
// Global variables to store detected geographical information:

var userLocationDetectionAttempted = false;
var userLocationDetectionError = undefined;
var userLocationDetected = false;
var userLocation = undefined;

var userTimezoneDetectionAttempted = false;
var userTimezoneDetectionError = undefined;
var userTimezoneDetected = false;
var userTimezone = undefined;


/**
 * Use geolocation to get the user's location if possible.
 */
function detectLocation(successCallback, errorCallback) {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function(location) {
        userLocationDetectionAttempted = true;
        userLocationDetected = true;
        userLocation = location;
        successCallback(location);
      },
      function(jqXHR, textStatus, errorThrown) {
        userLocationDetectionAttempted = true;
        userLocationDetected = false;
        if (errorCallback) {
          errorCallback(jqXHR, textStatus, errorThrown);
        }
      }
    );
  }
  else {
    return false;
  }
}

/**
 * Detect and set the user's timezone.
 *
 * @param successCallback
 *   Function to call if the timezone successfully detected.
 * @param errorCallback
 *   Function to call if the timezone not successfully detected.
 */
function detectTimezone(successCallback, errorCallback) {
  // Do we have the location yet?
  if (!userLocationDetectionAttempted) {
    detectLocation(
      function(location) {
        detectTimezone(successCallback, errorCallback);
      },
      function(jqXHR, textStatus, errorThrown) {
        if (errorCallback) {
          errorCallback(jqXHR, textStatus, errorThrown);
        }
      }
    );
  }
  else if (userLocationDetected && !userTimezoneDetectionAttempted) {
    // The location has been detected but we have not yet attempted to detect the timezone, so let's do it now.
    // Use geonames to get the user's timezone:
    jQuery.ajax({
      url: "http://api.geonames.org/timezoneJSON",
      data: {
        lat: userLocation.coords.latitude,
        lng: userLocation.coords.longitude,
        username: 'moonmars'
      },
      success: function(timezone) {
        userTimezoneDetectionAttempted = true;
        if (timezone.timezoneId) {
          userTimezoneDetected = true;
          userTimezone = timezone;
          successCallback(userTimezone);
        }
        else if (errorCallback) {
          // This could be an issue because the parameter list doesn't match.
          errorCallback(timezone);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        userTimezoneDetectionAttempted = true;
        userTimezoneDetected = false;
        if (errorCallback) {
          errorCallback(jqXHR, textStatus, errorThrown);
        }
      }
    });
  }
  else if (userTimezoneDetected) {
    successCallback(userTimezone);
  }
  else {
    return false;
  }
}
