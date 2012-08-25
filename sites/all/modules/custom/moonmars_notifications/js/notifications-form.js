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

  // Set default values for the radio-button/checkbox combination widgets:
  function nxn_set_radios(category, thing, defaultVal) {
    var rbg_id = '#edit-field-' + category + '-new-' + thing + '-nxn';
    var cbg_id = '#edit-field-' + category + '-which-' + thing + '-nxn';

    // Set default value:
    if ($(rbg_id + ' .form-radio:checked').length == 0) {
      $(rbg_id + ' .form-radio[value=' + defaultVal + ']').check();

      if (defaultVal == 'some') {
        $(cbg_id + ' .form-checkbox').check();
      }
    }

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

  nxn_set_radios('site', 'group', 'all');
  nxn_set_radios('site', 'member', 'none');
  nxn_set_radios('site', 'item', 'some');
  nxn_set_radios('site', 'comment', 'some');
  nxn_set_radios('channel', 'item', 'all');
  nxn_set_radios('channel', 'comment', 'all');
  nxn_set_radios('followee', 'item', 'all');
  nxn_set_radios('followee', 'comment', 'all');
  nxn_set_radios('group', 'item', 'all');
  nxn_set_radios('group', 'comment', 'all');
});

/**
 * Select options to receive no notifications.
 */
function notificationsFormSelectNothing() {
  $('fieldset.group-tab-nxns .form-checkbox').uncheck();
  $('fieldset.group-tab-nxns .form-radio[value=none]').check().click();
}

/**
 * Select options to receive default notifications.
 */
function notificationsFormSelectDefault() {
  // Default site settings:
  $('#edit-field-site-new-member-nxn input.form-radio[value=none]').check().click();
  $('#edit-field-site-new-group-nxn input.form-radio[value=all]').check().click();
  $('#edit-field-site-new-item-nxn input.form-radio[value=some]').check().click();
  $('#edit-field-site-which-item-nxn .form-checkbox').check();
  $('#edit-field-site-new-comment-nxn input.form-radio[value=some]').check().click();
  $('#edit-field-site-which-comment-nxn .form-checkbox').check();
  $('#edit-field-site-misc-nxn .form-checkbox').check();

  // Default settings for my channel:
  $('#edit-field-channel-new-item-nxn input.form-radio[value=all]').check().click();
  $('#edit-field-channel-new-comment-nxn input.form-radio[value=all]').check().click();

  // Default settings for my followees' channels:
  $('#edit-field-followee-new-item-nxn input.form-radio[value=all]').check().click();
  $('#edit-field-followee-new-comment-nxn input.form-radio[value=all]').check().click();
  $('#edit-field-followee-misc-nxn .form-checkbox').check();

  // Default settings for my groups:
  $('#edit-field-group-new-item-nxn input.form-radio[value=all]').check().click();
  $('#edit-field-group-new-comment-nxn input.form-radio[value=all]').check().click();
  $('#edit-field-group-misc-nxn .form-checkbox').check();
}

/**
 * Select options to receive all notifications.
 */
function notificationsFormSelectEverything() {
  $('fieldset.group-tab-nxns .form-checkbox').check();
  $('fieldset.group-tab-nxns .form-radio[value=all]').check().click();
}
