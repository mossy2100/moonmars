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
      if (isset($relation->rid) && $relation->rid && self::inCache($relation->rid)) {
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

    // If we have a rid, try to load the relation:
    if (isset($this->entity->rid) && $this->entity->rid) {
      // Load by rid. Drupal caching will prevent reloading of the same relation.
      $relation = relation_load($this->entity->rid);
    }

    // Set the valid flag:
    $this->valid = (bool) $relation;

    // If the relation was successfully loaded, update properties:
    if ($relation) {
      $this->entity = $relation;
      $this->loaded = TRUE;
    }

    return $this;
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
      return isset($this->entity->rid) ? $this->entity->rid : NULL;
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
  public function endpoint($delta, $lang = LANGUAGE_NONE) {
    $this->load();
    return isset($this->entity->endpoints[$lang][$delta]) ? $this->entity->endpoints[$lang][$delta] : NULL;
  }

  /**
   * Get an endpoint entity type.
   *
   * @param string $lang
   * @param int $delta
   * @return string
   */
  public function endpointEntityType($delta, $lang = LANGUAGE_NONE) {
    return $this->field('endpoints', $lang, $delta, 'entity_type');
  }

  /**
   * Get an endpoint entity id.
   *
   * @param string $lang
   * @param int $delta
   * @return int
   */
  public function endpointEntityId($delta, $lang = LANGUAGE_NONE) {
    return $this->field('endpoints', $lang, $delta, 'entity_id');
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

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Static methods for working with binary relationships.

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
   *   Whether or not to save the relationship. Defaults to TRUE.
   * @return Relation
   */
  public static function createNewBinary($relationship_type, $entity_type0, $entity_id0, $entity_type1, $entity_id1, $save = TRUE) {
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
   * Search for relationships matching the provided parameters.
   *
   * @todo This method currently relies on the database view 'view_relationship', which makes it somewhat unportable.
   *
   * @param string $relationship_type
   * @param string $entity_type0
   *   Use NULL to match all.
   * @param int $entity_id0
   *   Use NULL to match all.
   * @param string $entity_type1
   *   Use NULL to match all.
   * @param int $entity_id1
   *   Use NULL to match all.
   * @param null|int $offset
   * @param null|int $limit
   * @return array
   */
  public static function searchBinary($relationship_type, $entity_type0 = NULL, $entity_id0 = NULL, $entity_type1 = NULL, $entity_id1 = NULL, $offset = NULL, $limit = NULL, $orderByField = NULL, $orderByDirection = NULL) {
    // Look for a relationship record:
    $q = db_select('view_relationship', 'vr')
      ->fields('vr', array('rid'));

    // Add WHERE clause:
    $q->condition('relation_type', $relationship_type);
    if ($entity_type0 !== NULL) {
      $q->condition('entity_type0', $entity_type0);
    }
    if ($entity_id0 !== NULL) {
      $q->condition('entity_id0', $entity_id0);
    }
    if ($entity_type1 !== NULL) {
      $q->condition('entity_type1', $entity_type1);
    }
    if ($entity_id1 !== NULL) {
      $q->condition('entity_id1', $entity_id1);
    }

    // Add LIMIT clause:
    if ($offset !== NULL && $limit !== NULL) {
      $q->range($offset, $limit);
    }

    // Add ORDER BY clause:
    if ($orderByField === NULL) {
      $orderByField = 'changed';
    }
    if ($orderByDirection === NULL) {
      $orderByDirection = 'DESC';
    }
    $q->orderBy($orderByField, $orderByDirection);

    // Get the relationships:
    $rs = $q->execute();
    $results = array();
    foreach ($rs as $rec) {
      $results[] = Relation::create($rec->rid);
    }
    return $results;
  }

  /**
   * Update or create a relationship.
   *
   * @param string $relationship_type
   * @param string $entity_type0
   * @param int $entity_id0
   * @param string $entity_type1
   * @param int $entity_id1
   * @param bool $save
   *   Whether or not to save the relationship. Defaults to TRUE.
   */
  public static function updateBinary($relationship_type, $entity_type0, $entity_id0, $entity_type1, $entity_id1, $save = TRUE) {
    // See if the relationship already exists:
    $rels = Relation::searchBinary($relationship_type, $entity_type0, $entity_id0, $entity_type1, $entity_id1);

    if ($rels) {
      // Update the relationship. We really just want to update the changed timestamp, so let's just load and save it.
      $rel = $rels[0];
      $rel->load();

      if ($save) {
        $rel->save();
      }
    }
    else {
      // Create a new relationship:
      $rel = Relation::createNewBinary($relationship_type, $entity_type0, $entity_id0, $entity_type1, $entity_id1, $save);
    }

    return $rel;
  }

  /**
   * Delete relationships.
   *
   * @param string $relationship_type
   * @param string $entity_type0
   * @param int $entity_id0
   * @param string $entity_type1
   * @param int $entity_id1
   * @return bool
   *   TRUE on success, FALSE on failure
   */
  public static function deleteBinary($relationship_type, $entity_type0 = NULL, $entity_id0 = NULL, $entity_type1 = NULL, $entity_id1 = NULL) {
    // Get the relationships:
    $rels = Relation::searchBinary($relationship_type, $entity_type0, $entity_id0, $entity_type1, $entity_id1);

    // If none were found, return FALSE:
    if (empty($rels)) {
      return FALSE;
    }

    // Delete the relationships:
    foreach ($rels as $rel) {
      relation_delete($rel->rid());
    }

    return TRUE;
  }

}
