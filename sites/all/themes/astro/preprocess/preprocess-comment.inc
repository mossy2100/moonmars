<?php

// Make sure we have the comments JS:
drupal_add_js(drupal_get_path('theme', 'astro') . '/js/comments.js');

// Theme the user picture:
$vars['picture'] = moonmars_members_avatar_tooltip($vars['elements']['#comment']->uid);

// Format the username as a link:
$username = $vars['elements']['#comment']->name;
$vars['username'] = "<a class='username' href='/users/$username' title='Visit $username&apos;s profile.'>$username</a>";

// Format the comment datetime:
//$created_datetime = new XDateTime($vars['created']);
//// We should ensure that this is formatted using the user's timezone; or, we can just do a facebook and say roughly how long ago it was posted.
//// I would prefer to show at least the date.
//$vars['created_datetime'] = "<time datetime='{$vars['datetime']}'>" . $created_datetime->format('Y-m-d H:i:s') . "</time>";


$vars['created_datetime'] = astro_created_datetime($vars['created']);
//$created_datetime = new XDateTime($vars['created']);
//$vars['created_datetime'] = "<time datetime='" . $created_datetime->format('Y-m-d\TH:i:sZ') . "'>" .
//  $created_datetime->format('Y-m-d\TH:i:s\Z') . ' - ' . 'about ' . $created_datetime->aboutHowLongAgo() . ' ago' . "</time>";


$vars['score'] = mt_rand(-20, 9999);

//dbg($vars['content']['links']);

if (!user_is_logged_in()) {
  $login_to_comment = &$vars['content']['links']['comment']['#links']['comment_forbidden']['title'];
  $login_to_comment = str_replace('post comments', 'post or rate comments', $login_to_comment);
}
