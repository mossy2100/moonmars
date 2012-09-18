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
   * Has the nxn been loaded?
   *
   * @var bool
   */
  protected $loaded;
  
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
   * When was the nxn created? FALSE if not created yet.
   *
   * @var bool|MoonMarsDateTime
   */
  protected $created;

  /**
   * When was the nxn sent? FALSE if not sent yet.
   *
   * @var bool|MoonMarsDateTime
   */
  protected $sent;

  /**
   * The nxn subject.
   *
   * @var string
   */
  protected $subject;

  /**
   * The nxn summary, with links.
   *
   * @var string
   */
  protected $summary;

  /**
   * The nxn preview, which is a line of text.
   *
   * @var string
   */
  protected $preview;

  /**
   * The full nxn message, with details, comments, etc.
   *
   * @var string
   */
  protected $message;

  /**
   * Has the nxn been generated?
   *
   * @var bool
   */
  protected $generated = FALSE;

  /**
   * Constructor
   *
   * @param null|int $param1
   */
  public function __construct($param1 = NULL) {
    if ($param1 === NULL) {
      // New nxn:
      $this->loaded = FALSE;
      $this->created = FALSE;
      $this->sent = FALSE;
    }
    elseif (is_uint($param1)) {
      // nxn_id provided:
      $this->nxnId = (int) $param1;
      $this->loaded = FALSE;
    }
    elseif ($param1 instanceof stdClass) {
      // Copy db record:
      $this->copyRec($param1);
      $this->loaded = TRUE;
    }
    else {
      trigger_error("Nxn::__construct() - Invalid parameter.", E_USER_WARNING);
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
    $this->created = new MoonMarsDateTime($rec->created);
    $this->sent = $rec->sent ? (new MoonMarsDateTime($rec->sent)) : FALSE;
  }

  /**
   * Load a nxn from the db.
   *
   * @return Nxn
   */
  public function load() {
    if (!$this->loaded && $this->nxnId) {
      $q = db_select('moonmars_nxn', 'nxn')
        ->fields('nxn')
        ->condition('nxn_id', $this->nxnId);
      $rs = $q->execute();
      $rec = $rs->fetchObject();
      if ($rec) {
        // Copy values from the record into the properties:
        $this->copyRec($rec);
        // The nxn has been loaded:
        $this->loaded = TRUE;
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
      'sent'          => $this->sent ? $this->sent->timestamp() : NULL,
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
      $fields['created'] = time();
      $q = db_insert('moonmars_nxn')
        ->fields($fields);
      $this->nxnId = $q->execute();
    }
    return $this;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get/set

  /**
   * Get the triumph.
   *
   * @return Triumph
   */
  public function triumph($value = NULL) {
    if ($value === NULL) {
      // Get:
      $this->load();
      return $this->triumph;
    }
    else {
      // Set:
      $this->triumph = $value;
      return $this;
    }
  }

  /**
   * Get the recipient.
   *
   * @return Member
   */
  public function recipient($value = NULL) {
    if ($value === NULL) {
      // Get:
      $this->load();
      return $this->recipient;
    }
    else {
      // Set:
      $this->recipient = $value;
      return $this;
    }
  }

  /**
   * Get the created datetime
   *
   * @return MoonMarsDateTime
   */
  public function created() {
    $this->load();
    return $this->created;
  }

  /**
   * Get the notification subject.
   *
   * @return string
   */
  public function subject() {
    $this->generate();
    return $this->subject;
  }

  /**
   * Get the notification summary.
   *
   * @return string
   */
  public function summary() {
    $this->generate();
    return $this->summary;
  }

  /**
   * Get the notification preview.
   *
   * @return string
   */
  public function preview() {
    $this->generate();
    return $this->preview;
  }

  /**
   * Get the notification message.
   *
   * @return string
   */
  public function message() {
    $this->generate();
    return $this->message;
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Emails

  /**
   * Render a table of details for an email, i.e. use inline styles and tables.
   *
   * @param array $values
   * @return string
   */
  public function renderDetails(array $values, $title = NULL) {
    $html = $title ? "<h3>$title</h3>" : "";
    $html .= "<table style='background: none; padding: 0; border: 0; margin: 0; border-spacing: 0;'>\n";
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
   * Get an array of member details.
   *
   * @static
   * @param Member $member
   * @return array
   */
  public static function memberDetails(Member $member) {
    $details = array(
      'Username' => "<strong>" . $member->name(NULL, TRUE) ."</strong>",
      'Profile'  => $member->link(),
    );
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
    // Add a list of topics that the member is interested in:
//    $details['Interests'] = $member->interests();
    return $details;
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
      'Group tag'  => '#' . $group->tag(),
      'Group page' => $group->link(),
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
   * Generate an HTML table of member details.
   *
   * @param Member $member
   * @return string
   */
  public function renderMemberDetails(Member $member, $title = NULL) {
    return self::renderDetails(self::memberDetails($member, $title));
  }

  /**
   * Generate an HTML table of group details.
   *
   * @param Group $group
   * @return string
   */
  public function renderGroupDetails(Group $group, $title = NULL) {
    return self::renderDetails(self::groupDetails($group, $title));
  }

  /**
   * Generate a new-member nxn.
   */
  public function generateNewMember() {
    global $base_url;

    // Get the actors:
    $member = $this->triumph->actor('member');
    $group = $this->triumph->actor('group');

    // Create message:
    $message = self::renderMemberDetails($member, "Member details");

    if (!$group) {
      // New member of the site:
      $subject = "New member of moonmars.com";
      $summary = "<a href='$base_url'>moonmars.com</a> has a new member!";
    }
    else {
      // New member of a group:
      $subject = "New member of the " . $group->title() . " group";
      $summary = "The " . $group->link() . " group on <a href='$base_url'>moonmars.com</a> has a new member!";

      // Additional group details:
      $message .= self::renderGroupDetails($group, "Group details");
    }

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'message' => $message,
    );
  }

  /**
   * Generate a new-group nxn.
   */
  public function generateNewGroup() {
    global $base_url;

    // Get the actors:
    $group = $this->triumph->actor('group');
    $parent_group = $this->triumph->actor('parent group');

    // Subject:
    $group_name = $group->title();
    $subject = "New group created: $group_name";
    $group_link = $group->link();

    // Summary:
    $summary = "<a href='$base_url'>moonmars.com</a> has a new group: $group_link";

    // Details:
    $message = self::renderGroupDetails($group, "Group details");

    // Additional details for subgroups:
    if ($parent_group) {
      $summary .= " This is a subgroup of " . $parent_group->link() . ".";
      $message .= self::renderGroupDetails($parent_group, "Parent group details");
    }

    // Add a convenient "join group" link:
    $message .= "<p><strong>" . l("Join the $group_name group", $group->alias() . '/join') . "</strong></p>";

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'message' => $message,
    );
  }

  /**
   * Generate a new-item nxn.
   */
  public function generateNewItem() {
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
    if ($item->textScan()->mentions($this->recipient)) {
      $summary .= " You were mentioned in the $item_link.";
    }

    // @todo add a note to the summary if the item mentions a #topic they're interested in

    // @todo Add item text and comments.
    //$message = self::renderItem($item);
    // For now just show the HTML:
    $message = $item->textScan()->html();

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'preview' => moonmars_text_trim($item->text()),
      'message' => $message,
    );
  }

  /**
   * Generate a new-comment nxn.
   */
  public function generateNewComment() {
//    return array(
//      'subject' => $subject,
//      'summary' => $summary,
//'preview' => moonmars_text_trim($comment->text()),
//      'message' => $message,
//    );
  }

  /**
   * Generate a new-follower nxn.
   */
  public function generateNewFollower() {
    // Get the actors:
    $follower = $this->triumph()->actor('follower');
    $followee = $this->triumph()->actor('followee');

    if (Member::equals($followee, $this->recipient)) {
      $followee_name = "you";
      // If the followee is receiving the nxn they they'll be interested in the follower's details:
      $message = self::renderMemberDetails($follower, "Follower details");
    }
    else {
      $followee_name = $followee->name();
      // If someone is receiving a nxn about their followee following someone, then they'll be interested in the
      // followee's details:
      $message = self::renderMemberDetails($followee, "Followee details");
    }

    $subject = $follower->name() . " is now following $followee_name";
    $summary = $follower->link() . " is now following " . $followee->link($followee_name) . ".";

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'message' => $message,
    );
  }

  /**
   * Generate the email for a notification.
   *
   * @return array
   */
  public function generate() {
    if (!$this->generated) {
      // Get the function name.
      // This probably seems like a weird way to do it, but I didn't want one function (this one) with about 1000 lines
      // of code to generate emails for every triumph type. So I made one method per triumph type.
      $triumphTypeParts = explode('-', $this->triumph->triumphType());
      $fn = 'generate' . ucfirst($triumphTypeParts[0]) . ucfirst($triumphTypeParts[1]);

      // Get the email parts:
      $email = $this->$fn();

      // Copy into properties:
      $this->subject = $email['subject'];
      $this->summary = $email['summary'];
      $this->preview = isset($email['preview']) ? $email['preview'] : '';
      $this->message = $email['message'];

      // Add the unsubscribe message:
      $this->message .= "<p style='font-size: 10px; color: #777;'>" . l("Update your notification preferences, or unsubscribe from all emails", $this->recipient->alias() . '/edit/notifications') . "</p>";

      // Remember we've done this:
      $this->generated = TRUE;
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Sending

  /**
   * Send the nxn.
   *
   * @return bool
   *   TRUE on success, else FALSE
   */
  public function send() {
    $this->generate();
    $email_array = array(
      'subject' => $this->subject,
      'summary' => $this->summary,
      'message' => $this->message,
    );

    // Generate and send the email:
    drupal_mail('moonmars_nxn', 'nxn', $this->recipient()->mail(), language_default(), $email_array);

    // Update the sent property:
    $this->sent = MoonMarsDateTime::now();
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

      // Send the email and update the sent property:
      $sent = $nxn->send();

      // If it sent ok, count it:
      if ($sent) {
        $n_sent++;
      }

      // Save the nxn to update the sent field in the db record:
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
