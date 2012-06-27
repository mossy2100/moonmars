var $ = jQuery;

/**
 * Request provinces for a given country and update province selector.
 */
function select_province_get(country_id, selector_id) {
  // Get the selected country code:
  var countryCode = $('#' + country_id).val();

  // Empty the province selector. This seems to trigger the change() event on the selector, which in turn copies the
  // value (blank) to the autocomplete. Which is fine.
  var selector = $('#' + selector_id);
  selector.empty();

  // Get the form item:
  var formItem = selector.closest('.form-item');

  if (countryCode) {
    $.get('/ajax/get-provinces/' + countryCode,
      function(response) {
        var provinces = JSON.parse(response);

        if (!$.isEmptyObject(provinces)) {
          // Enable the selector:
          selector.enable();

          // Prompt the user to select a province:
          selector.append("<option value=''>Please select</option>");

          // Populate the selector options:
          for (var provinceCode in provinces) {
            selector.append("<option value='" + provinceCode + "'>" + provinces[provinceCode] + "</option>");
          }
        }
        else {
          // Inform the user that there are no provinces to select:
          selector.append("<option value=''>N/A</option>");

          // Disable the selector:
          selector.disable();
        }
      }
    );
  }
  else {
    // Prompt the user to select a country:
    selector.append("<option value=''>Please select country</option>");

    // Disable the selector:
    selector.disable();
  }
}

/**
 * Update the form, replacing all province autocomplete fields with selectors.
 */
function select_province_init() {
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
    var country = $(this).parents('.location').find('.location_auto_country');
    var country_id = country.attr('id');

    // Initialise the province selector:
    select_province_get(country_id, selector_id);

    // Whenever the country selector changes, update the province selector:
    country.change(function() {
      select_province_get(country_id, selector_id);
    })
  });
}

$(select_province_init);
