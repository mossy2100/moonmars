<?php
/**
 * Integer division.
 *
 * @param int $n
 * @param int $d
 * @return int
 */
function div($n, $d) {
	return floor($n / $d);
}

/**
 * Correct way to do modulus.
 *
 * @param int $n
 * @param int $d
 * @return int
 */
function mod($n, $d) {
  return $n - (div($n, $d) * $d);
}

/**
 * Handy function that PHP should have included.
 *
 * "is_sint" means "is signed integer". This doesn't refer to the value having the type "integer", but whether the
 * value is equivalent to a signed integer (positive, 0 or negative).
 *
 * Returns true if param is a signed integer, or a string of float that looks like one.
 *
 * @param mixed $n
 * @return bool
 */
function is_sint($n) {
  return is_int($n) || (is_string($n) && $n === strval(intval($n))) || (is_float($n) && $n === floatval(intval($n)));
}

/**
 * Handy function that PHP should have included.
 *
 * "is_uint" means "is unsigned integer". This doesn't refer to the value having the type "integer", but whether the
 * value is equivalent to a unsigned integer (0 or greater).
 *
 * Returns true if param is an unsigned integer, or a string of float that looks like one.
 *
 * @param mixed $n
 * @return bool
 */
function is_uint($n) {
  return is_sint($n) && $n >= 0;
}
