<?php
/**
 * Channel class - encapsulates a channel node.
 */
class Channel extends Node {

  /**
   * The node type.
   */
  const nodeType = 'channel';

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
      ->execute()
      ->fetch();
    return $rec ? self::create($rec->nid) : FALSE;
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

      // Look up the entity_has_channel relationship:
      $rels = moonmars_relationships_get_relationships('has_channel', NULL, NULL, 'node', $this->nid());

      if (!empty($rels)) {
        $endpoint = $rels[0]->endpoint(LANGUAGE_NONE, 0);
        $this->parentEntity = MmcEntity::getEntity($endpoint['entity_type'], $endpoint['entity_id']);
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
   * @return Channel
   */
  public function setAlias() {
    // Get the parent entity:
    $parent_entity = $this->parentEntity();
    if (!$parent_entity) {
      return FALSE;
    }

    // Set the alias:
    $this->alias($parent_entity->alias() . '/channel');

    // Make sure pathauto doesn't clobber the new alias:
    $this->entity->path['pathauto'] = FALSE;

    return $this;
  }

  /**
   * Reset the channel's title. Call this if the parent entity's title or name changes.
   *
   * @return Channel
   */
  public function setTitle() {
    $entity = $this->parentEntity();
    $title = $entity ? $entity->channelTitle() : FALSE;
    if ($title) {
      $this->title($title);
    }
    return $this;
  }

  /**
   * Update a channel's alias and title to match the parent entity.
   */
  public function updateAliasAndTitle() {
    $this->load();
    $this->setAlias();
    $this->setTitle();
    $this->save();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Item-related methods.

  /**
   * Get the items in the channel.
   *
   * @param int $offset
   * @param int $limit
   * @return array
   */
  public function items($offset = NULL, $limit = NULL) {
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
    $q->orderBy('changed', 'DESC');

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
    return (bool) moonmars_relationships_get_relationships('has_item', 'node', $this->nid(), 'node', $item->nid());
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

    $this_channel_nid = $this->nid();
    $item_nid = $item->nid();

    // Check if the item is already in a channel:
    $rels = moonmars_relationships_get_relationships('has_item', 'node', $this_channel_nid, 'node', $item_nid);

    if ($rels) {
      $rel = $rels[0];

      // Check the item wasn't posted in a different channel; if so, it's an error:
      $item_channel_nid = $rel->entityId(LANGUAGE_NONE, 0);
      if ($item_channel_nid != $this_channel_nid) {
        trigger_error("Item has already been posted in another channel.", E_USER_WARNING);
        return FALSE;
      }

      // No need to add the item to the channel, as it's already there. Just bump it by loading and saving.
      $rel->load();
      return $rel->save();
    }
    else {
      // Create a new relationship without saving:
      return Relation::createNewBinary('has_item', 'node', $this_channel_nid, 'node', $item_nid, TRUE);
    }
  }

  /**
   * Update a channel-item relationship's changed field so it appears at the top of the channel.
   *
   * @param Item $item
   * @return int
   */
  public function bumpItem(Item $item) {
    $channel_nid = $this->nid();
    $rels = moonmars_relationships_get_relationships('has_item', 'node', $channel_nid, 'node', $item->nid());
    if ($rels) {
      $rels[0]->load();
      $rels[0]->save();
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Post or edit an item.
   * Copy the update to all relevant channels and send notifications.
   *
   * @param object $item
   *   The item or comment being posted or edited.
   * @param bool $is_new
   *   TRUE if the post is new, FALSE if editing an existing post.
   */
  public function postItem($item, $is_new) {
    // Get the current item/comment poster:
    global $user;
    $poster_uid = $user->uid;
    $poster = Member::create($poster_uid);
    $poster_link = $poster->link();

    // Check what we got:
    if ($item instanceof Item) {
      $item = $item;
      $is_comment = FALSE;
    }
    elseif ($item instanceof ItemComment) {
      $comment = $item;
      $item = $comment->item();
      $is_comment = TRUE;
    }
    else {
      trigger_error("Invalid parameter to Channel::postItem()", E_USER_WARNING);
    }

    // Get the original item poster:
    $item_poster = $item->creator();
    $item_poster_link = $item_poster->link();

    /////////////////////////////////////////////////////////////////////////////
    // Step 1. Add or bump the item.
    $this->addItem($item);

    /////////////////////////////////////////////////////////////////////////////
    // Step 2. Notify members connected with this post.

    $recipients = array();

    // Get a description/link of the channel:
    $parent_entity = $this->parentEntity();
    if ($parent_entity instanceof Member) {
      if (Member::equals($poster, $parent_entity)) {
        $channel_link = "their channel";
      }
      else {
        $channel_link = $parent_entity->link() . "'s channel";
      }
    }
    else {
      $channel_link = "the " . $parent_entity->link($parent_entity->title() . ' ' . $parent_entity->type()) . "'s channel";
    }

    // a) If the item is being posted in a member's channel, notify that member.
    if ($parent_entity instanceof Member && !Member::equals($parent_entity, $poster)) {
      $parent_entity->notify("$poster posted an item in your channel", $channel);
      $recipients[$parent_entity->uid()] = $parent_entity;
//      $recipients[$parent_entity->uid()]['member'] = $parent_entity;
//      $recipients[$parent_entity->uid()]['reasons'][] = "It's your channel.";
    }

    // b) Everyone following the channel where the person posted.
    $subscribers = $channel->subscribers();
    foreach ($subscribers as $subscriber) {
      $subscriber->notify("$poster posted an item in the " . $channel->link() . " channel.", $channel);
      $recipients[$subscriber->uid()] = $subscriber;
//      $recipients[$follower->uid()]['member'] = $follower;
//      $recipients[$follower->uid()]['reasons'][] = "You follow $poster_link.";
    }


    // c) Everyone mentioned in the item text.
    $referenced_members = moonmars_text_referenced_members($item->text());
    foreach ($referenced_members as $member) {
      $subscriber->notify("$poster mentioned you in an item in the " . $channel->link() . " channel.", $channel);
      $recipients[$subscriber->uid()] = $subscriber;

      $recipients[$member->uid()]['member'] = $member;
      $recipients[$member->uid()]['reasons'][] = "You're mentioned in the " . ($is_comment ? 'comment' : 'item') . ".";
    }

    // g) Everyone following a hash tag that appears in the item text. @todo

    /////////////////////////////////////////////////////////////////////////////
    // Step 3. Copy/bump the item in all the channels of all relevant subscribers:
    foreach ($recipients as $recipient_uid => $recipient_info) {
      $recipient = $recipient_info['member'];

      // Send notifications to everyone who isn't the poster:
      if ($recipient_uid != $poster_uid) {

        // Check if the recipient's channel equals the original channel:
        $channel_link2 = Member::equals($parent_entity, $recipient) ? "your channel" : $channel_link;

        if ($is_comment) {
          // New comment posted or existing comment edited:
          $action = $is_new ? "commented" : "edited their comment";
          if (Member::equals($recipient, $item_poster)) {
            $posted_by = "you posted";
          }
          elseif (Member::equals($poster, $item_poster)) {
            $posted_by = "they posted";
          }
          else {
            $posted_by = "posted by $item_poster_link";
          }
          $summary = "$poster_link $action on an item $posted_by in $channel_link2.\n";
//          $text = "Comment text: <strong>" . moonmars_text_filter($comment->text()) . "</strong>";
        }
        else {
          // New item posted or existing item edited:
          $action = $is_new ? "posted a new" : "edited an";
          $summary = "$poster_link $action item in $channel_link2.\n";
//          $text = "Item text: <strong>" . moonmars_text_filter($item->text()) . "</strong>";
        }

        // Set the subject:
        $subject = strip_tags($summary);

        // Start the HTML message:
        $message = "<p><strong>$summary</strong></p>\n";

        // Reasons:
        $message .= "<p>You're receiving this notification because:\n";
        $message .= "<ul>\n";
        foreach ($recipient_info['reasons'] as $reason) {
          $message .= "<li>$reason</li>\n";
        }
        $message .= "</ul>\n";

        // Text:
//        $message .= "<p>$text</p>";

        // Item link:
        $message .= "<p>" . $item->link("Read or post comments") . "</p>\n";

        // Comment by email instructions:
//        $can_post_comment = $recipient->canPostComment($item);
//        if ($can_post_comment) {
//          $message .= "<hr>\n";
//          $message .= "<p>Scroll down to the bottom of this message to post a new comment by email.</p>";
//        }

        // The item with comments:
        $message .= "<hr>\n";
        $_SESSION['email_mode'] = 1;
        $message .= $item->render(TRUE);
        unset($_SESSION['email_mode']);

//        // Comment by email:
//        if ($can_post_comment) {
//          $message .= "<hr>\n";
//          $message .= "<p>To post a comment by email, enter your comment between the tags below, and click <em>Reply</em> in your email client:</p>\n";
//          $message .= "[BEGIN COMMENT]<br>";
//          $message .= "<br><br><br>";
//          $message .= "[END COMMENT]<br>";
//        }

        // Send the notification
        $recipient->notify($subject, $message);
      }
    }
  }


  /**
   * Post or edit an item or comment.
   * Copy the update to all relevant channels and send notifications.
   *
   * @param object $post
   *   The item or comment being posted or edited.
   * @param bool $is_new
   *   TRUE if the post is new, FALSE if editing an existing post.
   */
  public function post($post, $is_new) {
    // Get the current item/comment poster:
    global $user;
    $poster_uid = $user->uid;
    $poster = Member::create($poster_uid);
    $poster_link = $poster->link();

    // Check what we got:
    if ($post instanceof Item) {
      $item = $post;
      $is_comment = FALSE;
    }
    elseif ($post instanceof ItemComment) {
      $comment = $post;
      $item = $comment->item();
      $is_comment = TRUE;
    }
    else {
      trigger_error("Invalid parameter to Channel::postItem()", E_USER_WARNING);
    }

    // Get the original item poster:
    $item_poster = $item->creator();
    $item_poster_link = $item_poster->link();

    /////////////////////////////////////////////////////////////////////////////
    // Step 1. Add or bump the item.
    $this->addItem($item);

    // Get a description/link of the channel, for the notification:
    $parent_entity = $this->parentEntity();
    if ($parent_entity instanceof Member) {
      if (Member::equals($poster, $parent_entity)) {
        $channel_link = "their channel";
      }
      else {
        $channel_link = $parent_entity->link() . "'s channel";
      }
    }
    else {
      $channel_link = "the " . $parent_entity->link($parent_entity->title() . ' ' . $parent_entity->type()) . "'s channel";
    }

    /////////////////////////////////////////////////////////////////////////////
    // Step 2. Notify members connected with this post.

    $recipients = array();

    // a) If the item is being posted in a member's channel, that member.
    if ($parent_entity instanceof Member && !Member::equals($parent_entity, $poster)) {
      $parent_entity->notify();

      $recipients[$parent_entity->uid()]['member'] = $parent_entity;
      $recipients[$parent_entity->uid()]['reasons'][] = "It's your channel.";
    }

    // c) If the item is being posted in a group, all members of the group.
    if ($parent_entity instanceof Group) {
      $members = $parent_entity->members();
      foreach ($members as $member) {
        $recipients[$member->uid()]['member'] = $member;
        $recipients[$member->uid()]['reasons'][] = "You're a member of the " . $parent_entity->link() . " group.";
      }
    }

    // d) Everyone following the person who posted, edited or commented.
    $followers = $poster->followers();
    foreach ($followers as $follower) {
      $recipients[$follower->uid()]['member'] = $follower;
      $recipients[$follower->uid()]['reasons'][] = "You follow $poster_link.";
    }

    // e) Everyone following the original poster (if different to the current poster).
    if (!Member::equals($item_poster, $poster)) {
      $followers = $item_poster->followers();
      foreach ($followers as $follower) {
        if (!array_key_exists($recipients, $follower->uid())) {
          $recipients[$follower->uid()]['member'] = $follower;
          $recipients[$follower->uid()]['reasons'][] = "You follow $item_poster_link.";
        }
      }
    }

    // f) Everyone mentioned in the item text.
    $referenced_members = moonmars_text_referenced_members($item->text());
    foreach ($referenced_members as $member) {
      $recipients[$member->uid()]['member'] = $member;
      $recipients[$member->uid()]['reasons'][] = "You're mentioned in the " . ($is_comment ? 'comment' : 'item') . ".";
    }

    // g) Everyone following a hash tag that appears in the item text. @todo

    /////////////////////////////////////////////////////////////////////////////
    // Step 3. Copy/bump the item in all the channels of all relevant subscribers:
    foreach ($recipients as $recipient_uid => $recipient_info) {
      $recipient = $recipient_info['member'];

      // Send notifications to everyone who isn't the poster:
      if ($recipient_uid != $poster_uid) {

        // Check if the recipient's channel equals the original channel:
        $channel_link2 = Member::equals($parent_entity, $recipient) ? "your channel" : $channel_link;

        if ($is_comment) {
          // New comment posted or existing comment edited:
          $action = $is_new ? "commented" : "edited their comment";
          if (Member::equals($recipient, $item_poster)) {
            $posted_by = "you posted";
          }
          elseif (Member::equals($poster, $item_poster)) {
            $posted_by = "they posted";
          }
          else {
            $posted_by = "posted by $item_poster_link";
          }
          $summary = "$poster_link $action on an item $posted_by in $channel_link2.\n";
//          $text = "Comment text: <strong>" . moonmars_text_filter($comment->text()) . "</strong>";
        }
        else {
          // New item posted or existing item edited:
          $action = $is_new ? "posted a new" : "edited an";
          $summary = "$poster_link $action item in $channel_link2.\n";
//          $text = "Item text: <strong>" . moonmars_text_filter($item->text()) . "</strong>";
        }

        // Set the subject:
        $subject = strip_tags($summary);

        // Start the HTML message:
        $message = "<p><strong>$summary</strong></p>\n";

        // Reasons:
        $message .= "<p>You're receiving this notification because:\n";
        $message .= "<ul>\n";
        foreach ($recipient_info['reasons'] as $reason) {
          $message .= "<li>$reason</li>\n";
        }
        $message .= "</ul>\n";

        // Text:
//        $message .= "<p>$text</p>";

        // Item link:
        $message .= "<p>" . $item->link("Read or post comments") . "</p>\n";

        // Comment by email instructions:
//        $can_post_comment = $recipient->canPostComment($item);
//        if ($can_post_comment) {
//          $message .= "<hr>\n";
//          $message .= "<p>Scroll down to the bottom of this message to post a new comment by email.</p>";
//        }

        // The item with comments:
        $message .= "<hr>\n";
        $_SESSION['email_mode'] = 1;
        $message .= $item->render(TRUE);
        unset($_SESSION['email_mode']);

//        // Comment by email:
//        if ($can_post_comment) {
//          $message .= "<hr>\n";
//          $message .= "<p>To post a comment by email, enter your comment between the tags below, and click <em>Reply</em> in your email client:</p>\n";
//          $message .= "[BEGIN COMMENT]<br>";
//          $message .= "<br><br><br>";
//          $message .= "[END COMMENT]<br>";
//        }

        // Send the notification
        $recipient->notify($subject, $message);
      }
    }
  }

//  /**
//   * Post a system message to the channel.
//   *
//   * @param $message
//   * @return Channel
//   */
//  public function postSystemMessage($message) {
//    $item = Item::createSystemMessage($message);
//    $this->post($item, TRUE, TRUE);
//    return $this;
//  }

  /**
   * Get the total number of items in the channel.
   *
   * @return array
   */
  public function itemCount() {
    // Look for relationship records:
    $q = db_select('view_channel_has_item', 'vci')
      ->fields('vci', array('item_nid'))
      ->condition('channel_nid', $this->nid());

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
    $items = $this->items($page * self::pageSize, self::pageSize);

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

    // Official website:
    $url = $this->field('field_website', LANGUAGE_NONE, 0, 'url');
    if ($url) {
      $title = htmlspecialchars("Visit " . (($entity instanceof Member) ? ($entity->name() . "'s official website") : ("the official website of " . $entity->title())), ENT_QUOTES);
      $html .= "
        <p class='official-website'>
          Official website:<br>
          <a href='$url' target='_blank' title='$title' class='autotrim'>" . rtrim(trimhttp($url), '/') . "</a>
        </p>\n";
    }

    // Social links:
    $social_links = '';

    $social_sites = array(
      'facebook'  => 'facebook',
      'twitter'   => 'twitter',
      'linkedin'  => 'LinkedIn',
      'google'    => 'Google+',
      'youtube'   => 'YouTube',
      'wikipedia' => 'Wikipedia'
    );

    foreach ($social_sites as $social_site => $social_site_name) {
      $field = "field_{$social_site}_link";
      $url = $this->field($field, LANGUAGE_NONE, 0, 'url');
      if ($url) {
        $title = htmlspecialchars("Visit " . (($entity instanceof Member) ? ($entity->name() . "'s") : ("the " . $entity->title())) . " $social_site_name page", ENT_QUOTES);
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
  // Subscriber methods.

  /**
   * Check if a member is a subscriber to the channel.
   *
   * @param Member $member
   * @return bool
   */
  public function hasSubscriber(Member $member) {
    $rels = moonmars_relationships_get_relationships('has_subscriber', 'node', $this->nid(), 'user', $member->uid());
    return (bool) $rels;
  }

  /**
   * Get subscriber relationship.
   *
   * @param Member $member
   * @return array
   *   or FALSE if the relationship doesn't exist.
   */
  public function getSubscriberRelationship(Member $member) {
    $rels = moonmars_relationships_get_relationships('has_subscriber', 'node', $this->nid(), 'user', $member->uid());
    if ($rels) {
      return Relation::create($rels[0]->rid());
    }
    return FALSE;
  }

}
