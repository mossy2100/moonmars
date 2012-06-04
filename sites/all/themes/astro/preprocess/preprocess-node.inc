<?php

if ($vars['node']->type == 'post') {

  // Theme the user picture:
  $vars['picture'] = moonmars_user_avatar_tooltip($vars['elements']['#comment']->uid);

  // Format the post datetime:
  $comment_datetime = new XDateTime($vars['created']);

  // We should ensure that this is formatted using the user's timezone; or, we can just do a facebook and say roughly how long ago it was posted.
  // I would prefer to show at least the date.
  $vars['comment_datetime'] = "<time datetime='{$vars['datetime']}'>" . $comment_datetime->format('Y-m-d H:i:s') . "</time>";


}