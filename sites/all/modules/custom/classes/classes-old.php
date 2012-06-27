<?php


/// Methods from Nodebase.tpl.php

  /**
   * Get a reference to a property corresponding to a CCK field.
   *
   * @param string $field
   * @return mixed
   */
  function &getPropertyRef($field) {
    // Get the name of the property matching this field:
    $info = $this->getFieldInfo($field);
    $property = $info['property'];

    // If the CCK field hasn't been converted to a property yet, do it now:
    if (!$this->propertySet[$property]) {
      // Convert the CCK field to an array:
      $values = $this->cckFieldToArray($field);

      // If this is a multiple value, we want the property to contain the array,
      // otherwise just the single value:
      $this->$property = $info['multiple'] ? $values : (empty($values) ? NULL : $values[0]);

      // Record that we've copied the values:
      $this->propertySet[$property] = TRUE;
    }

    return $this->$property;
  }

  /**
   * Get the value of a property corresponding to a CCK field.
   *
   * @param string $field
   * @return mixed
   */
  function getPropertyValue($field) {
    return $this->getPropertyRef($field);
  }

  /**
   * Set the value of a property.
   * If the property represents a multiple-value CCK field, then $value must be
   * an array.
   *
   * @param string $field
   * @param mixed $value
   * @return object
   *   The $this object.
   */
  function setProperty($field, $value) {
    // Get the name of the property matching this field:
    $info = $this->getFieldInfo($field);
    $property = $info['property'];

    // Ensure the value is an array:
    if ($info['multiple'] && !is_array($value)) {
      trigger_error(t("setProperty() expects an array when setting the value of the %field field.", array('%field' => $field)), E_USER_WARNING);
      return $this;
    }

    // Convert the provided values to the correct types/classes:
    if ($info['multiple']) {
      $property_values = array();
      foreach ($value as $item) {
        $property_values[] = classes_value_to_property($item, $info['type'], $info['ref_type']);
      }
      $this->$property = $property_values;
    }
    else {
      $this->$property = classes_value_to_property($value, $info['type'], $info['ref_type']);
    }

    // Record that we've set the property.
    $this->propertySet[$property] = TRUE;

    // Return the $this object se we can chain set methods if desired.
    return $this;
  }



// This HTML here was for when I was going to have edit-in-place for class names
// on the generate form.
$id = "class-name-$type";
$editable_name = "
  <div id='$id' class='classes-class-name'>
    <span>$class</span>
    <a href='javascript:editClassName(\"$id\")'>
      <img class='classes-edit-icon' src='/$path/images/editIcon.gif' />
    </a>
  </div>
  <div id='edit-$id' class='classes-edit-class-name'>
    <input value='$class' />
    <a href='javascript:saveClassName(\"$id\")'>
      <img class='classes-check-mark' src='/$path/images/checkMark.gif' />
    </a>
  </div>";

#classes-generate-form .classes-class-name,
#classes-generate-form .classes-edit-class-name {
  height: 18px;
}

#classes-generate-form .classes-class-name span {
  height: 14px;
  padding: 2px;
  margin: 0;
  display: block;
  float: left;
  width: 200px;
}

#classes-generate-form img.classes-edit-icon {
  margin: 1px;
  display: block;
  float: left;
  vertical-align: middle;
}

#classes-generate-form .classes-edit-class-name {
  display: none;
}

#classes-generate-form .classes-edit-class-name input {
  font-size: 11px;
  height: 14px;
  padding: 1px;
  border: solid 1px #ddd;
  margin: 0;
  display: block;
  float: left;
  width: 200px;
}


/**
 * Edit the class name for a type.
 */
function editClassName(id) {
  $('#' + id).hide();
  $('#edit-' + id).show();
}

/**
 * Save the class name for a type.
 */
function saveClassName(id) {
  var newClassName = $('#edit-' + id + ' input').val();
  $('#' + id + ' span').text(newClassName);
  $('#edit-' + id).hide();
  $('#' + id).show();
}


// From old property.tpl.php:

  /**
   * Property corresponding to the <field> field.
   *
   * @var <property_type>
   */
  protected $x_property;



/**
 * Find a rid and role name from the provided parameter.
 *
 * @param mixed $param
 * @return array
 */
function classes_find_role($param) {
  if (is_null($param)) {
    return NULL;
  }
  elseif (classes_is_int($param)) {
    // $param is a role id, look up the name:
    $rid = (int) $param;
    $name = db_result(db_query("SELECT name FROM {role} WHERE rid = %d", $rid));
  }
  elseif (is_string($param)) {
    // $param is a role name, look up the rid:
    $name = $param;
    $rid = (int) db_result(db_query("SELECT rid FROM {role} WHERE name = '%s'", $name));
  }
  elseif (is_object($param)) {
    $rid = (int) $param->rid;
    $name = (string) $param->name;
  }
  elseif (is_array($param)) {
    $rid = (int) $param['rid'];
    $name = (string) $param['name'];
  }

  // If we have a valid role, return it as an object:
  // @todo Make a Role class and return a Role object from here.
  if ($rid && $name) {
    $role = new stdClass();
    $role->rid = $rid;
    $role->name = $name;
    return $role;
  }

  // No valid role found:
  return NULL;
}
