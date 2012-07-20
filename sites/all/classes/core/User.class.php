<?php
/**
 * User object.
 */
class User extends EntityBase {

  /**
   * The entity type.
   *
   * @var string
   */
  const entityType = 'user';

  /**
   * The table name.
   *
   * @var string
   */
  const table = 'users';

  /**
   * The primary key
   *
   * @var string
   */
  const primaryKey = 'uid';

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Create and delete.

  /**
   * Create a new User object.
   *
   * @param null|int|string|stdClass $user_param
   * @return User
   */
  public static function create($user_param = NULL) {
    // Get the class of the object we want to create:
    $class = get_called_class();

    if (is_null($user_param)) {
      // Create new user:
      $user_obj = new $class;
      // Assume active:
      $user_obj->entity->status = 1;
      return $user_obj;
    }
    elseif (is_uint($user_param)) {
      // uid provided. Only create the new user if not already in the cache:
      $uid = $user_param;
      if (self::inCache($uid)) {
        return self::getFromCache($uid);
      }
      else {
        // Create new user:
        $user_obj = new $class;
        // Set the uid:
        $user_obj->entity->uid = $uid;
        // Put the new user in the cache:
        $user_obj->addToCache();
        return $user_obj;
      }
    }
    elseif (is_object($user_param)) {
      // Drupal user object provided.
      $user = $user_param;
      // Get the User object:
      if ($user->uid && self::inCache($user->uid)) {
        $user_obj = self::getFromCache($user->uid);
      }
      else {
        $user_obj = new $class;
      }
      $user_obj->entity = $user;
      // Add to cache:
      $user_obj->addToCache();
      return $user_obj;
    }
    elseif (is_string($user_param)) {
      // User name provided. Load the user:
      $name = $user_param;
      $user = user_load_by_name($name);
      if (!$user) {
        return FALSE;
      }
      // Create from user object:
      return self::create($user);
    }
    else {
      trigger_error("Invalid parameter to User::create()", E_USER_ERROR);
    }
  }

  /**
   * Delete a user.
   */
  public function delete() {
    user_delete($this->uid());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Load and save.

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

    // Set the valid flag:
    $this->valid = (bool) $user;

    // If the comment was successfully loaded, update properties:
    if ($user) {
      $this->entity = $user;
      $this->loaded = TRUE;
      return $this;
    }

    trigger_error("Could not load user", E_USER_WARNING);
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
    $this->addToCache();

    return $this;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set methods.

  /**
   * Get/set the uid.
   *
   * @param int $uid
   * @return int|User
   */
  public function uid($uid = NULL) {
    if ($uid === NULL) {
      // Get the uid:
      return isset($this->entity->uid) ? $this->entity->uid : NULL;
    }
    else {
      // Set the uid:
      $this->entity->uid = $uid;
      // Add the user object to the cache if not already:
      $this->addToCache();
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
   * Get a link to the user's profile.
   */
  public function link($include_at = FALSE) {
    return l(($include_at ? '@' : '') . $this->name(), $this->alias());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Role-related methods.

  /**
   * Get the user's roles.
   *
   * @return array
   */
  public function roles() {
    $roles = $this->prop('roles');
    $role_objects = array();
    foreach ($roles as $rid => $name) {
      $role_objects[] = Role::create($rid, $name);
    }
    return $role_objects;
  }

  /**
   * Add a role to the user.
   *
   * @param mixed $role
   * @return User
   */
  public function addRole($role) {
    if (!$role instanceof Role) {
      $role = Role::create($role);
    }

    $this->entity->roles[$role->rid()] = $role->name();

    return $this;
  }

  /**
   * Remove a role from the user.
   *
   * @param mixed $role
   * @return User
   */
  public function removeRole(Role $role) {
    if (!$role instanceof Role) {
      $role = Role::create($role);
    }

    unset($this->entity->roles[$role->rid()]);
  }

  /**
   * Check if the user has a role.
   *
   * @param mixed $role
   * @return bool
   */
  public function hasRole($role) {
    if (!$role instanceof Role) {
      $role = Role::create($role);
    }

    foreach ($this->entity->roles as $rid => $name) {
      if ($rid == $role->rid()) {
        return TRUE;
      }
    }

    return FALSE;
  }

  /**
   * Check if the user is an administrator.
   *
   * @return bool
   */
  public function isAdmin() {
    return $this->hasRole('administrator');
  }

}
