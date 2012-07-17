<?php
/**
 * Encapsulates an item node.
 */
class Item extends Node {

  /**
   * The channel where the item was originally posted.
   *
   * @var Channel
   */
  protected $originalChannel;

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
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

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set methods.

  /**
   * Get the channel where this item was originally posted.
   *
   * @return Channel
   */
  public function originalChannel() {
    if (!isset($this->originalChannel)) {

      // Look up the original channel:
      $original_channel = db_select('view_item_original_channel', 'v')
        ->fields('v', array('channel_nid', 'channel_title'))
        ->condition('item_nid', $this->nid())
        ->execute()
        ->fetch();

      if ($original_channel) {
        // Create the Channel object and store in the originalChannel property:
        $this->originalChannel = Channel::create($original_channel->channel_nid);
        $this->originalChannel->title($original_channel->channel_title);
      }
    }

    return $this->originalChannel;
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

}
