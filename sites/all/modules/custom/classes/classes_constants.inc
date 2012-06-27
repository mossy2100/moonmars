<?php

/**
 * Default paths to class files.
 */
define('CLASSES_DEFAULT_DIR', 'sites/all/classes');
  
/**
 * Constants for class category options.
 */
define('CLASSES_CATEGORY_ALL', 'all');
define('CLASSES_CATEGORY_ENTITIES', 'entities');
define('CLASSES_CATEGORY_TYPES', 'types');

/**
 * Constants for 'existing base class' options.
 */
define('CLASSES_EXISTING_ALL', 'all');
define('CLASSES_EXISTING_YES', 'yes');
define('CLASSES_EXISTING_NO', 'no');

/**
 * Constants for the convert_case function.
 */
define('CLASSES_LOWER_CASE', 1);
define('CLASSES_UPPER_CASE', 2);
define('CLASSES_CAMEL_CASE', 3);
define('CLASSES_TITLE_CASE', 4);

/**
 * Constants for errors.
 */
define('CLASSES_ERROR_NONE', 0);
define('CLASSES_ERROR_UNKNOWN_PROPERTY', 1);

/**
 * Return value from a save() method for when an entity isn't saved because it
 * isn't new or dirty.
 * @see SAVED_NEW
 * @see SAVED_UPDATED
 * @see XNode::save(), XTerm::save(), etc.
 */
define('SAVED_NOT', -1);


////////////////////////////////////////////////////////////////////////////////
// Datetime formats.

/**
 * These constants are copies of those in date_api.module, but included here
 * so that that module isn't a dependency.
 */
if (!defined('DATE_FORMAT_ISO')) {
  
  // ISO datetime format.
	define('DATE_FORMAT_ISO', 'Y-m-d\TH:i:s');

  // Datetime format.
  define('DATE_FORMAT_DATETIME', 'Y-m-d H:i:s');

  // Date format.
  define('DATE_FORMAT_DATE', 'Y-m-d');
}

/**
 * Time format. This one is not defined in date_api.module.
 */
define('DATE_FORMAT_TIME', 'H:i:s');
