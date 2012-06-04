var $ = jQuery;

$(function() {
  // Convert select elements into selectBoxes:
  $('select').selectBox();

  // Position the avatar tooltips:
  $('.user-tooltip').each(function() {
    $(this).css({
      top: '-7px',
      left: '-7px'
    });
  });

  // Add tooltips to user avatars:
  $(".avatar-tooltip")
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
});
