<?php
namespace AstroMultimedia\MoonMars;

/**
 * Group class.
 */
class Group extends Node implements IStar {

  /**
   * The node type.
   */
  const NODE_TYPE = 'group';

  /**
   * The tag prefix.
   */
  const TAG_PREFIX = '%';

  /**
   * The group types.
   *
   * @var array
   */
  protected static $types;

  /**
   * The group's channel.
   *
   * @var string
   */
  protected $channel;

  /**
   * HTML for the group's icon.
   *
   * @var string
   */
  protected $icon;

  /**
   * The group's members.
   *
   * @var
   */
  protected $members;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Magic methods

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // IStar methods

  /**
   * Get/set the tag.
   *
   * @param null|string $tag
   * @param bool $include_prefix
   * @return string|Topic
   */
  public function tag($tag = NULL, $include_prefix = FALSE) {
    if ($tag === NULL) {
      // Get the username:
      return ($include_prefix ? self::TAG_PREFIX : '') . $this->field('field_group_tag');
    }
    else {
      // Set the username:
      return $this->field('field_group_tag', LANGUAGE_NONE, 0, 'value', $tag);
    }
  }

  /**
   * Create a link to the topic using the %tag for the link text.
   *
   * @return string
   */
  public function tagLink() {
    return $this->link($this->tag(NULL, TRUE));
  }

  /**
   * Get/set the label.
   *
   * @param null|string $label
   * @return string|Group
   */
  public function label($label = NULL) {
    return $this->title($label);
  }

  /**
   * Create a link to the group using the label for the link text.
   *
   * @return string
   */
  public function labelLink() {
    return $this->link($this->label());
  }

  /**
   * Get a group given a group tag.
   *
   * @static
   * @param $tag
   * @return Group
   */
  public static function findByTag($tag) {
    // Strip the prefix if present:
    if ($tag[0] == self::TAG_PREFIX) {
      $tag = substr($tag, 1);
    }
    $rec = db_select('field_data_field_group_tag', 'f')
      ->fields('f', array('entity_id'))
      ->condition('field_group_tag_value', $tag)
      ->execute()
      ->fetch();
    return $rec ? self::create($rec->entity_id) : FALSE;
  }

  /**
   * Update the path alias for the group's profile.
   *
   * @return string
   */
  public function resetAlias() {
    $alias = 'group/' . $this->tag();
    $this->alias($alias);
    return $alias;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get/set

  /**
   * Get the group's channel.
   *
   * @param bool $create
   * @return int
   */
  public function channel($create = TRUE) {
    if (!isset($this->channel)) {
      $this->channel = moonmars_stars_get_channel($this, $create);
    }
    return $this->channel;
  }

  /**
   * Get the title for the group's channel.
   *
   * @return string
   */
  public function channelTitle() {
    return 'Group: ' . $this->title();
  }

  /**
   * Get/set the description.
   *
   * @param string $description
   * @return mixed
   */
  public function description($description = NULL) {
    return $this->field('field_description', LANGUAGE_NONE, 0, 'value', $description);
  }

  /**
   * Get a link to the group's profile.
   *
   * @param null|string $label
   * @param bool $absolute
   * @return string
   */
  public function link($label = NULL, $absolute = FALSE) {
    $label = $label ?: $this->tag();
    return parent::link($label, $absolute);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Static methods

  /**
   * Find groups by title. Only supports exact match at present.
   *
   * @static
   * @param $title
   * @return Group
   */
  public static function searchByTitle($title) {
    $rs = db_select('node', 'n')
      ->fields('n', array('nid'))
      ->condition('type', 'group')
      ->condition('title', $title)
      ->execute();
    $matches = array();
    foreach ($rs as $rec) {
      $matches[] = self::create($rec->nid);
    }
    return $matches;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Logo

  /**
   * Get the group's logo.
   *
   * @return array
   */
  public function logo() {
    $this->load();
    return isset($this->entity->field_logo[LANGUAGE_NONE][0]) ? $this->entity->field_logo[LANGUAGE_NONE][0] : NULL;
  }

  /**
   * Render the logo HTML.
   *
   * @return array
   */
  public function renderLogo($style) {
    $logo = $this->logo();
    if ($logo) {
      $image_style = array(
        'style_name' => $style,
        'path'       => $logo['uri'],
        'alt'        => $this->title(),
      );
      return theme('image_style', $image_style);
    }
    return '';
  }

  /**
   * Generate HTML for a group icon.
   *
   * @return string
   */
  public function icon() {
    if (!$this->icon) {

      $html = '';
      $logo = $this->logo();

      if (isset($logo['uri'])) {
        // Render the icon:
        $image = array(
          'style_name' => 'sidebar-logo-90-wide',
          'path'       => $logo['uri'],
          'alt'        => $this->title(),
          'attributes' => array('class' => array('group-icon')),
        );
        $html = theme('image_style', $image);
      }

      // Remember the HTML in the property so we don't have to theme the image again:
      $this->icon = $html;
    }

    return $this->icon;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Group types

  /**
   * Get/set the group type.
   *
   * @param string $type
   * @param string $key_or_name
   *   'key' for the key, e.g. 'topic', 'society', 'business'
   *   'name' for the name, e.g. 'Topic', 'Society', 'Business'
   * @return string|Group
   */
  public function groupType($value = NULL, $key_or_name = 'key') {
    if ($value == NULL) {
      // Get the group type:
      $group_type = $this->field('field_group_type', LANGUAGE_NONE, 0, 'value');
      if ($key_or_name == 'name') {
        $group_types = self::groupTypes();
        return $group_types[$group_type];
      }
      else {
        return $group_type;
      }
    }
    else {
      // Set the group type:
      return $this->field('field_group_type', LANGUAGE_NONE, 0, 'value', $value);
    }
  }

  /**
   * Get the group types.
   *
   * @static
   * @return array
   */
  public static function groupTypes() {
    if (!isset(self::$types)) {
      $rec = db_select('field_config', 'fc')
        ->fields('fc', array('data'))
        ->condition('field_name', 'field_group_type')
        ->execute()
        ->fetch();
      $data = unserialize($rec->data);
      self::$types = $data['settings']['allowed_values'];
    }

    return self::$types;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Membership

  /**
   * Get the members of the group.
   *
   * @return array
   */
  public function members() {
    // Check if we already got them:
    if (!isset($this->members)) {

      // Get the group's members in reverse order of that in which they joined.
      $q = db_select('view_group_has_member', 'v')
        ->fields('v', array('member_uid'))
        ->condition('group_nid', $this->nid())
        ->orderBy('created', 'DESC');

      $rs = $q->execute();
      $this->members = array();
      foreach ($rs as $rec) {
        $this->members[] = Member::create($rec->member_uid);
      }
    }

    return $this->members;
  }

  /**
   * Get the number of members in a group.
   *
   * @return int
   */
  public function memberCount() {
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('rid'))
      ->condition('group_nid', $this->nid());
    $rs = $q->execute();
    return $rs->rowCount();
  }

  /**
   * Check if a user is a member of the group.
   *
   * @param Member $member
   * @return bool
   */
  public function hasMember(Member $member) {
    $rels = Relation::searchBinary('has_member', $this, $member);
    return (bool) $rels;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Admins

  /**
   * Get the admins of the group.
   *
   * @return array
   */
  public function admins() {
    // Get the group's admins in reverse order of that in which they joined the group.
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('member_uid'))
      ->condition('group_nid', $this->nid())
      ->condition('is_admin', 1)
      ->orderBy('created', 'DESC');

    $rs = $q->execute();
    $admins = array();
    foreach ($rs as $rec) {
      $admins[] = Member::create($rec->member_uid);
    }

    return $admins;
  }

  /**
   * Get the number of admins in a group.
   *
   * @return int
   */
  public function adminCount() {
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('rid'))
      ->condition('group_nid', $this->nid())
      ->condition('is_admin', 1);
    $rs = $q->execute();
    return $rs->rowCount();
  }

  /**
   * Add a new administrator to a group.
   *
   * @param Member $member
   * @return Group
   */
  public function addAdmin(Member $member) {
    $rel = Relation::createBinary('has_member', $this, $member, FALSE);
    $rel->field('field_is_admin', LANGUAGE_NONE, 0, 'value', 1);
    $rel->save();
  }

  /**
   * Check if a user is an admin of the group.
   *
   * @param Member $member
   * @return bool
   */
  public function hasAdmin(Member $member) {
    return $member->isGroupAdmin($this);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Select sets of groups

  /**
   * Get the top groups.
   *
   * @static
   * @param int $n
   * @param string $order_by_field
   * @param string $order_by_direction
   * @return array
   */
  public static function top($n, $order_by_field, $order_by_direction = 'DESC') {
    $rs = db_select('view_group', 'vg')
      ->fields('vg', array('nid'))
      ->condition('status', 1)
      ->orderBy($order_by_field, $order_by_direction)
      ->range(0, $n)
      ->execute();

    $groups = array();
    foreach ($rs as $rec) {
      $groups[] = self::create($rec->nid);
    }
    return $groups;
  }

  /**
   * Get the newest groups.
   *
   * @static
   * @param $n
   */
  public static function newest($n) {
    return self::top($n, 'created');
  }

  /**
   * Get the biggest groups.
   *
   * @static
   * @param $n
   */
  public static function biggest($n) {
    return self::top($n, 'member_count');
  }

  /**
   * Get the total number of active (published) groups.
   *
   * @static
   * @return int
   */
  public static function count() {
    return db_select('node', 'n')
      ->fields('n', array('nid'))
      ->condition('type', 'group')
      ->condition('status', 1)
      ->execute()
      ->rowCount();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Rendering

  public function renderLinks() {
    return $this->channel()->renderLinks();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Debugging

  /**
   * Debugging function.
   */
  public function dpm() {
    dpm(array(
             'object_id' => get_object_id($this),
             'entity object id' => get_object_id($this->entity),
             'nid' => $this->nid(),
             'title' => $this->title(),
        ));
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Permissions

  /**
   * Get the mode for the group.
   *
   * @return string (open, restricted, closed or announce)
   */
  public function mode() {
    return $this->field('field_group_mode');
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Items

}
