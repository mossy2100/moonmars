<?php

/**
 * Process function for regions.
 *
 * @param $vars
 */
function astro_alpha_process_region(&$vars) {
  if ($vars['elements']['#region'] == 'menu') {
    // If the logged-in member is on one of their own pages...
    if (moonmars_members_on_own_page()) {

      // Remove 'active' class from all links in the main menu:
      foreach ($vars['main_menu'] as &$item) {
        if (isset($item['attributes']['class'])) {
          $item['attributes']['class'] = array_diff($item['attributes']['class'], ['active']);
          break;
        }
      }

      // Add 'active' class to the Profile link:
      foreach ($vars['secondary_menu'] as &$item) {
        if ($item['title'] == 'Profile') {
          $item['attributes']['class'][] = 'active';
          break;
        }
      }
    }
  }
}
