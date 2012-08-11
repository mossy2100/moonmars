<?php

/**
 * Preprocess function for item nodes.
 *
 * @param $vars
 */
function astro_alpha_preprocess_node_item(&$vars) {

  drupal_add_js(drupal_get_path('module', 'moonmars_channels') . '/js/moonmars-channels.js');

  // Get the current logged-in member:
  $current_member = Member::currentMember();
  $vars['current_member'] = $current_member;

  // Get the node:
  $node = $vars['node'];

  // Create the Item object:
  $item = Item::create($node);
  $vars['item'] = $item;
  $item_nid = $item->nid();

  // If we're on an item node page, tell the client:
  $item_node_page = (arg(0) == 'node') && (arg(1) == $item_nid);
  if ($item_node_page) {
    drupal_add_js(array('astro' => array('item_node_page' => TRUE)), 'setting');
    $current_channel = NULL;
  }
  else {
    $current_channel = Channel::currentChannel();
    $vars['parent_entity'] = $current_channel->parentEntity();
  }
  $vars['item_node_page'] = $item_node_page;

  // Get the original poster:
  $poster = Member::create($vars['uid']);
  $vars['poster'] = $poster;

  // Get the poster's avatar:
  $vars['avatar'] = $poster->avatarTooltip();

  // Get the item's channel:
  $item_channel = $item->channel();
  $vars['channel'] = $item_channel;

  // Original channel string:
  if ($current_channel && Channel::equals($current_channel, $item_channel)) {
    $vars['item_channel_string'] = '';
//    $vars['item_channel_string'] = 'in this channel';
  }
  elseif ($current_channel && Channel::equals($item_channel, $poster->channel())) {
    $vars['item_channel_string'] = 'in their channel';
  }
  elseif ($item_channel) {
    $vars['item_channel_string'] = 'in ' . l($item_channel->title(), $item_channel->parentEntity()->alias());
  }
  $vars['item_channel_string'] = "<span class='item_channel'>{$vars['item_channel_string']}</span>";

  // Format the post datetime:
  $vars['created_datetime'] = astro_format_about_how_long_ago($node->created);

// Calculate the score for the item:
//      $vars['score'] = mt_rand(-20, 9999);

  // Remove unpublished comments. Count published comments.
  $n_comments = 0;
  if (isset($vars['content']['comments']['comments'])) {
    foreach ($vars['content']['comments']['comments'] as $key => $value) {
      if (is_numeric($key)) {
        if ($value['#comment']->status) {
          $n_comments++;
        }
        else {
          unset($vars['content']['comments']['comments'][$key]);
        }
      }
    }
  }

  // Render comments:
  $vars['comments'] = render($vars['content']['comments']);

  // Make sure we still have a comment wrapper even if there are no comments, so our JS works:
  if ($vars['comments'] == '') {
    $vars['comments'] = "<div id='comments' class='comment-wrapper'></div>";
  }

  // Add links in comment text to URLs, member references and hash tags:
  if (isset($vars['content']['field_item_text'])) {
    $vars['content']['field_item_text'][0]['#markup'] = moonmars_text_filter($vars['content']['field_item_text'][0]['#markup'], FALSE);
  }

  // Links for comment/edit/remove/delete item:
  $links1 = '';
  $links2 = '';

  if ($current_member) {
    // These links are in right-to-left order because they're floated right:

    // delete link:
    if ($current_member->canDeleteItem($item)) {
      $links1 .= "<li class='item-delete'><a href='javascript:deleteItem($item_nid)'>delete</a></li>";
    }

//    // remove link:
//    if ($current_channel && $current_member->canRemoveItem($item, $current_channel)) {
//      $links1 .= "<li class='item-remove'><a href='javascript:removeItem($item_nid)'>remove</a></li>";
//    }

    // edit link:
    if ($current_member->canEditItem($item)) {
      $links1 .= "<li class='item-edit'><a href='javascript:editItem($item_nid)'>edit</a></li>";
    }

//    // view link:
//    if (!$item_node_page) {
//      $links1 .= "<li class='item-view'><a href='/" . $item->alias() . "'>view</a></li>";
//    }

    // comment link - show at top and bottom:
    if ($current_member->canPostComment($item)) {
      $links1 .= "<li class='item-comment item-comment-$item_nid'><a href='javascript:showNewCommentForm($item_nid, true)'>comment</a></li>";

      // Only show the bottom comment link if there are some comments. Otherwise they can use the top one.
      if ($n_comments) {
        $links2 .= "<li class='item-comment item-comment-$item_nid'><a href='javascript:showNewCommentForm($item_nid, false)'>comment</a></li>";
      }
    }

    $links1 = "
      <ul class='action-links item-links clearfix'>
        $links1
      </ul>
    ";

    $links2 = $links2 ? "
      <div class='post-controls bottom-post-controls-$item_nid'>
        <ul class='action-links item-links clearfix'>
          $links2
        </ul>
      </div>" : '';
  }

  $vars['links1'] = $links1;
  $vars['links2'] = $links2;

}
