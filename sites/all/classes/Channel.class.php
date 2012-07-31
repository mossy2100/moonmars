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
   * Add a subscriber to an array for notification.
   *
   * @param array $subscribers
   * @param Member $member
   */
  protected static function collectSubscriber(array &$subscribers, Member $member) {
    $subscribers[$member->uid()] = $member;
  }

  /**
   * Post or edit an item, and notify the appropriate people.
   *
   * @param Item $item
   */
  public function postItem($item) {
    // Get the current member (the poster or editor of the item).
    $current_member = Member::currentMember();
    $current_member_link = $current_member->link();

    // Get the original item poster:
    $item_poster = $item->creator();

    // Get the item's channel:
    $channel = $item->channel();

    // Get the parent entity:
    $parent_entity = $channel->parentEntity();

    ////////////////////////////////////////////////
    // Add or bump the item.

    // If the item already has a channel...
    $is_new = !$channel;
    if ($is_new) {
      // It's a new item, so add it to the channel:
      $this->addItem($item);
    }
    else {
      // It's been edited, so bump it:
      $channel->bumpItem($item);
    }

    ////////////////////////////////////////////////
    // Determine who needs to be notified.

    $recipients = array();

    // 1. If the item is being posted in a member's channel (other than the poster's own channel), notify that member.
    if ($parent_entity instanceof Member && !Member::equals($parent_entity, $current_member)) {
      $recipients[$parent_entity->uid()] = $parent_entity;
    }

    // 2. If an admin edited a member's item, tell them.
    if (!Member::equals($current_member, $item_poster)) {
      $recipients[$item_poster->uid()] = $item_poster;
    }

    // 3. Everyone subscribed to this channel:
    $subscribers = $channel->subscribers();
    foreach ($subscribers as $subscriber) {
      if (!Member::equals($subscriber, $current_member) && !in_array($subscriber, $recipients)) {
        $recipients[$subscriber->uid()] = $subscriber;
      }
    }

    // 4. Everyone mentioned in the item text.
    $referenced_members = moonmars_text_referenced_members($item->text());
    foreach ($referenced_members as $member) {
      $recipients[$member->uid()] = $member;
    }

    // 5. Everyone following a hash tag that appears in the item text. @todo

    /////////////////////////////////////////////////////////////////////////////
    // Create notifications.

    // Get a link to the item:
    $item_link = $item->link("item");

    // Notify each recipient:
    foreach ($recipients as $recipient_uid => $recipient) {

      // Get a readable link to the channel:
      if ($parent_entity instanceof Member) {
        if (Member::equals($parent_entity, $recipient)) {
          $channel_link = $recipient->link("your channel");
        }
        elseif (Member::equals($parent_entity, $current_member)) {
          $channel_link = $current_member->link("their channel");
        }
        else {
          $channel_link = $parent_entity->link($parent_entity->name() . "'s channel");
        }
      }
      else {
        $channel_link = $channel->parentEntityLink();
      }

      // Create a summary of the notification:
      if ($is_new) {
        $message = "$current_member_link posted a new $item_link in $channel_link.";
      }
      else {
        $message = "$current_member_link edited an $item_link";
        if (Member::equals($recipient, $item_poster)) {
          $message .= " you posted";
        }
        $message .= " in $channel_link.";
      }

      // Add the mention part of the message:
      if (array_key_exists($recipient_uid, $referenced_members)) {
        $message .= " You were mentioned in the $item_link.";
      }

      // Send the notification
      $recipient->notify($message, $current_member, $channel, $item);
    }
  }

  /**
   * Post or edit a comment, and notify the appropriate people.
   *
   * @param ItemComment $comment
   * @parem bool $is_new
   */
  public function postComment(ItemComment $comment, $is_new) {
    // Get the current member (the poster or editor of the comment).
    $current_member = Member::currentMember();
    $current_member_link = $current_member->link();

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
    $channel->bumpItem($item);

    ////////////////////////////////////////////////
    // Determine who needs to be notified.

    $recipients = array();

    // 1. If the comment is being posted in a member's channel (other than the poster's own channel), notify that member.
    if ($parent_entity instanceof Member && !Member::equals($parent_entity, $current_member)) {
      $recipients[$parent_entity->uid()] = $parent_entity;
    }

    // 2. If an admin edited a member's comment, tell them.
    if (!Member::equals($current_member, $comment_poster)) {
      $recipients[$comment_poster->uid()] = $comment_poster;
    }

    // 3. Everyone subscribed to this channel:
    $subscribers = $channel->subscribers();
    foreach ($subscribers as $subscriber) {
      if (!Member::equals($subscriber, $current_member) && !in_array($subscriber, $recipients)) {
        $recipients[$subscriber->uid()] = $subscriber;
      }
    }

    // 4. Everyone mentioned in the comment text.
    $referenced_members = moonmars_text_referenced_members($comment->text());
    foreach ($referenced_members as $member) {
      $recipients[$member->uid()] = $member;
    }

    // 5. Everyone following a hash tag that appears in the item text. @todo

    /////////////////////////////////////////////////////////////////////////////
    // Create notifications.

    // Get a link to the item and the comment:
    $item_link = $item->link('item');
    $comment_link = $comment->link('comment');

    // Notify each recipient:
    foreach ($recipients as $recipient_uid => $recipient) {

      // Get a readable link to the channel:
      if ($parent_entity instanceof Member) {
        if (Member::equals($parent_entity, $recipient)) {
          $channel_link = $recipient->link("your channel");
        }
        elseif (Member::equals($parent_entity, $current_member)) {
          $channel_link = $current_member->link("their channel");
        }
        else {
          $channel_link = $parent_entity->link($parent_entity->name() . "'s channel");
        }
      }
      else {
        $channel_link = $channel->parentEntityLink();
      }

      // Create a summary of the notification:
      if ($is_new) {
        $message = "$current_member_link posted a new $comment_link on an $item_link";
        if (Member::equals($recipient, $item_poster)) {
          $message .= " you posted";
        }
        $member .= " in $channel_link.";
      }
      else {
        $message = "$current_member_link edited a $comment_link";
        if (Member::equals($recipient, $comment_poster)) {
          $message .= " you posted";
        }
        $message .= " on an $item_link";
        if (Member::equals($recipient, $item_poster)) {
          $message .= " you posted";
        }
        $message .= " in $channel_link.";
      }

      // Add the mention part of the message:
      if (array_key_exists($recipient_uid, $referenced_members)) {
        $message .= " You were mentioned in the $comment_link.";
      }

      // Send the notification
      $recipient->notify($message, $current_member, $channel, $item, $comment);
    }
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
   * Get the subscribers to the channel.
   *
   * @param int $offset
   * @param int $limit
   * @return array
   */
  public function subscribers($offset = NULL, $limit = NULL) {
    // Get the channel's subscribers in reverse order of that in which they subscribed.
    $q = db_select('view_channel_has_subscriber', 'v')
      ->fields('v', array('subscriber_uid'))
      ->condition('channel_nid', $this->nid())
      ->orderBy('created', 'DESC');

    // Set a limit if specified:
    if ($offset !== NULL && $limit !== NULL) {
      $q->range($offset, $limit);
    }

    $rs = $q->execute();
    $subscribers = array();
    foreach ($rs as $rec) {
      $subscribers[] = Member::create($rec->subscriber_uid);
    }

    return $subscribers;
  }

  /**
   * Get the number of subscribers in a channel.
   *
   * @return int
   */
  public function subscriberCount() {
    $q = db_select('view_channel_has_subscriber', 'v')
      ->fields('v', array('rid'))
      ->condition('channel_nid', $this->nid());
    $rs = $q->execute();
    return $rs->rowCount();
  }

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
