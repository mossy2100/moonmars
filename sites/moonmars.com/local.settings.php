<?php

// This is set in global.inc
//error_reporting(0);$conf['error_level'] = 32767;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
ini_set('error_reporting', TRUE);

// Override the setting in var/aegir/global.inc, for persistent_login:
ini_set('session.cookie_lifetime', 0);

// Include some PHP:
$star_path = DRUPAL_ROOT . "/sites/all/libraries/star";
require_once "$star_path/php/strings.php";
require_once "$star_path/php/numbers.php";
require_once "$star_path/php/arrays.php";
require_once "$star_path/php/objects.php";
require_once "$star_path/php/drupal.php";

/**
 * Custom autoload function based on the PSR-0 standard, which is used in D8 and other frameworks.
 *
 * @see https://gist.github.com/1234504
 * @see http://drupal.org/node/1240138
 *
 * @param $class
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

// Register the PSR-0 autoload function:
spl_autoload_register('psr0_autoload');
