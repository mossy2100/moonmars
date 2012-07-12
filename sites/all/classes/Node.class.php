<?php
/**
 * Node class.
 */
class Node extends EntityBase {

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
   * @param int $nid
   * @return Node
   */
  public static function create($class = 'Node', $nid = NULL) {
    if (is_null($nid)) {
      // Create new node:
      $node = new $class;
      // Assume published:
      $node->entity->status = 1;
      return $node;
    }
    elseif (is_uint($nid)) {
      // Only create the new node if not already in the cache:
      if (self::inCache('node', $nid)) {
        return self::getFromCache('node', $nid);
      }
      else {
        // Create new node:
        $node = new $class;
        // Set the nid:
        $node->entity->nid = $nid;
        // Put the new node in the cache:
        $node->addToCache('node', $nid);
        return $node;
      }
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
    if (func_num_args() == 0) {
      // Get the nid:
      return $this->entity->nid;
    }
    else {
      // Set the nid:
      $this->entity->nid = $nid;
      // Add the node object to the cache if not already:
      $this->addToCache('node', $nid);
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
    $uid = $this->getProperty('uid', TRUE);
    return Member::create($uid);
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
      trigger_error("Invalid node identifier.", E_USER_ERROR);
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
    $this->addToCache('node', $this->entity->nid);

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

}
