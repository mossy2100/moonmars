var $ = jQuery;

$(function() {
  resizeEditor();
  $(window).resize(resizeEditor);

  alert($('table.cke_editor td.cke_contents').length);

  window.setTimeout(function() {
    alert($('table.cke_editor td.cke_contents').length);
  }, 1000);




});

function resizeEditor() {
  var formWidth = $('form#group-node-form').innerWidth();
//  alert(formWidth);
//  alert($('td.cke_contents iframe body').length);
//  $('td.cke_contents iframe').contents().find('body').outerWidth(formWidth - 20);


}
