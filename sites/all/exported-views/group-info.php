<?php
$view = new view();
$view->name = 'group_info';
$view->description = '';
$view->tag = 'default';
$view->base_table = 'node';
$view->human_name = 'Group info';
$view->core = 7;
$view->api_version = '3.0';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

/* Display: Master */
$handler = $view->new_display('default', 'Master', 'default');
$handler->display->display_options['use_more_always'] = FALSE;
$handler->display->display_options['access']['type'] = 'perm';
$handler->display->display_options['cache']['type'] = 'none';
$handler->display->display_options['query']['type'] = 'views_query';
$handler->display->display_options['exposed_form']['type'] = 'basic';
$handler->display->display_options['pager']['type'] = 'some';
$handler->display->display_options['pager']['options']['items_per_page'] = '1';
$handler->display->display_options['style_plugin'] = 'default';
$handler->display->display_options['row_plugin'] = 'fields';
/* Field: Content: Logo */
$handler->display->display_options['fields']['field_logo']['id'] = 'field_logo';
$handler->display->display_options['fields']['field_logo']['table'] = 'field_data_field_logo';
$handler->display->display_options['fields']['field_logo']['field'] = 'field_logo';
$handler->display->display_options['fields']['field_logo']['label'] = '';
$handler->display->display_options['fields']['field_logo']['element_label_colon'] = FALSE;
$handler->display->display_options['fields']['field_logo']['click_sort_column'] = 'fid';
$handler->display->display_options['fields']['field_logo']['settings'] = array(
  'image_style' => 'sidebar-logo-90-wide',
  'image_link' => '',
);
/* Field: Content: Type */
$handler->display->display_options['fields']['field_group_type']['id'] = 'field_group_type';
$handler->display->display_options['fields']['field_group_type']['table'] = 'field_data_field_group_type';
$handler->display->display_options['fields']['field_group_type']['field'] = 'field_group_type';
/* Field: Field: Score */
$handler->display->display_options['fields']['field_score']['id'] = 'field_score';
$handler->display->display_options['fields']['field_score']['table'] = 'field_data_field_score';
$handler->display->display_options['fields']['field_score']['field'] = 'field_score';
$handler->display->display_options['fields']['field_score']['element_type'] = 'span';
$handler->display->display_options['fields']['field_score']['element_class'] = 'score score-node-!1';
$handler->display->display_options['fields']['field_score']['empty'] = '0';
$handler->display->display_options['fields']['field_score']['settings'] = array(
  'thousand_separator' => ' ',
  'prefix_suffix' => 0,
);
/* Field: PHP: Social Links */
$handler->display->display_options['fields']['php']['id'] = 'php';
$handler->display->display_options['fields']['php']['table'] = 'views';
$handler->display->display_options['fields']['php']['field'] = 'php';
$handler->display->display_options['fields']['php']['ui_name'] = 'PHP: Social Links';
$handler->display->display_options['fields']['php']['label'] = '';
$handler->display->display_options['fields']['php']['element_label_colon'] = FALSE;
$handler->display->display_options['fields']['php']['use_php_setup'] = 0;
$handler->display->display_options['fields']['php']['php_output'] = '<?php
echo \\AstroMultimedia\\MoonMars\\Group::create($data->nid)->renderLinks();
?>';
$handler->display->display_options['fields']['php']['use_php_click_sortable'] = '0';
$handler->display->display_options['fields']['php']['php_click_sortable'] = '';
/* Sort criterion: Content: Post date */
$handler->display->display_options['sorts']['created']['id'] = 'created';
$handler->display->display_options['sorts']['created']['table'] = 'node';
$handler->display->display_options['sorts']['created']['field'] = 'created';
$handler->display->display_options['sorts']['created']['order'] = 'DESC';
/* Contextual filter: Content: Nid */
$handler->display->display_options['arguments']['nid']['id'] = 'nid';
$handler->display->display_options['arguments']['nid']['table'] = 'node';
$handler->display->display_options['arguments']['nid']['field'] = 'nid';
$handler->display->display_options['arguments']['nid']['default_action'] = 'default';
$handler->display->display_options['arguments']['nid']['default_argument_type'] = 'node';
$handler->display->display_options['arguments']['nid']['summary']['number_of_records'] = '0';
$handler->display->display_options['arguments']['nid']['summary']['format'] = 'default_summary';
$handler->display->display_options['arguments']['nid']['summary_options']['items_per_page'] = '25';
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
  'group' => 'group',
);

/* Display: Block */
$handler = $view->new_display('block', 'Block', 'block');
$handler->display->display_options['defaults']['hide_admin_links'] = FALSE;
