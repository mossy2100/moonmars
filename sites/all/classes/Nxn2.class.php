<?php
/**
 * User: shaun
 * Date: 2012-08-30
 * Time: 5:29 AM
 */
class Triumph {

  protected $triumphId;

  protected $triumphType;

  protected $entities;

  public function __construct($param) {
    if (is_uint($param)) {
      $this->triumphId = $param;
    }
    elseif (is_string($param)) {
      $this->triumph_type = $param;
    }
    else {
      trigger_error("Invalid parameter to Triumph constructor.", E_USER_WARNING);
    }
  }

  /**
   * Get the entities.
   */
  public function entities() {
    if (!isset($this->entities)) {
      // Get the entities:
      $q = db_select('moonmars_nxn_entity', 'mne')
        ->fields('mne')
        ->condition('triumph_id', $this->triumphId);
      $rs = $q->execute();
      foreach ($rs as $rec) {
        $this->entities[$rec->nxn_role] = MoonMarsEntity::getEntity($rec->entity_type, $rec->entity_id);
      }
    }
    return $this->entities();
  }

  /**
   * Get an entity involved in the nxn.
   *
   * @return EntityBase
   */
  public function entity($nxn_role) {
    $this->entities();
    return isset($this->entities[$nxn_role]) ? $this->entities[$nxn_role] : NULL;
  }

  /**
   * Get the nxn type.
   *
   * @return string
   */
  public function triumphType() {
    if (!$this->triumphType) {
      if ($this->triumphId) {
        // Get the nxn record:
        $q = db_select('moonmars_nxn', 'mn')
          ->fields('mn')
          ->condition('triumph_id', $this->triumphId);
        $rs = $q->execute();
        $rec = $rs->fetchObject();

        if ($rec) {
          // Get the nxn type:
          $this->triumphType = $rec->triumph_type;
        }
        else {
          trigger_error("Triumph:load() Notification $this->nxn not found.", E_USER_WARNING);
        }
      }
      else {
        trigger_error("Triumph:triumphType() Can't get notification type without an id.", E_USER_WARNING);
      }
    }

    return $this->triumphType;
  }


  public function recipients() {
    $q = db_select('moonmars_nxn_entity', 'mne')
      ->fields('mne')
      ->condition('triumph_id', $this->triumphId);
    $rs = $q->execute();
    foreach ($rs as $rec) {
      $this->entities[$rec->nxn_role] = MoonMarsEntity::getEntity($rec->entity_type, $rec->entity_id);
    }
    return $this->recipients;
  }

}
