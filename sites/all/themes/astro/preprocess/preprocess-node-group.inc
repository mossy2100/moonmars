<?php

/**
 * Preprocess function for group nodes.
 *
 * @param $vars
 */
function astro_alpha_preprocess_node_group(&$vars) {

  // Get the current logged-in member:
  $current_member = Member::currentMember();
  $vars['current_member'] = $current_member;

  // Get the node:
  $node = $vars['node'];

  // Get the group:
  $group = Group::create($node);
  $vars['group'] = $group;

  // Get the group's channel:
  $channel = $group->channel();
  $vars['channel'] = $channel;

  // Get the group description:
  $vars['description'] = isset($node->field_description[LANGUAGE_NONE][0]['value']) ? $node->field_description[LANGUAGE_NONE][0]['value'] : '';
}
