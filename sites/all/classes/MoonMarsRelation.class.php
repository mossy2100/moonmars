<?php
/**
 * Creator: shaun
 * Date: 2012-08-21
 * Time: 10:14 PM
 * To change this template use File | Settings | File Templates.
 */
class MoonMarsRelation extends Relation {

  /**
   * Get an endpoint as an Actor-derived object (e.g. Group, Member, Item, ItemComment).
   * Overrides base class method which only returns an array.
   *
   * @param string $lang
   * @param int $delta
   * @return Actor
   */
  public function endpoint($delta, $lang = LANGUAGE_NONE) {
    $this->load();

    if (isset($this->entity->endpoints[$lang][$delta])) {
      $endpoint = $this->entity->endpoints[$lang][$delta];
      return Actor::getEntity($endpoint['entity_type'], $endpoint['entity_id']);
    }

    return NULL;
  }

//  /**
//   * Reset the alias for a relation.
//   */
//  public function resetAlias() {
//    switch ($this->relationType()) {
//      case 'has_member':
//        $group = $this->endpoint(0);
//        $member = $this->endpoint(1);
//        $alias = $member->alias() . '/email-preferences/' . (($group->nid() == MOONMARS_DEFAULT_GROUP_NID) ? 'groups' : $group->alias());
//        dpm($alias);
//        $this->alias($alias);
//        break;
//
//      case 'has_follower':
//        $followee = $this->endpoint(0);
//        $follower = $this->endpoint(1);
//        $alias = $follower->alias() . '/email-preferences/' . (($followee->uid() == MOONMARS_DEFAULT_MEMBER_UID) ? 'members' : $followee->alias());
//        $this->alias($alias);
//        break;
//    }
//  }

}
