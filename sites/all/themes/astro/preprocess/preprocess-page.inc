<?php

function astro_alpha_preprocess_page(&$vars) {
  // Include the jQuery Tools javascript, which has the tooltip code.
//  drupal_add_css('sites/all/libraries/jquery/tipTip/tipTip.css');
//  drupal_add_js('sites/all/libraries/jquery/tipTip/jquery.tipTip.js');

  // Some more lovely jQuery plugins:
  drupal_add_js('sites/all/libraries/jquery/jquery.sizes.js');
//  drupal_add_js('sites/all/libraries/jquery/jquery.dimensions.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.boolAttr.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.elastic.modified.js');

  // Star library strings:
  drupal_add_js('/sites/all/libraries/star/js/strings.js');
  drupal_add_js('/sites/all/libraries/star/js/arrays.js');
  drupal_add_js('/sites/all/libraries/star/js/debug.js');


//  dbg($vars);
  if (alias_arg(2) == 'activity') {
    $vars['title'] = 'Activity';
  }

}
