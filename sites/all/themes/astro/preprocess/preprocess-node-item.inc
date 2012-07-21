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

  // Are we in email mode?
  $email_mode = isset($_SESSION['email_mode']) && $_SESSION['email_mode'];
  $vars['email_mode'] = $email_mode;

  // Create the Item object:
  $item = Item::create($node);
  $vars['item'] = $item;
  $item_nid = $item->nid();

  // If we're on an item node page, tell the client:
  $item_node_page = arg(0) == 'node' && arg(1) == $item_nid;
  if ($item_node_page) {
    drupal_add_js(array('astro' => array('item_node_page' => TRUE)), 'setting');
    $current_channel = NULL;
    $vars['return_link'] = Channel::currentChannel()->parentEntityLink();
  }
  else {
    $current_channel = Channel::currentChannel();
  }
  $vars['item_node_page'] = $item_node_page;

  // Get the original poster:
  $poster = Member::create($vars['uid']);
  $vars['poster'] = $poster;

  // Get the poster's avatar:
  $vars['avatar'] = $email_mode ? $poster->avatar() : $poster->avatarTooltip();

  // Get the item's original channel:
  $original_channel = $item->originalChannel();
  $vars['original_channel'] = $original_channel;

  // Original channel string:
  if ($current_channel && Channel::equals($current_channel, $original_channel)) {
    $vars['original_channel_string'] = 'in this channel';
  }
  elseif ($current_channel && Channel::equals($original_channel, $poster->channel())) {
    $vars['original_channel_string'] = 'in their channel';
  }
  elseif ($original_channel) {
    $vars['original_channel_string'] = 'in ' . l($original_channel->title(), $original_channel->parentEntity()->alias());
  }
  $vars['original_channel_string'] = "<span class='original_channel'>{$vars['original_channel_string']}</span>";

  // Format the post datetime:
  $vars['created_datetime'] = astro_format_about_how_long_ago($node->created);

// Calculate the score for the item:
//      $vars['score'] = mt_rand(-20, 9999);

// Remove unpublished comments. Why are they even there?
//      foreach ($vars['content']['comments']['comments'] as $key => $value) {
//        if (is_numeric($key) && !$value['#comment']->status) {
//          unset($vars['content']['comments']['comments'][$key]);
//        }
//      }

  // Render comments:
  $vars['comments'] = render($vars['content']['comments']);

  // Make sure we still have a comment wrapper even if there are no comments, so our JS works:
  if ($vars['comments'] == '') {
    $vars['comments'] = "<div id='comments' class='comment-wrapper'></div>";
  }

  // Add links in comment text to URLs, member references and hash tags:
  if (isset($vars['content']['field_item_text'])) {
    $vars['content']['field_item_text'][0]['#markup'] = moonmars_text_filter($vars['content']['field_item_text'][0]['#markup']);
  }

  // Links for edit/remove/delete item:
  $links = '';
  if (user_is_logged_in() && !$email_mode) {
    // These links are in right-to-left order because they're floated right:

    // delete link:
    if ($current_member->canDeleteItem($item)) {
      $links .= "<li class='item-delete'><a href='javascript:deleteItem($item_nid)'>delete</a></li>";
    }

    // remove link:
    if ($current_channel && $current_member->canRemoveItem($item, $current_channel)) {
      $links .= "<li class='item-remove'><a href='javascript:removeItem($item_nid)'>remove</a></li>";
    }

    // edit link:
    if ($current_member->canEditItem($item)) {
      $links .= "<li class='item-edit'><a href='javascript:editItem($item_nid)'>edit</a></li>";
    }

    // view link:
    if (!$item_node_page) {
      $links .= "<li class='item-view'><a href='/" . $item->alias() . "'>view</a></li>";
    }

    $links = "
          <ul class='action-links item-links clearfix'>
            $links
          </ul>
        ";
  }
  $vars['links'] = $links;

}
