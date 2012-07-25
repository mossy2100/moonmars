
$(function() {
  // Implement autotrim links:
  $('.autotrim').each(function () {
    autotrim(this);
  });

  // If the window is resized, do the autotrim again:
  $(window).resize(function () {
    $('.autotrim').each(function () {
      // Restore the original text:
      var el = $(this);
      var origText = el.attr('origText');
      if (origText) {
        el.text(origText);
        el.removeAttr('origText');
      }

      // Autotrim the element:
      autotrim(this);
    });
  })

});

function autotrim(el) {
  var el = $(el);
  var boxInnerWidth = el.parent().innerWidth();
  var text, newText;
  var i = 0;

  // Count to max 100 iterations to ensure we don't get stuck in an infinite loop:
  while (i < 100) {

    // Get the width of the element:
    var elOuterWidth = el.outerWidth();
    if (elOuterWidth <= boxInnerWidth) {
      break;
    }

    // Get the current element text:
    text = el.text();

    // If it's ridiculously short, don't bother:
    if (text.length <= 4) {
      break;
    }

    // Shrink.
    if (!el.attr('origText')) {
      // Remember the original text:
      el.attr('origText', text);

      // Remove one character and replace with ellipsis:
      newText = text.substr(0, text.length - 1) + '...';
    }
    else {
      // Remove another character, and the ellipsis we added in the previous iteration, and replace with ellipsis:
      newText = text.substr(0, text.length - 4) + '...';
    }

    // Update the text:
    el.text(newText);

    i++;
  }
}
