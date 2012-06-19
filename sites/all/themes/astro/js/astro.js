var $ = jQuery;

var collapsedContentHeight = 96;

$(initChannel);

/**
 * Set up behaviours of links, buttons and avatars.
 */
function initChannel() {
  // Convert select elements into selectBoxes:
//  $('select').selectBox();

  // Enable avatar tooltip behaviour:
  $('.avatar-tooltip').each(function () {
    setupTooltipBehaviour(this);
  });

  // Setup comment behaviours:
  $('#comments article, article.new-comment-form-article').each(function () {
    setupCommentBehaviour(this);
  });

  // Setup item behaviours:
  $('article.node-item').each(function () {
    setupItemBehaviour(this);
  });

  // Tidy up and setup behaviours for the new item form:
  itemTypeSelected();
  $('#edit-field-item-type-und input:radio').click(itemTypeSelected);
  $('#edit-path').remove();
  $('#field-item-text-add-more-wrapper textarea').autoresize();
  $('#item-node-form span.form-required').remove();

  // Setup client-side validation for Post button:
  $('#item-node-form #edit-submit--3').click(function () {
    var itemText = $('#edit-field-item-text-und-0-value').val();
    if (!itemText) {
      alert('Please enter a description.');
      return false;
    }
  });

  // CSS
  $('#edit-actions--3').addClass('clearfix');

  // Hack - remove pagers from beneath comments in channels:
  $('article.node-item #comments .item-list').remove();
}

/**
 * Enable user avatar tooltips.
 */
function setupTooltipBehaviour(tooltip) {
  $(tooltip).hover(
    function () {
      $('.user-tooltip', this).css('display', 'block');
    },
    function () {
      $('.user-tooltip', this).css('display', 'none');
    }
  ).click(
    // When the tooltip is clicked, go to the user's profile:
    function () {
      location.href = $(this).find('.avatar-link').attr('href');
    }
  );
  // Same effect if we hover over the user name to the right of the avatar icon:
  $(tooltip).closest('.post-article-body').find('a.username').hover(
    function () {
      $('.user-tooltip', $(this).closest('.post-article-body').find('.avatar-tooltip')).css('display', 'block');
    },
    function () {
      $('.user-tooltip', $(this).closest('.post-article-body').find('.avatar-tooltip')).css('display', 'none');
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

  var postControls = postArticle.find('.post-controls').eq(0);
  var scoreMoreWrapper = postArticle.find('.score-more-wrapper').eq(0);

  if (postContentHeight <= collapsedContentHeight || !autoCollapse) {
    // Hide the "Read more" link:
    scoreMoreWrapper.hide();
    // Show the links and rating buttons;
    postControls.show();
  }
  else {
    // Collapse the post:
    var postContentWrapper = postArticle.find('.post-content-wrapper').eq(0);
    postContentWrapper.height(collapsedContentHeight);
    // Hide the "Read more" link:
    scoreMoreWrapper.show();
    // Show the links and rating buttons:
    postControls.hide();
  }

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
    function () {
      var commentArticle = $(this).closest('article');
      // Hide the comment text and controls:
      commentArticle.find('.field-name-comment-body').hide();
      commentArticle.find('.post-controls').hide();
      // Show the edit comment form:
      commentArticle.find('.edit-comment-form').show();
      commentArticle.find('.post-content-wrapper').css('height', 'auto');
      return false;
    }
  );

  // Setup handler for Post/Update button:
  commentArticle.find('.new-comment-button').click(
    function () {
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

  // Setup handler for delete link:
  commentArticle.find('.links li.comment-delete a').click(
    function () {
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
