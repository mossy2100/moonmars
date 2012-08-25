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
   * Quick-load properties.
   *
   * @var array
   */
  protected static $quickLoadProperties = array('subject', 'nid', 'uid');

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

      // Default status to published:
      $comment_obj->entity->status = 1;

      // Default language to none:
      $comment_obj->entity->language = LANGUAGE_NONE;

      // Default to current user:
      if (user_is_logged_in()) {
        global $user;
        $comment_obj->entity->uid = $user->uid;
        $comment_obj->entity->name = $user->name;
        $comment_obj->entity->mail = $user->mail;
      }

      // The comment is valid without a cid:
      $comment_obj->valid = TRUE;
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
      }
    }
    elseif (is_object($comment_param)) {
      // Drupal comment object provided:
      $comment = $comment_param;

      // Get the User object:
      if (isset($comment->cid) && $comment->cid && self::inCache($comment->cid)) {
        $comment_obj = self::getFromCache($comment->cid);
      }
      else {
        $comment_obj = new $class;
      }

      // Reference the provided entity object:
      $comment_obj->entity = $comment;
    }

    // If we have a comment object, add to cache and return:
    if (isset($comment_obj)) {
      $comment_obj->addToCache();
      return $comment_obj;
    }

    trigger_error("Invalid parameter to Comment::create()", E_USER_ERROR);
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

    // If we have a cid, try to load the comment:
    if (isset($this->entity->cid) && $this->entity->cid) {
      // Load by cid. Drupal caching will prevent reloading of the same comment.
      $comment = comment_load($this->entity->cid);
    }

    // Set the valid flag:
    $this->valid = (bool) $comment;

    // If the comment was successfully loaded, update properties:
    if ($comment) {
      $this->entity = $comment;
      $this->loaded = TRUE;
    }

    return $this;
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

  /**
   * OO wrapper for comment_submit.
   */
  public function submit() {
    comment_submit($this->entity);
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
   * Get/set the comment's subject.
   *
   * @param null|string
   * @return string|Comment
   */
  public function subject($subject = NULL) {
    return $this->prop('subject', $subject);
  }

  /**
   * Get/set the nid of the node that the comment is about.
   *
   * @param null|int
   * @return int|Comment
   */
  public function nid($nid = NULL) {
    return $this->prop('nid', $nid);
  }

  /**
   * Get the node that the comment is about.
   *
   * @param int
   * @return Node
   */
  public function node() {
    return Node::create($this->nid());
  }

  /**
   * Get/set the uid of the user who created the comment.
   *
   * @param null|int
   * @return int|Comment
   */
  public function uid($uid = NULL) {
    return $this->prop('uid', $uid);
  }

  /**
   * Get the comment's creator.
   *
   * @return User
   */
  public function creator() {
    return User::create($this->uid());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Status flags.

  /**
   * Get the comment status.
   *
   * @return Comment
   */
  public function published() {
    return $this->prop('status');
  }

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
