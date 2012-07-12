<?php
/**
 * User object.
 */
class User extends EntityBase {

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  /**
   * Create a new User object.
   *
   * @param string $class
   * @param int $uid
   * @return User
   */
  public static function create($class = 'User', $uid = NULL) {
    if (is_null($uid)) {
      // Create new user:
      $user = new $class;
      // Assume active:
      $user->entity->status = 1;
      return $user;
    }
    elseif (is_uint($uid)) {
      // Only create the new user if not already in the cache:
      if (self::inCache('user', $uid)) {
        return self::getFromCache('user', $uid);
      }
      else {
        // Create new user:
        $user = new $class;
        // Set the uid:
        $user->entity->uid = $uid;
        // Put the new user in the cache:
        $user->addToCache('user', $uid);
        return $user;
      }
    }
    else {
      trigger_error("Invalid parameter to User::create()", E_USER_ERROR);
    }
  }

  /**
   * Get/set the uid.
   *
   * @param int $uid
   * @return int|User
   */
  public function uid($uid = NULL) {
    if (func_num_args() == 0) {
      // Get the uid:
      return $this->entity->uid;
    }
    else {
      // Set the uid:
      $this->entity->uid = $uid;
      // Add the user object to the cache if not already:
      $this->addToCache('user', $uid);
      return $this;
    }
  }

  /**
   * Get the entity id.
   *
   * @return int
   */
  public function id() {
    return $this->uid();
  }

  /**
   * Get the user object.
   *
   * @return stdClass
   */
  public function user() {
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
    return parent::getProperty('users', 'uid', $property, $quick_load);
  }

  /**
   * Get the user's name.
   *
   * @return string
   */
  public function name() {
    return $this->getProperty('name', TRUE);
  }

  /**
   * Get the user's mail.
   *
   * @return string
   */
  public function mail() {
    return $this->getProperty('mail', TRUE);
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
   * Load the user object.
   *
   * @return User
   */
  public function load() {
    // Avoid reloading:
    if ($this->loaded) {
      return $this;
    }

    // Default result:
    $user = FALSE;

    // Try to load the user:
    if (isset($this->entity->uid) && $this->entity->uid > 0) {
      // Load by uid. Drupal caching will prevent reloading of the same user.
      $user = user_load($this->entity->uid);
    }
    elseif (isset($this->entity->name) && $this->entity->name != '') {
      // Load by name:
      $user = user_load_by_name($this->entity->name);
    }
    elseif (isset($this->entity->mail) && $this->entity->mail != '') {
      // Load by mail:
      $user = user_load_by_mail($this->entity->mail);
    }

    if ($user) {
      // Success. Update properties:
      $this->entity = $user;
      $this->loaded = TRUE;
      return $this;
    }
    else {
      trigger_error("Can't load user without a valid identifier.", E_USER_ERROR);
    }
  }

  /**
   * Save the user object.
   *
   * @return User
   */
  public function save() {
    // Save the user:
    $this->entity = user_save($this->entity);

    // If the user is new then we should add it to the cache:
    $this->addToCache('user', $this->entity->nid);

    return $this;
  }

  /**
   * Get the path to the member's profile.
   */
  public function path() {
    return 'user/' . $this->entity->uid;
  }

  /**
   * Get the path alias to the member's profile.
   */
  public function alias() {
    return drupal_get_path_alias($this->path());
  }

  /**
   * Get a link to the member's profile.
   */
  public function link() {
    return l($this->name(), $this->alias());
  }

}
