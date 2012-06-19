<?php

/**
 * Converts an object to an array.
 * Similar to casting, but gets rid of the weird \0*\0 prefix for protected properties.
 *
 * @param object $object
 * @param bool $deep
 *   If TRUE, then objects inside the provided object will also be converted to arrays.
 * @return array
 */
function object_to_array($object, $deep = FALSE, $objects = array()) {
  $array = (array) $object;
  $result = array();
  foreach ($array as $key => $value) {
    // If the value is an object:
    if (is_object($value)) {
      $object_hash = spl_object_hash($value);
      if (in_array($object_hash, $objects)) {
        $value = "((Circular reference))";
      }
      else {
        // Remember we saw this object:
        $objects[] = $object_hash;
        // If this is a deep conversion, convert it to an array also:
        if ($deep) {
          $value = object_to_array($value, $deep, $objects);
        }
      }
    }
    // Remove the initial 3 characters prepended to protected properties.
    if (substr($key, 0, 3) == "\0*\0") {
      $key = substr($key, 3);
    }
    // Add the value to the $result array:
    $result[$key] = $value;
  }
  return $result;
}
