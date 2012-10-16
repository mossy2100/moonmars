<?php

use \AstroMultimedia\MoonMars\Member;
use \AstroMultimedia\MoonMars\Channel;

/**
 * Preprocess function for channel nodes.
 *
 * @param $vars
 */
function astro_alpha_preprocess_node_channel(&$vars) {
  // Get the node:
  $node = $vars['node'];

  // Get the channel object:
  $channel = Channel::create($node);
  $vars['channel'] = $channel;

  // Get the parent entity:
  $parent_entity = $channel->parentEntity();

  // If we're at the channel's page, goto the parent entity's page.
  $parent_entity_path = $parent_entity->alias();
  if (request_path() != $parent_entity_path) {
    drupal_goto($parent_entity_path);
  }

  // JS:
  drupal_add_js(drupal_get_path('module', 'moonmars_channels') . '/js/moonmars-channels.js');
  drupal_add_js(drupal_get_path('module', 'moonmars_ratings') . '/js/ratings.js');
  drupal_add_js(drupal_get_path('module', 'moonmars_text') . '/js/autotrim.js');

  // Remember the current channel:
  Channel::currentChannel($channel);

  // Set the page title:
  if (arg(0) == 'node' && arg(1) == $channel->nid()) {
    // Only display the channel title if we're on the channel's node page.
    // Regular users should never see this. Even admins don't really need to see channel node pages.
    $vars['title'] = $channel->title();
  }
  else {
    $vars['title'] = '';
  }

  // Are we viewing the member's activity stream?
  $viewing_activity = ($parent_entity instanceof Member) && (request_arg(2) == 'activity');
  $vars['viewing_activity'] = $viewing_activity;

  // Render the items.
  if ($viewing_activity) {
    // Member's activity channel:
    $vars['items'] = $parent_entity->renderActivityItems();
  }
  else {
    $vars['items'] = $channel->renderItems();
  }

  // Get the logged-in member:
  $vars['logged_in_member'] = Member::loggedInMember();
}
