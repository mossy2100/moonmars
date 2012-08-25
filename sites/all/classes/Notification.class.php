<?php
/**
 * Encapsulates an notification node.
 */
class Notification extends MoonMarsNode {

  /**
   * The node type.
   */
  const nodeType = 'notification';

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set methods.

  /**
   * Get/set the notification message.
   *
   * @param null|string $message
   */
  public function message($message = NULL) {
    return $this->field('field_notification_message', LANGUAGE_NONE, 0, 'value', $message);
  }

  /**
   * Get the notification recipient.
   * Overrides base class method, which returns User.
   *
   * @return Member
   */
  public function recipient() {
    return Member::create($this->uid());
  }

  /**
   * Get all the members who may want to be notified about a new thing.
   *
   * @static
   * @param string $category
   * @param string $thing
   * @return array
   */
  public static function whoWants($category, $thing) {
    $field = $category . '_' . $thing . '_nxn';
    $q = db_select('view_member', 'vm')
      ->fields('vm', array('uid'))
      ->condition($field, array('some', 'all'));
    $rs = $q->execute();
    $members = array();
    foreach ($rs as $rec) {
      $members[] = Member::create($rec->uid);
    }
    return $members;
  }

  /**
   * When something new is created ('category thing', e.g. site member, channel item, followee comment, group comment,
   * etc.) check a list of members to see who wants to be notified about it, and add them to a list of recipients.
   *
   * @static
   * @param string $category
   * @param string $thing
   * @param array $recipients
   * @param array $members
   */
  public static function collectRecipients($category, $thing_type, $thing, $members, array &$recipients) {
    // In case we were just passed one member, convert to an array:
    if (!is_array($members)) {
      $members = array($members);
    }

    foreach ($members as $member) {
      $which_nxns = $member->whichNotifications($category, $thing_type);

      switch ($which_nxns['new']) {
        case 'all':
          $recipients[$member->uid()] = $member;
          break;

        case 'some':
          foreach ($which_nxns['which'] as $which_nxn) {
            switch ($which_nxn) {
              case 'country':
                // Applies to new members.
                // Notify the member of the new member is from the same country as them.
                if ($thing->countryCode() == $member->countryCode()) {
                  $recipients[$member->uid()] = $member;
                }
                break;

              case 'event':
              case 'project':
                // Applies to new groups.
                // Notify the member if the group type matches.
                if ($thing->groupType() == $which_nxn) {
                  $recipients[$member->uid()] = $member;
                }
                break;

              case 'mention':
                // Applies to items and comments.
                if ($thing->textScan()->mentions($member)) {
                  $recipients[$member->uid()] = $member;
                }
                break;

              case 'topic':
                // Applies to new groups, items and comments.
                //        if ($thing->matchesMemberTopics($member)) {
                //          $recipients[$member->uid()] = $member;
                //        }
                break;

              case 'item':
                // Applies to new comments.
                // Notify the member if the comment is on an item they posted:
                if ($thing->item()->uid() == $member->uid()) {
                  $recipients[$member->uid()] = $member;
                }
                break;

              case 'comment':
                // Applies to new comments.
                // Notify the member if the comment is on an item they've commented on:
                if ($member->commentedOn($thing->item())) {
                  $recipients[$member->uid()] = $member;
                }
                break;
            } // switch
          } // foreach
          break;
      } // switch

    } // foreach members
  } // collectRecipients

}
