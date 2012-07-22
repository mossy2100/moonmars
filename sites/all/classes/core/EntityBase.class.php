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
   * The Drupal entity object (node, user, etc.)
   *
   * @var stdClass
   */
  protected $entity;

  /**
   * If the entity has been loaded yet.
   *
   * @var bool
   */
  protected $loaded;

  /**
   * If the id is valid.
   *
   * @var bool
   */
  protected $valid;

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
   * @return EntityBase
   */
  abstract public function load();

  /**
   * Reload the entity.
   */
  public function reload() {
    $this->loaded = FALSE;
    $this->load();
  }

  /**
   * Child classes must define a save method.
   *
   * @abstract
   * @return EntityBase
   */
  abstract public function save();

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set.

  /**
   * Get the entity object.
   *
   * @return stdClass
   */
  public function entity() {
    return $this->entity;
  }

  /**
   * Get the entity id.
   *
   * @return int
   */
  public function id() {
    $class = get_class($this);
    $primaryKey = $class::primaryKey;
    return $this->$primaryKey();
  }

  /**
   * Get the entity type.
   *
   * @return stdClass
   */
  public function entityType() {
    $class = get_class($this);
    return $class::entityType;
  }

  /**
   * Set the values of multiple properties.
   *
   * @param array $values
   * @return mixed
   */
  public function setProperties($values) {
    $this->load();

    // Set the property's value.
    foreach ($values as $property => $value) {
      $this->entity->{$property} = $value;
    }
    return $this;
  }

  /**
   * Get/set a property value.
   *
   * @param string $property
   * @param mixed $value
   * @return mixed
   */
  public function prop($property, $value = NULL) {
    if ($value === NULL) {
      // Get a property's value.

      // If not set, load the property value from the database:
      if (!isset($this->entity->{$property})) {

        // Get the object's class:
        $class = get_class($this);

        // For some "quick load" properties, just get the field from the table record rather than load the whole object:
        if (in_array($property, $class::$quickLoadProperties)) {

          $rec = db_select($class::table, 't')
            ->fields('t', array($property))
            ->condition($class::primaryKey, $this->id())
            ->execute()
            ->fetch();

          // If we got the record then set the property value:
          if ($rec) {
            $this->entity->{$property} = $rec->$property;
          }

          // If we got the record then the id is valid:
          $this->valid = (bool) $rec;
        }
        else {
          // Load the whole object:
          $this->load();
        }
      }

      return isset($this->entity->{$property}) ? $this->entity->{$property} : NULL;

    }
    else {
      // Set a property's value.

      // Make sure the object is loaded:
      $this->load();

      // Set the property's value:
      $this->entity->{$property} = $value;
      return $this;
    }
  }

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

  /**
   * Check if the object is loaded.
   *
   * @return bool
   */
  public function loaded() {
    return $this->loaded;
  }

  /**
   * Check if the entity's id is valid.
   *
   * @return bool
   */
  public function valid() {
    // If the id is not set then the entity is valid. It's simply a new entity that hasn't been saved yet.
    if (!$this->id()) {
      return TRUE;
    }

    // If the valid flag hasn't been set yet via prop(), then the simplest way to check if the entity is valid
    // is to try and load it:
    if (!isset($this->valid)) {
      $this->load();
    }

    return $this->valid;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Caching methods.

  /**
   * Add an entity to the cache, if it has an id.
   *
   * @return bool
   */
  public function addToCache() {
    $id = $this->id();
    if ($id) {
      $class = get_class($this);
      self::$cache[$class::entityType][$id] = $this;
    }
  }

  /**
   * Check if an entity is in the cache.
   *
   * @param int $entity_id
   * @return bool
   */
  public static function inCache($entity_id) {
    $class = get_called_class();
    return isset(self::$cache[$class::entityType][$entity_id]);
  }

  /**
   * Get an entity from the cache.
   *
   * @param int $entity_id
   * @return EntityBase
   */
  public static function getFromCache($entity_id) {
    $class = get_called_class();
    return isset(self::$cache[$class::entityType][$entity_id]) ? self::$cache[$class::entityType][$entity_id] : NULL;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Equals.

  /**
   * Checks if two entities are equal.
   *
   * @static
   * @param EntityBase $entity1
   * @param EntityBase $entity2
   * @return bool
   */
  public static function equals(EntityBase $entity1, EntityBase $entity2) {
    return ($entity1->entityType() == $entity2->entityType()) && ($entity1->id() == $entity2->id());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Path and alias-related methods.

  /**
   * Get the path to the entity's page.
   *
   * @return string
   */
  public function path() {
    return $this->entityType() . '/' . $this->id();
  }

  /**
   * Get/set the path alias to the entity's page.
   *
   * @return string
   */
  public function alias($alias = NULL) {
    if ($alias === NULL) {
      // Get the entity's alias:
      return drupal_get_path_alias($this->path());
    }
    else {
      // Set the entity's alias:
      $source = $this->path();

      // Delete any existing aliases for this entity.
      db_delete('url_alias')
        ->condition('source', $source);

      // Insert the new alias:
      db_insert('url_alias')
        ->fields(array(
                      'source'   => $source,
                      'alias'    => $alias,
                      'language' => LANGUAGE_NONE,
                 ))
        ->execute();
    }
  }

  /**
   * Get the path to the entity's edit page.
   *
   * @return string
   */
  public function editAlias() {
    return $this->alias() . '/edit';
  }

}
