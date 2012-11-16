<?php
namespace AstroMultimedia\MoonMars;

/**
 * Encapsulates an item node.
 */
class Item extends Node implements IPost {

  /**
   * The node type.
   *
   * @var string
   */
  const NODE_TYPE = 'item';

  /**
   * The channel where the item was posted.
   *
   * @var Channel
   */
  protected $channel;

  /**
   * Result of text scan.
   *
   * @var string
   */
  protected $textScan;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Magic methods

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // IPost methods

  /**
   * Get/set the item text.
   *
   * @param null|string $text
   * @return string
   */
  public function text($text = NULL) {
    if ($text) {
      // Set the text.
      // Convert hearts to HTML entities:
      $text = moonmars_text_fix_hearts($text);
    }
    // Get/set the field:
    return $this->field('field_item_text', LANGUAGE_NONE, 0, 'value', $text);
  }

  /**
   * Get the results of the text scan.
   *
   * @param array
   * @return TextScan
   */
  public function textScan() {
    // If we haven't scanned the text yet, do it now.
    if (!isset($this->textScan)) {
      $this->textScan = new TextScan($this->text());
    }
    return $this->textScan;
  }

  /**
   * Get the item HTML.
   *
   * @return string
   */
  public function html() {
    return $this->textScan()->html();
  }

  /**
   * Checks if the item mentions a member.
   *
   * @param Member $member
   * @return bool
   */
  public function mentionsMember(Member $member) {
    return $this->textScan()->mentionsMember($member);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Channel

  /**
   * Get the channel where this item was posted.
   *
   * @return Channel
   */
  public function channel() {
    if (!isset($this->channel)) {
      $rels = Relation::searchBinary('has_item', NULL, $this);

      if ($rels) {
        $this->channel = $rels[0]->endpoint(0);
      }
    }

    return $this->channel;
  }

  /**
   * Update a channel-has-item relation's 'changed' field so that the item appears at the top of the channel.
   * This should be called whenever an item is edited, and whenever a comment is posted or edited,
   * so that the changed value in the relation always holds the time of the most recent change to the item.
   *
   * @todo Update this later, because we are updating the data model so that an item doesn't have only one
   * channel, but can appear in multiple channels based on tags. Instead we will simply calculate the latest change
   * time when creating the channel.
   *
   * @return bool
   *   TRUE if the channel was found and the item was bumped; otherwise FALSE.
   */
  public function bump() {
    $rels = Relation::searchBinary('has_item', NULL, $this);
    if ($rels) {
      $rels[0]->load();
      $rels[0]->save();
      return TRUE;
    }
    return FALSE;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Rendering

  /**
   * Render an item.
   *
   * @param bool $include_comments
   * @param string $view_mode
   * @return string
   */
  public function render($include_comments = TRUE, $view_mode = 'full') {
    return self::renderMultiple(array($this), $include_comments, $view_mode);
  }

  /**
   * Render an array of items.
   *
   * @static
   * @param array $items
   * @param bool $include_comments
   * @return string
   */
  public static function renderMultiple(array $items, $include_comments = TRUE, $view_mode = 'full') {
    // Render the items:
    $node_views = array();
    foreach ($items as $item) {
      $node = $item->node();
      $node_view = node_view($node, $view_mode);
      if ($include_comments) {
        $node_view['comments'] = comment_node_page_additions($node);
      }
      $node_views[] = $node_view;
    }
    return render($node_views);
  }

  /**
   * Render an item for an email.
   *
   * @param ItemComment $comment
   *   The comment to highlight, if that's what the notification is about.
   */
  public function emailRender(Member $recipient, ItemComment $comment = NULL) {

    // Item link:
    $message = "<p>" . $this->link("Read or post comments") . "</p>\n";

    // Comment by email instructions:
    $can_post_comment = $recipient->canPostComment($this);
    if ($can_post_comment) {
      $message .= "<hr>\n";
      $message .= "<p>Scroll down to the bottom of this message to post a new comment by email.</p>";
    }

    // The item with comments:
    $message .= "<hr>\n";
    $message .= $this->render();

    // Comment by email:
    if ($can_post_comment) {
      $message .= "<hr>\n";
      $message .= "<p>To post a comment by email, enter your comment between the tags below, and click <em>Reply</em> in your email client:</p>\n";
      $message .= "[BEGIN COMMENT]<br>";
      $message .= "<br><br><br>";
      $message .= "[END COMMENT]<br>";
    }

    return $message;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Comments

  /**
   * Get the comments for this item.
   *
   * @param bool $published
   * @param string $comment_class
   * @return array
   */
  public function comments($published = TRUE, $comment_class = '\AstroMultimedia\MoonMars\ItemComment') {
    return parent::comments($published, $comment_class);
  }

  /**
   * Get the members who commented on this item.
   *
   * @return array
   */
  public function commenters($user_class = '\AstroMultimedia\MoonMars\Member') {
    return parent::commenters($user_class);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Aliases

  /**
   * Reset the alias for the item.
   *
   * @return string
   */
  public function resetAlias() {
    $text = strtolower($this->text());
    //echobr("Item " . $this->nid());
    //echobr($text);

    // Close contractions:
    $text = preg_replace("/([a-z]+)'([a-z]+)/", "$1$2", $text);
    //echobr("Closed contractions: $text");

    // Extract words:
    $words = preg_split("/[^\w]+/", $text);
    $words = array_values(array_filter($words));
//    dbg($words);

    if (!$words) {
      $alias = 'untitled';
    }
    else {
      // Choose the number of words that gives us a alias max length of 50:
      $optimal_length = 100;
      $smallest_dist = PHP_INT_MAX;
      $smallest_dist_key = NULL;
      foreach ($words as $key => $word) {
        $alias = implode('-', array_slice($words, 0, $key + 1));
        $dist = abs(strlen($alias) - $optimal_length);
        //echobr("dist for $alias = $dist");
        if ($dist > $smallest_dist) {
          // we're done:
          break;
        }
        else {
          //echobr("updating key to $key");
          $smallest_dist = $dist;
          $smallest_dist_key = $key;
        }
      }
      $alias = implode('-', array_slice($words, 0, $smallest_dist_key + 1));
    }

    // Get a unique variation:
    $base = $alias;
    $n = 0;
    while (TRUE) {
      // Is this alias in use?
      $q = db_select('url_alias', 'ua')
        ->fields('ua', array('source'))
        ->condition('alias', $alias)
        ->condition('source', 'node/' . $this->nid(), '!=');
      $rs = $q->execute();
      if ($rs->rowCount()) {
        // Yes it is. Go to next variation.
        $source = $rs->fetchField();
        //echobr("Another node has this alias $alias: $source");
        $n++;
        $alias = "$base-$n";
      }
      else {
        break;
      }
    }
    
    $alias = 'item/' . $alias;

    //echobr($alias);
    $this->alias($alias);
  }

}
