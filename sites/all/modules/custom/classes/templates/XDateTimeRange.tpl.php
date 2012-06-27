<?php
// $Id$

/**
 * @file
 * Class to encapsulate CCK date and datetime fields, which have both a From and
 * To datetime.
 */

/**
 * This class encapsulates a CCK date or datetime field, storing the From and
 * To datetimes as XDateTime objects.
 *
 * @version <dt_generated>
 * @author shaunmoss
 */
class XDateTimeRange {

  /**
   * The From and To datetimes.
   *
   * @var XDateTime
   */
  protected $from = NULL;
  protected $to = NULL;

  /**
   * Constructor, create a new XDateTimeRange object.
   *
   * The parameters can be in any form accepted by the XDateTime
   * constructor, i.e. timestamps, datetime string, DateTime or XDateTime
   * objects, or XML-RPC datetime objects.
   *
   * @param mixed $from
   * @param mixed $to = NULL
   */
  public function __construct($from, $to = NULL) {
    // Allow the XDateTimeRange to be created from a CCK field:
    if (is_array($from) && $from['value']) {
      $to = $from['value2'];
      $tz = $from['timezone'];
      $from = $from['value'];
    }

    // Make the from datetime into an XDateTime:
    $this->from = $from instanceof XDateTime ? $from : new XDateTime($from, $tz);

    // Make the to datetime into an XDateTime, if provided:
    if ($to) {
      $this->to = $to instanceof XDateTime ? $to : new XDateTime($to, $tz);
    }
  }


  //////////////////////////////////////////////////////////////////////////////
  // Overload methods.

  /**
   * Passes the request to access an invisible property through to the
   * corresponding get method.
   *
   * For example $dtr->from can be used instead of $dtr->getFrom().
   *
   * @param string $name
   * @return mixed
   */
  public function &__get($name) {
    $method = 'get' . ucfirst($name);
    return $this->$method();
  }

  /**
   * Pass the request to modify an invisible property through to the
   * corresponding set method.
   *
   * For example, $dtr->from = $dt can be used instead of $dtr->setFrom($dt).
   *
   * @param string $name
   * @param mixed $value
   */
  public function __set($name, $value) {
    $method = 'set' . ucfirst($name);
    $this->$method($value);
  }

  /**
   * If any method gets called on the XDateTimeRange that it doesn't have, pass
   * it through to the $from datetime.
   *
   * For example, if $dtr->getYear() is called, it will get passed to
   * $dtr->from->getYear().
   *
   * @param string $method
   * @param array $params
   */
  public function __call($method, array $params) {
    return call_user_func_array(array($this->from, $method), $params);
  }


  //////////////////////////////////////////////////////////////////////////////
  // Range-related methods.

  /**
   * Return the difference in seconds between the From and To dates.
   * If the To date is earlier than the From date then the result will be
   * negative.
   *
   * @return int
   */
  public function diff() {
    // If there's no To datetime then we can't compute the difference.
    // Return FALSE to allow the user to check if this condition occurs.
    if (is_null($this->to)) {
      return FALSE;
    }
    // Calculate the difference between the datetimes:
    return $this->to->timestamp - $this->from->timestamp;
  }

  /**
   * Checks if the From and To datetimes are different.
   * If there's no To datetime, then it isn't assumed to be different from the
   * From datetime.
   *
   * Returns TRUE if:
   * a) There is only a From datetime, or
   * b) The From and To datetimes are equal.
   *
   * Note, I could have just used !$this->diff() here, but doing it this way
   * avoids the subtraction. A minor efficiency improvement.
   *
   * @return bool
   */
  public function noDiff() {
    // If there's no To datetime then there's no difference.
    if (is_null($this->to)) {
      return TRUE;
    }
    // Compare the datetimes:
    return $this->to->equal($this->from);
  }


  //////////////////////////////////////////////////////////////////////////////
  // Getters and setters for From and To dates.

  /**
   * Get the From date.
   *
   * @return XDateTime
   */
  public function getFrom() {
    return $this->from;
  }

  /**
   * Set the From date.
   *
   * @param mixed $datetime
   *   Any parameter suitable for the constructor.
   */
  public function setFrom($datetime) {
    $this->from = new XDateTime($datetime);
  }

  /**
   * Get the To date.
   *
   * @return XDateTime
   */
  public function getTo() {
    return $this->to;
  }

  /**
   * Set the To date.
   *
   * @param mixed $datetime
   *   Any parameter suitable for the constructor.
   */
  public function setTo($datetime) {
    $this->to = new XDateTime($datetime);
  }


  //////////////////////////////////////////////////////////////////////////////
  // Formatting methods.

  /**
   * Format the datetime range as a string, using the specified format.
   * If there's only a from date, then only this is included in the result.
   * If there's both a from and to date, then they will be joined by the
   * separator string, e.g. "2011-02-10 to 2012-12-21"
   *
   * @param string $format = 'medium'
   *   Either 'small', 'medium' or 'large' to use the datetime formats
   *   preconfigured in Drupal, or a regular date/datetime formatting string
   *   (@see date()).
   * @param string $separator = ' to '
   *   The string between the from and to dates.
   * @return string
   */
  public function format($format = 'medium', $separator = ' to ') {

    // Convert a Drupal format description to a datetime format string.
    // @see common.inc/format_date()
    switch ($format) {
      case 'small':
        $format = variable_get('date_format_short', 'm/d/Y - H:i');
        break;

      case 'large':
        $format = variable_get('date_format_long', 'l, F j, Y - H:i');
        break;

      case 'medium':
        $format = variable_get('date_format_medium', 'D, m/d/Y - H:i');
        break;
    }

    $result = $this->from->format($format);
    if ($this->to) {
      $result .= $separator . $this->to->format($format);
    }

    return $result;
  }

  /**
   * Format the datetime range as a string, using the specified format.
   * This method uses Drupal's format_date() function.
   *
   * If there's only a from date, then only this is included in the result.
   * If there's both a from and to date, then they will be joined by the
   * separator string, e.g. "2011-02-10 to 2012-12-21"
   *
   * @param string $format = 'medium'
   *   Either 'small', 'medium' or 'large' to use the datetime formats
   *   preconfigured in Drupal, or a regular date/datetime formatting string
   *   (@see date()).
   * @param string $separator = ' to '
   *   The string between the from and to dates.
   * @param string $timezone = NULL
   *   The timezone, defaults to user's timezone.
   * @param string $langcode = NULL
   *   Language code, defaults to the page's.
   * @return string
   */
  public function formatDrupal($format = 'medium', $separator = ' to ', $timezone = NULL, $langcode = NULL) {
    $result = $this->from->formatDrupal($format, $timezone, $langcode);
    if ($this->to) {
      $result .= $separator . $this->to->formatDrupal($format, $timezone, $langcode);
    }
    return $result;
  }


  //////////////////////////////////////////////////////////////////////////////
  // Conversion method.

  /**
   * Convert the object to an array. This exposes the values of the protected
   * and private properties of the object, which is useful when debugging.
   */
  public function toArray() {
    return get_object_vars($this);
  }

}
