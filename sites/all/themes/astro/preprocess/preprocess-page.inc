<?php

function astro_alpha_preprocess_page(&$vars) {
  // Include the jQuery Tools javascript, which has the tooltip code.
  drupal_add_css('/sites/all/libraries/jquery/tipTip/tipTip.css');
  drupal_add_js('/sites/all/libraries/jquery/tipTip/jquery.tipTip.js');
}
