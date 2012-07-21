<?php
/**
 * Group class.
 */
class Group extends Node {

  /**
   * The node type.
   */
  const nodeType = 'group';

  /**
   * The group's channel.
   *
   * @var string
   */
  protected $channel;

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set methods.

  /**
   * Get the group's channel.
   *
   * @param bool $create
   * @return int
   */
  public function channel($create = TRUE) {
    if (!isset($this->channel)) {
      $this->channel = Channel::entityChannel('node', $this->nid(), $create);
    }
    return $this->channel;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Logo stuff.

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

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Membership-related methods.

  /**
   * Get the members of the group.
   *
   * @param int $offset
   * @param int $limit
   * @return array
   */
  public function members($offset = NULL, $limit = NULL) {
    // Get the group's members in reverse order of that in which they joined.
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('member_uid'))
      ->condition('group_nid', $this->nid())
      ->orderBy('created', 'DESC');

    // Set a limit if specified:
    if ($offset !== NULL && $limit !== NULL) {
      $q->range($offset, $limit);
    }

    $rs = $q->execute();
    $members = array();
    foreach ($rs as $rec) {
      $members[] = Member::create($rec->member_uid);
    }

    return $members;
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
    $rels = moonmars_relationships_get_relationships('has_member', 'node', $this->nid(), 'user', $member->uid());
    return (bool) $rels;
  }

  /**
   * Get the newest groups created.
   *
   * @static
   * @param $n
   */
  public static function newest($n) {
    $rs = db_select('node', 'n')
      ->fields('n', array('nid'))
      ->condition('type', 'group')
      ->condition('status', 1)
      ->orderBy('created', 'DESC')
      ->range(0, $n)
      ->execute();

    $groups = array();
    foreach ($rs as $rec) {
      $groups[] = Group::create($rec->nid);
    }
    return $groups;
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

}
