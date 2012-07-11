var $ = jQuery;

//var provinceRequestWaiting = false;
//var timezoneRequestWaiting = false;

$(function() {
  // Move some form fields that I can't move via hook_form_alter.
  $('#edit-mimemail').insertAfter('#edit-contact');
  $('#edit-timezone').insertAfter('#edit-field-user-location');

  // Modify the date of birth widget:
  $('#edit-field-date-of-birth-und-0-value .form-item-field-date-of-birth-und-0-value-date label').text('Date of birth');
  $('#edit-field-date-of-birth-und-0-value .form-item-field-date-of-birth-und-0-value-date .description').remove();

  // Remove the "delete location" checkbox:
//  $('.form-item-field-user-location-und-0-delete-location').remove();

  // Update timezone when country changed.
  $('#edit-field-user-location-und-0-country').change(function() {
//    timezoneRequestWaiting = true;
    $.get('/ajax/geo/country-timezone', {country_code: $(this).val()}, function(data, textStatus, jqXHR) {
      data = JSON.parse(data);
//      debug(data);
      if (data.timezone.timezoneid !== undefined) {
        // Set the timezone:
        $('#edit-timezone--2').val(data.timezone.timezoneid);
        // Default the city name to the capital:
        $('#edit-field-user-location-und-0-city').val(data.capital.name);
      }
      else {
        $('#edit-timezone--2').val('UTC');
      }
//      timezoneRequestWaiting = false;
    });
  });

//  $('#edit-field-user-location-und-0-province-selector').bind('beginAjax', function() {
//    provinceRequestWaiting = true;
//  });
//  $('#edit-field-user-location-und-0-province-selector').bind('endAjax', function() {
//    provinceRequestWaiting = false;
//  });

});
