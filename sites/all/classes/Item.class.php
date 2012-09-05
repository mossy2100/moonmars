<?php
/**
 * Encapsulates an item node.
 */
class Item extends MoonMarsNode {

  /**
   * The node type.
   */
  const nodeType = 'item';

  /**
   * The class to use for comments.
   *
   * @var string
   */
  const COMMENT_CLASS = 'ItemComment';

  /**
   * The channel where the item was posted.
   *
   * @var Channel
   */
  protected $channel;

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set methods.

  /**
   * Get the channel where this item was posted.
   *
   * @return Channel
   */
  public function channel() {
    if (!isset($this->channel)) {
      $rels = Relation::searchBinary('has_item', 'node', NULL, 'node', $this->nid());

      if ($rels) {
        $this->channel = Channel::create($rels[0]->endpointEntityId(0));
      }
    }

    return $this->channel;
  }

  /**
   * Get/set the item text.
   *
   * @param null|string $text
   */
  public function text($text = NULL) {
    return $this->field('field_item_text', LANGUAGE_NONE, 0, 'value', $text);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Render methods.

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

}
