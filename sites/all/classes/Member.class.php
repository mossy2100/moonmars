<?php
/**
 * Encapsulates a moonmars.com member.
 */

class Member extends User {

  /**
   * The member's age.
   *
   * @var int
   */
  protected $age;

  /**
   * HTML for the member's avatar.
   *
   * @var string
   */
  protected $avatar;

  /**
   * HTML for the member's tooltip.
   *
   * @var string
   */
  protected $tooltip;

  /**
   * The member's channel.
   *
   * @var string
   */
  protected $channel;

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  /**
   * Get the member object for the current logged-in user.
   *
   * @static
   * @return Member|null
   */
  public static function currentMember() {
    return user_is_logged_in() ? self::create($GLOBALS['user']->uid) : NULL;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set methods.

  /**
   * Get a link to the user's profile.
   */
  public function link($label = NULL, $include_at = FALSE) {
    $label = ($include_at ? '@' : '') . (($label === NULL) ? $this->name() : $label);
    return l($label, $this->alias());
  }

  /**
   * Get the member's full name.
   */
  public function fullName() {
    $first_name = $this->field('field_first_name');
    $last_name = $this->field('field_last_name');
    return trim("$first_name $last_name");
  }

  /**
   * Get the location as an array.
   *
   * @return array
   */
  public function location() {
    $location = array(
      'city'          => $this->field('field_user_location', LANGUAGE_NONE, 0, 'city'),
      'province_code' => $this->field('field_user_location', LANGUAGE_NONE, 0, 'province'),
    );

    // Get the country code. Note, this will be lower-case, because that's what the location module uses:
    $country_code = $this->field('field_user_location', LANGUAGE_NONE, 0, 'country');

    // Get the upper-case country code because that's what everyone else in the whole world uses:
    $location['country_code'] = strtoupper($country_code);

    // Default names:
    $location['province_name'] = '';
    $location['country_name'] = '';

    if ($country_code) {
      // If we have a province code, get the full province name:
      if ($location['province_code']) {
        $provinces = location_get_provinces($country_code);
        $location['province_name'] = $provinces[$location['province_code']];
      }

      // Get the full country name:
      require_once DRUPAL_ROOT . '/includes/locale.inc';
      $countries = country_get_list();
      $location['country_name'] = $countries[$location['country_code']];
    }

    return $location;
  }

  /**
   * Get the location as a string.
   *
   * @param bool $full
   *   If TRUE, use province and country names instead of codes.
   * @return array
   */
  public function locationStr($full = FALSE, $map_link = FALSE) {
    $location = $this->location();

    if ($full) {
      $location_str = implode(', ', array_filter(array(
                                                      $location['city'],
                                                      $location['province_name'],
                                                      $location['country_name']
                                                 )));
    }
    else {
      $location_str = implode(', ', array_filter(array(
                                                      $location['city'],
                                                      $location['province_code'],
                                                      $location['country_code']
                                                 )));
    }

    if ($map_link) {
      return l($location_str, 'http://maps.google.com', array(
                                                             'attributes'  => array('target' => '_blank'),
                                                             'query'       => array('q' => $location_str)
                                                        ));
    }
    else {
      return $location_str;
    }
  }

  /**
   * Calculate the member's age from their date of birth.
   *
   * @return int
   */
  public function age() {
    // Cache the result of the age calculation in the age property so we don't have to recalculate it again.
    if (!isset($this->age)) {

      $date_of_birth = $this->field('field_date_of_birth');

      if ($date_of_birth) {
        $date_of_birth = new StarDateTime($date_of_birth);
        $today = StarDateTime::today();
        $birth_year = $date_of_birth->year();
        $current_year = $today->year();
        $birthday_this_year = $date_of_birth;
        $birthday_this_year->year($today->year());
        $this->age = ($current_year - $birth_year) - ($birthday_this_year <= $today ? 0 : 1);
      }
    }

    // Only return a value greater than 0 - some members set fake dates of birth so their ages don't show.
    return ($this->age > 0) ? $this->age : NULL;
  }

  /**
   * Get the user's gender.
   *
   * @param bool $full
   *   If TRUE then the full word is returned in title case.
   * @return string
   */
  public function gender($full = FALSE) {
    $gender = $this->field('field_gender');
    if ($gender) {
      return $full ? (($gender == 'M') ? 'Male' : 'Female') : $gender;
    }
    return NULL;
  }

  /**
   * A composite string of the age and gender, for the user info block.
   *
   * @param bool $full
   * @return string
   */
  public function ageGender($full = FALSE) {
    $gender = $this->gender($full);
    $age = $this->age();
    return implode('/', array_filter(array(
                                          $gender,
                                          $age
                                     )));
  }

  /**
   * Create a planet-flag icon for this member.
   *
   * @return string
   */
  public function planetFlagIcon() {
    require_once DRUPAL_ROOT . '/modules/system/image.gd.inc';

    $moon_or_mars = $this->field('field_moon_or_mars');
    $location = $this->location();
    $country_code = $location['country_code'] ? strtolower($location['country_code']) : NULL;
    $filename = implode('-', array_filter(array($moon_or_mars, $country_code))) . '.png';
    $files_dir = drupal_realpath("public://");

    // Check if this planet-flag icon already exists:
    $path = "$files_dir/planet-flag-icons/$filename";
    if (!file_exists($path)) {

      // Load the 40x40 planet icon:
      $planet = new stdClass;
      $planet->source = "$files_dir/styles/icon-40x40/public/avatars/870x870/$moon_or_mars-870x870.jpg";
      $planet->info['extension'] = 'jpg';
      image_gd_load($planet);

      // Paste the flag on it:
      if ($country_code) {

        // Get the path to the flag icon and check if it exists:
        $flag_path = DRUPAL_ROOT . '/' . drupal_get_path('theme', 'astro') . "/images/flag-icons/$country_code.png";
        if (file_exists($flag_path)) {

          // Load the flag icon:
          $flag = new stdClass;
          $flag->source = $flag_path;
          $flag->info['extension'] = 'png';
          image_gd_load($flag);

          // Get width and height of the flag:
          $info = getimagesize($flag_path);

          // Paste the flag onto the planet:
          imagecopy($planet->resource, $flag->resource, 7, 7, 0, 0, $info[0], $info[1]);
        }
      }

      // Save the planet-flag icon.
      image_gd_save($planet, $path);
    }

    if ($path) {
      return array(
        'path' => $path,
        'url' => str_replace(DRUPAL_ROOT, '', $path),
        'uri' => str_replace($files_dir, 'public:/', $path),
      );
    }

    return FALSE;
  }

  /**
   * Generate HTML for a member avatar.
   *
   * @return string
   */
  public function avatar() {
    if (!$this->avatar) {

      // Make sure the user is loaded:
      $this->load();

      $html = NULL;

      // If the user has a picture, use it:
      if (isset($this->entity->picture)) {

        // If we just have the fid, load the file:
        if (is_uint($this->entity->picture)) {
          $this->entity->picture = file_load($this->entity->picture);
        }

        // Check the file exists:
        $path = drupal_realpath($this->entity->picture->uri);
        if (file_exists($path)) {

          // Render the icon:
          $image = array(
            'style_name' => 'icon-40x40',
            'path'       => $this->entity->picture->uri,
            'alt'        => $this->entity->name,
            'attributes' => array('class' => array('avatar-icon')),
          );
          $html = theme('image_style', $image);

        }
      }

      if (!$html) {
        // If the user doesn't have a picture, use a default icon:
        $planet_flag = $this->planetFlagIcon();
        $html = "<img class='avatar-icon' typeof='foaf:Image' src='{$planet_flag['url']}' width='40' height='40' alt='" . $this->name() . "'>";
      }

      // Remember the HTML in the property so we don't have to theme the image again:
      $this->avatar = $html;
    }

    return $this->avatar;
  }

  /**
   * Generate HTML for a user avatar with link.
   *
   * @return string
   */
  public function avatarLink() {
    return l($this->avatar(), $this->alias(), array(
                                                   'html'       => TRUE,
                                                   'attributes' => array('class' => array('avatar-link'))
                                              ));
  }

  /**
   * Get the member's Skype callto link.
   *
   * @return string
   */
  public function skypeLink() {
    $skype = $this->field('field_skype');
    if ($skype) {
      return "
          <a class='skype-add' href='skype:$skype?add'></a>
      ";
    }
    return NULL;
  }

  /**
   * Generate HTML for a member's avatar tooltip.
   *
   * @return string
   */
  function tooltip() {
    if (!$this->tooltip) {

      // Make sure the user is loaded:
      $this->load();

      // Get the name:
      $username = $this->name();
      $full_name = $this->fullName();

      // Cater for names that are too long - we don't want the tooltip too wide.
      if (strlen($full_name) > 50) {
        $full_name = substr($full_name, 0, 47) . '...';
      }

      $age_gender = $this->ageGender(TRUE);
      $location = $this->locationStr();
      $info = array(
        "<strong>$username</strong>",
        $full_name,
        $age_gender,
        $location
      );
      $info = implode('<br>', array_filter($info));

      // Remember the HTML in a property in case we need it again:
      $this->tooltip = "
        <div class='user-tooltip' title='Visit $username&apos;s profile'>" .
        $this->avatar() .
        "<div class='user-tooltip-text'>$info</div>" .
        "</div>";
    }

    return $this->tooltip;
  }

  /**
   * Generate HTML for a user avatar with link and tooltip.
   *
   * @return string
   */
  public function avatarTooltip() {
    $avatar_link = $this->avatarLink();
    $tooltip = $this->tooltip();
    return "
      <div class='avatar-tooltip'>
        $avatar_link
        $tooltip
      </div>
    ";
  }

  /**
   * Get a link to the member's profile with a tooltip.
   */
  public function tooltipLink() {
    $attr = array(
      'class' => array('username'),
      'title' => 'Visit ' . $this->name() . '&apos;s profile.'
    );
    return l($this->name(), $this->alias(), array('attributes' => $attr));
  }

  /**
   * Renders a Moon or Mars or Both icon, with a flag on top.
   *
   * @return string
   */
  public function moonOrMarsWithFlag() {
    $moon_or_mars = $this->field('field_moon_or_mars');
    $country = $this->field('field_user_location', LANGUAGE_NONE, 0, 'country');

    // If the user doesn't have a picture, use a default icon:
    $icon = $this->field('field_moon_or_mars');
    if (!$icon) {
      $icon = 'both';
    }
    $image = array(
      'style_name' => 'icon-40x40',
      'path'       => "avatars/870x870/$icon-870x870.jpg",
      'alt'        => $this->entity->name,
      'attributes' => array('class' => array('avatar-icon')),
    );

    // Remember the HTML in the property so we don't have to theme the image again:
    $html = theme('image_style', $image);

    // See if the flag exists for the member's country:
    if ($country) {
      $path = "/" . drupal_get_path('theme', 'astro') . "/images/flag-icons/$country.png";
      if (file_exists(DRUPAL_ROOT . $path)) {
        $html .= "<img id='profile-flag' src='$path'>";
      }
    }

    return $html;
  }

  /**
   * Get/set a member's level.
   *
   * @return string|bool
   */
  public function level($level = NULL) {
    $levels = moonmars_members_levels();

    if ($level === NULL) {
      // Get the member's level:

      $levels = array_reverse($levels);
      $user_level = FALSE;

      foreach ($levels as $level) {
        if (in_array($level, $this->entity->roles)) {
          if (!$user_level) {
            $user_level = $level;
          }
          else {
            // The user level has already been found, so remove this level role:
            $this->entity->roles = array_diff($this->entity->roles, array($level));
            $save_user = TRUE;
          }
        }
      }

      // If no user level found, default to iron:
      if (!$user_level) {
        $user_level = 'iron';

        // Add the role:
        $role = user_role_load_by_name('iron');
        $this->entity->roles[$role->rid] = 'iron';
        $save_user = TRUE;
      }

      if ($save_user) {
        user_save($this->entity);
      }

      return $user_level;
    }
    else {
      // Set the member's level:

      // Remove any other levels:
      foreach ($levels as $level) {
        if (in_array($level, $this->entity->roles)) {
          $this->entity->roles = array_diff($this->entity->roles, array($level));
        }
      }

      // Add the role for the new level:
      $role = user_role_load_by_name($level);
      $this->entity->roles[$role->rid] = $level;

      // Save the user and return the updated account:
      return $this->save();
    }
  }

  /**
   * Get the user's member level number, which is also their rating multiplier.
   *
   * @return int
   */
  public function levelNum() {
    return array_search($this->level(), moonmars_members_levels());
  }

  /**
   * Get the member's channel.
   *
   * @param bool $create
   * @return int
   */
  public function channel($create = TRUE) {
    if (!isset($this->channel)) {
      $this->channel = MmcEntity::getEntityChannel('user', $this->uid(), $create);
    }
    return $this->channel;
  }

  /**
   * Get the title for the member's channel.
   *
   * @return string
   */
  public function channelTitle() {
    return 'Member: ' . $this->name();
  }

  /**
   * Update the path alias for the member's profile.
   */
  public function setAlias() {
    $this->alias('member/' . $this->name());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Group-related methods.

  /**
   * Get a member's groups.
   *
   * @param int $offset
   * @param int $limit
   * @return array
   */
  public function groups($offset = NULL, $limit = NULL) {
    // Get the group's members in reverse order of that in which they joined.
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('group_nid'))
      ->condition('member_uid', $this->uid())
      ->orderBy('created', 'DESC');

    // Set a limit if specified:
    if ($offset !== NULL && $limit !== NULL) {
      $q->range($offset, $limit);
    }

    // Get the groups:
    $rs = $q->execute();
    $groups = array();
    foreach ($rs as $rec) {
      $groups[] = Group::create($rec->group_nid);
    }

    return $groups;
  }

  /**
   * Get the number of groups that a member is in.
   *
   * @return int
   */
  public function groupCount() {
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('group_nid'))
      ->condition('member_uid', $this->uid());
    $rs = $q->execute();
    return $rs->rowCount();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Follow-related methods.

  /**
   * Get a member's followers.
   *
   * @return array
   */
  public function followers($limit = NULL) {
    // Get the group's members in reverse order of that in which they joined.
    $q = db_select('view_channel_has_subscriber', 'v')
      ->fields('v', array('subscriber_uid'))
      ->condition('channel_nid', $this->channel()->nid())
      ->orderBy('created', 'DESC');

    // Set a limit if specified:
    if ($limit !== NULL) {
      $q->range(0, $limit);
    }

    $rs = $q->execute();
    $followers = array();
    foreach ($rs as $rec) {
      $followers[] = self::create($rec->subscriber_uid);
    }

    return $followers;
  }

  /**
   * Get the number of followers that a member has.
   *
   * @return int
   */
  public function followerCount() {
    $q = db_select('view_channel_has_subscriber', 'v')
      ->fields('v', array('subscriber_uid'))
      ->condition('channel_nid', $this->channel()->nid());
    $rs = $q->execute();
    return $rs->rowCount();
  }

  /**
   * Get a member's followees (i.e. other members that the member follows).
   * @todo This method could be tightened up by querying the database directly.
   *
   * @return array
   */
  public function followees($limit = NULL) {
    // Get the channels that this member is subscribed to:
    $channels = $this->subscribedChannels();

    // Filter for member channels:
    $followees = array();
    foreach ($channels as $channel) {
      $parent_entity = $channel->parentEntity();
      if ($parent_entity instanceof Member) {
        $followees[] = $parent_entity;

        // Limit to specified count:
        if ($limit !== NULL && count($followees) == $limit) {
          break;
        }
      }
    }
    return $followees;
  }

  /**
   * Get the number of followees that a member has.
   * @todo This method could be tightened up by querying the database directly.
   *
   * @return int
   */
  public function followeeCount() {
    return count($this->followees());
  }

  /**
   * Checks if one user follows another.
   *
   * @param Member $member
   */
  public function follows(Member $member) {
    return $member->channel()->hasSubscriber($this);
  }

  /**
   * Follow another member.
   *
   * @param Member $member
   */
  public function follow(Member $member) {
    $this->subscribe($member->channel(), TRUE);
//    $this->subscribe($member->channel(), $this->defaultEmailNotification());

    // Notify the followee:
    $message = $this->link() . " subscribed to " . $member->link("your channel");
    $member->notify($message, $this, $member->channel());
  }

  /**
   * Unfollow another member.
   *
   * @param Member $member
   */
  public function unfollow(Member $member) {
    $this->unsubscribe($member->channel());

    // Notify the followee:
    $message = $this->link() . " unsubscribed from " . $member->link("your channel");
    $member->notify($message, $this, $member->channel());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Group-related methods. 

  /**
   * Add a member to the group.
   *
   * @param Member $member
   */
  public function joinGroup(Group $group) {
    // Create the membership relationship:
    moonmars_relationships_update_relationship('has_member', 'node', $group->nid(), 'user', $this->uid());

    // Post system message to the group:
    $message = $this->link() . " joined " . $group->channelTitleLink();
    $group->notify($message, $this, $group->channel());
  }

  /**
   * Remove a member from the group.
   *
   * @param Member $member
   */
  public function leaveGroup(Group $group) {
    // Delete the membership relationship:
    moonmars_relationships_delete_relationships('has_member', 'node', $group->nid(), 'user', $this->uid());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Subscription-related methods.

  /**
   * Get the channels that the member is subscribed to.
   *
   * @return array
   */
  public function subscribedChannels() {
    $rels = moonmars_relationships_get_relationships('has_subscriber', 'node', NULL, 'user', $this->uid());

    $channels = array();
    if ($rels) {
      foreach ($rels as $rel) {
        $channel_nid = $rel->field('endpoints', LANGUAGE_NONE, 0, 'entity_id');
        $channels[] = Channel::create($channel_nid);
      }
    }

    return $channels;
  }

  /**
   * Subscribe member to a channel.
   *
   * @param Channel $channel
   * @param bool $email_notification
   * @return Member
   */
  public function subscribe(Channel $channel, $email_notification = TRUE) {
    // See if the relationship already exists:
    $rels = moonmars_relationships_get_relationships('has_subscriber', 'node', $channel->nid(), 'user', $this->uid());

    // If the relationship doesn't exist, create it now:
    if (!$rels) {
      $rel = Relation::createNewBinary('has_subscriber', 'node', $channel->nid(), 'user', $this->uid(), FALSE);
      $update = TRUE;
    }
    else {
      // Update the relationship if the email_notification field has changed:
      $rel = $rels[0];
      $update = ((int) $rel->field('field_email_notification')) != ((int) $email_notification);
    }

    // Update the email_notification field:
    if ($update) {
      $rel->field('field_email_notification', LANGUAGE_NONE, 0, 'value', (int) $email_notification);
      $rel->save();
    }

    return $this;
  }

  /**
   * Unsubscribe member from a channel.
   *
   * @param Channel $channel
   * @return Member
   */
  public function unsubscribe(Channel $channel) {
    moonmars_relationships_delete_relationships('has_subscriber', 'node', $channel->nid(), 'user', $this->uid());
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Notification methods.

  /**
   * Check if the member wants an email notification from this channel.
   */
  public function wantsEmailNotification($channel) {
    $rels = moonmars_relationships_get_relationships('has_subscriber', 'node', $channel->nid(), 'user', $this->uid());
    if (!$rels) {
      return FALSE;
    }
    return (bool) $rels[0]->field('field_email_notification');
  }

  /***
   * Send a notification message to a member.
   *
   * @param string $summary
   * @param Member $actor
   * @param Channel $channel
   * @param Item $item
   * @param ItemComment $comment
   */
  public function notify($summary, Member $actor = NULL, Channel $channel = NULL, Item $item = NULL, ItemComment $comment = NULL) {

    $subject = strip_tags($summary);

    // Create the notification node:
    $notification = Notification::create();
    $notification->uid($this->uid());
    $notification->title($subject);
    $notification->field('field_notification_summary', LANGUAGE_NONE, 0, 'value', $summary);
    $notification->save();

    // Create relationship between notification and actor:
    if ($actor) {
      Relation::createNewBinary('about_member', 'node', $notification->nid(), 'user', $actor->uid());
    }

    // Create relationship between notification and channel:
    if ($channel) {
      Relation::createNewBinary('about_channel', 'node', $notification->nid(), 'node', $channel->nid());
    }

    // Create relationship between notification and item:
    if ($item) {
      Relation::createNewBinary('about_item', 'node', $notification->nid(), 'node', $item->nid());
    }

    // Create relationship between notification and comment:
    if ($comment) {
      Relation::createNewBinary('about_comment', 'node', $notification->nid(), 'comment', $comment->cid());
    }

    // If the member wants an email, send it:
    $send_email = $this->wantsEmailNotification($channel);
    if ($send_email) {
      $params = array(
        'subject' => "[moonmars.com] $subject",
        'summary' => $summary,
//        'message' => $message,
      );
      drupal_mail('moonmars_members', 'notification', $this->mail(), language_default(), $params);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Permissions.

  /**
   * Check if the member can post items in the channel.
   *
   * @param Channel $channel
   * @return bool
   */
  public function canPostItem(Channel $channel) {
    // Get the parent entity:
    $parent_entity = $channel->parentEntity();

    if ($parent_entity instanceof Member) {
      // The member is the only one who can post in their own channel:
      return self::equals($parent_entity, $this);
      // Members can post in each other's channels.
//      return TRUE;
      // A member can post in their own channel, or in the channel of someone who follows them:
//      return self::equals($parent_entity, $this) || $parent_entity->follows($this);
    }
    else if ($parent_entity instanceof Group) {
      // Only members of the group can post in the group's channel:
      return $parent_entity->hasMember($this);
    }

    return FALSE;
  }

  /**
   * Check if the member can edit an item.
   *
   * @param Item $item
   * @return bool
   */
  public function canEditItem(Item $item) {
    // For now, no-one can edit items until the UI is sorted out.
    return FALSE;

    // This function will probably change to this code here, but need to think about the UI.
//    return self::equals($this, $item->creator());
  }

  /**
   * Check if the member can delete an item.
   *
   * @param Item $item
   * @return bool
   */
  public function canDeleteItem(Item $item) {
    // Check the item is valid and published:
    if (!$item->valid() || !$item->published()) {
      return FALSE;
    }

    // Check core permissions:
//    if (user_access('administer nodes', $this->user()) || user_access('delete any item content', $this->user())) {
//      return TRUE;
//    }

    // A member can delete an item if they posted it.
    if (self::equals($this, $item->creator())) {
      return TRUE;
    }

    // A member can delete any item posted in their channel.
    if (Channel::equals($this->channel(), $item->channel())) {
      return TRUE;
    }

    // A group administrator can delete any item from a group.
    // (This rule will also apply to events and projects when implemented.)
//    $parent_entity = $channel->parentEntity();
//    if ($parent_entity instanceof Group && $parent_entity->hasAdmin($this)) {
//      return TRUE;
//    }

    return FALSE;
  }

//  /**
//   * Check if the member can remove an item from the channel
//   *
//   * @param Item $item
//   * @param Channel $channel
//   * @return bool
//   */
//  public function canRemoveItem(Item $item, Channel $channel) {
//    // Check the item and channel are valid:
//    if (!$item->valid() || !$item->published() || !$channel->valid()) {
//      return FALSE;
//    }
//
//    // Members can remove any item from their own channel.
//    return Channel::equals($channel, $this->channel());
//  }

  /**
   * Check if the member can post a comment on an item.
   *
   * @param Item $item
   * @return bool
   */
  public function canPostComment(Item $item) {
    // Check the item is valid:
    if (!$item->valid()) {
      return FALSE;
    }

    // Get the channel where the item was originally posted:
    $channel = $item->channel();
    if (!$channel) {
      return FALSE;
    }

    // Get the parent entity of the item's channel:
    $parent_entity = $channel->parentEntity();
    if (!$parent_entity) {
      return FALSE;
    }

    // If item posted in a member channel:
    if ($parent_entity instanceof Member) {
      // Members can post comments in each other's channels.
      return TRUE;

//      // If the item was posted in the member's own channel, they can comment on it:
//      if (Channel::equals($original_channel, $this->channel())) {
//        return TRUE;
//      }
//      else {
//        // If the item was posted in another member's channel, they can only comment on it if that member follows them:
//        return $parent_entity->follows($this);
//      }
    }
    elseif ($parent_entity instanceof Group) {
      // If posted in a group channel, the member can comment on it if they are a member of the group:
      return $parent_entity->hasMember($this);
    }

    return FALSE;
  }

  /**
   * Check if the member can edit a comment.
   *
   * @param ItemComment $comment
   * @return bool
   */
  public function canEditComment(ItemComment $comment) {
    // Check the comment is valid:
    if (!$comment->valid() || !$comment->published()) {
      return FALSE;
    }

    // Users with 'administer comments' (i.e. admins) can edit any comment.
    if (user_access('administer comments', $this->user())) {
      return TRUE;
    }

    // Members can edit their own comments:
    return self::equals($comment->creator(), $this);
  }

  /**
   * Check if the member can delete the comment.
   *
   * @param ItemComment $comment
   * @return bool
   */
  public function canDeleteComment(ItemComment $comment) {
    // Check the comment is valid:
    if (!$comment->valid() || !$comment->published()) {
      return FALSE;
    }

    // Users with 'administer comments' (i.e. admins) can delete any comment.
    if (user_access('administer comments', $this->user())) {
      return TRUE;
    }

    // Members can delete their own comments:
    if (self::equals($comment->creator(), $this)) {
      return TRUE;
    }

    // Members can delete comments made on items posted in their channel.
    if (Channel::equals($comment->item()->channel(), $this->channel())) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Check if the member can join a group.
   *
   * @param Group $group
   * @return bool
   */
  public function canJoinGroup(Group $group) {
    // For now, any member can join any group:
    return TRUE;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Rendering methods.

  public function renderLinks() {
    return $this->channel()->renderLinks();
  }

  /**
   * Get the common query elements used by the items() and itemCount() methods.
   *
   * @return array
   */
  public function itemQuery() {
    // Select items from the member's own channel plus all channels they're subscribed to.
    $sql = "
      SELECT vci.item_nid
      FROM view_channel_has_item vci
      WHERE vci.item_status = 1
        AND (
          vci.channel_nid = :members_channel_nid
          OR
          vci.channel_nid IN (SELECT vcs.channel_nid FROM view_channel_has_subscriber vcs WHERE vcs.subscriber_uid = :member_uid)
        )";

    $params = array(
      ':members_channel_nid' => $this->channel()->nid(),
      ':member_uid'          => $this->uid()
    );

    return array($sql, $params);
  }

  /**
   * Get the items that should appear in the member's channel.
   *
   * @param int $offset
   * @param int $limit
   * @return array
   */
  public function items($offset = NULL, $limit = NULL) {
    list($sql, $params) = $this->itemQuery();

    // Order by:
    $sql .= " ORDER BY vci.changed DESC";

    // Add the offset and limit if specified:
    if ($offset !== NULL && $limit !== NULL) {
      $offset = (int) $offset;
      $limit = (int) $limit;
      $sql .= " LIMIT $offset, $limit";
    }

    // Get the items:
    $rs = db_query($sql, $params);
    $items = array();
    foreach ($rs as $rec) {
      $items[] = Item::create($rec->item_nid);
    }

    return $items;
  }

  /**
   * Get items from the channels the member is subscribed to.
   *
   * @param int $offset
   * @param int $limit
   * @return array
   */
  public function activityItems($offset = NULL, $limit = NULL) {
    $sql = "
      SELECT vci.item_nid
      FROM view_channel_has_item vci
      WHERE vci.item_status = 1
        AND vci.channel_nid IN (SELECT vcs.channel_nid FROM view_channel_has_subscriber vcs WHERE vcs.subscriber_uid = :member_uid)
      ORDER BY vci.changed DESC";
    $params = array(
      ':members_channel_nid' => $this->channel()->nid(),
    );

    // Add the offset and limit if specified:
    if ($offset !== NULL && $limit !== NULL) {
      $offset = (int) $offset;
      $limit = (int) $limit;
      $sql .= " LIMIT $offset, $limit";
    }

    // Get the items:
    $rs = db_query($sql, $params);
    $items = array();
    foreach ($rs as $rec) {
      $items[] = Item::create($rec->item_nid);
    }

    return $items;
  }

  /**
   * Get the total number of items in the member's profile channel.
   *
   * @return array
   */
  public function itemCount() {
    list($sql, $params) = $this->itemQuery();
    $rs = db_query($sql, $params);
    return $rs->rowCount();
  }

  /**
   * Render items for a member's profile.
   *
   * @return string
   */
  public function renderItems() {
    // Get the page number:
    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 0;

    // Get the items from this channel:
    $items = $this->items($page * Channel::pageSize, Channel::pageSize);

    // Get the total item count:
    $total_n_items = $this->itemCount();

    // Render the page of items:
    return Channel::renderItemsPage($items, $total_n_items);
  }

  /**
   * Render items for a member's profile.
   *
   * @return string
   */
  public function renderActivityItems() {
    // Get the page number:
    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 0;

    // Get the items from this channel:
    $items = $this->activityItems($page * Channel::pageSize, Channel::pageSize);

    // Get the total item count:
    $total_n_items = $this->itemCount();

    // Render the page of items:
    return Channel::renderItemsPage($items, $total_n_items);
  }

}
