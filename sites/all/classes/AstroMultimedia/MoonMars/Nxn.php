<?php
namespace AstroMultimedia\MoonMars;

use \stdClass;
use \AstroMultimedia\Star\Style;

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
   * @var DateTime|bool
   */
  protected $created;

  /**
   * When was the nxn sent? FALSE if not sent yet.
   *
   * @var DateTime|bool
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
    $this->created = new DateTime($rec->created, 'UTC');
    $this->sent = $rec->sent ? (new DateTime($rec->sent, 'UTC')) : FALSE;
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
      $fields['created'] = DateTime::nowUTC()->mysql();
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
   * @return DateTime
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
    $html = $title ? "<h3 style='font-size: 13px; font-weight: bold; font-style: italic; padding: 0; margin: 0 0 5px;'>$title</h3>" : "";
    $html .= "<table style='background: none; padding: 0; border: 0; margin: 0; border-spacing: 0;'>\n";
    $grey3 = '#777';
    $td_style = new Style(array(
      'padding' => '5px 10px 5px 0',
      'margin' => 0,
      'border' => 0,
      'font-size' => '12px',
      'font-family' => 'Helvetica, Arial, Tahoma, Verdana, sans-serif',
      'vertical-align' => 'top',
    ));
    $td_style = $td_style->inline();
    foreach ($values as $label => $value) {
      $html .= "<tr>\n";
      $html .= "<td style='$td_style width: 75px; color: $grey3;'>$label:</td>\n";
      $html .= "<td style='$td_style color: black;'>$value</td>\n";
      $html .= "</tr>\n";
    }
    $html .= "</table>";
    return $html;
  }

  /**
   * Render member details as an HTML table.
   *
   * @param Member $member
   * @return array
   */
  public function memberDetails(Member $member, $title = "Member details") {
    $details = array();
    if ($member->fullName()) {
      $details['Name'] = $member->fullName();
    }
    $details['Tag'] = "<strong>" . $member->tag() . "</strong>";
    $details['Profile'] = $member->link($member->url(TRUE));
    $details['Avatar'] = $member->avatar();
    if ($member->age()) {
      $details['Age'] = $member->age();
    }
    if ($member->gender()) {
      $details['Gender'] = $member->gender(TRUE);
    }
    if (array_filter($member->location())) {
      $details['Location'] = $member->locationStr(TRUE);
    }
    $bio = $member->bio();
    if ($bio) {
      $details['Bio'] = "<div style='" . moonmars_box_inline_style('10px 5px') . "'>$bio</div>";
    }
//    $details['Interests'] = $member->topicsLinks();

    // Add a list of topics that the member is interested in:
//    $details['Interests'] = $member->interests();
    $html = "<div style='" . moonmars_box_inline_style('10px', '10px 0', '#96b1ff') . "'>" .
      self::renderDetails($details, $title) .
      "<p style='padding: 0; margin: 10px 0 0;'>" . $this->followStr($member) . "</p></div>";

    return $html;
  }

  /**
   * Render group details as an HTML table.
   *
   * @param Group $group
   * @return array
   */
  public function groupDetails(Group $group, $title = "Group details") {
    $group_name = $group->title();
    $details = array(
      'Name' => $group_name,
      'Tag' => "<strong>" . $group->tag(NULL, TRUE) . "</strong>",
      'Profile' => $group->link($group->url(TRUE)),
      'Type' => $group->groupType(NULL, 'name'),
    );
    if ($group->description()) {
      $details['Description'] = "<div style='" . moonmars_box_inline_style('0 5px') . "'>" . $group->description() . "</div>";
    }
    if ($group->icon()) {
      $details['Image'] = $group->icon();
    }

    // Group administrators:
    $admin_links = array();
    foreach ($group->admins() as $admin) {
      $admin_links[] = $admin->tagLink();
    }
    if ($admin_links) {
      $details['Administrators'] = implode('<br>', $admin_links);
    }

    $html = "<div style='" . moonmars_box_inline_style('10px', '10px 0', '#96b1ff') . "'>" . self::renderDetails($details, $title);
    if ($group->hasMember($this->recipient)) {
      $html .= "<p style='padding: 0; margin: 10px 0 0;'>You are a member of $group_name.</p>";
    }
    else {
      $html .= "<p style='padding: 0; margin: 10px 0 0;'>You are not a member of $group_name. " . l("Join " . $group->tag(NULL, TRUE), $group->alias() . '/join') . "</p>";
    }
    $html .= "</div>";

    return $html;
  }

  /**
   * Render an item or comment details as HTML.
   *
   * @param IPost $post
   * @param IPost $highlighted_post
   * @return string
   */
  public function itemOrCommentDetails(IPost $post, IPost $highlighted_post) {
    $poster = $post->creator();
    $highlight = $post->equals($highlighted_post);
    // Comments are indented 10px:
    $margin_left = $post instanceof Item ? 0 : '10px';
    $html = "
      <div style='" . $poster->commentStyle($highlight) . " margin: 0 0 5px $margin_left; border-radius: 3px;'>
        <table style='padding: 0; border: 0; margin: 0; border-spacing: 0;'>
          <tr>
            <td style='padding: 0; border: 0; margin: 0; vertical-align: top;'>" . $poster->avatar() . "</td>
            <td style='padding: 0 0 0 5px; border: 0; margin: 0; vertical-align: top;'>
              <div style='margin: 0; font-size: 11px;'>" . $poster->tagLink() . " 
                <span style='color: #919191'>about " . $post->created()->aboutHowLongAgo() . " ago</span><span style='margin: 0 0 0 10px;'><a class='post-link' href='" . $GLOBALS['base_url'] . '/' . $post->alias() . "'><img src='" . $GLOBALS['base_url'] . '/' . path_to_theme() . "/images/link-icon.png' title='" . $post->text() . "'></a></span>
              </div>
              <div style='margin: 10px 0 0; font-size: 12px;'>" . $post->html() . "</div>
            </td>
          </tr>
        <table>
      </div>\n";
    return $html;
  }

  /**
   * Generate some HTML to display an item with comments.
   *
   * @param Item $item
   * @param IPost $highlighted_post
   * @return string
   */
  public function itemDetails(Item $item, IPost $highlighted_post) {
    $html = '';
//    $heading_style = "padding: 0; font-size: 13px; font-weight: bold; color: black; margin: 10px 0 5px;";

    // Item:
//    $html .= "<div style='$heading_style'>Item:</div>";
    $html .= self::itemOrCommentDetails($item, $highlighted_post);

    // Comments:
//    $html .= "<div style='$heading_style'>Comments:</div>";
    $comments = $item->comments();
    if ($comments) {
      foreach ($comments as $comment) {
        $html .= self::itemOrCommentDetails($comment, $highlighted_post);
      }
    }

    $html .= "<p>" . l('Post a comment', $item->alias()) . "</p>";
//    else {
//      $html .= "<div>None yet.</div>";
//    }

    return $html;
  }

  /**
   * Get a name for a channel that is meaningful to the nxn recipient.
   *
   * @param Channel $channel
   * @param Member $poster
   * @return string
   */
  public function channelTitle(Channel $channel, Member $poster) {
    $star = $channel->star();
    if ($star) {
      if ($star instanceof Member) {
        if ($star->equals($this->recipient)) {
          $channel_name = 'your channel';
        }
        elseif ($star->equals($poster)) {
          $channel_name = "their channel";
        }
        else {
          $channel_name = $star->tag() . "'s channel";
        }
      }
      elseif ($star instanceof Group) {
        $channel_name = $star->title();
      }
    }
    return $channel_name;
  }

  /**
   * Generate a sentence describing the follow relationships between the nxn recipient and another member.
   *
   * @param Member $member
   * @return string
   */
  public function followStr(Member $member) {
    $you_follow_member = $this->recipient->follows($member);
    $member_follows_you = $member->follows($this->recipient);
    $member_name = $member->fullName() ?: $member->tag();
    if ($you_follow_member) {
      if ($member_follows_you) {
        return "You follow $member_name and they follow you.";
      }
      else {
        return "You follow $member_name but they do not follow you.";
      }
    }
    else {
      $follow_member_link = l("Follow " . $member->tag(), $member->alias() . '/follow');
      if ($member_follows_you) {
        return "You do not follow $member_name but they follow you. $follow_member_link";
      }
      else {
        return "You do not follow $member_name and they do not follow you. $follow_member_link";
      }
    }
  }

  /**
   * Generate a new-member nxn.
   *
   * @return array
   */
  public function generateNewMember() {
    global $base_url;

    // Get the actors:
    $member = $this->triumph->actor('member');
    $group = $this->triumph->actor('group');

    if (!$group) {
      // New member of the site:
      $subject = "New member of moonmars.com";
      $summary = "<a href='$base_url'>moonmars.com</a> has a new member!";
    }
    else {
      // New member of a group:
      $subject = "New member of the " . $group->title() . " group";
      $summary = "The " . l($group->title(), $group->alias()) . " group on <a href='$base_url'>moonmars.com</a> has a new member!";
    }

    // Details:
    $details = $this->memberDetails($member);
    if ($group) {
      $details .= $this->groupDetails($group);
    }

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
    );
  }

  /**
   * Generate a new-group nxn.
   *
   * @return array
   */
  public function generateNewGroup() {
    global $base_url;

    // Get the actors:
    $group = $this->triumph->actor('group');
    $parent_group = $this->triumph->actor('parent group');

    // Subject:
    $group_name = $group->title();
    $subject = "New group created";

    // Summary:
    $summary = "<a href='$base_url'>moonmars.com</a> has a new group!";
    if ($parent_group) {
      $summary .= " This is a subgroup of " . $parent_group->link() . ".";
    }

    // Details:
    $details = $this->groupDetails($group);
    if ($parent_group) {
      $details .= $this->groupDetails($parent_group, "Parent group details");
    }

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'details' => $details,
    );
  }

  /**
   * Generate a new-item nxn.
   *
   * @return array
   */
  public function generateNewItem() {
    // Get the actors:
    $item = $this->triumph()->actor('item');

    $item_link = $item->link("item");
    $poster = $item->creator();
    $channel = $item->channel();

    if ($channel) {
      $channel_name = $this->channelTitle($channel, $poster);
      $star = $channel->star();
    }
    else {
      $channel_name = NULL;
      $star = NULL;
    }

    // Subject:
    $subject = $poster->tag() . " posted a new item" . ($channel ? " in $channel_name" : '');

    // Summary:
    $summary = $poster->tagLink() . " posted a new $item_link" . ($star ? (" in " . $star->link($channel_name)) : '') . ".";
    if ($item->mentionsMember($this->recipient)) {
      $summary .= " You were mentioned in the item.";
    }
    // @todo add a note if the item mentions a #topic they're interested in

    // Details:
    $details = self::itemDetails($item, $item);

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
    // Get the actors:
    $comment = $this->triumph()->actor('comment');

    $item = $comment->item();
    $item_poster = $item->creator();
    $comment_poster = $comment->creator();
    $channel = $item->channel();

    if ($channel) {
      $channel_name = $this->channelTitle($channel, $comment_poster);
      $star = $channel->star();
    }
    else {
      $channel_name = NULL;
      $star = NULL;
    }

    // Subject:
    $subject = $comment_poster->tag() . " posted a new comment" . ($channel ? " in $channel_name" : '');

    // Summary:
    $summary =  $comment_poster->tagLink() . " posted a new " . $comment->link('comment') . " on an " . $item->link('item');
    if ($item_poster->equals($this->recipient)) {
      $summary .= " you posted";
    }
    elseif ($item_poster->equals($comment_poster)) {
      $summary .= " they posted";
    }
    else {
      $summary .= " posted by " . $item_poster->tagLink();
    }
    if ($star) {
      $summary .= " in " . $star->link($channel_name);
    }
    $summary .= ".";
    if ($comment->mentionsMember($this->recipient)) {
      $summary .= " You were mentioned in the comment.";
    }
    elseif ($item->mentionsMember($this->recipient)) {
      $summary .= " You were mentioned in the original item.";
    }
    // @todo add a note if the item mentions a #topic they're interested in

    // Details:
    $details = self::itemDetails($item, $comment);

    return array(
      'subject' => $subject,
      'summary' => $summary,
      'preview' => moonmars_text_trim($comment->text()),
      'details' => $details,
    );
  }

  /**
   * Generate a new-follower nxn.
   *
   * @return array
   */
  public function generateNewFollower() {
    // Get the actors:
    $follower = $this->triumph()->actor('follower');
    $followee = $this->triumph()->actor('followee');

    if ($followee->equals($this->recipient)) {
      $followee_tag = "you";
      $followee_link = "you";
    }
    else {
      $followee_tag = $followee->tag();
      $followee_link = $followee->tagLink();
    }

    // Subject:
    $subject = $follower->tag() . " is now following $followee_tag";

    // Summary:
    $summary = $follower->tagLink() . " is now following $followee_link.";

    // Details:
    // Only attach follower or followee details if they're different members than the recipient (who, presumably,
    // already knows their own details.)
    $details = '';
    if (!$follower->equals($this->recipient)) {
      $details .= $this->memberDetails($follower, "Follower details");
    }
    if (!$followee->equals($this->recipient)) {
      $details .= $this->memberDetails($followee, "Followee details");
    }

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

    // Subject:
    $subject = $creator->tag() . " created a new page: " . $page->title();

    // Summary:
    $summary = $creator->tagLink() . " created a new page: " . $page->link() . ".";

    // Details:
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

    // Subject:
    $subject = $member->tag() . " updated their profile";

    // Summary:
    $summary = $member->tagLink() . " updated their profile.";

    // Details:
    $details = $this->memberDetails($member);

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

    // Subject:
    $subject = "The " . $group->title() . " group profile was updated";

    // Summary:
    $summary = "The " . $group->link($group->title()) . " group profile was updated by " . $updater->tagLink() . ".";

    // Details:
    $details = $this->groupDetails($group);

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

    // Subject:
    $subject = "The " . $group->title() . " group has a new administrator";

    // Summary:
    $article = ($group->adminCount() == 1) ? 'the' : 'an';
    $summary = $admin->tagLink() . " is now $article administrator for the " . $group->link() . " group.";

    // Details:
    $details = $this->groupDetails($group);

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

    // Subject:
    $subject = "The " . $group->title() . " needs a new administrator";

    // Summary:
    $summary = "The " . $group->link() . " needs a new administrator.";

    // Details:
    $details = "<p>Could it be you?</p>
      <p>Being a group administrator on moonmars.com is a great way to contribute to the community and does
      not need to take up a lot of your time. It mainly involves:</p>
      <ul>
        <li>Maintaining the group profile, such as logo, description and links.</li>
        <li>If the group is restricted or closed, inviting new members or approving requests to join.</li>
        <li>Moderating content and enforcing rules of conduct if there are any.</li>
        <li>Warning or kicking trolls, spammers and scammers.</li>
      </ul>
      <p>Other group members can help you with these things, plus you can always add new administrators if you need to.
      You can step down at any time. Group administrators earn additional points for their efforts!</p>"
      . $this->groupDetails($group);

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
      $this->subject = '[moonmars.com] ' . $email['subject'];
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
      $this->sent = DateTime::nowUTC();
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
    $messages = array();
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
