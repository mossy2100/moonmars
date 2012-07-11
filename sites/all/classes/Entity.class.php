<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shaun
 * Date: 2012-07-11
 * Time: 4:26 PM
 * To change this template use File | Settings | File Templates.
 */
class Entity {

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
  private $loaded;

  /**
   * The Drupal entity object (node, user, etc.)
   *
   * @var stdClass
   */
  private $entity;

  /**
   * Constructor.
   */
  private function __construct() {
    // Create an entity object:
    $this->entity = new stdClass;
    // Initially the entity is not loaded:
    $this->loaded = FALSE;
  }

  /**
   * Get user properties.
   *
   * @param string $property
   * @return mixed
   */
  public function __get($property) {
    if (method_exists($this, $property)) {
      return $this->$property();
    }
    else {
      $this->load();
      return $this->entity->$property;
    }
  }

  /**
   * Set user properties.
   *
   * @param string $property
   * @param mixed $value
   * @return Member
   */
  public function __set($property, $value) {
    if (method_exists($this, $property)) {
      return $this->$property($value);
    }
    else {
      $this->entity->$property = $value;
      return $this;
    }
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
   * Get the entity object.
   *
   * @return stdClass
   */
  public function entity() {
    return $this->entity;
  }

  /**
   * Get/set a field's value.
   *
   * @param string $field_name
   * @param string $lang
   * @param int $delta
   * @param string $key
   * @param mixed $value
   */
  public function field($field_name, $lang = LANGUAGE_NONE, $delta = 0, $key = 'value', $value = NULL) {
    if ($value === NULL) {
      // Get the field's value.
      $this->load();
      return isset($this->entity->{$field_name}[$lang][$delta][$key]) ? $this->entity->{$field_name}[$lang][$delta][$key] : NULL;
    }
    else {
      // Set the field's value.
      $this->entity->$field_name[$lang][$delta][$key] = $value;
      return $this;
    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Caching methods.

  /**
   * Add an entity to the cache.
   *
   * @param string $entity_type
   * @param int $entity_id
   * @return bool
   */
  public function addToCache($entity_type, $entity_id) {
    self::$cache[$entity_type][$entity_id] = $this;
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
