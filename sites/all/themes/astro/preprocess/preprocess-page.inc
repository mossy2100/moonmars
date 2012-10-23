<?php

function astro_alpha_preprocess_page(&$vars) {
  // Some lovely jQuery plugins:
  drupal_add_js('sites/all/libraries/jquery/jquery.sizes.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.dimensions.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.boolAttr.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.elastic.modified.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.scrollTo-1.4.2.js');
  drupal_add_js('sites/all/libraries/jquery/jquery.CKEditor.js');

  // Star library strings:
  drupal_add_js('sites/all/libraries/star/js/strings.js');
  drupal_add_js('sites/all/libraries/star/js/arrays.js');
  drupal_add_js('sites/all/libraries/star/js/debug.js');
}
