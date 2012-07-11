<?php
/**
 * User object.
 */
class User extends Entity {

  /**
   * Create a new User object.
   *
   * @param int $uid
   */
  public static function create($uid = NULL) {
    if (is_null($uid)) {
      // Create new user:
      $user = new User;
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
        $user = new User;
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
   * Get/set the member's name.
   *
   * @param string $name
   * @return string|User
   */
  public function name($name = NULL) {
    if (func_num_args() == 0) {
      // Get the member's name:
      if (!$this->entity->name) {
        // If we don't have the name yet, just load the name:
        $this->entity->name = db_select('users', 'u')
          ->fields('u', array('name'))
          ->condition('uid', $this->entity->uid)
          ->execute()
          ->fetch()
          ->name;
      }
      return $this->entity->name;
    }
    else {
      // Set the member's name:
      $this->entity->name = $name;
      return $this;
    }
  }

  /**
   * Get the user object.
   *
   * @return stdClass
   */
  public function user() {
    return $this->entity;
  }

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
    $this->entity = user_save($this->entity);
    return $this;
  }

  /**
   * Get the path to the member's profile.
   */
  public function path() {
    return "user/$this->entity->uid";
  }

  /**
   * Get the path alias to the member's profile.
   */
  public function alias() {
    return drupal_get_path_alias("user/$this->entity->uid");
  }

  /**
   * Get a link to the member's profile.
   */
  public function link() {
    return l($this->name(), "user/$this->entity->uid");
  }

}
