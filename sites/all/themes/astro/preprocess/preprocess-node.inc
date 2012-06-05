<?php

function astro_alpha_preprocess_node(&$vars) {

  if ($vars['node']->type == 'item') {

    // Theme the user picture:
    $vars['picture'] = moonmars_members_avatar_tooltip($vars['uid']);

    // Format the post datetime:
    $vars['created_datetime'] = astro_created_datetime($vars['node']->created);

    $vars['score'] = mt_rand(-20, 9999);
  }
}
