
var $ = jQuery;

$(function() {
  // Add some HTML around and after the username field:
  $('#edit-name').before("<div id='edit-name-wrapper'></div>").appendTo('#edit-name-wrapper');
  $('#edit-name-wrapper').append(
    "<div id='username-check'>Check</div>" +
    "<div id='username-waiting'></div>" +
    "<div id='username-message'></div>");

  $('#edit-name').keyup(function() {
    // Get the username:
    var username = $('#edit-name').val();

    if (username == '') {
      usernameInvalid('');
    }
    else if (validUsername(username)) {
      usernameCheck();
    }
    else {
      usernameInvalid('Invalid');
    }
  });

  $('#username-check').click(function() {
    // Get the username:
    var username = $('#edit-name').val();

    // Get the uid:
    var uid = $('#uid').val();

    if (!username) {
      alert("Enter a username before checking.");
    }
    else {
      usernameWaiting();
      $.get('/ajax/username-check', {username: username, uid: uid}, function(data, textStatus, jqXHR) {
        $('#username-message').text(data.reason);
        if (data.result) {
          usernameValid(data.message);
        }
        else {
          usernameInvalid(data.message);
        }
      }, 'json');
    }
  });

  $('#edit-name').keyup();
});

function usernameCheck() {
  $('#username-message').hide();
  $('#username-waiting').hide();
  $('#username-check').show();
}

function usernameWaiting() {
  $('#username-message').hide();
  $('#username-check').hide();
  $('#username-waiting').show();
}

function usernameInvalid(message) {
  $('#username-check').hide();
  $('#username-waiting').hide();
  $('#username-message').removeClass('username-valid').addClass('username-invalid').text(message).show();
}

function usernameValid(message) {
  $('#username-check').hide();
  $('#username-waiting').hide();
  $('#username-message').removeClass('username-invalid').addClass('username-valid').text(message).show();
}

/**
 * Check if a username is valid.
 *
 * @see moonmars_members_valid_username()
 *
 * @param $name
 * @return bool
 */
function validUsername(username) {
  return username.match(/^[a-z0-9\-\_]{1,60}$/i);
}
