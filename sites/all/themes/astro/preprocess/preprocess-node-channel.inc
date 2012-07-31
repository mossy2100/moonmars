<?php

/**
 * Preprocess function for channel nodes.
 *
 * @param $vars
 */
function astro_alpha_preprocess_node_channel(&$vars) {

  // Get the current logged-in member:
  $current_member = Member::currentMember();
  $vars['current_member'] = $current_member;

  // Get the node:
  $node = $vars['node'];

  // Get the channel object:
  $channel = Channel::create($node);
  $vars['channel'] = $channel;

  // Load the channel JS:
  drupal_add_js(drupal_get_path('module', 'moonmars_channels') . '/js/moonmars-channels.js');
  drupal_add_js(drupal_get_path('module', 'moonmars_text') . '/js/autotrim.js');

  // Remember the current channel:
  Channel::currentChannel($channel);

  // Get the channel items.

  // Set the page title:
  if (arg(0) == 'node' && arg(1) == $channel->nid()) {
    // Only display the channel title if we're on the channel's node page.
    // Regular users should never see this. Even admins don't really need to see channel node pages.
    $vars['title'] = $channel->title();
  }
  else {
    $vars['title'] = '';
  }

  // Get the parent entity:
  $entity = $channel->parentEntity();

  // Render the items.
  if ($entity instanceof Member && alias_arg(2) == 'activity') {
    // Member's activity channel:
    $vars['items'] = $entity->renderActivityItems();
  }
  else {
    $vars['items'] = $channel->renderItems();
  }
}
