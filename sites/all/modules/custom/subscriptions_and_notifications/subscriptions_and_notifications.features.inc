<?php
/**
 * @file
 * subscriptions_and_notifications.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function subscriptions_and_notifications_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "relation" && $api == "relation_type_default") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_views_api().
 */
function subscriptions_and_notifications_views_api() {
  return array("version" => "3.0");
}

/**
 * Implements hook_node_info().
 */
function subscriptions_and_notifications_node_info() {
  $items = array(
    'notification' => array(
      'name' => t('Notification'),
      'base' => 'node_content',
      'description' => t('System notifications from moonmars.com.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
