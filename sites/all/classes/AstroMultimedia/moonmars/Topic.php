<?php
namespace AstroMultimedia\MoonMars;

/**
 * Encapsulates a moonmars.com topic.
 *
 * @author Shaun Moss (mossy2100)
 * @since 2012-10-07
 */
class Topic extends \AstroMultimedia\Drupal\Term {

  /**
   * The tag prefix.
   */
  const TAG_PREFIX = '#';

  /**
   * Create a link for the topic using the hash tag.
   *
   * @return string
   */
  public function tagLink() {
    return $this->link($this->name(NULL, TRUE));
  }

}
