<?php
/**
 * @file
 * comment_colours.field_group.inc
 */

/**
 * Implements hook_field_group_info().
 */
function comment_colours_field_group_info() {
  $export = array();

  $field_group = new stdClass();
  $field_group->disabled = FALSE; /* Edit this to true to make a default field_group disabled initially */
  $field_group->api_version = 1;
  $field_group->identifier = 'group_colours|user|user|form';
  $field_group->group_name = 'group_colours';
  $field_group->entity_type = 'user';
  $field_group->bundle = 'user';
  $field_group->mode = 'form';
  $field_group->parent_name = '';
  $field_group->data = array(
    'label' => 'Colours',
    'weight' => '15',
    'children' => array(
      0 => 'field_background_color',
      1 => 'field_border_color',
      2 => 'field_text_color',
    ),
    'format_type' => 'fieldset',
    'format_settings' => array(
      'formatter' => 'collapsible',
      'instance_settings' => array(
        'description' => '',
        'classes' => '',
        'required_fields' => 1,
      ),
    ),
  );
  $export['group_colours|user|user|form'] = $field_group;

  return $export;
}
