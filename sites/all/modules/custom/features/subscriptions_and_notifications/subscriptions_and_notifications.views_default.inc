<?php
/**
 * @file
 * subscriptions_and_notifications.views_default.inc
 */

/**
 * Implements hook_views_default_views().
 */
function subscriptions_and_notifications_views_default_views() {
  $export = array();

  $view = new view;
  $view->name = 'notifications';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'node';
  $view->human_name = 'Notifications';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Notifications';
  $handler->display->display_options['access']['type'] = 'perm';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['query']['options']['query_comment'] = FALSE;
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '50';
  $handler->display->display_options['style_plugin'] = 'table';
  /* Field: Content: Post date */
  $handler->display->display_options['fields']['created']['id'] = 'created';
  $handler->display->display_options['fields']['created']['table'] = 'node';
  $handler->display->display_options['fields']['created']['field'] = 'created';
  $handler->display->display_options['fields']['created']['label'] = 'When';
  $handler->display->display_options['fields']['created']['alter']['alter_text'] = 0;
  $handler->display->display_options['fields']['created']['alter']['make_link'] = 0;
  $handler->display->display_options['fields']['created']['alter']['absolute'] = 0;
  $handler->display->display_options['fields']['created']['alter']['external'] = 0;
  $handler->display->display_options['fields']['created']['alter']['replace_spaces'] = 0;
  $handler->display->display_options['fields']['created']['alter']['trim_whitespace'] = 0;
  $handler->display->display_options['fields']['created']['alter']['nl2br'] = 0;
  $handler->display->display_options['fields']['created']['alter']['word_boundary'] = 1;
  $handler->display->display_options['fields']['created']['alter']['ellipsis'] = 1;
  $handler->display->display_options['fields']['created']['alter']['more_link'] = 0;
  $handler->display->display_options['fields']['created']['alter']['strip_tags'] = 0;
  $handler->display->display_options['fields']['created']['alter']['trim'] = 0;
  $handler->display->display_options['fields']['created']['alter']['html'] = 0;
  $handler->display->display_options['fields']['created']['element_label_colon'] = 0;
  $handler->display->display_options['fields']['created']['element_default_classes'] = 1;
  $handler->display->display_options['fields']['created']['hide_empty'] = 0;
  $handler->display->display_options['fields']['created']['empty_zero'] = 0;
  $handler->display->display_options['fields']['created']['hide_alter_empty'] = 1;
  $handler->display->display_options['fields']['created']['date_format'] = 'medium';
  /* Field: Content: Summary */
  $handler->display->display_options['fields']['field_notification_summary']['id'] = 'field_notification_summary';
  $handler->display->display_options['fields']['field_notification_summary']['table'] = 'field_data_field_notification_summary';
  $handler->display->display_options['fields']['field_notification_summary']['field'] = 'field_notification_summary';
  $handler->display->display_options['fields']['field_notification_summary']['alter']['alter_text'] = 1;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['text'] = '[field_notification_summary-value]';
  $handler->display->display_options['fields']['field_notification_summary']['alter']['make_link'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['absolute'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['external'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['replace_spaces'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['trim_whitespace'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['nl2br'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['word_boundary'] = 1;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['ellipsis'] = 1;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['more_link'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['strip_tags'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['trim'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['html'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['element_label_colon'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['element_default_classes'] = 1;
  $handler->display->display_options['fields']['field_notification_summary']['hide_empty'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['empty_zero'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['hide_alter_empty'] = 1;
  $handler->display->display_options['fields']['field_notification_summary']['field_api_classes'] = 0;
  /* Sort criterion: Content: Post date */
  $handler->display->display_options['sorts']['created']['id'] = 'created';
  $handler->display->display_options['sorts']['created']['table'] = 'node';
  $handler->display->display_options['sorts']['created']['field'] = 'created';
  $handler->display->display_options['sorts']['created']['order'] = 'DESC';
  /* Contextual filter: Content: Author uid */
  $handler->display->display_options['arguments']['uid']['id'] = 'uid';
  $handler->display->display_options['arguments']['uid']['table'] = 'node';
  $handler->display->display_options['arguments']['uid']['field'] = 'uid';
  $handler->display->display_options['arguments']['uid']['default_action'] = 'default';
  $handler->display->display_options['arguments']['uid']['default_argument_type'] = 'current_user';
  $handler->display->display_options['arguments']['uid']['default_argument_skip_url'] = 0;
  $handler->display->display_options['arguments']['uid']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['uid']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['uid']['summary_options']['items_per_page'] = '25';
  $handler->display->display_options['arguments']['uid']['break_phrase'] = 0;
  $handler->display->display_options['arguments']['uid']['not'] = 0;
  /* Filter criterion: Content: Published */
  $handler->display->display_options['filters']['status']['id'] = 'status';
  $handler->display->display_options['filters']['status']['table'] = 'node';
  $handler->display->display_options['filters']['status']['field'] = 'status';
  $handler->display->display_options['filters']['status']['value'] = 1;
  $handler->display->display_options['filters']['status']['group'] = 1;
  $handler->display->display_options['filters']['status']['expose']['operator'] = FALSE;
  /* Filter criterion: Content: Type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'node';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['value'] = array(
    'notification' => 'notification',
  );

  /* Display: Page */
  $handler = $view->new_display('page', 'Page', 'page');
  $handler->display->display_options['path'] = 'notifications';

  /* Display: Block */
  $handler = $view->new_display('block', 'Block', 'block_1');
  $handler->display->display_options['defaults']['use_more'] = FALSE;
  $handler->display->display_options['use_more_text'] = 'View all';
  $handler->display->display_options['defaults']['pager'] = FALSE;
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '5';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['defaults']['style_plugin'] = FALSE;
  $handler->display->display_options['style_plugin'] = 'default';
  $handler->display->display_options['defaults']['style_options'] = FALSE;
  $handler->display->display_options['defaults']['row_plugin'] = FALSE;
  $handler->display->display_options['row_plugin'] = 'fields';
  $handler->display->display_options['defaults']['row_options'] = FALSE;
  $handler->display->display_options['defaults']['footer'] = FALSE;
  /* Footer: Global: PHP */
  $handler->display->display_options['footer']['php']['id'] = 'php';
  $handler->display->display_options['footer']['php']['table'] = 'views';
  $handler->display->display_options['footer']['php']['field'] = 'php';
  $handler->display->display_options['footer']['php']['empty'] = FALSE;
  $handler->display->display_options['footer']['php']['php_output'] = '<p class=\'view-all-notifications\'><a href=\'/<?php echo Member::currentMember()->alias(); ?>/notifications\'>View all</a></p>';
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Content: Post date */
  $handler->display->display_options['fields']['created']['id'] = 'created';
  $handler->display->display_options['fields']['created']['table'] = 'node';
  $handler->display->display_options['fields']['created']['field'] = 'created';
  $handler->display->display_options['fields']['created']['label'] = '';
  $handler->display->display_options['fields']['created']['alter']['alter_text'] = 0;
  $handler->display->display_options['fields']['created']['alter']['make_link'] = 0;
  $handler->display->display_options['fields']['created']['alter']['absolute'] = 0;
  $handler->display->display_options['fields']['created']['alter']['external'] = 0;
  $handler->display->display_options['fields']['created']['alter']['replace_spaces'] = 0;
  $handler->display->display_options['fields']['created']['alter']['trim_whitespace'] = 0;
  $handler->display->display_options['fields']['created']['alter']['nl2br'] = 0;
  $handler->display->display_options['fields']['created']['alter']['word_boundary'] = 1;
  $handler->display->display_options['fields']['created']['alter']['ellipsis'] = 1;
  $handler->display->display_options['fields']['created']['alter']['more_link'] = 0;
  $handler->display->display_options['fields']['created']['alter']['strip_tags'] = 0;
  $handler->display->display_options['fields']['created']['alter']['trim'] = 0;
  $handler->display->display_options['fields']['created']['alter']['html'] = 0;
  $handler->display->display_options['fields']['created']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['created']['element_default_classes'] = 1;
  $handler->display->display_options['fields']['created']['hide_empty'] = 0;
  $handler->display->display_options['fields']['created']['empty_zero'] = 0;
  $handler->display->display_options['fields']['created']['hide_alter_empty'] = 1;
  $handler->display->display_options['fields']['created']['date_format'] = 'medium';
  /* Field: Content: Summary */
  $handler->display->display_options['fields']['field_notification_summary']['id'] = 'field_notification_summary';
  $handler->display->display_options['fields']['field_notification_summary']['table'] = 'field_data_field_notification_summary';
  $handler->display->display_options['fields']['field_notification_summary']['field'] = 'field_notification_summary';
  $handler->display->display_options['fields']['field_notification_summary']['label'] = '';
  $handler->display->display_options['fields']['field_notification_summary']['alter']['alter_text'] = 1;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['text'] = '[field_notification_summary-value]';
  $handler->display->display_options['fields']['field_notification_summary']['alter']['make_link'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['absolute'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['external'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['replace_spaces'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['trim_whitespace'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['nl2br'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['word_boundary'] = 1;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['ellipsis'] = 1;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['more_link'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['strip_tags'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['trim'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['alter']['html'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['field_notification_summary']['element_default_classes'] = 1;
  $handler->display->display_options['fields']['field_notification_summary']['hide_empty'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['empty_zero'] = 0;
  $handler->display->display_options['fields']['field_notification_summary']['hide_alter_empty'] = 1;
  $handler->display->display_options['fields']['field_notification_summary']['field_api_classes'] = 0;
  $export['notifications'] = $view;

  return $export;
}
