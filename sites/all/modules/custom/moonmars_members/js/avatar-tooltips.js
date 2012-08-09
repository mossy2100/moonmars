var $ = jQuery;

$(function() {
  // Enable avatar tooltip behaviour:
  $('.avatar-tooltip').each(function () {
    setupTooltipBehaviour(this);
  });
});

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
  );
//  .click(
//    // When the tooltip is clicked, go to the user's profile:
//    function () {
//      location.href = $(this).find('.avatar-link').attr('href');
//    }
//  );

  // Same effect if we hover over the user name to the right of the avatar icon:
  $(tooltip).closest('.post-article-body').find('a.username').hover(
    function () {
      $('.user-tooltip', $(this).closest('.post-article-body').find('.avatar-tooltip')).eq(0).css('display', 'block');
    },
    function () {
      $('.user-tooltip', $(this).closest('.post-article-body').find('.avatar-tooltip')).eq(0).css('display', 'none');
    }
  );
}
