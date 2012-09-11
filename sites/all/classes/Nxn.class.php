<?php
/**
 * User: shaun
 * Date: 2012-08-30
 * Time: 5:29 AM
 */
class Nxn {

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
   * @return Nxn
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
   * @return Nxn
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
      $q = db_update('moonmars_nxn')
        ->fields($fields)
        ->condition('nxn_id', $this->nxnId);
      $q->execute();
    }
    else {
      // Insert new nxn:
      $fields['ts_created'] = time();
      $q = db_insert('moonmars_nxn')
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
    $html = "<table style='background: none; padding: 0; border: 0; margin: 0; border-spacing: 0;'>\n";
    $grey3 = '#777';
    $td_style = "
      padding: 5px 10px 5px 0;
      margin: 0;
      border: 0;
      font-size: 12px;
      font-family: Helvetica, Arial, Tahoma, Verdana, sans-serif;
      vertical-align: top;
    ";
    foreach ($values as $label => $value) {
      $html .= "<tr>\n";
      $html .= "<td style='$td_style color: $grey3;'>$label:</td>\n";
      $html .= "<td style='$td_style color: black;'>$value</td>\n";
      $html .= "</tr>\n";
    }
    $html .= "</table>";
    return $html;
  }

  /**
   * Get an array of group details.
   *
   * @static
   * @param Group $group
   * @return array
   */
  public static function groupDetails(Group $group) {
    $details = array(
      'Group name' => "<strong>" . $group->title() . "</strong>",
      'Group tag' => '#' . $group->tag(),
      'Group page' => $group->link($group->url(TRUE), TRUE),
      'Group type' => $group->groupType(NULL, 'name'),
    );
    if ($group->description()) {
      $details['Group description'] = $group->description();
    }
    if ($group->icon()) {
      $details['Group image'] = $group->icon();
    }
    return $details;
  }

  /**
   * Generate text for a new-member nxn.
   */
  public function newMemberEmail() {
    // Get the actors:
    $member = $this->triumph->actor('member');
    $group = $this->triumph->actor('group');

    // Details:
    $details['Username'] = "<strong>" . $member->name() ."</strong>";
    $details['Profile'] = $member->link($member->url(TRUE), FALSE, TRUE);
    if ($member->fullName()) {
      $details['Full name'] = $member->fullName();
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
      $group_name = $group->title();
      $subject = "New member of the $group_name group";
      $summary = "<p>The <strong>$group_name</strong> group on moonmars.com has a new member!</p>";

      // Additional group details:
      $details = array_merge($details, self::groupDetails($group));
    }

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'message' => self::renderDetails($details),
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
    $group_name = $group->title();
    $subject = "New group created: $group_name";

    // Summary:
    $summary = "moonmars.com has a new group!";

    // Details:
    $details = self::groupDetails($group);

    // Additional details for subgroups:
    if ($parent_group) {
      $summary .= " This is a subgroup of " . $parent_group->link(NULL, TRUE) . ".</p>";
      $details['Parent group name'] = $parent_group->link(NULL, TRUE);
      $details['Parent group page'] = $parent_group->link($parent_group->url(TRUE), TRUE);
    }

    // Get HTML for details:
    $message = self::renderDetails($details);
    $message .= "<p><strong>" . l("Join the $group_name group", $group->url(TRUE) . '/join') . "</strong></p>";

    $summary = "<p>$summary</p>";

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'message' => $message,
    );
  }

  /**
   * Generate text for a new-item nxn.
   */
  public function newItemEmail() {
    // Get the item:
    $item = $this->triumph()->actor('item');

    // Get the poster:
    $poster = $item->creator();

    // Get the item's channel:
    $channel = $item->channel();

    // Get the parent entity:
    $parent_entity = $channel ? $channel->parentEntity() : NULL;

    // Get a user-friendly name for the channel:
    if ($parent_entity) {
      if ($parent_entity instanceof Member) {
        if (Member::equals($parent_entity, $this->recipient)) {
          $channel_name = 'your channel';
        }
        elseif (Member::equals($parent_entity, $poster)) {
          $channel_name = "their channel";
        }
        else {
          $channel_name = $parent_entity->name() . "'s channel";
        }
      }
      elseif ($parent_entity instanceof Group) {
        $channel_name = "the " . $parent_entity->title() . " group";
      }
    }

    // Subject:
    $subject = $poster->name() . " posted in new item in $channel_name";

    // Get a link to the item:
    $item_link = $item->link("item");

    // Create a summary of the notification:
    $summary = $poster->link() . " posted a new $item_link in " . $parent_entity->link($channel_name) . ".";

    // Add the mention part of the message:
    if ($item->textScan()->mentions($this->recipient_uid)) {
      $summary .= " You were mentioned in the $item_link.";
    }

    // @todo add a note to the summary if the item mentions a #topic they're interested in

    // @todo Add item text and comments.
    //$message = self::renderItem($item);
    // For now just show the HTML:
    $message = $item->textScan()->html();

    return array(
      'subject' => $subject,
      'summary' => "<p>$summary</p>",
      'message' => $message,
    );
  }

  /**
   * Generate text for a new-comment nxn.
   */
  public function newCommentEmail() {
//    return array(
//      'subject' => $subject,
//      'summary' => $summary,
//      'message' => $message,
//    );
  }

  /**
   * Generate the email for a notification.
   *
   * @return array
   */
  function generateEmail() {
    // Get the function name.
    // This probably seems like a weird way to do it, but I didn't want one function (this one) with about 1000 lines
    // of code to generate emails for every triumph type. So I made one method per triumph type.
    $triumphTypeParts = explode('-', $this->triumph->triumphType());
    $fn = $triumphTypeParts[0] . ucfirst($triumphTypeParts[1]) . 'Email';

    // Get the email parts:
    $email = $this->$fn();

    // Add the mandatory unsubscribe message:
    $email['unsubscribe'] = "<p>" . l("Update your notification preferences or unsubscribe from all emails.", $this->recipient->alias() . '/notifications/preferences') . "</p>";

    return $email;
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
  public static function sendOutstanding() {
    // Look for any nxns we didn't send yet:
    $q = db_select('moonmars_nxn', 'nxn')
      ->fields('nxn')
      ->condition('sent', 0)
      ->orderBy('nxn_id');
    $rs = $q->execute();
    // Create the nxns:
    $n_sent = 0;
    foreach ($rs as $rec) {
      // Reset the time limit so the script doesn't time out while sending emails.
      // Let's assume 60 seconds will be well-and-truly enough time to send a single email!
      set_time_limit(60);

      // Create an Nxn object:
      $nxn = new Nxn($rec);

      // Send the email and update the sent and dtSent properties:
      $sent = $nxn->send();

      // If it sent ok, count it:
      if ($sent) {
        $n_sent++;
      }

      // Save the nxn to update the sent and ts_sent fields in the db record:
      $nxn->save();
    }
    return $n_sent;
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

}
