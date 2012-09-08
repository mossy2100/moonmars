<?php

/**
 * Encapsulates an notification node.
 */
class Nxn extends MoonMarsNode {

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
   * Get/set the notification subject.
   *
   * @param null|string $subject
   */
  public function subject($subject = NULL) {
    return $this->title($subject);
  }

  /**
   * Get/set the notification message.
   *
   * @param null|string $message
   */
  public function message($message = NULL) {
    return $this->field('field_nxn_message', LANGUAGE_NONE, 0, 'value', $message);
  }

  /**
   * Get the notification recipient.
   * Overrides base class method, which returns User.
   * @todo this needs to be updated to return multiple recipients
   *
   * @return Member
   */
  public function recipient() {
    return Member::create($this->uid());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Special

  /**
   * Get all the members who may want to be notified about a new thing.
   *
   * @static
   * @param string $category
   * @param string $thing
   * @return array
   */
  public static function mayWantNxnNew($category, $thing) {
    $col = $category . '_' . $thing . '_nxn';
    $q = db_select('view_member', 'vm')
      ->fields('vm', array('uid'))
      ->condition($col, array('some', 'all'));
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
   * @param string $nxn_category
   * @param string $nxn_type
   * @param string $thing
   * @param array $members
   * @param array $recipients
   */
  public static function collectRecipients($nxn_category, $nxn_type, $thing, array $members, array &$recipients) {
    // In case we were just passed one member, convert to an array:
    if (!is_array($members)) {
      $members = array($members);
    }

    foreach ($members as $member) {
      // Does the member want this nxn?
      $wants_nxn = $member->wantsNxn($nxn_category, $nxn_type);

      if (is_bool($wants_nxn)) {
        if ($wants_nxn) {
          // Add them to the list:
          $recipients[$member->uid()] = $member;
        }
      }
      else {
        // Check the conditions:
        foreach ($wants_nxn as $nxn_condition) {
          switch ($nxn_condition) {

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
              // Could be extended to all group types.
              if ($thing->groupType() == $nxn_condition) {
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
              // @todo
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
      } // else
    } // foreach members
  } // collectRecipients

  /**
   * Get the default preference for a certain notification.
   *
   * @static
   * @param string $nxn_category
   * @param string $nxn_type
   * @return bool|array
   */
  public static function defaultPref($nxn_category, $nxn_type) {
    $default_prefs = self::defaultPrefs();
    return $default_prefs[$nxn_category][$nxn_type];
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Send

  /**
   * Send a notification to one or mote recipients.
   *
   * @param $recipients
   */
  public function send($recipients) {
    if ($recipients instanceof Member) {
      $recipients = array($recipients);
    }

    foreach ($recipients as $recipient) {
      $recipient->notify();
    }
  }
}
