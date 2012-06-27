<?php
// $Id$

/**
 * @file
 * Contains functions specifically related to the Generate classes form.
 */

/**
 * Create the form for selecting which classes to generate.
 *
 * @param array $form_state
 * @return array
 */
function classes_generate_form($form_state) {
  global $_classes_dir;
  
  $path = drupal_get_path('module', 'classes');

  $form = array();

  // Instructions:
  $form['instructions'] = array(
    '#type' => 'markup',
    '#value' =>
      "<p>" . t("Select which classes you want to generate for your entities and content types.") . "</p>" .
      "<p>" . t("If the base class already exists it will be overwritten.") . "</p>" .
      "<p>" . t("If the derived class does not exist then a stub will be created, but if it does exist it will not be overwritten.") . "</p>" .
      "<p>" . t("Helper classes such as XDateTime and XLink are not listed here. If a helper class does not exist, or is out of date, it will be generated automatically.") . "</p>",
  );

  // Filters:
  $form['filters'] = array(
    '#type' => 'fieldset',
    '#title' => t("Selection filters"),
    '#collapsible' => FALSE,
  );
  
  // Select/deselect buttons:
  $form['filters']['buttons'] = array(
    '#value' => "
      <input type='button' class='form-button' value='Select all' onclick='classes_generate_select_all()' />
      <input type='button' class='form-button' value='Select none' onclick='classes_generate_deselect_all()' />
    ",
  );
  
  // Category filter radio buttons:
  $category_filter = $_SESSION['classes_generate']['category'] ? $_SESSION['classes_generate']['category'] : 'none';
  $form['filters']['category'] = array(
    '#type' => 'radios',
    '#title' => t("Class category"),
    '#options' => array(
      CLASSES_CATEGORY_ALL => t("All"),
      CLASSES_CATEGORY_ENTITIES => t("Entities"),
      CLASSES_CATEGORY_TYPES => t("Content types"),
    ),
    '#description' => t("Select which category of classes you want to generate."),
    '#attributes' => array('onclick' => 'classes_generate_filter()'),
    '#default_value' => $category_filter,
  );

  // Generate new/regenerate existing filter radio buttons:
  $existing_filter = $_SESSION['classes_generate']['existing'] ? $_SESSION['classes_generate']['existing'] : 'none';
  $form['filters']['existing'] = array(
    '#type' => 'radios',
    '#title' => t("With or without an existing base class?"),
    '#options' => array(
      CLASSES_EXISTING_ALL => t("All"),
      CLASSES_EXISTING_YES => t("With an existing base class (regenerate)"),
      CLASSES_EXISTING_NO => t("Without an existing base class (generate new)"),
    ),
    '#description' => t("Select entities or types with or without an existing base class."),
    '#attributes' => array('onclick' => 'classes_generate_filter()'),
    '#default_value' => $existing_filter,
  );
  
  // Get all the info about the content types and classes:
  $options = array();
  $selected = array();
  
  // Get the entities:
  $entities = array_keys(array_filter(classes_entities()));
  sort($entities);

  // Get the content types:
  $types = array_keys(node_get_types());
  sort($types);

  // Loop through all entities and types to create the form table data:
  $form['#categories'] = array('entities' => $entities, 'types' => $types);
  foreach ($form['#categories'] as $category => $items) {
    foreach ($items as $item) {
      // Get class names and check existence:
      $exists = classes_check_existence($item, $category);
      
      // Add the option to the checkboxes list, with no label:
      $key = $category . '-' . $item;
      $options[$key] = '';

      // Determine if this class should be selected:

      // Category filter:
      switch ($category_filter) {
        case CLASSES_CATEGORY_ALL:
          $category_filter_pass = TRUE;
          break;

        case CLASSES_CATEGORY_ENTITIES:
          $category_filter_pass = in_array($item, $entities);
          break;

        case CLASSES_CATEGORY_TYPES:
          $category_filter_pass = !in_array($item, $entities);
          break;
        
        default:
          $category_filter_pass = FALSE;
          break;
      }
      
      // Existing base class filter:
      switch ($existing_filter) {
        case CLASSES_EXISTING_ALL:
          $existing_filter_pass = TRUE;
          break;

        case CLASSES_EXISTING_YES:
          $existing_filter_pass = $exists['base class']['exists'];
          break;

        case CLASSES_EXISTING_NO:
          $existing_filter_pass = !$exists['base class']['exists'];
          break;
        
        default:
          $existing_filter_pass = FALSE;
          break;
      }
      
      // If both filters pass then select the class:
      if ($category_filter_pass && $existing_filter_pass) {
        $selected[] = $key;
      }

      // Set the table cell values:
      $form['type'][$key] = array(
        '#value' => $item,
      );
      $form['class'][$key] = array(
        '#value' => $exists['class']['name'],
      );
      $form['class_exists'][$key] = array(
        '#value' => $exists['class']['exists'] ? t('Yes') : t('No'),
      );
      $form['base_class'][$key] = array(
        '#value' => $exists['base class']['name'],
      );
      $form['base_class_exists'][$key] = array(
        '#value' => ($exists['base class']['exists'] ? t('Yes') : t('No')) .
          "<input type='hidden' class='base-class-exists' value='" . ((int) $exists['base class']['exists']) . "'>",
      );
    }
  }

  $form['generate'] = array(
    '#type' => 'checkboxes',
    '#options' => $options,
    '#default_value' => is_array($_SESSION['classes_generate']['selected']) ? $_SESSION['classes_generate']['selected'] : $selected,
  );

  // Submit button:
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t("Generate classes"),
  );
  
  // Add the CSS and JS:
  $path = drupal_get_path('module', 'classes');
  drupal_add_css("$path/classes.css");
  drupal_add_js("$path/classes_generate_form.js");
  drupal_add_js("sites/all/libraries/jquery/jquery.check-uncheck.js");

  return $form;
}

/**
 * Theme the classes_generate_form.
 * 
 * @param array $form
 * @return string
 */
function theme_classes_generate_form($form) {
  // Construct table, starting with the header row:
  $header = array(
    t('Entity/Type'),
    t('Class'),
    t('Exists?'),
    t('Base class'),
    t('Exists?'),
    t('Generate?'),
  );

  $entities = array_keys(classes_entities());
  $rows = array();
  $type_heading_added = FALSE;
  $class = 'class_entity';
  
  $category_info = array(
    'entities' => array(
      'heading' => t("Entities"),
      'class' => 'class_entity',
    ),
    'types' => array(
      'heading' => t("Content types"),
      'class' => 'class_type',
    ),
  );
  
  foreach ($form['#categories'] as $category => $items) {
    // Heading row:
    $rows[] = array(
      array(
        'data' => $category_info[$category]['heading'],
        'class' => 'section-heading',
      ),
    );
    
    // Loop through items in this category:
    foreach ($items as $item) {
      // Get the array key:
      $key = $category . '-' . $item;
      
      // Add row:
      $rows[] = array(
        'class' => $category_info[$category]['class'],
        'data' => array(
          array(
            'data' => drupal_render($form['type'][$key]),
            'class' => 'type-name',
          ),
          drupal_render($form['class'][$key]),
          drupal_render($form['class_exists'][$key]),
          drupal_render($form['base_class'][$key]),
          drupal_render($form['base_class_exists'][$key]),
          array(
            'data' => drupal_render($form['generate'][$key]),
            'class' => 'checkbox',
          ),
        ),
      );
    }
  }

  // Generate HTML:
  $output =
    drupal_render($form['instructions']) .
    drupal_render($form['filters']) .
    theme('table', $header, $rows, array('id' => 'classes-generate-table')) .
    drupal_render($form);
  
  return $output;
}

/**
 * Submit handler for the classes_generate_form.
 *
 * @param array $form
 * @param array $form_state
 */
function classes_generate_form_submit($form, &$form_state) {
  require_once "classes_generate.inc";

  // Make sure directories and helper classes are setup:
  $classes = classes_setup();

  // Generate selected classes:
  $selected = array();
  foreach ($form_state['values']['generate'] as $key => $generate) {
    list($category, $item) = explode('-', $key);
    
    if ($generate) {
      // Remember this item was selected:
      $selected[] = $key;
      
      // If it's an entity, generate entity classes:
      if ($category == 'entities') {
        $classes = array_merge($classes, classes_generate_entity_classes($item, TRUE));
      }
      else {
        // It's a content type, so generate type classes:
        $classes = array_merge($classes, classes_generate_type_classes($item));
      }
    }
  }

  // Remember the checked types:
  $_SESSION['classes_generate']['selected'] = $selected;
  $_SESSION['classes_generate']['category'] = $form_state['values']['category'];
  $_SESSION['classes_generate']['existing'] = $form_state['values']['existing'];

  // Tell the user what happened:
  if (empty($classes)) {
    drupal_set_message(t("No class files were generated."));
  }
  else {
    classes_generated_message($classes);
  }
}
