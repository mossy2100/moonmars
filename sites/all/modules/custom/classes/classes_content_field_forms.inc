<?php

////////////////////////////////////////////////////////////////////////////////
// content_field_edit_form

/**
 * Implementation of hook_form_FORM_ID_alter().
 *
 * @param array $form
 * @param array $form_state
 */
function classes_form_content_field_edit_form_alter(&$form, $form_state) {
  // This form appears after selecting "Configure" on the "Manage Fields"
  // page. Note, we don't want the class settings to display when the user is
  // editing basic information.
  if (!$form_state['change_basic']) {

    // Get the current property name for this field:
    $field = $form['#field']['field_name'];
    $type = $form['#field']['type_name'];
    $sql = "
      SELECT property_name
      FROM {content_node_field_instance}
      WHERE field_name = '%s' AND type_name = '%s'";
    $property = db_result(db_query($sql, $field, $type));

    // Calculate the default property:
    $default_property = classes_default_property_name($field, $type);

    // If no property name has been set, use the default:
    if (!$property) {
      $property = $default_property;
    }

    $form['classes_settings'] = array(
      '#type' => 'fieldset',
      '#title' => t('Classes settings'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
      '#weight' => 0,
    );
    $form['classes_settings']['property'] = array(
      '#type' => 'textfield',
      '#title' => t('Virtual property name'),
      '#description' => t(
        "Enter the name of the property corresponding to this field. Property names should be " .
        "camelCase to comply with Drupal coding standards. The default property name " .
        "is generated from the CCK field name with the 'field_' prefix removed, and also the " .
        "content type prefix (e.g. '!type_') if present.", array('!type' => $type)),
      '#default_value' => $property,
      '#required' => TRUE,
    );
    $form['classes_settings']['default_property'] = array(
      '#type' => 'hidden',
      '#value' => $default_property,
    );
    $form['classes_settings']['select_default_property'] = array(
      '#type' => 'markup',
      '#value' => "<a id='select-default-property' href='javascript:classes_use_default_property_name()'>" .
        t("Use default") . " (<em>$default_property</em>)</a>",
    );

    // Checkbox for regenerating class:
    $exists = classes_check_existence($type);
    $form['classes_settings']['generate'] = classes_generate_checkbox($exists);

    // Set the weights of the basic and widget settings fieldsets so that the
    // classes settings appear after them:
    $form['basic']['#weight'] = -2;
    $form['widget']['#weight'] = -1;

    // Custom validate and submit handlers:
    $form['#validate'][] = 'classes_content_field_edit_form_validate';
    $form['#submit'][] = 'classes_content_field_edit_form_submit';

    // Add some JS:
    drupal_add_js(drupal_get_path('module', 'classes') . "/classes_property_name.js");
  }
}

/**
 * Custom validate handler for content_field_edit_form.
 *
 * @param array $form
 * @param array $form_state
 */
function classes_content_field_edit_form_validate($form, &$form_state) {
  $type = $form['#field']['type_name'];
  $field = $form['#field']['field_name'];
  $property = &$form_state['values']['property'];
  $properties = classes_get_cck_fields($type);
  classes_property_name_validate($type, $field, $property, 'property', $properties);
}

/**
 * Custom submit handler for content_field_edit_form.
 * Update the property name if set, and update the class file for this content
 * type if requested.
 *
 * @param array $form
 * @param array $form_state
 */
function classes_content_field_edit_form_submit($form, &$form_state) {
  // Save the property name:
  $property = $form_state['values']['property'];
  $field = $form['#field']['field_name'];
  $type = $form['#field']['type_name'];
  $sql = "
    UPDATE {content_node_field_instance}
    SET property_name = '%s'
    WHERE field_name = '%s' AND type_name = '%s'";
  db_query($sql, $property, $field, $type);

  // Update the classes for this content type if requested:
  if ($form_state['values']['generate']) {
    classes_update_type_classes($type);
  }
}


////////////////////////////////////////////////////////////////////////////////
// content_field_remove_form

/**
 * Implementation of hook_form_alter().
 *
 * @param array $form
 * @param array $form_state
 */
function classes_form_content_field_remove_form_alter(&$form, $form_state) {
  // This form appears after selecting "Remove" on the "Manage Fields" page.

  // Get the content type and check class existence:
  $type = $form['type_name']['#value'];
  $exists = classes_check_existence($type);

  if ($exists['base class']['exists']) {
    // Show class settings:
    $form['classes_settings'] = array(
      '#type' => 'fieldset',
      '#type' => t("Classes settings"),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
      '#weight' => 100,
    );

    // Checkbox for regenerating class:
    $form['generate'] = classes_generate_checkbox($exists, t("After removing the field: "));

    // Custom submit handler:
    $form['#submit'][] = 'classes_content_field_remove_form_submit';
  }

}

/**
 * Custom submit handler for content_field_remove_form.
 * Update the class file for this content type, if requested.
 *
 * @param array $form
 * @param array $form_state
 */
function classes_content_field_remove_form_submit($form, &$form_state) {
  // Update the classes for this content type if requested:
  if ($form_state['values']['generate']) {
    $type = $form['type_name']['#value'];
    classes_update_type_classes($type);
  }
}
