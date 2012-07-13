<?php
/**
 * Group class.
 */
class Group extends Node {

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  /**
   * Create a new Group object.
   *
   * @param int $nid
   * @return Group
   */
  public static function create($nid = NULL) {
    return parent::create(__CLASS__, $nid);
  }

  /**
   * Get the group's channel.
   *
   * @param bool $create
   * @return int
   */
  public function channel($create = TRUE) {
    return Channel::entityChannel('node', $this->nid(), $create);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Membership-related stuff.

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
   * Add a member to the group.
   *
   * @param Member $member
   */
  public function addMember(Member $member) {
    // Create the membership relationship:
    moonmars_relationships_update_relationship('has_member', 'node', $this->nid(), 'user', $member->uid());
  }

  /**
   * Remove a member from the group.
   *
   * @param Member $member
   */
  public function removeMember(Member $member) {
    // Delete the membership relationship:
    moonmars_relationships_delete_relationships('has_member', 'node', $this->nid(), 'user', $member->uid());
  }

}
