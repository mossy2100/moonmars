var $ = jQuery;

var collapsedContentHeight = 96;
var item_node_page;

$(initChannel);

/**
 * Set up behaviours of links, buttons and avatars.
 */
function initChannel() {

  // Check if we're on an item's node page:
  item_node_page = Drupal.settings.astro && Drupal.settings.astro.item_node_page;

  // Setup item behaviours:
  $('article.node-item').each(function () {
    setupItemBehaviour(this);
  });

  // Setup comment behaviours:
  $('#comments article').each(function () {
    setupCommentBehaviour(this);
  });

  ///////////////////////////////////////////////////////////////////////////////////////
  // New item form

  // Tidy up and setup behaviours for the new item form:
  itemTypeSelected();
  $('#edit-field-item-type-und input:radio').click(itemTypeSelected);
  $('#edit-path').remove();
  $('#item-node-form span.form-required').remove();

  // Setup client-side validation for Post button:
  $('#item-node-form #edit-submit--3').click(function () {
    var itemText = $('#edit-field-item-text-und-0-value').val();
    if (!itemText) {
      alert('Please enter a description.');
      return false;
    }
  });

  ///////////////////////////////////////////////////////////////////////////////////////

  // Hack - remove pagers from beneath comments in channels:
  $('article.node-item #comments .item-list').remove();

  // Resize YouTube videos:
  $('.media-youtube-outer-wrapper, .media-youtube-preview-wrapper, .youtube-player').css({width: '240px', height: '180px'}).attr({width: 240, height: 180});

//  // Highlight the comment if mentioned in the hash:
//  var hash = window.location.hash;
//  if (hash) {
//    var hashParts = hash.split('-');
//    if (hashParts[0] == '#comment') {
//      $('#comment-article-' + hashParts[1] + ' .post-article-body').css('border-color', 'black');
//    }
//
//  }
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

  // Hide the textarea for editing the comment:
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
  }, 333, function() {
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

  var newCommentFormArticle = itemArticle.find('article.new-comment-form-article');

  // Setup new comment form behaviour:
  setupPostButton(newCommentFormArticle);

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
}

/**
 * Handler from when we get back from removing a item via AJAX.
 */
function removeItemReturn(data, textStatus, jqXHR) {
  // Hide the waiting icon:
  var itemArticle = $('#node-item-' + data.item_nid);
  itemArticle.find('.post-controls .item-remove').removeClass('waiting');

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
      $('#edit-field-item-image').hide();
      $('#edit-field-item-video').hide();
      $('#edit-field-item-document').hide();
      $('#field-item-text-add-more-wrapper .description').text('Write something to share.');
      break;

    case 'link':
      $('#edit-field-item-link').show();
      $('#edit-field-item-image').hide();
      $('#edit-field-item-video').hide();
      $('#edit-field-item-document').hide();
      $('#field-item-text-add-more-wrapper .description').text('Enter a description of the link.');
      break;

    case 'image':
      $('#edit-field-item-link').hide();
      $('#edit-field-item-image').show();
      $('#edit-field-item-video').hide();
      $('#edit-field-item-document').hide();
      $('#field-item-text-add-more-wrapper .description').text('Enter a description of the image.');
      break;

    case 'video':
      $('#edit-field-item-link').hide();
      $('#edit-field-item-image').hide();
      $('#edit-field-item-video').show();
      $('#edit-field-item-document').hide();
      $('#field-item-text-add-more-wrapper .description').text('Enter a description of the video.');
      break;

    case 'document':
      $('#edit-field-item-link').hide();
      $('#edit-field-item-image').hide();
      $('#edit-field-item-video').hide();
      $('#edit-field-item-document').show();
      $('#field-item-text-add-more-wrapper .description').text('Enter a description of the document.');
      break;
  }
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

  // Show the edit comment form.
  commentArticle.find('.edit-comment-form').show();

  // Reset the textarea height when it gets shown.
  // elastic() will already have been called once on this textarea, creating the twin div.
  commentArticle.find('.edit-comment-form textarea').elastic();

  // ??
//  commentArticle.find('.post-content-wrapper').css('height', 'auto');
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
    // Show the waiting icon:
    var commentArticle = $('#comment-article-' + cid);
    commentArticle.find('.post-controls .comment-delete').addClass('waiting');

    // Send AJAX request:
    $.post("/ajax/comment/delete", {cid: cid}, deleteCommentReturn, 'json');
  }
}

/**
 * Handler from when we get back from deleting a comment via AJAX.
 */
function deleteCommentReturn(data, textStatus, jqXHR) {
  // Hide the waiting icon:
  var commentArticle = $('#comment-article-' + data.cid);
  commentArticle.find('.post-controls .comment-delete').removeClass('waiting');

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
 * Display the new comment form.
 *
 * @param int item_nid
 */
function showNewCommentForm(item_nid) {
  // Get the new comment form:
  var newCommentFormArticle = $('#new-comment-form-article-' + item_nid);

  if (newCommentFormArticle.css('display') == 'block') {
    // New comment form is already displayed, do nothing:
    return;
  }

  // Get the initial height of the new comment area:
  var bottomLinks = $('.bottom-post-controls-' + item_nid);
  var initialHeight = bottomLinks.length ? bottomLinks.height() : 0;

  // Hide the comment links:
  bottomLinks.hide();

  // Initialise the form prior to animation:
  newCommentFormArticle.css({height: initialHeight, opacity: 0, overflow: 'hidden'}).show();

  // Reset the textarea height when it's made visible.
  // elastic() will already have been called once on this textarea, creating the twin div.
  newCommentFormArticle.find('textarea').elastic();

  // Get the height of the visible part of the form, now that it's shown:
  var height = newCommentFormArticle.find('.post-article-body').outerHeight();

  // Animate the display of the form:
  newCommentFormArticle.animate({
    height: height,
    opacity: 1
  }, 333, function() {
    // Now set the height to auto, so it grows automatically with the textarea:
    newCommentFormArticle.height('auto');
  });

  // Simultaneously scroll into view:
  var formTop = newCommentFormArticle.offset().top;
  var formHeight = newCommentFormArticle.height();
  var windowHeight = $(window).height();
  $.scrollTo({top: formTop - ((windowHeight - formHeight) / 2), left: 0}, 333, {
    easing: 'swing',
    onAfter: function() {
      newCommentFormArticle.find('textarea').focus();
    }
  });
}

/**
 * Hide the new comment form.
 *
 * @param int item_nid
 */
function hideNewCommentForm(item_nid, animate) {
  // Get the new comment form:
  var newCommentFormArticle = $('#new-comment-form-article-' + item_nid);

  // Get the final height of the new comment area:
  var bottomLinks = $('.bottom-post-controls-' + item_nid);
  var finalHeight = bottomLinks.length ? bottomLinks.height() : 0;

  function _hideNewCommentForm() {
    // Hide the new comment form:
    newCommentFormArticle.hide();
    // Show the comment link, if there is one:
    bottomLinks.show();
  }

  if (animate === true || animate === undefined) {
    // Animate and hide it.
    newCommentFormArticle.animate({
      height: finalHeight,
      opacity: 0
    }, 333, _hideNewCommentForm);
  }
  else {
    _hideNewCommentForm();
  }
}

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

  commentArticle.find('.cancel-comment-button').click(function() {
    hideNewCommentForm($(this).attr('data-nid'));
  });

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
    nodeArticle.find('.new-comment-form-article textarea').removeAttr('disabled').removeClass('uploading').val('').height(36);

    // Create new comment article:
    var commentArticle = $(data.html);

    // Insert comment into DOM:
    nodeArticle.find('#comments').append(commentArticle);

    // Hide the new comment form:
    hideNewCommentForm(data.item_nid, false);

    // Attach behaviours to the new comment:
    setupCommentBehaviour(commentArticle, false);
    setupTooltipBehaviour(commentArticle.find('.tooltip'));
  }
}
