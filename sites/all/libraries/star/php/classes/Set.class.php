<?php
/**
 * Set class. Emulates sets, i.e. unordered collections with no duplicates.
 */
class Set {

  /**
   * Items in the set.
   *
   * @var array
   */
  private $items;

  /**
   * Constructor.
   */
  public function __construct(array $arr = array()) {
    // Creates a new set containing the values of the parameters:
    $this->items = array_values(array_unique($arr));
  }

  /**
   * Return the number of items in the set.
   *
   * @return int
   */
  public function count() {
    return count($this->items);
  }

  /**
   * Check if the set contains a given item.
   *
   * @param mixed $item
   * @return bool
   */
  public function in($item) {
    return in_array($item, $this->items);
  }

  /**
   * Add an item to the set.
   *
   * @param mixed $item
   * @return Set
   */
  public function add($item) {
    if (!in_array($item, $this->items)) {
      $this->items[] = $item;
    }
    return $this;
  }

  /**
   * Remove an item from the set.
   *
   * @param mixed $item
   * @return Set
   */
  public function remove($item) {
    $this->items = array_values(array_diff($this->items, array($item)));
    return $this;
  }

  /**
   * Union of two sets.
   *
   * @param Set $set2
   * @return Set
   */
  public function union(Set $set2) {
    return new Set(array_merge($this->items, $set2->toArray()));
  }

  /**
   * Difference between two sets.
   *
   * @param Set $set2
   * @return Set
   */
  public function diff(Set $set2) {
    return new Set(array_diff($this->items, $set2->toArray()));
  }

  /**
   * Intersection between two sets.
   *
   * @param Set $set2
   * @return Set
   */
  public function intersect(Set $set2) {
    return new Set(array_intersect($this->items, $set2->toArray()));
  }

  /**
   * Checks if 2 sets are equal.
   *
   * @param Set $set2
   * @return Set
   */
  public function equal(Set $set2) {
    return ($this->count() == $set2->count()) && $this->subset($set2);
  }

  /**
   * Checks if a set is a subset of another set.
   *
   * @param Set $set2
   * @return Set
   */
  public function subset(Set $set2) {
    foreach ($this->items as $item) {
      if (!$set2->in($item)) {
        return FALSE;
      }
    }
    return TRUE;
  }

  /**
   * Checks if a set is a proper subset of another set.
   *
   * @param Set $set2
   * @return Set
   */
  public function properSubset(Set $set2) {
    return ($this->count() < $set2->count()) && $this->subset($set2);
  }

  /**
   * Checks if a set is a superset of another set.
   *
   * @param Set $set2
   * @return Set
   */
  public function superset(Set $set2) {
    return $set2->subset($this);
  }

  /**
   * Checks if a set is a proper superset of another set.
   *
   * @param Set $set2
   * @return Set
   */
  public function properSuperset(Set $set2) {
    return $set2->properSubset($this);
  }

  /**
   * Convert set to a string.
   *
   * @return string
   */
  function __toString() {
    return implode(',', $this->items);
  }

  /**
   * Convert set to an array.
   *
   * @return array
   */
  function toArray() {
    return $this->items;
  }
}
