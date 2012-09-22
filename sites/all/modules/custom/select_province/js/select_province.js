var $ = jQuery;

/**
 * Request provinces for a given country and update province selector.
 */
function select_province_get(countrySelectorId, provinceAutocompleteId, provinceSelectorId) {
  // Get the selected country code:
  var countryCode = $('#' + countrySelectorId).val();

  // Empty the province provinceSelector.
  var provinceSelector = $('#' + provinceSelectorId);
  provinceSelector.empty();

  // Add a null option to the provinceSelector:
  var nullOption = $("<option value=''></option>");
  provinceSelector.append(nullOption);

  // Disable the provinceSelector:
  provinceSelector.attr('disabled', 'disabled');

  // Get the province autocomplete:
  var provinceAutocomplete = $('#' + provinceAutocompleteId);

  if (countryCode) {
    // Trigger the beginAjax event in case any other scripts want to capture it:
    provinceSelector.trigger('beginAjax');

    // Ask the user to wait:
    nullOption.text("Please wait...");

    $.get('/select-province/ajax/get-provinces/' + countryCode,
      function(response) {
//        alert(response);
        var provinces = JSON.parse(response);

        if (!$.isEmptyObject(provinces)) {
          // Enable the provinceSelector:
          provinceSelector.removeAttr('disabled');

          // Prompt the user to select a province:
          nullOption.text("Please select");

          // Get the current province from the autocomplete field:
          var selectedProvince = provinceAutocomplete.val();

          // Populate the provinceSelector options:
          var option;
          var matchFound = false;
          for (var provinceCode in provinces) {
            option = $("<option value='" + provinceCode + "'>" + provinces[provinceCode] + "</option>");
            // If the province code matches the value from the province autocomplete, select it:
            if (provinceCode == selectedProvince) {
              option.attr('selected', 'selected');
              matchFound = true;
            }
            provinceSelector.append(option);
          }

          // If no match found, clear the autocomplete.
          if (!matchFound) {
            provinceAutocomplete.val('');
          }
        }
        else {
          // Inform the user that there are no provinces to select:
          nullOption.text("N/A");
        }

        // Trigger the endAjax event in case any other scripts want to capture it:
        provinceSelector.trigger('endAjax');
      }
    );
  }
  else {
    // Prompt the user to select a country:
    nullOption.text("Please select country");
  }
}

$(function () {
  // Update the form, replacing all province autocomplete fields with selectors.
  $('.location_auto_province').each(function() {
    var provinceAutocomplete = $(this);

    // Hide the province autocomplete field:
    provinceAutocomplete.hide();

    // Get the province field ids:
    var provinceAutocompleteId = this.id;
    var provinceSelectorId = this.id + '-selector';

    // Add the province selector:
    var provinceSelector = $("<select id='" + provinceSelectorId + "'></select>");
    provinceAutocomplete.after(provinceSelector);

    // Whenever the provinceSelector changes, we want to set the value of the autocomplete field:
    provinceSelector.change(function() {
      $('#' + provinceAutocompleteId).val($(this).val());
    });

    // Get the country selector id:
    var countrySelector = provinceAutocomplete.closest('.location').find('.location_auto_country');
    var countrySelectorId = countrySelector.attr('id');

    // Initialise the province provinceSelector:
    select_province_get(countrySelectorId, provinceAutocompleteId, provinceSelectorId);

    // Remove any other change events from the country selector. This could be dubious, maybe revisit later if I ever
    // contrib this module.
    countrySelector.unbind('change');

    // Whenever the country selector changes, update the province selector:
    countrySelector.change(function() {
      select_province_get(countrySelectorId, provinceAutocompleteId, provinceSelectorId);
    });
  });
});
