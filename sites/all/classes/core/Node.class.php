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
  const ENTITY_TYPE = 'node';

  /**
   * The database table name.
   *
   * @var string
   */
  const DB_TABLE = 'node';

  /**
   * The primary key.
   *
   * @var string
   */
  const PRIMARY_KEY = 'nid';

  /**
   * The class to use for comments.
   *
   * @var string
   */
  const COMMENT_CLASS = 'Comment';

  /**
   * Constructor.
   */
  protected function __construct() {
    // Create the object:
    parent::__construct();

    // Set the node type:
    $class = get_called_class();
    $this->entity->type = $class::nodeType;
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
      $node_obj->entity->type = $class::NODE_TYPE;

      // Default status to published:
      $node_obj->entity->status = 1;

      // Default language to none:
      $node_obj->entity->language = LANGUAGE_NONE;

      // Default user to current user:
      $node_obj->entity->uid = user_is_logged_in() ? $GLOBALS['user']->uid : NULL;

      // The node is valid without a nid:
      $node_obj->valid = TRUE;
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
      if (isset($node->nid) && $node->nid && self::inCache($node->nid)) {
        $node_obj = self::getFromCache($node->nid);
      }
      else {
        $node_obj = new $class;
      }

      // Reference the provided entity object:
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

    // If we have a nid, try to load the node:
    if (isset($this->entity->nid) && $this->entity->nid) {
      // Load by nid. Drupal caching will prevent reloading of the same node.
      $node = node_load($this->entity->nid);
    }

    // Set the valid flag:
    $this->valid = (bool) $node;

    // If the node was successfully loaded, update properties:
    if ($node) {
      $this->entity = $node;
      $this->loaded = TRUE;
    }

    return $this;
  }

  /**
   * Save the node object.
   *
   * @return Node
   */
  public function save() {
    // Ensure the node is loaded:
    $this->load();

    // We must set the pathauto flag so any custom alias doesn't get clobbered.
    $this->setPathauto();

    // Save the node:
    node_save($this->entity);

    // In case the node is new, add it to the cache:
    $this->addToCache();

    return $this;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set.

  /**
   * Get the quick-load properties.
   *
   * @static
   * @return array
   */
  protected static function quickLoadProperties() {
    return array('title', 'type', 'uid');
  }

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
   * Get/set the node's title.
   *
   * @param null|string
   * @return string|Node
   */
  public function title($title = NULL) {
    return $this->prop('title', $title);
  }

  /**
   * Get/set the node's type.
   *
   * Note as a rule we never say just 'type' because it's far too easy to get node type, entity type, field type,
   * relation type, etc., mixed up, which is a source of bugs.
   *
   * @param null|string
   * @return string|Node
   */
  public function nodeType($type = NULL) {
    // If getting the nodeType we could return self::NODE_TYPE here. However, one use of this function can be to check
    // if the node in the class is the correct type.
    return $this->prop('type', $type);
  }

  /**
   * Get/set the node's uid.
   *
   * @param null|int
   * @return int|Node
   */
  public function uid($uid = NULL) {
    return $this->prop('uid', $uid);
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
   * Get a link to the node's page.
   *
   * @return string
   */
  public function link($label = NULL, $absolute = FALSE) {
    $label = ($label === NULL) ? $this->title() : $label;
    return l($label, $this->url($absolute));
  }

  /**
   * Get the node's comments.
   *
   * @param bool|null $published
   *   NULL for all comments
   *   TRUE for published comments (default)
   *   FALSE for unpublished comments
   */
  public function comments($published = TRUE) {
    // Get the comment class:
    $node_class = get_called_class();
    $comment_class = $node_class::COMMENT_CLASS;

    // Get the comments:
    $q = db_select('comment', 'c')
      ->fields('c', array('cid'))
      ->condition('nid', $this->nid());

    // Set the published condition if specified:
    if (is_bool($published)) {
      $q->condition('status', (int) $published);
    }

    $rs = $q->execute();
    $comments = array();
    foreach ($rs as $rec) {
      $comments[] = $comment_class::create($rec->cid);
    }
    return $comments;
  }

  /**
   * Find out how many comments the node has.
   *
   * @param bool|null $published
   *   NULL for all comments
   *   TRUE for published comments (default)
   *   FALSE for unpublished comments
   */
  public function commentCount($published = TRUE) {
    $q = db_select('comment', 'c')
      ->fields('c', array('cid'))
      ->condition('nid', $this->nid());

    // Set the published condition if specified:
    if (is_bool($published)) {
      $q->condition('status', (int) $published);
    }

    return $q->execute()->rowCount();
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
   * @param bool $include_comments
   * @param string $view_mode
   * @return string
   */
  public function render($include_comments = FALSE, $view_mode = 'full') {
    $node = $this->node();
    $node_view = node_view($node, $view_mode);
    if ($include_comments) {
      $node_view['comments'] = comment_node_page_additions($node);
    }
    return render($node_view);
  }

}
