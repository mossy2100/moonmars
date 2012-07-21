<?php

/**
 * Preprocess function for nodes.
 * Simply looks for and calls the preprocess function for the given node type.
 *
 * @param $vars
 */
function astro_alpha_preprocess_node(&$vars) {

  // Get the node:
  $node = $vars['node'];

  // Look for the preprocess file for this node type:
  $include_path = DRUPAL_ROOT . '/' . drupal_get_path('theme', 'astro') . "/preprocess/preprocess-node-{$node->type}.inc";
  if (file_exists($include_path)) {
    require_once $include_path;
    $function = "astro_alpha_preprocess_node_{$node->type}";
    if (function_exists($function)) {
      $function($vars);
    }
  }

}
