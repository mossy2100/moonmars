// $Id$

/**
 * @file
 * Functions to support the class names form.
 */

/**
 * Set the class name for a given content type to the default.
 */
function classes_use_default_class_name(type, default_class) {
  // Find the textfield and set the class name:
  $('input:text[name=' + type + ']').val(default_class);
}
