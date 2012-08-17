(function ($) {

  $.extend($.fn, {
    boxSizing: function(value) {
      if (value === undefined) {
        // Get the box sizing:
        var boxSizing = $(this).css('box-sizing');

        // If we didn't get it, try the browser-specific property:
        if (!boxSizing) {
          if ($.browser.mozilla) {
            boxSizing = $(this).css('-moz-box-sizing');
          }
          else if ($.browser.webkit) {
            boxSizing = $(this).css('-webkit-box-sizing');
          }
          else if ($.browser.msie) {
            boxSizing = $(this).css('-ms-box-sizing');
          }
        }

        return boxSizing;
      }
      else {
        // Set the box sizing:
        $(this).css('box-sizing', value);

        // Also set the browser-specific property:
        if ($.browser.mozilla) {
          $(this).css('-moz-box-sizing', value);
        }
        else if ($.browser.webkit) {
          $(this).css('-webkit-box-sizing', value);
        }
        else if ($.browser.msie) {
          $(this).css('-ms-box-sizing', value);
        }

        // Return a jQuery object so we can chain stuff:
        return $(this);
      }
    },

    // General purpose method for getting/setting the total size of a dimension (padding, border, margin).
    dimension: function(type, direction, value) {

      // Get the dimensions of interest based on the direction:
      if (direction == 'width') {
        var dimension1 = 'left';
        var dimension2 = 'right';
      }
      else {
        var dimension1 = 'top';
        var dimension2 = 'bottom';
      }

      if (value === undefined) {
        // Get the size of the dimension in pixels.
        var box = $(this)[type]();
        return box[dimension1] + box[dimension2];
      }
      else {
        // Set the total size of the dimension in pixels by setting each side of the dimension to half the value:
        var half = Math.round(value / 2) + 'px';
        var css = {};
        css[type + '-' + dimension1] = half;
        css[type + '-' + dimension2] = half;
        $(this).css(css);
      }
    },

    // Get/set the total padding width in pixels:
    paddingWidth: function(value) {
      return $(this).dimension('padding', 'width', value);
    },

    // Get/set the total padding height in pixels:
    paddingHeight: function(value) {
      return $(this).dimension('padding', 'height', value);
    },

    // Get/set the total border width in pixels:
    borderWidth: function(value) {
      return $(this).dimension('border', 'width', value);
    },

    // Get/set the total border height in pixels:
    borderHeight: function(value) {
      return $(this).dimension('border', 'height', value);
    },

    // Get/set the total margin width in pixels:
    marginWidth: function(value) {
      return $(this).dimension('margin', 'width', value);
    },

    // Get/set the total margin height in pixels:
    marginHeight: function(value) {
      return $(this).dimension('margin', 'height', value);
    },

    // Get/set the content width:
    contentWidth: function(value) {
      if (value === undefined) {
        // Get the width of the content in pixels.

        // This is the behaviour of jQuery's width().
        return $(this).width();
      }
      else {
        // Set the width of the content in pixels.

        // Only works with pixels - remove any units and make sure we have an int:
        var width = parseInt(value, 10);

        // Get the boxSizing:
        var boxSizing = $(this).boxSizing();

        switch (boxSizing) {
          case 'content-box':
            // width is correct.
            break;

          case 'padding-box':
            width += $(this).paddingWidth();
            break;

          case 'border-box':
            width += $(this).paddingWidth() + $(this).borderWidth();
            break;
        }

        $(this).width(width);
      }
    },

    // Get/set the content height:
    contentHeight: function(value) {
      if (value === undefined) {
        // Get the height of the content in pixels.

        // This is the behaviour of jQuery's height().
        return $(this).height();
      }
      else {
        // Set the height of the content in pixels.

        // Only works with pixels - remove any units and make sure we have an int:
        var height = parseInt(value, 10);

        // Get the boxSizing:
        var boxSizing = $(this).boxSizing();

        switch (boxSizing) {
          case 'content-box':
            // height is correct.
            break;

          case 'padding-box':
            height += $(this).paddingHeight();
            break;

          case 'border-box':
            height += $(this).paddingHeight() + $(this).borderHeight();
            break;
        }

        $(this).height(height);
      }
    },

    // Get/set the width of the content plus padding in pixels.
    paddingBoxWidth: function(value) {
      if (value === undefined) {
        // Get the width of the content plus padding in pixels.

        // This is the behaviour of jQuery's innerWidth().
        return $(this).innerWidth();
      }
      else {
        // Set the width of the content plus padding in pixels.

        // Only works with pixels - remove any units and make sure we have an int:
        var width = parseInt(value, 10);

        // Get the boxSizing:
        var boxSizing = $(this).boxSizing();

        switch (boxSizing) {
          case 'content-box':
            width -= $(this).paddingWidth();
            break;

          case 'padding-box':
            // width is correct.
            break;

          case 'border-box':
            width += $(this).borderWidth();
            break;
        }

        $(this).width(width);
      }
    },

    // Get/set the height of the content plus padding in pixels.
    paddingBoxHeight: function(value) {
      if (value === undefined) {
        // Get the height of the content plus padding in pixels.

        // This is the behaviour of jQuery's innerHeight().
        return $(this).innerHeight();
      }
      else {
        // Set the height of the content plus padding in pixels.

        // Only works with pixels - remove any units and make sure we have an int:
        var height = parseInt(value, 10);

        // Get the boxSizing:
        var boxSizing = $(this).boxSizing();

        switch (boxSizing) {
          case 'content-box':
            height -= $(this).paddingHeight();
            break;

          case 'padding-box':
            // height is correct.
            break;

          case 'border-box':
            height += $(this).borderHeight();
            break;
        }

        $(this).height(height);
      }
    },

    // Get/set the width of the content + padding + border in pixels.
    borderBoxWidth: function(value) {
      if (value === undefined) {
        // Get the width of the content + padding + border in pixels.

        // This is the behaviour of jQuery's outerWidth() without including margins:
        return $(this).outerWidth();
      }
      else {
        // Set the width of the content + padding + border in pixels.

        // Only works with pixels - remove any units and make sure we have an int:
        var width = parseInt(value, 10);

        // Get the boxSizing:
        var boxSizing = $(this).boxSizing();

        switch (boxSizing) {
          case 'content-box':
            width -= $(this).paddingWidth() + $(this).borderWidth();
            break;

          case 'padding-box':
            width -= $(this).borderWidth();
            break;

          case 'border-box':
            // width is correct.
            break;
        }

        $(this).width(width);
      }
    },

    // Get/set the height of the content + padding + border in pixels.
    borderBoxHeight: function(value) {
      if (value === undefined) {
        // Get the height of the content + padding + border in pixels.

        // This is the behaviour of jQuery's outerHeight() without including margins:
        return $(this).outerHeight();
      }
      else {
        // Set the height of the content + padding + border in pixels.

        // Only works with pixels - remove any units and make sure we have an int:
        var height = parseInt(value, 10);

        // Get the boxSizing:
        var boxSizing = $(this).boxSizing();

        switch (boxSizing) {
          case 'content-box':
            height -= $(this).paddingHeight() + $(this).borderHeight();
            break;

          case 'padding-box':
            height -= $(this).borderHeight();
            break;

          case 'border-box':
            // height is correct.
            break;
        }

        $(this).height(height);
      }
    },

    // Get/set the width of the content + padding + border + margin in pixels.
    marginBoxWidth: function(value) {
      if (value === undefined) {
        // Get the width of the content + padding + border + margin in pixels.

        // This is the behaviour of jQuery's outerWidth() including margins:
        return $(this).outerWidth(true);
      }
      else {
        // Set the width of the content + padding + border + margin in pixels.

        // Only works with pixels - remove any units and make sure we have an int:
        var width = parseInt(value, 10);

        // Get the boxSizing model:
        var boxSizing = $(this).boxSizing();

        switch (boxSizing) {
          case 'content-box':
            width -= $(this).paddingWidth() + $(this).borderWidth() + $(this).marginWidth();
            break;

          case 'padding-box':
            width -= $(this).borderWidth() + $(this).marginWidth();
            break;

          case 'border-box':
            width -= $(this).marginWidth();
            break;
        }

        $(this).width(width);
      }
    },

    // Get/set the height of the content + padding + border + margin in pixels.
    marginBoxHeight: function(value) {
      if (value === undefined) {
        // Get the height of the content + padding + border + margin in pixels.

        // This is the behaviour of jQuery's outerHeight() including margins:
        return $(this).outerHeight(true);
      }
      else {
        // Set the height of the content + padding + border + margin in pixels.

        // Only works with pixels - remove any units and make sure we have an int:
        var height = parseInt(value, 10);

        // Get the boxSizing model:
        var boxSizing = $(this).boxSizing();

        switch (boxSizing) {
          case 'content-box':
            height -= $(this).paddingHeight() + $(this).borderHeight() + $(this).marginHeight();
            break;

          case 'padding-box':
            height -= $(this).borderHeight() + $(this).marginHeight();
            break;

          case 'border-box':
            var margin = $(this).margin();
            height -= $(this).marginHeight();
            break;
        }

        $(this).height(height);
      }
    }

  });

})(jQuery);
