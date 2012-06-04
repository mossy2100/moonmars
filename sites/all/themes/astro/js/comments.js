var $ = jQuery;

$(function() {
  // Activate any of the more-less buttons.
  $('#comments article').each(function() {

    var article = $(this);
    var articleHeight = article.height();

    var commentContent = article.find('.comment-content');
    var commentContentHeight = commentContent.height();

    var commentContentWrapper = article.find('.comment-content-wrapper');
    var commentContentWrapperHeight = commentContentWrapper.height();

    var commentControls = article.find('.comment-controls');
    var scoreMoreWrapper = article.find('.score-more-wrapper');
    var moreLink = scoreMoreWrapper.find('a');

    if (commentContentHeight <= commentContentWrapperHeight) {
      scoreMoreWrapper.hide();
    }
    else {
      commentControls.hide();

      moreLink.click(function() {
        // Expand the comment:
        commentContentWrapper.height(commentContentHeight);
        // Hide the "Read more" link:
        scoreMoreWrapper.hide();
        commentControls.show();
      });
    }
  });
});
