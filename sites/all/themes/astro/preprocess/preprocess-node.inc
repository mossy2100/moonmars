<?php

function astro_alpha_preprocess_node(&$vars) {

  if ($vars['node']->type == 'item') {

    // Theme the user picture:
    $vars['picture'] = moonmars_members_avatar_tooltip($vars['uid']);

    // Format the post datetime:
    $vars['created_datetime'] = astro_created_datetime($vars['created']);

    $vars['score'] = mt_rand(-20, 9999);

    $nid = $vars['node']->nid;

    // Item links:
  //  if (user_is_logged_in()) {
  //    global $user;
  //
  //    $vars['item_links'] = "
  //      <ul class='links inline'>
  //        <li class='item-comment'><a href='javascript:itemComment($nid)' class='af-button-small'><span>comment</span></a></li>\n";

          // Leave this feature out for now (the ability to subscribe/unsubscribe to specific items)
  //    if (moonmars_items_member_subscribed($user->uid)) {
  //      $vars['item_links'] .= "<li class='item-subscribe'><a href='javascript:itemSubscribe($nid)' class='af-button-small'><span>subscribe</span></a></li>\n";
  //    }
  //    else {
  //      $vars['item_links'] .= "<li class='item-unsubscribe'><a href='javascript:itemUnsubscribe($nid)' class='af-button-small'><span>unsubscribe</span></a></li>\n";
  //    }

  //    $vars['item_links'] .= "</ul>\n";
  //  }

  }
}
