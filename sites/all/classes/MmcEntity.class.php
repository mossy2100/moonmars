<?php
/**
 * Static entity-related methods.
 * This could perhaps be implemented as a trait that could be given to Member, Group, Event, etc.
 */
class MmcEntity {

  /**
   * Gets an EntityBase-derived object from a Drupal entity.
   *
   * @static
   * @param $node
   * @return mixed
   */
  public static function getEntity($entity_type, $entity) {
    switch ($entity_type) {
      case 'user':
        return Member::create($entity);

      case 'node':
        // Get the node type.
        $type = is_uint($entity) ? node_get_type($entity) : $entity->type;

        // If a valid node type, create the object:
        if (in_array($type, moonmars_channels_node_types())) {
          $class = ucfirst($type);

          // Note I create the object using $entity instead of reloading the node (which would be another way of getting
          // the type), to prevent the node we just loaded from clobbering the one we have in memory.
          // My caching mechanism works better than Drupal's, unfortunately.
          return $class::create($entity);
        }
        break;
    }

    return FALSE;
  }

  /**
   * Creates a new channel for an entity.
   *
   * @param string $entity_type
   * @param int $entity_id
   * @return int
   */
  public static function createEntityChannel($entity_type, $entity_id) {
    // Get the parent entity object:
    $parent_entity = self::getEntity($entity_type, $entity_id);

    // Create the new channel:
    $channel = Channel::create()
      ->setProperties(array(
          'uid'   => $parent_entity->uid(),
          'title' => $parent_entity->channelTitle(),
        ));

    // Save the node for the first time, which will give it a nid, which we need to create the relationship:
    $channel->save();

    // Create the relationship between the entity and the relationship:
    moonmars_relationships_create_relationship('has_channel', $entity_type, $entity_id, 'node', $channel->nid(), TRUE);

    // Update the channel's alias and title:
    $channel->updateAliasAndTitle();

    // Return the Channel:
    return $channel;
  }

  /**
   * Get an entity's channel.
   *
   * @param string $entity_type
   * @param int $entity_id
   * @param bool $create
   * @return int
   */
  public static function getEntityChannel($entity_type, $entity_id, $create = TRUE) {
    // Check if the entity already has a channel:
    $rels = moonmars_relationships_get_relationships('has_channel', $entity_type, $entity_id, 'node', NULL);

    if (!empty($rels)) {
      return Channel::create($rels[0]->entity_id1);
    }

    // If the entity has no channel, and $create is TRUE, create the channel now:
    if ($create) {
      return self::createEntityChannel($entity_type, $entity_id);
    }

    return NULL;
  }

}
