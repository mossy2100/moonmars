(function ($) {

  // Initialise a handy object:
  $.autoresize = {};

  // Initialise the counter:
  $.autoresize.divIndex = 0;

  $.extend($.fn, {
      autoresize: function () {
        // Get the textarea
        var textarea = $(this);

        // Create the resize div:
        $.autoresize.divIndex++;
        var autoresizeDivId = 'autoresize-div-' + $.autoresize.divIndex;
        var autoresizeDiv = $("<div id='" + autoresizeDivId + "'></div>");
        textarea.attr('data-autoresize-div-id', autoresizeDivId);
        textarea.after(autoresizeDiv);

        // Copy the style of the textarea to the div.
        // @todo Make this leaner, it adds a fuckload of inline CSS to the download.
        var textareaStyle = textarea.getStyleObject();
        var divStyle = autoresizeDiv.getStyleObject();
        var textareaValue, divValue, propertyLower, styleObject = {};
        for (var property in textareaStyle) {
          // Ignore some irrelevant properties:
          propertyLower = property.toLowerCase();
          if (propertyLower.indexOf('color') > -1 || propertyLower.indexOf('background') > -1 ||
              propertyLower.indexOf('radius') > -1 || propertyLower.indexOf('shadow') > -1) {
            continue;
          }
          // Compare properties and look for differences to apply to the div:
          textareaValue = textareaStyle[property];
          divValue = divStyle[property];
          if (textareaValue != divValue) {
            styleObject[property] = textareaValue;
          }
        }

        // Set the div style:
        styleObject.height = 'auto';
        styleObject.display = 'none';
        autoresizeDiv.css(styleObject);

        // Make the widths match:
        autoresizeDiv.outerWidth(textarea.outerWidth());

        // Capture keyup events:
        textarea.bind('keyup', function() {
          var text = $(this).val();
          autoresizeDivId = textarea.attr('data-autoresize-div-id');
          autoresizeDiv = $('#' + autoresizeDivId);

          // Set the text in the div:
          autoresizeDiv.html(text + "\n\n");

          // Copy the outer height of the textarea from the div.
          // Depends on jquery.setouter.js, which in turn depends on jquery.sizes.js.
          textarea.outerHeight(autoresizeDiv.outerHeight());
        });

        // Trigger it once to initialise the textarea height:
        textarea.trigger('keyup');
      }
    }
  );

})(jQuery);
