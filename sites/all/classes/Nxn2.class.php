<?php
/**
 * User: shaun
 * Date: 2012-08-30
 * Time: 5:29 AM
 */
class Nxn2 {

  /**
   * The unique nxn id.
   *
   * @var int
   */
  protected $nxnId;

  /**
   * The triumph.
   *
   * @var Triumph
   */
  protected $triumph;

  /**
   * The recipient.
   *
   * @var Member
   */
  protected $recipient;

  /**
   * Has the nxn email been sent?
   *
   * @var bool
   */
  protected $sent;

  /**
   * When was the nxn email sent? NULL if $sent is FALSE.
   *
   * @var StarDateTime
   */
  protected $dtSent;

  /**
   * Constructor
   *
   * @param null|int|Triumph $param1
   * @param null|Member $param2
   */
  public function __construct($param1 = NULL, $param2 = NULL) {
    if (is_uint($param1)) {
      $this->nxnId = (int) $param2;
    }
    elseif ($param1 instanceof Triumph && $param2 instanceof Member) {
      // New triumph:
      $this->triumph = $param1;
      $this->recipient = $param2;
    }
    elseif ($param1 instanceof stdClass) {
      // Copy db record:
      $this->copyRec($param1);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Load/save

  /**
   * Copy a database record into properties.
   *
   * @param $rec
   */
  public function copyRec($rec) {
    $this->nxnId = (int) $rec->nxn_id;
    $this->triumph = new Triumph($rec->triumph_id);
    $this->recipient = Member::create($rec->recipient_uid);
    $this->dtCreated = new StarDateTime($rec->ts_created);
    $this->sent = (bool) $rec->sent;
    $this->dtSent = is_null($rec->ts_sent) ? NULL : new StarDateTime($rec->ts_sent);
  }

  /**
   * Load a nxn from the db.
   *
   * @return Nxn2
   */
  public function load() {
    if ($this->nxnId) {
      $q = db_select('moonmars_nxn', 'nxn')
        ->fields('nxn')
        ->condition('nxn_id', $this->nxnId);
      $rs = $q->execute();
      $rec = $rs->fetchObject();
      if ($rec) {
        // Copy values from the record into the properties:
        $this->copyRec($rec);
      }
    }
    return $this;
  }

  /**
   * Save a nxn to the db.
   *
   * @return Nxn2
   */
  public function save() {
    $fields = array(
      'triumph_id'    => $this->triumph->id(),
      'recipient_uid' => $this->recipient->uid(),
      'sent'          => (int) $this->sent,
      'ts_sent'       => isset($this->dtSent) ? $this->dtSent->timestamp() : NULL,
    );
    if ($this->nxnId) {
      // Update existing nxn:
      $q = db_update('moonmars_nxn', 'nxn')
        ->fields($fields)
        ->condition('nxn_id', $this->nxnId);
      $q->execute();
    }
    else {
      // Insert new nxn:
      $fields['ts_created'] = time();
      $q = db_insert('moonmars_nxn', 'nxn')
        ->fields($fields);
      $this->nxnId = $q->execute();
    }
    return $this;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get/set

  /**
   * Get the nxn recipient.
   *
   * @return Member|null
   */
  public function recipient() {
    if (!isset($this->recipient)) {
      $this->load();
    }
    return $this->recipient;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Emails

  /**
   * Render a table of details for an email, i.e. use inline styles and tables.
   *
   * @param array $values
   * @return string
   */
  public function renderDetails(array $values) {
    $html = "<table style='background: none; padding: 0; border: 0; margin: 0;'>\n";
    $grey3 = '#919191';
    $style = "padding: 2px; margin: 0; border: 0; font-size: 11px; font-family: Helvetica, Arial, Tahoma, Verdana, sans-serif;";
    foreach ($values as $label => $value) {
      $html .= "<tr>\n";
      $html .= "<td style='$style color: $grey3;'>$label:</td>\n";
      $html .= "<td style='$style color: black;'>$value</td>\n";
      $html .= "</tr>\n";
    }
    $html .= "</table>";
    return $html;
  }

  /**
   * Generate text for a new-member nxn.
   */
  public function newMemberEmail() {
    // Get the actors:
    $member = $this->triumph->actor('member');
    $group = $this->triumph->actor('group');

    // Details:
    $details['Member name'] = $member->link(NULL, TRUE, TRUE);
    $details['Member page'] = $member->link($member->url(TRUE), FALSE, TRUE);
    if ($member->fullName()) {
      $details['Name'] = $member->fullName();
    }
    if ($member->age()) {
      $details['Age'] = $member->age();
    }
    if ($member->gender()) {
      $details['Gender'] = $member->gender(TRUE);
    }
    if (array_filter($member->location())) {
      $details['Location'] = $member->locationStr(TRUE);
    }

    // Check if it's a new member of a group, or of the site:
    $new_member_of = $group ? 'group' : 'site';

    if ($new_member_of == 'site') {
      $subject = "New member of moonmars.com";
      $summary = "<p>moonmars.com has a new member!</p>";
    }
    else {
      $subject = "New member of the " . $group->title() . " group";
      $summary = "<p>The " . $group->title() . " group on moonmars.com has a new member!</p>";

      // Additional group details:
      $details['Group name'] = $group->link(NULL, TRUE);
      $details['Group page'] = $group->link($group->url(TRUE), TRUE);
      $details['Number of members'] = $group->memberCount();
    }

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
    );
  }

  /**
   * Generate text for a new-group nxn.
   */
  public function newGroupEmail() {
    // Get the actors:
    $group = $this->triumph->actor('group');
    $parent_group = $this->triumph->actor('parent group');

    // Subject:
    $subject = "New group created";

    // Summary:
    $summary = "moonmars.com has a new group!";

    // Details:
    $details['Group name'] = $group->link(NULL, TRUE);
    $details['Group page'] = $group->link($group->url(TRUE), TRUE);
    if ($group->description()) {
      $details['Description'] = $group->description();
    }
    if ($group->icon()) {
      $details['Logo'] = $group->icon();
    }

    // Additional details for subgroups:
    if ($parent_group) {
      $summary .= " This is a subgroup of " . $parent_group->link(NULL, TRUE) . ".</p>";
      $details['Parent group name'] = $parent_group->link(NULL, TRUE);
      $details['Parent group page'] = $parent_group->link($parent_group->url(TRUE), TRUE);
      $details['Number of members'] = $parent_group->memberCount();
    }

    $join_link = l("Join the " . $group->title() . " group!", $group->url(TRUE) . '/join');
    $summary = "<p>$summary <strong>$join_link</strong></p>";

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
    );
  }

  /**
   * Generate text for a new-item nxn.
   */
  public function newItemEmail() {
//    return array(
//      'subject' => $subject,
//      'summary' => $summary,
//      'details' => $details,
//    );
  }

  /**
   * Generate text for a new-comment nxn.
   */
  public function newCommentEmail() {
//    return array(
//      'subject' => $subject,
//      'summary' => $summary,
//      'details' => $details,
//    );
  }

  /**
   * Generate the email for a notification.
   *
   * @return array
   */
  function generateEmail() {
    // Get the function name and call it.
    // This probably seems like a weird way to do it, but I didn't want one function (this one) with about 1000 lines
    // of code to generate emails for every triumph type. So I made one method per triumph type.
    $triumphTypeParts = explode('-', $this->triumph->triumphType());
    $fn = $triumphTypeParts[0] . ucfirst($triumphTypeParts[1]) . 'Email';
    return $this->$fn();
  }

  /**
   * Send the nxn.
   *
   * @return bool
   *   TRUE on success, else FALSE
   */
  public function send() {
    // Generate and send the email:
    drupal_mail('moonmars_nxn', 'nxn', $this->recipient()->mail(), language_default(), $this->generateEmail());

    // Update the sent properties:
    $this->sent = TRUE;
    $this->dtSent = StarDateTime::now();
  }

  /**
   * Send all outstanding nxns.
   *
   * @static
   * @return int
   *   The number of nxns sent.
   */
  public static function sendAllOutstanding() {
    // Look for any nxns we didn't send yet:
    $q = db_select('moonmars_nxn', 'mmn')
      ->fields('mmn')
      ->condition('sent', 0)
      ->orderBy('nxn_id');
    $rs = $q->execute();
    // Create the nxns:
    foreach ($rs as $rec) {
      // Reset the time limit so the script doesn't time out while sending emails.
      // Let's assume 60 seconds will be ample time for a single iteration of this loop.
      set_time_limit(60);

      // Create an nxn object:
      $nxn = new Nxn2($rec);
      // Send the email and update the sent and dtSent properties:
      $nxn->send();
      // Save the nxn to update the sent and ts_sent fields in the db record:
      $nxn->save();
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Static methods

  /**
   * Get all the members who may want to be notified about a new thing.
   * i.e. they selected Yes or Some.
   * This is a bit faster than checking everyone, as we can easily filter out all the people who selected 'No'.
   *
   * @static
   * @param $nxn_category
   * @param $triumph_type
   * @return array
   */
  public static function mayWant($nxn_category, $triumph_type) {
    // Find out who might want (wants = YES or SOME) notifications about this triumph.
    $q = db_select('moonmars_nxn_pref', 'np')
      ->fields('np', array('uid'))
      ->condition('nxn_category', $nxn_category)
      ->condition('triumph_type', $triumph_type)
      ->condition('nxn_wants', array(MOONMARS_NXN_YES, MOONMARS_NXN_SOME));
    $rs = $q->execute();

    // Get the members:
    $members = array();
    foreach ($rs as $rec) {
      $members[$rec->uid] = Member::create($rec->uid);
    }

    return $members;
  }

//  /**
//   * Get the unsent nxns.
//   *
//   * @todo add $daily_digest flag so we can filter for people who just want the once-per-day email, or not.
//   *
//   * @static
//   * @return array
//   */
//  public static function getUnsent() {
//    $q = db_select('moonmars_nxn', 'nxn')
//      ->fields('nxn')
//      ->condition('sent', FALSE)
//      ->orderBy('ts_created');
//    $rs = $q->execute();
//    $nxns = array();
//    foreach ($rs as $rec) {
//      $nxns[$rec->nxn_id] = new Nxn2($rec);
//    }
//    return $nxns;
//  }
}
