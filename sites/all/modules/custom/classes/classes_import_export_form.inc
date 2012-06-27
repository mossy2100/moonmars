<?php
// $Id$

/**
 * @file
 * Contains functions specifically related to the Class names form.
 */

/**
 * Create the form for importing and exporting of class and property names.
 *
 * @param array $form_state
 * @return array
 */
function classes_import_export_form($form_state, $type) {
  $form = array();
  
  // Import:
  $form['import'] = array(
    '#type' => 'fieldset',
    '#title' => t("Import class and property names."),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
    '#description' => t("Paste the text here that describes the class and property names. This looks like a serialised PHP array and will probably come from the export textbox (below) on another site. Then click the Import button."),
  );
  
  $form['import']['import_text'] = array(
    '#type' => 'textarea',
    '#rows' => 10,
    '#wysiwyg' => FALSE,
  );
  
  $form['import']['import_btn'] = array(
    '#type' => 'submit',
    '#value' => t('Import'),
  );
  
  // Export:
  $form['export'] = array(
    '#type' => 'fieldset',
    '#title' => t("Export class and property names."),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
    '#description' => t("The code below describes all the class and property names on this site. It can be pasted into the import textbox (above) on another site."),
  );
  
  $form['export']['export_text'] = array(
    '#type' => 'textarea',
    '#rows' => 10,
    '#value' => serialize(classes_export_names()),
    '#wysiwyg' => FALSE,
  );
  
  return $form;
}

/**
 * Submit handler for classes_import_export_form().
 *
 * @param array $form
 * @param array $form_state
 */
function classes_import_export_form_submit($form, &$form_state) {
  $names = unserialize($form_state['values']['import_text']);
  
  if (!is_array($names)) {
    form_set_error('import_text', t("The pasted text was invalid."));
  }
  else {

    // Make sure the node_type and content_node_field_instance table have the
    // extra columns, and that any unset class and property names are
    // initialised to the default.
    classes_set_default_names();
    
    // Loop through the provided array of names:
    foreach ($names as $type => $info) {
      
      // Update the class name:
      $class = $info['class'];
      $sql = "UPDATE {node_type} SET class_name = '%s' WHERE type = '%s'";
      db_query($sql, $info['class'], $type);
      if (db_affected_rows()) {
        drupal_set_message(t("The class name for the content type %type has been set to %class.", array('%type' => $type, '%class' => $class)));
      }
      else {
        drupal_set_message(t("Content type %type not found.", array('%type' => $type)));
      }
      
      // Update the properties:
      if (is_array($info['properties']) && !empty($info['properties'])) {
        foreach ($info['properties'] as $field => $property) {
          $sql = "
            UPDATE {content_node_field_instance} SET
              property_name = '%s'
            WHERE field_name = '%s' AND type_name = '%s'";
          db_query($sql, $property, $field, $type);
          if (db_affected_rows()) {
            drupal_set_message(t("The property name for the field %field in the content type %type has been set to %property.", array('%field' => $field, '%type' => $type, '%property' => $property)));
           }
          else {
            drupal_set_message(t("The field %field was not found in the content type %type.", array('%field' => $field, '%type' => $type)));
          }
        }
      }
    }
    
    // Tell the user:
    drupal_set_message(t("The class and property names were successfully updated."));
  }
}

/**
 * Get all the class and property names as an array.
 * 
 * @return array
 */
function classes_export_names() {
  $class_info = array();
  $sql = "
    SELECT type, class_name
    FROM {node_type}
    ORDER BY name";
  $rs = db_query($sql);
  while ($rec = db_fetch_array($rs)) {
    // Create the array for this type:
    $class_info[$rec['type']] = array();
    $class_info[$rec['type']]['class'] = $rec['class_name'];
    $class_info[$rec['type']]['properties'] = array();
    
    // Get the property names:
    $sql2 = "
      SELECT field_name, property_name
      FROM {content_node_field_instance}
      WHERE type_name = '%s'
      ORDER BY field_name";
    $rs2 = db_query($sql2, $rec['type']);
    while ($rec2 = db_fetch_array($rs2)) {
      $class_info[$rec['type']]['properties'][$rec2['field_name']] = $rec2['property_name'];
    }
  }
  
  return $class_info;
}
