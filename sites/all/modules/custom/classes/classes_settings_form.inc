<?php
// $Id$

/**
 * @file
 * Functions to support the Classes Settings form.
 */

/**
 * Create the form for settings for the classes module.
 *
 * @param array $form_state
 * @return array
 */
function classes_settings_form($form_state) {
  $form = array();

  // Add the JS:
  drupal_add_js(drupal_get_path('module', 'classes') . '/classes_settings_form.js');

  // Classes directory:
  $form['classes_dir'] = array(
    '#type' => 'textfield',
    '#title' => t("Classes directory"),
    '#description' => t("Enter the directory, relative to the website root, where you want your class files to be located."),
    '#default_value' => variable_get('classes_dir', CLASSES_DEFAULT_DIR),
  );

  // Submit button:
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
  );

  // Reset to defaults button:
  $form['reset'] = array(
    '#type' => 'markup',
    '#value' => "<a href='javascript:classes_settings_reset()'>Reset to default</a>",
  );
  
  return $form;
}

/**
 * Validation handler for classes_settings_form()
 *
 * @param array $form
 * @param array $form_state
 */
function classes_settings_form_validate($form, &$form_state) {
  // Check that the directories entered are valid.
  $dir = trim(str_replace("\\", "/", $form_state['values']['classes_dir']), "/");
  
  // Does this directory exist?
  $path = DRUPAL_ROOT . "/$dir";
  if (file_exists($path)) {
    // Check if it's a directory:
    if (!is_dir($path)) {
      form_set_error('classes_dir', t("%path is not a directory.", array('%path' => $path)));
    }
  }
  else {
    // Try to create the directory:
    if (!mkdir($path, 0755)) {
      form_set_error('classes_dir', t("Could not create directory %path.", array('%path' => $path)));
    }
  }
  // Update the $form_state:
  $form_state['values']['classes_dir'] = $dir;

  // Add the JS:
  classes_settings_form_js();
}

/**
 * Submit handler for classes_settings_form()
 *
 * @param array $form
 * @param array $form_state
 */
function classes_settings_form_submit($form, &$form_state) {
  global $_classes_dir;

  // Store the classes directory in the database:
  $_classes_dir = $form_state['values']['classes_dir'];
  variable_set('classes_dir', $_classes_dir);

  // Make sure directories and entity classes are setup:
  classes_setup();

  // Tell the user what we did:
  drupal_set_message(t("The classes directory has been updated."));
}
