<?php

////////////////////////////////////////////////
// Local settings for development environment.

$conf['enviroment'] = 'development';

// Report all errors including notices and strict:
error_reporting(E_ALL | E_STRICT);

// Log errors:
ini_set('log_errors', TRUE);

// Display errors:
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Override the setting in var/aegir/global.inc, for persistent_login:
ini_set('session.cookie_lifetime', 0);
