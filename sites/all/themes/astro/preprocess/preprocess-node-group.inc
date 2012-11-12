<?php

use \AstroMultimedia\MoonMars\Member;
use \AstroMultimedia\MoonMars\Group;

/**
 * Preprocess function for group nodes.
 *
 * @param $vars
 */
function astro_alpha_preprocess_node_group(&$vars) {
  // Get the current logged-in member:
  $logged_in_member = Member::loggedInMember();
  $vars['logged_in_member'] = $logged_in_member;

  // Get the node:
  $node = $vars['node'];

  // Get the group:
  $group = Group::create($node);
  $vars['group'] = $group;

  // Get the group's channel:
  $channel = $group->channel();
  $vars['channel'] = $channel;

  // Get the group description:
  $vars['description'] = $group->description();

  // Get the group tag:
  $vars['group_tag'] = $group->tag(NULL, TRUE);
}
