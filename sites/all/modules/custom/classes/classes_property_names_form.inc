<?php
// $Id$

/**
 * @file
 * Contains functions specifically related to the Property names form.
 */

/**
 * Create the form for entering property names for a content type.
 *
 * @param array $form_state
 * @return array
 */
function classes_property_names_form($form_state, $content_type) {
  global $_classes_dir;

  $form = array();

  $form['#attributes'] = array('class' => 'classes-names-form');

  // Instructions:
  $form['instructions'] = array(
    '#type' => 'markup',
    '#value' =>
      "<p>" . t("Enter the property name for each CCK field.") . ' ' . t("If the field can contain multiple values, it's a good idea to pluralise the property name.") . "</p>" .
      "<p>" . t("Drupal coding standards specify that property names should be camelCase, e.g. 'propertyName' (not 'property_name', 'PropertyName' or 'PROPERTY_NAME').") . "</p>" .
      "<p>" . t("WARNING: This does not refactor your code! If you change a property name here, you also need to update any of your code that references it.") . "</p>",
  );

  // Get the CCK fields for this content type, in the same order as on the
  // "Manage fields" page.
  $fields = classes_get_cck_fields($content_type);
  foreach ($fields as $field => $field_info) {
    $field = $field_info['field'];

    // Get default property name:
    $default_property = classes_default_property_name($field, $content_type);

    // Get the current property name:
    $property = $field_info['property'] ? $field_info['property'] : $default_property;

    // Set the table cell values:
    $form['label'][$field] = array(
      '#value' => $field_info['label'],
    );
    $form['field'][$field] = array(
      '#value' => $field,
    );
    $form['field_type'][$field] = array(
      '#value' => $field_info['field_type'],
    );
    $form['multiple'][$field] = array(
      '#value' => $field_info['multiple'] ? t('Yes') : t('No'),
    );
    $form['property'][$field] = array(
      '#type' => 'textfield',
      '#default_value' => $property,
    );
    $form['default_property'][$field] = array(
      '#value' => "<a href=\"javascript:classes_use_default_property_name('$field', '$default_property')\">$default_property</a>",
    );
  }

  // Checkbox for regenerating class:
  $exists = classes_check_existence($content_type);
  $form['generate'] = classes_generate_checkbox($exists);

  // Submit button:
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t("Save property names"),
  );

  // Send the content type name through as a hidden field:
  $form['content_type'] = array(
    '#type' => 'hidden',
    '#default_value' => $content_type,
  );

  // Add the CSS and JS:
  $path = drupal_get_path('module', 'classes');
  drupal_add_css("$path/classes.css");
  drupal_add_js("$path/classes_property_names_form.js");

  return $form;
}

/**
 * Theme classes_property_names_form.
 *
 * @param array $form
 * @return string
 */
function theme_classes_property_names_form($form) {
  // Construct table, starting with the header row:
  $header = array(
    t('Label'),
    t('Field name'),
    t('Field type'),
    t('Multiple values?'),
    t('Property name'),
    t('Default (click to set)'),
  );

  $rows = array();

  foreach ($form['field'] as $field_info) {
    // Skip array items that don't describe fields:
    if (!isset($field_info['#value'])) {
      continue;
    }

    // Get the type or entity name:
    $field = $field_info['#value'];

    // Add row:
    $rows[] = array(
      drupal_render($form['label'][$field]),
      drupal_render($form['field'][$field]),
      drupal_render($form['field_type'][$field]),
      drupal_render($form['multiple'][$field]),
      drupal_render($form['property'][$field]),
      drupal_render($form['default_property'][$field]),
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
 * Validation handler for classes_property_names_form.
 *
 * @param array $form
 * @param array $form_state
 */
function classes_property_names_form_validate($form, &$form_state) {
  // Get the content type:
  $type = $form_state['values']['content_type'];

  // Check each of the entered property names:
  $properties = array();
  // Note that I make $property a reference in case
  // classes_property_name_validate() trims it.
  foreach ($form_state['values'] as $field => &$property) {
    if (substr($field, 0, 6) == 'field_') {
      classes_property_name_validate($type, $field, $property, $field, $properties);
      $properties[$field] = $property;
    }
  }
}

/**
 * Submit handler for classes_property_names_form.
 *
 * @param array $form
 * @param array $form_state
 */
function classes_property_names_form_submit($form, &$form_state) {
  // Get the content type:
  $type = $form_state['values']['content_type'];

  // Loop through fields updating the property name:
  foreach ($form_state['values'] as $field => $property) {
    if (substr($field, 0, 6) == 'field_') {
      // Update the property name for this field:
      db_query("
        UPDATE {content_node_field_instance} SET property_name = '%s'
        WHERE field_name ='%s' AND type_name = '%s'", $property, $field, $type);
    }
  }

  // Tell the user:
  drupal_set_message(t("Property names for the content type %type have been updated.", array('%type' => $type)));

  // Generate the class file if requested:
  if ($form_state['values']['generate']) {
    require_once "classes_generate.inc";
    $classes = classes_generate_type_classes($type);
    // Tell user:
    classes_generated_message($classes);
  }
}
