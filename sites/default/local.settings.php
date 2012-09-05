<?php

// Show all errors, warnings, notices::
error_reporting(E_ALL | E_STRICT);

// Include some PHP:
require_once DRUPAL_ROOT . '/sites/all/libraries/star/php/strings.php';
require_once DRUPAL_ROOT . '/sites/all/libraries/star/php/numbers.php';
require_once DRUPAL_ROOT . '/sites/all/libraries/star/php/arrays.php';
require_once DRUPAL_ROOT . '/sites/all/libraries/star/php/drupal.php';

/**
 * Custom autoload function.
 *
 * @param $class
 */
function moonmars_autoload($class) {
  // Try sites/all/classes:
  $path = DRUPAL_ROOT . "/sites/all/classes/$class.class.php";
  if (file_exists($path)) {
    require_once $path;
    return;
  }

  // Try sites/all/classes/core:
  $path = DRUPAL_ROOT . "/sites/all/classes/core/$class.class.php";
  if (file_exists($path)) {
    require_once $path;
    return;
  }

  // Try sites/all/libraries/star/php/classes:
  $path = DRUPAL_ROOT . "/sites/all/libraries/star/php/classes/$class.class.php";
  if (file_exists($path)) {
    require_once $path;
    return;
  }
}

// Register our autoload function:
spl_autoload_register('moonmars_autoload');
