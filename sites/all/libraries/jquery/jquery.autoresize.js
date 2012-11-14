(function ($) {

  $.extend($.fn, {

      autoresize: function() {

        // Get the textarea:
        var textarea = $(this);

        // Capture keyup events:
        textarea.keydown(function(event) {
          // We only need to resize when enter, delete or backspace is pressed.
          if (event.which == 13 || event.which == 46 || event.which == 8) {
            $(this).resize();
          }
        });

        // Initialise the textarea height:
        textarea.resize();
      },

      resize: function() {
        // Get the textarea:
        var textarea = $(this);

        // Get the number of lines:
        var text = textarea.val();
        var n_lines = text.split('\n').length + 1;

        // Get the line height:
        var lineHeight = parseInt(textarea.css('line-height'), 10);

        // Set the textarea's height to fit the number of lines:
        textarea.innerHeight(lineHeight * n_lines);
      }

    }
  );

})(jQuery);
