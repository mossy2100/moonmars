var $ = jQuery;

/**
 * Constant for specifying notifications of a certain type.
 * These must match the definitions in moonmars_nxn.module.
 */
var MOONMARS_NXN_NO   = 0;
var MOONMARS_NXN_YES  = 1;
var MOONMARS_NXN_SOME = 2;

$(function() {
//  // Remove all N/A radio buttons:
//  $('input.form-radio[value=_none]').parent().remove();

//  // TEMPORARY. Remove all topic checkboxes.
//  $('input.form-checkbox[value=topic]').parent().remove();

  // Set up the form.
  for (var nxnCategory in nxnDefinitions) {
    for (var triumphType in nxnDefinitions[nxnCategory]['triumph types']) {
      nxnSetRadios(nxnCategory, triumphType);
    }
  }
});

/**
 * Set default values for the radio-button/checkbox combination widgets.
 *
 * @param string nxnCategory
 * @param string triumphType
 */
function nxnSetRadios(nxnCategory, triumphType) {
  // Get the radio button group:
  var rbg_id = '#edit-nxn-' + nxnCategory + '-' + triumphType;

  // If none selected, select the default:
  if ($(rbg_id + ' .form-radio:checked').length == 0) {
    nxnSelectDefaultPref(nxnCategory, triumphType);
  }

  // If there's a checkbox group for conditions, add behaviours:
  var cbg_id = '.form-item-nxn-' + nxnCategory + '-' + triumphType + '-cond';
  if ($(cbg_id).length) {

    // Remember the original height of the checkbox group:
    $(cbg_id).attr('data-height', $(cbg_id).height());

    // If 'Some' not selected, hide the checkbox group:
    if ($(rbg_id + ' .form-radio:checked').val() != MOONMARS_NXN_SOME) {
      $(cbg_id).hide();
    }

    // Capture radio button clicks.
    $(rbg_id + ' .form-radio').click(function() {
      if ($(this).val() == MOONMARS_NXN_SOME && !$(cbg_id).is(':visible')) {
        // 'Some' clicked but checkboxes aren't visible, so let's show them:
        $(cbg_id).height(0).show().animate({
          height: $(cbg_id).attr('data-height')
        }, 333, function() {
          // If no checkboxes are selected, select them all by default:
          if ($(cbg_id + ' .form-checkbox:checked').length == 0) {
            $(cbg_id + ' .form-checkbox').check();
          }
        });
      }
      else if ($(this).val() != MOONMARS_NXN_SOME && $(cbg_id).is(':visible')) {
        // 'None' or 'All' clicked but checkboxes are visible, so let's hide them:
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
  $('#moonmars-nxn-form .form-radio[value=' + MOONMARS_NXN_YES + ']').check().click();
}

/**
 * Select options to receive no notifications.
 */
function nxnSelectNone() {
  $('#moonmars-nxn-form .form-radio[value=' + MOONMARS_NXN_NO + ']').check().click();
}

/**
 * Select options to receive default notifications.
 */
function nxnSelectDefault() {
  for (var nxnCategory in nxnDefinitions) {
    for (var triumphType in nxnDefinitions[nxnCategory]['triumph types']) {
      nxnSelectDefaultPref(nxnCategory, triumphType);
    }
  }
}

/**
 * Select default preferences for a given notification, specified by category and key.
 *
 * @param string nxnCategory
 * @param string triumphType
 */
function nxnSelectDefaultPref(nxnCategory, triumphType) {
  // Select and click the default radio button:
  var nxn = nxnDefinitions[nxnCategory]['triumph types'][triumphType];
  var nxnWants = nxn['default'];
  var rbgId = '#edit-nxn-' + nxnCategory + '-' + triumphType;
  $(rbgId + ' .form-radio[value=' + nxnWants + ']').check().click();

  // If the default radio is 'Some'...
  if (nxnWants == MOONMARS_NXN_SOME) {
    // Check/uncheck the default condition checkboxes:
    for (var nxnCondition in nxn['conditions']) {
      if (nxn['conditions']) {
        $(rbgId + '-cond .form-checkbox[value=' + nxnCondition + ']').check(nxn['conditions'][nxnCondition]['default']);
      }
    }
  }
}
