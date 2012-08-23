var $ = jQuery;

$(function() {

  // Set default values for the radio-button/checkbox combination widgets:
  function nxn_set_radios(category, thing, defaultVal) {
    var rbg_id = '.form-type-radios.form-item-' + category + '-new-' + thing + 's';
    var cbg_id = '.form-type-checkboxes.form-item-' + category + '-which-' + thing + 's';

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
  nxn_set_radios('page', 'item', 'all');
  nxn_set_radios('page', 'comment', 'all');
  nxn_set_radios('followee', 'item', 'all');
  nxn_set_radios('followee', 'comment', 'all');
  nxn_set_radios('group', 'item', 'all');
  nxn_set_radios('group', 'comment', 'all');
});

function notificationsFormSelectEverything() {
  $('.form-checkbox').check();
  $('.form-radio[value=all]').check().click();
}

function notificationsFormSelectNothing() {
  $('.form-checkbox').uncheck();
  $('.form-radio[value=none]').check().click();
}

function notificationsFormSelectDefault() {
  // Default site settings:
  $('#edit-site-new-members-none').check().click();
  $('#edit-site-new-groups-all').check().click();
  $('#edit-site-new-items-some').check().click();
  $('#edit-site-which-items .form-checkbox').check();
  $('#edit-site-new-comments-some').check().click();
  $('#edit-site-which-comments .form-checkbox').check();

  // Default settings for my channel:
  $('#edit-page-new-items-all').check().click();
  $('#edit-page-new-comments-all').check().click();

  // Default settings for my followees' channels:
  $('#edit-followee-new-items-all').check().click();
  $('#edit-followee-new-comments-all').check().click();
  $('#edit-followee-misc .form-checkbox').check();

  // Default settings for my groups:
  $('#edit-group-new-items-all').check().click();
  $('#edit-group-new-comments-all').check().click();
  $('#edit-group-misc .form-checkbox').check();
}
