<?php
namespace AstroMultimedia\MoonMars;

use \stdClass;
use \AstroMultimedia\Star\Color;
use \AstroMultimedia\Star\Style;

/**
 * Encapsulates a moonmars.com member.
 */
class Member extends \AstroMultimedia\Drupal\User {

  /**
   * The tag prefix.
   */
  const TAG_PREFIX = '@';

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
   * The member's followers.
   *
   * @var array
   */
  protected $followers;

  /**
   * The member's followees.
   *
   * @var array
   */
  protected $followees;

  /**
   * The member's groups.
   *
   * @var array
   */
  protected $groups;

  /**
   * The member's notification preferences.
   *
   * @var array
   */
  protected $nxnPrefs;

  /**
   * Gender options.
   *
   * @var array
   */
  protected static $genders;

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
  public static function loggedInMember() {
    return user_is_logged_in() ? self::create($GLOBALS['user']->uid) : NULL;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set methods.

  /**
   * Get/set the user's name.
   *
   * @param null|string $name
   * @param bool $include_at
   * @return string|User
   */
  public function name($name = NULL, $include_prefix = FALSE) {
    if ($name === NULL) {
      // Get the username:
      return ($include_prefix ? self::TAG_PREFIX : '') . $this->prop('name');
    }
    else {
      // Set the username:
      return $this->prop('name', $name);
    }
  }

  /**
   * Get a link to the user's profile.
   *
   * @param null|string $label
   * @param bool $absolute
   * @return string
   */
  public function link($label = NULL, $absolute = FALSE) {
    $label = $label ?: $this->name();
    return parent::link($label, $absolute);;
  }

  /**
   * Get the member's tag, i.e. their username with the '@' prefix.
   *
   * @return string
   */
  public function tag() {
    return $this->name(NULL, TRUE);
  }

  /**
   * Get a link to the user's profile with their tag as the label.
   *
   * @return string
   */
  public function tagLink() {
    return $this->link($this->tag());
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
   * Calculate the member's age from their date of birth.
   *
   * @return int
   */
  public function age() {
    // Cache the result of the age calculation in the age property so we don't have to recalculate it again.
    if (!isset($this->age)) {

      $date_of_birth = $this->field('field_date_of_birth');

      if ($date_of_birth) {
        $date_of_birth = new DateTime($date_of_birth);
        $today = DateTime::today();
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
   * Get the genders.
   *
   * @static
   * @return array
   */
  public static function genders() {
    if (!isset(self::$genders)) {
      $rec = db_select('field_config', 'fc')
        ->fields('fc', array('data'))
        ->condition('field_name', 'field_gender')
        ->execute()
        ->fetch();
      $data = unserialize($rec->data);
      self::$genders = $data['settings']['allowed_values'];
    }
    return self::$genders;
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
    if ($gender && $full) {
      $genders = self::genders();
      if (isset($genders[$gender])) {
        return $genders[$gender];
      }
    }
    return $gender;
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
   * Get the member's bio field.
   *
   * @return string
   */
  public function bio() {
    return $this->field('field_bio');
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Avatars, tooltips, links

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

        // If we only have the fid, load the file:
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
                                                   'html' => TRUE,
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
      return "<a class='skype-add' href='skype:$skype?add'></a>";
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
//      $this->tooltip = "
//        <div class='user-tooltip' title='Visit $username&apos;s profile'>" .
//        $this->avatar() .
//        "<div class='user-tooltip-text'>$info</div>" .
//        "</div>";
      $this->tooltip = "<div class='user-tooltip' title='Visit $username&apos;s profile'>$info</div>";
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
      'title' => 'Visit ' . $this->name() . "'s profile."
    );
    return l($this->name(), $this->alias(), array('attributes' => $attr));
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

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Channel

  /**
   * Get the member's channel.
   *
   * @param bool $create
   * @return int
   */
  public function channel($create = TRUE) {
    if (!isset($this->channel)) {
      $this->channel = moonmars_actors_get_channel($this, $create);
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

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Alias

  /**
   * Update the path alias for the member's profile.
   *
   * @return string
   */
  public function resetAlias() {
    $alias = 'member/' . $this->name();
    $this->alias($alias);
    return $alias;
  }

  /**
   * Get the path to the entity's email preferences form.
   *
   * @return string
   */
  public function emailPreferencesAlias() {
    return $this->alias() . '/email-preferences';
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Style

  /**
   * Get the comment background color.
   *
   * @return Color
   */
  public function commentBackgroundColor() {
    $bg_color = $this->field('field_background_color', LANGUAGE_NONE, 0, 'rgb');

    if (Color::isHexString($bg_color)) {
      $bg_color = new Color($bg_color);
    }
    else {
      // Default to blue:
      $bg_color = new Color(220, 0.97, 0.97, TRUE);
    }

    // Reset the saturation and lightness:
    $bg_color->saturation(0.97);
    $bg_color->lightness(0.97);

    return $bg_color;
  }

  /**
   * Get the comment border color. Same as the background color except darker.
   *
   * @return Color
   */
  public function commentBorderColor() {
    $border_color = clone $this->commentBackgroundColor();
    $border_color->saturation(0.8);
    $border_color->lightness(0.8);
    return $border_color;
  }

  /**
   * Get the HTML attribute for the member's comment border style.
   *
   * @return string
   */
  public function commentBorderStyle($highlight = FALSE) {
    $style = new Style([
      'border-color' => $this->commentBorderColor()->hex(),
    ]);
    return $style->inline();
  }

  /**
   * Get the HTML attribute for the member's post or comment style.
   */
  public function commentStyle($highlight = FALSE) {
    $style = new Style([
      'padding' => ($highlight ? 4 : 5) . 'px',
      'border' => 'solid ' . ($highlight ? 2 : 1) . 'px ' . $this->commentBorderColor()->hex(),
      'background-color' => ($highlight ? 'white' : $this->commentBackgroundColor()->hex()),
    ]);
    return $style->inline();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Location/geography

  /**
   * Get the location as an array.
   *
   * @return array
   */
  public function location() {
    // Initialise:
    $city           = $this->field('field_user_location', LANGUAGE_NONE, 0, 'city');
    $province_code  = $this->field('field_user_location', LANGUAGE_NONE, 0, 'province');
    $province_name  = '';
    $country_code   = '';
    $country_name   = '';

    // Get the list of countries:
    require_once DRUPAL_ROOT . '/includes/locale.inc';
    $countries = country_get_list();

    // Check the country code. The location module uses lower-case codes but we'll use upper-case which is standard.
    $lc_country_code = $this->field('field_user_location', LANGUAGE_NONE, 0, 'country');
    // Check if we have a 2-letter country code, and, if so, force to lower-case:
    $country_code_ok = location_standardize_country_code($lc_country_code);
    if ($country_code_ok) {
      // Now check if the country code actually corresponds to a country:
      $uc_country_code = strtoupper($lc_country_code);
      $country_code_ok = isset($countries[$uc_country_code]);
    }

    // If we have a valid country code, get the province and country name:
    if ($country_code_ok) {
      // Get the country code and name:
      $country_code = $uc_country_code;
      $country_name = $countries[$country_code];

      // If we have a province code, get the full province name:
      if ($province_code) {
        $provinces = location_get_provinces($lc_country_code);
        $province_name = $provinces[$province_code];
      }
    }

    // Create the location array:
    return array(
      'city'          => $city,
      'province_code' => $province_code,
      'province_name' => $province_name,
      'country_code'  => $country_code,
      'country_name'  => $country_name,
    );
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
   * Get the member's country code.
   *
   * @return string
   */
  public function countryCode() {
    return strtoupper($this->field('field_user_location', LANGUAGE_NONE, 0, 'country'));
  }

  /**
   * Get the value of the "Moon or Mars" field.
   *
   * @return string
   */
  public function moonOrMars() {
    $moon_or_mars = $this->field('field_moon_or_mars');
    return $moon_or_mars ?: 'both';
  }

  /**
   * Renders a Moon, Mars or Both icon, with a flag on top.
   * @todo check if this is still used.
   *
   * @return string
   */
  public function moonOrMarsWithFlag() {
    $this->load();

    // If the user doesn't have a picture, use a default icon:
    $moon_or_mars = $this->moonOrMars();
    $image = array(
      'style_name' => 'icon-40x40',
      'path'       => "avatars/870x870/$moon_or_mars-870x870.jpg",
      'alt'        => $this->name(),
      'attributes' => array('class' => array('avatar-icon')),
    );

    // Remember the HTML in the property so we don't have to theme the image again:
    $html = theme('image_style', $image);

    // See if the flag exists for the member's country:
    $country = $this->field('field_user_location', LANGUAGE_NONE, 0, 'country');
    if ($country) {
      $path = "/" . drupal_get_path('theme', 'astro') . "/images/flag-icons/$country.png";
      if (file_exists(DRUPAL_ROOT . $path)) {
        $html .= "<img id='profile-flag' src='$path'>";
      }
    }

    return $html;
  }

  /**
   * Create a planet-flag icon for this member.
   * @todo check if this is still used.
   *
   * @return string
   */
  public function planetFlagIcon() {
    require_once DRUPAL_ROOT . '/modules/system/image.gd.inc';

    $moon_or_mars = $this->moonOrMars();
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

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Group-related methods.

  /**
   * Get a member's groups.
   *
   * @return array
   */
  public function groups() {
    // Check if we already did this:
    if (!isset($this->groups)) {
      $this->groups = array();

      // Get the group's members in reverse order of that in which they joined.
      $q = db_select('view_group_has_member', 'v')
        ->fields('v', array('group_nid'))
        ->condition('member_uid', $this->uid())
        ->orderBy('created', 'DESC');

      // Get the groups:
      $rs = $q->execute();
      foreach ($rs as $rec) {
        $this->groups[] = Group::create($rec->group_nid);
      }
    }

    return $this->groups;
  }

  /**
   * Get the number of groups that a member is in.
   *
   * @return int
   */
  public function groupCount() {
    return count($this->groups());
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Follow-related methods.

  /**
   * Get a member's followers.
   *
   * @return array
   */
  public function followers() {
    // Check if we already got them:
    if (!isset($this->followers)) {

      // Get the member's followers in reverse order of that in which they connected.
      $q = db_select('view_followers', 'vf')
        ->fields('vf', array('follower_uid'))
        ->condition('followee_uid', $this->uid())
        ->orderBy('created', 'DESC');
      $rs = $q->execute();

      $this->followers = array();
      foreach ($rs as $rec) {
        $this->followers[] = self::create($rec->follower_uid);
      }
    }

    return $this->followers;
  }

  /**
   * Get the number of followers that a member has.
   *
   * @return int
   */
  public function followerCount() {
    return count($this->followers());
  }

  /**
   * Get a member's followees (i.e. other members that the member follows).
   *
   * @return array
   */
  public function followees() {
    // Check if we already got them:
    if (!isset($this->followees)) {
      // Get the member's followees in reverse order of that in which they connected.
      $q = db_select('view_followers', 'vf')
        ->fields('vf', array('followee_uid'))
        ->condition('follower_uid', $this->uid())
        ->orderBy('created', 'DESC');
      $rs = $q->execute();

      $this->followees = array();
      foreach ($rs as $rec) {
        $this->followees[] = self::create($rec->followee_uid);
      }
    }

    return $this->followees;
  }

  /**
   * Get the number of followees that a member has.
   *
   * @return int
   */
  public function followeeCount() {
    return count($this->followees());
  }

  /**
   * Checks if one member follows another.
   *
   * @param Member $member
   */
  public function follows(Member $member) {
    // If we've already got the list of followees, look through that first in order to avoid a database hit:
    if (isset($this->followees)) {
      foreach ($this->followees as $followee) {
        if ($member->equals($followee)) {
          return TRUE;
        }
      }
    }

    // Otherwise let's look for a relationship:
    $rels = Relation::searchBinary('follows', $this, $member);
    return (bool) $rels;
  }

  /**
   * Follow another member.
   *
   * @param Member $member
   */
  public function follow(Member $member) {
    // Create or update the follow relationship:
    Relation::updateBinary('follows', $this, $member);

//    // Notify the followee, if they want to be notified:
//    if ($member->nxnPrefWants('site', 'new-follower')) {
//      $subject = "You have a new follower!";
//      $summary = $this->link() . " followed you. They're really cool, you could " . l('follow them back', $this->alias() . '/follow') . ".";
//      $member->notify($summary, NULL, $this, $member->channel());
//    }

    // Create a triumph:
    Triumph::newFollower($this, $member);
  }

  /**
   * Unfollow another member.
   *
   * @param Member $member
   */
  public function unfollow(Member $member) {
    // Delete the follow relationship:
    Relation::deleteBinary('follows', $this, $member);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Group-related methods

  /**
   * Add a member to the group.
   *
   * @param Member $member
   */
  public function joinGroup(Group $group) {
    // Create or update the membership relationship.
    // We're calling updateBinary() here instead of createBinary(), just in case, but actually this method should never
    // be called if they're already a member of the group. See logic in moonmars_groups_join().
    Relation::updateBinary('has_member', $group, $this);

    // Create the triumph:
    Triumph::newMember($this, $group);

//    //////////////////
//    // Notifications
//
//    // Nxn summary:
//    $summary = "Guess what! " . $this->link() . " joined the group " . $group->link() . ".";
//
//    // 1. Notify group members:
//    $members = $group->members();
//    foreach ($members as $member) {
//      // If they want to be notified, notify them:
//      if ($member->nxnPrefWants('group', 'new-member')) {
//        $member->notify($summary, $group, $this);
//      }
//    }
//
//    // 2. Notify the member's followers:
//    $members = $this->followers();
//    foreach ($members as $member) {
//      // If they want to be notified, notify them:
//      if ($member->nxnPrefWants('followee', 'join-group')) {
//        $member->notify($summary, $group, $this);
//      }
//    }
  }

  /**
   * Remove a member from the group.
   *
   * @param Member $member
   */
  public function leaveGroup(Group $group) {
    // Delete the membership relationship:
    Relation::deleteBinary('has_member', $group, $this);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Notifications

//  /**
//   * Send a notification message to a member.
//   *
//   * @param string $summary
//   * @param Entity $thing
//   *   The thing (member, group, item or comment) that the notification is about.
//   * @param Member $actor
//   * @param Channel $channel
//   * @param Item $item
//   * @param ItemComment $comment
//   */
//  public function notify($summary, $thing = NULL, Member $actor = NULL) {
//    $subject = strip_tags($summary);
//
//    // Create the notification node:
//    $notification_summary = "
//      <p class='notification-summary'>
//        $summary
//      </p>
//      <p class='notification-teaser'>
//       " . moonmars_text_trim($thing->text(), 100) . "
//      </p>
//    ";
//    $notification = Nxn::create();
//    $notification->uid($this->uid());
//    $notification->title($subject);
//    $notification->field('field_notification_summary', LANGUAGE_NONE, 0, 'value', $notification_summary);
//    $notification->save();
//
//    $text = $thing->html();
//
//    $params = array(
//      'subject' => "[moonmars.com] $subject",
//      'summary' => "<p style='margin: 0 0 10px; color: #919191;'>$summary</p>",
//      'text'    => "<p style='margin: 0;'>$text</p>",
//    );
//    drupal_mail('moonmars_nxn', 'notification', $this->mail(), language_default(), $params);
//  }

  /**
   * Check what notifications a member wants of a certain type.
   * Returns an array with two keys:
   *    nxn_wants => MOONMARS_NXN_NO, MOONMARS_NXN_YES or MOONMARS_NXN_SOME
   *    nxn_conditions => an array of conditions
   *
   * @param string $category
   *   site, channel, followee or group
   * @param string $triumph_type
   * @param int $entity_id
   *   The group_nid or followee_uid
   * @return array
   */
  public function nxnPref($nxn_category, $triumph_type, $entity_id = 0) {
    // Check if we already got this result:
    if (!isset($this->nxnPrefs[$nxn_category][$triumph_type][$entity_id])) {

      $found = FALSE;
      $nxn_pref = NULL;
      $nxn_definitions = moonmars_nxn_definitions();

      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      // 1. Get the "wants" preference.

      // 1a. If entity_id is specified (indicating group_nid or followee_uid), look for this exact preference:
      if ($entity_id) {
        $q = db_select('moonmars_nxn_pref', 'np')
          ->fields('np', array('nxn_wants', 'nxn_conditions'))
          ->condition('nxn_category', $nxn_category)
          ->condition('triumph_type', $triumph_type)
          ->condition('entity_id', $entity_id)
          ->condition('uid', $this->uid());
        $rs = $q->execute();
        $rec = $rs->fetchObject();
        if ($rec) {
          $found = TRUE;
          $nxn_pref['wants'] = $rec->nxn_wants;
        }
      }

      // 1b. If we did not find it (or if entity_id not specified), use their base preference:
      if (!$found) {
        $q = db_select('moonmars_nxn_pref', 'np')
          ->fields('np', array('nxn_wants', 'nxn_conditions'))
          ->condition('nxn_category', $nxn_category)
          ->condition('triumph_type', $triumph_type)
          ->condition('entity_id', 0)
          ->condition('uid', $this->uid());
        $rs = $q->execute();
        $rec = $rs->fetchObject();
        if ($rec) {
          $found = TRUE;
          $nxn_pref['wants'] = $rec->nxn_wants;
        }
      }

      // 1c. If we still don't have the value, use the site default:
      if (!$found) {
        $nxn_pref['wants'] = $nxn_definitions[$nxn_category]['triumph types'][$triumph_type]['default'];
      }

      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      // 2. If Some, get the "conditions" preferences.

      if ($nxn_pref['wants'] == MOONMARS_NXN_SOME) {
        // If a db record was found, get the conditions that were specified:
        if ($found && $rec->nxn_conditions) {
          $rec_nxn_conditions = unserialize($rec->nxn_conditions);
        }

        // Scan through the conditions and use default value if not set.
        $nxn_conditions = $nxn_definitions[$nxn_category]['triumph types'][$triumph_type]['conditions'];
        foreach ($nxn_conditions as $nxn_condition => $nxn_condition_info) {
          if (isset($rec_nxn_conditions[$nxn_condition])) {
            // If specified in the database record, use that value:
            $nxn_pref['conditions'][$nxn_condition] = $rec_nxn_conditions[$nxn_condition];
          }
          else {
            // Otherwise use the default:
            $nxn_pref['conditions'][$nxn_condition] = $nxn_condition_info['default'];
          }
        }
      }

      // Remember the result:
      $this->nxnPrefs[$nxn_category][$triumph_type][$entity_id] = $nxn_pref;
    }

    return $this->nxnPrefs[$nxn_category][$triumph_type][$entity_id];
  }

  /**
   * Find out whether a member wants a certain notification in a certain category.
   * Returns MOONMARS_NXN_NO, MOONMARS_NXN_YES, or MOONMARS_NXN_SOME.
   *
   * @param string $nxn_category
   *   site, channel, followee or group
   * @param string $triumph_type
   * @param int $entity_id
   *   The group_nid or followee_uid
   * @return int
   */
  public function nxnPrefWants($nxn_category, $triumph_type, $entity_id = 0) {
    $nxn_pref = $this->nxnPref($nxn_category, $triumph_type, $entity_id);
    return $nxn_pref['wants'];
  }

  /**
   * Find out the conditions for when a member only wants some of a certain kind of notification.
   * Arrays of conditions have the condition key as keys and booleans as values, e.g.
   *    array(
   *      'mention' => TRUE,
   *      'topic' => FALSE,
   *    )
   * Then we know which checkboxes have actually been set, i.e. if the key is not in the array then use the default.
   *
   * @param string $nxn_category
   *   site, channel, followee or group
   * @param string $triumph_type
   * @param int $entity_id
   *   The group_nid or followee_uid
   * @return array
   */
  public function nxnPrefConditions($nxn_category, $triumph_type, $entity_id = 0) {
    $nxn_pref = $this->nxnPref($nxn_category, $triumph_type, $entity_id);
    return isset($nxn_pref['conditions']) ? $nxn_pref['conditions'] : [];
  }

  /**
   * Check if a member may want a certain notification.
   *
   * @param string $nxn_category
   *   site, channel, followee or group
   * @param string $triumph_type
   * @param int $entity_id
   *   The group_nid or followee_uid
   * @return bool
   */
  public function nxnMayWant($nxn_category, $triumph_type, $entity_id = 0) {
    return in_array($this->nxnPrefWants($nxn_category, $triumph_type, $entity_id), [MOONMARS_NXN_YES, MOONMARS_NXN_SOME]);
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
      // @todo Implement permissions so people can specify who can post in their channel.
      // If a post is blocked from a channel by permissions, then the tag appears crossed out.

      // The member is the only one who can post in their own channel:
//      return $parent_entity->equals($this);

      // Members can post in each others' channels.
      return TRUE;
    }
    elseif ($parent_entity instanceof Group) {
      // Only administrators can post items in the News channel.
      // @todo This should be controlled by group permission settings.
      if ($channel->nid() == MOONMARS_NEWS_CHANNEL_NID) {
        return $this->hasRole('administrator') || $this->hasRole('site administrator');
      }

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

    // An administrator can delete any item:
    if ($this->isAdmin()) {
      return TRUE;
    }

    // A member can delete an item if they posted it.
    if ($this->equals($item->creator())) {
      return TRUE;
    }

    // A member can delete any item posted in their channel.
    if ($this->channel()->equals($item->channel())) {
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
      // Anyone can post comments in the News channel:
      if ($channel->nid() == MOONMARS_NEWS_CHANNEL_NID) {
        return TRUE;
      }

      // If posted in a group channel, the member can post comment in it if they're a member of the group:
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
    return $this->equals($comment->creator());
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
    if ($this->equals($comment->creator())) {
      return TRUE;
    }

    // Members can delete comments made on items posted in their channel.
    if ($this->channel()->equals($comment->item()->channel())) {
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

  /**
   * Check if the member can administer a group.
   *
   * @param Group $group
   * @return bool
   */
  public function canAdministerGroup(Group $group) {
    return $this->isSuperuser() || $this->isAdmin() || $this->isGroupAdmin($group);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Rendering

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
   * Get all the items posted by the member that have modified (created, changed or commented on) within a datetime range.
   * Note, this method does NOT return an array of Item objects, but timestamps, because it's designed for
   * lightning fast sorting. Item object creation happens later when the page is rendered.
   *
   * @param int $ts_start
   * @param int $ts_end
   * @return array
   */
  public function itemsPostedBy($ts_start, $ts_end) {
    $q = db_select('view_channel_has_item', 'vchi')
      ->fields('vchi', array('nid', 'item_modified'))
      ->condition('item_uid', $this->uid())
      ->condition('item_modified', [$ts_start, $ts_end], 'BETWEEN');
    $rs = $q->execute();
    $items = array();
    foreach ($rs as $rec) {
      $items[$rec->nid] = $rec->item_modified;
    }
    return $items;
  }

  /**
   * Get the items that should appear in the member's profile channel.
   * This method is optimised for speed and memory.
   * @todo Check for restricted/closed groups. Need Member::canSeeItem() method.
   * @todo Include topics the member is following.
   *
   * @param int $ts_start
   * @param int $ts_end
   * @return array
   */
  public function items($ts_start, $ts_end) {
    // Items appearing in their profile channel come from multiple sources:
    //   1. Items posted by them.
    //   2. Items posted by their followees.
    //   3. Items posted in their channel.
    //   4. Items posted in their groups. @todo Replace this with: Items tagged with one of their groups.
    //   5. Items tagged with their member tag. @todo
    //   6. Items tagged with a topic they're following. @todo

    /////////////////////////////////////////////////////////////////////
    // Create an array of uids of item posters that we want to include.

    // Start with theirs:
    $item_uids = [$this->uid()];

    // Now get the uids of this member's followees.
    // If we already have the followees in an array, use that:
    if (isset($this->followees)) {
      foreach ($this->followees as $followee) {
        $item_uids[] = $followee->uid();
      }
    }
    else {
      // Get the member's followees from the db:
      $q = db_select('view_followers', 'vf')
        ->fields('vf', array('followee_uid'))
        ->condition('follower_uid', $this->uid());
      $rs = $q->execute();
      foreach ($rs as $rec) {
        $item_uids[] = $rec->followee_uid;
      }
    }

    /////////////////////////////////////////////////////////////////////
    // Create an array of nids of channels that we want to include.

    // Start with theirs:
    $channel_nids = [$this->channel()->nid()];

    // Now get the nids of this member's groups' channels.
    // If we already have the groups in an array, use that:
    if (isset($this->groups)) {
      foreach ($this->groups as $group) {
        $channel_nids[] = $group->channel()->nid();
      }
    }
    else {
      // Get the member's groups from the db:
      $q = db_select('view_group_has_member', 'vghm')
        ->join('view_entity_has_channel', 'vehc', "vgm.group_nid = vec.entity_id AND vec.entity_type = 'node'");
      $q->fields('vehc', array('channel_nid'))
        ->condition('vghm.member_uid', $this->uid());
      $rs = $q->execute();
      foreach ($rs as $rec) {
        $channel_nids[] = $rec->channel_nid;
      }
    }

    /////////////////////////////////////////////////////////////////////
    // The main query.
    $q = db_select('view_channel_has_item', 'vchi')
      ->fields('vchi', array('nid', 'item_modified'))
      ->condition(db_or()
        ->condition('item_uid', $item_uids)
        ->condition('channel_nid', $channel_nids))
      ->condition('item_modified', [$ts_start, $ts_end], 'BETWEEN');
    dbg_query($q);
    $rs = $q->execute();
    $items = array();
    foreach ($rs as $rec) {
      $items[$rec->nid] = $rec->item_modified;
    }

    // Order the items in descending order of the latest time it was created, changed or commented on.
    asort($items);
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

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Ratings

  /**
   * Get/set this member's rating for an entity.
   *
   * @param string $entity_type
   * @param int $entity_id
   * @param int $new_rating
   * @return int|bool
   */
  public function rating($entity, $new_rating = NULL) {
    if ($new_rating === NULL) {
      // Get this member's rating for the entity.
      $rels = Relation::searchBinary('rates', $this, $entity);

      if ($rels) {
        return (int) $rels[0]->field('field_rating');
      }

      // The member hasn't rated this entity yet:
      return FALSE;
    }
    else {
      // Set this member's rating for the entity.

      // Get the member's current rating for this entity:
      $old_rating = $this->rating($entity);
      // $old_rating will be FALSE if the member hasn't rated the entity yet.

      $rating_names = moonmars_ratings_names();

      // Initialise result:
      $result = array(
        'rater' => array(
          'uid' => $this->uid(),
        ),
        'entity' => array(
          'old_rating'      => $old_rating,
          'old_rating_name' => $rating_names[$old_rating],
          'new_rating'      => $new_rating,
          'new_rating_name' => $rating_names[$new_rating],
        ),
      );

      /////////////////////////////////////////////////////////
      // Step 1. Update the rating relationship:
      $rel = Relation::updateBinary('rates', $this, $entity, FALSE);
      $rel->field('field_rating', LANGUAGE_NONE, 0, 'value', $new_rating);
      $rel->field('field_multiplier', LANGUAGE_NONE, 0, 'value', 1);
      $rel->save();

      /////////////////////////////////////////////////////////
      // Step 2. Update the entity's score.

      // Get the entity's current score:
      $entity_old_score = (int) $entity->field('field_score');

      // Update the entity's total score:
      $entity_new_score = $entity_old_score - $old_rating + $new_rating;
      $entity->field('field_score', LANGUAGE_NONE, 0, 'value', $entity_new_score);
      $entity->save();

      // Add to result:
      $result['entity']['old_score'] = $entity_old_score;
      $result['entity']['new_score'] = $entity_new_score;

//      /////////////////////////////////////////////////////////
//      // Step 3. Update the rater's score.
//
//      // If the rater hasn't rated this entity before, give them a point:
//      if ($old_rating === FALSE) {
//        // Get the rater's current score:
//        $rater_old_score = (int) $this->field('field_score');
//
//        // Update the rater's total score:
//        $rater_new_score = $rater_old_score + 1;
//        $this->field('field_score', LANGUAGE_NONE, 0, 'value', $rater_new_score);
//        $this->save();
//
//        // Add to result:
//        $result['rater']['old_score'] = $rater_old_score;
//        $result['rater']['new_score'] = $rater_new_score;
//      }

      /////////////////////////////////////////////////////////
      // Step 4. Update the poster's score.

      // Get the entity's poster:
      $poster = $entity->creator();

      // Get the poster's current score:
      $poster_old_score = (int) $poster->field('field_score');

      // Update the poster's total score:
      $poster_new_score = $poster_old_score - $old_rating + $new_rating;
      $poster->field('field_score', LANGUAGE_NONE, 0, 'value', $poster_new_score);
      $poster->save();

      // Add to result:
      $result['poster']['uid'] = $poster->uid();
      $result['poster']['old_score'] = $poster_old_score;
      $result['poster']['new_score'] = $poster_new_score;

      /////////////////////////////////////////////////////////
      // Step 5. Update the group's score, if applicable.

      $item = NULL;

      if ($entity instanceof ItemComment) {
        $item = $entity->item();
      }
      elseif ($entity instanceof Item) {
        $item = $entity;
      }

      if ($item) {
        // If the item was shared in a group, find it.
        $group = NULL;

        $channel = $item->channel();
        if ($channel) {
          $parent_entity = $channel->parentEntity();
          if ($parent_entity && ($parent_entity instanceof Group)) {
            $group = $parent_entity;
          }
        }

        if ($group) {
          // Get the group's current score:
          $group_old_score = (int) $group->field('field_score');

          // Update the group's total score:
          $group_new_score = $group_old_score - $old_rating + $new_rating;
          $group->field('field_score', LANGUAGE_NONE, 0, 'value', $group_new_score);
          $group->save();

          // Add to result:
          $result['group']['nid'] = $group->nid();
          $result['group']['old_score'] = $group_old_score;
          $result['group']['new_score'] = $group_new_score;
        }
      }

      return $result;
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Comments

  /**
   * Checks if a member commented on an item.
   *
   * @param Item $item
   * @return bool
   */
  public function commentedOn(Item $item) {
    foreach ($item->commenters() as $commenter) {
      if ($this->equals($commenter)) {
        return TRUE;
      }
    }
    return FALSE;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Search

  /**
   * Look for a member with the specified name. Avoid doing a full user load.
   *
   * @static
   * @param $name
   * @return Member|bool
   */
  public static function createByName($name) {
    $q = db_select('users', 'u')
      ->fields('u', array('uid'))
      ->condition('name', $name);
    $rs = $q->execute();
    $rec = $rs->fetch();
    return $rec ? self::create($rec->uid) : FALSE;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Roles

  /**
   * Check if the member is a group administrator.
   *
   * @return bool
   */
  public function isGroupAdmin(Group $group = NULL) {
    $is_group_admin = $this->hasRole('group administrator');

    // If they don't have this role then they're not a group admin, regardless of the value of $group:
    if (!$is_group_admin) {
      return FALSE;
    }

    // If the group is not specified, but they have this role, then they are a group admin of some group.
    if (!$group) {
      return TRUE;
    }

    // Check if the user is a member of the group, and if they're also an admin.
    $rels = Relation::searchBinary('has_member', $group, $this);
    return $rels ? ((bool) $rels[0]->field('field_is_admin')) : FALSE;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Triumphs

  /**
   * Check if we've already created a new-member triumph for this member.
   *
   * @return bool
   */
  public function newMemberTriumphCreated() {
    $q = db_select('moonmars_triumph', 't')
      ->fields('t', ['triumph_id'])
      ->condition('t.triumph_type', 'new-member')
      ->condition('a.entity_id', $this->uid());
    $q->join('moonmars_triumph_actor', 'a', "t.triumph_id = a.triumph_id");
    $rs = $q->execute();
    return (bool) $rs->rowCount();
  }

}
