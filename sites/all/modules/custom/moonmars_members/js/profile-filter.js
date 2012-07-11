var $ = jQuery;

$(function() {
  // If the profile filter checkbox is clicked, submit the form automatically:
  $('#edit-profile-filter').click(function() {
    $(this).closest('form').submit();
  });
});
