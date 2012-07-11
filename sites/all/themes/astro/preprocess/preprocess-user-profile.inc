<?php

/**
 * Implement themehook_preprocess_user_profile().
 */
function astro_alpha_preprocess_user_profile(&$vars) {
  global $user;
  $vars['member'] = $vars['elements']['#account'];
  $vars['viewing_own_profile'] = $user->uid == $vars['member']->uid;
  $member = Member::create($vars['member']->uid);
  $vars['channel_nid'] = $member->channel();
  $vars['channel'] = node_load($vars['channel_nid']);
}
