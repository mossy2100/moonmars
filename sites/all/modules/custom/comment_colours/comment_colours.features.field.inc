<?php
/**
 * @file
 * comment_colours.features.field.inc
 */

/**
 * Implements hook_field_default_fields().
 */
function comment_colours_field_default_fields() {
  $fields = array();

  // Exported field: 'user-user-field_background_color'.
  $fields['user-user-field_background_color'] = array(
    'field_config' => array(
      'active' => '1',
      'cardinality' => '1',
      'deleted' => '0',
      'entity_types' => array(),
      'field_name' => 'field_background_color',
      'foreign keys' => array(),
      'indexes' => array(
        'rgb' => array(
          0 => 'rgb',
        ),
      ),
      'locked' => '0',
      'module' => 'colorfield',
      'new_field_name' => 'field_background_color',
      'settings' => array(),
      'translatable' => '0',
      'type' => 'colorfield_rgb',
    ),
    'field_instance' => array(
      'bundle' => 'user',
      'default_value' => array(
        0 => array(
          'rgb' => '#e3eddf',
        ),
      ),
      'deleted' => '0',
      'description' => 'Select your preferred background colour for your comments.',
      'display' => array(
        'default' => array(
          'label' => 'above',
          'module' => 'colorfield',
          'settings' => array(),
          'type' => 'colorfield_simple_text',
          'weight' => 10,
        ),
      ),
      'entity_type' => 'user',
      'field_name' => 'field_background_color',
      'label' => 'Background colour',
      'required' => 0,
      'settings' => array(
        'text_processing' => 0,
        'user_register_form' => 0,
      ),
      'widget' => array(
        'active' => 0,
        'module' => 'colorfield',
        'settings' => array(),
        'type' => 'colorfield_colorpicker',
        'weight' => '16',
      ),
    ),
  );

  // Exported field: 'user-user-field_border_color'.
  $fields['user-user-field_border_color'] = array(
    'field_config' => array(
      'active' => '1',
      'cardinality' => '1',
      'deleted' => '0',
      'entity_types' => array(),
      'field_name' => 'field_border_color',
      'foreign keys' => array(),
      'indexes' => array(
        'rgb' => array(
          0 => 'rgb',
        ),
      ),
      'locked' => '0',
      'module' => 'colorfield',
      'new_field_name' => 'field_border_color',
      'settings' => array(),
      'translatable' => '0',
      'type' => 'colorfield_rgb',
    ),
    'field_instance' => array(
      'bundle' => 'user',
      'default_value' => array(
        0 => array(
          'rgb' => '#96b1ff',
        ),
      ),
      'deleted' => '0',
      'description' => 'Select your preferred border colour for your comments.',
      'display' => array(
        'default' => array(
          'label' => 'above',
          'module' => 'colorfield',
          'settings' => array(),
          'type' => 'colorfield_simple_text',
          'weight' => 11,
        ),
      ),
      'entity_type' => 'user',
      'field_name' => 'field_border_color',
      'label' => 'Border colour',
      'required' => 0,
      'settings' => array(
        'text_processing' => 0,
        'user_register_form' => 0,
      ),
      'widget' => array(
        'active' => 0,
        'module' => 'colorfield',
        'settings' => array(),
        'type' => 'colorfield_colorpicker',
        'weight' => '18',
      ),
    ),
  );

  // Exported field: 'user-user-field_text_color'.
  $fields['user-user-field_text_color'] = array(
    'field_config' => array(
      'active' => '1',
      'cardinality' => '1',
      'deleted' => '0',
      'entity_types' => array(),
      'field_name' => 'field_text_color',
      'foreign keys' => array(),
      'indexes' => array(
        'rgb' => array(
          0 => 'rgb',
        ),
      ),
      'locked' => '0',
      'module' => 'colorfield',
      'new_field_name' => 'field_text_color',
      'settings' => array(),
      'translatable' => '0',
      'type' => 'colorfield_rgb',
    ),
    'field_instance' => array(
      'bundle' => 'user',
      'default_value' => array(
        0 => array(
          'rgb' => '#000000',
        ),
      ),
      'deleted' => '0',
      'description' => 'Select your preferred text colour for your comments.',
      'display' => array(
        'default' => array(
          'label' => 'above',
          'module' => 'colorfield',
          'settings' => array(),
          'type' => 'colorfield_simple_text',
          'weight' => 12,
        ),
      ),
      'entity_type' => 'user',
      'field_name' => 'field_text_color',
      'label' => 'Text colour',
      'required' => 0,
      'settings' => array(
        'text_processing' => 0,
        'user_register_form' => 0,
      ),
      'widget' => array(
        'active' => 0,
        'module' => 'colorfield',
        'settings' => array(),
        'type' => 'colorfield_colorpicker',
        'weight' => '17',
      ),
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Background colour');
  t('Border colour');
  t('Select your preferred background colour for your comments.');
  t('Select your preferred border colour for your comments.');
  t('Select your preferred text colour for your comments.');
  t('Text colour');

  return $fields;
}
