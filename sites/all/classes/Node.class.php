<?php
/**
 * Node class.
 */
class Node extends EntityBase {

  /**
   * The entity type.
   *
   * @var string
   */
  protected static $entityType = 'node';

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  /**
   * Create a new Node object.
   *
   * @param string $class
   * @param null|int|stdClass $node_param
   * @return Node
   */
  public static function create($class = 'Node', $node_param = NULL) {
    if (is_null($node_param)) {
      // Create new node:
      $node_obj = new $class;
      // Assume published:
      $node_obj->entity->status = 1;
      return $node_obj;
    }
    elseif (is_uint($node_param)) {
      // nid provided:
      $nid = $node_param;
      // Only create the new node if not already in the cache:
      if (self::inCache($nid)) {
        return self::getFromCache($nid);
      }
      else {
        // Create new node:
        $node_obj = new $class;
        // Set the nid:
        $node_obj->entity->nid = $nid;
        // Put the new node in the cache:
        $node_obj->addToCache();
        return $node_obj;
      }
    }
    elseif (is_object($node_param)) {
      // Drupal node object provided:
      $node = $node_param;
      // Get the User object:
      if ($node->nid && self::inCache($node->nid)) {
        $node_obj = self::getFromCache($node->nid);
      }
      else {
        $node_obj = new $class;
      }
      $node_obj->entity = $node;
      // Add to cache:
      $node_obj->addToCache();
      return $node_obj;
    }
    else {
      trigger_error("Invalid parameter to Node::create()", E_USER_ERROR);
    }
  }

  /**
   * Get/set the nid.
   *
   * @param int $nid
   * @return int|Node
   */
  public function nid($nid = NULL) {
    if ($nid = NULL) {
      // Get the nid:
      return $this->entity->nid;
    }
    else {
      // Set the nid:
      $this->entity->nid = $nid;
      // Add the node object to the cache if not already:
      $this->addToCache();
      return $this;
    }
  }

  /**
   * Get the entity id.
   *
   * @return int
   */
  public function id() {
    return $this->nid();
  }

  /**
   * Get the node object.
   *
   * @return stdClass
   */
  public function node() {
    $this->load();
    return $this->entity;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Caching methods.

  /**
   * Add a node to the cache.
   *
   * @return bool
   */
  public function addToCache() {
    parent::addToCache(self::$entityType);
  }

  /**
   * Check if a node is in the cache.
   *
   * @param int $entity_id
   * @return bool
   */
  public static function inCache($entity_id) {
    return parent::inCache(self::$entityType, $entity_id);
  }

  /**
   * Get a node from the cache.
   *
   * @param int $entity_id
   * @return Node
   */
  public static function getFromCache($entity_id) {
    return parent::getFromCache(self::$entityType, $entity_id);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get/set properties.

  /**
   * Get a property value.
   *
   * @param $property
   * @param $quick_load
   * @return mixed
   */
  public function getProperty($property, $quick_load = FALSE) {
    return parent::getProperty('node', 'nid', $property, $quick_load);
  }

  /**
   * Get the node's title.
   *
   * @return string
   */
  public function title() {
    return $this->getProperty('title', TRUE);
  }

  /**
   * Get the node's type.
   *
   * @return string
   */
  public function type() {
    return $this->getProperty('type', TRUE);
  }

  /**
   * Get/set a property value.
   *
   * @param string $property
   * @param mixed $value
   * @return mixed
   */
  public function prop($property, $value = NULL) {
    if (func_get_args() == 1) {
      // Get a property value:
      return $this->getProperty($property);
    }
    else {
      // Set a property value:
      return $this->setProperty($property, $value);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Get/set the node's creator.
   *
   * @return Member
   */
  public function creator() {
    return Member::create($this->getProperty('uid', TRUE));
  }

  /**
   * Load the node object.
   *
   * @return Node
   */
  public function load() {
    // Avoid reloading:
    if ($this->loaded) {
      return $this;
    }

    // Default result:
    $node = FALSE;

    // Try to load the node:
    if (isset($this->entity->nid) && $this->entity->nid > 0) {
      // Load by nid. Drupal caching will prevent reloading of the same node.
      $node = node_load($this->entity->nid);
    }

    if ($node) {
      // Success. Update properties:
      $this->entity = $node;
      $this->loaded = TRUE;
      return $this;
    }
    else {
      trigger_error("Invalid node identifier: " . $this->entity->nid, E_USER_ERROR);
    }
  }

  /**
   * Save the node object.
   *
   * @return Node
   */
  public function save() {
    // Save the node:
    node_save($this->entity);

    // If the node is new then we should add it to the cache:
    $this->addToCache();

    return $this;
  }

  /**
   * Get the path to the node's page.
   *
   * @return string
   */
  public function path() {
    return 'node/' . $this->entity->nid;
  }

  /**
   * Get the path alias to the node's page.
   *
   * @return string
   */
  public function alias() {
    return drupal_get_path_alias($this->path());
  }

  /**
   * Get a link to the node's profile.
   *
   * @return string
   */
  public function link() {
    return l($this->title(), $this->alias());
  }

  /**
   * Find out how many published comments a node has.
   */
  public function commentCount() {
    return db_select('comment', 'c')
      ->fields('c', array('cid'))
      ->condition('nid', $this->nid())
      ->condition('status', 1)
      ->execute()
      ->rowCount();
  }

}
