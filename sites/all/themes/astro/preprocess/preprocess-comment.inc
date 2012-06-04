<?php

function astro_alpha_preprocess_comment(&$vars) {

  // Make sure we have the comments JS:
  drupal_add_js(drupal_get_path('theme', 'astro') . '/js/comments.js');

  // Theme the user picture:
  $vars['picture'] = moonmars_members_avatar_tooltip($vars['elements']['#comment']->uid);

  // Format the username as a link:
  $username = $vars['elements']['#comment']->name;
  $vars['username'] = "<a class='username' href='/users/$username' title='Visit $username&apos;s profile.'>$username</a>";

  // Format the comment created datetime:
  $vars['created_datetime'] = astro_created_datetime($vars['created']);

  // Make up a random score for now:
  $vars['score'] = mt_rand(-20, 9999);

  // Remove the "reply" link.
  unset($vars['content']['links']['comment']['#links']['comment-reply']);
  //if (!$x) {
  //  dbg($vars['content']['links']);
  //  $x = 1;
  //}

  if (!user_is_logged_in()) {
    $login_to_comment = &$vars['content']['links']['comment']['#links']['comment_forbidden']['title'];
    $login_to_comment = str_replace('post comments', 'post or rate comments', $login_to_comment);
  }
}
