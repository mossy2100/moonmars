/*
 * getStyleObject Plugin for jQuery JavaScript Library
 * From: http://upshots.org/?p=112
 *
 * Copyright: Unknown, see source link
 * Plugin version by Dakota Schneider (http://hackthetruth.org)
 */
(function ($) {
  $.fn.getStyleObject = function () {
    var dom = this.get(0);
    var style;
    var returns = {};
    if (document.defaultView && document.defaultView.getComputedStyle) {
      var camelize = function (a, b) {
        return b.toUpperCase();
      }
      style = document.defaultView.getComputedStyle(dom, null);
      if (style) {
        for (var i = 0; i < style.length; i++) {
          var prop = style[i];
          // Remove leading '-' if present, and convert to camel case:
          var camel = prop.replace(/^\-/g, '').replace(/\-([a-z])/g, camelize);
          var val = style.getPropertyValue(prop);
          returns[camel] = val;
        }
      }
      return returns;
    }
    if (dom.currentStyle) {
      style = dom.currentStyle;
      for (var prop in style) {
        returns[prop] = style[prop];
      }
      return returns;
    }
    return this.css();
  }
})(jQuery);
