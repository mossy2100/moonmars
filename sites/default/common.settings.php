<?php

// Override the setting in var/aegir/global.inc, for persistent_login:
ini_set('session.cookie_lifetime', 0);

// Include some Star Library awesomeness:
$star_path = DRUPAL_ROOT . "/sites/all/libraries/star";
require_once "$star_path/php/strings.php";
require_once "$star_path/php/numbers.php";
require_once "$star_path/php/arrays.php";
require_once "$star_path/php/objects.php";
require_once "$star_path/php/drupal.php";

// Set the internal encoding to UTF-8.
// @see moonmars_text_html_entities()
mb_internal_encoding('UTF-8');

/**
 * Custom autoload function based on the PSR-0 standard, as used in D8 and other frameworks.
 *
 * @see https://gist.github.com/1234504
 * @see http://drupal.org/node/1240138
 *
 * @param string $class_name
 */
function psr0_autoload($class_name) {
  $class_name = ltrim($class_name, '\\');
  $path  = DRUPAL_ROOT . '/sites/all/classes';
  if ($last_namespace_pos = strripos($class_name, '\\')) {
    $namespace = substr($class_name, 0, $last_namespace_pos);
    $class_name = substr($class_name, $last_namespace_pos + 1);
    $path .= '/' . str_replace('\\', '/', $namespace);
  }
  $path .= '/' . str_replace('_', '/', $class_name) . '.php';
  if (file_exists($path)) {
    require $path;
  }
}

// Register autoload function:
spl_autoload_register('psr0_autoload');
