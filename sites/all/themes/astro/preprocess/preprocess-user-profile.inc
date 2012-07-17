<?php

/**
 * Implement themehook_preprocess_user_profile().
 */
function astro_alpha_preprocess_user_profile(&$vars) {
  // Get the profile member:
  $profile_member = Member::create($vars['elements']['#account']);
  $vars['profile_member'] = $profile_member;

  // Get the current member:
  $current_member = Member::currentMember();
  $vars['current_member'] = $current_member;

  // Is the current member viewing their own profile?
  $vars['viewing_own_profile'] = $profile_member->uid() == $current_member->uid();

  // Get the profile member's channel:
  $channel = $profile_member->channel();
  $vars['channel'] = $channel;
  $channel->load();
}
