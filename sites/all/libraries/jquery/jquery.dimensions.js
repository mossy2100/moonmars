(function ($) {

  $.extend($.fn, {
    boxSizing: function () {
      // Try CSS3:
      var boxSizing = $(this).css('box-sizing');
      if (!boxSizing) {
        if ($.browser.mozilla) {
          // Try Mozilla:
          boxSizing = $(this).css('-moz-box-sizing');
        }
        else if ($.browser.webkit) {
          // Try Webkit:
          boxSizing = $(this).css('-webkit-box-sizing');
        }
        else if ($.browser.msie) {
          // Try MSIE:
          boxSizing = $(this).css('-ms-box-sizing');
        }
      }
      return boxSizing;
    },

    innerHeight: function(newInnerHeight) {
      if (newInnerHeight === undefined) {
        // Get the inner height:
        return $(this).height();
      }
      else {
        // Set the inner height:
        var boxSizing = $(this).boxSizing();
        var height = parseInt(newInnerHeight);
        if (boxSizing != 'content-box') {
          var padding = $(this).padding();
          if (boxSizing == 'border-box') {
            var border = $(this).border();
            height += padding.top + padding.bottom + border.top + border.bottom;
          }
          else {
            // padding-box:
            height += padding.top + padding.bottom;
          }
        }
        $(this).height(height);
      }
    },

    innerWidth: function(newInnerWidth) {
      if (newInnerWidth === undefined) {
        // Get the inner width:
        return $(this).width();
      }
      else {
        // Set the inner width:
        var boxSizing = $(this).boxSizing();
        var width = parseInt(newInnerWidth);
        if (boxSizing != 'content-box') {
          var padding = $(this).padding();
          if (boxSizing == 'border-box') {
            var border = $(this).border();
            width += padding.top + padding.bottom + border.top + border.bottom;
          }
          else {
            // padding-box:
            width += padding.top + padding.bottom;
          }
        }
        $(this).width(width);
      }
    },

    outerHeight: function(newOuterHeight) {
      if (newOuterHeight === undefined) {
        // Get the outer height:
        var padding = $(this).padding();
        var border = $(this).border();
        return $(this).height() + padding.top + padding.bottom + border.top + border.bottom;
      }
      else {
        // Set the outer height:
        var boxSizing = $(this).boxSizing();
        var height = parseInt(newOuterHeight);
        if (boxSizing != 'border-box') {
          var border = $(this).border();
          if (boxSizing == 'content-box') {
            var padding = $(this).padding();
            height -= (padding.top + padding.bottom + border.top + border.bottom);
          }
          else {
            // padding-box:
            height -= (border.top + border.bottom);
          }
        }
        $(this).height(height);
      }
    },

    outerWidth: function(newOuterWidth) {
      if (newOuterWidth === undefined) {
        // Get the outer width:
        var padding = $(this).padding();
        var border = $(this).border();
        return $(this).width() + padding.top + padding.bottom + border.top + border.bottom;
      }
      else {
        // Set the outer width:
        var boxSizing = $(this).boxSizing();
        var width = parseInt(newOuterWidth);
        if (boxSizing != 'border-box') {
          var border = $(this).border();
          if (boxSizing == 'content-box') {
            var padding = $(this).padding();
            width -= (padding.top + padding.bottom + border.top + border.bottom);
          }
          else {
            // padding-box:
            width -= (border.top + border.bottom);
          }
        }
        $(this).width(width);
      }
    }
  });

})(jQuery);
