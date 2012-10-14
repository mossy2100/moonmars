<?php

// Report all errors except for notices and strict:
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

// Report all errors except for notices:
error_reporting(E_ALL & ~E_NOTICE);

// Include some PHP:
$star_path = DRUPAL_ROOT . "/sites/all/libraries/star";
require_once "$star_path/php/strings.php";
require_once "$star_path/php/numbers.php";
require_once "$star_path/php/arrays.php";
require_once "$star_path/php/objects.php";
require_once "$star_path/php/drupal.php";

/**
 * Scan /sites/all/classes to find where all the classes are.
 *
 * @param string|null $dir
 */
function moonmars_scan_classes_dir($dir = NULL) {
  global $moonmars_classes;

  // Default dir:
  if ($dir === NULL) {
    $dir = DRUPAL_ROOT . "/sites/all/classes";
  }

  $filenames = scandir($dir);
  foreach ($filenames as $filename) {
    if (in_array($filename, array('.', '..'))) {
      continue;
    }

    $path = "$dir/$filename";
    if (is_file($path)) {
      // Check if it's a class file:
      if (substr($filename, -10) == '.class.php') {
        $class_name = substr($filename, 0, strlen($filename) - 10);
        $moonmars_classes[$class_name] = $path;
      }
    }
    elseif (is_dir($path)) {
      moonmars_scan_classes_dir($path);
    }
  }
}

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

// Old autoload code:
//  // Get the location of our classes if not done already:
//  global $moonmars_classes;
//  if (!isset($moonmars_classes)) {
//    // Check the cache:
//    $moonmars_classes_cache = cache_get('moonmars_classes');
//    if ($moonmars_classes_cache) {
//      $moonmars_classes = $moonmars_classes_cache->data;
//    }
//    else {
//      // Not in cache, so scan the classes folder:
//      moonmars_scan_classes_dir();
//      // Cache that shit:
//      cache_set('moonmars_classes', $moonmars_classes, 'cache', CACHE_TEMPORARY);
//    }
//  }
//
//  // If we have this class, load it:
//  if (array_key_exists($class_name, $moonmars_classes)) {
//    require_once $moonmars_classes[$class_name];
//    return;
//  }
