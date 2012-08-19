<?php
/**
 * @file
 * subscriptions_and_notifications.features.menu_links.inc
 */

/**
 * Implements hook_menu_default_menu_links().
 */
function subscriptions_and_notifications_menu_default_menu_links() {
  $menu_links = array();

  // Exported menu link: user-menu:activity
  $menu_links['user-menu:activity'] = array(
    'menu_name' => 'user-menu',
    'link_path' => 'activity',
    'router_path' => 'activity',
    'link_title' => 'Activity',
    'options' => array(
      'attributes' => array(
        'title' => 'View items from the channels you\'re subscribed to.',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-50',
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('Activity');


  return $menu_links;
}
