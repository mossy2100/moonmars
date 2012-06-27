// $Id$

/**
 * @file
 * Functions to support the modifications to the CCK field properties form.
 */

/**
 * Adds a link after the property name textfield that enables the user to easily select the default
 * property name.
 * @todo Use the t() function on the link text.
 */
$(function() {
  $('#select-default-property').insertAfter('#edit-property');
});

/**
 * Set the property name to the default.
 */
function classes_use_default_property_name() {
  $('#edit-property').val($('#edit-default-property').val());
}
