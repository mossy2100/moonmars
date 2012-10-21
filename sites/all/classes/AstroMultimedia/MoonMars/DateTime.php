<?php
namespace AstroMultimedia\MoonMars;

/**
 * Created by JetBrains PhpStorm.
 * User: shaun
 * Date: 2012-09-17
 * Time: 7:24 PM
 * To change this template use File | Settings | File Templates.
 */
class DateTime extends \AstroMultimedia\Star\DateTime {

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Datetime formats

  /**
   * Format for long datetimes, without timezone.
   */
  const FORMAT_DATETIME_LONG = 'D Y-m-d H:i:s';

  /**
   * Format for long datetimes, with timezone.
   */
  const FORMAT_DATETIME_LONG_TZ = 'D Y-m-d H:i:s T';

  /**
   * Format for ISO datetimes, without timezone.
   */
  const FORMAT_DATETIME_ISO = 'Y-m-d H:i:s';

  /**
   * Format for ISO datetimes, with timezone.
   */
  const FORMAT_DATETIME_ISO_TZ = 'Y-m-d H:i:s T';

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Date formats

  /**
   * Format for long dates, without timezone.
   */
  const FORMAT_DATE_LONG = 'D Y-m-d';

  /**
   * Format for long dates, with timezone.
   */
  const FORMAT_DATE_LONG_TZ = 'D Y-m-d T';

  /**
   * Format for ISO dates, without timezone.
   */
  const FORMAT_DATE_ISO = 'Y-m-d';

  /**
   * Format for ISO dates, with timezone.
   */
  const FORMAT_DATE_ISO_TZ = 'Y-m-d T';

  /**
   * Display the datetime in the current member's timezone.
   *
   * @return string
   */
  public function formatMemberTZ($format) {
    // Get the logged-in member's timezone:
    $logged_in_member = Member::loggedInMember();
    $tz = $logged_in_member->timezone();
    $this->timezone($tz);
    return parent::format($format);
  }

}
