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
   * Get the topic tag with the '#' prefix.
   *
   * @return string
   */
  public function tag() {
    return $this->name(NULL, TRUE);
  }

  /**
   * Create a link to the topic using the hash tag for the link label.
   *
   * @return string
   */
  public function tagLink() {
    return $this->link($this->tag());
  }

}
