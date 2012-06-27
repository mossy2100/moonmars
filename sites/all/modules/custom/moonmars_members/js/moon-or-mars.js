var $ = jQuery;

$(function() {
  $('#edit-field-moon-or-mars-und').addClass('clearfix');
  var moonmarsOptions = $('#edit-field-moon-or-mars-und .form-item label');
  moonmarsOptions.eq(0).css('background-image', "url('/sites/all/themes/astro/images/moon-80x80.jpg')");
  moonmarsOptions.eq(1).css('background-image', "url('/sites/all/themes/astro/images/mars-80x80.jpg')");
  moonmarsOptions.eq(2).css('background-image', "url('/sites/all/themes/astro/images/both-80x80.jpg')");

  // Select 'both' by default:
  $('#edit-field-moon-or-mars-und .form-item input').uncheck().eq(2).check();
  $('#edit-field-moon-or-mars-und .form-item label').removeClass('selected').eq(2).addClass('selected');

  // When a label is clicked, and the radio button changes, move the selected class:
  $('#edit-field-moon-or-mars-und .form-item label').click(function() {
    // Remove the checked state and the selected class from all radio buttons in the group:
    $('#edit-field-moon-or-mars-und .form-item label').removeClass('selected');
    $('#edit-field-moon-or-mars-und .form-item input').uncheck();
    // Check and select the newly selected one:
    $(this).addClass('selected');
    $(this).closest('.form-item').find('input').check();
  });

});
