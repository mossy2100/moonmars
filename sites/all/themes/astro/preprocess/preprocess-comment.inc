<?php

function astro_alpha_preprocess_comment(&$vars) {

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

  // Remove the "reply" link. For now, people can only comment on the node, not on other comments.
  unset($vars['content']['links']['comment']['#links']['comment-reply']);

  if (!user_is_logged_in()) {
    $login_to_comment = &$vars['content']['links']['comment']['#links']['comment_forbidden']['title'];
    $login_to_comment = str_replace('post comments', 'post or rate comments', $login_to_comment);
  }

  // Set some attributes that we can use with JS:
  $cid = $vars['elements']['#comment']->cid;
  $nid = $vars['elements']['#node']->nid;

  $vars['attributes_array']['data-cid'] = $cid;
  $vars['attributes_array']['data-nid'] = $nid;
  $vars['attributes_array']['id'] = "comment-article-$cid";

  // If we have an edit link, add a form for editing the comment.
  if (isset($vars['content']['links']['comment']['#links']['comment-edit'])) {
//    dbg($vars['content']['comment_body'][0]['#markup']);
    $vars['edit_comment_form'] = "
      <form class='comment-form edit-comment-form'>
        <textarea id='edit-comment-$cid'>{$vars['content']['comment_body'][0]['#markup']}</textarea>
        <div class='new-comment-controls'>
          <input data-nid='$nid' class='new-comment-button' type='button' value='Update'>
        </div>
      </form>
    ";
  }


}
