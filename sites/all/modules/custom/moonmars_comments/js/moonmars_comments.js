
(function($) {

  $(function() {

    // Auto-collapse items and comments:
    $('#comments article, .view-channel .article-body').each(
      function() {
        postAutoCollapse(this);
      }
    );

    // Add autogrow for textareas:
    $('#comments article textarea, .view-channel .article-body textarea').autogrow();

    // Handler for when the "Post" button is clicked to post a new comment.
    $('.new-comment-button').click(function() {
      var commentTextarea = $(this).closest('.post-content').find('textarea');
      var commentText = commentTextarea.val();
      if (commentText == '') {
        alert("Please enter a comment before clicking Post.");
      }
      else {
        commentTextarea.attr('disabled', 'disabled').addClass('uploading');
        var nid = $(this).attr('data-nid');
        $.post("/ajax/post/comment",
          {
            nid: nid,
            text: commentText
          },
          function(data, textStatus, jqXHR) {
            if (data == '0') {
              alert('Sorry, your comment could not be posted for some reason. Please report the problem.');
            }
            else {
              var comment = $(data);
              $('#node-item-' + nid + ' .comment-form').before(comment);
              postAutoCollapse(comment);
            }
            commentTextarea.val('').removeClass('uploading').removeAttr('disabled');
          },
          'html'
        );

      }
    });

  });

})(jQuery);


function postAutoCollapse(comment) {

  var article = $(comment);
  var articleHeight = article.height();

  var postContent = article.find('.post-content');
  var postContentHeight = postContent.height();

  var postContentWrapper = article.find('.post-content-wrapper');
  var postContentWrapperHeight = postContentWrapper.height();

  var postControls = article.find('.post-controls');
  var scoreMoreWrapper = article.find('.score-more-wrapper');
  var moreLink = scoreMoreWrapper.find('a');

  if (postContentHeight <= postContentWrapperHeight) {
    scoreMoreWrapper.hide();
  }
  else {
    postControls.hide();

    moreLink.click(function() {
      // Expand the post:
      postContentWrapper.height(postContentHeight);
      // Hide the "Read more" link:
      scoreMoreWrapper.hide();
      postControls.show();
    });
  }
}
