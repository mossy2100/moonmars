var $ = jQuery;

/**
 * Request provinces for a given country and update province selector.
 */
function select_province_get(country_id, province_id, selector_id) {
  // Get the selected country code:
  var countryCode = $('#' + country_id).val();

  // Empty the province selector.
  var selector = $('#' + selector_id);
  selector.empty();

  // Add a null option to the selector:
  var nullOption = $("<option value=''></option>");
  selector.append(nullOption);

  // Disable the selector:
  selector.attr('disabled', 'disabled');

  if (countryCode) {
    // Trigger the beginAjax event in case any other scripts want to capture it:
    selector.trigger('beginAjax');

    // Ask the user to wait:
    nullOption.text("Please wait...");

    $.get('/ajax/get-provinces/' + countryCode,
      function(response) {
        var provinces = JSON.parse(response);

        if (!$.isEmptyObject(provinces)) {
          // Enable the selector:
          selector.removeAttr('disabled');

          // Prompt the user to select a province:
          nullOption.text("Please select");

          // Get the current province from the autocomplete field
          var selectedProvince = $('#' + province_id).val();

          // Populate the selector options:
          var option;
          for (var provinceCode in provinces) {
            option = $("<option value='" + provinceCode + "'>" + provinces[provinceCode] + "</option>");
            if (provinceCode == selectedProvince) {
              option.attr('selected', 'selected');
            }
            selector.append(option);
          }
        }
        else {
          // Inform the user that there are no provinces to select:
          nullOption.text("N/A");
        }

        // Trigger the endAjax event in case any other scripts want to capture it:
        selector.trigger('endAjax');
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

    // Hide the province autocomplete field:
    $(this).hide();

    // Add the selector:
    var province_id = this.id;
    var selector_id = this.id + '-selector';
    var selector = $("<select id='" + selector_id + "'></select>");
    $(this).after(selector);

    // Whenever the selector changes, we want to set the value of the autocomplete field:
    selector.change(function() {
      $('#' + province_id).val($(this).val());
    });

    // Get the country selector id:
    var country = $(this).closest('.location').find('.location_auto_country');
    var country_id = country.attr('id');

    // Initialise the province selector:
    select_province_get(country_id, province_id, selector_id);

    // Whenever the country selector changes, update the province selector:
    country.change(function() {
      select_province_get(country_id, province_id, selector_id);
    });
  });
});
