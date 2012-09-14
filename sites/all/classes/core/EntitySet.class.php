<?php
/**
 * User: shaun
 * Date: 2012-09-14
 * Time: 12:08 PM
 * To change this template use File | Settings | File Templates.
 */
class EntitySet extends StarSet {

  /**
   * Add one or more entities to the set.
   * Supports both single EntityBase objects and arrays of EntityBase objects.
   *
   * @param array $entities
   */
  public function addMultiple($entities) {
    // Make sure we have an array:
    if (!is_array($entities)) {
      trigger_error("EntitySet::addMultiple() - Parameter must be an array of EntityBase objects.", E_USER_WARNING);
    }

    // Add each entity in the array:
    foreach ($entities as $entity) {
      if (!$entity instanceof EntityBase) {
        trigger_error("EntitySet::addMultiple() - Items to add must be EntityBase objects.", E_USER_WARNING);
      }

      // By using the entity id as the key, we prevent duplicates.
      $key = $entity->entityType() . ':' . $entity->id();
      $this->items[$key] = $entity;
    }
  }

  /**
   * Add an entity to the set.
   *
   * @param EntityBase $entity
   */
  public function add(EntityBase $entity) {
    $this->addMultiple(array($entity));
  }

  /**
   * Remove entities from the set.
   *
   * @param array $entities
   */
  public function removeMultiple($entities) {
    // Make sure we have an array:
    if (!is_array($entities)) {
      trigger_error("EntitySet::removeMultiple() - Parameter must be array of EntityBase objects.", E_USER_WARNING);
    }

    // Remove each entity in the array:
    foreach ($entities as $entity) {
      if (!$entity instanceof EntityBase) {
        trigger_error("EntitySet::removeMultiple() - Items to remove must be EntityBase objects.", E_USER_WARNING);
      }

      // By using the entity uid as the key, it's easy to find the entity to remove.
      $key = $entity->entityType() . ':' . $entity->id();
      unset($this->entities[$key]);
    }
  }

  /**
   * Remove an entity from the set.
   *
   * @param EntityBase $entity
   */
  public function remove(EntityBase $entity) {
    return $this->removeMultiple(array($entity));
  }

  /**
   * Get the array of entities.
   *
   * @return array
   */
  public function entities() {
    return $this->items;
  }

}
