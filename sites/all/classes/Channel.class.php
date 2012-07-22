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
        $this->parentEntity = mmcEntity::getEntity($rels[0]->entity_type0, $rels[0]->entity_id0);
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
    $item_poster = $item->creator();
    $item_poster_link = $item_poster->link();

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
      if (Member::equals($poster, $parent_entity)) {
        $original_channel_link = "their channel";
      }
      else {
        $original_channel_link = $parent_entity->link() . "'s channel";
      }
    }
    else {
      $original_channel_link = "the " . $parent_entity->link($parent_entity->title() . ' ' . $parent_entity->type()) . "'s channel";
    }

    /////////////////////////////////////////////////////////////////////////////
    // Step 2. Bump the item in the channel where it was originally posted, if different.
    if (!self::equals($this, $original_channel)) {
      $original_channel->bumpItem($item);
    }

    /////////////////////////////////////////////////////////////////////////////
    // Step 3. Find out which members should see this item in their channel:
    $recipients = array();

    // a) The current user, i.e. the posting member.
    // Note, we omit a reason, because we don't need to notify this member.
    $recipients[$poster_uid] = array(
      'member' => $poster
    );

    // b) If the item is being posted in a member's channel, that member.
    if ($parent_entity instanceof Member) {
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
    // Step 4. Copy/bump the item in all the channels of all relevant subscribers:
    foreach ($recipients as $recipient_uid => $recipient_info) {
      $recipient = $recipient_info['member'];

      // Copy/bump the item in the subscribers channel:
      $recipient->channel()->addItem($item);

      // Send notifications to everyone who isn't the poster:
      if ($recipient_uid != $poster_uid) {

        // Check if the recipient's channel equals the original channel:
        $original_channel_link2 = Member::equals($parent_entity, $recipient) ? "your channel" : $original_channel_link;

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
          $summary = "$poster_link $action on an item $posted_by in $original_channel_link2.\n";
//          $text = "Comment text: <strong>" . moonmars_text_filter($comment->text()) . "</strong>";
        }
        else {
          // New item posted or existing item edited:
          $action = $is_new ? "posted a new" : "edited an";
          $summary = "$poster_link $action item in $original_channel_link2.\n";
//          $text = "Item text: <strong>" . moonmars_text_filter($item->text()) . "</strong>";
        }

        // Set the subject:
        $subject = strip_tags($is_notification ? $item->text() : $summary);

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
      $html .= "<p class='official-website'><a href='$url' target='_blank' title='$title'>Official website</a></p>\n";
    }

    // Social links:
    $html .= "<div class='social-links clearfix'>\n";

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
        $html .= "<a class='social-link social-link-{$social_site}' href='$url' target='_blank' title='$title'></a>\n";
      }
    }

    $html .= "</div>";
    return $html;
  }

}
