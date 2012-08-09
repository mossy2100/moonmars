/**
 * @file
 * Javascript for Field Example.
 */

/**
 * Provides a farbtastic colorpicker for the fancier widget.
 */
(function ($) {
  Drupal.behaviors.colorfield_colorpicker = {
    attach: function(context) {
      $(".edit-colorfield-colorpicker").ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).val('#'+hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            $(this).ColorPickerSetColor(this.value);
        }
    })
    .bind('keyup', function(){
        $(this).ColorPickerSetColor(this.value);
    });
    }
  }
})(jQuery);
