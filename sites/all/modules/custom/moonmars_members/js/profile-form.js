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

});
