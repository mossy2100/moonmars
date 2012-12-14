var $ = jQuery;

$(function() {
  // Set the state of the select all checkbox.
  setStateSelectAll();

  // Set behaviour of select all checkbox.
  $('input#members-select-all').click(function() {
    var selectAll = $(this).checked();
    $('td.search-col-star input:checkbox').check(selectAll);
  });

  // Set behaviour of membership checkboxes:
  $('td.search-col-star input:checkbox').click(function() {
    // Set the state of the select all checkbox:
    setStateSelectAll();
  });
});

function setStateSelectAll() {
  var allSelected = $('td.search-col-star input:checkbox').length == $('td.search-col-star input:checkbox:checked').length;
  $('input#members-select-all').check(allSelected);
}

function clearMemberSearchForm() {
  $('#edit-text').val('');

  $('#edit-follows input:radio').uncheck();
  $('#edit-follows-1').check();
  $('#edit-followee').val('');

  $('#edit-is-followed-by input:radio').uncheck();
  $('#edit-is-followed-by-1').check();
  $('#edit-follower').val('');

  $('#edit-is-member input:radio').uncheck();
  $('#edit-is-member-1').check();
  $('#edit-group').val('');
}

/**
 * Set the follower to the logged-in member.
 */
function setFollowerToMe() {
  $('#edit-follower').val(Drupal.settings.moonmars_members.username);
}

/**
 * Set the followee to the logged-in member.
 */
function setFolloweeToMe() {
  $('#edit-followee').val(Drupal.settings.moonmars_members.username);
}
