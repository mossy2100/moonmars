<?php

// This is set in global.inc
//error_reporting(0);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);

// Override the setting in var/aegir/global.inc, for persistent_login:
ini_set('session.cookie_lifetime', 0);

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
  // echo "Trying " . DRUPAL_ROOT . "/sites/all/classes/$class.class.php";
  $path = DRUPAL_ROOT . "/sites/all/classes/$class.class.php";
  if (file_exists($path)) {
    require_once $path;
    return;
  }

  // Try sites/all/classes/core:
  // echo "Trying " . DRUPAL_ROOT . "/sites/all/classes/core/$class.class.php";
  $path = DRUPAL_ROOT . "/sites/all/classes/core/$class.class.php";
  if (file_exists($path)) {
    require_once $path;
    return;
  }

  // Try sites/all/libraries/star/php/classes:
  // echo "Trying " . DRUPAL_ROOT . "/sites/all/libraries/star/php/classes/$class.class.php";
  $path = DRUPAL_ROOT . "/sites/all/libraries/star/php/classes/$class.class.php";
  if (file_exists($path)) {
    require_once $path;
    return;
  }
}

// Register our autoload function:
spl_autoload_register('moonmars_autoload');
