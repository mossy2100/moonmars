<?php
namespace AstroMultimedia\MoonMars;

/**
 * Interface to be shared by Member, Group and Topic.
 *
 * @author Shaun Moss (shaun@astromultimedia.com, skype:mossy2100)
 * @since 2012-10-27 18:56
 */
interface IActor {

  /**
   * Get/set the tag.
   *
   * @param null|string $tag
   * @param bool $include_prefix
   * @return string|IActor
   */
  public function tag($tag = NULL, $include_prefix = FALSE);

  /**
   * Get a link to the actor using the *tag field (with prefix) for the link text.
   *
   * @return string
   */
  public function tagLink();

  /**
   * Get/set the label.
   *
   * @param null|string $label
   * @return string|IActor
   */
  public function label($label = NULL);

  /**
   * Get a link to the actor using the label field for the link text.
   *
   * @return string
   */
  public function labelLink();

  /**
   * Lookup an actor given a tag.
   *
   * @static
   * @param $tag
   * @return IActor
   */
  public static function findByTag($tag);

  /**
   * Reset the actor's alias.
   *
   * @return mixed
   */
  public function resetAlias();

  /**
   * Get a title for the channel from the actor's title.
   *
   * @return string
   */
  public function channelTitle();
}
