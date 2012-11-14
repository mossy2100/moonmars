var $ = jQuery;

var currentQuicksearchText;
var quicksearchCache = {};
var currentItem;

/**
 * Position and size the results box relative to the textbox.
 */
function quicksearchResize() {
  var quicksearchTextBox = $('form#moonmars-quicksearch-form input#edit-quicksearch-text');
  var quicksearchResultsBox = $('form#moonmars-quicksearch-form #quicksearch-results');

  // Get the textbox position and dimensions:
  var tbPos = quicksearchTextBox.position();
  var tbWidth = quicksearchTextBox.borderBoxWidth();
  var tbHeight = quicksearchTextBox.borderBoxHeight();

  // Get the width of the content area:
  var contentWidth = $('#zone-content').contentWidth();

  // Set the position and the min and max width of the results box:
  var resultsWidth = quicksearchResultsBox.borderBoxWidth();
  var resultsLeft = tbPos.left + tbWidth - resultsWidth;
  var resultsTop = tbPos.top + tbHeight - 1;
  quicksearchResultsBox.css({
    left: resultsLeft + 'px',
    top: resultsTop,
    'min-width': tbWidth - 2 + 'px',
    'max-width': contentWidth - 22 + 'px'
  });
}

function quicksearchInit() {
  quicksearchResize();
  $(window).resize(quicksearchResize);

  var quicksearchTextBox = $('form#moonmars-quicksearch-form input#edit-quicksearch-text');
  var quicksearchResultsBox = $('form#moonmars-quicksearch-form #quicksearch-results');

  quicksearchTextBox.keyup(function() {
    var quicksearchText = $(this).val();
    if (quicksearchText.length < 3) {
      // Hide the results box:
      quicksearchResultsBox.hide();
    }
    else if (quicksearchText != currentQuicksearchText) {
      currentQuicksearchText = quicksearchText;

      // Check the cache:
      var lcQuicksearchText = quicksearchText.toLowerCase();
      if (lcQuicksearchText in quicksearchCache) {
        updateQuicksearchResults(quicksearchCache[lcQuicksearchText]);
      }
      else {
        // Request matches:
        $.get('/ajax/quicksearch/' + quicksearchText, {}, quicksearchResultsReceived, 'json');
      }
    }
  });

  // When the user's mouse leaves the result box, fade it out after half a second:
  quicksearchResultsBox.mouseleave(function() {
    window.setTimeout(function() {
      $('form#moonmars-quicksearch-form #quicksearch-results').fadeOut('fast');
    }, 500);
  })

  // Capture up and down arrows and enter key, for keyboard navigation of search results:
  $(document).keydown(function(e) {
    // Check that the results box is visible:
    var quicksearchResultsBox = $('form#moonmars-quicksearch-form #quicksearch-results');
    if (!quicksearchResultsBox.is(':visible')) {
      return;
    }

    // Down arrow:
    if (e.keyCode == 40) {
      if (currentItem === undefined) {
        // Select first item:
        currentItem = quicksearchResultsBox.find('li:first-child');
        currentItem.addClass('hover');
      }
      else {
        // Get the next item after it if there is one:
        currentItem.removeClass('hover');
        var nextItem = currentItem.next('li');
        if (nextItem.length) {
          currentItem = nextItem;
          currentItem.addClass('hover');
        }
        else {
          currentItem = undefined;
        }
      }
      return false;
    }

    // Up arrow:
    if (e.keyCode == 38) {
      if (currentItem === undefined) {
        // Select last item:
        currentItem = quicksearchResultsBox.find('li:last-child');
        currentItem.addClass('hover');
      }
      else {
        // Get the prev item if there is one:
        currentItem.removeClass('hover');
        var prevItem = currentItem.prev('li');
        if (prevItem.length) {
          currentItem = prevItem;
          currentItem.addClass('hover');
        }
        else {
          currentItem = undefined;
        }
      }
      return false;
    }
  });

  // Capture form submit event:
  $('form#moonmars-quicksearch-form').submit(function() {
    // If an item is highlighted, go to that item. Otherwise submit the form for a search.
    if (currentItem !== undefined) {
//      alert(currentItem.find('a').attr('href'));
      location.href = currentItem.find('a').attr('href');
    }
    return false;
  });
}

function updateQuicksearchResults(html) {
  var quicksearchResultsBox = $('form#moonmars-quicksearch-form #quicksearch-results');
  quicksearchResultsBox.html(html);
  quicksearchResize();
  quicksearchResultsBox.show();

  // Add/remove the hover classes on list items:
  quicksearchResultsBox.find('li').mouseenter(function() {
    if (currentItem !== undefined) {
      currentItem.removeClass('hover');
    }
    currentItem = $(this);
    currentItem.addClass('hover');
  });

  currentItem = undefined;
}

function quicksearchResultsReceived(data, textStatus, jqXHR) {
  var quicksearchResultsBox = $('form#moonmars-quicksearch-form #quicksearch-results');
  if (data.html) {
    // Update the results box:
    updateQuicksearchResults(data.html);
    // Add the response to the cache:
    quicksearchCache[data.text] = data.html;
  }
  else {
    quicksearchResultsBox.hide();
  }
}

$(quicksearchInit);
