<?php

function astro_alpha_preprocess_node(&$vars) {
  global $user;

  if ($vars['node']->type == 'item') {
    // Theme the user picture:
    $vars['picture'] = moonmars_members_avatar_tooltip($vars['uid']);

    // Format the post datetime:
    $vars['created_datetime'] = astro_created_datetime($vars['node']->created);

    // Format the avatar tooltip for the current user:
    $vars['new_comment_picture'] = moonmars_members_avatar_tooltip($user->uid);

    // Format the username of the current user:
    $new_comment_username = $user->name;
    $vars['new_comment_username'] = "<a class='username' href='/users/$new_comment_username' title='Visit $new_comment_username&apos;s profile.'>$new_comment_username</a>";

    // Format the post datetime:
    $vars['new_comment_created_datetime'] = "<time>now</time>";

    // Calculate the score for the item:
    $vars['score'] = mt_rand(-20, 9999);
  }
  elseif ($vars['node']->type == 'group') {
    // Theme the user picture:
    $vars['new_item_picture'] = moonmars_members_avatar_tooltip($user->uid);

    // Format the username of the current user:
    $new_item_username = $user->name;
    $vars['new_item_username'] = "<a class='username' href='/users/$new_item_username' title='Visit $new_item_username&apos;s profile.'>$new_item_username</a>";

    // Format the post datetime:
    $vars['new_item_created_datetime'] = "<time>now</time>";
  }
}
