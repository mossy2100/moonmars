<?php

function astro_alpha_preprocess_node(&$vars) {
  global $user;

  switch ($vars['node']->type) {

    case 'item':
      // Theme the user picture of the member who originally posted the item:
      $original_poster = Member::create($vars['uid']);
      $vars['picture'] = $original_poster->avatarTooltip();

      // Add the channel title if set:
      if ($vars['node']->copied) {
        $channel = Channel::create($vars['node']->original_channel->nid());
        $entity = $channel->parentEntity();
        $vars['channel_posted'] = 'in ' . l($vars['node']->original_channel->title(), $entity['alias']);
      }
      else {
        $vars['channel_posted'] = '';
      }

      // Format the post datetime:
      $vars['created_datetime'] = astro_format_about_how_long_ago($vars['node']->created);

      // Format the avatar tooltip for the current user:
      $current_member = Member::create($user->uid);
      $vars['new_comment_picture'] = $current_member->avatarTooltip();

      // Format the username of the current user:
      $new_comment_username = ($user && $user->uid) ? $user->name : '';
      $vars['new_comment_username'] = "<a class='username' href='/users/$new_comment_username' title='Visit $new_comment_username&apos;s profile.'>$new_comment_username</a>";

      // Format the post datetime:
//      $vars['new_comment_created_datetime'] = "<time>now</time>";

      // Calculate the score for the item:
      $vars['score'] = mt_rand(-20, 9999);

      // If this is a group page, get the group:
      if (moonmars_groups_is_group_page()) {
        $vars['group'] = moonmars_groups_get_current_group();
      }

      // Render the comments for the item:
      $vars['comments'] = render($vars['content']['comments']);
      // Make sure we still have a comment wrapper even if there are no comments:
      if ($vars['comments'] == '') {
        $vars['comments'] = "<div id='comments' class='comment-wrapper'></div>";
      }

      // Add links to member references and hash tags:
      $vars['content']['field_item_text'][0]['#markup'] = moonmars_text_filter($vars['content']['field_item_text'][0]['#markup']);

      break;

    case 'group':
//      $vars['head_title'] = "moonmars.com - Group - " . $vars['node']->title;
//      drupal_set_title("moonmars.com - Group - " . $vars['node']->title);
      break;

    case 'channel':
      drupal_add_js(drupal_get_path('module', 'moonmars_channels') . '/js/moonmars-channels.js');

      // Theme the user picture:
      $vars['current_member'] = Member::create($user->uid);
      $vars['new_item_picture'] = $vars['current_member']->avatarTooltip();

      // Format the username of the current user:
      if ($user) {
        $new_item_username = $user->name;
        $vars['new_item_username'] = "<a class='username' href='/users/$new_item_username' title='Visit $new_item_username&apos;s profile.'>$new_item_username</a>";
      }

      // Format the post datetime:
      $vars['new_item_created_datetime'] = "<time>now</time>";

      if (arg(0) == 'user') {
        // Hide the channel title if we're looking at a user profile:
        $vars['title'] = '';
        // If the member is viewing their own profile, include stuff they're following (unless they have the 'Show only my stuff' filter on).
        $viewing_own_profile = $user->uid == arg(1);
        $filter_on = $viewing_own_profile && (isset($_SESSION['user']['profile_filter']) ? $_SESSION['user']['profile_filter'] : FALSE);
        $include_copied_items = $viewing_own_profile && !$filter_on;
      }
      elseif (arg(0) == 'node' && is_uint(arg(1))) {
        $entity = node_load(arg(1));
        // Hide the channel title if we aren't looking at a channel node page:
        if ($entity->type != 'channel') {
          $vars['title'] = '';
        }
        $include_copied_items = TRUE;
      }

      // Get the channel object:
      $vars['channel'] = Channel::create($vars['node']->nid);

      // Render the items:
      $vars['items'] = $vars['channel']->render($include_copied_items);

      // Remember the current channel:
      Channel::currentChannel($vars['node']->nid);

      break;
  }

  // Get the channel if applicable:
  if (in_array($vars['node']->type, moonmars_channels_node_types())) {
    $vars['channel'] = Channel::entityChannel('node', $vars['node']->nid);
  }

}
