<?php
/**
 * Encapsulates an item node.
 */
class Item extends Node {

  /**
   * Original posters of items.
   *
   * @var
   */
  static $original_posters;

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  /**
   * Create a new Item object.
   *
   * @param int $nid
   * @return Group
   */
  public static function create($nid = NULL) {
    return parent::create(__CLASS__, $nid);
  }

  /**
   * Gets a title from the item text, max 100 characters.
   *
   * @return string
   */
  public function autoNodetitle() {
    $text = $this->field('field_item_text');
    return (strlen($text) <= 100) ? $text : (substr($text, 0, 97) . '...');
  }

  /**
   * Get the channel where this item was originally posted.
   *
   * @return Channel
   */
  public function originalChannel() {
    // Cache the results:
    static $original_channels = array();

    $item_nid = $this->nid();
    if (!isset($original_channels[$item_nid])) {
      $original_channel = db_select('view_item_original_channel', 'v')
        ->fields('v', array('channel_nid', 'channel_title'))
        ->condition('item_nid', $item_nid)
        ->execute()
        ->fetch();
      if ($original_channel) {
        $original_channels[$item_nid] = $original_channel;
      }
    }

    // If found, create the Channel object:
    if (isset($original_channels[$item_nid])) {
      $channel = Channel::create($original_channels[$item_nid]->channel_nid);
      $channel->title($original_channels[$item_nid]->channel_title);
      return $channel;
    }

    return NULL;
  }

}
