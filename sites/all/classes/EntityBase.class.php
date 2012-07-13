<?php
/**
 * A base class for entities.
 *
 * @todo This should be integrated somehow with the Entity class provided by the entity module.
 */
abstract class EntityBase {

  /**
   * Static cache of entity objects.
   *
   * @var array
   */
  private static $cache;

  /**
   * If the entity has been loaded yet.
   *
   * @var bool
   */
  protected $loaded;

  /**
   * The Drupal entity object (node, user, etc.)
   *
   * @var stdClass
   */
  protected $entity;

  /**
   * Constructor.
   */
  protected function __construct() {
    // Create an entity object:
    $this->entity = new stdClass;
    // Initially the entity is not loaded:
    $this->loaded = FALSE;
  }

  /**
   * Child classes must define a load method.
   *
   * @abstract
   * @return Entity
   */
  abstract public function load();

  /**
   * Child classes must define a save method.
   *
   * @abstract
   * @return Entity
   */
  abstract public function save();

  /**
   * Child classes must define an id method.
   *
   * @abstract
   * @return int
   */
  abstract public function id();

  /**
   * Get the entity object.
   *
   * @return stdClass
   */
  public function entity() {
    return $this->entity;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get/set properties.

  /**
   * Get a property value.
   *
   * @param string $table
   * @param string $primary_key
   * @param string $property
   * @param bool $quick_load
   * @return mixed
   */
  public function getProperty($table, $primary_key, $property, $quick_load = FALSE) {
    // If not set, load the property value from the database:
    if (!isset($this->entity->{$property})) {
      // For some "quick load" properties, just get the field from the table record rather than load the whole object:
      if ($quick_load) {
        $this->entity->{$property} = db_select($table, 't')
          ->fields('t', array($property))
          ->condition($primary_key, $this->id())
          ->execute()
          ->fetch()
          ->$property;
//        dpm($table . '.' . $property. ' = ' . $this->entity->{$property});
      }
      else {
        // Load the whole object:
        $this->load();
      }
    }
    return isset($this->entity->{$property}) ? $this->entity->{$property} : NULL;
  }

  /**
   * Set a property value.
   *
   * @param string $property
   * @param mixed $value
   * @return mixed
   */
  public function setProperty($property, $value) {
    // Set the property's value.
    $this->entity->{$property} = $value;
    return $this;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Get/set an entity field's value.
   *
   * @param string $field
   * @param string $lang
   * @param int $delta
   * @param string $key
   * @param mixed $value
   * @return mixed
   */
  public function field($field, $lang = LANGUAGE_NONE, $delta = 0, $key = 'value', $value = NULL) {
    if ($value === NULL) {
      // Get the field's value.
      $this->load();
      return isset($this->entity->{$field}[$lang][$delta][$key]) ? $this->entity->{$field}[$lang][$delta][$key] : NULL;
    }
    else {
      // Set the field's value.
      $this->entity->{$field}[$lang][$delta][$key] = $value;
      return $this;
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Caching methods.

  /**
   * Add an entity to the cache.
   *
   * @param string $entity_type
   * @return bool
   */
  public function addToCache($entity_type) {
    self::$cache[$entity_type][$this->id()] = $this;
  }

  /**
   * Check if an entity is in the cache.
   *
   * @param string $entity_type
   * @param int $entity_id
   * @return bool
   */
  public static function inCache($entity_type, $entity_id) {
    return isset(self::$cache[$entity_type][$entity_id]);
  }

  /**
   * Get an entity from the cache.
   *
   * @param string $entity_type
   * @param int $entity_id
   * @return Entity
   */
  public static function getFromCache($entity_type, $entity_id) {
    return self::$cache[$entity_type][$entity_id];
  }

}
