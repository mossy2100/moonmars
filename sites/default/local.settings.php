<?php

// Show all errors, warnings, notices::
error_reporting(E_ALL | E_STRICT);

// Include some PHP:
require_once DRUPAL_ROOT . '/sites/all/libraries/star/php/strings.php';
require_once DRUPAL_ROOT . '/sites/all/libraries/star/php/numbers.php';
require_once DRUPAL_ROOT . '/sites/all/libraries/star/php/arrays.php';
require_once DRUPAL_ROOT . '/sites/all/libraries/star/php/drupal.php';

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
 * Custom autoload function.
 *
 * @param $class
 */
function moonmars_autoload($class_name) {
  // Get the location of our classes if not done already:
  global $moonmars_classes;
  if (!isset($moonmars_classes)) {
    // Check the cache:
    $moonmars_classes_cache = cache_get('moonmars_classes');
    if ($moonmars_classes_cache) {
      $moonmars_classes = $moonmars_classes_cache->data;
    }
    else {
      // Not in cache, so scan the classes folder:
      moonmars_scan_classes_dir();
      // Cache that shit:
      cache_set('moonmars_classes', $moonmars_classes, 'cache', CACHE_TEMPORARY);
    }
  }

  // If we have this class, load it:
  if (array_key_exists($class_name, $moonmars_classes)) {
    require_once $moonmars_classes[$class_name];
    return;
  }
}

// Register our autoload function:
spl_autoload_register('moonmars_autoload');
