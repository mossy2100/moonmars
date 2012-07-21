var $ = jQuery;

var collapsedContentHeight = 96;
var item_node_page;

$(initChannel);

/**
 * Set up behaviours of links, buttons and avatars.
 */
function initChannel() {
  // Convert select elements into selectBoxes:
//  $('select').selectBox();

  // Check if we're on an item's node page:
  item_node_page = Drupal.settings.astro && Drupal.settings.astro.item_node_page;

  // Setup item behaviours:
  $('article.node-item').each(function () {
    setupItemBehaviour(this);
  });

  // Setup new item form behaviour:
  $('#item-node-form #edit-submit').click(function() {
    // Disable the post button:
    $(this).disable();

    // Show the uploading graphic:
    $(this).closest('form').find('#edit-field-item-text textarea').addClass('uploading');
  });

  // Setup comment behaviours:
  $('#comments article').each(function () {
    setupCommentBehaviour(this);
  });

  // Setup new comment form behaviour:
  $('article.new-comment-form-article').each(function () {
    setupPostButton(this);
  });

  // Tidy up and setup behaviours for the new item form:
  itemTypeSelected();
  $('#edit-field-item-type-und input:radio').click(itemTypeSelected);
  $('#edit-path').remove();
//  $('#field-item-text-add-more-wrapper textarea').autoresize();
  $('#item-node-form span.form-required').remove();

  // Setup client-side validation for Post button:
  $('#item-node-form #edit-submit--3').click(function () {
    var itemText = $('#edit-field-item-text-und-0-value').val();
    if (!itemText) {
      alert('Please enter a description.');
      return false;
    }
  });

  // Hack - remove pagers from beneath comments in channels:
  $('article.node-item #comments .item-list').remove();

  // Setup rating button behaviours:
  setupRatings();
}

/**
 * Set the initial collapse state for items and comments, and behaviour of the "Read more" link.
 *
 * @param object postArticle
 * @param bool autoCollapse
 */
function collapsePost(postArticle, autoCollapse) {
  // Set default value for autoCollapse:
  if (autoCollapse === undefined) {
    autoCollapse = true;
  }

  // Add autogrow for textareas. This needs to be done before hiding anything, otherwise the sizing doesn't work right:
//  postArticle.find('textarea').eq(0).autoresize();

  // Have to hide the textarea after calling autoresize.
  postArticle.find('.edit-comment-form').eq(0).hide();

  // Determine what to hide:
  var postContent = postArticle.find('.post-content').eq(0);
  var postContentHeight = postContent.height();

  var postControls = postArticle.find('.post-controls').eq(0);
  var scoreMoreWrapper = postArticle.find('.score-more-wrapper').eq(0);

//  if (postContentHeight <= collapsedContentHeight || !autoCollapse) {
    // Hide the "Read more" link:
    scoreMoreWrapper.hide();
    // Show the links and rating buttons;
    postControls.show();
//  }
//  else {
//    // Collapse the post:
//    var postContentWrapper = postArticle.find('.post-content-wrapper').eq(0);
//    postContentWrapper.height(collapsedContentHeight);
//    // Hide the "Read more" link:
//    scoreMoreWrapper.show();
//    // Show the links and rating buttons:
//    postControls.hide();
//  }

  // Setup handler for "Read more" link:
  var moreLink = scoreMoreWrapper.find('a').eq(0);
  moreLink.click(function () {
    // Expand the post:
    postContentWrapper.css('height', 'auto');
    // Hide the "Read more" link:
    scoreMoreWrapper.hide();
    // Show the links and rating buttons:
    postControls.show();
  });

}

/**
 * Remove an item or comment with animation.
 *
 * @param selector
 */
function removePost(post) {
  post.animate({
    opacity: 0,
    height: 0,
    marginTop: 0,
    marginBottom: 0,
    paddingTop: 0,
    paddingBottom: 0
  }, 500, function() {
    $(this).remove();
  });
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Item behaviours.

/**
 * Setup behaviour for items.
 *
 * @param object itemArticle
 * @param bool autoCollapse
 */
function setupItemBehaviour(itemArticle, autoCollapse) {
  itemArticle = $(itemArticle);

//  // Setup behaviour for edit link:
//  itemArticle.find('.links li.item-edit a').click(
//    function () {
//      var itemArticle = $(this).closest('article');
//      // Hide the item text and controls:
//      itemArticle.find('.field-name-field-item-text').hide();
//      itemArticle.find('.post-controls').hide();
//      // Show the edit item form:
//      itemArticle.find('.edit-item-form').show();
//      itemArticle.find('.post-content-wrapper').css('height', 'auto');
//      return false;
//    }
//  );

//  // Setup behaviour for update button:
//  itemArticle.find('.update-item-button').click(
//    function () {
//      var itemTextarea = itemArticle.find('textarea');
//      var itemText = itemTextarea.val();
//      if (itemText == '') {
//        alert("Please enter some text before clicking Update.");
//      }
//      else {
//        itemTextarea.attr('disabled', 'disabled').addClass('uploading');
//        var item_nid = itemArticle.attr('data-nid');
//        $.post("/ajax/item/edit",
//          {
//            item_nid: item_nid,
//            text: itemText
//          },
//          editItemReturn,
//          'json'
//        );
//      }
//    }
//  );

//  // Setup behaviour for cancel button:
//  itemArticle.find('.cancel-item-button').click(
//    function () {
//      var itemArticle = $(this).closest('article');
//      // Hide the edit item form:
//      itemArticle.find('.edit-item-form').hide();
//      // Show the item text and controls:
//      itemArticle.find('.field-name-field-item-text').show();
//      itemArticle.find('.post-controls').show();
//      return false;
//    }
//  );

//  collapsePost(itemArticle, autoCollapse);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Deleting items.

/**
 * Handler for the delete item link.
 *
 * @param item_nid
 * @return bool
 */
function deleteItem(item_nid) {
  var result = confirm('Are you sure you want to delete this item?\nThis action cannot be reversed.');
  if (result) {
    // Show the waiting icon:
    var itemArticle = $('#node-item-' + item_nid);
    itemArticle.find('.post-controls .item-delete').addClass('waiting');

    // Request the deletion:
    var query = {
      item_nid: item_nid
    };
    $.post("/ajax/item/delete", query, deleteItemReturn, 'json');
  }
  return false;
}

/**
 * Handler for when we get back from deleting a item via AJAX.
 */
function deleteItemReturn(data, textStatus, jqXHR) {
  // Hide the waiting icon:
  var itemArticle = $('#node-item-' + data.item_nid);
  itemArticle.find('.post-controls .item-delete').removeClass('waiting');

  if (!data.result) {
    alert(data.error);
  }
  else {
    // Remove the item:
    removePost(itemArticle);

    // If we're on an item's node page, go back to the channel where we came from:
    if (item_node_page) {
      var return_href = $('#return_link a').attr('href');
      $('#region-content .block-main .content').html("Please wait while you are redirected...");
      location.href = return_href;
    }
  }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Removing items.

/**
 * Handler for the remove item link.
 *
 * @param item_nid
 * @return bool
 */
function removeItem(item_nid) {
  var result = confirm('Are you sure you want to remove this item from your channel?\nThis action cannot be reversed.');
  if (result) {
    // Show the waiting icon:
    var itemArticle = $('#node-item-' + item_nid);
    itemArticle.find('.post-controls .item-remove').addClass('waiting');

    // Request the removal:
    $.post("/ajax/item/remove", {item_nid: item_nid}, removeItemReturn, 'json');
  }
  return false;
}

/**
 * Handler from when we get back from removing a item via AJAX.
 */
function removeItemReturn(data, textStatus, jqXHR) {
  // Hide the waiting icon:
  var itemArticle = $('#node-item-' + data.item_nid);
  itemArticle.find('.post-controls .item-delete').removeClass('waiting');

  if (!data.result) {
    alert(data.error);
  }
  else {
    // Remove the item:
    removePost(itemArticle);
  }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// New item form.

/**
 * Handler for when the item type is selected.
 */
function itemTypeSelected() {
  var itemType = $('#edit-field-item-type-und input:radio:checked').val();
  switch (itemType) {
    case 'text':
      $('#edit-field-item-link').hide();
      $('#edit-field-item-file').hide();
      $('#field-item-text-add-more-wrapper .description').text('Write something to share.');
      break;

    case 'link':
      $('#edit-field-item-link').show();
      $('#edit-field-item-file').hide();
      $('#field-item-text-add-more-wrapper .description').text('Enter a description of the link.');
      break;

    case 'file':
      $('#edit-field-item-link').hide();
      $('#edit-field-item-file').show();
      $('#field-item-text-add-more-wrapper .description').text('Enter a description of the file.');
      break;
  }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Rating items.

function setupRatings() {
  $('.rating-button').click(function() {
    var item_nid = $(this).closest('article').attr('data-nid');
    var rating = $(this).attr('data-rating');
    $.post("/ajax/rate/item", {item_nid: item_nid, rating: rating}, rateItemReturn);
  });

}

function rateItemReturn(data, textStatus, jqXHR) {
  debug(data);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Editing comments.

/**
 * Setup behaviour for a comment.
 *
 * @param object commentArticle
 * @param bool autoCollapse
 */
function setupCommentBehaviour(commentArticle, autoCollapse) {
  // Make sure commentArticle is a jQuery object:
  commentArticle = $(commentArticle);

  collapsePost(commentArticle, autoCollapse);

  // Setup behaviour for Update button:
  commentArticle.find('.update-comment-button').click(
    function () {
      var commentArticle = $(this).closest('article');
      var commentTextarea = commentArticle.find('textarea');
      var commentText = commentTextarea.val();

      if (commentText == '') {
        alert("Please enter a comment before clicking Update.");
      }
      else {
        commentTextarea.attr('disabled', 'disabled').addClass('uploading');
        var item_nid = commentArticle.attr('data-nid');
        var cid = commentArticle.attr('data-cid');
        $.post("/ajax/comment/edit", {cid: cid, item_nid: item_nid, text: commentText}, editCommentReturn, 'json');
      }
    }
  );

  // Setup behaviour for Cancel button:
  commentArticle.find('.cancel-comment-button').click(
    function () {
      var commentArticle = $(this).closest('article');

      // Hide the edit comment form:
      commentArticle.find('.edit-comment-form').hide();

      // Show the comment text and controls:
      commentArticle.find('.field-name-comment-body').show();
      commentArticle.find('.post-controls').show();

      return false;
    }
  );
}

/**
 * Handler for the edit comment link.
 *
 * @param item_nid
 * @return bool
 */
function editComment(cid) {
  var commentArticle = $('#comment-article-' + cid);

  // Hide the comment text and controls:
  commentArticle.find('.field-name-comment-body').hide();
  commentArticle.find('.post-controls').hide();

  // Show the edit comment form:
  commentArticle.find('.edit-comment-form').show();

  // ??
//  commentArticle.find('.post-content-wrapper').css('height', 'auto');

  return false;
}

/**
 * Handler from when we get back from editing a comment via AJAX.
 */
function editCommentReturn(data, textStatus, jqXHR) {
  if (!data.result) {
    alert(data.error);
  }
  else {
    // Edited comment.

    // Get the comment article:
    var commentArticle = $('#comment-article-' + data.cid);

    // Update comment body contents:
    var commentBody = commentArticle.find('.field-name-comment-body');
    commentBody.find('.field-item').html(data.filtered_text);

    // Remove uploading icon and disabled state from textarea, and update contents:
    commentArticle.find('textarea').removeAttr('disabled').removeClass('uploading').val(data.text);

    // Show the comment text and controls:
    commentBody.show();
    commentArticle.find('.post-controls').show();

    // Hide the edit comment form:
    commentArticle.find('.edit-comment-form').hide();
  }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Deleting comments.

/**
 * Handler for the delete comment link.
 *
 * @param item_nid
 * @return bool
 */
function deleteComment(cid) {
  var result = confirm('Are you sure you want to delete this comment?\nThis action cannot be reversed.');
  if (result) {
    var commentArticle = $('#comment-article-' + cid);
    commentArticle.find('.post-controls .comment-delete').addClass('waiting');
    $.post("/ajax/comment/delete", {cid: cid}, deleteCommentReturn, 'json');
  }
  return false;
}

/**
 * Handler from when we get back from deleting a comment via AJAX.
 */
function deleteCommentReturn(data, textStatus, jqXHR) {
  // Remove the waiting icon:
  var commentArticle = $('#comment-article-' + data.cid);
  commentArticle.find('.post-controls .comment-delete').addClass('waiting');

  if (!data.result) {
    alert(data.error);
  }
  else {
    // Remove the comment:
    removePost(commentArticle);
  }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Posting new comments.

/**
 * Setup behaviour for Post button for posting new comments.
 *
 * @param commentArticle
 */
function setupPostButton(commentArticle) {
  // Make sure commentArticle is a jQuery object:
  commentArticle = $(commentArticle);

  commentArticle.find('.new-comment-button').click(
    function () {
      var commentArticle = $(this).closest('article');
      var commentTextarea = commentArticle.find('textarea');
      var commentText = commentTextarea.val();

      if (commentText == '') {
        alert("Please enter a comment before clicking Post.");
      }
      else {
        commentTextarea.attr('disabled', 'disabled').addClass('uploading');
        var item_nid = commentArticle.attr('data-nid');

        $.post("/ajax/comment/post",
          {
            item_nid: item_nid,
            text: commentText
          },
          postCommentReturn,
          'json'
        );
      }
    }
  );
}

/**
 * Handler from when we get back from posting a comment via AJAX.
 */
function postCommentReturn(data, textStatus, jqXHR) {
  if (!data.result) {
    alert(data.error);
  }
  else {
    // Posted new comment.

    // Get the node article:
    var nodeArticle = $('#node-item-' + data.item_nid);

    // Remove the uploading icon from the new comment textarea:
    nodeArticle.find('.new-comment-form-article textarea').removeAttr('disabled').removeClass('uploading').val(''); //.autoresize();

    // Create new comment article:
    var commentArticle = $(data.html);

    // Insert comment into DOM:
    nodeArticle.find('#comments').append(commentArticle);

    // Attach behaviours to the new comment:
    setupCommentBehaviour(commentArticle, false);
    setupTooltipBehaviour(commentArticle.find('.tooltip'));
  }
}
