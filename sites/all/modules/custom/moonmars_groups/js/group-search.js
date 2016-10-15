var $ = jQuery;

$(function() {
  // Set the state of the select all checkbox.
  setStateSelectAll();

  // Set behaviour of select all checkbox.
  $('input#groups-select-all').click(function() {
    var selectAll = $(this).checked();
    $('td.search-col-follower input:checkbox').check(selectAll);
  });

  // Set behaviour of membership checkboxes:
  $('td.search-col-follower input:checkbox').click(function() {
    // Set the state of the select all checkbox:
    setStateSelectAll();
  });
});

function setStateSelectAll() {
  var allSelected = $('td.search-col-follower input:checkbox').length == $('td.search-col-follower input:checkbox:checked').length;
  $('input#groups-select-all').check(allSelected);
}

function clearGroupSearchForm() {
  $('#edit-text').val('');
  $('#edit-type input:checkbox').uncheck();
  $('#edit-size').val(0);
  $('#edit-member').val('');
  $('#edit-is-member input:radio').uncheck();
  $('#edit-is-member-1').check();
}

/**
 * Set the member to the logged-in member.
 */
function setMemberToMe() {
  $('#edit-member').val(Drupal.settings.moonmars_members.username);
}
