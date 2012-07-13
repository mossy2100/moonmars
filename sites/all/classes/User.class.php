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
  protected static $entityType = 'user';

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
   * @param null|int|string|stdClass $user_param
   * @return User
   */
  public static function create($class = 'User', $user_param = NULL) {
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
      return self::create($class, $user);
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
  // Caching methods.

  /**
   * Add a user to the cache.
   *
   * @return bool
   */
  public function addToCache() {
    parent::addToCache(self::$entityType);
  }

  /**
   * Check if a user is in the cache.
   *
   * @param int $entity_id
   * @return bool
   */
  public static function inCache($entity_id) {
    return parent::inCache(self::$entityType, $entity_id);
  }

  /**
   * Get a user from the cache.
   *
   * @param int $entity_id
   * @return Node
   */
  public static function getFromCache($entity_id) {
    return parent::getFromCache(self::$entityType, $entity_id);
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
    $this->addToCache();

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
  public function link($include_at = FALSE) {
    return l(($include_at ? '@' : '') . $this->name(), $this->alias());
  }

}
