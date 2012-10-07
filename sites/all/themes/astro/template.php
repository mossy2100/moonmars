<?php

use \AstroMultimedia\MoonMars\MoonMarsDateTime;

/**
 * @file
 * This file is empty by default because the base theme chain (Alpha & Omega) provides
 * all the basic functionality. However, in case you wish to customize the output that Drupal
 * generates through Alpha & Omega this file is a good place to do so.
 *
 * Alpha comes with a neat solution for keeping this file as clean as possible while the code
 * for your subtheme grows. Please read the README.txt in the /preprocess and /process subfolders
 * for more information on this topic.
 */

/**
 * Format a datetime in terms of how long ago it was.
 *
 * @param mixed $datetime
 * @return string
 */
function astro_format_about_how_long_ago($datetime) {
  $datetime = new MoonMarsDateTime($datetime);
  $time_ago = $datetime->aboutHowLongAgo();
  $time_ago = $time_ago == 'now' ? 'just now' : "about $time_ago ago";
  $iso = $datetime->format(DateTime::ISO8601);
  return "<time datetime='$iso'>$time_ago</time>";
}
