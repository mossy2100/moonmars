(function($) {
  
  /////////////////////////////////////////////////////////////////////////////
  // Check and uncheck functions

  // Check the selected elements:
  $.fn.check = function() {
    return this.attr('checked', 'checked');
  };
  
  // Uncheck all the selected elements:
  $.fn.uncheck = function() {
    return this.removeAttr('checked');
  };
  
  // Returns whether or not the element is checked:
  $.fn.checked = function() {
    return this.is(':checked');
  };
  
  // Returns whether or not the element is unchecked:
  $.fn.unchecked = function() {
    return !this.checked();
  };


  /////////////////////////////////////////////////////////////////////////////
  // Enable and disable functions

  // Disable all the selected elements:
  $.fn.disable = function() {
    return this.attr('disabled', 'disabled');
  };

  // Enable all the selected elements:
  $.fn.enable = function() {
    return this.removeAttr('disabled');
  };

  // Returns whether or not the element is enabled:
  $.fn.disabled = function() {
    return this.is(':disabled');
  };

  // Returns whether or not the element is enabled:
  $.fn.enabled = function() {
    return !this.disabled();
  };

})(jQuery);
