<?php
// $Id$

/**
 * @file
 * Contains XDateTime class (short for "Drupal DateTime"), which extends PHP's
 * built-in DateTime class.
 */

/**
 * This class extends PHP's DateTime class in the following ways:
 *
 *   - Virtual properties are supported for getting and setting date and time
 *     parts (year, month, day, hour, minute and second).
 *   - Methods for adding and subtracting periods.
 *   - Methods for comparing datetimes.
 *   - Support for Drupal's format_date() functions.
 *   - Works with PHP 5.2 and above.
 *
 * @version <dt_generated>
 * @author shaunmoss
 */
class XDateTime extends DateTime {

  /**
   * Constructor that can accept datetimes in most of the usual forms,
   * including:
   *   - Unix timestamps.
   *   - Date strings in a wide variety of formats. @see strototime()
   *   - Instances of DateTime or XDateTime.
   *   - XML-RPC date objects. @see xmlrpc_date()
   *
   * Usages:
   *   new XDateTime();
   *   new XDateTime($datetime);
   *   new XDateTime($datetime, $timezone);
   *   new XDateTime($year, $month, $day);
   *   new XDateTime($year, $month, $day, $hour);
   *   new XDateTime($year, $month, $day, $hour, $minute);
   *   new XDateTime($year, $month, $day, $hour, $minute, $second);
   *   new XDateTime($year, $month, $day, $hour, $minute, $second, $timezone);
   *
   * @param type $datetime_year
   *   Can be a datetime value or the year, or NULL for the current time.
   * @param type $timezone_month
   *   Can be the timezone or the month.
   * @param type $day
   *   Day of the month.
   * @param type $hour
   * @param type $minute
   * @param type $second
   * @param type $timezone
   *   Can be a timezone name, a DateTimeZone object, or NULL to use the current
   *   system default (if the timezone isn't specified by the first parameter.)
   */
  public function __construct($datetime_year = NULL, $timezone_month = NULL,
      $day = NULL, $hour = NULL, $minute = NULL, $second = NULL, $timezone = NULL) {

    // Determine meaning of first 2 parameters:
    $long = func_num_args() >= 3;
    if ($long) {
      $year = $datetime_year;
      $month = $timezone_month;
    }
    else {
      $datetime = $datetime_year;
      $timezone = $timezone_month;
    }

    // Determine the timezone if not specified:
    if (is_null($timezone)) {
      if ($datetime instanceof DateTime) {
        // Get the timezone from the DateTime or XDateTime object:
        $timezone = $datetime->getTimezone();
      }
      elseif (is_array($datetime) && $datetime['timezone']) {
        // Get the timezone from the CCK field:
        $timezone = $datetime['timezone'];
      }
      else {
        // Use the current default timezone:
        $timezone = date_default_timezone_get();
      }
    }

    // Make sure $timezone is a DateTimeZone:
    if (!$timezone instanceof DateTimeZone) {
      $timezone = new DateTimeZone($timezone);
    }

    // Construct the new object:
    if ($long) {
      // Create a ISO datetime string (better to do it this way than by using
      // mktime(), because mktime() uses the current system default timezone
      // and we may want to specify a different one.)
      $year   = str_pad((int) $year,   4, '0', STR_PAD_LEFT);
      $month  = str_pad((int) $month,  2, '0', STR_PAD_LEFT);
      $day    = str_pad((int) $day,    2, '0', STR_PAD_LEFT);
      $hour   = str_pad((int) $hour,   2, '0', STR_PAD_LEFT);
      $minute = str_pad((int) $minute, 2, '0', STR_PAD_LEFT);
      $second = str_pad((int) $second, 2, '0', STR_PAD_LEFT);
      $datetime = "$year-$month-{$day}T$hour:$minute:$second";
    }
    elseif (is_object($datetime)) {
      if ($datetime instanceof DateTime) {
        // Generate a string instead of using the timestamp for 2 reasons:
        // 1. In PHP versions < 5.3, the getTimestamp() method is not available.
        // 2. When the timestamp is used the timezone parameter is ignored.
        // Note, I don't use DateTime::ISO3601 here, otherwise the timezone part
        // of that string will be used instead of the $timezone variable.
        $datetime = $datetime->format(DATE_FORMAT_ISO);
      }
      elseif ($datetime->iso8601) {
        // Looks like an XML-RPC datetime:
        $datetime = $datetime->iso8601;
      }
    }
    elseif (preg_match("/^\@?(\d+)$/", $datetime, $matches)) {
      // Unix timestamp. We convert to a datetime string instead of using the
      // '@' syntax so that the timezone parameter won't be ignored.
      $datetime = date(DATE_FORMAT_ISO, $matches[1]);
    }
    elseif (is_array($datetime) && array_key_exists('value', $datetime)) {
      // CCK field:
      $datetime = $datetime['value'];
    }

    // Construct the base DateTime object:
    parent::__construct($datetime, $timezone);
  }


  //////////////////////////////////////////////////////////////////////////////
  // Overload methods.

  /**
   * Property overloading. By implementing these methods we can provide access
   * to fields via virtual properties, which are a bit more concise than the
   * getBlah() and setBlah() methods.
   * It can be useful to have both ways of accessing date parts.
   *
   * It would be nice to inherit these methods from the XEntityBase class, but
   * PHP does not support multiple inheritance. One alternative would be to not
   * inherit from DateTime, but that approach would block us from any
   * performance benefits of, or future improvements to, PHP's DateTime class.
   */

  /**
   * Passes the request through to the corresponding get method (getTitle(),
   * etc.), which will take care of loading fields from the database, etc.
   * For example $date->hour can be used instead of $date->getHour().
   *
   * @param string $name
   * @return mixed
   */
  public function __get($name) {
    $method = 'get' . ucfirst($name);
    return $this->$method();
  }

  /**
   *
   * Passes the request through to the corresponding set method.
   * For example, $date->month = 5 can be used instead of $date->setMonth(5).
   *
   * @param string $name
   * @param mixed $value
   */
  public function __set($name, $value) {
    $method = 'set' . ucfirst($name);
    $this->$method($value);
  }

  /**
   * Allow format methods to be accessed via virtual properties like get
   * methods, as a useful shortcut.
   * For example, if $dt->iso is called, it will get passed to
   * $dtr->formatIso().
   *
   * @param string $method
   * @param array $params
   */
  public function __call($method, array $params) {
    if (substr($method, 0, 3) == 'get') {
      $format_method = 'format' . substr($method, 3);
      if (method_exists($this, $format_method)) {
        return call_user_func_array(array($this, $format_method), $params);
      }
    }

    // Throw an error:
    trigger_error(t("Call to undefined method !method", array('!method' => $method)), E_USER_ERROR);
  }


  //////////////////////////////////////////////////////////////////////////////
  // Static methods.

  /**
   * Get today's date as a XDateTime object.
   *
   * @return XDateTime
   */
  public static function today() {
    return new XDateTime(date(DATE_FORMAT_DATE));
  }

  /**
   * Get the current time, according to server and in the server's timezone, as
   * a XDateTime object.
   *
   * @return XDateTime
   */
  public static function now() {
    return new XDateTime();
  }


  //////////////////////////////////////////////////////////////////////////////
  // Conversion method.

  /**
   * Return the datetime as an array of date and time parts.
   * This method is fairly similar to getdate(), except that array is simpler,
   * containing only the 6 primary datetime parts.
   *
   * @return array
   */
  public function toArray() {
    $parts = getdate($this->timestamp);
    return array(
      'year' => $parts['year'],
      'month' => $parts['mon'],
      'day' => $parts['mday'],
      'hour' => $parts['hours'],
      'minute' => $parts['minutes'],
      'second' => $parts['seconds'],
      'timezone' => array(
        'name' => $this->getTimezoneName(),
        'offset' => $this->getTimezoneOffset(),
      ),
    );
  }


  //////////////////////////////////////////////////////////////////////////////
  // Accessor and mutator methods for date parts.

  /**
   * Get the year.
   *
   * @return int
   */
  public function getYear() {
    return (int) $this->format('Y');
  }

  /**
   * Set the year.
   * Note, there is no special handling for 2-digit years.
   *
   * @param int $year
   * @return XDateTime
   *   The $this object for method chaining.
   */
  public function setYear($year) {
    $dta = $this->toArray();
    return $this->setDate((int) $year, $dta['month'], $dta['day']);
  }

  /**
   * Get the month.
   *
   * @return int
   */
  public function getMonth() {
    return (int) $this->format('n');
  }

  /**
   * Set the month.
   *
   * @param int $month
   * @return XDateTime
   *   The $this object for method chaining.
   */
  public function setMonth($month) {
    $dta = $this->toArray();
    return $this->setDate($dta['year'], (int) $month, $dta['day']);
  }

  /**
   * Get the day of the month.
   *
   * @return int
   */
  public function getDay() {
    return (int) $this->format('j');
  }

  /**
   * Set the day of the month.
   *
   * @param int
   * @return XDateTime
   *   The $this object for method chaining.
   */
  public function setDay($day) {
    $dta = $this->toArray();
    return $this->setDate($dta['year'], $dta['month'], (int) $day);
  }

  /**
   * Get the hour.
   *
   * @return int
   */
  public function getHour() {
    return (int) $this->format('G');
  }

  /**
   * Set the hour.
   *
   * @param int $hour
   * @return XDateTime
   *   The $this object for method chaining.
   */
  public function setHour($hour) {
    $dta = $this->toArray();
    return $this->setTime((int) $hour, $dta['minute'], $dta['second']);
  }

  /**
   * Get the minute.
   *
   * @return int
   */
  public function getMinute() {
    return (int) $this->format('i');
  }

  /**
   * Set the minute.
   *
   * @param int $minute
   * @return XDateTime
   *   The $this object for method chaining.
   */
  public function setMinute($minute) {
    $dta = $this->toArray();
    return $this->setTime($dta['hour'], (int) $minute, $dta['second']);
  }

  /**
   * Get the second.
   *
   * @return int
   */
  public function getSecond() {
    return (int) $this->format('s');
  }

  /**
   * Set the second.
   *
   * @param int
   * @return XDateTime
   *   The $this object for method chaining.
   */
  public function setSecond($second) {
    $dta = $this->toArray();
    return $this->setTime($dta['hour'], $dta['minute'], (int) $second);
  }


  //////////////////////////////////////////////////////////////////////////////
  // Timezone methods.

  /**
   * The getTimezone() method is provided by the base class.
   */

  /**
   * Return the timezone as a string.
   *
   * This method can also be accessed via a virtual property
   * "timezoneName", e.g. echo $dt->timezoneName
   *
   * @return string
   */
  public function getTimezoneName() {
    return $this->getTimezone()->getName();
  }

  /**
   * Override parent class method so that timezones can be set using a string,
   * e.g. "Australia/Melbourne".
   *
   * This method can also be accessed via a virtual property
   * "timezone", e.g. $dt->timezone = "Australia/Melbourne" or
   * $dt->timezone = new DateTimeZone('UTC')
   *
   * @param mixed $timezone
   * @return XDateTime
   *   The $this object for method chaining.
   */
  public function setTimezone($timezone) {
    // If a string was provided, convert to a DateTimeZone object:
    if (is_string($timezone)) {
      $timezone = new DateTimeZone($timezone);
    }
    // Call DateTime::setTimezone():
    return parent::setTimezone($timezone);
  }

  /**
   * Return the timezone offset in seconds.
   *
   * This method can also be accessed via a virtual property
   * "timezoneOffset", e.g. echo $dt->timezoneOffset
   *
   * @return string
   */
  public function getTimezoneOffset() {
    return $this->getTimezone()->getOffset($this);
  }


  //////////////////////////////////////////////////////////////////////////////
  // Timestamp methods.

  /**
   * Get the datetime as a Unix timestamp.
   *
   * @return int
   */
  public function getTimestamp() {
    // If using PHP 5.3 or higher, use the DateTime::getTimestamp() method.
    if (classes_php_version_at_least(5.3)) {
      return parent::getTimestamp();
    }
    else {
      // Workaround.
      // Convert the datetime to a string (with timezone), then to a timestamp:
      return strtotime($this->formatIsoFull());
    }
  }

  /**
   * Set the datetime with a Unix timestamp.
   *
   * @param int $ts
   * @return XDateTime
   *   The $this object for method chaining.
   */
  public function setTimestamp($ts) {
    // If using PHP 5.3 or higher, use the DateTime::getTimestamp() method.
    if (classes_php_version_at_least(5.3)) {
      return parent::setTimestamp();
    }
    else {
      // Workaround.
      // Convert the timestamp to a datetime array:
      $dta = getdate($ts);
      // Set the date and time using the PHP 5.2 methods.
      $this->setDate($dta['year'], $dta['mon'], $dta['mday']);
      return $this->setTime($dta['hours'], $dta['minutes'], $dta['seconds']);
    }
  }


  //////////////////////////////////////////////////////////////////////////////
  // Functions for adding and subtracting timespans.

  /**
   * General add function for PHP 5.3 and above.
   * Overrides method in DateTime, providing a more user-friendly interface.
   *
   * Note: Capital 'M' is months, lower-case 'm' is minutes.
   * Other than that, units are case-insensitive.
   *
   * @param int $n
   * @param string $unit
   *   Supports 'y', 'mon', 'd', 'h', 'min', 's' and common alternatives.
   * @return object
   */
  public function add($n, $unit = 'd') {
    // Determine the appropriate unit for the DateInterval string:
    $lunit = strtolower($unit);
    if (in_array($lunit, array('y', 'yr', 'yrs', 'year', 'years'))) {
      $unit = 'Y';
      $time = FALSE;
    }
    elseif ($unit == 'M' || in_array($lunit, array('mon', 'mons', 'month', 'months'))) {
      $unit = 'M';
      $time = FALSE;
    }
    elseif (in_array($lunit, array('d', 'day', 'days'))) {
      $unit = 'D';
      $time = FALSE;
    }
    elseif (in_array($lunit, array('h', 'hr', 'hrs', 'hour', 'hours'))) {
      $unit = 'H';
      $time = TRUE;
    }
    elseif ($unit == 'm' || in_array($lunit, array('min', 'mins', 'minute', 'minutes'))) {
      $unit = 'M';
      $time = TRUE;
    }
    elseif (in_array($lunit, array('s', 'sec', 'secs', 'second', 'seconds'))) {
      $unit = 'S';
      $time = TRUE;
    }

    // Construct the DateInterval object:
    $interval = new DateInterval('P' . ($time ? 'T' : '') . abs($n) . $unit);

    if ($n < 0) {
      // Subtract the interval from the datetime:
      return parent::sub($interval);
    }
    elseif ($n > 0) {
      // Add the interval to the datetime:
      return parent::add($interval);
    }
  }

  /**
   * General subtract function for PHP 5.3 and above.
   * Overrides method in DateTime, providing a more user-friendly interface.
   *
   * @param int $n
   * @param string $unit
   * @return object
   */
  public function sub($n, $unit) {
    return $this->add(-$n, $unit);
  }

  /**
   * Add a given number of years to the datetime.
   *
   * @param int $n_years
   * @return XDateTime
   */
  public function addYears($n_years) {
    if (classes_php_version_at_least(5.3)) {
      return $this->add($n_years, 'y');
    }
    else {
      $dta = $this->toArray();
      return $this->setDate($dta['year'] + $n_years, $dta['month'], $dta['day']);
    }
  }

  /**
   * Subtract a given number of years from the datetime.
   *
   * @param int $n_years
   * @return XDateTime
   */
  public function subtractYears($n_years) {
    return $this->addYears(-$n_years);
  }

  /**
   * Add a given number of months to the datetime.
   *
   * @param int $n_months
   * @return XDateTime
   */
  public function addMonths($n_months) {
    if (classes_php_version_at_least(5.3)) {
      return $this->add($n_months, 'mon');
    }
    else {
      $dta = $this->toArray();
      return $this->setDate($dta['year'], $dta['month'] + $n_months, $dta['day']);
    }
  }

  /**
   * Subtract a given number of months from the datetime.
   *
   * @param int $n_months
   * @return XDateTime
   */
  public function subtractMonths($n_months) {
    return $this->addMonths(-$n_months);
  }

  /**
   * Add a given number of weeks to the datetime.
   *
   * @param int $n_weeks
   * @return XDateTime
   */
  public function addWeeks($n_weeks) {
    return $this->addDays($n_weeks * 7);
  }

  /**
   * Subtract a given number of weeks from the datetime.
   *
   * @param int $n_weeks
   * @return XDateTime
   */
  public function subtractWeeks($n_weeks) {
    return $this->addWeeks(-$n_weeks);
  }

  /**
   * Add a given number of days to the datetime.
   *
   * @param int $n_days
   * @return XDateTime
   */
  public function addDays($n_days) {
    if (classes_php_version_at_least(5.3)) {
      return $this->add($n_days, 'd');
    }
    else {
      $dta = $this->toArray();
      return $this->setDate($dta['year'], $dta['month'], $dta['day'] + $n_days);
    }
  }

  /**
   * Subtract a given number of days from the datetime.
   *
   * @param int $n_days
   * @return XDateTime
   */
  public function subtractDays($n_days) {
    return $this->addDays(-$n_days);
  }

  /**
   * Add a given number of hours to the datetime.
   *
   * @param int $n_hours
   * @return XDateTime
   */
  public function addHours($n_hours) {
    if (classes_php_version_at_least(5.3)) {
      return $this->add($n_hours, 'h');
    }
    else {
      $dta = $this->toArray();
      return $this->setTime($dta['hour'] + $n_hours, $dta['minute'], $dta['second']);
    }
  }

  /**
   * Subtract a given number of hours from the datetime.
   *
   * @param int $n_hours
   * @return XDateTime
   */
  public function subtractHours($n_hours) {
    return $this->addHours(-$n_hours);
  }

  /**
   * Add a given number of minutes to the datetime.
   *
   * @param int $n_minutes
   * @return XDateTime
   */
  public function addMinutes($n_minutes) {
    if (classes_php_version_at_least(5.3)) {
      return $this->add($n_minutes, 'min');
    }
    else {
      $dta = $this->toArray();
      return $this->setTime($dta['hour'], $dta['minute'] + $n_minutes, $dta['second']);
    }
  }

  /**
   * Subtract a given number of minutes from the datetime.
   *
   * @param int $n_minutes
   * @return XDateTime
   */
  public function subtractMinutes($n_minutes) {
    return $this->addMinutes(-$n_minutes);
  }

  /**
   * Add a given number of seconds to the datetime.
   *
   * @param int $n_seconds
   * @return XDateTime
   */
  public function addSeconds($n_seconds) {
    if (classes_php_version_at_least(5.3)) {
      return $this->add($n_seconds, 's');
    }
    else {
      $dta = $this->toArray();
      return $this->setTime($dta['hour'], $dta['minute'], $dta['second'] + $n_seconds);
    }
  }

  /**
   * Subtract a given number of seconds from the datetime.
   *
   * @param int $n_seconds
   * @return XDateTime
   */
  public function subtractSeconds($n_seconds) {
    return $this->addSeconds(-$n_seconds);
  }


  //////////////////////////////////////////////////////////////////////////////
  // ISO formatting methods.

  /**
   * Format the datetime in the full ISO format, with timezone offset.
   * i.e. YYYY-MM-DDThh:mm:ss+TMZN
   * e.g. 2011-01-06T11:28:00+1000
   *
   * @return string
   */
  public function formatIsoFull() {
    return $this->format(DateTime::ISO8601);
  }

  /**
   * Format the datetime in ISO format, without timezone offset.
   * i.e. YYYY-MM-DDThh:mm:ss
   * e.g. 2011-01-06T11:28:00
   *
   * Use this format for CCK and database fields.
   *
   * @return string
   */
  public function formatIso() {
    return $this->format(DATE_FORMAT_ISO);
  }

  /**
   * Format the date part in ISO format.
   * i.e. YYYY-MM-DD
   * e.g. 2011-01-06
   *
   * @return string
   */
  public function formatIsoDate() {
    return $this->format(DATE_FORMAT_DATE);
  }

  /**
   * Format the time part in ISO format.
   * i.e. hh:mm:ss
   * e.g. 23:30:15
   *
   * @return string
   */
  public function formatIsoTime() {
    return $this->format(DATE_FORMAT_TIME);
  }


  //////////////////////////////////////////////////////////////////////////////
  // Drupal formatting methods.

  /**
   * Wrapper for Drupal's format_date() function.
   *
   * Normally you would use one of the other Drupal date formatting functions,
   * i.e. formatSmall(), formatMedium(), formatLarge() or formatCustom().
   *
   * @param string $format
   *   Either 'small', 'medium' (default), or 'large', or a date/datetime
   *   formatting string (@see date()).
   * @param string $timezone
   *   The timezone, defaults to user's timezone.
   * @param string $langcode
   *   Language code, defaults to the page's.
   * @return string
   */
  public function formatDrupal($format = 'medium', $timezone = NULL, $langcode = NULL) {
    // Determine the $type parameter for the format_date function.
    $type = in_array($format, array('small', 'medium', 'large')) ? $format : 'custom';

    return format_date($this->getTimestamp(), $type, $format, $timezone, $langcode);
  }

  /**
   * Format date using the small format.
   *
   * @param string $timezone
   * @param string $langcode
   * @return string
   */
  public function formatSmall($timezone = NULL, $langcode = NULL) {
    return $this->formatDrupal('small', $timezone, $langcode);
  }

  /**
   * Format date using the medium format.
   *
   * @param string $timezone
   * @param string $langcode
   * @return string
   */
  public function formatMedium($timezone = NULL, $langcode = NULL) {
    return $this->formatDrupal('medium', $timezone, $langcode);
  }

  /**
   * Format date using the large format.
   *
   * @param string $timezone
   * @param string $langcode
   * @return string
   */
  public function formatLarge($timezone = NULL, $langcode = NULL) {
    return $this->formatDrupal('large', $timezone, $langcode);
  }

  /**
   * Format date using a custom format.
   *
   * @param string $format
   *   The datetime format string, @see date().
   * @param string $timezone
   * @param string $langcode
   * @return string
   */
  public function formatCustom($format, $timezone = NULL, $langcode = NULL) {
    return $this->formatDrupal($format, $timezone, $langcode);
  }


  //////////////////////////////////////////////////////////////////////////////
  // Datetime comparison functions

  /**
   * Returns TRUE if the two datetimes are equal.
   *
   * @param mixed $dt
   *   Any valid date or datetime value accepted by the constructor.
   * @return bool
   */
  public function equal($dt) {
    // Convert param to a XDateTime if not one already:
    if (!$dt instanceof XDateTime) {
      $dt = new XDateTime($dt);
    }
    return $this->timestamp == $dt->timestamp;
  }

  /**
   * Returns TRUE if $this datetime is not equal to the $dt parameter.
   *
   * @param mixed $dt
   *   Any valid date or datetime value accepted by the constructor.
   * @return bool
   */
  public function notEqual($dt) {
    return !$this->equal($dt);
  }

  /**
   * Returns TRUE if $this datetime is earlier than the $dt parameter.
   *
   * @param mixed $dt
   *   Any valid date or datetime value accepted by the constructor.
   * @return bool
   */
  public function earlier($dt) {
    // Convert param to a XDateTime if not one already:
    if (!$dt instanceof XDateTime) {
      $dt = new XDateTime($dt);
    }
    return $this->timestamp < $dt->timestamp;
  }

  /**
   * Returns TRUE if $this datetime is later than the $dt parameter. Timezones
   * are not considered.
   *
   * @param mixed $dt
   *   Any valid date or datetime value accepted by the constructor.
   * @return bool
   */
  public function later($dt) {
    // Convert param to a XDateTime if not one already:
    if (!$dt instanceof XDateTime) {
      $dt = new XDateTime($dt);
    }
    return $this->timestamp > $dt->timestamp;
  }

  /**
   * Returns TRUE if $this datetime is earlier than or equal to the $dt
   * parameter.
   *
   * @param mixed $dt
   *   Any valid date or datetime value accepted by the constructor.
   * @return bool
   */
  public function earlierOrEqual($dt) {
    return !$this->later($dt);
  }

  /**
   * Returns TRUE if $this datetime is later than or equal to the $dt parameter.
   *
   * @param mixed $dt
   *   Any valid date or datetime value accepted by the constructor.
   * @return bool
   */
  public function laterOrEqual($dt) {
    return !$this->earlier($dt);
  }

}
