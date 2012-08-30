<?php
/**
 * User: shaun
 * Date: 2012-08-30
 * Time: 5:29 AM
 */
class Triumph {

  protected $triumphId;

  protected $triumphType;

  protected $created;

  protected $entities;

  public function __construct($param) {
    if (is_uint($param)) {
      $this->triumphId = $param;
    }
    elseif (is_string($param)) {
      $this->triumphType = $param;
    }
    else {
      trigger_error("Invalid parameter to Triumph constructor.", E_USER_WARNING);
    }
  }

  /**
   * Load the triumph.
   */
  public function load() {
    if ($this->triumphId) {
      // Get the triumph record:
      $q = db_select('moonmars_triumph', 'mt')
        ->fields('mt')
        ->condition('triumph_id', $this->triumphId);
      $rs = $q->execute();
      $rec = $rs->fetchObject();

      if ($rec) {
        // Get the triumph type:
        $this->triumphType = $rec->triumph_type;
        $this->created = new StarDateTime($rec->created);
      }
      else {
        trigger_error("Triumph::load() -> Triumph $this->triumphId not found.", E_USER_WARNING);
      }
    }
    else {
      trigger_error("Triumph:load() -> Can't load the triumph without an id.", E_USER_WARNING);
    }
  }

  /**
   * Get the triumph type.
   *
   * @return string
   */
  public function triumphType() {
    if (!isset($this->triumphType)) {
      $this->load();
    }

    return $this->triumphType;
  }


  /**
   * Get the datetime when the triumph was created.
   *
   * @return StarDateTime
   */
  public function created() {
    if (!isset($this->created)) {
      $this->load();
    }

    return $this->created;
  }

  /**
   * Get the entities.
   */
  public function entities() {
    if (!isset($this->entities)) {
      // Get the entities:
      $q = db_select('moonmars_triumph_entity', 'mne')
        ->fields('mne')
        ->condition('triumph_id', $this->triumphId);
      $rs = $q->execute();
      foreach ($rs as $rec) {
        $this->entities[$rec->triumph_role] = MoonMarsEntity::getEntity($rec->entity_type, $rec->entity_id);
      }
    }
    return $this->entities();
  }

  /**
   * Get an entity involved in the triumph.
   *
   * @return EntityBase
   */
  public function entity($triumph_role) {
    $this->entities();
    return isset($this->entities[$triumph_role]) ? $this->entities[$triumph_role] : NULL;
  }

  /**
   * Add an entity to the triumph.
   *
   * @param $triumph_role
   * @param EntityBase $entity
   * @return Triumph
   */
  public function addEntity($triumph_role, $entity) {
    $this->entities[$triumph_role] = $entity;
    return $this;
  }

  /**
   * Save a triumph.
   *
   */
  public function save() {
    // Save the triumph record:



    // Delete existing triumph entity records:

    // Insert new triumph entity records:
    foreach ($this->entities as $entity) {


    }


    return $this;
  }

}
