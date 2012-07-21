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

//      dbg(arg());
//      // If we're on a channel node page, bounce the user to the parent entity's page:
//      if (arg(0) == 'node' && arg(1) == $channel->nid()) {
//        $parent_entity = $channel->parentEntity();
//        drupal_goto($parent_entity->alias());
//      }

  drupal_add_js(drupal_get_path('module', 'moonmars_channels') . '/js/moonmars-channels.js');

  // Remember the current channel:
  Channel::currentChannel($channel);

  // Get the channel items.
  // By default include all items in the channel:
  $include_copied_items = TRUE;

//      if (arg(0) == 'user') {
//         If the member is viewing their own profile, include stuff they're following (unless they have the 'Show only my stuff' filter on).
//        $viewing_own_profile = $user->uid == arg(1);
//        $filter_on = $viewing_own_profile && (isset($_SESSION['user']['profile_filter']) ? $_SESSION['user']['profile_filter'] : FALSE);
//        $include_copied_items = $viewing_own_profile && !$filter_on;
//      }

  // Set the page title:
  if (arg(0) == 'node' && arg(1) == $channel->nid()) {
    // Only display the channel title if we're on the channel's node page.
    // Regular users should never see this. Even admins don't really need to see channel node pages.
    $vars['title'] = $channel->title();
  }
  else {
    $vars['title'] = '';
  }

  // Render the items:
  $vars['items'] = $channel->renderItems($include_copied_items);

}
