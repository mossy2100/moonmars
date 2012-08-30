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
   * Get/set the comment alias.
   *
   * @param null|string $text
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
