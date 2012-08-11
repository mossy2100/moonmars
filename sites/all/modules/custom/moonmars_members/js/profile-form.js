var $ = jQuery;

$(function() {
  // Move some form fields that I can't move via hook_form_alter.
  $('#edit-mimemail').insertAfter('#edit-contact');
  $('#edit-timezone').insertAfter('#edit-field-user-location');

  // Modify the date of birth widget:
  $('#edit-field-date-of-birth-und-0-value .form-item-field-date-of-birth-und-0-value-date label').text('Date of birth');
  $('#edit-field-date-of-birth-und-0-value .form-item-field-date-of-birth-und-0-value-date .description').remove();

  // Remove the "delete location" checkbox:
//  $('.form-item-field-user-location-und-0-delete-location').remove();

  // Get the initial values of timezone and capital:
  var tz = $('#edit-timezone--2').val();
  var capital = $('#edit-field-user-location-und-0-city').val();

  // If the timezone or capital city isn't set, then set one or both of them automatically when the country is selected:
  if (!tz || tz == 'UTC' || !capital) {

    // Update timezone and/or capital when country changed.
    $('#edit-field-user-location-und-0-country').change(
      function() {
        // Make the AJAX request:
        $.get('/ajax/geo/country-timezone', {country_code: $(this).val()},
          function(data, textStatus, jqXHR) {
            data = JSON.parse(data);

            // Set the timezone if one was found and if not set already:
            if (data.timezone.timezoneid && (!tz || tz == 'UTC')) {
              $('#edit-timezone--2').val(data.timezone.timezoneid);
            }

            // Set the capital city name if one was found and if not set already:
            if (data.capital.name && !capital) {
              $('#edit-field-user-location-und-0-city').val(data.capital.name);
            }

          }
        );

      }
    );
  }

  ///////////////////////////////////
  // Colors:

//  $('#edit-field-background-color-und-0-rgb').hide();
//  $('.colorpicker').remove();
  $('#field-background-color-add-more-wrapper').insertAfter('.form-item-field-background-color-und-0-rgb label');

  updateColors();

  $('.color-icon').click(function() {
    $(this).closest('.color-icons').find('.color-icon-wrapper').removeClass('selected');
    $(this).closest('.color-icon-wrapper').addClass('selected');
    updateColors();
  });

});

function rgb2hex(rgb) {
  rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
  if (!rgb) {
    return '';
  }

  function hex(x) {
    return ("0" + parseInt(x).toString(16)).slice(-2);
  }

  return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

// Update colors:
function updateColors() {
  // Get the selected color:
  var selectedBackgroundColor = $('#edit-field-background-color .color-icon-wrapper.selected .color-icon').css('background-color');

  // Set the value of the hidden field:
  $('#edit-field-background-color-und-0-rgb').val(rgb2hex(selectedBackgroundColor));

//  var selectedTextColor = $('#edit-field-text-color .color-icon-wrapper.selected .color-icon').css('color');
//  var selectedBorderColor = $('#edit-field-border-color .color-icon-wrapper.selected .color-icon').css('border-color');
//  alert('selected background color = ' + selectedBackgroundColor + '\n' +
//    'selected text color = ' + selectedTextColor + '\n' +
//    'selected border color = ' + selectedBorderColor + '\n');

//  // Set the background color of the text and border color selectors to match the selected background color:
//  $('#edit-field-text-color .color-icon, #edit-field-border-color .color-icon').css('background-color', selectedBackgroundColor);
//
//  // Set the text color of the background and border color selectors to match the selected text color:
//  $('#edit-field-background-color .color-icon, #edit-field-border-color .color-icon').css('color', selectedTextColor);
//
//  // Set the border color of the background and text color selectors to match the selected border color:
//  $('#edit-field-background-color .color-icon, #edit-field-text-color .color-icon').css('border-color', selectedBorderColor);
}
