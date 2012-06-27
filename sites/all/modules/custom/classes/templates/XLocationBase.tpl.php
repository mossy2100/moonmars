<?php
// $Id$

/**
 * !! DO NOT EDIT THIS FILE !!
 * Instead, add your own methods and properties to the XLocation class, which is
 * derived from this one.
 *
 * The XLocationBase class is the base class for XLocation. It is used to
 * represent a record in the location table.
 *
 * This class follows the Factory pattern, which gives 2 main advantages:
 * - XLocation objects are cached, thus there is never a duplicate object created
 *   for the same location.
 * - If an invalid parameter is passed to the create() method then FALSE is
 *   returned. If an ordinary constructor was used then we would have to either
 *   return an empty object or throw an exception, neither of which is ideal.
 *
 * @version <dt_generated>
 * @author shaunmoss
 */
abstract class XLocationBase extends XEntity {

  //////////////////////////////////////////////////////////////////////////////
  // Static properties.

  /**
   * Static array of property information.
   *
   * @var array
   */
  protected static $propertyInfo = '(property_info)';

  /**
   * The id property for locations.
   *
   * @var string
   */
  protected static $idProperty = 'lid';

  /**
   * Static cache of created XLocation objects.
   *
   * @var array
   */
  protected static $cache = array();


  //////////////////////////////////////////////////////////////////////////////
  // Constructor.

  /**
   * Constructor is protected, as we're using the Factory pattern.
   */
  protected function __construct() {}


  //////////////////////////////////////////////////////////////////////////////
  // Static methods for creating and deleting objects.

  /**
   * Public factory method for creating new XLocationBase objects.
   *
   * @param mixed $location
   *   Can be:
   *     - a lid
   *     - a regular Drupal location object
   *     - a record from the location table
   *     - a XLocationBase object
   *     - NULL, for a new location
   * @return object
   *   Or FALSE if there's any problem.
   */
  public static function create($location = NULL) {
    // Get the lid:
    $lid = classes_find_lid($location);

    // Check it's valid:
    if ($lid < 0) {
      return FALSE;
    }

    // Check the XLocation cache:
    if ($lid && self::inCache($lid)) {
      $xlocation = self::$cache[$lid];
    }
    else {
      // Create the new object:
      $xlocation = new XLocation();

      // Do stuff related to whether or not the lid was provided:
      if ($lid) {
        // Set the lid:
        $xlocation->lid = $lid;

        // This is an existing location:
        $xlocation->new = FALSE;

        // Add the XLocation to the cache:
        $xlocation->addToCache();
      }
      else {
        // This is a new location:
        $xlocation->new = TRUE;
      }
    }

    if (is_string($location) && !classes_is_int($location)) {
      // If the parameter is a string, it's the location name:
      $xlocation->name = $location;
    }
    elseif (is_object($location) || is_array($location)) {
      // If an object or array was provided, copy its fields:
      $xlocation->copy($location);
    }

    // Check how loaded the location is:
    $xlocation->setLoaded();

    return $xlocation;
  }

  /**
   * Delete a location record.
   *
   * @param mixed $location
   *   Can be:
   *     - a lid
   *     - a regular Drupal location object
   *     - a record from the location table
   *     - a XLocationBase or XLocation object
   *     - anything else from which a lid can be extracted (@see create())
   */
  public static function destroy($location) {
    // Get the lid from the param:
    $lid = classes_find_lid($location);

    // Check for valid lid:
    if ($lid <= 0) {
      return;
    }

    // Delete the location records.
    db_query("DELETE FROM {location} WHERE lid = %d", $lid);
    db_query("DELETE FROM {location_instance} WHERE lid = %d", $lid);

    // Unlink the inner location object, leave it for garbage collection:
    $xlocation->entity = NULL;

    // Wipe all properties:
    $xlocation->properties = array();
    $xlocation->propertySet = array();

    // No fields are loaded:
    $xlocation->loaded = FALSE;

    // Remove the XLocation from the cache:
    unset(self::$cache[$xlocation->lid]);

    // The delete succeeded:
    return TRUE;
  }


  //////////////////////////////////////////////////////////////////////////////
  // Core instance methods.

  /**
   * Load the location record.
   *
   * @return object
   */
  public function load() {
    // We can't load the location without a lid:
    if (!$this->lid) {
      return FALSE;
    }

    // Load the location record. Note that the location_load_location()
    // function always returns a location array even if the lid is invalid.
    // It also invokes location load hooks.
    $location = location_load_location($this->lid);

    // Check that we successfully loaded the location:
    if (!$location) {
      return FALSE;
    }

    // Set the entity to the loaded location, converted to an object:
    $this->entity = (object) $location;

    // The entity is now fully loaded:
    $this->loaded = TRUE;

    return $this;
  }

  /**
   * Save a location.
   *
   * @return int
   *   Either SAVED_NEW, SAVED_UPDATED, SAVED_NOT or FALSE.
   */
  public function save() {
    // Copy any values from properties back into fields:
    $this->getEntity();

    // Default result:
    $result = SAVED_NOT;

    // Only save the location if it's new or if it's changed:
    if ($this->new || $this->dirty) {

      // Insert or update the location record.
      // XNode, I would have used location_save() here, but it likes to create
      // new lids, and generally does stuff with the location_instance table
      // that we don't care about here.
      $result = drupal_write_record('location', $this->entity, $this->new ? array() : 'lid');

      if ($result) {
        // Invoke location save hooks:
        $location = (array) $this->entity;
        location_invoke_locationapi($location, 'save');
        $this->entity = (object) $location;

        // The location is no longer new or dirty.
        $this->new = FALSE;
        $this->dirty = FALSE;

        // Add the XLocation to the cache:
        $this->addToCache();

        // The lid may have been changed by the save process, so
        // let's copy the fields back to the properties.
        $this->copy($this->entity, TRUE);
      }
    }

    // Return result:
    return $result;
  }


  //////////////////////////////////////////////////////////////////////////////
  // Override the setProperty() method in XEntityBase.

  /**
   * Set the value of a property.
   *
   * This method overrides the setProperty() method in XEntityBase.
   * Necessary so we can control values assigned to country properties.
   *
   * There's an option here to do similar kind of checking on state/province to
   * ensure that the value is a valid state/province; however, this is more
   * tricky since (a) the country may not be set first, and (b) the location
   * module does not maintain up-to-date lists of states/provinces anyway. For
   * now we will rely on the programmer to take care of this.
   *
   * @param string $property
   * @param mixed $value
   * @return object
   */
  public function setProperty($property, $value) {

    // Special handling for the country property:
    if ($property == 'country' && $value) {

      // Check that the provided value is a string:
      if (!is_string($value)) {
        return FALSE;
      }

      // Convert to lower-case:
      $value = strtolower($value);

      // Get the countries and their codes:
      $countries = location_get_iso3166_list();

      if (strlen($value) != 2) {
        // Assume country name and try to find the code:
        $value = array_search($value, array_map('strtolower', $countries));
        if (!$value) {
          return FALSE;
        }
      }

      // Support alternative country code 'GB' for UK. The correct ISO code for
      // the United Kingdom is actually 'GB', however, the location module
      // uses 'uk'.
      if ($value == 'gb') {
        $value = 'uk';
      }

      // Check that the code is valid:
      if (!array_key_exists($value, $countries)) {
        return FALSE;
      }
    }

    // All good, proceed with the usual method:
    parent::setProperty($property, $value);
  }


  //////////////////////////////////////////////////////////////////////////////
  // Methods for working with the XLocation object cache.

  /**
   * Get the static XLocation object cache.
   *
   * @return array
   */
  public static function getCache() {
    return self::$cache;
  }

  /**
   * Clear the static XLocation object cache.
   *
   * @return array
   */
  public static function clearCache() {
    self::$cache = array();
  }

  /**
   * Checks if a XLocation is in the cache.
   *
   * @param mixed $location
   *   Can be a lid, location, XLocation, etc.
   * @return bool
   */
  public static function inCache($location) {
    $lid = classes_find_lid($location);
    return $lid ? array_key_exists($lid, self::$cache) : FALSE;
  }

  /**
   * Add the XLocation object to the static cache.
   */
  public function addToCache() {
    if ($this->lid) {
      self::$cache[$this->lid] = $this;
    }
  }


  //////////////////////////////////////////////////////////////////////////////
  // Special accessor and mutator methods.

  /**
   * Get the regular Drupal location object referenced by the XLocation object.
   * Alias for getEntity().
   *
   * Note that location entities in Drupal are normally arrays, so if you need
   * it in that form, remember to cast the result of this method.
   *
   * @return object
   */
  public function getLocation() {
    return $this->getEntity();
  }

  /**
   * Alias for getProvince().
   * This method enables the use of the virtual property 'state' as an
   * alternative to 'province'.
   * @see XLocationBase::getProvince()
   *
   * @return string
   */
  public function getState() {
    return $this->province;
  }

  /**
   * This method enables the use of the virtual property 'state' as an
   * alternative to 'province'.
   *
   * @param string $value
   * @return object
   *   The $this object, for chaining method calls.
   */
  public function setState($value) {
    return $this->province = $value;
  }


  //////////////////////////////////////////////////////////////////////////////
  // Accessor and mutator methods.
//getters_setters
}
