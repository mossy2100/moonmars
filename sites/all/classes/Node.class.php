<?php
/**
 * Node class.
 */
class Node extends Entity {

  /**
   * Create a new Node object.
   *
   * @param int $nid
   */
  public static function create($nid = NULL) {
    if (is_null($nid)) {
      // Create new node:
      $node = new Node;
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
        $node = new Node;
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
   * Get/set the node title.
   *
   * @param string $title
   * @return string|Node
   */
  public function title($title = NULL) {
    if (func_num_args() == 0) {
      // Get the node's title:
      if (!$this->entity->title) {
        // If we don't have the title yet, just load the title:
        $this->entity->title = db_select('nodes', 'n')
          ->fields('n', array('title'))
          ->condition('nid', $this->entity->nid)
          ->execute()
          ->fetch()
          ->title;
      }
      return $this->entity->title;
    }
    else {
      // Set the node's title:
      $this->entity->title = $title;
      return $this;
    }
  }

  /**
   * Get the node object.
   *
   * @return stdClass
   */
  public function node() {
    return $this->entity;
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
      trigger_error("Can't load node without a valid identifier.", E_USER_ERROR);
    }
  }

  /**
   * Save the node object.
   *
   * @return Node
   */
  public function save() {
    $this->entity = node_save($this->entity);
    return $this;
  }

  /**
   * Get the path to the node's page.
   */
  public function path() {
    return "node/$this->entity->nid";
  }

  /**
   * Get the path alias to the node's page.
   */
  public function alias() {
    return drupal_get_path_alias("node/$this->entity->nid");
  }

  /**
   * Get a link to the node's profile.
   */
  public function link() {
    return l($this->title(), "node/$this->entity->nid");
  }

}
