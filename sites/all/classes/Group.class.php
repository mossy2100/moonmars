<?php
/**
 * Group class.
 */
class Group extends MoonMarsNode {

  /**
   * The node type.
   */
  const nodeType = 'group';

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

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
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
      $this->channel = MoonMarsEntity::getEntityChannel($this, $create);
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
   * Get a link to the group using the channel the title.
   * Note, this produces the same result as Channel::parentEntityLink(), but sometimes you have the group object
   * rather than the channel object.
   *
   * @return string
   */
  public function channelTitleLink() {
    return $this->link($this->channelTitle());
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
   * @return mixed|Node|string
   */
  public function groupType($type = NULL) {
    return $this->field('field_group_type', LANGUAGE_NONE, 0, 'value', $type);
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
    $rels = MoonMarsRelation::searchBinary('has_member', $this, $member);
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
    // Get the group's admins in reverse order of that in which they joined.
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('admin_uid'))
      ->condition('group_nid', $this->nid())
      ->condition('is_admin', 1)
      ->orderBy('created', 'DESC');

    $rs = $q->execute();
    $admins = array();
    foreach ($rs as $rec) {
      $admins[] = Member::create($rec->admin_uid);
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
   * Check if a user is an admin of the group.
   *
   * @param Member $member
   * @return bool
   */
  public function hasAdmin(Member $member) {
    // Superuser is admin of every group:
    if ($member->uid() == 1) {
      return TRUE;
    }

    // Check if the user is a member of the group, and if they're also an admin.
    $rels = MoonMarsRelation::searchBinary('has_member', $this, $member);
    return $rels ? ((bool) $rels[0]->field('field_is_admin')) : FALSE;
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
      $groups[] = Group::create($rec->nid);
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

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Notifications

  /***
   * Send a notification message to all the members of a group.
   *
   * @param string $summary
   * @param string $text
   * @param Member $actor
   * @param Channel $channel
   * @param Item $item
   * @param ItemComment $comment
   */
  public function notifyMembers($summary, $text = NULL, Member $actor = NULL, Channel $channel = NULL, Item $item = NULL, ItemComment $comment = NULL) {
    $members = $this->members();
    foreach ($members as $member) {
      // Notify everyone in the group except the actor:
      if (!Member::equals($member, $actor)) {
        $member->notify($summary, $text, $actor, $channel, $item, $comment);
      }
    }
  }

  /***
   * Send a notification message to all the admins of a group.
   *
   * @param string $summary
   * @param string $text
   * @param Member $actor
   * @param Channel $channel
   * @param Item $item
   * @param ItemComment $comment
   */
  public function notifyAdmins($summary, $text = NULL, Member $actor = NULL, Channel $channel = NULL, Item $item = NULL, ItemComment $comment = NULL) {
    $admins = $this->admins();
    foreach ($admins as $admin) {
      // Notify all admins except the actor:
      if (!Member::equals($admin, $actor)) {
        $admin->notify($summary, $text, $actor, $channel, $item, $comment);
      }
    }
  }

}
