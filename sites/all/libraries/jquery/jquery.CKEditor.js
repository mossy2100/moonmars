(function ($) {

  $.extend($.fn, {
    CKEditor: function() {

      for (var instanceName in CKEDITOR.instances) {
        if (CKEDITOR.instances[instanceName].name == $(this).attr('id')) {
          // Found:
          return CKEDITOR.instances[instanceName];
        }
      }

      // Not found:
      return undefined;

    }
  });

})(jQuery);
