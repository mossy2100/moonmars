<?php

function astro_alpha_preprocess_node(&$vars) {

  // Get the current logged-in member:
  $current_member = Member::currentMember();
  $vars['current_member'] = $current_member;

  switch ($vars['node']->type) {

    case 'item':
      // Create the Item object:
      $item = Item::create($vars['node']);
      $vars['item'] = $item;

      // Get the original poster:
      $poster = Member::create($vars['uid']);
      $vars['poster'] = $poster;

      // Get the current channel:
      $current_channel = Channel::currentChannel();

      // Get the item's original channel:
      $original_channel = $item->originalChannel();

      // Original channel string:
      if (Channel::equals($current_channel, $original_channel)) {
        $vars['original_channel'] = 'in this channel';
      }
      elseif (Channel::equals($original_channel, $poster->channel())) {
        $vars['original_channel'] = 'in their channel';
      }
      else {
        $vars['original_channel'] = 'in ' . l($original_channel->title(), $original_channel->parentEntity()->alias());
      }
      $vars['original_channel'] = "<span class='original_channel'>{$vars['original_channel']}</span>";

      // Format the post datetime:
      $vars['created_datetime'] = astro_format_about_how_long_ago($vars['node']->created);

      // Calculate the score for the item:
//      $vars['score'] = mt_rand(-20, 9999);

      // Render the comments for the item:
      $vars['comments'] = render($vars['content']['comments']);
      // Make sure we still have a comment wrapper even if there are no comments, so our JS works:
      if ($vars['comments'] == '') {
        $vars['comments'] = "<div id='comments' class='comment-wrapper'></div>";
      }

      // Add links in comment text to URLs, member references and hash tags:
      $vars['content']['field_item_text'][0]['#markup'] = moonmars_text_filter($vars['content']['field_item_text'][0]['#markup']);

      // Links for edit/remove/delete item:
      $links = '';
      if ($current_member->canDeleteItem($item)) {
        $links .= "<li class='item-delete'>delete</li>";
      }
      if ($current_member->canRemoveItem($item, $current_channel)) {
        $links .= "<li class='item-remove'>remove</li>";
      }
      if ($current_member->canEditItem($item)) {
        $links .= "<li class='item-edit'>edit</li>";
      }
      if ($links) {
        $links = "
          <ul class='action-links item-links clearfix'>
            $links
          </ul>
        ";
      }
      $vars['links'] = $links;

      break;

    case 'group':
      // Get the group:
      $group = Group::create($vars['node']);
      $vars['group'] = $group;

      // Get the group's channel:
      $channel = $group->channel();
      $vars['channel'] = $channel;

      break;

    case 'channel':
      drupal_add_js(drupal_get_path('module', 'moonmars_channels') . '/js/moonmars-channels.js');

      // Get the channel object:
      $channel = Channel::create($vars['node']);
      $vars['channel'] = $channel;

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

      break;
  }

}
