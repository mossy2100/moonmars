<?php
/**
 * Group class.
 */
class Group extends Node {

  /**
   * Get the relationship for a user being a member of a group.
   *
   * @param int $uid
   * @return object
   */
  public function memberRelationship($uid) {
    // Look for a relationship record:
    $rels = moonmars_relationships_get_relationships('has_member', 'node', $this->entity->nid, 'user', $uid);
    return $rels ? $rels[0] : FALSE;
  }

  /**
   * Check if a user is a member of the group.
   *
   * @param int $uid
   * @return bool
   */
  function isMember($uid) {
    return (bool) $this->memberRelationship($uid);
  }

  /**
   * Get the members of the group.
   *
   * @param int $offset
   * @param int $limit
   * @return array
   */
  function members($offset = NULL, $limit = NULL) {
    // Get the group's members in reverse order of that in which they joined.
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('member_uid'))
      ->condition('group_nid', $this->entity->nid)
      ->orderBy('created', 'DESC');

    // Set a limit if specified:
    if ($offset !== NULL && $limit !== NULL) {
      $q->range($offset, $limit);
    }

    $rs = $q->execute();
    $member_uids = array();
    foreach ($rs as $rec) {
      $member_uids[] = $rec->member_uid;
    }

    return $member_uids;
  }

  /**
   * Get the number of members in a group.
   *
   * @return int
   */
  public function memberCount() {
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('rid'))
      ->condition('group_nid', $this->entity->nid);
    $rs = $q->execute();
    return $rs->rowCount();
  }

}
