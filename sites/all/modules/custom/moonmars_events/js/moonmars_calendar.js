var $ = jQuery;

$(function () {

  $('.view-calendar .view-filters').prependTo('.view-calendar .view-header');
  $('.view-calendar .view-filters').prepend('<h3>Filters</h3>');

  // Set the previous and next button labels:
  if (Drupal.settings.calendar.prevLabel) {
    $('.view-calendar ul.pager li.date-prev a').text(Drupal.settings.calendar.prevLabel);
  }
  else {
    $('.view-calendar ul.pager li.date-prev a').remove();
  }
  if (Drupal.settings.calendar.nextLabel) {
    $('.view-calendar ul.pager li.date-next a').text(Drupal.settings.calendar.nextLabel);
  }
  else {
    $('.view-calendar ul.pager li.date-next a').remove();
  }

  // Insert links to other views:
  var links = "<div id='calendar-template-links'><a href='/events/year'>Year</a> | <a href='/events'>Month</a> | <a href='/events/day'>Day</a></div>";
  $('.view-calendar > .view-header > .date-nav-wrapper > .date-nav').prepend(links);

  // Get the date parts:
  var selectedDate = new Date(Drupal.settings.calendar.selectedDate);
  var selectedYear = selectedDate.getFullYear();
  var selectedMonth = selectedDate.getMonth() + 1;
  var selectedDay = selectedDate.getDate();

  // Create some HTML for the date selectors.
  var selectors = "<div id='calendar-selectors'>";

  // Create the year selector:
  selectors += "<select class='calendar-year'>";
  for (var y = Drupal.settings.calendar.minYear; y <= Drupal.settings.calendar.maxYear; y++) {
    selectors += "<option value='" + y + "'";
    if (y == selectedYear) {
      selectors += " selected";
    }
    selectors += ">" + y + "</option>";
  }
  selectors += "</select>";

  // Create the month selector:
  if (Drupal.settings.calendar.template == 'day' || Drupal.settings.calendar.template == 'month') {
    var months = [
      '',
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
      'August',
      'September',
      'October',
      'November',
      'December'
    ];
    selectors += "<select class='calendar-month'>";
    var mm;
    for (var m = 1; m <= 12; m++) {
      mm = (m < 10) ? ('0' + m) : m;
      selectors += "<option value='" + mm + "'";
      if (m == selectedMonth) {
        selectors += " selected";
      }
      selectors += ">" + months[m] + "</option>";
    }
    selectors += "</select>";
  }

  // Create the day selector, if needed:
  if (Drupal.settings.calendar.template == 'day') {
    selectors += "<select class='calendar-day'>";
    var dd;
    for (var d = 0; d <= daysInMonth(selectedYear, selectedMonth); d++) {
      dd = (d < 10) ? ('0' + d) : d;
      selectors += "<option value='" + dd + "'";
      if (d == selectedDay) {
        selectors += " selected";
      }
      selectors += ">" + d + "</option>";
    }
    selectors += "</select>";
  }

  selectors += "</div>";

  // Add the selectors to the calendar header.
  $('.view-calendar > .view-header > .date-nav-wrapper > .date-nav').append(selectors);

  // If any of the date selectors change, refresh the calendar:
  $('.view-calendar .date-nav select').change(function() {
    var year = $("select.calendar-year").selectBox('value');
    var month = $("select.calendar-month").selectBox('value');
    var day = $("select.calendar-day").selectBox('value');

    switch (Drupal.settings.calendar.template) {
      case 'year':
        location.href = '/events/year/' + year;
        break;

      case 'month':
        location.href = '/events/' + year + '-' + month;
        break;

      case 'day':
        location.href = '/events/day/' + year + '-' + month + '-' + day;
        break;
    }
  });
});

/**
 * Get the number of days in a month.
 *
 * @param int year
 * @param int month 1..12
 * @return int
 */
function daysInMonth(year, month) {
  return new Date(year, month, 0).getDate();
}
