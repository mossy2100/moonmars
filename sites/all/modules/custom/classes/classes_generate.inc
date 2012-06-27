<?php
// $Id$

/**
 * @file
 * Functions for generating class files.
 */

/**
 * Determine the property type from a field or schema type.
 *
 * @param string $field_type
 * @return string
 */
function classes_get_property_type($field_type) {
  switch ($field_type) {
    case 'int':
    case 'serial':
    case 'number_integer':
      return 'int';

    case 'float':
    case 'numeric':
    case 'decimal':
    case 'number_float':
    case 'number_decimal':
      return 'float';

    case 'string':
    case 'char':
    case 'varchar':
    case 'text':
      return 'string';

    case 'timestamp':
      return 'XDateTime';

    case 'date':
    case 'datetime':
    case 'datestamp':
      return 'XDateTimeRange';

    case 'nodereference':
      return 'XNode';

    case 'userreference':
      return 'XUser';

    case 'content_taxonomy':
      return 'XTerm';

    case 'filefield':
      return 'XFile';

    case 'location':
      return 'XLocation';

    case 'link':
      return 'XLink';

    case 'array':
    default:
      return 'array';
  }
}


////////////////////////////////////////////////////////////////////////////////
// Functions for generating entity class files.

/**
 * Generate code related to the properties of the given entity's class.
 * Properties are determined from fields in the database tables used by this
 * entity.
 * The code includes property information, property declarations, and accessor
 * (getter) and mutator (setter) methods.
 *
 * @param string $tables
 * @return string
 */
function classes_generate_entity_properties($entity) {
  global $_classes_tpl_dir;

  // Get the tables for this entity:
  $entities = classes_entities();
  $entity_info = $entities[$entity];

  // Prepare an array of fields that have a column type of int but are really
  // timestamps, so that we can return XDateTime objects instead. (This is
  // a workaround. Those columns should have been datetimes or timestamps.)
  $datetime_fields = array(
    'node' => array('created', 'changed'),
    'node_revisions' => array('timestamp'),
    'users' => array('created', 'access', 'login'),
    'files' => array('timestamp'),
  );

  // Construct an array of field names with their types:
  $properties = array();
  $tables = $entity_info['tables'];
  $entity_len = strlen($entity);
  if (!empty($tables)) {
    foreach ($tables as $table) {

      // Get the table schema:
      $schema = drupal_get_schema($table);

      // Loop through the table fields, generating properties:
      foreach ($schema['fields'] as $field => $info) {

        // Rename a couple of revision fields as in node_load().
        if ($table == 'node_revisions' && ($field == 'timestamp' || $field == 'uid')) {
          $field = "revision_$field";
        }

        // If the field name starts with the entity name (e.g. 'file_path' or
        // 'filepath'), remove it:
        if (substr($field, 0, $entity_len + 1) == $entity . '_') {
          $property = substr($field, $entity_len + 1);
        }
        elseif (substr($field, 0, $entity_len) == $entity) {
          $property = substr($field, $entity_len);
        }
        else {
          $property = $field;
        }

        // Convert property name to camelCase:
        $property = classes_convert_case($property, CLASSES_LOWER_CASE, CLASSES_CAMEL_CASE);

        // Check that we don't already have a property with this name:
        if (array_key_exists($property, $properties)) {
          continue;
        }

        // Get the type:
        if (isset($datetime_fields[$table]) && in_array($field, $datetime_fields[$table])) {
          $property_type = 'XDateTime';
        }
        else {
          $property_type = classes_get_property_type($info['type']);
        }

        // Add property into to array:
        $properties[$property] = array(
          'field' => $field,
          'source' => $table,
          'type' => $property_type,
        );
      }
    }
  }

  // Add any additional CCK fields:
  $cck = $entity_info['cck'];
  if (!empty($cck)) {
    foreach ($cck as $field => $type) {
      // Convert to camelCase:
      $property = classes_convert_case($field, CLASSES_LOWER_CASE, CLASSES_CAMEL_CASE);

      // Check that we don't already have a property with this name:
      if (array_key_exists($property, $properties)) {
        continue;
      }

      // Add property into to array:
      $properties[$property] = array(
        'field' => $field,
        'source' => 'cck',
        'type' => $type,
      );
    }
  }

  // Generate the property and getter and setter code.
  $getters_setters = '';
  $property_info = array();
  foreach ($properties as $property => $info) {

    $property_type = classes_get_property_type($info['type']);

    // Set template vars:
    $vars = array(
      'property' => $property,
      'field' => $info['field'],
      'function' => ucfirst($property),
      'property_type' => $multiple ? 'array' : $property_type,
      'ref' => $info['type'] == 'array' ? '&' : '',
      'var' => classes_convert_case($property, CLASSES_CAMEL_CASE, CLASSES_LOWER_CASE),
    );

    // Generate getter and setter methods:
    if (!in_array($property, $entity_info['custom']['get'])) {
      $getters_setters .= classes_render_template("$_classes_tpl_dir/getter.tpl.php", $vars);
    }
    if (!in_array($property, $entity_info['custom']['set'])) {
      $getters_setters .= classes_render_template("$_classes_tpl_dir/setter.tpl.php", $vars);
    }

    // Remember the property info:
    $property_info[$property] = array(
      'field' => $info['field'],
      'source' => $info['source'],
      'type' => $info['type'],
      'multiple' => FALSE,
    );
  }

  return array(
    'property_info' => $property_info,
    'getters_setters' => $getters_setters,
  );
}

/**
 * Generate an entity base class.
 *
 * @param string $entity
 *   The entity that we want to generate a base class for.
 * @return array
 *   Array of classes generated.
 */
function classes_generate_entity_base_class($entity) {
  global $_classes_tpl_dir, $_classes_dir;

  // Get the source and destination paths:
  $base_class = classes_entity_class_name($entity) . 'Base';
  $src = "$_classes_tpl_dir/$base_class.tpl.php";
  $dst = "$_classes_dir/entities/base/$base_class.class.php";

  // Generate the properties and getters and setters for all node and revision
  // fields:
  $vars = classes_generate_entity_properties($entity);
  $vars['property_info'] = classes_format_array($vars['property_info'], 2);
  $vars['dt_generated'] = date(DATE_FORMAT_DATETIME);

  // Generate the class code:
  $code = classes_render_template($src, $vars);

  // Output the base class file:
  $result = file_put_contents($dst, $code) ? array($base_class => $dst) : array();

  // Return the generated class name and path:
  return $result;
}

/**
 * Generate base and derived classes for an entity.
 * A stub for the derived class will only ever be generated if it doesn't
 * already exists, so that any methods added by the developer can't be
 * accidentally over-written.
 *
 * @param string $entity
 *   The entity name, e.g. 'node', 'user', 'term'.
 * @return array
 *   Array of generated class names.
 */
function classes_generate_entity_classes($entity) {
  // Generate the base class:
  $classes = classes_generate_entity_base_class($entity);

  // If a stub for the derived class has not been generated yet, do it now:
  if ($class = classes_generate_class_stub($entity, 'entities')) {
    $classes = array_merge($classes, $class);
  }

  return $classes;
}


////////////////////////////////////////////////////////////////////////////////
// Functions for generating content type class files.

/**
 * Generate (or regenerate) the base class file for a given content type.
 *
 * @param $type
 * @return string
 *   The generated class name.
 */
function classes_generate_type_base_class($type) {
  global $_classes_tpl_dir, $_classes_dir;

  // Get the class names:
  $class = classes_type_class_name($type);
  $base_class = $class . "Base";

  // Generate the base class:
  $vars = array(
    'type' => $type,
    'base_class' => $base_class,
    'class' => $class,
    'dt_generated' => date(DATE_FORMAT_DATETIME),
  );

  // Initialize template variables:
  $getters_setters = '';
  $property_info = array();

  // Get the fields in this content type:
  //    SELECT *
  //    FROM {content_node_field_instance} cnfi
  //      LEFT JOIN {content_node_field} cnf USING (field_name)
  //    WHERE type_name = '%s'
  //    ORDER BY weight";

  $fields = classes_get_cck_fields($type);
  foreach ($fields as $field => $field_info) {
    // If the property_name field hasn't been added to the
    // content_node_field_instance table then do it now:
    if (!isset($field_info['property'])) {
      classes_set_default_property_names();
    }

    if ($field_info['property']) {
      $property = $field_info['property'];
    }
    else {
      // If the property name for this field isn't set, use the default. The
      // user can always update this and regenerate the class if they want.
      $property = classes_default_property_name($field_info['field'], $field_info['content_type']);
      // Update the record with the default property name:
      $sql = "
        UPDATE {content_node_field_instance}
        SET property_name = '%s'
        WHERE field_name = '%s' AND type_name = '%s'";
      db_query($sql, $property, $field_info['field'], $type);
    }

    $field = $field_info['field'];
    $multiple = (bool) $field_info['multiple'];

    $vars['field'] = $field;
    $vars['property'] = $property;
    $vars['ref']  = $multiple ? '&' : '';
    $vars['var'] = classes_convert_case($property, CLASSES_CAMEL_CASE, CLASSES_LOWER_CASE);
    $vars['function'] = ucfirst($property);

    $property_type = classes_get_property_type($field_info['field_type']);

    // If a node reference, get the class of the reference content type.
    if ($field_info['module'] == 'nodereference') {
      // $property_type will already be set to XNode, which means the class used
      // will be determined from the content type. However, if nodes of only one
      // type can be referenced, then we get its class. Doing this saves us from
      // having to look up the type of a node when creating XNode objects.

      // Find out the referenceable type:
      if (is_array($field_info['global_settings']['referenceable_types'])) {
        $referenceable_types = array_values(array_filter($field_info['global_settings']['referenceable_types']));
        // We can only specify the class of the referenced nodes if there's only
        // 1 referenceable type:
        if (count($referenceable_types) == 1) {
          $property_type = classes_type_class_name($referenceable_types[0]);
        }
      }
    }

    // Remember the property info:
    $property_info[$property] = array(
      'field' => $field,
      'source' => 'content',
      'type' => $property_type,
      'multiple' => $multiple,
    );

    // Set the property type for the getter and setter methods. If a
    // multiple-value property, then this will be array.
    $vars['property_type'] = $multiple ? 'array' : $property_type;

    // Include prefix and suffix if set:
    if ($field_info['global_settings']['prefix']) {
      $property_info[$property]['prefix'] = $field_info['global_settings']['prefix'];
    }
    if ($field_info['global_settings']['suffix']) {
      $property_info[$property]['suffix'] = $field_info['global_settings']['suffix'];
    }

    // Generate the getter and setter methods:
    $getters_setters .= classes_render_template("$_classes_tpl_dir/getter.tpl.php", $vars);
    $getters_setters .= classes_render_template("$_classes_tpl_dir/setter.tpl.php", $vars);

  } // while

  // Get locations fields:
  $settings = variable_get('location_settings_node_' . $type, NULL);
  if ($settings && $settings['multiple']['max'] > 0) {

    if ($settings['multiple']['max'] == 1) {
      // Maximum 1 location:
      $property = 'location';
      $multiple = FALSE;
    }
    else {
      // Multiple locations possible, so make it an array:
      $property = 'locations';
      $multiple = TRUE;
    }

    // Generate the property text:
    $vars['field'] = 'locations';
    $vars['property_type'] = $multiple ? 'array' : 'XLocation';
    $vars['multiple'] = $multiple;
    $vars['property'] = $property;
    $vars['function'] = ucfirst($property);
    $vars['ref']  = $multiple ? '&' : '';
    $vars['var'] = classes_convert_case($property, CLASSES_CAMEL_CASE, CLASSES_LOWER_CASE);

    // Generate the getter and setter methods:
    $getters_setters .= classes_render_template("$_classes_tpl_dir/getter.tpl.php", $vars);
    $getters_setters .= classes_render_template("$_classes_tpl_dir/setter.tpl.php", $vars);

    // Add the property info:
    $property_info[$property] = array(
      'field' => 'locations',
      'source' => 'locations',
      'type' => 'XLocation',
      'multiple' => $multiple,
    );
  }

  // Generate the fields array:
  $vars['property_info'] = classes_format_array($property_info, 2);

  // Copy template variables:
  $vars['getters_setters'] = $getters_setters;

  // Generate the class code:
  $class_code = classes_render_template("$_classes_tpl_dir/TypeBase.tpl.php", $vars);

  // Output the base class:
  $path = "$_classes_dir/types/base/$base_class.class.php";

  if (file_put_contents($path, $class_code)) {
    return array($base_class => $path);
  }

  // Can't output the source file. This has to be dealt with or the module
  // won't work, so treat as an error.
  $msg = t("Could not create file %path.", array('%path' => $path));
  trigger_error($msg, E_USER_ERROR);
  drupal_set_message($msg, 'error');

  // Return an empty array, since no class files were written.
  return array();
}

/**
 * Update the base class for a content type (so it's up-to-date) and also create
 * the class stub for the derived class if not present.
 *
 * @param $type
 */
function classes_generate_type_classes($type) {
  // Generate the base class:
  $classes = classes_generate_type_base_class($type);

  // If a stub for the derived class has not been generated yet, do it now:
  if ($class = classes_generate_class_stub($type, 'types')) {
    $classes = array_merge($classes, $class);
  }

  return $classes;
}


////////////////////////////////////////////////////////////////////////////////
// Other functions for generating class files.

/**
 * Generate a class stub for a derived class, if it doesn't already exist.
 *
 * @param string $type
 *   The content type.
 * @param string $category
 *   Should be 'entities' or 'types'.
 * @return array
 *   A map with class name and path.
 */
function classes_generate_class_stub($type, $category = 'types') {
  global $_classes_tpl_dir, $_classes_dir;

  // Normalize $category parameter:
  $entity = in_array(strtolower($category), array('entities', 'entity'));
  $category = $entity ? CLASSES_CATEGORY_ENTITIES : CLASSES_CATEGORY_TYPES;

  $class = classes_class_name($type, $category);
  $path = "$_classes_dir/$category/$class.class.php";

  if (file_exists($path)) {
    // We don't want to overwrite it, so we're done:
    return array();
  }

  $vars = array(
    'type' => $type,
    'base_class' => $class . 'Base',
    'class' => $class,
    'dt_generated' => date(DATE_FORMAT_DATETIME),
  );

  // If there's a specific template to copy, use it, otherwise use the Stub
  // template:
  $tpl = "$_classes_tpl_dir/$class.tpl.php";
  if (!file_exists($tpl)) {
    $tpl = "$_classes_tpl_dir/Stub.tpl.php";
  }

  // Generate the stub from the template:
  $class_stub = classes_render_template($tpl, $vars);

  // Save the class file:
  $result = file_put_contents($path, $class_stub);

  // Return the class name and path:
  return $result ? array($class => $path) : array();
}

/**
 * Generate a helper class.
 *
 * @param string $class
 * @param bool $force
 *   If TRUE, the class will definitely be copied without checking file mod times.
 * @return array
 */
function classes_generate_helper_class($class, $force = FALSE) {
  global $_classes_dir;

  // Get source and destination paths for copying:
  $src = DRUPAL_ROOT . '/' . drupal_get_path('module', 'classes') . "/templates/$class.tpl.php";
  $dst = "$_classes_dir/helper/$class.class.php";

  $classes_generated = array();

  // If the destination file already exists, only overwrite if the source file
  // has a later modification date. If it doesn't exist then generate it.
  if ($force || !file_exists($dst) || filemtime($src) > filemtime($dst)) {

    // Generate the helper class:
    $vars = array(
      'dt_generated' => date(DATE_FORMAT_DATETIME),
    );
    $class_code = classes_render_template($src, $vars);

    // Save the class file:
    $result = file_put_contents($dst, $class_code);

    if ($result) {
      $classes_generated[$class] = $dst;
    }
  }

  // Return generated class:
  return $classes_generated;
}
