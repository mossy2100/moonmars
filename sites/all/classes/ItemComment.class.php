<?php

/**
 * Comments posted on items.
 */
class ItemComment extends Comment {

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

  /**
   * Get/set the comment text.
   *
   * @param null|string $text
   */
  public function text($text = NULL) {
    return $this->field('comment_body', LANGUAGE_NONE, 0, 'value', $text);
  }

  /**
   * Get a link to the comment, which is really a link to the item with the comment highlighted.
   *
   * @param null|string $text
   */
  public function alias() {
    $cid = $this->cid();
    return $this->item()->alias() . "?cid=$cid#comment-$cid";
  }

  /**
   * Get a link to the comment.
   *
   * @return string
   */
  public function link($label = NULL) {
    $label = ($label === NULL) ? $this->subject() : $label;
    return l($label, $this->alias());
  }

}
