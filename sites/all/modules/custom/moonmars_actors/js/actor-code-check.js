var $ = jQuery;

function actorCodeCheckSetup(actorType, actorCodeFieldId) {
  // Get the jQuery object for the text field containing the code:
  var tfActorCode = $('#' + actorCodeFieldId);

  // Get the appropriate mark character for actor type:
  var mark = actorType == 'member' ? '@' : '#';

  // Add some HTML around and after the actor code field:
  tfActorCode.before("<div id='actor-code-wrapper'><div id='actor-code-mark'>" + mark + "</div></div>").appendTo('#actor-code-wrapper');
  $('#actor-code-wrapper').append(
    "<div id='actor-code-check'>Check</div>" +
      "<div id='actor-code-waiting'></div>" +
      "<div id='actor-code-message'></div>");

  // Add keyup behaviour:
  $('#' + actorCodeFieldId).keyup(function() {
    // If code is valid, show the check link:
    if (validActorCode(tfActorCode.val())) {
      actorCodeShowCheckLink();
    }
    else {
      // If not, show "Invalid":
      actorCodeShowInvalidMessage('Invalid');
    }
  }).blur(function() {
    // If code is valid, check it:
    if (validActorCode(tfActorCode.val())) {
      actorCodeCheck(actorType, tfActorCode);
    }
    else {
      // If not, show "Invalid":
      actorCodeShowInvalidMessage('Invalid');
    }
  });
}

/**
 * Check the actor code.
 *
 * @param string actorType
 * @param object tfActorCode
 */
function actorCodeCheck(actorType, tfActorCode) {
//  console.log('actorCodeCheck');

  // Get the actor code:
  var actorCode = tfActorCode.val();

  if (!actorCode) {
    actorCodeShowInvalidMessage('Invalid');
  }
  else {
    // Show the waiting icon:
    actorCodeShowWaitingIcon();

    // Get the actorId:
    var actorId = $('#' + (actorType == 'member' ? 'uid' : 'nid')).val();

    // Make an AJAX callback to check the actor code:
    $.get('/ajax/check-actor-code', {
      actorType: actorType,
      actorCode: actorCode,
      actorId: actorId
    }, function(data, textStatus, jqXHR) {
      $('#actor-code-message').text(data.reason);
      if (data.result) {
        actorCodeShowValidMessage(data.message);
      }
      else {
        actorCodeShowInvalidMessage(data.message);
      }
    }, 'json');
  }
}

/**
 * Show the Check link.
 */
function actorCodeShowCheckLink() {
  $('#actor-code-message').hide();
  $('#actor-code-waiting').hide();
  $('#actor-code-check').show();
}

/**
 * Show the Waiting icon.
 */
function actorCodeShowWaitingIcon() {
  $('#actor-code-message').hide();
  $('#actor-code-check').hide();
  $('#actor-code-waiting').show();
}

/**
 * Show an Invalid message.
 */
function actorCodeShowInvalidMessage(message) {
  $('#actor-code-check').hide();
  $('#actor-code-waiting').hide();
  $('#actor-code-message').removeClass('actor-code-valid').addClass('actor-code-invalid').text(message).show();
}

/**
 * Show a Valid message.
 */
function actorCodeShowValidMessage(message) {
  $('#actor-code-check').hide();
  $('#actor-code-waiting').hide();
  $('#actor-code-message').removeClass('actor-code-invalid').addClass('actor-code-valid').text(message).show();
}

/**
 * Check if a actor code is valid.
 *
 * @see moonmars_actors_valid_code()
 *
 * @param string actorCode
 * @return bool
 */
function validActorCode(actorCode) {
  return actorCode.match(/^[a-z0-9\-\_]{3,60}$/i);
}
