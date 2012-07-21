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
    return $rec ? Channel::create($rec->nid) : FALSE;
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
      return (isset($_SESSION['current_channel_nid']) && $_SESSION['current_channel_nid']) ? Channel::create($_SESSION['current_channel_nid']) : NULL;
    }
    else {
      // Remember the current channel nid in the session:
      $_SESSION['current_channel_nid'] = $channel->nid();
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Entity-related methods.

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
        if ($rels[0]->entity_type0 == 'user') {
          return Member::create($rels[0]->entity_id0);
        }

        // $rels[0]->entity_type0 == 'node'
        $node = node_load($rels[0]->entity_id0);
        switch ($node->type) {
          case 'group':
            return Group::create($node);

          case 'event':
            return Event::create($node);

          case 'project':
            return Project::create($node);
        }
      }
    }

    return $this->parentEntity;
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

    // Determine the title and path alias for the channel.
    // (This could probably better be done when the channel is saved, i.e. in moonmars_channels_node_presave())
    switch ($entity_type) {
      case 'node':
        $title = ucfirst($entity->type) . ': ' . $entity->title;
        break;

      case 'user':
        $title = 'Member: ' . $entity->name;
        break;
    }

    // Create the new channel:
    $channel = Channel::create()
      ->setProperties(array(
        'uid' => $entity->uid,
        'title' => $title,
      ));

    // Save the node for the first time, which will give it a nid:
    $channel->save();

    // Create the relationship between the entity and the relationship:
    moonmars_relationships_create_relationship('has_channel', $entity_type, $entity_id, 'node', $channel->nid(), TRUE);

    // Update the alias for the channel:
    $channel->setAlias();

    // Return the Channel:
    return $channel;
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

    return NULL;
  }

  /**
   * Get a link to a channel's entity's page.
   *
   * @return string
   *   Or FALSE if parent entity not found - should never happen.
   */
  public function parentEntityLink($brackets = FALSE) {
    $entity = $this->parentEntity();
    if ($entity) {
      $label = $brackets ? ('[' . $this->title() . ']') : $this->title();
      return l($label, $entity->alias());
    }
    return FALSE;
  }

  /**
   * Update the path alias for the channel.
   *
   * @return Channel
   */
  public function setAlias() {
    $parent_entity = $this->parentEntity();
    if ($parent_entity) {
      $this->alias($parent_entity->alias() . '/channel');
    }
    return $this;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Item-related methods.

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
      ->condition('channel_nid', $this->nid())
      ->condition('item_status', 1);

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
   * @return bool
   *   If a new relationship was created.
   */
  public function addItem(Item $item) {
    $channel_nid = $this->nid();
    $item_nid = $item->nid();

    // Check if the item is already in the specified channel:
    $rels = moonmars_relationships_get_relationships('has_item', 'node', $channel_nid, 'node', $item_nid);

    if ($rels) {
      // No need to add the item to the channel, as it's already there. Just bump it by loading and saving.
      $rel = relation_load($rels[0]->rid);
      relation_save($rel);
      return FALSE;
    }
    else {
      // Create a new relationship without saving:
      $rel = moonmars_relationships_create_relationship('has_item', 'node', $channel_nid, 'node', $item_nid, FALSE);

      // Get the item's original channel:
      $original_channel = $item->originalChannel();
      $original_channel_nid = $original_channel ? $original_channel->nid() : FALSE;

      // Set the copied flag:
      $rel->field_copied[LANGUAGE_NONE][0]['value'] = (int) ($original_channel_nid && $channel_nid != $original_channel_nid);

      // Save the relationship:
      relation_save($rel);
      return TRUE;
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
      $rel = relation_load($rels[0]->rid);
      return relation_save($rel);
    }
    return FALSE;
  }

  /**
   * Post or edit an item or comment.
   * Copy the update to all relevant channels and send notifications.
   *
   * @param object $item_or_comment
   *   The item or comment being posted or edited.
   * @param bool $is_new
   *   TRUE if the post is new, FALSE if editing an existing post.
   * @param bool $is_comment
   *   TRUE if the post is a comment, FALSE if an item.
   */
  public function post($item_or_comment, $is_new, $is_notification = FALSE) {
    // Get the current item/comment poster:
    global $user;
    $poster_uid = $user->uid;
    $poster = Member::create($poster_uid);
    $poster_link = $poster->link();

    // Check what we got:
    if ($item_or_comment instanceof Item) {
      $item = $item_or_comment;
      $is_comment = FALSE;
    }
    elseif ($item_or_comment instanceof ItemComment) {
      $comment = $item_or_comment;
      $item = $comment->item();
      $is_comment = TRUE;
    }
    else {
      trigger_error("Invalid parameter to Channel::postItem()", E_USER_WARNING);
    }

    // Get the original item poster:
    $original_poster = $item->creator();
    $original_poster_link = $original_poster->link();

    /////////////////////////////////////////////////////////////////////////////
    // Step 1. Add or bump the item in the current channel.
    $new_relation = $this->addItem($item);

    // Get the original channel:
    if ($new_relation) {
      // New item. The current channel will be the original channel. No need to bump.
      $original_channel = $this;
    }
    else{
      $original_channel = $item->originalChannel();
    }

    // Get a link to the original channel:
    $parent_entity = $original_channel->parentEntity();
    if ($parent_entity instanceof Member) {
      $original_channel_link = $parent_entity->link() . "'s channel";
    }
    else {
      $original_channel_link = "the " . $parent_entity->link() . " " . $parent_entity->type() . "'s channel";
    }

    /////////////////////////////////////////////////////////////////////////////
    // Step 2. Bump the item in the channel where it was originally posted, if different.
    if (!Channel::equals($this, $original_channel)) {
      $original_channel->bumpItem($item);
    }

    /////////////////////////////////////////////////////////////////////////////
    // Step 3. Find out which members should see this item in their channel:
    $subscribers = array();

    // a) The current user, i.e. the posting member.
    // Note, we omit a reason, because we don't need to notify this member.
    $subscribers[$poster_uid] = array(
      'member' => $poster
    );

    // b) If the item is being posted in a member's channel, that member.
    if ($parent_entity instanceof Member) {
      $subscribers[$parent_entity->uid()]['member'] = $parent_entity;
      $subscribers[$parent_entity->uid()]['reasons'][] = "It's your channel.";
    }

    // c) If the item is being posted in a group, all members of the group.
    if ($parent_entity instanceof Group) {
      $members = $parent_entity->members();
      foreach ($members as $member) {
        $subscribers[$member->uid()]['member'] = $member;
        $subscribers[$member->uid()]['reasons'][] = "You're a member of the " . $parent_entity->link() . " group.";
      }
    }

    // d) Everyone following the person who posted, edited or commented.
    $followers = $poster->followers();
    foreach ($followers as $follower) {
      $subscribers[$follower->uid()]['member'] = $follower;
      $subscribers[$follower->uid()]['reasons'][] = "You follow $poster_link.";
    }

    // e) Everyone following the original poster (if different to the current poster).
    if (!Member::equals($original_poster, $poster)) {
      $followers = $original_poster->followers();
      foreach ($followers as $follower) {
        if (!array_key_exists($subscribers, $follower->uid())) {
          $subscribers[$follower->uid()]['member'] = $follower;
          $subscribers[$follower->uid()]['reasons'][] = "You follow $original_poster_link.";
        }
      }
    }

    // f) Everyone mentioned in the item text.
    $referenced_members = moonmars_text_referenced_members($item->text());
    foreach ($referenced_members as $member) {
      $subscribers[$member->uid()]['member'] = $member;
      $subscribers[$member->uid()]['reasons'][] = "You're mentioned in the " . ($is_comment ? 'comment' : 'item') . ".";
    }

    // g) Everyone following a hash tag that appears in the item text. @todo

    /////////////////////////////////////////////////////////////////////////////
    // Step 4. Copy/bump the item in all the channels of all relevant subscribers:
    foreach ($subscribers as $subscriber_uid => $subscriber_info) {
      $subscriber = $subscriber_info['member'];

      // Copy/bump the item in the subscribers channel:
      $subscriber->channel()->addItem($item);

      // Send notifications to everyone who isn't the poster:
      if ($subscriber_uid != $poster_uid) {

        if (Member::equals($parent_entity, $subscriber)) {
          $original_channel_link = "your channel";
        }

        if ($is_comment) {
          // New comment posted or existing comment edited:
          $action = $is_new ? "commented" : "edited their comment";
          if (Member::equals($subscriber, $original_poster)) {
            $posted_by = "you posted";
          }
          elseif (Member::equals($poster, $original_poster)) {
            $posted_by = "they posted";
          }
          else {
            $posted_by = "posted by $original_poster_link";
          }
          $summary = "$poster_link $action on an item $posted_by in channel $original_channel_link.\n";

          $text = "Comment text: <strong>" . moonmars_text_filter($comment->text()) . "</strong>";
        }
        else {
          // New item posted or existing item edited:
          $action = $is_new ? "posted a new" : "edited an";
          $summary = "$poster_link $action item in $original_channel_link.\n";
          $text = "Item text: <strong>" . moonmars_text_filter($item->text()) . "</strong>";
        }

        // Set the subject:
        $subject = strip_tags($is_notification ? $item->text() : $summary);

        // Start the HTML message:
        $message = "<p><strong>$summary</strong></p>\n";

        // Reasons:
        $message .= "<p>You're receiving this notification because:\n";
        $message .= "<ul>\n";
        foreach ($subscriber_info['reasons'] as $reason) {
          $message .= "<li>$reason</li>\n";
        }
        $message .= "</ul>\n";

        // Text:
        $message .= "<p>$text</p>";

        // Item link:
        $message .= "<p>" . $item->link("Read or post comments") . "</p>\n";

        // Comment by email instructions:
//        $can_post_comment = $subscriber->canPostComment($item);
//        if ($can_post_comment) {
//          $message .= "<hr>\n";
//          $message .= "<p>Scroll down to the bottom of this message to post a new comment by email.</p>";
//        }

        // The item with comments:
//        $message .= "<hr>\n";
//        $message .= $item->render();

//        // Comment by email:
//        if ($can_post_comment) {
//          $message .= "<hr>\n";
//          $message .= "<p>To post a comment by email, enter your comment between the tags below, and click <em>Reply</em> in your email client:</p>\n";
//          $message .= "[BEGIN COMMENT]<br>";
//          $message .= "<br><br><br>";
//          $message .= "[END COMMENT]<br>";
//        }

        // Send the notification
        $subscriber->notify($subject, $message);
      }
    }
  }

  /**
   * Post a system message to the channel.
   *
   * @param $message
   * @return Channel
   */
  public function postSystemMessage($message) {
    $item = Item::createSystemMessage($message);
    $this->post($item, TRUE, TRUE);
    return $this;
  }

  /**
   * Get the total number of items in the channel.
   *
   * @param bool $include_copied_items
   * @return array
   */
  public function itemCount($include_copied_items = TRUE) {
    // Look for relationship records:
    $q = db_select('view_channel_has_item', 'vci')
      ->fields('vci', array('item_nid', 'copied'))
      ->condition('channel_nid', $this->nid());

    // Add condition if we want to exclude copied items:
    if (!$include_copied_items) {
      $q->condition(db_or()->condition('copied', 0)->condition('copied'));
    }

    // Get the items and return the count:
    $rs = $q->execute();
    return $rs->rowCount();
  }

  /**
   * Render a channel's items.
   *
   * @param bool $include_copied_items
   * @return string
   */
  public function renderItems($include_copied_items = TRUE) {
    // Get the page number:
    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 0;

    // Get the items from this channel:
    $items = $this->items($include_copied_items, $page * self::pageSize, self::pageSize);

    // Render the items:
    $node_views = array();
    foreach ($items as $item) {
      $node = $item->node();
      $node_view = node_view($node);
      $node_view['comments'] = comment_node_page_additions($node);
      $node_views[] = $node_view;
    }
    $items = render($node_views);

    // Render the pager:
    $n_items = $this->itemCount();
    pager_default_initialize($n_items, self::pageSize);
    $pager = theme('pager', array('quantity' => $n_items));

    return "
      <div id='channel'>
        <div id='channel-items'>$items</div>
        <div id='channel-pager'>$pager</div>
      </div>";
  }

}
