var $ = jQuery;

function starTagCheckSetup(starType, starTagFieldId) {
  // Get the jQuery object for the text field containing the tag:
  var tfStarTag = $('#' + starTagFieldId);

  // Get the appropriate prefix character for the star type:
  var prefix = Drupal.settings.tagPrefixes[starType];

  // Add some HTML around and after the star tag field:
  tfStarTag.before("<div id='star-tag-wrapper'><div id='star-tag-prefix'>" + prefix + "</div></div>").appendTo('#star-tag-wrapper');
  $('#star-tag-wrapper').append(
    "<div id='star-tag-check'>Check</div>" +
      "<div id='star-tag-waiting'></div>" +
      "<div id='star-tag-message'></div>");

  // Add keyup behaviour:
  $('#' + starTagFieldId).keyup(function() {
    // If tag is valid, show the check link:
    if (validStarTag(tfStarTag.val())) {
      starTagShowCheckLink();
    }
    else {
      // If not, show "Invalid":
      starTagShowInvalidMessage('Invalid');
    }
  }).blur(function() {
    // If tag is valid, check it:
    if (validStarTag(tfStarTag.val())) {
      starTagCheck(starType, tfStarTag);
    }
    else {
      // If not, show "Invalid":
      starTagShowInvalidMessage('Invalid');
    }
  });
}

/**
 * Check the star tag.
 *
 * @param string starType
 * @param object tfStarTag
 */
function starTagCheck(starType, tfStarTag) {
//  console.log('starTagCheck');

  // Get the star tag:
  var starTag = tfStarTag.val();

  if (!starTag) {
    starTagShowInvalidMessage('Invalid');
  }
  else {
    // Show the waiting icon:
    starTagShowWaitingIcon();

    // Get the starId:
    var starId = $('#' + (starType == 'member' ? 'uid' : 'nid')).val();

    // Make an AJAX callback to check the star tag:
    $.get('/ajax/check-star-tag', {
      starTag: starTag,
      starType: starType,
      starId: starId
    }, function(data, textStatus, jqXHR) {
      $('#star-tag-message').text(data.reason);
      if (data.result) {
        starTagShowValidMessage(data.message);
      }
      else {
        starTagShowInvalidMessage(data.message);
      }
    }, 'json');
  }
}

/**
 * Show the Check link.
 */
function starTagShowCheckLink() {
  $('#star-tag-message').hide();
  $('#star-tag-waiting').hide();
  $('#star-tag-check').show();
}

/**
 * Show the Waiting icon.
 */
function starTagShowWaitingIcon() {
  $('#star-tag-message').hide();
  $('#star-tag-check').hide();
  $('#star-tag-waiting').show();
}

/**
 * Show an Invalid message.
 */
function starTagShowInvalidMessage(message) {
  $('#star-tag-check').hide();
  $('#star-tag-waiting').hide();
  $('#star-tag-message').removeClass('star-tag-valid').addClass('star-tag-invalid').text(message).show();
}

/**
 * Show a Valid message.
 */
function starTagShowValidMessage(message) {
  $('#star-tag-check').hide();
  $('#star-tag-waiting').hide();
  $('#star-tag-message').removeClass('star-tag-invalid').addClass('star-tag-valid').text(message).show();
}

/**
 * Check if a star tag is valid.
 *
 * @see moonmars_stars_valid_tag()
 *
 * @param string starTag
 * @return bool
 */
function validStarTag(starTag) {
  return starTag.match(/^[a-z0-9\-\_]{3,60}$/i);
}
