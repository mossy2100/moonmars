<?php

/**
 * Comments posted on items.
 */
class ItemComment extends Comment {

  /**
   * Result of text scan.
   *
   * @var string
   */
  protected $textScan;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set methods.

  /**
   * Get the item that the comment was about.
   *
   * @return Item
   */
  public function item() {
    return Item::create($this->nid());
  }

  /**
   * Get the comment's creator.
   * Overrides base class method, which returns a User object.
   *
   * @return Member
   */
  public function creator() {
    return Member::create($this->uid());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Link/alias/URL

  /**
   * Get a link to the comment, which is really a link to the item with the comment highlighted.
   *
   * @param null|string $text
   */
  public function link($label = NULL, $absolute = FALSE) {
    $label = ($label === NULL) ? $this->subject() : $label;
    $cid = $this->cid();
    return l($label, $this->item()->url($absolute), array('query' => array('cid' => $cid), 'fragment' => "comment-$cid"));
  }

  /**
   * Get/set the comment alias.
   *
   * @param array
   */
  public function alias($alias = NULL) {
    if ($alias === NULL) {
      // Get the comment alias:
      $cid = $this->cid();
      return $this->item()->alias() . "?cid=$cid#comment-$cid";
    }
    else {
      // Set the comment alias:
      return parent::alias($alias);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Text

  /**
   * Get/set the comment text.
   *
   * @param null|string $text
   */
  public function text($text = NULL) {
    if ($text === NULL) {
      // Get the comment text:
      return moonmars_text_fix_hearts($this->field('comment_body', LANGUAGE_NONE, 0, 'value'));
    }
    else {
      // Set the comment text:
      return $this->field('comment_body', LANGUAGE_NONE, 0, 'value', moonmars_text_fix_hearts($text));
    }
  }

  /**
   * Get/set the comment text scan.
   *
   * @param array
   */
  public function textScan() {
    // If we haven't scanned the text yet, do it now.
    if (!isset($this->textScan)) {
      $this->textScan = new TextScan($this->text());
    }
    return $this->textScan;
  }

}
