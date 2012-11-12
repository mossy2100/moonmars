<?php

use \AstroMultimedia\MoonMars\Member;

/**
 * Implement themehook_preprocess_user_profile().
 */
function astro_alpha_preprocess_user_profile(&$vars) {
  // Get the profile member:
  $page_member = Member::create($vars['elements']['#account']);
  $vars['page_member'] = $page_member;

  // Get the current member:
  $logged_in_member = Member::loggedInMember();
  $vars['logged_in_member'] = $logged_in_member;

  // Is the current member viewing their own profile?
  $vars['viewing_own_profile'] = $logged_in_member && ($page_member->uid() == $logged_in_member->uid());

  // Get the profile member's channel:
  $channel = $page_member->channel();
  $channel->load();
  $vars['channel'] = $channel;
}
