(function ($) {

  // Initialise a handy object:
  $.autoresize = {};

  // Initialise the counter:
  $.autoresize.divIndex = 0;

  $.extend($.fn, {
      autoresize: function () {
        // Get the textarea
        var textarea = $(this);

        // Check if it already has a resize div attached.
        var autoresizeDivId = textarea.attr('data-autoresize-div-id');
        if (!autoresizeDivId) {
          // Create the resize div:
          $.autoresize.divIndex++;
          autoresizeDivId = 'autoresize-div-' + $.autoresize.divIndex;
          var autoresizeDiv = $("<div id='" + autoresizeDivId + "'></div>");
          textarea.attr('data-autoresize-div-id', autoresizeDivId);
          textarea.after(autoresizeDiv);
        }

        // Override the div style to match the textarea:
//        var textareaStyle = textarea.getStyleObject();
//
//        var properties = [];
//        for (prop in textareaStyle) {
//          properties[properties.length] = prop;
//        }
//        debug(properties);
//
//        var divStyle = autoresizeDiv.getStyleObject();
//        var propertyLower, styleObject = {};
//        for (var property in textareaStyle) {
//          // Ignore some irrelevant properties:
//          propertyLower = property.toLowerCase();
//          if (propertyLower.indexOf('color') > -1 || propertyLower.indexOf('opacity') > -1 || propertyLower.indexOf('background') > -1 ||
//            propertyLower.indexOf('radius') > -1 || propertyLower.indexOf('shadow') > -1) {
//            continue;
//          }
//          // Compare properties and look for differences to apply to the div:
//          if (textareaStyle[property] != divStyle[property]) {
//            styleObject[property] = textareaStyle[property];
//          }
//        }

        // Copy CSS properties from the textarea to the div, to make sure our height calcs are right.
        // This is hacky and needs to be improved.
        var prop, textareaStyleValue, autoresizeDivStyleValue, styleObject = {};
        for (var i in cssProperties) {
          prop = cssProperties[i];
          textareaStyleValue = textarea.css(prop);
          autoresizeDivStyleValue = autoresizeDiv.css(prop);
          //alert(prop + ', ' + textareaStyleValue + ', ' + autoresizeDivStyleValue);
          if (textareaStyleValue != autoresizeDivStyleValue) {
            styleObject[prop] = textareaStyleValue;
          }
        }

        // Set the div style:
        styleObject.height = 'auto';
//        styleObject.display = 'none';
        autoresizeDiv.css(styleObject);

        // Make sure the box sizing matches also:
//        autoresizeDiv.boxSizing(textarea.boxSixing());

        // Make the widths match:
        autoresizeDiv.outerWidth(textarea.outerWidth());

        // Capture keyup events:
        textarea.bind('keyup change', function () {
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


var cssProperties = [
  'borderBottomStyle',
  'borderBottomWidth',
  'borderCollapse',
  'borderLeftStyle',
  'borderLeftWidth',
  'borderRightStyle',
  'borderRightWidth',
  'borderSpacing',
  'borderTopStyle',
  'borderTopWidth',
  'bottom',
  'captionSide',
  'clear',
  'clip',
  'content',
  'counterIncrement',
  'counterReset',
  'cursor',
  'direction',
  'display',
  'emptyCells',
  'float',
  'fontFamily',
  'fontSize',
  'fontSizeAdjust',
  'fontStretch',
  'fontStyle',
  'fontVariant',
  'fontWeight',
  'height',
  'imeMode',
  'left',
  'letterSpacing',
  'lineHeight',
  'listStyleImage',
  'listStylePosition',
  'listStyleType',
  'marginBottom',
  'marginLeft',
  'marginRight',
  'marginTop',
  'markerOffset',
  'maxHeight',
  'maxWidth',
  'minHeight',
  'minWidth',
  'outlineOffset',
  'outlineStyle',
  'outlineWidth',
  'overflow',
  'overflowX',
  'overflowY',
  'paddingBottom',
  'paddingLeft',
  'paddingRight',
  'paddingTop',
  'pageBreakAfter',
  'pageBreakBefore',
  'pointerEvents',
  'position',
  'quotes',
  'resize',
  'right',
  'tableLayout',
  'textAlign',
  'textDecoration',
  'textIndent',
  'textOverflow',
  'textTransform',
  'top',
  'unicodeBidi',
  'verticalAlign',
  'visibility',
  'whiteSpace',
  'width',
  'wordSpacing',
  'wordWrap',
  'zIndex',
//  'animationDelay',
//  'animationDirection',
//  'animationDuration',
//  'animationFillMode',
//  'animationIterationCount',
//  'animationName',
//  'animationPlayState',
//  'animationTimingFunction',
//  'appearance',
//  'backfaceVisibility',
//  'binding',
//  'borderImage',
//  'boxAlign',
//  'boxDirection',
//  'boxFlex',
//  'boxOrdinalGroup',
//  'boxOrient',
//  'boxPack',
//  'boxSizing',
//  'columnCount',
//  'columnGap',
//  'columnRuleStyle',
//  'columnRuleWidth',
//  'columnWidth',
//  'floatEdge',
//  'fontFeatureSettings',
//  'fontLanguageOverride',
//  'forceBrokenImageIcon',
//  'hyphens',
//  'imageRegion',
//  'orient',
//  'perspective',
//  'perspectiveOrigin',
//  'stackSizing',
//  'tabSize',
//  'textAlignLast',
//  'textBlink',
//  'textDecorationLine',
//  'textDecorationStyle',
//  'textSizeAdjust',
//  'transform',
//  'transformOrigin',
//  'transformStyle',
//  'transitionDelay',
//  'transitionDuration',
//  'transitionProperty',
//  'transitionTimingFunction',
//  'userFocus',
//  'userInput',
//  'userModify',
//  'userSelect',
  'clipPath',
  'clipRule',
  'dominantBaseline',
  'fill',
  'fillRule',
  'filter',
  'imageRendering',
  'markerEnd',
  'markerMid',
  'markerStart',
  'mask',
  'shapeRendering',
  'stroke',
  'strokeDasharray',
  'strokeDashoffset',
  'strokeLinecap',
  'strokeLinejoin',
  'strokeMiterlimit',
  'strokeWidth',
  'textAnchor',
  'textRendering'
];
 