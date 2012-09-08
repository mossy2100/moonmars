var $ = jQuery;

$(function() {
  // Set the state of the Subscribed? "set all" checkbox.
  setStateSubscribedAll();

  // Set behaviour of Subscribed? "set all" checkbox.
  $('input#subscribed-all').click(function() {
    var subscribeAll = $(this).checked();
    if (subscribeAll) {
      $('input.subscribed').each(function() {
        var cb_subscribed = $(this);
        if (cb_subscribed.unchecked()) {
          cb_subscribed.check();
          var cb_email_notification = cb_subscribed.closest('tr').find('input.email-notification');
          cb_email_notification.enable().check();
        }
      });
    }
    else {
      $('input.subscribed').uncheck();
      $('input.email-notification').disable().uncheck();
    }
    setStateEmailNotificationAll();
  });

  // Set behaviour of subscribed checkboxes:
  $('input.subscribed').click(function() {
    // Set the state of the "Subscribe all" checkbox:
    setStateSubscribedAll();

    var cb_subscribed = $(this);
    var cb_email_notification = cb_subscribed.closest('tr').find('input.email-notification');

    if (cb_subscribed.checked()) {
      cb_email_notification.enable().check();
    }
    else {
      cb_email_notification.disable().uncheck();
    }
  });

  // Set the state of the Email notifications? "set all" checkbox.
  setStateEmailNotificationAll();
  $('input.email-notification').click(setStateEmailNotificationAll);

  // Set behaviour of the Email notifications? "set all" checkbox.
  $('input#email-notification-all').click(function() {
    if ($(this).checked()) {
      $('input.subscribed').each(function() {
        var cb_subscribed = $(this);
        if (cb_subscribed.checked()) {
          var cb_email_notification = cb_subscribed.closest('tr').find('input.email-notification');
          cb_email_notification.check();
        }
      });
    }
    else {
      $('input.email-notification').uncheck();
    }
  });

});

function setStateSubscribedAll() {
  if ($('input.subscribed').length == $('input.subscribed:checked').length) {
    // All checked:
    $('input#subscribed-all').check();
  }
  else {
    // Some unchecked:
    $('input#subscribed-all').uncheck();
  }
}

function setStateEmailNotificationAll() {
  if ($('input.email-notification').length == $('input.email-notification:checked').length) {
    // All checked:
    $('input#email-notification-all').check();
  }
  else {
    // Some unchecked:
    $('input#email-notification-all').uncheck();
  }
}
