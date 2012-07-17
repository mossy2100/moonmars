<?php
/**
 * Comment class.
 */
class Comment extends EntityBase {

  /**
   * The entity type.
   *
   * @var string
   */
  const entityType = 'comment';

  /**
   * The table name.
   *
   * @var string
   */
  const table = 'comment';

  /**
   * The primary key
   *
   * @var string
   */
  const primaryKey = 'cid';

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Create and delete.

  /**
   * Create a new Comment object.
   *
   * @param null|int|stdClass $comment_param
   * @return Comment
   */
  public static function create($comment_param = NULL) {
    // Get the class of the object we want to create:
    $class = get_called_class();

    if (is_null($comment_param)) {
      // Create new comment:
      $comment_obj = new $class;
      // Assume published:
      $comment_obj->entity->status = 1;
      return $comment_obj;
    }
    elseif (is_uint($comment_param)) {
      // cid provided:
      $cid = $comment_param;
      // Only create the new comment if not already in the cache:
      if (self::inCache($cid)) {
        return self::getFromCache($cid);
      }
      else {
        // Create new comment:
        $comment_obj = new $class;
        // Set the cid:
        $comment_obj->entity->cid = $cid;
        // Put the new comment in the cache:
        $comment_obj->addToCache();
        return $comment_obj;
      }
    }
    elseif (is_object($comment_param)) {
      // Drupal comment object provided:
      $comment = $comment_param;
      // Get the User object:
      if ($comment->cid && self::inCache($comment->cid)) {
        $comment_obj = self::getFromCache($comment->cid);
      }
      else {
        $comment_obj = new $class;
      }
      $comment_obj->entity = $comment;
      // Add to cache:
      $comment_obj->addToCache();
      return $comment_obj;
    }
    else {
      trigger_error("Invalid parameter to Comment::create()", E_USER_ERROR);
    }
  }

  /**
   * Delete a comment.
   */
  public function delete() {
    comment_delete($this->cid());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Load and save.

  /**
   * Load the comment object.
   *
   * @return Comment
   */
  public function load() {
    // Avoid reloading:
    if ($this->loaded) {
      return $this;
    }

    // Default result:
    $comment = FALSE;

    // Try to load the comment:
    if (isset($this->entity->cid) && $this->entity->cid > 0) {
      // Load by cid. Drupal caching will prevent reloading of the same comment.
      $comment = comment_load($this->entity->cid);
    }

    // Set the valid flag:
    $this->valid = (bool) $comment;

    // If the comment was successfully loaded, update properties:
    if ($comment) {
      $this->entity = $comment;
      $this->loaded = TRUE;
      return $this;
    }

    trigger_error("Could not load comment", E_USER_WARNING);
  }

  /**
   * Save the comment object.
   *
   * @return Comment
   */
  public function save() {
    // Save the comment:
    comment_save($this->entity);

    // If the comment is new then we should add it to the cache:
    $this->addToCache();

    return $this;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set.

  /**
   * Get/set the cid.
   *
   * @param int $cid
   * @return int|Comment
   */
  public function cid($cid = NULL) {
    if ($cid === NULL) {
      // Get the cid:
      return $this->entity->cid;
    }
    else {
      // Set the cid:
      $this->entity->cid = $cid;
      // Add the comment object to the cache if not already:
      $this->addToCache();
      return $this;
    }
  }

  /**
   * Get the comment object.
   *
   * @return stdClass
   */
  public function comment() {
    $this->load();
    return $this->entity;
  }

  /**
   * Get the comment's subject.
   *
   * @return string
   */
  public function subject() {
    return $this->getProperty('subject', TRUE);
  }

  /**
   * Get the uid of the user who created the comment.
   *
   * @return int
   */
  public function uid() {
    return $this->getProperty('uid', TRUE);
  }

  /**
   * Get the comment's creator.
   *
   * @return User
   */
  public function creator() {
    return User::create($this->uid());
  }

  /**
   * Get the nid of the node that the comment is about.
   *
   * @return int
   */
  public function nid() {
    return $this->getProperty('nid', TRUE);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Status flags.

  /**
   * Publish the comment, i.e. set the status flag to 1.
   *
   * @return Comment
   */
  public function publish() {
    return $this->prop('status', 1);
  }

  /**
   * Unpublish the comment, i.e. set the status flag to 0.
   *
   * @return Comment
   */
  public function unpublish() {
    return $this->prop('status', 0);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Rendering.

  /**
   * Get the HTML for a comment.
   *
   * @param $comment
   * @return mixed|string
   */
  public function render() {
    // Make sure the comment is loaded:
    $this->load();

    // Get the node that the comment is about:
    $node = node_load($this->entity->nid);

    // Build the content. This sets the content property.
    comment_build_content($this->entity, $node);

    // Theme the comment:
    return theme('comment',
      array(
        'elements' => array(
          '#comment' => $this->entity,
          '#node'    => $node,
        ),
        'content'  => $this->entity->content
      )
    );
  }

}
