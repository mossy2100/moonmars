<?php
/**
 * @file
 * social_links_and_groups_update.features.filter.inc
 */

/**
 * Implements hook_filter_default_formats().
 */
function social_links_and_groups_update_filter_default_formats() {
  $formats = array();

  // Exported format: Simple.
  $formats['simple'] = array(
    'format' => 'simple',
    'name' => 'Simple',
    'cache' => '1',
    'status' => '1',
    'weight' => '0',
    'filters' => array(
      'filter_url' => array(
        'weight' => '-49',
        'status' => '1',
        'settings' => array(
          'filter_url_length' => '72',
        ),
      ),
      'filter_html' => array(
        'weight' => '-48',
        'status' => '1',
        'settings' => array(
          'allowed_html' => '<a> <em> <i> <strong> <b> <blockquote> <ul> <ol> <li> <h2> <h3> <h4> <img> <p> <br> <div> <span>',
          'filter_html_help' => 0,
          'filter_html_nofollow' => 0,
        ),
      ),
      'filter_autop' => array(
        'weight' => '-40',
        'status' => '1',
        'settings' => array(),
      ),
      'filter_htmlcorrector' => array(
        'weight' => '-36',
        'status' => '1',
        'settings' => array(),
      ),
    ),
  );

  return $formats;
}
