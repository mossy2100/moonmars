var $ = jQuery;

//alert(1);

$(function() {

  $('#edit-field-moon-or-mars-und').addClass('clearfix');

  // Add the images:
  var moonmarsOptions = $('#edit-field-moon-or-mars-und .form-item label');
  moonmarsOptions.eq(0).css('background-image', "url('/sites/all/themes/astro/images/moon-80x80.jpg')");
  moonmarsOptions.eq(1).css('background-image', "url('/sites/all/themes/astro/images/mars-80x80.jpg')");
  moonmarsOptions.eq(2).css('background-image', "url('/sites/all/themes/astro/images/both-80x80.jpg')");

  // Get the current selection:
  var currentMoonMarsSelection = $('#edit-field-moon-or-mars-und .form-item input:checked');

  // If nothing selected, delect 'Both' by default:
  if (!currentMoonMarsSelection.val()) {
    currentMoonMarsSelection = $('#edit-field-moon-or-mars-und .form-item input[value=both]');
    currentMoonMarsSelection.check();
  }

  // Highlight the selected image:
  currentMoonMarsSelection.closest('.form-item').find('label').addClass('selected');

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
