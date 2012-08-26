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
   * @param object|string $param1
   * @param null|object|int $param2
   * @return EntityBase
   */
  public static function getEntity($param1, $param2 = NULL) {
    // Allow for the first parameter to be an endpoint object:
    if (is_object($param1)) {
      $endpoint = $param1;
      $entity_type = $endpoint->entity_type;
      $entity = $endpoint->entity_id;
    }
    elseif (is_string($param2)) {
      $entity_type = $param1;
      $entity = $param2;
    }
    else {
      return FALSE;
    }

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
    $valid_entity_types = array('user', 'node', 'comment', 'relation');

    // Look for the entity type and id in the request_uri:
    $uri = trim($_SERVER['REQUEST_URI'], '/');
    $parts = explode('/', $uri);

    if (in_array($parts[0], $valid_entity_types)) {
      $id = $parts[1];
      if ($id && is_uint($id)) {
        return self::getEntity($parts[0], $parts[1]);
      }
    }

    // Maybe it's an alias, try converting to normal path:
    $entity_alias = $parts[0] . '/'. $parts[1];
    $path = drupal_get_normal_path($entity_alias);
    $parts = explode('/', $path);

    if (in_array($parts[0], $valid_entity_types)) {
      $id = $parts[1];
      if ($id && is_uint($id)) {
        return self::getEntity($parts[0], $parts[1]);
      }
    }

    // Not an entity path:
    return FALSE;
  }

  /**
   * Creates a new channel for an entity.
   *
   * @param EntityBase $entity
   * @return int
   */
  public static function createEntityChannel(EntityBase $entity) {
    // Create the new channel:
    $channel = Channel::create()
      ->setProperties(array(
          'uid'   => $entity->uid(),
          'title' => $entity->channelTitle(),
        ));

    // Save the node for the first time, which will give it a nid, which we need to create the relationship:
    $channel->save();

    // Create the relationship between the entity and the relationship:
    MoonMarsRelation::createNewBinary('has_channel', $entity, $channel);

    // Reset the channel's alias and title. This needs to be done after creating the relationship.
    $channel->resetAliasAndTitle();

    // Return the Channel:
    return $channel;
  }

  /**
   * Get an entity's channel.
   *
   * @param EntityBase $entity
   * @param bool $create
   * @return int
   */
  public static function getEntityChannel(EntityBase $entity, $create = TRUE) {
    // Check if the entity already has a channel:
    $rels = MoonMarsRelation::searchBinary('has_channel', $entity, NULL);

    if (!empty($rels)) {
      return $rels[0]->endpoint(1);
    }

    // If the entity has no channel, and $create is TRUE, create the channel now:
    if ($create) {
      return self::createEntityChannel($entity);
    }

    return NULL;
  }

}
