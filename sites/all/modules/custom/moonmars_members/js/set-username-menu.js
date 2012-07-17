var $ = jQuery;


$(function() {
  if (Drupal.settings.moonmars_members.username) {
    $('#secondary-menu').after("<span id='nav-username'>" + Drupal.settings.moonmars_members.username + "</span>");
  }
});
