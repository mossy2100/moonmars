(function ($) {

  $.extend($.fn, {

    /////////////////////////////////////////////////////////////////////////////
    // Check and uncheck functions

    // Check the selected elements:
    check: function () {
      return this.attr('checked', 'checked');
    },

    // Uncheck all the selected elements:
    uncheck: function () {
      return this.removeAttr('checked');
    },

    // Returns whether or not the element is checked:
    checked: function () {
      return this.is(':checked');
    },

    // Returns whether or not the element is unchecked:
    unchecked: function () {
      return !this.checked();
    },

    /////////////////////////////////////////////////////////////////////////////
    // Enable and disable functions

    // Disable all the selected elements:
    disable: function () {
      return this.attr('disabled', 'disabled');
    },

    // Enable all the selected elements:
    enable: function () {
      return this.removeAttr('disabled');
    },

    // Returns whether or not the element is enabled:
    disabled: function () {
      return this.is(':disabled');
    },

    // Returns whether or not the element is enabled:
    enabled: function () {
      return !this.disabled();
    }

  });

})(jQuery);
