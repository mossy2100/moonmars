<?php
namespace AstroMultimedia\MoonMars;

use \AstroMultimedia\Drupal\Term;

/**
 * Encapsulates a moonmars.com topic.
 *
 * @author Shaun Moss (mossy2100)
 * @since 2012-10-07
 */
class Topic extends Term implements IStar {

  /**
   * The tag prefix.
   *
   * @var string
   */
  const TAG_PREFIX = '#';

  /**
   * The vocabulary machine name, a.k.a. 'term type'. To be overridden by child classes.
   *
   * @var string
   */
  const VOCABULARY_MACHINE_NAME = 'topic';

  /**
   * The topic's channel.
   *
   * @var string
   */
  protected $channel;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // IStar methods

  /**
   * Get/set the tag.
   *
   * @param null|string $tag
   * @param bool $include_prefix
   * @return string|Topic
   */
  public function tag($tag = NULL, $include_prefix = FALSE) {
    return $this->name($tag, $include_prefix);
  }

  /**
   * Create a link to the topic using the #tag for the link text.
   *
   * @return string
   */
  public function tagLink() {
    return $this->link($this->tag(NULL, TRUE));
  }

  /**
   * Get/set the label.
   *
   * @param null|string $label
   * @return string|Topic
   */
  public function label($label = NULL) {
    return $this->field('field_topic_title', LANGUAGE_NONE, 0, 'value', $label);
  }

  /**
   * Create a link to the topic using the label for the link text.
   *
   * @return string
   */
  public function labelLink() {
    return $this->link($this->label());
  }

  /**
   * Get a topic given a topic tag.
   *
   * @static
   * @param $tag
   * @return Topic
   */
  public static function findByTag($tag) {
    // Strip the prefix if present:
    if ($tag[0] == self::TAG_PREFIX) {
      $tag = substr($tag, 1);
    }
    $q = db_select('taxonomy_term_data', 't')
      ->fields('t', array('tid'))
      ->condition('t.name', $tag)
      ->condition('v.machine_name', 'topic');
    $q->join('taxonomy_vocabulary', 'v', 't.vid = v.vid');
    $rec = $q->execute()->fetch();
    return $rec ? self::create($rec->tid) : FALSE;
  }

  /**
   * Update the path alias for the topic's profile.
   *
   * @return string
   */
  public function resetAlias() {
    $alias = 'topic/' . $this->tag();
    $this->alias($alias);
    return $alias;
  }

  /**
   * Get the title for the topic's channel.
   *
   * @return string
   */
  public function channelTitle() {
    return 'Topic: ' . $this->name();
  }

}
