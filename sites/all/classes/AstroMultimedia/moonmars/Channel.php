<?php
namespace AstroMultimedia\MoonMars;

use \AstroMultimedia\Drupal\Entity;

/**
 * Channel class - encapsulates a channel node.
 */
class Channel extends Node {

  /**
   * The node type.
   */
  const NODE_TYPE = 'channel';

  /**
   * The default page size for channels.
   */
  const pageSize = 10;

  /**
   * The parent entity of the channel.
   *
   * @var array
   */
  protected $parentEntity;

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Static methods that return Channels.

  /**
   * Get a channel given a channel title.
   *
   * @static
   * @param $channel_title
   * @return Channel
   */
  public static function createByTitle($channel_title) {
    $rec = db_select('node', 'n')
      ->fields('n', array('nid'))
      ->condition('title', $channel_title)
      ->condition('type', 'channel')
      ->execute()
      ->fetch();
    return $rec ? new self($rec->nid) : FALSE;
  }

  /**
   * Get/set the current channel.
   *
   * @static
   * @param null|Channel $channel
   * @return Channel
   */
  public static function currentChannel($channel = NULL) {
    if ($channel === NULL) {
      // Get the current channel:
      return (isset($_SESSION['current_channel_nid']) && $_SESSION['current_channel_nid']) ? self::create($_SESSION['current_channel_nid']) : NULL;
    }
    else {
      // Remember the current channel nid in the session:
      $_SESSION['current_channel_nid'] = $channel->nid();
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Parent entity-related methods.

  /**
   * Get the entity that a channel belongs to.
   *
   * @return array
   */
  public function parentEntity() {
    // Check if we remembered the result in the parentEntity property:
    if (!isset($this->parentEntity)) {
      // Search for the has_channel relationship:
      $rels = Relation::searchBinary('has_channel', NULL, $this);
      if (!empty($rels)) {
        $this->parentEntity = $rels[0]->endpoint(0);
      }
    }

    return $this->parentEntity;
  }

  /**
   * Get a link to a channel's entity's page.
   *
   * @return string
   *   Or FALSE if parent entity not found - should never happen.
   */
  public function parentEntityLink($brackets = FALSE) {
    $entity = $this->parentEntity();
    if (!$entity) {
      return FALSE;
    }

    $label = $brackets ? ('[' . $this->title() . ']') : $this->title();
    return l($label, $entity->alias());
  }

  /**
   * Get the parent entity's name or title.
   *
   * @return string
   *   Or FALSE if parent entity not found - should never happen.
   */
  public function parentEntityName() {
    $entity = $this->parentEntity();
    if (!$entity) {
      return FALSE;
    }

    // Member:
    if ($entity instanceof Member) {
      return $entity->name();
    }

    // Node:
    return $entity->title();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Alias and title methods.

  /**
   * Update the path alias for the channel.
   *
   * @return string
   */
  public function resetAlias() {
    // Get the parent entity:
    $parent_entity = $this->parentEntity();
    if (!$parent_entity) {
      return FALSE;
    }

    // Set the alias:
    $alias = $parent_entity->alias() . '/channel';
    $this->alias($alias);

    // Make sure pathauto doesn't clobber the new alias:
    $this->entity->path['pathauto'] = FALSE;

    return $alias;
  }

  /**
   * Reset the channel's title. Call this if the parent entity's title or name changes.
   *
   * @return Channel
   */
  public function resetTitle() {
    $entity = $this->parentEntity();
    $title = $entity ? $entity->channelTitle() : FALSE;
    if ($title) {
      $this->title($title);
    }
    return $this;
  }

  /**
   * Reset a channel's alias and title to match the parent entity.
   */
  public function resetAliasAndTitle() {
    $this->load();
    $this->resetAlias();
    $this->resetTitle();
    $this->save();
  }

  /**
   * Get a name for the channel that is meaningful to a notification recipient.
   *
   * @param Member $recipient
   * @param Member $poster
   * @return string
   */
  public function userFriendlyTitle(Member $recipient, Member $poster) {
    $parent_entity = $this->parentEntity();
    if ($parent_entity) {
      if ($parent_entity instanceof Member) {
        if (Member::equals($parent_entity, $recipient)) {
          $channel_name = 'your channel';
        }
        elseif (Member::equals($parent_entity, $poster)) {
          $channel_name = "their channel";
        }
        else {
          $channel_name = $parent_entity->name() . "'s channel";
        }
      }
      elseif ($parent_entity instanceof Group) {
        $channel_name = "the " . $parent_entity->title() . " group";
      }
    }
    return $channel_name;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Item-related methods.

  /**
   * Get the items in the channel.
   *
   * @param int $offset
   * @param int $limit
   * @param string $order_by_field
   * @param string $order_by_direction
   * @return array
   */
  public function items($offset = NULL, $limit = NULL, $order_by_field = 'changed', $order_by_direction = 'DESC') {
    // Look for relationship records:
    $q = db_select('view_channel_has_item', 'vci')
      ->fields('vci', array('item_nid'))
      ->condition('channel_nid', $this->nid())
      ->condition('item_status', 1);

    // Add LIMIT clause:
    if ($offset !== NULL && $limit !== NULL) {
      $q->range($offset, $limit);
    }

    // Add ORDER BY clause:
    $q->orderBy($order_by_field, $order_by_direction);

    // Get the items:
    $rs = $q->execute();
    $items = array();
    foreach ($rs as $rec) {
      $item = Item::create($rec->item_nid);
//      $item->load();
      $items[] = $item;
    }
    return $items;
  }

  /**
   * Checks if an item is in the channel.
   *
   * @param Item $item
   * @return bool
   */
  public function hasItem(Item $item) {
    return (bool) Relation::searchBinary('has_item', $this, $item);
  }

  /**
   * Add an item to a channel.
   *
   * @param Item $item
   *   The item being posted.
   * @return Relation
   *   The channel_has_item relationship.
   */
  public function addItem(Item $item) {

    // Check if the item is already in a channel:
    $rels = Relation::searchBinary('has_item', $this, $item);

    if ($rels) {
      $rel = $rels[0];

      // Check the item wasn't posted in a different channel; if so, it's an error:
      if (Entity::equals($rel->endpoint(0), $this)) {
        trigger_error("Channel::addItem() - Item has already been posted in another channel.", E_USER_WARNING);
        return FALSE;
      }

      // No need to add the item to the channel, as it's already there. Just bump it by loading and saving.
      $rel->load();
      return $rel->save();
    }
    else {
      // Create a new relationship:
      return Relation::createNewBinary('has_item', $this, $item);
    }
  }

  /**
   * Post or edit a comment, and notify the appropriate people.
   * @todo Refactor into Item::postNewComment() and ItemComment::update()
   *
   * @param ItemComment $comment
   * @parem bool $is_new
   */
  public function postComment(ItemComment $comment, $is_new) {
    // Get the current member (the poster or editor of the comment).
    $logged_in_member = Member::loggedInMember();
    $logged_in_member_link = $logged_in_member->link();

    // Get the original item and its poster:
    $item = $comment->item();
    $item_poster = $item->creator();

    // Get the original comment poster:
    $comment_poster = $comment->creator();

    // Get the item's channel:
    $channel = $item->channel();

    // Get the parent entity:
    $parent_entity = $channel->parentEntity();

    ////////////////////////////////////////////////
    // Bump the item:
    $item->bump();

    // For new comments, create the triumph:
    if ($is_new) {
      Triumph::newComment($comment);
    }

//    ////////////////////////////////////////////////
//    // Determine who needs to be notified.
//
//    $recipients = array();
//
//    // Do these in the same order as the notifications form.
//    // @see members_notifications_form().
//
//    // Site-wide preferences.
//    // Get all members who want to be notified about at least some of the new comments posted on the site.
//    $members = Nxn::mayWantNxnNew('site', 'comment');
//    Nxn::collectRecipients('site', 'new-comment', $comment, $members, $recipients);
//
//    // Channel preferences.
//    // If this is a member's channel, check if they want to be notified about new comments.
//    if ($parent_entity instanceof Member) {
//      Nxn::collectRecipients('channel', 'new-comment', $comment, $parent_entity, $recipients);
//    }
//
//    // Followee preferences.
//    // Get the followers of the poster and notify those who want to be notified about new comments.
//    Nxn::collectRecipients('followee', 'new-comment', $comment, $comment_poster->followers(), $recipients);
//
//    // Group preferences.
//    // If this is a group channel, get the members of the group and notify those who want to be notified about new comments.
//    if ($parent_entity instanceof Group) {
//      Nxn::collectRecipients('group', 'new-comment', $comment, $parent_entity->members(), $recipients);
//    }
//
////    // 1. If the comment is being posted in a member's channel, notify that member.
////    if ($parent_entity instanceof Member) {
////      $recipients[$parent_entity->uid()] = $parent_entity;
////    }
////
////    // 2. If an admin edited a member's comment, tell them.
////    $recipients[$comment_poster->uid()] = $comment_poster;
////
////    // 3. Tell the original poster of the item:
////    $recipients[$item_poster->uid()] = $item_poster;
////
////    // 3. Everyone subscribed to this channel:
////    $subscribers = $channel->subscribers();
////    foreach ($subscribers as $subscriber) {
////      $recipients[$subscriber->uid()] = $subscriber;
////    }
////
////    // 4. Everyone mentioned in the comment text.
////    $comment_mentions = moonmars_text_referenced_members($comment->text());
////    foreach ($comment_mentions as $member) {
////      $recipients[$member->uid()] = $member;
////    }
////
////    // 5. Everyone mentioned in the item text.
////    $item_mentions = moonmars_text_referenced_members($item->text());
////    foreach ($item_mentions as $member) {
////      $recipients[$member->uid()] = $member;
////    }
////
////    // 5. Everyone following a hash tag that appears in the item text. @todo
//
//    /////////////////////////////////////////////////////////////////////////////
//    // Create notifications.
//
//    // Get a link to the item and the comment:
//    $item_link = $item->link('item');
//    $comment_link = $comment->link('comment');
//
//    // Notify each recipient:
//    foreach ($recipients as $recipient_uid => $recipient) {
//
//      // No need to notify the current member:
//      if (Member::equals($recipient, $logged_in_member)) {
//        continue;
//      }
//
//      // Get a readable link to the channel:
//      if ($parent_entity instanceof Member) {
//        if (Member::equals($parent_entity, $recipient)) {
//          $channel_link = $recipient->link("your channel");
//        }
//        elseif (Member::equals($parent_entity, $logged_in_member)) {
//          $channel_link = $logged_in_member->link("their channel");
//        }
//        else {
//          $channel_link = $parent_entity->link($parent_entity->name() . "'s channel");
//        }
//      }
//      else {
//        $channel_link = $channel->parentEntityLink();
//      }
//
//      // Create a summary of the notification:
//      $summary = '';
//      if ($is_new) {
//        $summary .= "$logged_in_member_link posted a new $comment_link on an $item_link";
//        if (Member::equals($recipient, $item_poster)) {
//          $summary .= " you posted";
//        }
//        $summary .= " in $channel_link.";
//      }
//      else {
//        $summary .= "$logged_in_member_link edited a $comment_link";
//        if (Member::equals($recipient, $comment_poster)) {
//          $summary .= " you posted";
//        }
//        $summary .= " on an $item_link";
//        if (Member::equals($recipient, $item_poster)) {
//          $summary .= " you posted";
//        }
//        $summary .= " in $channel_link.";
//      }
//
//      // Add the mention part of the message:
//      $mentioned_in_item = array_key_exists($recipient_uid, $item_mentions);
//      $mentioned_in_comment = array_key_exists($recipient_uid, $comment_mentions);
//      if ($mentioned_in_item) {
//        $summary .= " You were mentioned in the $item_link";
//        if ($mentioned_in_comment) {
//          $summary . " and the $comment_link";
//        }
//        $summary .= ".";
//      }
//      elseif ($mentioned_in_comment) {
//        $summary .= " You were mentioned in the $comment_link.";
//      }
//
//      // Send the notification
//      $recipient->notify($summary, $comment->text(), $logged_in_member, $channel, $item, $comment);
//    }
  }

  /**
   * Get the total number of items in the channel.
   *
   * @return array
   */
  public function itemCount() {
    // Look for relationship records:
    $q = db_select('view_channel_has_item', 'vci')
      ->fields('vci', array('item_nid'))
      ->condition('channel_nid', $this->nid())
      ->condition('item_status', 1);

    // Get the items and return the count:
    $rs = $q->execute();
    return $rs->rowCount();
  }

  /**
   * Render a page of items, with pagination.
   *
   * @return string
   */
  public static function renderItemsPage($items, $total_n_items) {
    // Render the items:
    $items_html = Item::renderMultiple($items);

    // Render the pager:
    pager_default_initialize($total_n_items, self::pageSize);
    $pager_html = theme('pager', array('quantity' => $total_n_items));

    return "
      <div id='channel'>
        <div id='channel-items'>$items_html</div>
        <div id='channel-pager'>$pager_html</div>
      </div>";
  }

  /**
   * Render a channel's items.
   *
   * @return string
   */
  public function renderItems() {
    // Get the page number:
    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 0;

    // Get the items from this channel:
    $order_by_field = ($this->nid() == MOONMARS_NEWS_CHANNEL_NID) ? 'item_created' : 'changed';
    $items = $this->items($page * self::pageSize, self::pageSize, $order_by_field);

    // Get the total item count:
    $total_n_items = $this->itemCount();

    // Render the page of items:
    return self::renderItemsPage($items, $total_n_items);
  }

  /**
   * Return the links for this channel's entity.
   *
   * @return string
   */
  public function renderLinks() {
    $html = '';
    $entity = $this->parentEntity();

    // Social links:
    $social_links = '';
    $social_link_fields = moonmars_channels_social_links();
    foreach ($social_link_fields as $social_site => $info) {
      $link_field = $info['field'];
      $url = $this->field($link_field, LANGUAGE_NONE, 0, 'url');
      if ($url) {
        $title = "Visit " . (($entity instanceof Member) ? $entity->name() : $entity->title()) . "'s " . $info['description'];
        $title = htmlspecialchars($title, ENT_QUOTES);
        $social_links .= "<a class='social-link social-link-{$social_site}' href='$url' target='_blank' title='$title'></a>\n";
      }
    }

    // Skype link:
    if ($entity instanceof Member) {
      $skype_name = $entity->field('field_skype');
      if ($skype_name) {
        $title = htmlspecialchars("Chat with " . $entity->name() . " on Skype", ENT_QUOTES);
        $social_links .= "<a class='social-link social-link-skype' href='skype:$skype_name?chat' title='$title'></a>\n";
      }
    }

    if ($social_links) {
      $html .= "<div class='social-links clearfix'>\n$social_links\n</div>\n";
    }

    return $html;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // News

  /**
   * Check if this is the Site News channel.
   *
   * @return bool
   */
  public function isNewsChannel() {
    return $this->nid() == MOONMARS_NEWS_CHANNEL_NID;
  }

}
