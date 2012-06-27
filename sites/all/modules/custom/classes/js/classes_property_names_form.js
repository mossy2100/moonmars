// $Id$

/**
 * @file
 * Functions to support the CCK field property names form.
 */

/**
 * Set the property name for a given field to the default.
 */
function classes_use_default_property_name(field, default_property) {
  // Find the textfield and set the property name:
  $('input:text[name=' + field + ']').val(default_property);
}
