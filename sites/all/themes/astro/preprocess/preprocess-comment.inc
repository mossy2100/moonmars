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
//  if (strpos($item_comment->text(), 'This '))
//  dbg($vars['content']['comment_body'][0]['#markup']);
//  dbg($item_comment->text());


//  exit;

//  $comment_text = html_entity_decode($vars['content']['comment_body'][0]['#markup']);
//  $vars['content']['comment_body'][0]['#markup'] = moonmars_text_filter($comment_text, TRUE);
  $vars['content']['comment_body'][0]['#markup'] = $item_comment->textScan()->html();

  // Get the current member:
  $logged_in_member = Member::loggedInMember();

  // Remove the default links:
  unset($vars['content']['links']);

  // Generate links for editing and deleting comment:
  $links = '';
  if (user_is_logged_in()) {
    // delete link:
    if ($logged_in_member->canDeleteComment($item_comment)) {
      $links .= "<li class='comment-delete'><a href='javascript:deleteComment($cid)'>delete</a></li>";
    }

    // edit link:
    if ($logged_in_member->canEditComment($item_comment)) {
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
  if ($logged_in_member && $logged_in_member->canEditComment($item_comment)) {
//    dbg($vars['content']['comment_body'][0]['#markup']);
    $vars['edit_comment_form'] = "
      <form class='comment-form edit-comment-form'>
        <textarea id='edit-comment-$cid'>" . html_entity_decode($item_comment->text(), ENT_QUOTES) . "</textarea>
        <div class='comment-buttons'>
          <input data-nid='$nid' class='form-button cancel-comment-button' type='button' value='Cancel'>
          <input data-nid='$nid' class='form-button update-comment-button' type='button' value='Update'>
        </div>
      </form>
    ";
  }

  // Use highlight style?
  $vars['highlight'] = isset($_GET['cid']) && $item_comment->cid() == $_GET['cid'];

  // Score:
  $vars['score'] = (int) $item_comment->field('field_score');

  // Ratings:
  // To rate an item, the member must be logged in, and it must have been created by someone else.
  // @todo Update this to a Member::canRateComment() method.
  $can_rate = $logged_in_member && !Member::equals($logged_in_member, $poster);
  $vars['rating_buttons'] = $can_rate ? moonmars_ratings_buttons($logged_in_member, $item_comment) : '';

  // Path to theme:
  $vars['theme_path'] = drupal_get_path('theme', 'astro');
}
