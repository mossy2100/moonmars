
/**
 * Constants for class category options.
 */
var CLASSES_CATEGORY_ALL = 'all';
var CLASSES_CATEGORY_ENTITIES = 'entities';
var CLASSES_CATEGORY_TYPES = 'types';

/**
 * Constants for 'existing base class' options.
 */
var CLASSES_EXISTING_ALL = 'all';
var CLASSES_EXISTING_YES = 'yes';
var CLASSES_EXISTING_NO = 'no';

/**
 * Select types/classes based on filter selections.
 */
function classes_generate_filter() {
  var hiddenField;
  var updateCheckbox;
  
  // Get the values of the radio button options:
  var category = $('#edit-category-all-wrapper').parent().find("input:checked").val();
  var existing = $('#edit-existing-all-wrapper').parent().find("input:checked").val();
  // alert("category = " + category + ", existing = " + existing);
  
  // Loop through all entities & types checking if they should be selected:
  var hiddenFields = $('#classes-generate-form .base-class-exists');
  for (var i = 0; i < hiddenFields.length; i++) {
    hiddenField = hiddenFields.eq(i);
    row = hiddenField.parents('tr');
    updateCheckbox = true;
    
    // Determine whether to select this entity/type:
    
    // Category filter:
    switch (category) {
      case CLASSES_CATEGORY_ALL:
        category_filter_pass = true;
        break;

      case CLASSES_CATEGORY_ENTITIES:
        category_filter_pass = row.hasClass('class_entity');
        break;
        
      case CLASSES_CATEGORY_TYPES:
        category_filter_pass = row.hasClass('class_type');
        break;
        
      default:
        updateCheckbox = false;
        break;
    }
    
    // Existing base class filter:
    switch (existing) {
      case CLASSES_EXISTING_ALL:
        existing_filter_pass = true;
        break;

      case CLASSES_EXISTING_YES:
        existing_filter_pass = hiddenField.val() == 1;
        break;
        
      case CLASSES_EXISTING_NO:
        existing_filter_pass = hiddenField.val() == 0;
        break;
        
      default:
        updateCheckbox = false;
        break;
    }
    
    // Check the filters to determine whether the class should be generated or not:
    if (updateCheckbox) {
      if (category_filter_pass && existing_filter_pass) {
        // Select the type:
        row.find('input:checkbox').attr('checked', true);
      }
      else {
        // Deselect the type:
        row.find('input:checkbox').attr('checked', false);
      }
    }
  } // for

  // Update the row classes:
  classes_set_rows_style();
}

/**
 * Add the selected class to the row for every selected entity and type.
 */
function classes_set_rows_style() {
  var cells = $('#classes-generate-table .base-class-exists');
  for (var i = 0; i < cells.length; i++) {
    cell = cells.eq(i);
    row = cell.parents('tr');
    
    // Update the row color:
    if (row.find('input:checkbox').attr('checked')) {
      row.addClass('selected');
    }
    else {
      row.removeClass('selected');
    }
  }
}

/**
 * Select all classes for generation.
 */
function classes_generate_select_all() {
  $('#classes-generate-table input:checkbox').check();
  classes_set_rows_style();
  $('#edit-category-all').check();
  $('#edit-existing-all').check();
}

/**
 * Deselect all classes.
 */
function classes_generate_deselect_all() {
  $('#classes-generate-table input:checkbox').uncheck();
  classes_set_rows_style();
  $('#edit-category-all-wrapper').parent().find('input:radio').uncheck();
  $('#edit-existing-all-wrapper').parent().find('input:radio').uncheck();
}

// Set the selected CSS class on the correct rows on page load.
$(function () {
  // Set the initial row styles:
  classes_set_rows_style();
  
  // Whenever a checkbox is selected, we want the row style to change.
  $('#classes-generate-table input:checkbox').click(function() {
    row = $(this).parents('tr:first');
    // Update the row color:
    if ($(this).attr('checked')) {
      row.addClass('selected');
    }
    else {
      row.removeClass('selected');
    }
  });
  
});

