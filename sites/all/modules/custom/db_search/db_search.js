var $ = jQuery;

$(function() {
  $('#edit-search-options-1').click(function() {
    if (this.checked) {
      // Check all the others:
      $('#edit-search-options input[type=checkbox]').attr('checked', 'checked');
    }
    else {
      // Uncheck all the others:
      $('#edit-search-options input[type=checkbox]').attr('checked', '');
    }
  });
  
  $('#edit-search-options input[type=checkbox]').click(db_search_set_everything_checkbox);

  db_search_set_everything_checkbox();
});

function db_search_set_everything_checkbox() {
  // Check if the 'Everything' checkbox should be checked:
  var checkEverything = true;
  var checkboxes = $('#edit-search-options input[type=checkbox]');
  for (var i = 1; i < checkboxes.length; i++) {
    if (!checkboxes.get(i).checked) {
      checkEverything = false;
      break;
    }
  }
  // Check or uncheck the 'Everything' checkbox:
  $('#edit-search-options-1').attr('checked', checkEverything ? 'checked' : '');
}
