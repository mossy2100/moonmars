<?php

/**
 * Get the user's full name.
 *
 * @param int|stdClass $user
 * @return string
 */
function moonmars_members_get_full_name($user = NULL) {
  $user = param_user($user);
  $first_name = $user->field_first_name ? $user->field_first_name[LANGUAGE_NONE][0]['value'] : '';
  $last_name = $user->field_last_name ? $user->field_last_name[LANGUAGE_NONE][0]['value'] : '';
  return trim("$first_name $last_name");
}

/**
 * Get the user's name with full name.
 *
 * @param int|stdClass $user
 * @return string
 */
function moonmars_members_get_name_plus_full_name($user = NULL) {
  $user = param_user($user);
  $full_name = moonmars_members_get_full_name($user->uid);
  return $user->name . ($full_name ? " ($full_name)" : '');
}

function moonmars_members_get_link($uid) {
  return l(user_get_name($uid), "user/$uid");
}

/**
 * Get the user's location as city, state, country.
 *
 * @param int|stdClass $user
 * @return string
 */
function moonmars_members_get_location($user = NULL, $full = FALSE, $map_link = FALSE) {
  $user = param_user($user);
  if ($user->field_user_location) {
    $city = isset($user->field_user_location[LANGUAGE_NONE][0]['city']) ? $user->field_user_location[LANGUAGE_NONE][0]['city'] : NULL;
    $province = isset($user->field_user_location[LANGUAGE_NONE][0]['province']) ? $user->field_user_location[LANGUAGE_NONE][0]['province'] : NULL;
    $country = isset($user->field_user_location[LANGUAGE_NONE][0]['country']) ? strtoupper($user->field_user_location[LANGUAGE_NONE][0]['country']) : NULL;

    if ($full && $country) {
      // Get the full province name:
      if ($province) {
        $provinces = location_get_provinces($country);
        $province = $provinces[$province];
      }
      // Get the full country name:
      require_once DRUPAL_ROOT . '/includes/locale.inc';
      $countries = country_get_list();
      $country = $countries[$country];
    }

    $location = implode(', ', array_filter(array(
      $city,
      $province,
      $country
    )));

    if ($map_link) {
      $location = l($location, 'http://maps.google.com', array('attributes' => array('target' => '_blank'), 'query' => array('q' => $location)));
    }

    return $location;
  }
  return NULL;
}


/**
 * Calculate the user's age from their date of birth.
 *
 * @param null|int|stdClass $user
 * @return int|null
 */
function moonmars_members_get_age($user = NULL) {
  $user = param_user($user);
  $date_of_birth = $user->field_date_of_birth ? $user->field_date_of_birth[LANGUAGE_NONE][0]['value'] : NULL;
  if ($date_of_birth) {
    $date_of_birth = new StarDateTime($date_of_birth);

    // Calculates age using average year length:
//    $now = StarDateTime::now();
//    $diff = $now->diffSeconds($date_of_birth);
//    return floor($diff / StarDateTime::SECONDS_PER_YEAR ? 1 : 0);

    // Calculates age using calendar dates, which is more traditional:
    $today = StarDateTime::today();
    $birth_year = $date_of_birth->year();
    $current_year = $today->year();
    $birthday_this_year = $date_of_birth;
    $birthday_this_year->year($today->year());
    return ($current_year - $birth_year) + ($birthday_this_year <= $today ? 1 : 0);
  }

  return NULL;
}


/**
 * Get the user's gender as a single letter.
 *
 * @param null|int|stdClass $user
 * @param bool $full
 *   If TRUE then the full word is returned in title case.
 * @return string
 */
function moonmars_members_get_gender($user = NULL, $full = FALSE) {
  $user = param_user($user);
  $gender = $user->field_gender ? $user->field_gender[LANGUAGE_NONE][0]['value'] : NULL;
  if ($gender && $full) {
    $gender = ($gender == 'M') ? 'Male' : 'Female';
  }
  return $gender;
}

/**
 * A composite string of the age and gender, for the user info block.
 *
 * @param null|int|stdClass $user
 * @param bool $full
 * @return string
 */
function moonmars_members_get_age_gender($user = NULL, $full = FALSE) {
  $gender = moonmars_members_get_gender($user, $full);
  $age = moonmars_members_get_age($user);
  return implode('/', array_filter(array($gender, $age)));
}

/**
 * Generate HTML for a user avatar.
 *
 * @param int|stdClass $user
 * @return string
 */
function moonmars_members_get_avatar($user = NULL) {
  $user = param_user($user);

  // If the user has a picture, use it:
  if ($user->picture) {
    // If we just have the fid, load the file:
    if (is_uint($user->picture)) {
      $user->picture = file_load($user->picture);
    }
    $icon_path = $user->picture->uri;
  }
  else {
    // If the user doesn't have a picture, use a default icon:
    $icon = isset($user->field_moon_or_mars[LANGUAGE_NONE][0]['value']) ? $user->field_moon_or_mars[LANGUAGE_NONE][0]['value'] : 'both';
    $icon_path = "avatars/870x870/$icon-870x870.jpg";
  }

  $image = array(
    'style_name' => 'icon-40x40',
    'path'       => $icon_path,
    'alt'        => $user->name,
    'attributes' => array('class' => array('avatar-icon')),
  );

  return theme('image_style', $image);
}


/**
 * Generate HTML for a user avatar with link.
 *
 * @param int|stdClass $user
 * @return string
 */
function moonmars_members_get_avatar_link($user = NULL) {
  $uid = param_uid($user);
  return l(moonmars_members_get_avatar($user), "user/$uid", array('html' => TRUE, 'attributes' => array('class' => array('avatar-link'))));
}


/**
 * Generate HTML for a user avatar with link and tooltip.
 *
 * @param int|stdClass $user
 * @return string
 */
function moonmars_members_get_avatar_tooltip($user = NULL) {
  // HTML for the tooltip:
  $avatar = moonmars_members_get_avatar_link($user);
  $tooltip = moonmars_members_get_tooltip($user);

  return "
    <div class='avatar-tooltip'>
      $avatar
      $tooltip
    </div>
  ";
}


/**
 * Get a member's level.
 *
 * @param object|int|null $user
 * @return string|bool
 */
function moonmars_members_get_level($user = NULL) {
  $user = param_user($user);
  $levels = array_reverse(moonmars_members_levels());
  $user_level = FALSE;

  foreach ($levels as $level) {
    if (in_array($level, $user->roles)) {
      if (!$user_level) {
        $user_level = $level;
      }
      else {
        // The user level has already been found, so remove this level role:
        $user->roles = array_diff($user->roles, array($level));
        $save_user = TRUE;
      }
    }
  }

  // If no user level found, default to iron:
  if (!$user_level) {
    $user_level = 'iron';
    // Add the role:
    $role = user_role_load_by_name('iron');
    $user->roles[$role->rid] = 'iron';
    $save_user = TRUE;
  }

  if ($save_user) {
    user_save($user);
  }

  return $user_level;
}


/**
 * Set a member's level.
 *
 * @param object|int|null $user
 * @return string|bool
 */
function moonmars_members_set_level($user = NULL, $level = 'iron') {
  $user = param_user($user);
  $levels = moonmars_members_levels();

  // Remove any other levels:
  foreach ($levels as $level) {
    if (in_array($level, $user->roles)) {
      $user->roles = array_diff($user->roles, array($level));
    }
  }

  // Add the role for the new level:
  $role = user_role_load_by_name($level);
  $user->roles[$role->rid] = $level;

  // Save the user and return the updated account:
  return user_save($user);
}


/**
 * Get the user's member level number.
 *
 * @param object|int|null $user
 * @return int
 */
function moonmars_members_get_level_num($user = NULL) {
  return array_search(moonmars_members_get_level($user), moonmars_members_levels());
}


/**
 * Get a member's followers.
 *
 * @param int|stdClass $user
 * @return array
 */
function moonmars_members_get_followers($user = NULL) {
  $uid = param_uid($user);
  return moonmars_relationships_get_entity_ids('follows', 'user', NULL, 'user', $uid);
}

/**
 * Get a member's followees (i.e. other members that the member follows).
 *
 * @param int|stdClass $user
 * @return array
 */
function moonmars_members_get_followees($user = NULL) {
  $uid = param_uid($user);
  return moonmars_relationships_get_entity_ids('follows', 'user', $uid, 'user', NULL);
}


/**
 * Get the user's channel.
 *
 * @param null $user
 * @param bool $create
 * @return bool|int
 */
function moonmars_members_get_channel($user = NULL, $create = TRUE) {
  return moonmars_channels_get_channel('user', $user, $create);
}


/**
 * Get a member's groups.
 *
 * @param int|stdClass $user
 * @param int $offset
 * @param int $limit
 * @return array
 */
function moonmars_members_get_groups($user, $offset = NULL, $limit = NULL) {
  $uid = param_uid($user);

  // Get the group's members in reverse order of that in which they joined.
  $q = db_select('view_group_has_member', 'v')
    ->fields('v', array('group_nid'))
    ->condition('member_uid', $uid)
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
 * Generate HTML for an avatar tooltip.
 *
 * @param int|stdClass $user
 * @return string
 */
function moonmars_members_get_tooltip($user = NULL) {
  $user = param_user($user);

  // HTML for the tooltip:
  $user_name = "<strong>$user->name</strong>";
  $full_name = moonmars_members_get_full_name($user->uid);

  // Cater for names that are too long - we don't want the tooltip too big.
  if (strlen($full_name) > 50) {
    $full_name = substr($full_name, 0, 47) . '...';
  }

  $age_gender = implode('/', array_filter(array(
                                               moonmars_members_get_gender($user->uid),
                                               moonmars_members_get_age($user->uid),
                                          )));
  $location = moonmars_members_get_location($user->uid);
  return
    "<div class='user-tooltip' title='Visit $user->name&apos;s profile'>" .
    moonmars_members_get_avatar($user) .
    "<div class='user-tooltip-text'>" .
    implode('<br>', array_filter(array(
                                      $user_name,
                                      $full_name,
                                      $age_gender,
                                      $location
                                 ))) .
    "</div>" .
    "</div>";
}

