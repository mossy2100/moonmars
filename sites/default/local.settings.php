<?php
// Local settings for development environment.
$conf['enviroment'] = 'development';

// Report all errors except notices and strict:
error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);

// Log errors:
ini_set('log_errors', TRUE);

// Display errors:
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Get the common settings:
require_once DRUPAL_ROOT . '/sites/default/common.settings.php';
