<?php
// $Id$

/**
 * @file
 * Contains functions specifically related to the Class names form.
 */

/**
 * Create the form for entering class names for content types.
 *
 * @param array $form_state
 * @return array
 */
function classes_class_names_form($form_state, $type) {
  global $_classes_dir;

  $form = array();
  
  $form['#attributes'] = array('class' => 'classes-names-form');

  // Instructions:
  $form['instructions'] = array(
    '#type' => 'markup',
    '#value' =>
      "<p>" . t("Enter the class name for each content type.") . "</p>" .
      "<p>" . t("Drupal coding standards specify that class names should be TitleCase, e.g. 'ClassName' (not 'class_name', 'className' or 'CLASS_NAME').") . "</p>" .
      "<p>" . t("Class names should be singular.") . "</p>" .
      "<p>" . t("Class names cannot be PHP reserved words or function names.") . "</p>" .
      "<p>" . t("Class names cannot be the same as any entity or helper class, i.e. XEntity, XNode, XUser, XDateTime, etc.") . "</p>" .
      "<p>" . t("WARNING: This does not refactor your code! If you change a class name here, you also need to update any of your code that references it.") . "</p>",
  );

  // Get the content types classes:
  $classes = classes_get_type_classes();
  
  // Loop through content types:
  foreach ($classes as $type => $class_info) {
    // Get default class name:
    $default_class = classes_default_class_name($type);

    // Get the current class name:
    $class = $class_info['class_name'] ? $class_info['class_name'] : $default_class;

    // Set the table cell values:
    $form['name'][$type] = array(
      '#value' => $class_info['name'],
    );
    $form['type'][$type] = array(
      '#value' => $type,
    );
    $form['class'][$type] = array(
      '#type' => 'textfield',
      '#default_value' => $class,
    );
    $form['default_class'][$type] = array(
      '#value' => "<a href=\"javascript:classes_use_default_class_name('$type', '$default_class')\">$default_class</a>",
    );
  }
  
  // Checkbox for regenerating classes:
  $form['generate'] = array(
    '#type' => 'checkbox',
    '#default_value' => FALSE,
    '#title' => t("Go to the \"Generate classes\" form after saving."),
  );
  
  // Submit button:
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t("Save class names"),
  );
  
  // Add the CSS and JS:
  $path = drupal_get_path('module', 'classes');
  drupal_add_css("$path/classes.css");
  drupal_add_js("$path/classes_class_names_form.js");

  return $form;
}

/**
 * Theme classes_class_names_form.
 * 
 * @param array $form
 * @return string
 */
function theme_classes_class_names_form($form) {
  // Construct table, starting with the header row:
  $header = array(
    t('Name'),
    t('Type'),
    t('Class name'),
    t('Default (click to set)'),
  );

  $rows = array();

  foreach ($form['type'] as $type_info) {
    // Skip array items that don't describe types:
    if (!isset($type_info['#value'])) {
      continue;
    }

    // Get the type or entity name:
    $type = $type_info['#value'];

    // Add row:
    $rows[] = array(
      drupal_render($form['name'][$type]),
      drupal_render($form['type'][$type]),
      drupal_render($form['class'][$type]),
      drupal_render($form['default_class'][$type]),
    );
  }

  // Generate HTML:
  $output =
    drupal_render($form['instructions']) .
    theme('table', $header, $rows) .
    drupal_render($form);
  return $output;
}

/**
 * Validation handler for classes_class_names_form().
 *
 * @param array $form
 * @param array $form_state
 */
function classes_class_names_form_validate($form, &$form_state) {
  // Get the type names:
  $types = node_get_types();

  // Check each of the entered class names:
  $classes = array();
  foreach ($form_state['values'] as $type => $class) {
    
    // Check that this form field is a class name:
    if (!array_key_exists($type, $types)) {
      continue;
    }
    
    // Validate the class name:
    classes_class_name_validate($type, $class, $type, $classes);
    
    // Remember the class:
    $classes[$type] = array('class_name' => $class);
  }
}

/**
 * Submit handler for classes_class_names_form().
 *
 * @param array $form
 * @param array $form_state
 */
function classes_class_names_form_submit($form, &$form_state) {
  
  foreach ($form_state['values'] as $type => $class) {
    // Update the class name for this content type:
    db_query("
      UPDATE {node_type} SET class_name = '%s'
      WHERE type = '%s'", $class, $type);
  }
  drupal_set_message(t("Class names have been updated."));
  
  // Update the cache of type class names:
  classes_type_class_name(NULL, TRUE);

  // Go to "Generate classes" form if requested:
  if ($form_state['values']['generate']) {
    $_REQUEST['destination'] = "admin/settings/classes/generate";
  }
}
