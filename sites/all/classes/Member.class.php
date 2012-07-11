<?php
/**
 * Encapsulates a moonmars.com member.
 */

class Member extends User {

  private $age;
  private $avatar;
  private $tooltip;

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
   * @param bool $full
   * @return array
   */
  public function location($full = FALSE) {
    $location = array(
      'city'          => $this->field('field_user_location', LANGUAGE_NONE, 0, 'city'),
      'province_code' => $this->field('field_user_location', LANGUAGE_NONE, 0, 'province'),
    );

    // Get the country code:
    $country_code = $this->field('field_user_location', LANGUAGE_NONE, 0, 'country');

    // Location module uses lower-case country codes. Drupal and basically everyone else in the world uses upper-case:
    $location['country_code'] = strtoupper($country_code);

    // Default names:
    $location['province_name'] = '';
    $location['country_name'] = '';

    if ($country_code) {
      if ($full) {
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
    }

    return $location;
  }

  /**
   * Get the location as a string.
   *
   * @param bool $full
   * @return array
   */
  public function locationStr($full = FALSE, $map_link = FALSE) {
    $location = $this->location($full);

    if ($full) {
      $location_str = implode(', ', array_filter(array($location['city'], $location['province_name'], $location['country_name'])));
    }
    else {
      $location_str = implode(', ', array_filter(array($location['city'], $location['province_code'], $location['country_code'])));
    }

    if ($map_link) {
      return l($location_str, 'http://maps.google.com', array('attributes' => array('target' => '_blank'), 'query' => array('q' => $location_str)));
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
    if (!$this->age) {
      $date_of_birth = $this->field('field_date_of_birth');
      if ($date_of_birth) {
        $date_of_birth = new StarDateTime($date_of_birth);
        $today = StarDateTime::today();
        $birth_year = $date_of_birth->year();
        $current_year = $today->year();
        $birthday_this_year = $date_of_birth;
        $birthday_this_year->year($today->year());
        $this->age = ($current_year - $birth_year) + ($birthday_this_year <= $today ? 1 : 0);
      }
    }
    return $this->age;
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
    return implode('/', array_filter(array($gender, $age)));
  }

  /**
   * Generate HTML for a member avatar.
   *
   * @return string
   */
  public function avatar() {
    if (!$this->avatar) {
      // If the user has a picture, use it:
      if (isset($this->entity->picture)) {
        // If we just have the fid, load the file:
        if (is_uint($this->entity->picture)) {
          $this->entity->picture = file_load($this->entity->picture);
        }
        $icon_path = $this->entity->picture->uri;
      }
      else {
        // If the user doesn't have a picture, use a default icon:
        $icon = $this->field('field_moon_or_mars');
        if (!$icon) {
          $icon = 'both';
        }
        $icon_path = "avatars/870x870/$icon-870x870.jpg";
      }

      $image = array(
        'style_name' => 'icon-40x40',
        'path'       => $icon_path,
        'alt'        => $this->entity->name,
        'attributes' => array('class' => array('avatar-icon')),
      );
      $this->avatar = theme('image_style', $image);
    }
    return $this->avatar;
  }

  /**
   * Generate HTML for a user avatar with link.
   *
   * @return string
   */
  public function avatarLink() {
    return l($this->avatar(), 'user/' . $this->entity->uid, array('html' => TRUE, 'attributes' => array('class' => array('avatar-link'))));
  }

  /**
   * Generate HTML for a member's avatar tooltip.
   *
   * @return string
   */
  function tooltip() {
    if (!$this->tooltip) {
      $this->load();
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

      return
        "<div class='user-tooltip' title='Visit $username&apos;s profile'>" .
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
   * Get a member's level.
   *
   * @return string|bool
   */
  public function level($level = NULL) {
    $levels = moonmars_members_levels();

    if (func_num_args() == 0) {
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
   * Get the user's member level number.
   *
   * @return int
   */
  public function levelNum() {
    return array_search($this->level(), moonmars_members_levels());
  }

  /**
   * Get a member's followers.
   *
   * @return array
   */
  public function followers() {
    return moonmars_relationships_get_entity_ids('follows', 'user', NULL, 'user', $this->entity->uid);
  }

  /**
   * Get a member's followees (i.e. other members that the member follows).
   *
   * @return array
   */
  public function followees() {
    return moonmars_relationships_get_entity_ids('follows', 'user', $this->entity->uid, 'user', NULL);
  }

  /**
   * Checks if one user follows another.
   *
   * @param int $uid
   */
  public function follows($uid) {
    $rels = moonmars_relationships_get_relationships('has_follower', 'user', $uid, 'user', $this->entity->uid);
    return !empty($rels);
  }

  /**
   * Get the member's channel.
   *
   * @param bool $create
   * @return int
   */
  public function channel($create = TRUE) {
    return moonmars_channels_get_channel('user', $this->entity->uid, $create);
  }

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
      ->condition('member_uid', $this->entity->uid)
      ->orderBy('created', 'DESC');

    // Set a limit if specified:
    if ($offset !== NULL && $limit !== NULL) {
      $q->range($offset, $limit);
    }

    $rs = $q->execute();
    $group_nids = array();
    foreach ($rs as $rec) {
      $group_nids[] = $rec->group_nid;
    }

    return $group_nids;
  }

  /**
   * Send a notification message to a member.
   *
   * @param $message
   */
  public function notify($message) {
//    drupal_mail('moonmars_members', 'notification', $this->mail(), LANGUAGE_NONE, $params = array(), $from = NULL, $send = TRUE)
  }

}
