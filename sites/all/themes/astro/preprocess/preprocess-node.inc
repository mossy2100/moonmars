<?php

function astro_alpha_preprocess_node(&$vars) {
  global $user;

  if ($vars['node']->type == 'item') {
    // Theme the user picture:
    $vars['picture'] = moonmars_members_get_avatar_tooltip($vars['uid']);

    // Format the post datetime:
    $vars['created_datetime'] = astro_created_datetime($vars['node']->created);

    // Format the avatar tooltip for the current user:
    $vars['new_comment_picture'] = moonmars_members_get_avatar_tooltip($user->uid);

    // Format the username of the current user:
    $new_comment_username = ($user && $user->uid) ? $user->name : '';
    $vars['new_comment_username'] = "<a class='username' href='/users/$new_comment_username' title='Visit $new_comment_username&apos;s profile.'>$new_comment_username</a>";

    // Format the post datetime:
    $vars['new_comment_created_datetime'] = "<time>now</time>";

    // Calculate the score for the item:
    $vars['score'] = mt_rand(-20, 9999);

    // If this is a group page, get the group:
    if (moonmars_groups_is_group_page()) {
      $vars['group'] = moonmars_groups_get_current_group();
    }
  }
  elseif ($vars['node']->type == 'group') {
    // Theme the user picture:
    $vars['new_item_picture'] = moonmars_members_get_avatar_tooltip($user->uid);

    // Format the username of the current user:
    if ($user) {
      $new_item_username = $user->name;
      $vars['new_item_username'] = "<a class='username' href='/users/$new_item_username' title='Visit $new_item_username&apos;s profile.'>$new_item_username</a>";
    }

    // Format the post datetime:
    $vars['new_item_created_datetime'] = "<time>now</time>";

    $vars['head_title'] = "moonmars.com - Group - " . $vars['node']->title;
  }

}
