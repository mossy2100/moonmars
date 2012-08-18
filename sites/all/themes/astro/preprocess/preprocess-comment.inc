<?php

function astro_alpha_preprocess_comment(&$vars) {

  // Get the ItemComment object:
  $item_comment = ItemComment::create($vars['elements']['#comment']);
  $vars['item_comment'] = $item_comment;

  // Theme the user picture:
  $poster = $item_comment->creator();
  $vars['poster'] = $poster;
  $vars['picture'] = $poster->avatarTooltip();

  // Format the comment created datetime:
  $vars['created_datetime'] = astro_format_about_how_long_ago($vars['elements']['#comment']->created);

  // Get the poster's avatar:
  $vars['avatar'] = $poster->avatarTooltip();

  if (!user_is_logged_in()) {
    $login_to_comment = &$vars['content']['links']['comment']['#links']['comment_forbidden']['title'];
    $login_to_comment = str_replace('post comments', 'post or rate comments', $login_to_comment);
  }

  // Set some attributes that we can use with JS:
  $cid = $item_comment->cid();
  $nid = $item_comment->nid();

  $vars['attributes_array']['data-cid'] = $cid;
  $vars['attributes_array']['data-nid'] = $nid;
  $vars['attributes_array']['id'] = "comment-article-$cid";

  // Add links for urls, mentions and tags to the comment text:
  $comment_text = $vars['content']['comment_body'][0]['#markup'];
  $vars['content']['comment_body'][0]['#markup'] = moonmars_text_filter($comment_text, TRUE);

  // Get the current member:
  $current_member = Member::currentMember();

  // Remove the default links:
  unset($vars['content']['links']);

  // Generate links for editing and deleting comment:
  $links = '';
  if (user_is_logged_in()) {
    // delete link:
    if ($current_member->canDeleteComment($item_comment)) {
      $links .= "<li class='comment-delete'><a href='javascript:deleteComment($cid)'>delete</a></li>";
    }

    // edit link:
    if ($current_member->canEditComment($item_comment)) {
      $links .= "<li class='comment-edit'><a href='javascript:editComment($cid)'>edit</a></li>";
    }

    // If we have some links create a list element:
    if ($links) {
      $links = "
        <ul class='action-links clearfix'>
          $links
        </ul>
      ";
    }
  }
  $vars['links'] = $links;

  // Add a form for editing the comment if the user is allowed to edit it:
  if ($current_member && $current_member->canEditComment($item_comment)) {
//    dbg($vars['content']['comment_body'][0]['#markup']);
    $vars['edit_comment_form'] = "
      <form class='comment-form edit-comment-form'>
        <textarea id='edit-comment-$cid'>$comment_text</textarea>
        <div class='comment-buttons'>
          <input data-nid='$nid' class='form-button cancel-comment-button' type='button' value='Cancel'>
          <input data-nid='$nid' class='form-button update-comment-button' type='button' value='Update'>
        </div>
      </form>
    ";
  }

  // Highlight class:
  $vars['highlight'] = (isset($_GET['cid']) && $item_comment->cid() == $_GET['cid']) ? 'highlight' : '';

  // Score:
  $vars['score'] = (int) $item_comment->field('field_score');

  // Ratings:
  // To rate an item, the member must be logged in, and it must have been created by someone else.
  $can_rate = $current_member && !Member::equals($current_member, $poster);
  $vars['rating_buttons'] = $can_rate ? moonmars_ratings_buttons($current_member, 'comment', $cid) : '';
}
