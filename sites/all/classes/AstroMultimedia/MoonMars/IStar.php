<?php
namespace AstroMultimedia\MoonMars;

/**
 * Interface to be shared by Member, Group and Topic.
 * These "actors" are "stars" because they have their own channel :)
 * Every star has a tag, like @mossy2100, or %marsdrive, or #space-settlement.
 *
 * @author Shaun Moss (shaun@astromultimedia.com, skype:mossy2100)
 * @since 2012-10-27 18:56
 */
interface IStar extends IActor {

  /**
   * Get/set the tag.
   *
   * @param null|string $tag
   * @param bool $include_prefix
   * @return string|IStar
   */
  public function tag($tag = NULL, $include_prefix = FALSE);

  /**
   * Get a link to the star using the *tag field (with prefix) for the link text.
   *
   * @return string
   */
  public function tagLink();

  /**
   * Get/set the label.
   *
   * @param null|string $label
   * @return string|IStar
   */
  public function label($label = NULL);

  /**
   * Get a link to the star using the label field for the link text.
   *
   * @return string
   */
  public function labelLink();

  /**
   * Lookup an star given a tag.
   *
   * @static
   * @param $tag
   * @return IStar
   */
  public static function findByTag($tag);

  /**
   * Reset the star's alias.
   *
   * @return mixed
   */
  public function resetAlias();

  /**
   * Get a title for the channel from the star's title.
   *
   * @return string
   */
  public function channelTitle();
}
