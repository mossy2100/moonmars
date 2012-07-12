<?php

/**
 * Implement themehook_preprocess_user_profile().
 */
function astro_alpha_preprocess_user_profile(&$vars) {
  global $user;

  // Get the member:
  $vars['member'] = Member::create($vars['elements']['#account']->uid);

  // Is the member viewing their own profile?
  $vars['viewing_own_profile'] = $user->uid == $vars['member']->uid();

  // Get the member's channel:
  $vars['channel'] = $vars['member']->channel();
  $vars['channel']->load();
}
