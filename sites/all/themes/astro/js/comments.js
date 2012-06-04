var $ = jQuery;

$(function() {
  $('#comments article, .view-channel .article-body').each(function() {

    var article = $(this);
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
  });

});
