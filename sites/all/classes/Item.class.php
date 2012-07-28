<?php
/**
 * Encapsulates an item node.
 */
class Item extends Node {

  /**
   * The node type.
   */
  const nodeType = 'item';

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

      $rels = moonmars_relationships_get_relationships('has_item', 'node', NULL, 'node', $this->nid());

      if ($rels) {
        $this->channel = Channel::create($rels[0]->entityId(LANGUAGE_NONE, 0));
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

  /**
   * Get the item's creator.
   * Overrides base class method, which returns User.
   *
   * @return Member
   */
  public function creator() {
    return Member::create($this->uid());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // System messages.

  /**
   * Create a system message.
   *
   * @param string $text
   * @param Channel $channel
   */
  public static function createSystemMessage($text) {
    return self::create()
      ->setProperties(array(
        'uid'   => MOONMARS_SYSTEM_UID,
        'title' => moonmars_text_trim($text),
      ))
      ->field('field_item_text',   LANGUAGE_NONE, 0, 'value', $text)
      ->field('field_item_system', LANGUAGE_NONE, 0, 'value', 1)
      ->save();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Render methods.

  /**
   * Render an item.
   *
   * @param bool $include_comments
   * @return string
   */
  public function render($include_comments = TRUE) {
    return self::renderMultiple(array($this), $include_comments);
  }

  /**
   * Render an array of items.
   *
   * @static
   * @param array $items
   * @param bool $include_comments
   * @return string
   */
  public static function renderMultiple(array $items, $include_comments = TRUE) {
    // Render the items:
    $node_views = array();
    foreach ($items as $item) {
      $node = $item->node();
      $node_view = node_view($node);
      if ($include_comments) {
        $node_view['comments'] = comment_node_page_additions($node);
      }
      $node_views[] = $node_view;
    }
    return render($node_views);
  }

}
