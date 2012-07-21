<?php
// $Id$

/**
 * @file
 * Contains the XEntityBase class.
 */

/**
 * This abstract class defines and implements properties and methods common to
 * all database entitites, including create(), delete(), load(), save(), etc.
 *
 * It also implements the property overloading feature used by other classes
 * generated by the classes module. By implementing these methods we can provide
 * access to entity fields via virtual properties.
 *
 * So, you can use $obj->title instead of $obj->getTitle(),
 * or $obj->firstName = "Bob" instead of $obj->setFirstName("Bob")
 *
 * Virtual properties and accessor and mutator methods should always be in
 * camelCase in order to comply with Drupal coding standards.
 * @see http://drupal.org/coding-standards
 *
 * Note that the definition of "entity" used by the classes module may vary from
 * the Drupal 7 usage of this term. In D7 the term "entity" only applies to
 * nodes, users, terms, files and comments; however, the D6 version of the
 * classes module may refer to other things (e.g. locations) as entities also.
 *
 * @version <dt_generated>
 * @author shaunmoss
 */
abstract class XEntityBase {

  //////////////////////////////////////////////////////////////////////////////
  // Static properties.

  /**
   * Static array of property information.
   *
   * @var array
   */
  protected static $propertyInfo;

  /**
   * Whether or not to ignore errors.
   *
   * @var bool
   */
  public static $ignoreErrors = FALSE;


  //////////////////////////////////////////////////////////////////////////////
  // Instance properties.

  /**
   * The virtual properties.
   *
   * @var array
   */
  protected $properties = array();

  /**
   * An array to record which properties are set.
   *
   * @var array
   */
  protected $propertySet = array();

  /**
   * A reference to the Drupal entity (node, user, file, term, location, etc.)
   * that this object represents.
   *
   * @var array
   */
  protected $entity = NULL;

  /**
   * If an error occurs, store an error code in the object.
   *
   * @var int
   */
  protected $errorCode = CLASSES_ERROR_NONE;


  //////////////////////////////////////////////////////////////////////////////
  // Flags.

  /**
   * Is this a new entity?
   *
   * @var bool
   */
  protected $new = FALSE;

  /**
   * Has the entity been modified?
   *
   * @var bool
   */
  protected $dirty = FALSE;

  /**
   * Has the entity been loaded from the database?
   *
   * @var bool
   */
  protected $loaded = FALSE;


  //////////////////////////////////////////////////////////////////////////////
  // Overloading methods.

  /**
   * Provide support for getting virtual properties.
   *
   * For example, outside of any classes derived from this one (i.e. in your
   * application code), $page->title can be used instead of $page->getTitle().
   *
   * @param string $name
   * @return mixed
   */
  public function &__get($name) {
    $this->errorCode = CLASSES_ERROR_NONE;

    // Look for a matching 'get' method:
    // We have to do this first in case a derived class implements one.
    $method = 'get' . ucfirst($name);
    if (method_exists($this, $method)) {
      return $this->$method();
    }

    // Look for a matching 'is' method:
    $method = 'is' . ucfirst($name);
    if (method_exists($this, $method)) {
      return $this->$method();
    }

    // Look for a matching entity field. This is defensive programming, and will
    // allow the programmer to access entity fields as if the object was a
    // normal Drupal object.

    // Make sure the entity is fully loaded:
    $this->ensureLoaded();
    $this->getEntity();

    // Check that the entity has the requested field:
    if ($this->entity && property_exists($this->entity, $name)) {
      // Get the entity field:
      return $this->entity->$name;
    }

    // Unknown virtual property:
    $this->errorCode = CLASSES_ERROR_UNKNOWN_PROPERTY;
    // Report the error:
    if (!self::$ignoreErrors) {
      classes_error_property('get', $name, $this);
    }
    return NULL;
  }

  /**
   * Provide support for setting virtual properties.
   *
   * For example, outside of any classes derived from this one (i.e. in your
   * application code), $country->code = 'AU' can be used instead of
   * $country->setCode('AU').
   *
   * @param string $name
   * @param mixed $value
   * @return object
   */
  public function __set($name, $value) {
    $this->errorCode = CLASSES_ERROR_NONE;

    // Look for a matching 'set' method:
    // We have to do this first in case a derived class implements one.
    $method = 'set' . ucfirst($name);
    if (method_exists($this, $method)) {
      return $this->$method($value);
    }

    // Look for a matching entity field. This is defensive programming, and will
    // allow the programmer to access entity fields as if the object was a
    // normal Drupal object.

    // Make sure the entity is fully loaded:
    $this->ensureLoaded();
    $this->getEntity();

    // Check that the entity has the requested field:
    if ($this->entity && property_exists($this->entity, $name)) {
      // Set the entity field:
      $this->entity->$name = $value;

      // If this is a field that corresponds to a property, set the property
      // value as well.
      $info = $this->getFieldInfo($name);
      if ($info) {
        $this->setProperty($info['property'], $value);
      }

      return $this;
    }

    // Unknown virtual property:
    $this->errorCode = CLASSES_ERROR_UNKNOWN_PROPERTY;
    // Report the error:
    if (!self::$ignoreErrors) {
      classes_error_property('set', $name, $this);
    }
    return $this;
  }


  //////////////////////////////////////////////////////////////////////////////
  // Abstract methods.

  /**
   * Static factory method for creating new objects.
   *
   * Note that I haven't made this method abstract, because if I do then PHP
   * throws fatal errors when the number of parameters in the derived method
   * doesn't match. However, we sometimes want a different number of parameters
   * for the create method.
   *
   * @return object
   *   Or FALSE if there's any problem.
   */
  public static function create() {}

  /**
   * Static method for destroying objects.
   *
   * @param mixed $param
   */
  abstract public static function destroy($param);

  /**
   * Load the entity from the database.
   *
   * @return object
   */
  abstract public function load();

  /**
   * Save the entity to the database.
   *
   * The result will be one of:
   *   - SAVED_NEW (a new entity was saved successfully)
   *   - SAVED_UPDATED (an existing entity was saved successfully)
   *   - SAVED_NOT (the entity wasn't saved because it wasn't new or dirty)
   *   - FALSE (there was an error when trying to save the entity)
   *
   * @see SAVED_NEW
   * @see SAVED_UPDATED
   * @see SAVED_NOT
   * @see drupal_write_record
   *
   * @return int
   */
  abstract public function save();

  /**
   * Get the static object cache.
   *
   * @return array
   */
  abstract public static function getCache();

  /**
   * Clear the static object cache.
   */
  abstract public static function clearCache();

  /**
   * Checks if an XEntity is in the cache.
   *
   * @param mixed $entity
   * @return bool
   */
  abstract public static function inCache($entity);

  /**
   * Add the object to its class' cache.
   */
  abstract public function addToCache();


  //////////////////////////////////////////////////////////////////////////////
  // Core methods.

  /**
   * Instance method for deleting an object.
   */
  public function delete() {
    eval(get_class($this) . "::destroy(\$this);");
  }

  /**
   * Copies new fields from an object or array.
   *
   * Every field is copied, including ids. If the field already exists in the
   * associated entity then it won't be overwritten unless $overwrite == TRUE.
   *
   * @param mixed $object
   *   Can be an array or an object.
   * @param bool $overwrite
   *   If TRUE then existing set property values will be overwritten.
   * @return object
   *   Or FALSE if the parameter is invalid.
   */
  public function copy($object, $overwrite = FALSE) {
    // If the $entity is an array, convert to an object:
    if (is_array($object)) {
      $object = (object) $object;
    }

    // Check that we have an object:
    if (!is_object($object)) {
      return FALSE;
    }

    // If we have an XEntity, get its Drupal entity:
    if ($object instanceof XEntityBase) {
      $object = $object->getEntity();
    }

    // Create the entity object if necessary:
    if (!$this->entity) {
      $this->entity = new stdClass();
    }

    // Loop through the object's fields, copying them into $this:
    foreach ($object as $field => $value) {
      if ($overwrite || !property_exists($this->entity, $field)) {
        $this->entity->$field = $value;
      }
    }

    // Update the state of the loaded flag(s).
    $this->setLoaded();

    // In case the id was set, add the object to the static cache:
    $this->addToCache();

    return $this;
  }

  /**
   * Check if an entity exists in the database.
   *
   * This is effectively an alias for load() unless a derived class overrides
   * it, e.g. @see XNodeBase::exists()
   *
   * @return bool
   */
  public function inDB() {
    return $this->load();
  }


  //////////////////////////////////////////////////////////////////////////////
  // Methods for getting info about properties and fields.

  /**
   * Get the array of property info for the specified class.
   *
   * @param string $class
   * @return mixed
   */
  public static function getPropertyInfo($class) {
    // If an object was passed to the method, get its class name:
    if (is_object($class)) {
      $class = get_class($class);
    }

    // Unfortunately have to use eval because we don't have late static binding
    // in PHP 5.2.
    $code = "
      // If not done already, merge CCK property info with the node property info:
      if (isset($class::\$propertyInfoMerged) && !$class::\$propertyInfoMerged) {
        $class::\$propertyInfo = array_merge(XNodeBase::\$propertyInfo, $class::\$propertyInfo);
        $class::\$propertyInfoMerged = TRUE;
      }
      // Return the array of property info:
      return $class::\$propertyInfo;
    ";
    return eval($code);
  }

  /**
   * Get the property info for one or all properties in the object.
   * This is a bit of a hack for PHP 5.2.
   *
   * @return mixed
   */
  public function propertyInfo($property = NULL) {
    $property_info = self::getPropertyInfo($this);
    return $property ? $property_info[$property] : $property_info;
  }

  /**
   * Get information about a property/field given the field name.
   *
   * @param string $field
   * @return array
   */
  public function getFieldInfo($field) {
    // Remember our results so we don't have to loop through the $property_info
    // array every time.
    static $field_info;

    if (!$field_info[$field]) {
      // Loop through properties looking for a matching field name:
      $property_info = $this->propertyInfo();
      foreach ($property_info as $property => $info) {
        if ($info['field'] == $field) {
          // Add the property name into the array:
          $info['property'] = $property;
          // Remember this result:
          $field_info[$field] = $info;
          break;
        }
      }
    }

    // Note - if $field is an unknown field then $field_info[$field] won't have
    // been set, and the method will return NULL.

    return $field_info[$field];
  }

  /**
   * Calculate the state of the loaded flag by checking that the attached Drupal
   * entity has every field we expect it to have.
   */
  public function setLoaded() {
    // If we don't have an entity at all, then it isn't loaded:
    if (!$this->entity) {
      $this->loaded = FALSE;
      return;
    }

    // Look through fields to see if any are not set:
    $property_info = $this->propertyInfo();
    foreach ($property_info as $property => $info) {
      // If a field is not set, the entity is not fully loaded:
      $field = $info['field'];
      if (!property_exists($this->entity, $field) && $info['source'] != 'cck') {
        $this->loaded = FALSE;
        return;
      }
    }

    // The entity is fully loaded.
    $this->loaded = TRUE;
  }

  /**
   * Check to see if the entity is loaded, and if not, load it.
   */
  public function ensureLoaded() {
    if (!$this->loaded) {
      $this->load();
    }
  }


  //////////////////////////////////////////////////////////////////////////////
  // Methods related to properties.

  /**
   * Load a property from the database.
   *
   * The default behaviour is to load the entire entity, however, this can be
   * overridden in derived classes, e.g. @see XNodeBase::loadField()
   *
   * @param string $field
   * @return bool
   *   TRUE on success, FALSE on failure.
   */
  protected function loadField($field) {
    return $this->load();
  }

  /**
   * Checks if a given field has been loaded from the database.
   *
   * @param string $field
   * @return bool
   */
  protected function fieldLoaded($field) {
    return $this->entity && property_exists($this->entity, $field);
  }

  /**
   * Find the name of the id property for this entity.
   *
   * @return string
   */
  public function idProperty() {
    eval("\$idProperty = " . get_class($this) . "::\$idProperty;");
    return $idProperty;
  }

  /**
   * Get the valid of the id property of the entity.
   *   - For a node this will be the 'nid' property.
   *   - For a term this will be the 'tid' property.
   *   - For a user this will be the 'uid' property.
   *   - For a file this will be the 'fid' property.
   *   - For a location this will be the 'lid' property.
   *
   * This method can be accessed through the virtual property 'id'.
   * e.g. echo $x_entity->id;
   *
   * @return string
   */
  public function getId() {
    eval("\$id = \$this->" . get_class($this) . "::\$idProperty;");
    return $id;
  }

  /**
   * Get a reference to a property.
   *
   * If $autoload is TRUE (default) and the corresponding field hasn't been
   * loaded from the database yet, do it now.
   *
   * If the field's value hasn'tbeen copied to the property yet, do that now as
   * well.
   *
   * The reason why a reference is returned instead of just the value is to make
   * it possible to set values in array properties.
   * e.g. $page->words[0] = "Hello";
   *
   * @param string $property
   * @param bool $autoload = TRUE
   *
   * @return mixed
   */
  public function &getProperty($property, $autoload = TRUE) {
    // Get the property info:
    $info = $this->propertyInfo($property);

    // Check if the property is already set:
    if (!$this->propertySet[$property]) {

      // Get the field for this property:
      $field = $info['field'];

      // If the field isn't loaded, try and load it:
      if (!$this->fieldLoaded($field) && $autoload) {
        $this->loadField($field);
      }

      // If the field is loaded, copy its value to the property:
      if ($this->fieldLoaded($field)) {
        $this->setProperty($property, $this->entity->$field);
      }

    }
    elseif ($info['multiple']) {
      // If this is a multiple-value field, then the types could be wrong
      // because of the mechanism used to set array elements, so make sure
      // the values have the proper type before returning.
      $this->properties[$property] = classes_values_to_property($this->properties[$property], $info);
    }

    // Return a reference to the property. We return a reference here instead
    // of just the value, so that we can set array elements using [] syntax.
    return $this->properties[$property];
  }

  /**
   * Same as getProperty(), except that the field can be specified instead of
   * the property.
   *
   * @param string $field
   * @return mixed
   */
  public function &getPropertyByField($field) {
    $info = $this->getFieldInfo($field);
    return $info ? $this->getProperty($info['property']) : NULL;
  }

  /**
   * Set the value of a property. The values are converted to the correct type
   * or class suitable for the property.
   *
   * @param string $property
   * @param mixed $value
   * @return object
   */
  public function setProperty($property, $value) {
    // Get the info related to this property:
    $info = $this->propertyInfo($property);

    if ($info['source'] == 'content') {
      // Check if the provided value contains any values:
      if (classes_is_empty_cck_field($value)) {
        $this->properties[$property] = $info['multiple'] ? array() : NULL;
      }
      else {
        $this->properties[$property] = classes_values_to_property($value, $info);
      }
    }
    elseif ($info['source'] == 'locations') {
      // Could be an array if copying from a node:
      $this->properties[$property] = classes_values_to_property($value, $info);
    }
    else {
      $this->properties[$property] = classes_value_to_property($value, $info);
    }

    // Record that we've set the property.
    $this->propertySet[$property] = TRUE;

    // Return the $this object so we can chain set methods if desired.
    return $this;
  }


  //////////////////////////////////////////////////////////////////////////////
  // Special accessor methods.

  /**
   * Get the array of virtual properties.
   *
   * @return array
   */
  public function getProperties() {
    return $this->properties;
  }

  /**
   * Get the associated Drupal entity.
   * This will trigger loading if the entity isn't already fully loaded.
   *
   * @return object
   */
  public function getEntity() {
    // Ensure the entity is loaded:
    $this->ensureLoaded();

    // Copy all set properties to the Drupal entity's fields:
    foreach ($this->properties as $property => $property_value) {

      // Ignore unset properties:
      if (!$this->propertySet[$property]) {
        continue;
      }

      // Get the property info:
      $info = $this->propertyInfo($property);

      // If this property maps to a CCK field or location, convert to an array:
      if ($info['source'] == 'content' || $info['source'] == 'locations') {
        $array = $info['multiple'] ? $property_value : array($property_value);

        // Loop through the array of values, converting into field values:
        $field_value = array();
        foreach ($array as $value) {
          $field_value[] = classes_value_to_field($value, $info);
        }
      }
      else {
        // A normal field:
        $field_value = classes_value_to_field($property_value, $info);
      }

      // We only need to update the field value if the new value is different
      // from the current value.
      $field = $info['field'];
      if (!property_exists($this->entity, $field) || $this->entity->$field !== $field_value) {
        // Set the entity property:
        $this->entity->$field = $field_value;

        // Note that the entity has been modified:
        $this->dirty = TRUE;
      }

    } // foreach property

    return $this->entity;
  }

  /**
   * This function is really only for testing and debugging.
   */
  public function getEntityProperty() {
    return $this->entity;
  }


  //////////////////////////////////////////////////////////////////////////////
  // Getter methods for flags.

  /**
   * Get the value of the new property.
   *
   * @return bool
   */
  public function isNew() {
    return $this->new;
  }

  /**
   * Get the value of the dirty property.
   *
   * @return bool
   */
  public function isDirty() {
    return $this->dirty;
  }

  /**
   * Get the value of the loaded property.
   *
   * @return bool
   */
  public function isLoaded() {
    return $this->loaded;
  }


  //////////////////////////////////////////////////////////////////////////////
  // Conversion methods.

  /**
   * Convert the object to an array. This exposes the values of the protected
   * and private properties of the object, which is useful when debugging.
   */
  public function toArray() {
    return get_object_vars($this);
  }

}