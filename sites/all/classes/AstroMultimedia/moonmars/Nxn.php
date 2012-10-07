<?php
namespace AstroMultimedia\MoonMars;

use \stdClass;

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
   * @var MoonMarsDateTime|bool
   */
  protected $created;

  /**
   * When was the nxn sent? FALSE if not sent yet.
   *
   * @var MoonMarsDateTime|bool
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
  protected $details;

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
    $this->created = new MoonMarsDateTime($rec->created, 'UTC');
    $this->sent = $rec->sent ? (new MoonMarsDateTime($rec->sent, 'UTC')) : FALSE;
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
      'sent'          => $this->sent ? $this->sent->mysqlUTC() : NULL,
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
      $fields['created'] = MoonMarsDateTime::nowUTC()->mysql();
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
  // Generate nxn summaries and emails

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
      'Username' => "<strong>" . $member->name(NULL, TRUE) . "</strong>",
      'Profile'  => $member->link($member->url(TRUE)),
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
      'Name'    => "<strong>" . $group->title() . "</strong>",
      'Tag'     => '#' . $group->tag(),
      'Profile' => $group->link($group->url(TRUE)),
      'Type'    => $group->groupType(NULL, 'name'),
    );
    if ($group->description()) {
      $details['Description'] = $group->description();
    }
    if ($group->icon()) {
      $details['Image'] = $group->icon();
    }

    // Group administrators:
    $admin_links = array();
    foreach ($group->admins() as $admin) {
      $admin_links[] = $admin->link();
    }
    $details['Administrators'] = implode('<br>', $admin_links);

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
    $details = self::renderMemberDetails($member, "Member details");

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
      $details .= self::renderGroupDetails($group, "Group details");
    }

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
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

    // Generate the subject, summary and details.
    // Subject:
    $group_name = $group->title();
    $subject = "New group created";
    $group_link = $group->link();

    // Summary:
    $summary = "<a href='$base_url'>moonmars.com</a> has a new group!";

    // Details:
    $details = self::renderGroupDetails($group, "Group details");

    // Additional details for subgroups:
    if ($parent_group) {
      $summary .= " This is a subgroup of " . $parent_group->link() . ".";
      $details .= self::renderGroupDetails($parent_group, "Parent group details");
    }

    // Add a convenient "join group" link:
    $details .= "<p><strong>" . l("Join the $group_name group", $group->alias() . '/join') . "</strong></p>";

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
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
    // @todo Add "comment-by-email-reply" feature.
    //$details = self::renderItem($item);
    // For now just show the HTML:
    $details = "<div style='padding: 5px; border: solid 1px #ccc; border-radius: 3px'>" . $item->textScan()->html() . "</div>";

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'preview' => moonmars_text_trim($item->text()),
      'details' => $details,
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
//      'details' => $details,
//    );
  }

  /**
   * Generate a new-follower nxn.
   */
  public function generateNewFollower() {
    // Get the actors:
    $follower = $this->triumph()->actor('follower');
    $followee = $this->triumph()->actor('followee');

    // Generate the subject, summary and details:
    if (Member::equals($followee, $this->recipient)) {
      $followee_name = "you";
      // If the followee is receiving the nxn they they'll be interested in the follower's details:
      $details = self::renderMemberDetails($follower, "Follower details");
    }
    else {
      $followee_name = $followee->name();
      // If someone is receiving a nxn about their followee following someone, then they'll be interested in the
      // followee's details:
      $details = self::renderMemberDetails($followee, "Followee details");
    }
    $subject = $follower->name() . " is now following $followee_name";
    $summary = $follower->link() . " is now following " . $followee->link($followee_name) . ".";

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
    );
  }

  /**
   * Generate a new-page nxn.
   */
  public function generateNewPage() {
    // Get the actors:
    $page = $this->triumph()->actor('page');
    $creator = $page->creator();

    // Generate the subject, summary and details:
    $subject = $creator->name() . " created a new page: " . $page->title();
    $summary = $creator->link() . " created a new page: " . $page->link() . ".";
    $details = $page->html();

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
    );
  }

  /**
   * Generate an update-member nxn.
   */
  public function generateUpdateMember() {
    // Get the actors:
    $member = $this->triumph()->actor('member');

    // Generate the subject, summary and details:
    $subject = $member->name() . " updated their profile";
    $summary = $member->link() . " updated their profile.";
    $details = self::renderMemberDetails($member, "Member details");

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
    );
  }

  /**
   * Generate a update-group nxn.
   */
  public function generateUpdateGroup() {
    // Get the actors:
    $group = $this->triumph()->actor('group');
    $updater = $this->triumph()->actor('updater');

    // Generate the subject, summary and details:
    $subject = "The " . $group->title() . " group profile has been updated";
    $summary = "The " . $group->link() . " group profile was updated by " . $updater->link() . ".";
    $details = self::renderGroupDetails($group, "Group details");

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
    );
  }

  /**
   * Generate a new-admin nxn.
   */
  public function generateNewAdmin() {
    // Get the actors:
    $group = $this->triumph()->actor('group');
    $admin = $this->triumph()->actor('admin');

    // Generate the subject, summary and details:
    $subject = "The " . $group->title() . " group has a new administrator";
    $article = ($group->adminCount() == 1) ? 'the' : 'an';
    $summary = $admin->link() . " is now $article administrator for the " . $group->link() . " group.";
    $details = self::renderGroupDetails($group, "Group details");

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
    );
  }

  /**
   * Generate a want-admin nxn.
   */
  public function generateWantAdmin() {
    // Get the actors:
    $group = $this->triumph()->actor('group');

    // Generate the subject, summary and details:
    $subject = "The " . $group->title() . " needs a new administrator";
    $summary = "The " . $group->link() . " needs a new administrator.";

    $details = "<p>Could it be you?</p>
      <p>Being a group administrator on moonmars.com is a great way to contribute to the community and does
      not need to take up a lot of your time. It simply involves:
      <ul>
        <li>Maintaining the group profile, such as logo, description and links.</li>
        <li>Tagging and adding value to shared resources.</li>
        <li>If the group is restricted or closed, inviting new members or approving requests to join.</li>
        <li>Moderating content and enforcing rules of conduct if there are any.</li>
        <li>Warning or kicking trolls, spammers and scammers.</li>
      </ul>
      Remember, other group members can and will help you with this work. Plus, you can always add new administrators,
      and you can step down at any time. Group administrators earn additional points for their efforts.</p>";
    $details .= self::renderGroupDetails($group, "Group details");

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
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
      $this->message = $email['details'];

      // Add the unsubscribe message:
      $this->message .= "
        <p style='font-size: 11px; border-top: solid 1px #aaa; padding-top: 5px;'>
          " . l("Update your notification preferences", $this->recipient->alias() . '/edit/notifications') . "
        </p>";

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
      'details' => $this->message,
    );

    // Generate and send the email:
    $recipient = $this->recipient()->mail();
    $message = drupal_mail('moonmars_nxn', 'nxn', $recipient, language_default(), $email_array);

    // If sent ok, update the sent property:
    if ($message['result']) {
      $this->sent = MoonMarsDateTime::nowUTC();
    }

    return $message;
  }

  /**
   * Send all outstanding nxns.
   *
   * @static
   * @return array
   */
  public static function sendOutstanding() {
    // Look for any nxns we didn't send yet:
    $q = db_select('moonmars_nxn', 'nxn')
      ->fields('nxn')
      ->condition(db_or()
        ->condition('sent', 0)
        ->condition('sent', NULL))
      ->orderBy('nxn_id');
    $rs = $q->execute();

    // Create the nxns:
    $messages = [];
    foreach ($rs as $rec) {
      // Reset the time limit so the script doesn't time out while sending emails.
      // Let's assume 60 seconds will be more than enough time to send an email.
      set_time_limit(60);

      // Create an Nxn object:
      $nxn = new Nxn($rec);

      // Send the email and update the sent property:
      $messages[] = $nxn->send();

      // Save the nxn to update the sent field in the db record:
      $nxn->save();
    }
    return $messages;
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
