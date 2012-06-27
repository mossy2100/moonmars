<?php

/**
 * Implementation of hook_form_alter().
 *
 * @param array $form
 * @param array $form_state
 */
function classes_form_node_type_form_alter(&$form, $form_state) {
  // This is the "Edit" form for a content type.

  // Get content type and check for class existence:
  $type = $form['#node_type']->type;
  $exists = classes_check_existence($type);

  // Show class settings:
  $form['classes_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t("Classes settings"),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
    '#weight' => 100,
  );

  // Calculate the default class name:
  $default_class = classes_default_class_name($type);

  // Textfield for class name:
  $form['classes_settings']['class_name'] = array(
    '#type' => 'textfield',
    '#title' => t('Class name'),
    '#description' => t(
      "Enter the name of the class corresponding to this content type. Class names should be " .
      "TitleCase to comply with Drupal coding standards. The default class name " .
      "is generated from the content type name.", array('!type' => $type)),
    '#default_value' => $exists['class']['name'],
    '#required' => TRUE,
  );
  $form['classes_settings']['default_class'] = array(
    '#type' => 'hidden',
    '#value' => $default_class,
  );
  $form['classes_settings']['select_default_class'] = array(
    '#type' => 'markup',
    '#value' => "<a id='select-default-class' href='javascript:classes_use_default_class_name()'>" .
      t("Use default") . " (<em>$default_class</em>)</a>",
  );

  // Checkbox for regenerating class:
  $form['classes_settings']['generate'] = classes_generate_checkbox($exists, '', FALSE);

  // Custom submit handler:
  $form['#validate'][] = 'classes_node_type_form_validate';
  $form['#submit'][] = 'classes_node_type_form_submit';

  // Add the JS:
  drupal_add_js(drupal_get_path('module', 'classes') . "/classes_default_class_name.js");
}

/**
 * Custom validate handler for the edit content type form.
 *
 * @param array $form
 * @param array $form_state
 */
function classes_node_type_form_validate($form, &$form_state) {
  // Check the class name is valid:
  $type = $form_state['values']['type'];
  $class = $form_state['values']['class_name'];
  $classes = classes_get_type_classes();
  classes_class_name_validate($type, $class, 'class_name', $classes);
}

/**
 * Custom submit handler for the edit content type form.
 * Generates/regenerates the base class (and derived class stub if necessary)
 * for this content type, if requested.
 *
 * @param array $form
 * @param array $form_state
 */
function classes_node_type_form_submit($form, &$form_state) {
  // Update the class name for this content type:
  $type = $form_state['values']['type'];
  $class = $form_state['values']['class_name'];
  db_query("
    UPDATE {node_type} SET class_name = '%s'
    WHERE type = '%s'", $class, $type);
  
  // Update the classes for this content type if requested:
  if ($form_state['values']['generate']) {
    classes_update_type_classes($type);
  }
}
