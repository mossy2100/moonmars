<?php
/**
 * Channel class - encapsulates a channel node.
 */
class Channel extends Node {

  /**
   * Cache the channel-entity relationships so we don't have to look up the database every time.
   *
   * @var array
   */
  protected static $entityCache;

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  /**
   * Create a new Channel object.
   *
   * @param int $nid
   * @return Channel
   */
  public static function create($nid = NULL) {
    return parent::create(__CLASS__, $nid);
  }

  /**
   * Get the entity that a channel belongs to.
   *
   * @return array
   */
  public function parentEntity() {
    $channel_nid = $this->nid();

    // If we haven't already loaded this one, do it now:
    if (!isset(self::$entityCache[$channel_nid])) {
      $rels = moonmars_relationships_get_relationships('has_channel', NULL, NULL, 'node', $channel_nid);
      if (empty($rels)) {
        return FALSE;
      }

      // Store the result in the cache:
      self::$entityCache[$channel_nid] = array(
        'entity_type' => $rels[0]->entity_type0,
        'entity_id' => $rels[0]->entity_id0,
        'alias' => drupal_get_path_alias($rels[0]->entity_type0 . '/' . $rels[0]->entity_id0)
      );
    }

    return self::$entityCache[$channel_nid];
  }

  /**
   * Creates a new channel for an entity.
   *
   * @param string $entity_type
   * @param int $entity_id
   * @return int
   */
  public static function createEntityChannel($entity_type, $entity_id) {
    // Load the entity
    $entity = entity_load_single($entity_type, $entity_id);

    // Determine the title and path alias for the channel:
    switch ($entity_type) {
      case 'node':
        $title = ucfirst($entity->type) . ': ' . $entity->title;
        break;

      case 'user':
        $title = 'Member: ' . $entity->name;
        break;
    }

    // Create the new node:
    $alias = drupal_get_path_alias("$entity_type/$entity_id") . '/channel';
    $channel_node = node_create('channel', $title, TRUE, $alias);

    // Set the channel uid to match the node or user entity:
    $channel_node->uid = $entity->uid;

    // Save the node for the first time, which will give it a nid:
    node_save($channel_node);

    // Create the relationship between the entity and the relationship:
    moonmars_relationships_create_relationship('has_channel', $entity_type, $entity_id, 'node', $channel_node->nid, TRUE);

    return self::create($channel_node->nid);
  }

  /**
   * Get an entity's channel.
   *
   * @param string $entity_type
   * @param int $entity_id
   * @param bool $create
   * @return int
   */
  public static function entityChannel($entity_type, $entity_id, $create = TRUE) {
    // Check if the entity already has a channel:
    $rels = moonmars_relationships_get_relationships('has_channel', $entity_type, $entity_id, 'node', NULL);

    if (!empty($rels)) {
      return self::create($rels[0]->entity_id1);
    }

    // If the entity has no channel, and $create is TRUE, create the channel now:
    if ($create) {
      return self::createEntityChannel($entity_type, $entity_id);
    }

    return FALSE;
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
   * Get a link to a channel's entity's page.
   *
   * @return string
   */
  public function entityLink() {
    $entity = $this->parentEntity();
    return l($this->title(), $entity['alias']);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Posting and updating items in channels.

  /**
   * Add an item to a channel.
   *
   * @param Item $item
   *   The item being posted.
   * @return int
   */
  public function addItem(Item $item) {
    $channel_nid = $this->nid();
    $item_nid = $item->nid();

    // Check if the item is already in the specified channel:
    $rels = moonmars_relationships_get_relationships('has_item', 'node', $channel_nid, 'node', $item_nid);

    if ($rels) {
      // No need to add the item to the channel, as it's already there. Just bump it by loading and saving.
      $rel = relation_load($rels[0]->rid);
    }
    else {
      // Create a new relationship without saving:
      $rel = moonmars_relationships_create_relationship('has_item', 'node', $channel_nid, 'node', $item_nid, FALSE);

      // Get the item's original channel:
      $original_channel = $item->originalChannel();
      $original_channel_nid = $original_channel ? $original_channel->nid() : FALSE;

      // Set the copied flag:
      $rel->field_copied[LANGUAGE_NONE][0]['value'] = (int) ($original_channel_nid && $channel_nid != $original_channel_nid);
    }

    // Save the relationship:
    return relation_save($rel);
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
      $rel = relation_load($rels[0]->rid);
      return relation_save($rel);
    }
    return FALSE;
  }

  /**
   * Post or edit an item or comment.
   * Copy the update to all relevant channels and send notifications.
   *
   * @param Item $item
   *   The item being posted, edited or commented on.
   * @param bool $is_new
   *   TRUE if the post is new, FALSE if editing an existing post.
   * @param bool $is_comment
   *   TRUE if the post is a comment, FALSE if an item.
   */
  public function postItem(Item $item, $is_new, $is_comment) {
    $item_nid = $item->nid();

    // Current poster:
    global $user;
    $poster_uid = $user->uid;
    $poster = Member::create($poster_uid);

    /////////////////////////////////////////////////////////////////////////////
    // Step 1. Add or bump the item in the current channel.
    $current_channel_nid = $this->nid();
    $this->addItem($item);

    /////////////////////////////////////////////////////////////////////////////
    // Step 2. Bump the item in the channel where it was originally posted, if different.
    if ($is_new && !$is_comment) {
      // New item. The current channel will be the original channel. No need to bump.
      $original_channel_nid = $current_channel_nid;
    }
    else{
      $original_channel = $item->originalChannel();
      $original_channel_nid = $original_channel->nid();
      if ($original_channel_nid != $current_channel_nid) {
        $original_channel->bumpItem($item);
      }
    }

    /////////////////////////////////////////////////////////////////////////////
    // Step 3. Find out which members should see this item in their channel:
    $subscribers = array();

    // a) The current user, i.e. the posting member.
    $subscribers[$poster_uid] = $poster;

    // b) Everyone following the person who edited the item.
    $followers = $poster->followers();
    foreach ($followers as $follower) {
      $subscribers[$follower->uid()] = $follower;
    }

    // c) Everyone following the original poster (if different).
    $original_poster = $item->creator();
    if ($original_poster->uid() != $poster_uid) {
      $followers = $original_poster->followers();
      foreach ($followers as $follower) {
        $subscribers[$follower->uid()] = $follower;
      }
    }

    // d) If the item is being posted in a group, all members of the group:
    $entity = $this->entity();
    if ($entity['entity_type'] == 'node') {
      $group = Group::create($entity['entity_id']);
      if ($group->type() == 'group') {
        $members = $group->members();
        foreach ($members as $member) {
          $subscribers[$member->uid()] = $member;
        }
      }
    }

    // f) Everyone mentioned in the item text. @todo
    // g) Everyone following a tag that appears in the item text. @todo

    /////////////////////////////////////////////////////////////////////////////
    // Step 4. Copy/bump the item in all the channels of all relevant subscribers:
    foreach ($subscribers as $subscriber) {
      // Copy/bump the item:
      $subscriber->channel()->addItem($item);

      // Send notifications to everyone who isn't the poster:
      if ($subscriber->uid() != $poster_uid) {
        $current_channel_link = $this->entityLink();
        if (!$is_comment) {
          // New item posted or existing item edited:
          $action = $is_new ? "posted a new item" : "edited an item";
          $message = $poster->link() . " $action in $current_channel_link.";
        }
        else {
          // New comment posted or existing comment edited:
          $poster = ($subscriber->uid() == $original_poster->uid()) ? 'you' : $original_poster->link();
          $action = $is_new ? "commented on an item" : "edited their comment on an item";
          $message = $poster->link() . " $action posted by $poster in $current_channel_link.";
        }
        // Send the notification
        $subscriber->notify($message);
      }
    }
  }

  /**
   * Get/set the current channel.
   *
   * @static
   * @return Channel
   */
  public static function currentChannel($channel_nid = NULL) {
    if (func_num_args() == 0) {
      // Get the current channel:
      return Channel::create($_SESSION['current_channel_nid']);
    }
    else {
      // Set the current channel:
      $_SESSION['current_channel_nid'] = $channel_nid;
    }
  }

  /**
   * Determine if a member can post in the channel.
   *
   * @param Member $member
   * @return bool
   */
  public function canPost(Member $member) {
    // Can only post in channels when the channel is embedded in an entity page:
    if (!moonmars_channels_is_embedded_channel_page()) {
      return FALSE;
    }

    // Get the channel's parent entity:
    $entity = $this->parentEntity();

    if ($entity['entity_type'] == 'user') {
      // For now, we are going to allow anyone to post in anyone's channel:
      return TRUE; // $entity['entity_id'] == $uid;
    }
    else {
      // $entity_type == 'node'
      $node = node_load($entity['entity_id']);
      if ($node->type == 'group') {
        $group = Group::create($entity['entity_id']);
        return $group->isMember($member);
      }
    }
    return FALSE;
  }

  /**
   * Get the items in the channel.
   *
   * @param bool $include_copied_items
   * @param int $offset
   * @param int $limit
   * @return array
   */
  public function items($include_copied_items = TRUE, $offset = NULL, $limit = NULL) {
    // Look for relationship records:
    $q = db_select('view_channel_has_item', 'vci')
      ->fields('vci', array('item_nid', 'copied'))
      ->condition('channel_nid', $this->nid());

    // Add condition if we want to exclude copied items:
    if (!$include_copied_items) {
      $q->condition(db_or()->condition('copied', 0)->condition('copied'));
    }

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
      $item->load();

      // If the item was copied, get some info about this:
      $item->prop('copied', (bool) $rec->copied);
      if ($rec->copied) {
        $item->prop('original_channel', $item->originalChannel());
      }

      $items[] = $item;
    }
    return $items;
  }

  /**
   * Render a channel.
   *
   * @param bool $include_copied_items
   * @return string
   */
  public function render($include_copied_items = TRUE) {
    // Get the page number:
    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 0;
    $page_size = 10;

    // Get the items from this channel:
    $items = $this->items($include_copied_items, $page * $page_size, $page_size);

    // Render the items:
    $node_views = array();
    foreach ($items as $item) {
      $node = $item->node();
      $node_view = node_view($node);
      $node_view['comments'] = comment_node_page_additions($node);
      $node_views[] = $node_view;
    }
    return "<div id='channel-items'>" . render($node_views) . "</div>";
  }

}
