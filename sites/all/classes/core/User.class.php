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
   * Quick-load properties.
   *
   * @var array
   */
  protected static $quickLoadProperties = array('name', 'mail');

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
   * @param null|int|stdClass $user_param
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

      // Without a uid the user is valid:
      $user_obj->valid = TRUE;
    }
    elseif (is_uint($user_param)) {
      // uid provided.
      $uid = $user_param;

      // Only create the new node if not already in the cache:
      if (self::inCache($uid)) {
        return self::getFromCache($uid);
      }
      else {
        // Create new user:
        $user_obj = new $class;

        // Set the uid:
        $user_obj->entity->uid = $uid;
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

      // Reference the provided entity object:
      $user_obj->entity = $user;
    }

    // If we have a user object, add to cache and return:
    if (isset($user_obj)) {
      $user_obj->addToCache();
      return $user_obj;
    }

    trigger_error("Invalid parameter to User::create()", E_USER_ERROR);
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
    else {
      // Can't load the user:
      return $this;
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
   * Get/set the user's name.
   *
   * @param null|string
   * @return string|User
   */
  public function name($name = NULL) {
    return $this->prop('name', $name);
  }

  /**
   * Get/set the user's mail.
   *
   * @param null|string
   * @return string|User
   */
  public function mail($mail = NULL) {
    return $this->prop('mail', $mail);
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
