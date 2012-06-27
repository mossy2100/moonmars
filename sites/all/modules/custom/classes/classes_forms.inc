<?php

/**
 * @file
 * This file contains helper functions used by forms.
 */

/**
 * Return a FAPI checkbox for a form.
 *
 * @param array $exists
 *   This array is obtained by calling classes_check_existence().
 * @param string $prefix
 *   Appended to the start of the label.
 * @param bool $include_class_names
 * @return array
 */
function classes_generate_checkbox($exists, $prefix = '', $include_class_names = TRUE) {
  // Determine the label:
  if ($include_class_names) {
    $label = $exists['base class']['exists'] ?
      t("Regenerate class %base_class", array('%base_class' => $exists['base class']['name'])) :
      t("Generate class %base_class", array('%base_class' => $exists['base class']['name']));
    if (!$exists['class']['exists']) {
      $label .= t(" and generate a stub for class %class", array('%class' => $exists['class']['name']));
    }
  }
  else {
    $label = t("Generate the base class, and a stub for the derived class if it doesn't already exist.");
  }

  // Prepend the prefix:
  $label = $prefix . $label . '.';

  // FAPI checkbox array:
  return array(
    '#type' => 'checkbox',
    '#title' => $label,
    '#default_value' => FALSE,
  );
}

/**
 * Universal validation function for property names.
 *
 * @param string $field
 *   The CCK field.
 * @param string $property
 *   The entered property name being checked.
 * @param string $error_field
 *   The form element of the property name.
 * @param array $properties
 *   The known property names for this content type.
 */
function classes_property_name_validate($type, $field, &$property, $error_field, $properties) {
  $property = trim($property);

  // Check that the property name is not blank:
  if ($property == '') {
    form_set_error($error_field, t("A property name is required for the %field field.", array('%field' => $field)));
  }

  // Check that the property name is a valid identifier:
  if (!classes_valid_identifier($property)) {
    form_set_error($error_field, t("Property names must begin with a letter and only contain letters, digits and underscores."));
  }

  // Check that the property name is not reserved:
  $reserved = classes_reserved_properties($type);
  if (in_array($property, $reserved)) {
    form_set_error($error_field, t("The property name %property is reserved.", array('%property' => $property)));
  }

  // Check that the property name is not a duplicate:
  unset($properties[$field]);
  foreach ($properties as $field => $info) {
    if ($info['property'] == $property) {
      form_set_error($error_field, t("Property names must be unique."));
      break;
    }
  }
}

/**
 * Universal validation function for class names.
 *
 * @param string $type
 *   The content type.
 * @param string $class
 *   The class name being checked.
 * @param string $error_field
 *   The name of the form element being checked.
 * @param array $classes
 *   The names of all the known content type classes.
 */
function classes_class_name_validate($type, $class, $error_field, $classes) {
  // Check the class name is not blank:
  if ($class == '') {
    form_set_error($error_field, t("A class name is required for the %type content type.", array('%type' => $type)));
  }

  // Check that the class name is valid PHP:
  if (!classes_valid_identifier($class)) {
    form_set_error($error_field, t("Class names must begin with a letter and only contain letters, digits and underscores."));
  }

  // Check that the class name is not restricted:
  $restricted = classes_entity_class_names();
  if (in_array($class, $restricted)) {
    form_set_error($error_field, t("The class name %name is reserved.", array('%name' => $class)));
  }

  // Check that the class name is not a duplicate:
  foreach ($classes as $type2 => $class_info) {
    if ($type2 != $type && $class_info['class_name'] == $class) {
      form_set_error($error_field, t("Class names must be unique. The name %class is currently used by the content type %type.", array('%class' => $class, '%type' => $type2)));
      break;
    }
  }
}
