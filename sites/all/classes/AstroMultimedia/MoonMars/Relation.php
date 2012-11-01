<?php
namespace AstroMultimedia\MoonMars;

/**
 * Creator: shaun
 * Date: 2012-08-21
 * Time: 10:14 PM
 * To change this template use File | Settings | File Templates.
 */
class Relation extends \AstroMultimedia\Drupal\Relation {

  /**
   * Get an endpoint as an IActor object (e.g. Group, Member, Item, ItemComment).
   * Overrides base class method which only returns an array.
   *
   * @param string $lang
   * @param int $delta
   * @return IActor
   */
  public function endpoint($delta, $lang = LANGUAGE_NONE) {
    $this->load();
    if (isset($this->entity->endpoints[$lang][$delta])) {
      $endpoint = $this->entity->endpoints[$lang][$delta];
      return moonmars_actors_get_actor($endpoint['entity_type'], $endpoint['entity_id']);
    }
    return NULL;
  }

}
