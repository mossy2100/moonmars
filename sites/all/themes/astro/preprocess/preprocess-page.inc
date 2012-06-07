<?php

function astro_alpha_preprocess_page(&$vars) {
  // Include the jQuery Tools javascript, which has the tooltip code.
  drupal_add_css('sites/all/libraries/jquery/tipTip/tipTip.css');
  drupal_add_js('sites/all/libraries/jquery/tipTip/jquery.tipTip.js');

  // Some more lovely jQuery:
  drupal_add_js('sites/all/libraries/jquery/jquery.getStyleObject.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.sizes.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.dimensions.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.autoresize.js');

  // Star library strings:
  drupal_add_js('/sites/all/libraries/star/strings.js');
}
