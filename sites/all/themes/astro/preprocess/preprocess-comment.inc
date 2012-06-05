<?php

function astro_alpha_preprocess_comment(&$vars) {

  // Make sure we have the comments JS:
  drupal_add_js(drupal_get_path('module', 'moonmars_comments') . '/js/moonmars_comments.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.autogrow-textarea.js');

  // Theme the user picture:
  $vars['picture'] = moonmars_members_avatar_tooltip($vars['elements']['#comment']->uid);

  // Format the username as a link:
  $username = $vars['elements']['#comment']->name;
  $vars['username'] = "<a class='username' href='/users/$username' title='Visit $username&apos;s profile.'>$username</a>";

  // Format the comment created datetime:
  $vars['created_datetime'] = astro_created_datetime($vars['elements']['#comment']->created);

  // If no score is set, make up a random one for now:
  $vars['score'] = isset($vars['elements']['#comment']->field_score[LANGUAGE_NONE][0]['value']) ? $vars['elements']['#comment']->field_score[LANGUAGE_NONE][0]['value'] : 0;
  if (!$vars['score']) {
    $vars['score'] = mt_rand(-20, 9999);
  }

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


  if (!$x) {
    dbg($vars['links']);
    $x = 1;
  }
}
