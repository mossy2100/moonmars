<?php
/**
 * @file
 * subscriptions_and_notifications.relation_type_default.inc
 */

/**
 * Implements hook_relation_default_relation_types().
 */
function subscriptions_and_notifications_relation_default_relation_types() {
  $export = array();

  $relation_type = new stdClass();
  $relation_type->disabled = FALSE; /* Edit this to true to make a default relation_type disabled initially */
  $relation_type->api_version = 1;
  $relation_type->relation_type = 'has_subscriber';
  $relation_type->label = 'channel has subscriber';
  $relation_type->reverse_label = 'is subscribed to';
  $relation_type->directional = 1;
  $relation_type->transitive = 0;
  $relation_type->r_unique = 0;
  $relation_type->min_arity = 2;
  $relation_type->max_arity = 2;
  $relation_type->source_bundles = array(
    0 => 'node:channel',
  );
  $relation_type->target_bundles = array(
    0 => 'user:user',
  );
  $export['has_subscriber'] = $relation_type;

  return $export;
}
