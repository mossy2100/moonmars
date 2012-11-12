var $ = jQuery;

$(function() {
  waitUntilEditorReady();
});

function waitUntilEditorReady() {
  if ($('table.cke_editor td.cke_contents iframe').contents().find('body').length) {
    // Check again in 100ms:
    window.setTimeout(waitUntilEditorReady, 100);
    return;
  }
  else {
    // Editor is ready:
    initEditor();
  }
}

function initEditor() {
  // Initialise the editor width:
  setEditorWidth();

  // Resize the editor if the window is resized:
  $(window).resize(setEditorWidth);

//  // Update the height when the editor contents changes:
//  var editor = $('#edit-field-description-und-0-value').CKEditor();
//  editor.on('key', function() {
//    console.log('key pressed');
//    setEditorHeight();
//  });
}

function setEditorWidth() {
  var formWidth = $('form#group-node-form').contentWidth();
  $('table.cke_editor td.cke_contents iframe').borderBoxWidth(formWidth);
//  setEditorHeight();
}

function setEditorHeight() {
  var editorContentHeight = $('table.cke_editor td.cke_contents iframe').contents().find('body').height();
  $('table.cke_editor td.cke_contents').contentHeight(editorContentHeight + 16);
}
