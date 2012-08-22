<?php
/**
 * Static entity-related methods.
 *
 * @todo If we move to PHP 5.4 this could be implemented as a trait to be attached to Member, Group, Event, etc.
 * At the moment this class isn't connected to those ones, other than conceptually. Hence only static methods.
 */
class MoonMarsEntity {

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
        // Get the node type:
        $node_type = is_uint($entity) ? node_get_type($entity) : $entity->type;

        // Get the node class:
        $class = ucfirst($node_type);

        // If the node class exists, instantiate:
        if (class_exists($class)) {
          // Note I create the object using $entity instead of reloading the node (which would be another way of getting
          // the type), to prevent the node we just loaded from clobbering the one we have in memory.
          // My caching mechanism is better than Drupal's, unfortunately.
          return $class::create($entity);
        }

        // Fall back to base Node class:
        return Node::create($entity);

      case 'comment':
        // Get the cid:
        $cid = is_uint($entity) ? $entity : $entity->cid;

        // Get the comment's node type.
        $node_type = comment_get_node_type($cid);

        // Get the comment class:
        $class = ucfirst($node_type) . 'Comment';

        // If the comment class exists, instantiate.
        // This will capture ItemComment and potential other future comment classes such as ArticleComment or BlogPostComment.
        if (class_exists($class)) {
          return $class::create($entity);
        }

        // Fall back to base Comment class:
        return Comment::create($entity);

      case 'relation':
        // Create the object:
        return MoonMarsRelation::create($entity);
    }

    return FALSE;
  }

  /**
   * Get the entity from the URL.
   *
   * @static
   * @return bool
   */
  public static function getEntityFromUrl() {
    return self::getEntity(arg(0), arg(1));
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
    Relation::createNewBinary('has_channel', $entity_type, $entity_id, 'node', $channel->nid());

    // Reset the channel's alias and title:
    $channel->resetAliasAndTitle();

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
    $rels = Relation::searchBinary('has_channel', $entity_type, $entity_id, 'node', NULL);

    if (!empty($rels)) {
      return Channel::create($rels[0]->endpointEntityId(1));
    }

    // If the entity has no channel, and $create is TRUE, create the channel now:
    if ($create) {
      return self::createEntityChannel($entity_type, $entity_id);
    }

    return NULL;
  }

}
