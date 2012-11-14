<?php
/**
 * @file
 * rates_relation.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function rates_relation_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "relation" && $api == "relation_type_default") {
    return array("version" => "1");
  }
}
