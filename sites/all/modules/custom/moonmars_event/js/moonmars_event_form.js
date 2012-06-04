jQuery(function() {

  // Detect and set the timezone:
  detectTimezone(function(timezone) {
    // Set the value of the timezone field:
    jQuery('#edit-field-event-datetime-und-0-timezone-timezone').val(timezone.timezoneId);
  });

  // Get the required span:
  var reqd = jQuery('.form-item-field-event-datetime-und-0-value > label').html();

  // Remove some labels we don't want:
  //jQuery('.field-name-field-event-datetime fieldset.form-wrapper legend').remove();
  jQuery('.form-item-field-event-datetime-und-0-value > label').remove();
  jQuery('.form-item-field-event-datetime-und-0-value2 > label').remove();

  // Update the labels we do want:
  jQuery('.form-item-field-event-datetime-und-0-value-date > label').html("Start date " + reqd);
  jQuery('.form-item-field-event-datetime-und-0-value-time > label').html("Time " + reqd);
  jQuery('.form-item-field-event-datetime-und-0-value2-date > label').html("Finish date " + reqd);
  jQuery('.form-item-field-event-datetime-und-0-value2-time > label').html("Time " + reqd);
});
