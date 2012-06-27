// $Id$

/**
 * @file
 * Functions to support alterations to the content type form.
 */

/**
 * Adds a link after the property name textfield that enables the user to easily select the default
 * property name.
 * @todo Use the t() function on the link text.
 */
$(function() {
  $('#select-default-class').insertAfter('#edit-class-name');
});

/**
 * Set the property name to the default.
 */
function classes_use_default_class_name() {
  $('#edit-class-name').val($('#edit-default-class').val());
}
