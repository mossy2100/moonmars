<?php
/**
 * Relation class.
 */
class Relation extends EntityBase {

  /**
   * The entity type.
   *
   * @var string
   */
  const entityType = 'relation';

  /**
   * The table name.
   *
   * @var string
   */
  const table = 'relation';

  /**
   * The primary key
   *
   * @var string
   */
  const primaryKey = 'rid';

  /**
   * Quick-load properties.
   *
   * @var array
   */
  protected static $quickLoadProperties = array();

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Create and delete.

  /**
   * Create a new Relation object.
   *
   * @param null|int|stdClass $relation_param
   * @return Relation
   */
  public static function create($relation_param = NULL) {
    // Get the class of the object we want to create:
    $class = get_called_class();

    if (is_null($relation_param)) {
      // Create new relation:
      $relation_obj = new $class;

      // The relation is valid without a rid:
      $relation_obj->valid = TRUE;
    }
    elseif (is_uint($relation_param)) {
      // rid provided:
      $rid = $relation_param;

      // Only create the new relation if not already in the cache:
      if (self::inCache($rid)) {
        return self::getFromCache($rid);
      }
      else {
        // Create new relation:
        $relation_obj = new $class;

        // Set the rid:
        $relation_obj->entity->rid = $rid;
      }
    }
    elseif (is_object($relation_param)) {
      // Drupal relation object provided:
      $relation = $relation_param;

      // Get the object from the cache if possible:
      if ($relation->rid && self::inCache($relation->rid)) {
        $relation_obj = self::getFromCache($relation->rid);
      }
      else {
        $relation_obj = new $class;
      }

      // Reference the provided entity object:
      $relation_obj->entity = $relation;
    }

    // If we have a relation object, add to cache and return:
    if (isset($relation_obj)) {
      $relation_obj->addToCache();
      return $relation_obj;
    }

    trigger_error("Invalid parameter to Relation::create()", E_USER_ERROR);
  }

  /**
   * Create a new binary relation.
   *
   * @static
   * @param string $relationship_type
   * @param string $entity_type0
   * @param int $entity_id0
   * @param string $entity_type1
   * @param int $entity_id1
   * @param bool $save
   * @return Relation
   */
  public static function createNewBinary($relationship_type, $entity_type0, $entity_id0, $entity_type1, $entity_id1, $save = FALSE) {
    $endpoints = array(
      array(
        'entity_type' => $entity_type0,
        'entity_id'   => $entity_id0,
      ),
      array(
        'entity_type' => $entity_type1,
        'entity_id'   => $entity_id1,
      ),
    );

    // Create the relation entity:
    $rel_entity = relation_create($relationship_type, $endpoints);

    // Create the Relation object:
    $relation = Relation::create($rel_entity);

    // Save if requested:
    if ($save) {
      $relation->save();
    }

    return $relation;
  }

  /**
   * Delete a relation.
   */
  public function delete() {
    relation_delete($this->rid());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Load and save.

  /**
   * Load the relation object.
   *
   * @return Relation
   */
  public function load() {
    // Avoid reloading:
    if ($this->loaded) {
      return $this;
    }

    // Default result:
    $relation = FALSE;

    // Try to load the relation:
    if (isset($this->entity->rid) && $this->entity->rid > 0) {
      // Load by rid. Drupal caching will prevent reloading of the same relation.
      $relation = relation_load($this->entity->rid);
    }

    // Set the valid flag:
    $this->valid = (bool) $relation;

    // If the relation was successfully loaded, update properties:
    if ($relation) {
      $this->entity = $relation;
      $this->loaded = TRUE;
      return $this;
    }

    trigger_error("Could not load relation", E_USER_WARNING);
  }

  /**
   * Save the relation object.
   *
   * @return Relation
   */
  public function save() {
    // Ensure the relation is loaded:
    $this->load();

    // Save the relation:
    relation_save($this->entity);

    // In case the relation is new, add it to the cache:
    $this->addToCache();

    return $this;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set.

  /**
   * Get/set the rid.
   *
   * @param int $rid
   * @return int|Relation
   */
  public function rid($rid = NULL) {
    if ($rid === NULL) {
      // Get the rid:
      return $this->entity->rid;
    }
    else {
      // Set the rid:
      $this->entity->rid = $rid;

      // Add the relation object to the cache if not already:
      $this->addToCache();

      return $this;
    }
  }

  /**
   * Get the relation object.
   *
   * @return stdClass
   */
  public function relation() {
    $this->load();
    return $this->entity;
  }

  /**
   * Get/set the uid of the user who created the relation.
   *
   * @param null|int
   * @return int|Relation
   */
  public function uid($uid = NULL) {
    return $this->prop('uid', $uid);
  }

  /**
   * Get the relation's creator.
   *
   * @return User
   */
  public function creator() {
    return User::create($this->uid());
  }

  /**
   * Get an endpoint.
   *
   * @param string $lang
   * @param int $delta
   * @return array
   */
  public function endpoint($lang, $delta) {
    $this->load();
    return isset($this->entity->endpoints[$lang][$delta]) ? $this->entity->endpoints[$lang][$delta] : NULL;
  }

  /**
   * Get an entity type.
   *
   * @param string $lang
   * @param int $delta
   * @return string
   */
  public function entityType($lang, $delta) {
    $this->load();
    return isset($this->entity->endpoints[$lang][$delta]['entity_type']) ? $this->entity->endpoints[$lang][$delta]['entity_type'] : NULL;
  }

  /**
   * Get an entity id.
   *
   * @param string $lang
   * @param int $delta
   * @return int
   */
  public function entityId($lang, $delta) {
    $this->load();
    return isset($this->entity->endpoints[$lang][$delta]['entity_id']) ? ((int) $this->entity->endpoints[$lang][$delta]['entity_id']) : NULL;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Status flags.

  /**
   * Get the relation status.
   *
   * @return Relation
   */
  public function published() {
    return $this->prop('status');
  }

  /**
   * Publish the relation, i.e. set the status flag to 1.
   *
   * @return Relation
   */
  public function publish() {
    return $this->prop('status', 1);
  }

  /**
   * Unpublish the relation, i.e. set the status flag to 0.
   *
   * @return Relation
   */
  public function unpublish() {
    return $this->prop('status', 0);
  }

}
