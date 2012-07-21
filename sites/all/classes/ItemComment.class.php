<?php

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
   * Overrides base class method, which returns User.
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

}
