<?php

/**
 * Page to display any inconsistencies between the class and property names in
 * the classes and those in the database.
 */
function classes_consistency_check() {
  // Make sure the node_type and content_node_field_instance table have the
  // extra columns, and that any unset class and property names are
  // initialised to the default.
  classes_set_default_names();

  // Get all the class names and locations:
  $class_paths = classes_paths();

  // Array to contain results:
  $results = array();

  // Scan the content types:
  $sql = "
    SELECT *
    FROM {node_type}
    ORDER BY type";
  $rs = db_query($sql);
  while ($rec = db_fetch_array($rs)) {
    $content_type = $rec['type'];
    $class = $rec['class_name'];

    // Initialise the results array for this content type:
    $results[$content_type] = array(
      'db' => $class,
      'msg' => 'OK',
      'fields' => array(),
    );

    // Look for the class with a matching content type:
    $class_found = FALSE;
    foreach ($class_paths as $class2 => $path) {

      // Only check content type classes:
      if (endsWith($class2, 'Base') || !is_subclass_of($class2, 'XNode')) {
        continue;
      }

      // Get the content type in this class:
      $content_type2 = call_user_func_array(array($class2, 'getContentType'), array());

      if ($content_type == $content_type2) {
        $class_found = TRUE;

        // Check that the class names match:
        $class_names_match = $class == $class2;

        $results[$content_type]['file'] = $class2;

        // No need to keep looking:
        break;
      }
    } // foreach

    if (!$class_found) {
      $results[$content_type]['msg'] = t("Class file not found.") . ' (' . l('fix', 'admin/settings/classes/generate') . ')';
      $results[$content_type]['status'] = 'warning';
    }
    else {
      if (!$class_names_match) {
        $results[$content_type]['msg'] = t("Class names don't match.") . ' (' . l('fix', 'admin/settings/classes/names') . ')';
        $results[$content_type]['status'] = 'error';
      }

      // Get the properties in the matching class:
      $properties = XEntityBase::getPropertyInfo($class2);

      $results[$content_type]['fields'] = array();

      // Link for fixing property names for this content type:
      $fix_link = l('fix', 'admin/content/node-type/' . str_replace('_', '-', $content_type) . '/properties');

      // Check for consistency with the property names for this type.
      $fields = classes_get_cck_fields($content_type);
      foreach ($fields as $field => $field_info) {
        $field = $field_info['field'];
        $property = $field_info['property'];

        $results[$content_type]['fields'][$field] = array(
          'db' => $property,
          'msg' => 'OK',
        );

        $field_found = FALSE;
        foreach ($properties as $property2 => $info) {

          if ($field == $info['field']) {
            $field_found = TRUE;
            $property_names_match = $property == $property2;

            $results[$content_type]['fields'][$field]['file'] = $property2;
            $results[$content_type]['fields'][$field]['ok'] = $property_names_match;

            if (!$property_names_match) {

              $results[$content_type]['fields'][$field]['msg'] = t("Property names don't match.") . " ($fix_link)";
              $results[$content_type]['fields'][$field]['status'] = 'error';
            }

            break;
          }

        } // foreach

        if (!$field_found) {
          $results[$content_type]['fields'][$field]['msg'] = t("Property not found.") . " ($fix_link)";
          $results[$content_type]['fields'][$field]['status'] = 'error';
        }
      }
    }
  }

  // Include the CSS:
  $path = drupal_get_path('module', 'classes');
  drupal_add_css("$path/classes.css");

  // Generate the HTML:
  $header = array("Content type/field", "Class/property name in database", "Class/property name in class file", "Status");
  foreach ($results as $content_type => $result) {

    // Row for content type/class names:
    $rows[] = array(
      'class' => 'type ' . $result['status'],
      'data' => array($content_type, $result['db'], $result['file'], $result['msg']),
    );

    // Provide a link to the property names page for this content type:
    $result2['msg'] .= ' (' . l('admin/settings/classes/names', 'fix') . ')';

    // Row for field/property names:
    foreach ($result['fields'] as $field => $result2) {

      $rows[] = array(
        'class' => 'field ' . $result2['status'],
        'data' => array($field, $result2['db'], $result2['file'], $result2['msg']),
      );
    }
  }

  $html = "<div>" .
    t("The messages in yellow are warnings, and may not be important.") .
    " " . t("Any messages in red indicate errors and inconsistencies between the class and property names in your database and those in your class files.") .
    " " . t("These problems can be fixed by updating the class and property names, or by regenerating the class files (or both).") .
    "</div>";

  $html .= theme('table', $header, $rows, array('id' => 'classes-consistency-check'));
  return $html;
}

/**
 * Generate files describing the content types on dev and production, so they
 * can be compared for differences.
 *
 * ** CAUTION **
 * Before running this script, dump the node_type, content_node_field and
 * content_node_field_instance tables from the production server, and recreate
 * them in the development system with the prefix "prod_". Obviously BE CAREFUL
 * and don't wax your development tables.
 */
function classes_diff() {
  $report = "";

  //////////////////////////////////////////////////////////////////////////////
  // node_type table
  $report .= "Comparing node-type tables\n";
  $report .= "==========================\n\n";

  // Look for types present in dev but missing in prod.
  $missing = array();
  $sql = "
    SELECT *
    FROM {node_type}
    ORDER BY type";
  $rs = db_query($sql);
  while ($rec = db_fetch_array($rs)) {
    $type = $rec['type'];
    // Get the corresponding record from the production table:
    $sql2 = "
      SELECT *
      FROM prod_node_type
      WHERE type = '%s'";
    $rec2 = db_fetch_array(db_query($sql2, $type));
    if ($rec2) {
      // Look for differences between the types:
      if ($rec != $rec2) {
        $report .= "Difference found for content type $type.\n\n";
        foreach ($rec as $key => $value) {
          if ($value != $rec2[$key]) {
            $report .= "  $key on dev database = $value\n";
            $report .= "  $key on prod database = {$rec2[$key]}\n\n";
          }
        }
      }
    }
    else {
      $missing[] = $type;
    }
  }
  if (!empty($missing)) {
    $report .= "\nThe following types are present in the dev DB but missing in prod:\n\n";
    foreach ($missing as $type) {
      $report .= "  $type\n";
    }
  }

  // Look for types present in production but missing in dev.
  $missing = array();
  $sql = "
    SELECT *
    FROM prod_node_type
    ORDER BY type";
  $rs = db_query($sql);
  while ($rec = db_fetch_array($rs)) {
    $type = $rec['type'];
    // Get the corresponding record from the production table:
    $sql2 = "
      SELECT *
      FROM {node_type}
      WHERE type = '%s'";
    $rec2 = db_fetch_array(db_query($sql2, $type));
    if (!$rec2) {
      $missing[] = $type;
    }
  }
  if (!empty($missing)) {
    $report .= "\nThe following types are present in the prod DB but missing in dev:\n\n";
    foreach ($missing as $type) {
      $report .= "  $type\n";
    }
  }


  //////////////////////////////////////////////////////////////////////////////
  // content_node_field table
  $report .= "\n\n\n";
  $report .= "Comparing content_node_field tables\n";
  $report .= "===================================\n\n";

  // Look for CCK fields present in dev but missing in prod.
  $missing = array();
  $sql = "
    SELECT *
    FROM {content_node_field}
    ORDER BY field_name";
  $rs = db_query($sql);
  while ($rec = db_fetch_array($rs)) {
    $field = $rec['field_name'];
    // Get the corresponding record from the production table:
    $sql2 = "
      SELECT *
      FROM prod_content_node_field
      WHERE field_name = '%s'";
    $rec2 = db_fetch_array(db_query($sql2, $field));
    if ($rec2) {
      // Look for differences between the types:
      if ($rec != $rec2) {
        $report .= "Difference found for CCK field $field.\n\n";
        foreach ($rec as $key => $value) {
          if ($value != $rec2[$key]) {
            $report .= "  $key on dev database = $value\n";
            $report .= "  $key on prod database = {$rec2[$key]}\n\n";
          }
        }
      }
    }
    else {
      $missing[] = $field;
    }
  }
  if (!empty($missing)) {
    $report .= "\nThe following CCK fields are present in the dev DB but missing in prod:\n\n";
    foreach ($missing as $field) {
      $report .= "  $field\n";
    }
  }

  // Look for CCK fields present in production but missing in dev.
  $missing = array();
  $sql = "
    SELECT *
    FROM prod_content_node_field
    ORDER BY field_name";
  $rs = db_query($sql);
  while ($rec = db_fetch_array($rs)) {
    $field = $rec['field_name'];
    // Get the corresponding record from the production table:
    $sql2 = "
      SELECT *
      FROM {content_node_field}
      WHERE field_name = '%s'";
    $rec2 = db_fetch_array(db_query($sql2, $field));
    if (!$rec2) {
      $missing[] = $field;
    }
  }
  if (!empty($missing)) {
    $report .= "\nThe following CCK fields are present in the prod DB but missing in dev:\n\n";
    foreach ($missing as $field) {
      $report .= "  $field\n";
    }
  }

  //////////////////////////////////////////////////////////////////////////////
  // content_node_field_instance table
  $report .= "\n\n\n";
  $report .= "Comparing content_node_field_instance tables\n";
  $report .= "============================================\n\n";

  // Look for CCK fields present in dev but missing in prod.
  $missing = array();
  $sql = "
    SELECT *
    FROM {content_node_field_instance}
    ORDER BY type_name, field_name";
  $rs = db_query($sql);
  while ($rec = db_fetch_array($rs)) {
    $type = $rec['type_name'];
    $field = $rec['field_name'];
    // Get the corresponding record from the production table:
    $sql2 = "
      SELECT *
      FROM prod_content_node_field_instance
      WHERE type_name = '%s' AND field_name = '%s'";
    $rec2 = db_fetch_array(db_query($sql2, $type, $field));
    if ($rec2) {
      // Look for differences between the types:
      if ($rec != $rec2) {
        $report .= "Difference found for CCK field $field in content type $type.\n\n";
        foreach ($rec as $key => $value) {
          if ($value != $rec2[$key]) {
            $report .= "  $key on dev database = $value\n";
            $report .= "  $key on prod database = {$rec2[$key]}\n\n";
          }
        }
      }
    }
    else {
      $missing[] = "$type.$field";
    }
  }
  if (!empty($missing)) {
    $report .= "\nThe following CCK field instances are present in the dev DB but missing in prod:\n\n";
    foreach ($missing as $field) {
      $report .= "  $field\n";
    }
  }

  // Look for CCK fields present in production but missing in dev.
  $missing = array();
  $sql = "
    SELECT *
    FROM prod_content_node_field_instance
    ORDER BY type_name, field_name";
  $rs = db_query($sql);
  while ($rec = db_fetch_array($rs)) {
    $type = $rec['type_name'];
    $field = $rec['field_name'];
    // Get the corresponding record from the production table:
    $sql2 = "
      SELECT *
      FROM {content_node_field_instance}
      WHERE type_name = '%s' AND field_name = '%s'";
    $rec2 = db_fetch_array(db_query($sql2, $type, $field));
    if (!$rec2) {
      $missing[] = "$type.$field";
    }
  }
  if (!empty($missing)) {
    $report .= "\nThe following CCK field instances are present in the prod DB but missing in dev:\n\n";
    foreach ($missing as $field) {
      $report .= "  $field\n";
    }
  }

  // Output report:
  $path = drupal_get_path('module', 'classes') . "/content-types-diff.txt";
  file_put_contents($path, $report);
  echo "<pre>$report</pre>";
}
