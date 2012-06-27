var $ = jQuery;

$(function() {
  // Move some form fields that I can't figure out how to change via hook_form_alter.
  $('#edit-mimemail').insertAfter('#edit-contact');
  $('#edit-timezone').insertAfter('#edit-field-user-location');

  // Modify the date of birth widget:
  $('#edit-field-date-of-birth-und-0-value .form-item-field-date-of-birth-und-0-value-date label').text('Date of birth');
  $('#edit-field-date-of-birth-und-0-value .form-item-field-date-of-birth-und-0-value-date .description').remove();

  // Update timezone when country changed.
  $('#edit-field-user-location-und-0-country').change(function() {
    $.get('/ajax/geo/country-timezone', {country_code: $(this).val()}, function(data, textStatus, jqXHR) {
      data = JSON.parse(data);
      if (data.timezoneId !== undefined) {
        $('#edit-timezone--2').val(data.timezoneId);
      }
    });
  });

});
