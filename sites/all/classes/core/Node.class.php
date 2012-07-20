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
  const entityType = 'node';

  /**
   * The table name.
   *
   * @var string
   */
  const table = 'node';

  /**
   * The primary key
   *
   * @var string
   */
  const primaryKey = 'nid';

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Create and delete.

  /**
   * Create a new Node object.
   *
   * @param null|int|stdClass $node_param
   * @return Node
   */
  public static function create($node_param = NULL) {
    // Get the class of the object we want to create:
    $class = get_called_class();

    if (is_null($node_param)) {
      // Create new node:
      $node_obj = new $class;

      // Set the type:
      $node_obj->entity->type = $class::nodeType;

      // Default status to published:
      $node_obj->entity->status = 1;

      // Default language to none:
      $node_obj->entity->language = LANGUAGE_NONE;

      // Default user to current user:
      $node_obj->entity->uid = user_is_logged_in() ? $GLOBALS['user']->uid : NULL;
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
      }
    }
    elseif (is_object($node_param)) {
      // Drupal node object provided:
      $node = $node_param;

      // Get the object from the cache if possible:
      if ($node->nid && self::inCache($node->nid)) {
        $node_obj = self::getFromCache($node->nid);
      }
      else {
        $node_obj = new $class;
      }

      // Link to the provided entity object:
      $node_obj->entity = $node;
    }

    // If we have a node object, add to cache and return:
    if (isset($node_obj)) {
      $node_obj->addToCache();
      return $node_obj;
    }

    trigger_error("Invalid parameter to Node::create()", E_USER_ERROR);
  }

  /**
   * Delete a node.
   */
  public function delete() {
    node_delete($this->nid());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Load and save.

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

    // Set the valid flag:
    $this->valid = (bool) $node;

    // If the node was successfully loaded, update properties:
    if ($node) {
      $this->entity = $node;
      $this->loaded = TRUE;
      return $this;
    }

    trigger_error("Could not load node", E_USER_WARNING);
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

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set.

  /**
   * Get/set the nid.
   *
   * @param int $nid
   * @return int|Node
   */
  public function nid($nid = NULL) {
    if ($nid === NULL) {
      // Get the nid:
      return isset($this->entity->nid) ? $this->entity->nid : NULL;
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
   * Get the node object.
   *
   * @return stdClass
   */
  public function node() {
    $this->load();
    return $this->entity;
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
   * Get the node's uid.
   *
   * @return int
   */
  public function uid() {
    return $this->getProperty('uid', TRUE);
  }

  /**
   * Get the node's creator.
   *
   * @return User
   */
  public function creator() {
    return User::create($this->uid());
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

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Publish and unpublish.

  /**
   * Get the node status.
   *
   * @return Node
   */
  public function published() {
    return $this->prop('status');
  }

  /**
   * Publish the node, i.e. set the status flag to 1.
   *
   * @return Node
   */
  public function publish() {
    return $this->prop('status', 1);
  }

  /**
   * Unpublish the node, i.e. set the status flag to 0.
   *
   * @return Node
   */
  public function unpublish() {
    return $this->prop('status', 0);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Render method.

  /**
   * Get the HTML for a node.
   *
   * @param string $view_mode
   * @return string
   */
  public function render($view_mode = 'full') {
    return theme('node',
      array(
        'elements' => array(
          '#node'      => $this->node(),
          '#view_mode' => $view_mode,
        ),
      )
    );
  }

}
