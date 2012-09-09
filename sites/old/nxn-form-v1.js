var $ = jQuery;

$(function() {
  // If a tab was specified, select it:
  if (tab) {
    var tabLink = $('.horizontal-tab-button a strong').each(function() {
      if ($(this).text().toLowerCase() == tab.toLowerCase()) {
        // Click the tab:
        $(this).closest('a').click();
        // We're done:
        return false;
      }
    });
  }

  // Remove all N/A radio buttons:
  $('input.form-radio[value=_none]').parent().remove();

  // TEMPORARY. Remove all topic checkboxes.
  $('input.form-checkbox[value=topic]').parent().remove();

  // Set up the form.
  for (var nxnCategory in nxnDefaultPrefs) {
    for (var nxnKey in nxnDefaultPrefs[nxnCategory]) {
      nxnSetRadios(nxnCategory, nxnKey);
    }
  }
});

/**
 * Set default values for the radio-button/checkbox combination widgets.
 *
 * @param string nxnCategory
 * @param string nxnKey
 */
function nxnSetRadios(nxnCategory, nxnKey) {
  // Get the radio button group:
  var elementIdBase = '#edit-field-' + nxnCategory + '-' + nxnKey;
  var rbg_id = elementIdBase + '-nxn';

  // If none selected, select the default:
  if ($(rbg_id + ' .form-radio:checked').length == 0) {
    nxnSelectDefaultPref(nxnCategory, nxnKey);
  }

  // If there's a checkbox group for conditions, add behaviours:
  var cbg_id = elementIdBase + '-cond';
  if ($(cbg_id).length) {

    // Remember the original height of the checkbox group:
    $(cbg_id).attr('data-height', $(cbg_id).height());

    // If 'some' not selected, hide the checkbox group:
    if ($(rbg_id + ' .form-radio:checked').val() != 'some') {
      $(cbg_id).hide();
    }

    $(rbg_id + ' .form-radio').click(function() {
      if ($(this).val() == 'some' && !$(cbg_id).is(':visible')) {
        $(cbg_id).height(0).show().animate({
          height: $(cbg_id).attr('data-height')
        }, 333, function() {
          // If no checkboxes are selected, select them all by default:
          if ($(cbg_id + ' .form-checkbox:checked').length == 0) {
            $(cbg_id + ' .form-checkbox').check();
          }
        });
      }
      else if ($(this).val() != 'some' && $(cbg_id).is(':visible')) {
        $(cbg_id).animate({
          height: 0
        }, 333, function() {
          $(cbg_id).hide();
        });
      }
    });
  }
}

/**
 * Select options to receive all notifications.
 */
function nxnSelectAll() {
  $('fieldset.group-tab-nxns .form-radio[value=all]').check().click();
}

/**
 * Select options to receive no notifications.
 */
function nxnSelectNone() {
  $('fieldset.group-tab-nxns .form-radio[value=none]').check().click();
}

/**
 * Select options to receive default notifications.
 */
function nxnSelectDefault() {
  for (var nxnCategory in nxnDefaultPrefs) {
    for (var nxnKey in nxnDefaultPrefs[nxnCategory]) {
      nxnSelectDefaultPref(nxnCategory, nxnKey);
    }
  }
}

/**
 * Select default preferences for a given notification, specified by category and key.
 *
 * @param string nxnCategory
 * @param string nxnKey
 */
function nxnSelectDefaultPref(nxnCategory, nxnKey) {
  var nxnPref = nxnDefaultPrefs[nxnCategory][nxnKey];

  var value;
  if (nxnPref === true) {
    value = 'all';
  }
  else if (nxnPref === false) {
    value = 'none';
  }
  else {
    value = 'some';
  }

  // Select the radio button:
  var elementIdBase = '#edit-field-' + nxnCategory + '-' + nxnKey;
  $(elementIdBase + '-nxn input.form-radio[value=' + value + ']').check().click();

  if (value == 'some') {
    // Check and uncheck the condition checkboxes:
    for (var nxnCondition in nxnPref) {
      $(elementIdBase + '-cond .form-checkbox[value=' + nxnCondition + ']').check(nxnPref[nxnCondition]);
    }
  }
}
