<?php

/**
 * This class is part of the Star Library, and is designed to extend and improve PHP's built-in DateTime class.
 */
class StarDateTime extends DateTime {

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Constants

  // These values are based on average Gregorian calendar month and year lengths.

  const SECONDS_PER_MINUTE  = 60;
  const SECONDS_PER_HOUR    = 3600;
  const SECONDS_PER_DAY     = 86400;
  const SECONDS_PER_WEEK    = 604800;
  const SECONDS_PER_MONTH   = 2629746;
  const SECONDS_PER_YEAR    = 31556952;

  const MINUTES_PER_HOUR    = 60;
  const MINUTES_PER_DAY     = 1440;
  const MINUTES_PER_WEEK    = 10080;
  const MINUTES_PER_MONTH   = 43829.1;
  const MINUTES_PER_YEAR    = 525949.2;

  const HOURS_PER_DAY       = 24;
  const HOURS_PER_WEEK      = 168;
  const HOURS_PER_MONTH     = 730.485;
  const HOURS_PER_YEAR      = 8765.82;

  const DAYS_PER_WEEK       = 7;
  const DAYS_PER_MONTH      = 30.436875;
  const DAYS_PER_YEAR       = 365.2425;
  
  const WEEKS_PER_MONTH     = 4.348125;
  const WEEKS_PER_YEAR      = 52.1775;
  
  const MONTHS_PER_YEAR     = 12;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Static methods

  /**
   * The current datetime as an StarDateTime object.
   *
   * @return StarDateTime
   */
  public static function now() {
    // This will call the parent constructor, which defaults to 'now'.
    return new StarDateTime();
  }

  /**
   * Today's date as an StarDateTime object.
   *
   * @return StarDateTime
   */
  public static function today() {
    $now = self::now();
    return $now->date();
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Constructor

  /**
   * Constructor for making dates and datetimes.
   * Time zones may be provided as DateTimeZone objects, or as timezone strings.
   * All arguments are optional.
   *
   * Usage examples:
   *    $dt = new StarDateTime();
   *    $dt = new StarDateTime($unix_timestamp);
   *    $dt = new StarDateTime($datetime_string);
   *    $dt = new StarDateTime($datetime_string, $timezone);
   *    $dt = new StarDateTime($year, $month, $day);
   *    $dt = new StarDateTime($year, $month, $day, $timezone);
   *    $dt = new StarDateTime($year, $month, $day, $hour, $minute, $second);
   *    $dt = new StarDateTime($year, $month, $day, $hour, $minute, $second, $timezone);
   *
   * @param string|int                    $year, $unix_timestamp or $datetime_string
   * @param null|DateTimeZone|string|int  $month or $timezone
   * @param int                           $day
   * @param null|DateTimeZone|string|int  $hour or $timezone
   * @param int                           $minute
   * @param int                           $second
   * @param null|DateTimeZone|string      $timezone
   */
  public function __construct() {
    // All arguments are optional and several serve multiple roles, so it's simpler not to include parameters in the
    // function signature, and instead just grab them as follows:
    $n_args = func_num_args();
    $args = func_get_args();

    // Default timezone:
    $timezone = NULL;

    if ($n_args == 0) {
      // Now:
      $datetime = 'now';
    }
    elseif ($n_args == 1 && is_numeric($args[0])) {
      // Unix timestamp:
      $datetime = '@' . $args[0];
    }
    elseif ($n_args <= 2) {
      // Args are assumed to be: $datetime, [$timezone], as for the DateTime constructor.
      $datetime = $args[0];
      $timezone = isset($args[1]) ? $args[1] : NULL;
    }
    elseif ($n_args <= 4) {
      // Args are assumed to be: $year, $month, $day, [$timezone].
      $date = self::zero_pad($args[0], 4) . '-' . self::zero_pad($args[1]) . '-' . self::zero_pad($args[2]);
      $time = '00:00:00';
      $datetime = "$date $time";
      $timezone = isset($args[3]) ? $args[3] : NULL;
    }
    elseif ($n_args >= 6 && $n_args <= 7) {
      // Args are assumed to be: $year, $month, $day, [$timezone].
      $date = self::zero_pad($args[0], 4) . '-' . self::zero_pad($args[1]) . '-' . self::zero_pad($args[2]);
      $time = self::zero_pad($args[3]) . ':' . self::zero_pad($args[4]) . ':' . self::zero_pad($args[5]);
      $datetime = "$date $time";
      $timezone = isset($args[6]) ? $args[6] : NULL;
    }
    else {
      trigger_error(E_USER_WARNING, "Invalid number of arguments to StarDateTime constructor.");
    }

    // Support string timezones:
    if (is_string($timezone)) {
      $timezone = new DateTimeZone($timezone);
    }

    // Check we have a valid timezone:
    if ($timezone !== NULL && !($timezone instanceof DateTimeZone)) {
      trigger_error(E_USER_WARNING, "Invalid timezone provided to StarDateTime constructor.");
    }

    // Call parent constructor:
    parent::__construct($datetime, $timezone);
  }

  /**
   * Pads a number with '0' characters up to a specified width.
   *
   * @param int $n
   * @param int $w
   * @return string
   */
  protected static function zero_pad($n, $w = 2) {
    return str_pad((int) $n, $w, '0', STR_PAD_LEFT);
  }

  /**
   * Convert the datetime to a string.
   *
   * @return string
   */
  public function __toString() {
    return $this->format('Y-m-d H:i:s P e');
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Getters/setters for date and time.

  /**
   * Gets or sets the date.
   *
   * @param int $year
   * @param int $month
   * @param int $day
   * @return StarDateTime
   */
  public function date($year = 1, $month = 1, $day = 1) {
    if (func_num_args() == 0) {
      // Get the date:
      return new StarDateTime($this->format('Y-m-d'));
    }
    else {
      // Set the date:
      return $this->setDate($year, $month, $day);
    }
  }

  /**
   * Gets or sets the time.
   *
   * @param int $hour
   * @param int $minute
   * @param int $second
   * @return DateInterval|DateTime
   */
  public function time($hour = 0, $minute = 0, $second = 0) {
    if (func_num_args() == 0) {
      // Get the time:
      return new DateInterval('PT' . $this->format('His'));
    }
    else {
      // Set the time:
      return $this->setTime($hour, $minute, $second);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Getters/setters for standard datetime parts.

  /**
   * Get or set the year.
   *
   * @param int $year
   * @return int|StarDateTime
   */
  public function year($year = 1) {
    if (func_num_args() == 0) {
      // Get the year:
      return (int) $this->format('Y');
    }
    else {
      // Set the year:
      return $this->date($year, $this->month(), $this->day());
    }
  }

  /**
   * Get or set the month.
   *
   * @param int $month
   * @return int|StarDateTime
   */
  public function month($month = 1) {
    if (func_num_args() == 0) {
      // Get the month:
      return (int) $this->format('n');
    }
    else {
      // Set the month:
      return $this->date($this->year(), $month, $this->day());
    }
  }

  /**
   * Get or set the day of the month.
   *
   * @param int $day
   * @return int|StarDateTime
   */
  public function day($day = 1) {
    if (func_num_args() == 0) {
      // Get the day of the month:
      return (int) $this->format('j');
    }
    else {
      // Set the day of the month:
      return $this->date($this->year(), $this->month(), $day);
    }
  }

  /**
   * Get or set the hour.
   *
   * @param int $hour
   * @return int|StarDateTime
   */
  public function hour($hour = 0) {
    if (func_num_args() == 0) {
      // Get the hour:
      return (int) $this->format('G');
    }
    else {
      // Set the hour:
      return $this->time($hour, $this->minute(), $this->second());
    }
  }

  /**
   * Get or set the minute.
   *
   * @param int $minute
   * @return int|StarDateTime
   */
  public function minute($minute = 0) {
    if (func_num_args() == 0) {
      // Get the minute:
      return (int) $this->format('i');
    }
    else {
      // Set the minute:
      return $this->time($this->hour(), $minute, $this->second());
    }
  }

  /**
   * Get or set the second.
   *
   * @param int $second
   * @return int|StarDateTime
   */
  public function second($second = 0) {
    if (func_num_args() == 0) {
      // Get the second:
      return (int) $this->format('s');
    }
    else {
      // Set the second:
      return $this->time($this->hour(), $this->minute(), $second);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Additional handy getters.

  /**
   * Get the timestamp.
   *
   * @return int
   */
  public function timestamp() {
    return $this->getTimestamp();
  }

  /**
   * Get the week of the year as an integer (1.. 52).
   *
   * @return int
   */
  public function week() {
    return (int) $this->format('W');
  }

  /**
   * Get the day of the year as an integer (1..366).
   *
   * @return int
   */
  public function dayOfYear() {
    return ((int) $this->format('z')) + 1;
  }

  /**
   * Get the day of the week as an integer (1..7).
   * 1 = Monday .. 7 = Sunday
   *
   * @return int
   */
  public function dayOfWeek() {
    return (int) $this->format('N');
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Add periods. These methods return a new StarDateTime object; they don't modify the calling object.

  /**
   * Add years.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function addYears($n) {
    $dt = clone $this;
    return $dt->year($dt->year() + $n);
  }

  /**
   * Add months.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function addMonths($n) {
    $dt = clone $this;
    return $dt->month($dt->month() + $n);
  }

  /**
   * Add weeks.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function addWeeks($n) {
    return $this->addDays($n * 7);
  }

  /**
   * Add days.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function addDays($n) {
    $dt = clone $this;
    return $dt->day($dt->day() + $n);
  }

  /**
   * Add hours.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function addHours($n) {
    $dt = clone $this;
    return $dt->hour($dt->hour() + $n);
  }

  /**
   * Add minutes.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function addMinutes($n) {
    $dt = clone $this;
    return $dt->minute($dt->minute() + $n);
  }

  /**
   * Add seconds.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function addSeconds($n) {
    $dt = clone $this;
    return $dt->second($dt->second() + $n);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Subtract periods. These methods return a new StarDateTime object; they don't modify the calling object.

  /**
   * Subtract years.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function subYears($n) {
    return $this->addYears(-$n);
  }

  /**
   * Subtract months.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function subMonths($n) {
    return $this->addMonths(-$n);
  }

  /**
   * Subtract weeks.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function subWeeks($n) {
    return $this->addWeeks(-$n);
  }

  /**
   * Subtract days.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function subDays($n) {
    return $this->addDays(-$n);
  }

  /**
   * Subtract hours.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function subHours($n) {
    return $this->addHours(-$n);
  }

  /**
   * Subtract minutes.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function subMinutes($n) {
    return $this->addMinutes(-$n);
  }

  /**
   * Subtract seconds.
   *
   * @param int $n
   * @return StarDateTime
   */
  public function subSeconds($n) {
    return $this->addSeconds(-$n);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Miscellaneous useful functions.

  /**
   * Clamp the year to a specified range.
   * Either min or max can be specified.
   *
   * @param int|null $min
   * @param int|null $max
   */
  public function clampYear($min = NULL, $max = NULL) {
    // Clamp to min year, if specified:
    if ($min !== NULL && $this->year() < $min) {
      $this->year($min);
    }
    // Clamp to max year, if specified:
    if ($max !== NULL && $this->year() > $max) {
      $this->year($max);
    }
  }

  /**
   * Generates a string describing how long ago a datetime was.
   *
   * @return string
   */
  public function aboutHowLongAgo() {
    $ts = $this->timestamp();
    $now = time();

    // Get the time difference in seconds:
    $seconds = $now - $ts;

    // Check time is in the past:
    if ($seconds < 0) {
      trigger_error("StarDateTime::aboutHowLongAgo() only works with datetimes in the past.", E_USER_WARNING);
      return FALSE;
    }

    // Now:
    if ($seconds == 0) {
      return 'now';
    }

    // Seconds:
    if ($seconds <= 20) {
      return $seconds == 1 ? 'a second' : "$seconds seconds";
    }

    // 5 seconds:
    if ($seconds < 58) {
      return (round($seconds / 5) * 5) . ' seconds';
    }

    // Minutes:
    $minutes = round($seconds / self::SECONDS_PER_MINUTE);
    if ($minutes <= 20) {
      return $minutes == 1 ? 'a minute' : "$minutes minutes";
    }

    // 5 minutes:
    if ($minutes < 58) {
      return (round($minutes / 5) * 5) . ' minutes';
    }

    // Hours:
    $hours = round($seconds / self::SECONDS_PER_HOUR);
    if ($hours < 48 && $hours % self::HOURS_PER_DAY != 0) {
      return $hours == 1 ? 'an hour' : "$hours hours";
    }

    // Days:
    $days = round($seconds / self::SECONDS_PER_DAY);
    if ($days < 28 && $days % self::DAYS_PER_WEEK != 0) {
      return $days == 1 ? 'a day' : "$days days";
    }

    // Weeks:
    $weeks = round($seconds / self::SECONDS_PER_WEEK);
    if ($weeks <= 12) {
      return $weeks == 1 ? 'a week' : "$weeks weeks";
    }

    // Months:
    $months = round($seconds / self::SECONDS_PER_MONTH);
    if ($months < 24 && $months % self::MONTHS_PER_YEAR != 0) {
      return $months == 1 ? 'a month' : "$months months";
    }

    // Years:
    $years = round($seconds / self::SECONDS_PER_YEAR);
    return $years == 1 ? 'a year' : "$years years";
  }

}
