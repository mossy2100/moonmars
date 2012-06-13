var $ = jQuery;

$(initChannel);

/**
 * Set up behaviours of links, buttons and avatars.
 */
function initChannel() {
  // Convert select elements into selectBoxes:
  $('select').selectBox();

  // Enable avatar tooltip behaviour:
  $('.avatar-tooltip').each(function() {
    setupTooltipBehaviour(this);
  });

  // Setup comment behaviours:
  $('#comments article').each(function() {
    setupCommentBehaviour(this);
  });

  // Setup item behaviours:
  $('article.node-item').each(function() {
    setupItemBehaviour(this);
  });

//  // Setup post button behaviours:
//  $('#post-button').click(function() {
//    var itemText = $('#edit-new-item').val();
//    if (!itemText) {
//      alert('Please enter something before clicking Post.');
//    }
//    else {
//      var group_nid = $('input:hidden[name=group-nid]');
////      var item_nid = $('input:hidden[name=group-nid]');
//      var item_nid = 0;
//      $.post("/ajax/item/update",
//        {
//          group_nid: group_nid,
//          item_nid: item_nid,
//          text: itemText
//        },
//        updateItemReturn,
//        'json'
//      );
//
//    }
//    return false;
//  });
}

/**
 * Enable user avatar tooltips.
 */
function setupTooltipBehaviour(tooltip) {
  $(tooltip)
    .hover(
      function () {
        $('.user-tooltip', this).css('display', 'block');
      },
      function () {
        $('.user-tooltip', this).css('display', 'none');
      }
    ).click(
      // When the tooltip is clicked, go to the user's profile:
      function() {
        location.href = $(this).find('.avatar-link').attr('href');
      }
    );
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
  postArticle.find('textarea').eq(0).autoresize();

  // Have to hide the textarea after calling autoresize.
  postArticle.find('.edit-comment-form').eq(0).hide();

  // Determine what to hide:
  var postContent = postArticle.find('.post-content').eq(0);
  var postContentHeight = postContent.height();

  var postContentWrapper = postArticle.find('.post-content-wrapper').eq(0);
  var postContentWrapperHeight = postContentWrapper.height();

  var postControls = postArticle.find('.post-controls').eq(0);
  var scoreMoreWrapper = postArticle.find('.score-more-wrapper').eq(0);
  var moreLink = scoreMoreWrapper.find('a').eq(0);

  if (postContentHeight <= postContentWrapperHeight || !autoCollapse) {
    // Expand the post:
    postContentWrapper.addClass('auto-height');
    // Hide the "Read more" link:
    scoreMoreWrapper.hide();
    // Show the links and rating buttons;
    postControls.show();
  }
  else {
    postControls.hide();
    scoreMoreWrapper.show();
  }

  // Setup handler for "Read more" link:
  moreLink.click(function() {
//    var postArticle = $(this).closest('article');
    // Expand the post:
//    var postContentWrapper = postArticle.find('.post-content-wrapper');
    postContentWrapper.addClass('auto-height');
    // Hide the "Read more" link:
//    var scoreMoreWrapper = postArticle.find('.score-more-wrapper');
    scoreMoreWrapper.hide();
    // Show the links and rating buttons:
//    var postControls = postArticle.find('.post-controls');
    postControls.show();
  });

}

/**
 * Setup behaviour for comments.
 *
 * @param object commentArticle
 * @param bool autoCollapse
 */
function setupCommentBehaviour(commentArticle, autoCollapse) {

  commentArticle = $(commentArticle);

  collapsePost(commentArticle, autoCollapse);

  // Setup handler for edit link:
  commentArticle.find('.links li.comment-edit a').click(
    function() {
      var commentArticle = $(this).closest('article');
      // Hide the comment text and controls:
      commentArticle.find('.field-name-comment-body').hide();
      commentArticle.find('.post-controls').hide();
      // Show the edit comment form:
      commentArticle.find('.edit-comment-form').show();
      commentArticle.find('.post-content-wrapper').addClass('auto-height');
      return false;
    }
  );

  // Setup handler for Post/Update button:
  commentArticle.find('.new-comment-button').click(
    function() {
      var commentArticle = $(this).closest('article');
      var commentTextarea = commentArticle.find('textarea');
      var commentText = commentTextarea.val();
      //      alert(commentText);
      if (commentText == '') {
        alert("Please enter a comment before clicking Post.");
      }
      else {
        commentTextarea.attr('disabled', 'disabled').addClass('uploading');
        var cid = commentArticle.attr('data-cid');
        var nid = commentArticle.attr('data-nid');
        $.post("/ajax/comment/update",
          {
            cid: cid,
            nid: nid,
            text: commentText
          },
          updateCommentReturn,
          'json'
        );
      }
    }
  );

  commentArticle.find('.cancel-comment-button').click(
    function() {
      var commentArticle = $(this).closest('article');
      // Hide the edit comment form:
      commentArticle.find('.edit-comment-form').hide();
      // Show the comment text and controls:
      commentArticle.find('.field-name-comment-body').show();
      commentArticle.find('.post-controls').show();
      return false;
    }
  );

  // Setup handler for delete link:
  commentArticle.find('.links li.comment-delete a').click(
    function() {
      var result = confirm('Are you sure you want to delete this comment?');
      if (result) {
        var commentArticle = $(this).closest('article');
        var cid = commentArticle.attr('data-cid');
        $.post("/ajax/comment/delete",
          {
            cid: cid
          },
          deleteCommentReturn,
          'json'
        );
      }
      return false;
    }
  );

}

/**
 * Handler from when we get back from updating or creating a comment via AJAX.
 */
function updateCommentReturn(data, textStatus, jqXHR) {
  //              alert(JSON.stringify(data));
  if (!data.result) {
    alert('Sorry, your comment could not be ' + (data.mode == 'edit' ? 'updated' : 'posted') + ' for some reason. Please report the problem.');
  }
  else {
    if (data.mode == 'edit') {
      // Edited comment:
      var commentArticle = $('#comment-article-' + data.cid);
      commentArticle.find('textarea').removeAttr('disabled').removeClass('uploading').val(data.text).autoresize();
      commentArticle.find('.field-name-comment-body').show();
      commentArticle.find('.field-name-comment-body .field-item').text(data.text);
    }
    else {
      // Posted new comment:
      var commentArticle = $(data.html);
      var newCommentFormArticle = $('#node-item-' + data.nid + ' .new-comment-form-article');
      newCommentFormArticle.before(commentArticle);
      newCommentFormArticle.find('textarea').removeAttr('disabled').removeClass('uploading').val('').autoresize();
    }
    setupCommentBehaviour(commentArticle, false);
    setupTooltipBehaviour(commentArticle.find('.tooltip'));
  }
}

/**
 * Handler from when we get back from deleting a comment via AJAX.
 */
function deleteCommentReturn(data, textStatus, jqXHR) {
  if (!data.result) {
    alert('Sorry, your comment could not be deleted for some reason. Please report the problem.');
  }
  else {
    // Remove the comment:
    $('#comment-article-' + data.cid).remove();
  }
}

/**
 * Setup behaviour for items.
 *
 * @param object itemArticle
 * @param bool autoCollapse
 */
function setupItemBehaviour(itemArticle, autoCollapse) {
  itemArticle = $(itemArticle);
  collapsePost(itemArticle, autoCollapse);
}
