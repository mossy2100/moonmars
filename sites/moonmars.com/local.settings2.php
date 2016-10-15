<?php

////////////////////////////////////////////////
// Local settings for production environment.

$conf['enviroment'] = 'production';

// Report all errors except for strict and notices:
error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);

// Log errors:
ini_set('log_errors', TRUE);

// Do not display errors:
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', FALSE);

// Override the setting in var/aegir/global.inc, for persistent_login:
ini_set('session.cookie_lifetime', 0);
