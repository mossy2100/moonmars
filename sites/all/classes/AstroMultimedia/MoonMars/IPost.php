<?php
namespace AstroMultimedia\MoonMars;

/**
 * Interface to be shared by Item and ItemComment.
 *
 * @author Shaun Moss (shaun@astromultimedia.com, skype:mossy2100)
 * @since 2012-10-31 12:42
 */
interface IPost extends IActor {

  public function text($text = NULL);

  public function textScan();

  public function html();

  public function mentions(IStar $member);

  public function channel();
}
