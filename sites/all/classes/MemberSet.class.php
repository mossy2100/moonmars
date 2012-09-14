<?php
/**
 * User: shaun
 * Date: 2012-09-12
 * Time: 8:42 PM
 *
 * A set of members.
 */
class MemberSet {

  /**
   * An array of members to store the set.
   * Member uids are keys. No duplicates. Order not important.
   *
   * @var array
   */
  protected $members;

  /**
   * Constructor
   */
  public function __construct() {
    $this->set = array();
  }

  /**
   * Add a member to the set.
   * Supports both single Member objects and arrays of Member objects.
   *
   * @param Member|array $member
   */
  public function add($members) {
    // Make sure we have an array:
    if ($members instanceof Member) {
      $members = array($members);
    }
    if (!is_array($members)) {
      trigger_error("Invalid parameter to MemberSet::add(). Must be a Member or array of Members.", E_USER_WARNING);
    }

    // Add each member in the array:
    foreach ($members as $member) {
      // By using the member uid as the key, we prevent duplicates.
      $this->members[$member->uid()] = $member;
    }
  }

  /**
   * Remove a member from the set.
   * Supports both single Member objects and arrays of Member objects.
   *
   * @param Member|array $member
   */
  public function remove($members) {
    // Make sure we have an array:
    if ($members instanceof Member) {
      $members = array($members);
    }
    if (!is_array($members)) {
      trigger_error("Invalid parameter to MemberSet::add(). Must be a Member or array of Members.", E_USER_WARNING);
    }

    // Remove each member in the array:
    foreach ($members as $member) {
      // By using the member uid as the key, it's easy to find the member to remove.
      unset($this->members[$member->uid()]);
    }
  }

  /**
   * Get the array of members.
   *
   * @return array
   */
  public function members() {
    return $this->members;
  }

  /**
   * Get the number of members in the set.
   *
   * @return int
   */
  public function count() {
    return count($this->members);
  }

}
