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

  // Set up comment behaviours:
  $('#comments article').each(function() {
    setupCommentBehaviour(this);
  });
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

function setupCommentBehaviour(commentArticle) {
  commentArticle = $(commentArticle);
  var postContent = commentArticle.find('.post-content');
  var postContentHeight = postContent.height();

  var postContentWrapper = commentArticle.find('.post-content-wrapper');
  var postContentWrapperHeight = postContentWrapper.height();

  var postControls = commentArticle.find('.post-controls');
  var scoreMoreWrapper = commentArticle.find('.score-more-wrapper');
  var moreLink = scoreMoreWrapper.find('a');

  // Determine what to hide:
  if (postContentHeight <= postContentWrapperHeight) {
    scoreMoreWrapper.hide();
    postControls.show();
  }
  else {
    postControls.hide();
    scoreMoreWrapper.show();
  }

  // Setup handler for "Read more" link:
  moreLink.click(function() {
    // Expand the post:
    postContentWrapper.css({height: 'auto'});
    // Hide the "Read more" link:
    scoreMoreWrapper.hide();
    postControls.show();
  });

  // Setup handler for edit link:
  commentArticle.find('.links li.comment-edit a').click(
    function() {
      // Hide the comment text and controls:
      var commentArticle = $(this).closest('article');
      commentArticle.find('.field-name-comment-body').hide();
      commentArticle.find('.post-controls').hide();
      // Show the edit comment form:
      commentArticle.find('.edit-comment-form').show();
      commentArticle.find('.post-content-wrapper').css({height: 'auto'});
      return false;
    }
  );

  // Add autogrow for textareas:
  commentArticle.find('textarea').autoresize();

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
        $.post("/ajax/post/comment",
          {
            cid: cid,
            nid: nid,
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
  //              alert(JSON.stringify(data));
  if (!data.result) {
    alert('Sorry, your comment could not be posted for some reason. Please report the problem.');
  }
  else {
    if (data.mode == 'edit') {
      var commentArticle = $('#comment-article-' + data.cid);
      commentArticle.find('textarea').removeAttr('disabled').removeClass('uploading').val(data.text);
      commentArticle.find('.field-name-comment-body').show();
      commentArticle.find('.field-name-comment-body .field-item').text(data.text);
      commentArticle.find('.edit-comment-form').hide();
    }
    else {
      var commentArticle = $(data.html);
      var newCommentFormArticle = $('#node-item-' + data.nid + ' .new-comment-form-article');
      newCommentFormArticle.before(commentArticle);
      newCommentFormArticle.find('textarea').removeAttr('disabled').removeClass('uploading').val('');
    }
    setupCommentBehaviour(commentArticle);
    setupTooltipBehaviour(commentArticle.find('.tooltip'));
  }
}
