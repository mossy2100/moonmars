var $ = jQuery;

function actorCodeCheckSetup(actorType, actorCodeFieldId) {
  // Get the jQuery object for the text field containing the code:
  var tfActorCode = $('#' + actorCodeFieldId);

  // Get the appropriate prefix character for the actor type:
  var prefix = Drupal.settings.tagPrefixes[actorType];

  // Add some HTML around and after the actor tag field:
  tfActorCode.before("<div id='actor-tag-wrapper'><div id='actor-tag-prefix'>" + prefix + "</div></div>").appendTo('#actor-tag-wrapper');
  $('#actor-tag-wrapper').append(
    "<div id='actor-tag-check'>Check</div>" +
      "<div id='actor-tag-waiting'></div>" +
      "<div id='actor-tag-message'></div>");

  // Add keyup behaviour:
  $('#' + actorCodeFieldId).keyup(function() {
    // If tag is valid, show the check link:
    if (validActorCode(tfActorCode.val())) {
      actorCodeShowCheckLink();
    }
    else {
      // If not, show "Invalid":
      actorCodeShowInvalidMessage('Invalid');
    }
  }).blur(function() {
    // If tag is valid, check it:
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
 * Check the actor tag.
 *
 * @param string actorType
 * @param object tfActorCode
 */
function actorCodeCheck(actorType, tfActorCode) {
//  console.log('actorCodeCheck');

  // Get the actor tag:
  var actorCode = tfActorCode.val();

  if (!actorCode) {
    actorCodeShowInvalidMessage('Invalid');
  }
  else {
    // Show the waiting icon:
    actorCodeShowWaitingIcon();

    // Get the actorId:
    var actorId = $('#' + (actorType == 'member' ? 'uid' : 'nid')).val();

    // Make an AJAX callback to check the actor tag:
    $.get('/ajax/check-actor-tag', {
      actorType: actorType,
      actorCode: actorCode,
      actorId: actorId
    }, function(data, textStatus, jqXHR) {
      $('#actor-tag-message').text(data.reason);
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
  $('#actor-tag-message').hide();
  $('#actor-tag-waiting').hide();
  $('#actor-tag-check').show();
}

/**
 * Show the Waiting icon.
 */
function actorCodeShowWaitingIcon() {
  $('#actor-tag-message').hide();
  $('#actor-tag-check').hide();
  $('#actor-tag-waiting').show();
}

/**
 * Show an Invalid message.
 */
function actorCodeShowInvalidMessage(message) {
  $('#actor-tag-check').hide();
  $('#actor-tag-waiting').hide();
  $('#actor-tag-message').removeClass('actor-tag-valid').addClass('actor-tag-invalid').text(message).show();
}

/**
 * Show a Valid message.
 */
function actorCodeShowValidMessage(message) {
  $('#actor-tag-check').hide();
  $('#actor-tag-waiting').hide();
  $('#actor-tag-message').removeClass('actor-tag-invalid').addClass('actor-tag-valid').text(message).show();
}

/**
 * Check if a actor tag is valid.
 *
 * @see moonmars_actors_valid_tag()
 *
 * @param string actorCode
 * @return bool
 */
function validActorCode(actorCode) {
  return actorCode.match(/^[a-z0-9\-\_]{3,60}$/i);
}
