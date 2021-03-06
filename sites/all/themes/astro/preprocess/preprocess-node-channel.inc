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

  // Remember the current channel in the session:
  Channel::currentChannel($channel);

  // Get the star:
  $star = $channel->star();

  // If we're at the channel's page, goto the star's page.
  $star_path = $star->alias();
  if (request_path() != $star_path) {
    drupal_goto($star_path);
  }

  // JS:
  drupal_add_js(drupal_get_path('module', 'moonmars_channels') . '/js/moonmars-channels.js');
  drupal_add_js(drupal_get_path('module', 'moonmars_ratings') . '/js/ratings.js');
  drupal_add_js(drupal_get_path('module', 'moonmars_text') . '/js/autotrim.js');

  // Don't display the channel title:
  $vars['title'] = '';

  // Render the items.
  $vars['items'] = $channel->renderItems();

  // Get the logged-in member:
  $vars['logged_in_member'] = Member::loggedInMember();
}
