<?php
/**
 * @file
 * rates_relation_fields.features.field.inc
 */

/**
 * Implements hook_field_default_fields().
 */
function rates_relation_fields_field_default_fields() {
  $fields = array();

  // Exported field: 'relation-rates-field_multiplier'.
  $fields['relation-rates-field_multiplier'] = array(
    'field_config' => array(
      'active' => '1',
      'cardinality' => '1',
      'deleted' => '0',
      'entity_types' => array(),
      'field_name' => 'field_multiplier',
      'foreign keys' => array(),
      'indexes' => array(),
      'locked' => '0',
      'module' => 'number',
      'new_field_name' => 'field_multiplier',
      'settings' => array(),
      'translatable' => '0',
      'type' => 'number_integer',
    ),
    'field_instance' => array(
      'bundle' => 'rates',
      'default_value' => NULL,
      'deleted' => '0',
      'description' => 'Multiplier from 1..5 equal to the member\'s level.',
      'display' => array(
        'default' => array(
          'label' => 'above',
          'module' => 'number',
          'settings' => array(
            'decimal_separator' => '.',
            'prefix_suffix' => TRUE,
            'scale' => 0,
            'thousand_separator' => ' ',
          ),
          'type' => 'number_integer',
          'weight' => 2,
        ),
      ),
      'entity_type' => 'relation',
      'field_name' => 'field_multiplier',
      'label' => 'Multiplier',
      'required' => 1,
      'settings' => array(
        'max' => '5',
        'min' => '1',
        'prefix' => '',
        'suffix' => '',
        'user_register_form' => FALSE,
      ),
      'widget' => array(
        'active' => 0,
        'module' => 'number',
        'settings' => array(),
        'type' => 'number',
        'weight' => '2',
      ),
    ),
  );

  // Exported field: 'relation-rates-field_rating'.
  $fields['relation-rates-field_rating'] = array(
    'field_config' => array(
      'active' => '1',
      'cardinality' => '1',
      'deleted' => '0',
      'entity_types' => array(),
      'field_name' => 'field_rating',
      'foreign keys' => array(),
      'indexes' => array(),
      'locked' => '0',
      'module' => 'number',
      'new_field_name' => 'field_rating',
      'settings' => array(),
      'translatable' => '0',
      'type' => 'number_integer',
    ),
    'field_instance' => array(
      'bundle' => 'rates',
      'default_value' => NULL,
      'deleted' => '0',
      'description' => 'The rating given by the member for this entity.',
      'display' => array(
        'default' => array(
          'label' => 'above',
          'module' => 'number',
          'settings' => array(
            'decimal_separator' => '.',
            'prefix_suffix' => TRUE,
            'scale' => 0,
            'thousand_separator' => ' ',
          ),
          'type' => 'number_integer',
          'weight' => 1,
        ),
      ),
      'entity_type' => 'relation',
      'field_name' => 'field_rating',
      'label' => 'Rating',
      'required' => 1,
      'settings' => array(
        'max' => '2',
        'min' => '-2',
        'prefix' => '',
        'suffix' => '',
        'user_register_form' => FALSE,
      ),
      'widget' => array(
        'active' => 0,
        'module' => 'number',
        'settings' => array(),
        'type' => 'number',
        'weight' => '1',
      ),
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Multiplier');
  t('Multiplier from 1..5 equal to the member\'s level.');
  t('Rating');
  t('The rating given by the member for this entity.');

  return $fields;
}
