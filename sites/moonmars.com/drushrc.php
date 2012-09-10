<?php 


$options['db_type'] = 'mysql';
$options['db_host'] = 'localhost';
$options['db_port'] = '3306';
$options['db_passwd'] = 'YD4N2KqGVB';
$options['db_name'] = 'moonmarscom';
$options['db_user'] = 'moonmarscom';
$options['site_ip_addresses'] = array (
  '@server_master' => '106.187.51.162',
);
$options['installed'] = true;
$options['packages'] = array (
  'platforms' => 
  array (
    'drupal' => 
    array (
      'short_name' => 'drupal',
      'version' => '7.15',
      'description' => 'This platform is running Drupal 7.15',
    ),
  ),
  'profiles' => 
  array (
    'standard' => 
    array (
      'name' => 'standard',
      'filename' => '/var/aegir/platforms/moonmars-1.x/profiles/standard/standard.profile',
      'project' => 'drupal',
      'info' => 
      array (
        'name' => 'Standard',
        'description' => 'Install with commonly used features pre-configured.',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'block',
          1 => 'color',
          2 => 'comment',
          3 => 'contextual',
          4 => 'dashboard',
          5 => 'help',
          6 => 'image',
          7 => 'list',
          8 => 'menu',
          9 => 'number',
          10 => 'options',
          11 => 'path',
          12 => 'taxonomy',
          13 => 'dblog',
          14 => 'search',
          15 => 'shortcut',
          16 => 'toolbar',
          17 => 'overlay',
          18 => 'field_ui',
          19 => 'file',
          20 => 'rdf',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
        'languages' => 
        array (
          0 => 'en',
        ),
        'old_short_name' => 'default',
      ),
      'version' => '7.15',
      'status' => 1,
    ),
  ),
  'modules' => 
  array (
    'aaa_update_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/update/tests/aaa_update_test.module',
      'name' => 'aaa_update_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'AAA Update test',
        'description' => 'Support module for update module testing.',
        'package' => 'Testing',
        'core' => '7.x',
        'hidden' => true,
        'version' => '7.15',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'actions_loop_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/actions_loop_test.module',
      'name' => 'actions_loop_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Actions loop test',
        'description' => 'Support module for action loop testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'actions_permissions' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/views_bulk_operations/actions_permissions.module',
      'name' => 'actions_permissions',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Actions permissions',
        'description' => 'Integrates actions with the permission system.',
        'package' => 'Administration',
        'core' => '7.x',
        'version' => '7.x-3.0-rc1',
        'project' => 'views_bulk_operations',
        'datestamp' => '1328576162',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'views_bulk_operations',
      'version' => '7.x-3.0-rc1',
    ),
    'addressfield' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/addressfield/addressfield.module',
      'name' => 'addressfield',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7000',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Address Field',
        'description' => 'Manage a flexible address field, implementing the xNAL standard.',
        'core' => '7.x',
        'package' => 'Fields',
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'files' => 
        array (
          0 => 'views/addressfield_views_handler_filter_country.inc',
        ),
        'version' => '7.x-1.0-beta3',
        'project' => 'addressfield',
        'datestamp' => '1338304248',
        'php' => '5.2.4',
      ),
      'project' => 'addressfield',
      'version' => '7.x-1.0-beta3',
    ),
    'addressfield_example' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/addressfield/example/addressfield_example.module',
      'name' => 'addressfield_example',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Address Field Example',
        'description' => 'Example module for how to implement an addressfield format handler.',
        'core' => '7.x',
        'package' => 'Fields',
        'hidden' => true,
        'dependencies' => 
        array (
          0 => 'ctools',
          1 => 'addressfield',
        ),
        'version' => '7.x-1.0-beta3',
        'project' => 'addressfield',
        'datestamp' => '1338304248',
        'php' => '5.2.4',
      ),
      'project' => 'addressfield',
      'version' => '7.x-1.0-beta3',
    ),
    'admin_devel' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/admin_menu/admin_devel/admin_devel.module',
      'name' => 'admin_devel',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Administration Development tools',
        'description' => 'Administration and debugging functionality for developers and site builders.',
        'package' => 'Administration',
        'core' => '7.x',
        'scripts' => 
        array (
          0 => 'admin_devel.js',
        ),
        'version' => '7.x-3.0-rc3',
        'project' => 'admin_menu',
        'datestamp' => '1337292349',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'admin_menu',
      'version' => '7.x-3.0-rc3',
    ),
    'admin_menu' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/admin_menu/admin_menu.module',
      'name' => 'admin_menu',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7304',
      'weight' => '100',
      'info' => 
      array (
        'name' => 'Administration menu',
        'description' => 'Provides a dropdown menu to most administrative tasks and other common destinations (to users with the proper permissions).',
        'package' => 'Administration',
        'core' => '7.x',
        'configure' => 'admin/config/administration/admin_menu',
        'dependencies' => 
        array (
          0 => 'system (>7.10)',
        ),
        'files' => 
        array (
          0 => 'tests/admin_menu.test',
        ),
        'version' => '7.x-3.0-rc3',
        'project' => 'admin_menu',
        'datestamp' => '1337292349',
        'php' => '5.2.4',
      ),
      'project' => 'admin_menu',
      'version' => '7.x-3.0-rc3',
    ),
    'admin_menu_fix' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/admin_menu_fix/admin_menu_fix.module',
      'name' => 'admin_menu_fix',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Administration Menu Fix',
        'description' => 'Fixes a couple of issues with admin_menu, specifically the lack of "Add content" links.',
        'core' => '7.x',
        'package' => 'Administration',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'admin_menu_toolbar' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/admin_menu/admin_menu_toolbar/admin_menu_toolbar.module',
      'name' => 'admin_menu_toolbar',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Administration menu Toolbar style',
        'description' => 'A better Toolbar.',
        'package' => 'Administration',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'admin_menu',
        ),
        'version' => '7.x-3.0-rc3',
        'project' => 'admin_menu',
        'datestamp' => '1337292349',
        'php' => '5.2.4',
      ),
      'project' => 'admin_menu',
      'version' => '7.x-3.0-rc3',
    ),
    'advanced_forum' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/advanced_forum/advanced_forum.module',
      'name' => 'advanced_forum',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '5005',
      'weight' => '15',
      'info' => 
      array (
        'name' => 'Advanced Forum',
        'description' => 'Enables the look and feel of other popular forum software.',
        'version' => '7.x-2.0',
        'dependencies' => 
        array (
          0 => 'forum',
          1 => 'ctools',
          2 => 'views',
        ),
        'configure' => 'admin/config/content/advanced-forum',
        'files' => 
        array (
          0 => 'includes/views/advanced_forum_handler_field_node_topic_icon.inc',
          1 => 'includes/views/advanced_forum_handler_field_node_topic_pager.inc',
          2 => 'includes/views/advanced_forum_plugin_style_forum_topic_list.inc',
        ),
        'core' => '7.x',
        'project' => 'advanced_forum',
        'datestamp' => '1332167738',
        'php' => '5.2.4',
      ),
      'project' => 'advanced_forum',
      'version' => '7.x-2.0',
    ),
    'advanced_help' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/advanced_help/advanced_help.module',
      'name' => 'advanced_help',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Advanced help',
        'description' => 'Allow advanced help and documentation.',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'advanced_help.module',
          1 => 'advanced_help.install',
        ),
        'version' => '7.x-1.0',
        'project' => 'advanced_help',
        'datestamp' => '1321022730',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'advanced_help',
      'version' => '7.x-1.0',
    ),
    'aggregator' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/aggregator/aggregator.module',
      'name' => 'aggregator',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Aggregator',
        'description' => 'Aggregates syndicated content (RSS, RDF, and Atom feeds).',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'aggregator.test',
        ),
        'configure' => 'admin/config/services/aggregator/settings',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'aggregator.css',
          ),
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'aggregator_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/aggregator/tests/aggregator_test.module',
      'name' => 'aggregator_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Aggregator module tests',
        'description' => 'Support module for aggregator related testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'ajax_forms_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/ajax_forms_test.module',
      'name' => 'ajax_forms_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'AJAX form test mock module',
        'description' => 'Test for AJAX form calls.',
        'core' => '7.x',
        'package' => 'Testing',
        'version' => '7.15',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'ajax_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/ajax_test.module',
      'name' => 'ajax_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'AJAX Test',
        'description' => 'Support module for AJAX framework tests.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'anon_session' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/anon_session/anon_session.module',
      'name' => 'anon_session',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '1',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Anonymous Session',
        'description' => 'Fixes issue in D7 whereby sessions aren\'t saved for anonymous users and hence messages not displaying.',
        'core' => '7.x',
        'package' => 'Miscellaneous',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'backup_migrate' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/backup_migrate/backup_migrate.module',
      'name' => 'backup_migrate',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7203',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Backup and Migrate',
        'description' => 'Backup or migrate the Drupal Database quickly and without unnecessary data.',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'backup_migrate.module',
          1 => 'backup_migrate.install',
          2 => 'includes/destinations.inc',
          3 => 'includes/profiles.inc',
          4 => 'includes/schedules.inc',
        ),
        'configure' => 'admin/config/system/backup_migrate',
        'version' => '7.x-2.4',
        'project' => 'backup_migrate',
        'datestamp' => '1338903073',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'backup_migrate',
      'version' => '7.x-2.4',
    ),
    'batch_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/batch_test.module',
      'name' => 'batch_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Batch API test',
        'description' => 'Support module for Batch API tests.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'bbb_update_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/update/tests/bbb_update_test.module',
      'name' => 'bbb_update_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'BBB Update test',
        'description' => 'Support module for update module testing.',
        'package' => 'Testing',
        'core' => '7.x',
        'hidden' => true,
        'version' => '7.15',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'block' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/block/block.module',
      'name' => 'block',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7008',
      'weight' => '-5',
      'info' => 
      array (
        'name' => 'Block',
        'description' => 'Controls the visual building blocks a page is constructed with. Blocks are boxes of content rendered into an area, or region, of a web page.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'block.test',
        ),
        'configure' => 'admin/structure/block',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'block_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/block/tests/block_test.module',
      'name' => 'block_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Block test',
        'description' => 'Provides test blocks.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'blog' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/blog/blog.module',
      'name' => 'blog',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Blog',
        'description' => 'Enables multi-user blogs.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'blog.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'book' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/book/book.module',
      'name' => 'book',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Book',
        'description' => 'Allows users to create and organize related content in an outline.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'book.test',
        ),
        'configure' => 'admin/content/book/settings',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'book.css',
          ),
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'bulk_export' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/bulk_export/bulk_export.module',
      'name' => 'bulk_export',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Bulk Export',
        'description' => 'Performs bulk exporting of data objects known about by Chaos tools.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'package' => 'Chaos tool suite',
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'calendar' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/calendar/calendar.module',
      'name' => 'calendar',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7002',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Calendar',
        'description' => 'Views plugin to display views containing dates as Calendars.',
        'dependencies' => 
        array (
          0 => 'views',
          1 => 'date_api',
          2 => 'date_views',
        ),
        'package' => 'Date/Time',
        'core' => '7.x',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'css/calendar_multiday.css',
          ),
        ),
        'files' => 
        array (
          0 => 'calendar.install',
          1 => 'calendar.module',
          2 => 'includes/calendar.views.inc',
          3 => 'includes/calendar_plugin_style.inc',
          4 => 'includes/calendar_plugin_row.inc',
          5 => 'includes/calendar.views_template.inc',
          6 => 'theme/theme.inc',
          7 => 'theme/calendar-style.tpl.php',
        ),
        'version' => '7.x-3.4',
        'project' => 'calendar',
        'datestamp' => '1337429753',
        'php' => '5.2.4',
      ),
      'project' => 'calendar',
      'version' => '7.x-3.4',
    ),
    'ccc_update_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/update/tests/ccc_update_test.module',
      'name' => 'ccc_update_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'CCC Update test',
        'description' => 'Support module for update module testing.',
        'package' => 'Testing',
        'core' => '7.x',
        'hidden' => true,
        'version' => '7.15',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'cck' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/cck/cck.module',
      'name' => 'cck',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'CCK',
        'description' => 'Miscellaneous field functions not handled by core.',
        'package' => 'CCK',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'cck.module',
          1 => 'cck.install',
        ),
        'dependencies' => 
        array (
          0 => 'field_ui',
        ),
        'version' => '7.x-2.x-dev',
        'project' => 'cck',
        'datestamp' => '1300492994',
        'php' => '5.2.4',
      ),
      'project' => 'cck',
      'version' => '7.x-2.x-dev',
    ),
    'chatroom' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/chatroom/chatroom.module',
      'name' => 'chatroom',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Chat Room',
        'description' => 'Allows the creation of chatrooms.',
        'package' => 'Chat',
        'core' => '7.x',
        'version' => '7.x-2.0',
        'files' => 
        array (
          0 => 'chatroom.module',
          1 => 'chatroom.chatroom.inc',
        ),
        'dependencies' => 
        array (
          0 => 'nodejs',
        ),
        'project' => 'chatroom',
        'datestamp' => '1344741727',
        'php' => '5.2.4',
      ),
      'project' => 'chatroom',
      'version' => '7.x-2.0',
    ),
    'classes' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/classes/classes.module',
      'name' => 'classes',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Classes',
        'description' => 'Generates class files for Drupal entities and content types.',
        'package' => 'Classes',
        'core' => '6.x',
        'dependencies' => 
        array (
          0 => 'content',
          1 => 'number',
          2 => 'text',
          3 => 'nodereference',
          4 => 'userreference',
          5 => 'optionwidgets',
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'clone' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/node_clone/clone.module',
      'name' => 'clone',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Node clone',
        'description' => 'Allows users to clone (copy then edit) an existing node.',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'clone.module',
          1 => 'clone.pages.inc',
        ),
        'version' => '7.x-1.0-beta1',
        'project' => 'node_clone',
        'datestamp' => '1296525949',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'node_clone',
      'version' => '7.x-1.0-beta1',
    ),
    'coder' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/coder/coder.module',
      'name' => 'coder',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Coder',
        'description' => 'Developer Module that assists with code review and version upgrade',
        'package' => 'Development',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'coder.module',
        ),
        'version' => '7.x-1.0',
        'project' => 'coder',
        'datestamp' => '1313611616',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'coder',
      'version' => '7.x-1.0',
    ),
    'coder_review' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/coder/coder_review/coder_review.module',
      'name' => 'coder_review',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Coder Review',
        'description' => 'Developer module which reviews your code identifying coding style problems and where updates to the API are required.',
        'package' => 'Development',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'coder',
        ),
        'files' => 
        array (
          0 => 'tests/coder_review_test_case.tinc',
          1 => 'tests/coder_review_6x.test',
          2 => 'tests/coder_review_7x.test',
          3 => 'tests/coder_review_comment.test',
          4 => 'tests/coder_review_i18n.test',
          5 => 'tests/coder_review_security.test',
          6 => 'tests/coder_review_sql.test',
          7 => 'tests/coder_review_style.test',
        ),
        'version' => '7.x-1.0',
        'project' => 'coder',
        'datestamp' => '1313611616',
        'php' => '5.2.4',
      ),
      'project' => 'coder',
      'version' => '7.x-1.0',
    ),
    'coder_review_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/coder/coder_review/tests/coder_review_test/coder_review_test.module',
      'name' => 'coder_review_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Coder Review Test',
        'package' => 'Coder',
        'core' => '7.x',
        'hidden' => true,
        'files' => 
        array (
          0 => 'coder_review_test.module',
        ),
        'version' => '7.x-1.0',
        'project' => 'coder',
        'datestamp' => '1313611616',
        'dependencies' => 
        array (
        ),
        'description' => '',
        'php' => '5.2.4',
      ),
      'project' => 'coder',
      'version' => '7.x-1.0',
    ),
    'coder_upgrade' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/coder/coder_upgrade/coder_upgrade.module',
      'name' => 'coder_upgrade',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Coder Upgrade',
        'description' => 'Module conversion suite -- generates code to assist with the upgrade of
               contributed 6.x modules to version 7.x modules.
               WARNING: Use only on contributed modules.',
        'package' => 'Development',
        'dependencies' => 
        array (
          0 => 'gplib',
        ),
        'files' => 
        array (
          0 => 'coder_upgrade.test',
        ),
        'configure' => 'admin/config/development/coder/upgrade/settings',
        'core' => '7.x',
        'version' => '7.x-1.0',
        'project' => 'coder',
        'datestamp' => '1313611616',
        'php' => '5.2.4',
      ),
      'project' => 'coder',
      'version' => '7.x-1.0',
    ),
    'color' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/color/color.module',
      'name' => 'color',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7001',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Color',
        'description' => 'Allows administrators to change the color scheme of compatible themes.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'color.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'colorfield' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/colorfield/colorfield.module',
      'name' => 'colorfield',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Color Fields',
        'description' => 'A color field for attaching colors to entities',
        'package' => 'Miscellaneous',
        'core' => '7.x',
        'version' => '7.x-1.x-dev',
        'project' => 'colorfield',
        'datestamp' => '1343131746',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'colorfield',
      'version' => '7.x-1.x-dev',
    ),
    'comment' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/comment/comment.module',
      'name' => 'comment',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7009',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Comment',
        'description' => 'Allows users to comment on and discuss published content.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'text',
        ),
        'files' => 
        array (
          0 => 'comment.module',
          1 => 'comment.test',
        ),
        'configure' => 'admin/content/comment',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'comment.css',
          ),
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'comment_colours' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/features/comment_colours/comment_colours.module',
      'name' => 'comment_colours',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Comment colours',
        'core' => '7.x',
        'package' => 'Features',
        'version' => '7.x-1.0',
        'project' => 'comment_colours',
        'dependencies' => 
        array (
          0 => 'colorfield',
          1 => 'features',
          2 => 'field_group',
          3 => 'field_sql_storage',
        ),
        'features' => 
        array (
          'features_api' => 
          array (
            0 => 'api:1',
          ),
          'field' => 
          array (
            0 => 'user-user-field_background_color',
            1 => 'user-user-field_border_color',
            2 => 'user-user-field_text_color',
          ),
          'field_group' => 
          array (
            0 => 'group_colours|user|user|form',
          ),
        ),
        'description' => '',
        'php' => '5.2.4',
      ),
      'project' => 'comment_colours',
      'version' => '7.x-1.0',
    ),
    'commerce_extra' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/commerce_extra/commerce_extra.module',
      'name' => 'commerce_extra',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Commerce Extra',
        'description' => 'Contains multiple extra features for Drupal Commerce.',
        'core' => '7.x',
        'package' => 'Commerce Extra',
        'configure' => 'admin/commerce/config/commerce_extra',
        'dependencies' => 
        array (
          0 => 'commerce',
        ),
        'version' => '7.x-1.0-alpha1',
        'project' => 'commerce_extra',
        'datestamp' => '1326873349',
        'php' => '5.2.4',
      ),
      'project' => 'commerce_extra',
      'version' => '7.x-1.0-alpha1',
    ),
    'commerce_extra_address_populate' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/commerce_extra/modules/address_populate/commerce_extra_address_populate.module',
      'name' => 'commerce_extra_address_populate',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Commerce Extra Address Populate',
        'description' => 'Uses user account address field to pre-populate customer profiles in checkout.',
        'package' => 'Commerce Extra',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'commerce_extra',
          1 => 'commerce_customer',
        ),
        'version' => '7.x-1.0-alpha1',
        'project' => 'commerce_extra',
        'datestamp' => '1326873349',
        'php' => '5.2.4',
      ),
      'project' => 'commerce_extra',
      'version' => '7.x-1.0-alpha1',
    ),
    'commerce_extra_login_page' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/commerce_extra/modules/login_page/commerce_extra_login_page.module',
      'name' => 'commerce_extra_login_page',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Commerce Extra Login Page',
        'description' => 'Creates extra step for checkout process where user can alternatively login.',
        'core' => '7.x',
        'package' => 'Commerce Extra',
        'dependencies' => 
        array (
          0 => 'commerce_extra',
          1 => 'commerce_checkout',
        ),
        'version' => '7.x-1.0-alpha1',
        'project' => 'commerce_extra',
        'datestamp' => '1326873349',
        'php' => '5.2.4',
      ),
      'project' => 'commerce_extra',
      'version' => '7.x-1.0-alpha1',
    ),
    'commerce_extra_quantity' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/commerce_extra/modules/quantity/commerce_extra_quantity.module',
      'name' => 'commerce_extra_quantity',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Commerce Extra Quantity',
        'description' => 'Wraps quantity fields with - and + links to decrease or increase quantity.',
        'package' => 'Commerce Extra',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'commerce_extra',
          1 => 'commerce_cart',
        ),
        'version' => '7.x-1.0-alpha1',
        'project' => 'commerce_extra',
        'datestamp' => '1326873349',
        'php' => '5.2.4',
      ),
      'project' => 'commerce_extra',
      'version' => '7.x-1.0-alpha1',
    ),
    'commerce_paypal' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/commerce_paypal/commerce_paypal.module',
      'name' => 'commerce_paypal',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'PayPal',
        'description' => 'Implements PayPal payment services for use with Drupal Commerce.',
        'package' => 'Commerce (PayPal)',
        'dependencies' => 
        array (
          0 => 'commerce',
          1 => 'commerce_ui',
          2 => 'commerce_payment',
          3 => 'commerce_order',
        ),
        'core' => '7.x',
        'version' => '7.x-1.x-dev',
        'project' => 'commerce_paypal',
        'datestamp' => '1328400676',
        'php' => '5.2.4',
      ),
      'project' => 'commerce_paypal',
      'version' => '7.x-1.x-dev',
    ),
    'commerce_paypal_wpp' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/commerce_paypal/modules/wpp/commerce_paypal_wpp.module',
      'name' => 'commerce_paypal_wpp',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'PayPal WPP',
        'description' => 'Implements PayPal Website Payments Pro in Drupal Commerce checkout.',
        'package' => 'Commerce (PayPal)',
        'dependencies' => 
        array (
          0 => 'commerce',
          1 => 'commerce_ui',
          2 => 'commerce_payment',
          3 => 'commerce_order',
          4 => 'commerce_paypal',
        ),
        'core' => '7.x',
        'version' => '7.x-1.x-dev',
        'project' => 'commerce_paypal',
        'datestamp' => '1328400676',
        'php' => '5.2.4',
      ),
      'project' => 'commerce_paypal',
      'version' => '7.x-1.x-dev',
    ),
    'commerce_paypal_wps' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/commerce_paypal/modules/wps/commerce_paypal_wps.module',
      'name' => 'commerce_paypal_wps',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'PayPal WPS',
        'description' => 'Implements PayPal Website Payments Standard in Drupal Commerce checkout.',
        'package' => 'Commerce (PayPal)',
        'dependencies' => 
        array (
          0 => 'commerce',
          1 => 'commerce_ui',
          2 => 'commerce_payment',
          3 => 'commerce_order',
          4 => 'commerce_paypal',
        ),
        'core' => '7.x',
        'version' => '7.x-1.x-dev',
        'project' => 'commerce_paypal',
        'datestamp' => '1328400676',
        'php' => '5.2.4',
      ),
      'project' => 'commerce_paypal',
      'version' => '7.x-1.x-dev',
    ),
    'common_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/common_test.module',
      'name' => 'common_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Common Test',
        'description' => 'Support module for Common tests.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'common_test.css',
          ),
          'print' => 
          array (
            0 => 'common_test.print.css',
          ),
        ),
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'common_test_cron_helper' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/common_test_cron_helper.module',
      'name' => 'common_test_cron_helper',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Common Test Cron Helper',
        'description' => 'Helper module for CronRunTestCase::testCronExceptions().',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'contact' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/contact/contact.module',
      'name' => 'contact',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7003',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Contact',
        'description' => 'Enables the use of both personal and site-wide contact forms.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'contact.test',
        ),
        'configure' => 'admin/structure/contact',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'content_migrate' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/cck/modules/content_migrate/content_migrate.module',
      'name' => 'content_migrate',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Content Migrate',
        'description' => 'Migrate fields and field data from CCK D6 format to the D7 field format. Required to migrate data, can be disabled once all fields have been migrated.',
        'core' => '7.x',
        'package' => 'CCK',
        'files' => 
        array (
          0 => 'content_migrate.module',
          1 => 'content_migrate.api.php',
          2 => 'includes/content_migrate.admin.inc',
          3 => 'includes/content_migrate.values.inc',
          4 => 'includes/content_migrate.drush.inc',
          5 => 'modules/content_migrate.text.inc',
          6 => 'modules/content_migrate.number.inc',
          7 => 'modules/content_migrate.optionwidgets.inc',
          8 => 'modules/content_migrate.filefield.inc',
          9 => 'tests/content_migrate.test',
        ),
        'version' => '7.x-2.x-dev',
        'project' => 'cck',
        'datestamp' => '1300492994',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'cck',
      'version' => '7.x-2.x-dev',
    ),
    'context' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/context/context.module',
      'name' => 'context',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7000',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Context',
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'description' => 'Provide modules with a cache that lasts for a single page request.',
        'package' => 'Context',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'context.module',
          1 => 'tests/context.test',
          2 => 'tests/context.conditions.test',
          3 => 'tests/context.reactions.test',
        ),
        'version' => '7.x-3.0-beta3',
        'project' => 'context',
        'datestamp' => '1337490055',
        'php' => '5.2.4',
      ),
      'project' => 'context',
      'version' => '7.x-3.0-beta3',
    ),
    'contextual' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/contextual/contextual.module',
      'name' => 'contextual',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Contextual links',
        'description' => 'Provides contextual links to perform actions related to elements on a page.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'contextual.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'context_layouts' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/context/context_layouts/context_layouts.module',
      'name' => 'context_layouts',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Context layouts',
        'description' => 'Allow theme layer to provide multiple region layouts and integrate with context.',
        'dependencies' => 
        array (
          0 => 'context',
        ),
        'package' => 'Context',
        'core' => '7.x',
        'version' => '7.x-3.0-beta3',
        'project' => 'context',
        'datestamp' => '1337490055',
        'php' => '5.2.4',
      ),
      'project' => 'context',
      'version' => '7.x-3.0-beta3',
    ),
    'context_ui' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/context/context_ui/context_ui.module',
      'name' => 'context_ui',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '6004',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Context UI',
        'description' => 'Provides a simple UI for settings up a site structure using Context.',
        'dependencies' => 
        array (
          0 => 'context',
        ),
        'package' => 'Context',
        'core' => '7.x',
        'configure' => 'admin/structure/context',
        'files' => 
        array (
          0 => 'context.module',
          1 => 'tests/context_ui.test',
        ),
        'version' => '7.x-3.0-beta3',
        'project' => 'context',
        'datestamp' => '1337490055',
        'php' => '5.2.4',
      ),
      'project' => 'context',
      'version' => '7.x-3.0-beta3',
    ),
    'css3pie' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/css3pie/css3pie.module',
      'name' => 'css3pie',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7003',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'CSS3PIE',
        'description' => 'Provides CSS3PIE (http://css3pie.com/) library support.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'libraries',
          1 => 'ctools',
        ),
        'configure' => 'admin/config/user-interface/css3pie',
        'version' => '7.x-2.1',
        'project' => 'css3pie',
        'datestamp' => '1332951952',
        'php' => '5.2.4',
      ),
      'project' => 'css3pie',
      'version' => '7.x-2.1',
    ),
    'ctools' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/ctools.module',
      'name' => 'ctools',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '6007',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Chaos tools',
        'description' => 'A library of helpful tools by Merlin of Chaos.',
        'core' => '7.x',
        'package' => 'Chaos tool suite',
        'files' => 
        array (
          0 => 'includes/context.inc',
          1 => 'includes/math-expr.inc',
          2 => 'includes/stylizer.inc',
        ),
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'ctools_access_ruleset' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/ctools_access_ruleset/ctools_access_ruleset.module',
      'name' => 'ctools_access_ruleset',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Custom rulesets',
        'description' => 'Create custom, exportable, reusable access rulesets for applications like Panels.',
        'core' => '7.x',
        'package' => 'Chaos tool suite',
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'ctools_ajax_sample' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/ctools_ajax_sample/ctools_ajax_sample.module',
      'name' => 'ctools_ajax_sample',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Chaos Tools (CTools) AJAX Example',
        'description' => 'Shows how to use the power of Chaos AJAX.',
        'package' => 'Chaos tool suite',
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'core' => '7.x',
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'ctools_custom_content' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/ctools_custom_content/ctools_custom_content.module',
      'name' => 'ctools_custom_content',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Custom content panes',
        'description' => 'Create custom, exportable, reusable content panes for applications like Panels.',
        'core' => '7.x',
        'package' => 'Chaos tool suite',
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'ctools_export_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/tests/ctools_export_test/ctools_export_test.module',
      'name' => 'ctools_export_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'CTools export test',
        'description' => 'CTools export test module',
        'core' => '7.x',
        'package' => 'Chaos tool suite',
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'hidden' => true,
        'files' => 
        array (
          0 => 'ctools_export.test',
        ),
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'ctools_plugin_example' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/ctools_plugin_example/ctools_plugin_example.module',
      'name' => 'ctools_plugin_example',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Chaos Tools (CTools) Plugin Example',
        'description' => 'Shows how an external module can provide ctools plugins (for Panels, etc.).',
        'package' => 'Chaos tool suite',
        'dependencies' => 
        array (
          0 => 'ctools',
          1 => 'panels',
          2 => 'page_manager',
          3 => 'advanced_help',
        ),
        'core' => '7.x',
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'ctools_plugin_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/tests/ctools_plugin_test.module',
      'name' => 'ctools_plugin_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Chaos tools plugins test',
        'description' => 'Provides hooks for testing ctools plugins.',
        'package' => 'Chaos tool suite',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'files' => 
        array (
          0 => 'ctools.plugins.test',
          1 => 'object_cache.test',
          2 => 'css.test',
        ),
        'hidden' => true,
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'currency' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/currency/currency.module',
      'name' => 'currency',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Currency',
        'description' => 'Provides currency exchange rates.',
        'dependencies' => 
        array (
          0 => 'currency_api',
        ),
        'package' => 'Currency',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'currency.module',
          1 => 'includes/views/handlers/currency_handler_field_currency.inc',
          2 => 'includes/views/handlers/currency_handler_argument_currency.inc',
          3 => 'includes/views/handlers/currency_handler_filter_currency.inc',
        ),
        'configure' => 'admin/config/regional/currency',
        'version' => '7.x-1.x-dev',
        'project' => 'currency',
        'datestamp' => '1320970744',
        'php' => '5.2.4',
      ),
      'project' => 'currency',
      'version' => '7.x-1.x-dev',
    ),
    'currency_api' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/currency/currency_api/currency_api.module',
      'name' => 'currency_api',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Currency API',
        'description' => 'Provides an API for currency conversion.',
        'package' => 'Currency',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'currency_api.module',
        ),
        'configure' => 'admin/config/regional/currency_api',
        'version' => '7.x-1.x-dev',
        'project' => 'currency',
        'datestamp' => '1320970744',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'currency',
      'version' => '7.x-1.x-dev',
    ),
    'dashboard' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/dashboard/dashboard.module',
      'name' => 'dashboard',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Dashboard',
        'description' => 'Provides a dashboard page in the administrative interface for organizing administrative tasks and tracking information within your site.',
        'core' => '7.x',
        'package' => 'Core',
        'version' => '7.15',
        'files' => 
        array (
          0 => 'dashboard.test',
        ),
        'dependencies' => 
        array (
          0 => 'block',
        ),
        'configure' => 'admin/dashboard/customize',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'database_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/database_test.module',
      'name' => 'database_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Database Test',
        'description' => 'Support module for Database layer tests.',
        'core' => '7.x',
        'package' => 'Testing',
        'version' => '7.15',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'date' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date.module',
      'name' => 'date',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7003',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Date',
        'description' => 'Makes date/time fields available.',
        'dependencies' => 
        array (
          0 => 'date_api',
        ),
        'package' => 'Date/Time',
        'core' => '7.x',
        'php' => '5.2',
        'files' => 
        array (
          0 => 'tests/date_api.test',
          1 => 'tests/date.test',
          2 => 'tests/date_field.test',
          3 => 'tests/date_validation.test',
          4 => 'tests/date_timezone.test',
        ),
        'version' => '7.x-2.5',
        'project' => 'date',
        'datestamp' => '1334835098',
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'date_all_day' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date_all_day/date_all_day.module',
      'name' => 'date_all_day',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Date All Day',
        'description' => 'Adds \'All Day\' functionality to date fields, including an \'All Day\' theme and \'All Day\' checkboxes for the Date select and Date popup widgets.',
        'dependencies' => 
        array (
          0 => 'date_api',
          1 => 'date',
        ),
        'package' => 'Date/Time',
        'core' => '7.x',
        'version' => '7.x-2.5',
        'project' => 'date',
        'datestamp' => '1334835098',
        'php' => '5.2.4',
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'date_api' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date_api/date_api.module',
      'name' => 'date_api',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7000',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Date API',
        'description' => 'A Date API that can be used by other modules.',
        'package' => 'Date/Time',
        'core' => '7.x',
        'php' => '5.2',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'date.css',
          ),
        ),
        'files' => 
        array (
          0 => 'date_api.module',
          1 => 'date_api_sql.inc',
        ),
        'version' => '7.x-2.5',
        'project' => 'date',
        'datestamp' => '1334835098',
        'dependencies' => 
        array (
        ),
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'date_context' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date_context/date_context.module',
      'name' => 'date_context',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Date Context',
        'description' => 'Adds an option to the Context module to set a context condition based on the value of a date field.',
        'package' => 'Date/Time',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'date',
          1 => 'context',
        ),
        'files' => 
        array (
          0 => 'date_context.module',
          1 => 'plugins/date_context_date_condition.inc',
        ),
        'version' => '7.x-2.5',
        'project' => 'date',
        'datestamp' => '1334835098',
        'php' => '5.2.4',
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'date_migrate' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date_migrate/date_migrate.module',
      'name' => 'date_migrate',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Date Migration',
        'description' => 'Provides support for importing into date fields with the Migrate module.',
        'core' => '7.x',
        'package' => 'Date/Time',
        'dependencies' => 
        array (
          0 => 'migrate',
          1 => 'date',
        ),
        'files' => 
        array (
          0 => 'date.migrate.inc',
          1 => 'date_migrate.test',
        ),
        'version' => '7.x-2.5',
        'project' => 'date',
        'datestamp' => '1334835098',
        'php' => '5.2.4',
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'date_migrate_example' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date_migrate/date_migrate_example/date_migrate_example.module',
      'name' => 'date_migrate_example',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'date',
          1 => 'date_repeat',
          2 => 'date_repeat_field',
          3 => 'date_migrate',
          4 => 'features',
          5 => 'migrate',
        ),
        'description' => 'Examples of migrating with the Date module',
        'features' => 
        array (
          'field' => 
          array (
            0 => 'node-date_migrate_example-body',
            1 => 'node-date_migrate_example-field_date',
            2 => 'node-date_migrate_example-field_date_range',
            3 => 'node-date_migrate_example-field_date_repeat',
            4 => 'node-date_migrate_example-field_datestamp',
            5 => 'node-date_migrate_example-field_datestamp_range',
            6 => 'node-date_migrate_example-field_datetime',
            7 => 'node-date_migrate_example-field_datetime_range',
          ),
          'node' => 
          array (
            0 => 'date_migrate_example',
          ),
        ),
        'files' => 
        array (
          0 => 'date_migrate_example.migrate.inc',
        ),
        'name' => 'Date Migration Example',
        'package' => 'Features',
        'project' => 'date',
        'version' => '7.x-2.5',
        'datestamp' => '1334835098',
        'php' => '5.2.4',
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'date_popup' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date_popup/date_popup.module',
      'name' => 'date_popup',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Date Popup',
        'description' => 'Enables jquery popup calendars and time entry widgets for selecting dates and times.',
        'dependencies' => 
        array (
          0 => 'date_api',
        ),
        'package' => 'Date/Time',
        'core' => '7.x',
        'configure' => 'admin/config/date/date_popup',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'themes/datepicker.1.7.css',
          ),
        ),
        'version' => '7.x-2.5',
        'project' => 'date',
        'datestamp' => '1334835098',
        'php' => '5.2.4',
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'date_repeat' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date_repeat/date_repeat.module',
      'name' => 'date_repeat',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Date Repeat API',
        'description' => 'A Date Repeat API to calculate repeating dates and times from iCal rules.',
        'dependencies' => 
        array (
          0 => 'date_api',
        ),
        'package' => 'Date/Time',
        'core' => '7.x',
        'php' => '5.2',
        'files' => 
        array (
          0 => 'tests/date_repeat.test',
          1 => 'tests/date_repeat_form.test',
        ),
        'version' => '7.x-2.5',
        'project' => 'date',
        'datestamp' => '1334835098',
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'date_repeat_field' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date_repeat_field/date_repeat_field.module',
      'name' => 'date_repeat_field',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Date Repeat Field',
        'description' => 'Creates the option of Repeating date fields and manages Date fields that use the Date Repeat API.',
        'dependencies' => 
        array (
          0 => 'date_api',
          1 => 'date',
          2 => 'date_repeat',
        ),
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'date_repeat_field.css',
          ),
        ),
        'package' => 'Date/Time',
        'core' => '7.x',
        'version' => '7.x-2.5',
        'project' => 'date',
        'datestamp' => '1334835098',
        'php' => '5.2.4',
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'date_tools' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date_tools/date_tools.module',
      'name' => 'date_tools',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Date Tools',
        'description' => 'Tools to import and auto-create dates and calendars.',
        'dependencies' => 
        array (
          0 => 'date',
        ),
        'package' => 'Date/Time',
        'core' => '7.x',
        'configure' => 'admin/config/date/tools',
        'files' => 
        array (
          0 => 'tests/date_tools.test',
        ),
        'version' => '7.x-2.5',
        'project' => 'date',
        'datestamp' => '1334835098',
        'php' => '5.2.4',
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'date_views' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/date/date_views/date_views.module',
      'name' => 'date_views',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Date Views',
        'description' => 'Views integration for date fields and date functionality.',
        'package' => 'Date/Time',
        'dependencies' => 
        array (
          0 => 'date_api',
          1 => 'views',
        ),
        'core' => '7.x',
        'php' => '5.2',
        'files' => 
        array (
          0 => 'includes/date_views_argument_handler.inc',
          1 => 'includes/date_views_argument_handler_simple.inc',
          2 => 'includes/date_views_filter_handler.inc',
          3 => 'includes/date_views_filter_handler_simple.inc',
          4 => 'includes/date_views.views_default.inc',
          5 => 'includes/date_views.views.inc',
          6 => 'includes/date_views_plugin_pager.inc',
        ),
        'version' => '7.x-2.5',
        'project' => 'date',
        'datestamp' => '1334835098',
      ),
      'project' => 'date',
      'version' => '7.x-2.5',
    ),
    'dbg' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/dbg/dbg.module',
      'name' => 'dbg',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '1',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Debug (dbg)',
        'description' => 'Provides dbg(), println(), and other useful debug-related functions.',
        'core' => '7.x',
        'package' => 'Astro Multimedia',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'dblog' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/dblog/dblog.module',
      'name' => 'dblog',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '1',
      'schema_version' => '7001',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Database logging',
        'description' => 'Logs and records system events to the database.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'dblog.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'db_search' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/db_search/db_search.module',
      'name' => 'db_search',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Database Search',
        'description' => 'Search database text fields.',
        'core' => '7.x',
        'package' => 'Development',
        'dependencies' => 
        array (
          0 => 'backup_migrate',
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'devel' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/devel/devel.module',
      'name' => 'devel',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '1',
      'schema_version' => '7004',
      'weight' => '88',
      'info' => 
      array (
        'name' => 'Devel',
        'description' => 'Various blocks, pages, and functions for developers.',
        'package' => 'Development',
        'core' => '7.x',
        'configure' => 'admin/config/development/devel',
        'tags' => 
        array (
          0 => 'developer',
        ),
        'files' => 
        array (
          0 => 'devel.test',
          1 => 'devel.mail.inc',
        ),
        'version' => '7.x-1.3',
        'project' => 'devel',
        'datestamp' => '1338940281',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'devel',
      'version' => '7.x-1.3',
    ),
    'devel_generate' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/devel/devel_generate/devel_generate.module',
      'name' => 'devel_generate',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Devel generate',
        'description' => 'Generate dummy users, nodes, and taxonomy terms.',
        'package' => 'Development',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'devel',
        ),
        'tags' => 
        array (
          0 => 'developer',
        ),
        'configure' => 'admin/config/development/generate',
        'version' => '7.x-1.3',
        'project' => 'devel',
        'datestamp' => '1338940281',
        'php' => '5.2.4',
      ),
      'project' => 'devel',
      'version' => '7.x-1.3',
    ),
    'devel_node_access' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/devel/devel_node_access.module',
      'name' => 'devel_node_access',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Devel node access',
        'description' => 'Developer blocks and page illustrating relevant node_access records.',
        'package' => 'Development',
        'dependencies' => 
        array (
          0 => 'menu',
        ),
        'core' => '7.x',
        'configure' => 'admin/config/development/devel',
        'tags' => 
        array (
          0 => 'developer',
        ),
        'version' => '7.x-1.3',
        'project' => 'devel',
        'datestamp' => '1338940281',
        'php' => '5.2.4',
      ),
      'project' => 'devel',
      'version' => '7.x-1.3',
    ),
    'drupal_system_listing_compatible_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/drupal_system_listing_compatible_test/drupal_system_listing_compatible_test.module',
      'name' => 'drupal_system_listing_compatible_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Drupal system listing compatible test',
        'description' => 'Support module for testing the drupal_system_listing function.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'drupal_system_listing_incompatible_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/drupal_system_listing_incompatible_test/drupal_system_listing_incompatible_test.module',
      'name' => 'drupal_system_listing_incompatible_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Drupal system listing incompatible test',
        'description' => 'Support module for testing the drupal_system_listing function.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'elements' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/elements/elements.module',
      'name' => 'elements',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Elements',
        'description' => 'Provides a library of Form API elements.',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'elements.module',
          1 => 'elements.theme.inc',
        ),
        'version' => '7.x-1.2',
        'project' => 'elements',
        'datestamp' => '1292175136',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'elements',
      'version' => '7.x-1.2',
    ),
    'email' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/email/email.module',
      'name' => 'email',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Email',
        'description' => 'Defines an email field type.',
        'core' => '7.x',
        'package' => 'Fields',
        'files' => 
        array (
          0 => 'email.migrate.inc',
        ),
        'version' => '7.x-1.1',
        'project' => 'email',
        'datestamp' => '1340207779',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'email',
      'version' => '7.x-1.1',
    ),
    'emfield' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/emfield/emfield.module',
      'name' => 'emfield',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Embedded Media Field',
        'description' => 'Provides an embedded media widget for file fields.',
        'dependencies' => 
        array (
          0 => 'media',
          1 => 'media_internet',
        ),
        'package' => 'Media',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'emfield.install',
          1 => 'emfield.module',
        ),
        'version' => '7.x-1.0-alpha1',
        'project' => 'emfield',
        'datestamp' => '1323874542',
        'php' => '5.2.4',
      ),
      'project' => 'emfield',
      'version' => '7.x-1.0-alpha1',
    ),
    'entity' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/entity/entity.module',
      'name' => 'entity',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7002',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity API',
        'description' => 'Enables modules to work with any entity type and to provide entities.',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'entity.features.inc',
          1 => 'entity.i18n.inc',
          2 => 'entity.info.inc',
          3 => 'entity.rules.inc',
          4 => 'entity.test',
          5 => 'includes/entity.inc',
          6 => 'includes/entity.controller.inc',
          7 => 'includes/entity.ui.inc',
          8 => 'includes/entity.wrapper.inc',
          9 => 'views/entity.views.inc',
          10 => 'views/handlers/entity_views_field_handler_helper.inc',
          11 => 'views/handlers/entity_views_handler_area_entity.inc',
          12 => 'views/handlers/entity_views_handler_field_boolean.inc',
          13 => 'views/handlers/entity_views_handler_field_date.inc',
          14 => 'views/handlers/entity_views_handler_field_duration.inc',
          15 => 'views/handlers/entity_views_handler_field_entity.inc',
          16 => 'views/handlers/entity_views_handler_field_field.inc',
          17 => 'views/handlers/entity_views_handler_field_numeric.inc',
          18 => 'views/handlers/entity_views_handler_field_options.inc',
          19 => 'views/handlers/entity_views_handler_field_text.inc',
          20 => 'views/handlers/entity_views_handler_field_uri.inc',
          21 => 'views/handlers/entity_views_handler_relationship_by_bundle.inc',
          22 => 'views/handlers/entity_views_handler_relationship.inc',
          23 => 'views/plugins/entity_views_plugin_row_entity_view.inc',
        ),
        'version' => '7.x-1.0-rc3',
        'project' => 'entity',
        'datestamp' => '1337981155',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'entity',
      'version' => '7.x-1.0-rc3',
    ),
    'entityreference' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/entityreference/entityreference.module',
      'name' => 'entityreference',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7002',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity Reference',
        'description' => 'Provides a field that can reference other entities.',
        'core' => '7.x',
        'package' => 'Fields',
        'dependencies' => 
        array (
          0 => 'entity',
          1 => 'ctools',
        ),
        'files' => 
        array (
          0 => 'entityreference.migrate.inc',
          1 => 'plugins/selection/abstract.inc',
          2 => 'plugins/selection/views.inc',
          3 => 'plugins/behavior/abstract.inc',
          4 => 'views/entityreference_plugin_display.inc',
          5 => 'views/entityreference_plugin_style.inc',
          6 => 'views/entityreference_plugin_row_fields.inc',
          7 => 'tests/entityreference.handlers.test',
        ),
        'version' => '7.x-1.0-rc3',
        'project' => 'entityreference',
        'datestamp' => '1338411955',
        'php' => '5.2.4',
      ),
      'project' => 'entityreference',
      'version' => '7.x-1.0-rc3',
    ),
    'entityreference_behavior_example' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/entityreference/examples/entityreference_behavior_example/entityreference_behavior_example.module',
      'name' => 'entityreference_behavior_example',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity Reference Behavior Example',
        'description' => 'Provides some example code for implementing Entity Reference behaviors.',
        'core' => '7.x',
        'package' => 'Fields',
        'dependencies' => 
        array (
          0 => 'entityreference',
        ),
        'version' => '7.x-1.0-rc3',
        'project' => 'entityreference',
        'datestamp' => '1338411955',
        'php' => '5.2.4',
      ),
      'project' => 'entityreference',
      'version' => '7.x-1.0-rc3',
    ),
    'entity_cache_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/entity_cache_test.module',
      'name' => 'entity_cache_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity cache test',
        'description' => 'Support module for testing entity cache.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'entity_cache_test_dependency',
        ),
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'entity_cache_test_dependency' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/entity_cache_test_dependency.module',
      'name' => 'entity_cache_test_dependency',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity cache test dependency',
        'description' => 'Support dependency module for testing entity cache.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'entity_crud_hook_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/entity_crud_hook_test.module',
      'name' => 'entity_crud_hook_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity CRUD Hooks Test',
        'description' => 'Support module for CRUD hook tests.',
        'core' => '7.x',
        'package' => 'Testing',
        'version' => '7.15',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'entity_feature' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/entity/tests/entity_feature.module',
      'name' => 'entity_feature',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity feature module',
        'description' => 'Provides some entities in code.',
        'version' => '7.x-1.0-rc3',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'entity_feature.module',
        ),
        'dependencies' => 
        array (
          0 => 'entity_test',
        ),
        'hidden' => true,
        'project' => 'entity',
        'datestamp' => '1337981155',
        'php' => '5.2.4',
      ),
      'project' => 'entity',
      'version' => '7.x-1.0-rc3',
    ),
    'entity_query_access_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/entity_query_access_test.module',
      'name' => 'entity_query_access_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity query access test',
        'description' => 'Support module for checking entity query results.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'entity_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/entity/tests/entity_test.module',
      'name' => 'entity_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity CRUD test module',
        'description' => 'Provides entity types based upon the CRUD API.',
        'version' => '7.x-1.0-rc3',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'entity_test.module',
          1 => 'entity_test.install',
        ),
        'dependencies' => 
        array (
          0 => 'entity',
        ),
        'hidden' => true,
        'project' => 'entity',
        'datestamp' => '1337981155',
        'php' => '5.2.4',
      ),
      'project' => 'entity',
      'version' => '7.x-1.0-rc3',
    ),
    'entity_test_i18n' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/entity/tests/entity_test_i18n.module',
      'name' => 'entity_test_i18n',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity-test type translation',
        'description' => 'Allows translating entity-test types.',
        'dependencies' => 
        array (
          0 => 'entity_test',
          1 => 'i18n_string',
        ),
        'package' => 'Multilingual - Internationalization',
        'core' => '7.x',
        'hidden' => true,
        'version' => '7.x-1.0-rc3',
        'project' => 'entity',
        'datestamp' => '1337981155',
        'php' => '5.2.4',
      ),
      'project' => 'entity',
      'version' => '7.x-1.0-rc3',
    ),
    'entity_token' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/entity/entity_token.module',
      'name' => 'entity_token',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Entity tokens',
        'description' => 'Provides token replacements for all properties that have no tokens and are known to the entity API.',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'entity_token.tokens.inc',
          1 => 'entity_token.module',
        ),
        'dependencies' => 
        array (
          0 => 'entity',
        ),
        'version' => '7.x-1.0-rc3',
        'project' => 'entity',
        'datestamp' => '1337981155',
        'php' => '5.2.4',
      ),
      'project' => 'entity',
      'version' => '7.x-1.0-rc3',
    ),
    'error_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/error_test.module',
      'name' => 'error_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Error test',
        'description' => 'Support module for error and exception testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'features' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/features/features.module',
      'name' => 'features',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '6101',
      'weight' => '20',
      'info' => 
      array (
        'name' => 'Features',
        'description' => 'Provides feature management for Drupal.',
        'core' => '7.x',
        'package' => 'Features',
        'files' => 
        array (
          0 => 'tests/features.test',
        ),
        'version' => '7.x-1.0',
        'project' => 'features',
        'datestamp' => '1343240292',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'features',
      'version' => '7.x-1.0',
    ),
    'features_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/features/tests/features_test.module',
      'name' => 'features_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Features Tests',
        'description' => 'Test module for Features testing.',
        'core' => '7.x',
        'package' => 'Testing',
        'php' => '5.2.0',
        'dependencies' => 
        array (
          0 => 'features',
          1 => 'image',
          2 => 'strongarm',
          3 => 'taxonomy',
          4 => 'views',
        ),
        'features' => 
        array (
          'ctools' => 
          array (
            0 => 'strongarm:strongarm:1',
            1 => 'views:views_default:3.0',
          ),
          'features_api' => 
          array (
            0 => 'api:1',
          ),
          'field' => 
          array (
            0 => 'node-features_test-field_features_test',
          ),
          'filter' => 
          array (
            0 => 'features_test',
          ),
          'image' => 
          array (
            0 => 'features_test',
          ),
          'node' => 
          array (
            0 => 'features_test',
          ),
          'taxonomy' => 
          array (
            0 => 'taxonomy_features_test',
          ),
          'user_permission' => 
          array (
            0 => 'create features_test content',
          ),
          'views_view' => 
          array (
            0 => 'features_test',
          ),
        ),
        'hidden' => true,
        'version' => '7.x-1.0',
        'project' => 'features',
        'datestamp' => '1343240292',
      ),
      'project' => 'features',
      'version' => '7.x-1.0',
    ),
    'field' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/field/field.module',
      'name' => 'field',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7002',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Field',
        'description' => 'Field API to add fields to entities like nodes and users.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'field.module',
          1 => 'field.attach.inc',
          2 => 'tests/field.test',
        ),
        'dependencies' => 
        array (
          0 => 'field_sql_storage',
        ),
        'required' => true,
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'theme/field.css',
          ),
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'field_collection' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/field_collection/field_collection.module',
      'name' => 'field_collection',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7000',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Field collection',
        'description' => 'Provides a field collection field, to which any number of fields can be attached.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'entity',
        ),
        'files' => 
        array (
          0 => 'field_collection.test',
          1 => 'field_collection.info.inc',
          2 => 'views/field_collection_handler_relationship.inc',
        ),
        'configure' => 'admin/structure/field-collections',
        'package' => 'Fields',
        'version' => '7.x-1.0-beta4',
        'project' => 'field_collection',
        'datestamp' => '1333382446',
        'php' => '5.2.4',
      ),
      'project' => 'field_collection',
      'version' => '7.x-1.0-beta4',
    ),
    'field_collection_table' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/field_collection_table/field_collection_table.module',
      'name' => 'field_collection_table',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Field Collection Table',
        'description' => 'Provides a field-collection table formatter.',
        'core' => '7.x',
        'configure' => 'admin/config/user-interface/field_collection_table',
        'dependencies' => 
        array (
          0 => 'field_collection',
        ),
        'version' => '7.x-1.0-beta1',
        'project' => 'field_collection_table',
        'datestamp' => '1323980440',
        'php' => '5.2.4',
      ),
      'project' => 'field_collection_table',
      'version' => '7.x-1.0-beta1',
    ),
    'field_group' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/field_group/field_group.module',
      'name' => 'field_group',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7003',
      'weight' => '1',
      'info' => 
      array (
        'name' => 'Fieldgroup',
        'description' => 'Fieldgroup',
        'package' => 'Fields',
        'dependencies' => 
        array (
          0 => 'field',
          1 => 'ctools',
        ),
        'core' => '7.x',
        'files' => 
        array (
          0 => 'field_group.install',
          1 => 'field_group.module',
          2 => 'field_group.field_ui.inc',
          3 => 'field_group.form.inc',
          4 => 'field_group.features.inc',
          5 => 'field_group.test',
        ),
        'version' => '7.x-1.1',
        'project' => 'field_group',
        'datestamp' => '1319051133',
        'php' => '5.2.4',
      ),
      'project' => 'field_group',
      'version' => '7.x-1.1',
    ),
    'field_permissions' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/field_permissions/field_permissions.module',
      'name' => 'field_permissions',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Field Permissions',
        'description' => 'Set field-level permissions to create, update or view fields.',
        'package' => 'Fields',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'field_permissions.module',
          1 => 'field_permissions.admin.inc',
          2 => 'field_permissions.test',
        ),
        'configure' => 'admin/reports/fields/permissions',
        'version' => '7.x-1.0-beta2',
        'project' => 'field_permissions',
        'datestamp' => '1327510549',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'field_permissions',
      'version' => '7.x-1.0-beta2',
    ),
    'field_rename' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/field_rename/field_rename.module',
      'name' => 'field_rename',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Field Rename',
        'description' => 'Allows site builders to rename fields.',
        'core' => '7.x',
        'package' => 'Development',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'field_sql_storage' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/field/modules/field_sql_storage/field_sql_storage.module',
      'name' => 'field_sql_storage',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7002',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Field SQL storage',
        'description' => 'Stores field data in an SQL database.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
        ),
        'files' => 
        array (
          0 => 'field_sql_storage.test',
        ),
        'required' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'field_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/field/tests/field_test.module',
      'name' => 'field_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Field API Test',
        'description' => 'Support module for the Field API tests.',
        'core' => '7.x',
        'package' => 'Testing',
        'files' => 
        array (
          0 => 'field_test.entity.inc',
        ),
        'version' => '7.15',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'field_ui' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/field_ui/field_ui.module',
      'name' => 'field_ui',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Field UI',
        'description' => 'User interface for the Field API.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
        ),
        'files' => 
        array (
          0 => 'field_ui.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'file' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/file/file.module',
      'name' => 'file',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'File',
        'description' => 'Defines a file field type.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
        ),
        'files' => 
        array (
          0 => 'tests/file.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'file_entity' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/file_entity/file_entity.module',
      'name' => 'file_entity',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7200',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'File entity',
        'description' => 'Extends Drupal file entities to be fieldable and viewable.',
        'package' => 'Media',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
          1 => 'file',
          2 => 'ctools',
        ),
        'files' => 
        array (
          0 => 'views/views_handler_argument_file_type.inc',
          1 => 'views/views_handler_field_file_type.inc',
          2 => 'views/views_handler_filter_file_type.inc',
          3 => 'views/views_plugin_row_file_view.inc',
          4 => 'tests/file_entity.test',
        ),
        'configure' => 'admin/structure/file-types',
        'version' => '7.x-2.0-unstable6',
        'project' => 'file_entity',
        'datestamp' => '1341083500',
        'php' => '5.2.4',
      ),
      'project' => 'file_entity',
      'version' => '7.x-2.0-unstable6',
    ),
    'file_entity_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/file_entity/tests/file_entity_test.module',
      'name' => 'file_entity_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'File Entity Test',
        'description' => 'Support module for File Entity tests.',
        'package' => 'Testing',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'file_entity',
        ),
        'hidden' => true,
        'version' => '7.x-2.0-unstable6',
        'project' => 'file_entity',
        'datestamp' => '1341083500',
        'php' => '5.2.4',
      ),
      'project' => 'file_entity',
      'version' => '7.x-2.0-unstable6',
    ),
    'file_module_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/file/tests/file_module_test.module',
      'name' => 'file_module_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'File test',
        'description' => 'Provides hooks for testing File module functionality.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'file_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/file_test.module',
      'name' => 'file_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'File test',
        'description' => 'Support module for file handling tests.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'file_test.module',
        ),
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'filter' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/filter/filter.module',
      'name' => 'filter',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7010',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Filter',
        'description' => 'Filters content in preparation for display.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'filter.test',
        ),
        'required' => true,
        'configure' => 'admin/config/content/formats',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'filter_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/filter_test.module',
      'name' => 'filter_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Filter test module',
        'description' => 'Tests filter hooks and functions.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'fontdeck' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/fontyourface/modules/fontdeck/fontdeck.module',
      'name' => 'fontdeck',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '1',
      'info' => 
      array (
        'name' => 'Fontdeck',
        'description' => '@font-your-face provider of fonts from Fontdeck.com.',
        'dependencies' => 
        array (
          0 => 'fontyourface',
        ),
        'package' => '@font-your-face',
        'core' => '7.x',
        'php' => '5.2.0',
        'files' => 
        array (
          0 => 'fontdeck.install',
          1 => 'fontdeck.module',
        ),
        'version' => '7.x-2.4',
        'project' => 'fontyourface',
        'datestamp' => '1343611963',
      ),
      'project' => 'fontyourface',
      'version' => '7.x-2.4',
    ),
    'fontsquirrel' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/fontyourface/modules/fontsquirrel/fontsquirrel.module',
      'name' => 'fontsquirrel',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '1',
      'info' => 
      array (
        'name' => 'Font Squirrel API',
        'description' => '@font-your-face provider with Font Squirrel fonts.',
        'dependencies' => 
        array (
          0 => 'fontyourface',
        ),
        'package' => '@font-your-face',
        'core' => '7.x',
        'php' => '5.2.0',
        'version' => '7.x-2.4',
        'project' => 'fontyourface',
        'datestamp' => '1343611963',
      ),
      'project' => 'fontyourface',
      'version' => '7.x-2.4',
    ),
    'fonts_com' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/fontyourface/modules/fonts_com/fonts_com.module',
      'name' => 'fonts_com',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '1',
      'info' => 
      array (
        'name' => 'Fonts.com',
        'description' => '@font-your-face provider of fonts from Fonts.com.',
        'dependencies' => 
        array (
          0 => 'fontyourface',
        ),
        'package' => '@font-your-face',
        'core' => '7.x',
        'php' => '5.2.0',
        'files' => 
        array (
          0 => 'api.inc',
        ),
        'version' => '7.x-2.4',
        'project' => 'fontyourface',
        'datestamp' => '1343611963',
      ),
      'project' => 'fontyourface',
      'version' => '7.x-2.4',
    ),
    'fontyourface' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/fontyourface/fontyourface.module',
      'name' => 'fontyourface',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7203',
      'weight' => '0',
      'info' => 
      array (
        'name' => '@font-your-face',
        'description' => 'Manages web fonts.',
        'package' => '@font-your-face',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'fontyourface.test',
        ),
        'version' => '7.x-2.4',
        'project' => 'fontyourface',
        'datestamp' => '1343611963',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'fontyourface',
      'version' => '7.x-2.4',
    ),
    'fontyourface_ui' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/fontyourface/modules/fontyourface_ui/fontyourface_ui.module',
      'name' => 'fontyourface_ui',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => '@font-your-face UI',
        'description' => 'Administrative interface for managing fonts.',
        'package' => '@font-your-face',
        'dependencies' => 
        array (
          0 => 'fontyourface',
          1 => 'views',
        ),
        'configure' => 'admin/config/user-interface/fontyourface',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'views/fontyourface.views_default.inc',
          1 => 'views/views_handler_field_fontyourface_font.inc',
          2 => 'views/views_handler_field_fontyourface_foundry.inc',
          3 => 'views/views_handler_field_fontyourface_license.inc',
          4 => 'views/views_handler_field_fontyourface_provider.inc',
          5 => 'views/views_handler_field_fontyourface_tag_font_tid.inc',
          6 => 'views/views_handler_filter_tag_font_tid.inc',
          7 => 'views/views_handler_relationship_fontyourface_tag.inc',
          8 => 'views/views_handler_field_fontyourface_preview.inc',
          9 => 'views/views_handler_field_fontyourface_enable_disable.inc',
          10 => 'views/views_handler_field_fontyourface_enabled_yes_no.inc',
          11 => 'views/views_handler_filter_fontyourface_provider.inc',
          12 => 'views/views_handler_filter_fontyourface_foundry.inc',
        ),
        'version' => '7.x-2.4',
        'project' => 'fontyourface',
        'datestamp' => '1343611963',
        'php' => '5.2.4',
      ),
      'project' => 'fontyourface',
      'version' => '7.x-2.4',
    ),
    'font_reference' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/fontyourface/modules/font_reference/font_reference.module',
      'name' => 'font_reference',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Font Reference',
        'description' => 'Defines a field type for referencing a font from a node.',
        'package' => 'Fields',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'fontyourface',
          1 => 'field',
          2 => 'options',
        ),
        'version' => '7.x-2.4',
        'project' => 'fontyourface',
        'datestamp' => '1343611963',
        'php' => '5.2.4',
      ),
      'project' => 'fontyourface',
      'version' => '7.x-2.4',
    ),
    'form_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/form_test.module',
      'name' => 'form_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'FormAPI Test',
        'description' => 'Support module for Form API tests.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'forum' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/forum/forum.module',
      'name' => 'forum',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7012',
      'weight' => '1',
      'info' => 
      array (
        'name' => 'Forum',
        'description' => 'Provides discussion forums.',
        'dependencies' => 
        array (
          0 => 'taxonomy',
          1 => 'comment',
        ),
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'forum.test',
        ),
        'configure' => 'admin/structure/forum',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'forum.css',
          ),
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'geonames' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/geonames/geonames.module',
      'name' => 'geonames',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7001',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'GeoNames API',
        'description' => 'The GeoNames API provides the programming framework for the GeoNames services.',
        'package' => 'Geonames',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'geonames.admin.inc',
          1 => 'geonames.doc.inc',
          2 => 'geonames.install',
          3 => 'geonames.module',
          4 => 'geonames_config.inc',
          5 => 'tests/geonames.test',
          6 => 'tests/geonames.all.test',
        ),
        'configure' => 'admin/config/geonames',
        'version' => '7.x-1.1',
        'project' => 'geonames',
        'datestamp' => '1342657638',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'geonames',
      'version' => '7.x-1.1',
    ),
    'geonames_tools' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/geonames/geonames_tools.module',
      'name' => 'geonames_tools',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Geonames Tools',
        'description' => 'Various tools that depend on the Geonames Services',
        'dependencies' => 
        array (
          0 => 'geonames',
        ),
        'package' => 'Geonames',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'geonames_tools.module',
        ),
        'version' => '7.x-1.1',
        'project' => 'geonames',
        'datestamp' => '1342657638',
        'php' => '5.2.4',
      ),
      'project' => 'geonames',
      'version' => '7.x-1.1',
    ),
    'google_fonts_api' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/fontyourface/modules/google_fonts_api/google_fonts_api.module',
      'name' => 'google_fonts_api',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7100',
      'weight' => '1',
      'info' => 
      array (
        'name' => 'Google Fonts API',
        'description' => '@font-your-face provider with Google fonts.',
        'dependencies' => 
        array (
          0 => 'fontyourface',
        ),
        'package' => '@font-your-face',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'views/google_fonts_api.views_default.inc',
        ),
        'version' => '7.x-2.4',
        'project' => 'fontyourface',
        'datestamp' => '1343611963',
        'php' => '5.2.4',
      ),
      'project' => 'fontyourface',
      'version' => '7.x-2.4',
    ),
    'help' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/help/help.module',
      'name' => 'help',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Help',
        'description' => 'Manages the display of online help.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'help.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'help_example' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/advanced_help/help_example/help_example.module',
      'name' => 'help_example',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Advanced help example',
        'description' => 'A example help module to demonstrate the advanced help module.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'advanced_help',
        ),
        'files' => 
        array (
          0 => 'help_example.module',
        ),
        'version' => '7.x-1.0',
        'project' => 'advanced_help',
        'datestamp' => '1321022730',
        'php' => '5.2.4',
      ),
      'project' => 'advanced_help',
      'version' => '7.x-1.0',
    ),
    'html5_tools' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/html5_tools/html5_tools.module',
      'name' => 'html5_tools',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'HTML5 Tools',
        'description' => 'Provides a set of tools to allow sites to be built using HTML5.',
        'core' => '7.x',
        'php' => '5',
        'package' => 'Markup',
        'dependencies' => 
        array (
          0 => 'elements',
          1 => 'field',
        ),
        'configure' => 'admin/config/markup/html5-tools',
        'version' => '7.x-1.1',
        'project' => 'html5_tools',
        'datestamp' => '1315838502',
      ),
      'project' => 'html5_tools',
      'version' => '7.x-1.1',
    ),
    'image' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/image/image.module',
      'name' => 'image',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7004',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Image',
        'description' => 'Provides image manipulation tools.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'file',
        ),
        'files' => 
        array (
          0 => 'image.test',
        ),
        'configure' => 'admin/config/media/image-styles',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'image_module_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/image/tests/image_module_test.module',
      'name' => 'image_module_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Image test',
        'description' => 'Provides hook implementations for testing Image module functionality.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'image_module_test.module',
        ),
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'image_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/image_test.module',
      'name' => 'image_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Image test',
        'description' => 'Support module for image toolkit tests.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'insert' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/insert/insert.module',
      'name' => 'insert',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Insert',
        'description' => 'Assists in inserting files, images, or other media into the body field or other text areas.',
        'core' => '7.x',
        'version' => '7.x-1.1',
        'project' => 'insert',
        'datestamp' => '1304092615',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'insert',
      'version' => '7.x-1.1',
    ),
    'libraries' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/libraries/libraries.module',
      'name' => 'libraries',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Libraries',
        'description' => 'Allows version dependent and shared usage of external libraries.',
        'core' => '7.x',
        'version' => '7.x-1.0',
        'project' => 'libraries',
        'datestamp' => '1296096156',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'libraries',
      'version' => '7.x-1.0',
    ),
    'lightbox2' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/lightbox2/lightbox2.module',
      'name' => 'lightbox2',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '6003',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Lightbox2',
        'description' => 'Enables Lightbox2 for Drupal',
        'core' => '7.x',
        'package' => 'User interface',
        'files' => 
        array (
          0 => 'lightbox2.install',
          1 => 'lightbox2.module',
          2 => 'lightbox2.formatter.inc',
          3 => 'lightbox2.admin.inc',
        ),
        'configure' => 'admin/config/user-interface/lightbox2',
        'version' => '7.x-1.0-beta1',
        'project' => 'lightbox2',
        'datestamp' => '1318819001',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'lightbox2',
      'version' => '7.x-1.0-beta1',
    ),
    'link' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/link/link.module',
      'name' => 'link',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7001',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Link',
        'description' => 'Defines simple link field types.',
        'core' => '7.x',
        'package' => 'Fields',
        'files' => 
        array (
          0 => 'link.module',
          1 => 'link.install',
          2 => 'tests/link.test',
          3 => 'tests/link.attribute.test',
          4 => 'tests/link.crud.test',
          5 => 'tests/link.crud_browser.test',
          6 => 'tests/link.token.test',
          7 => 'tests/link.validate.test',
          8 => 'views/link_views_handler_argument_target.inc',
          9 => 'views/link_views_handler_filter_protocol.inc',
        ),
        'version' => '7.x-1.0',
        'project' => 'link',
        'datestamp' => '1319392535',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'link',
      'version' => '7.x-1.0',
    ),
    'list' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/field/modules/list/list.module',
      'name' => 'list',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7002',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'List',
        'description' => 'Defines list field types. Use with Options to create selection lists.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
          1 => 'options',
        ),
        'files' => 
        array (
          0 => 'tests/list.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'list_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/field/modules/list/tests/list_test.module',
      'name' => 'list_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'List test',
        'description' => 'Support module for the List module tests.',
        'core' => '7.x',
        'package' => 'Testing',
        'version' => '7.15',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'locale' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/locale/locale.module',
      'name' => 'locale',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Locale',
        'description' => 'Adds language handling functionality and enables the translation of the user interface to languages other than English.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'locale.test',
        ),
        'configure' => 'admin/config/regional/language',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'locale_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/locale/tests/locale_test.module',
      'name' => 'locale_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Locale Test',
        'description' => 'Support module for the locale layer tests.',
        'core' => '7.x',
        'package' => 'Testing',
        'version' => '7.15',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'local_fonts' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/fontyourface/modules/local_fonts/local_fonts.module',
      'name' => 'local_fonts',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '1',
      'info' => 
      array (
        'name' => 'Local Fonts',
        'description' => '@font-your-face provider with fonts installed locally on the Drupal server.',
        'dependencies' => 
        array (
          0 => 'fontyourface',
        ),
        'package' => '@font-your-face',
        'core' => '7.x',
        'version' => '7.x-2.4',
        'project' => 'fontyourface',
        'datestamp' => '1343611963',
        'php' => '5.2.4',
      ),
      'project' => 'fontyourface',
      'version' => '7.x-2.4',
    ),
    'location' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/location/location.module',
      'name' => 'location',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7301',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Location',
        'package' => 'Location',
        'description' => 'The location module allows you to associate a geographic location with content and users. Users can do proximity searches by postal code.  This is useful for organizing communities that have a geographic presence.',
        'core' => '7.x',
        'configure' => 'admin/config/content/location',
        'files' => 
        array (
          0 => 'location.module',
          1 => 'location.install',
          2 => 'location.admin.inc',
          3 => 'location.georss.inc',
          4 => 'location.inc',
          5 => 'location.token.inc',
          6 => 'location.views.inc',
          7 => 'location.views_default.inc',
          8 => 'tests/location_testcase.php',
          9 => 'tests/cow.test',
          10 => 'tests/earth.test',
          11 => 'tests/google_geocoder.test',
          12 => 'tests/location_cck.test',
          13 => 'handlers/location_handler_argument_location_country.inc',
          14 => 'handlers/location_handler_argument_location_province.inc',
          15 => 'handlers/location_handler_argument_location_proximity.inc',
          16 => 'handlers/location_handler_field_location_address.inc',
          17 => 'handlers/location_handler_field_location_country.inc',
          18 => 'handlers/location_handler_field_location_distance.inc',
          19 => 'handlers/location_handler_field_location_province.inc',
          20 => 'handlers/location_handler_field_location_street.inc',
          21 => 'handlers/location_handler_filter_location_country.inc',
          22 => 'handlers/location_handler_filter_location_province.inc',
          23 => 'handlers/location_handler_sort_location_distance.inc',
          24 => 'handlers/location_views_handler_field_coordinates.inc',
          25 => 'handlers/location_views_handler_field_latitude.inc',
          26 => 'handlers/location_views_handler_field_longitude.inc',
          27 => 'handlers/location_views_handler_filter_proximity.inc',
          28 => 'plugins/contexts/location.inc',
          29 => 'plugins/relationships/location_from_node.inc',
        ),
        'version' => '7.x-3.0-alpha1',
        'project' => 'location',
        'datestamp' => '1343220794',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'location',
      'version' => '7.x-3.0-alpha1',
    ),
    'location_addanother' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/location/contrib/location_addanother/location_addanother.module',
      'name' => 'location_addanother',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Location Add Another',
        'description' => 'Allows you to quickly add locations directly from a node without having to click \'edit\' first.',
        'dependencies' => 
        array (
          0 => 'location',
          1 => 'location_node',
        ),
        'package' => 'Location',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'location_addanother.module',
          1 => 'location_addanother.install',
        ),
        'version' => '7.x-3.0-alpha1',
        'project' => 'location',
        'datestamp' => '1343220794',
        'php' => '5.2.4',
      ),
      'project' => 'location',
      'version' => '7.x-3.0-alpha1',
    ),
    'location_cck' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/location/contrib/location_cck/location_cck.module',
      'name' => 'location_cck',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '6301',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Location CCK',
        'description' => 'Defines a Location field type.',
        'dependencies' => 
        array (
          0 => 'location',
        ),
        'package' => 'CCK',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'location_cck.module',
          1 => 'location_cck.install',
        ),
        'version' => '7.x-3.0-alpha1',
        'project' => 'location',
        'datestamp' => '1343220794',
        'php' => '5.2.4',
      ),
      'project' => 'location',
      'version' => '7.x-3.0-alpha1',
    ),
    'location_fax' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/location/contrib/location_fax/location_fax.module',
      'name' => 'location_fax',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Location Fax',
        'package' => 'Location',
        'description' => 'Allows you to add a fax number to a location.',
        'dependencies' => 
        array (
          0 => 'location',
        ),
        'core' => '7.x',
        'files' => 
        array (
          0 => 'location_fax.module',
          1 => 'location_fax.install',
          2 => 'location_fax.views.inc',
        ),
        'version' => '7.x-3.0-alpha1',
        'project' => 'location',
        'datestamp' => '1343220794',
        'php' => '5.2.4',
      ),
      'project' => 'location',
      'version' => '7.x-3.0-alpha1',
    ),
    'location_generate' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/location/contrib/location_generate/location_generate.module',
      'name' => 'location_generate',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Location Generate',
        'description' => 'Bulk assign random latitude and longitudes to nodes.',
        'package' => 'Development',
        'dependencies' => 
        array (
          0 => 'devel_generate',
          1 => 'location',
        ),
        'core' => '7.x',
        'files' => 
        array (
          0 => 'location_generate.module',
        ),
        'version' => '7.x-3.0-alpha1',
        'project' => 'location',
        'datestamp' => '1343220794',
        'php' => '5.2.4',
      ),
      'project' => 'location',
      'version' => '7.x-3.0-alpha1',
    ),
    'location_node' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/location/location_node.module',
      'name' => 'location_node',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Node Locations',
        'description' => 'Associate locations with nodes.',
        'dependencies' => 
        array (
          0 => 'location',
        ),
        'package' => 'Location',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'location_node.module',
          1 => 'location_node.install',
        ),
        'version' => '7.x-3.0-alpha1',
        'project' => 'location',
        'datestamp' => '1343220794',
        'php' => '5.2.4',
      ),
      'project' => 'location',
      'version' => '7.x-3.0-alpha1',
    ),
    'location_phone' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/location/contrib/location_phone/location_phone.module',
      'name' => 'location_phone',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '6301',
      'weight' => '1',
      'info' => 
      array (
        'name' => 'Location Phone',
        'package' => 'Location',
        'description' => 'Allows you to add a phone number to a location.',
        'dependencies' => 
        array (
          0 => 'location',
        ),
        'core' => '7.x',
        'files' => 
        array (
          0 => 'location_phone.module',
          1 => 'location_phone.install',
          2 => 'location_phone.views.inc',
        ),
        'version' => '7.x-3.0-alpha1',
        'project' => 'location',
        'datestamp' => '1343220794',
        'php' => '5.2.4',
      ),
      'project' => 'location',
      'version' => '7.x-3.0-alpha1',
    ),
    'location_search' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/location/contrib/location_search/location_search.module',
      'name' => 'location_search',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => '5300',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Location Search',
        'package' => 'Location',
        'description' => 'Advanced search page for locations.',
        'dependencies' => 
        array (
          0 => 'search',
          1 => 'location',
        ),
        'core' => '7.x',
        'files' => 
        array (
          0 => 'location_search.module',
          1 => 'location_search.install',
          2 => 'location_search.admin.inc',
        ),
        'version' => '7.x-3.0-alpha1',
        'project' => 'location',
        'datestamp' => '1343220794',
        'php' => '5.2.4',
      ),
      'project' => 'location',
      'version' => '7.x-3.0-alpha1',
    ),
    'location_taxonomy' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/location/contrib/location_taxonomy/location_taxonomy.module',
      'name' => 'location_taxonomy',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Location Taxonomy',
        'description' => 'Associate locations with taxonomy terms.',
        'dependencies' => 
        array (
          0 => 'location',
          1 => 'taxonomy',
        ),
        'package' => 'Location',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'location_taxonomy.module',
          1 => 'location_taxonomy.install',
        ),
        'version' => '7.x-3.0-alpha1',
        'project' => 'location',
        'datestamp' => '1343220794',
        'php' => '5.2.4',
      ),
      'project' => 'location',
      'version' => '7.x-3.0-alpha1',
    ),
    'location_user' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/location/location_user.module',
      'name' => 'location_user',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'User Locations',
        'description' => 'Associate locations with users.',
        'dependencies' => 
        array (
          0 => 'location',
        ),
        'package' => 'Location',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'location_user.module',
          1 => 'location_user.install',
        ),
        'configure' => 'admin/config/people/accounts',
        'version' => '7.x-3.0-alpha1',
        'project' => 'location',
        'datestamp' => '1343220794',
        'php' => '5.2.4',
      ),
      'project' => 'location',
      'version' => '7.x-3.0-alpha1',
    ),
    'logintoboggan' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/logintoboggan/logintoboggan.module',
      'name' => 'logintoboggan',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7000',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'LoginToboggan',
        'description' => 'Improves Drupal\'s login system.',
        'core' => '7.x',
        'configure' => 'admin/config/system/logintoboggan',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'logintoboggan.css',
          ),
        ),
        'version' => '7.x-1.3',
        'project' => 'logintoboggan',
        'datestamp' => '1320873335',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'logintoboggan',
      'version' => '7.x-1.3',
    ),
    'logintoboggan_content_access_integration' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/logintoboggan/contrib/logintoboggan_content_access_integration/logintoboggan_content_access_integration.module',
      'name' => 'logintoboggan_content_access_integration',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'LoginToboggan Content Access Integration',
        'description' => 'Integrates LoginToboggan with Content Access module, so that Non-validated users are handled correctly',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'logintoboggan',
          1 => 'content_access',
        ),
        'version' => '7.x-1.3',
        'project' => 'logintoboggan',
        'datestamp' => '1320873335',
        'php' => '5.2.4',
      ),
      'project' => 'logintoboggan',
      'version' => '7.x-1.3',
    ),
    'logintoboggan_rules' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/logintoboggan/contrib/logintoboggan_rules/logintoboggan_rules.module',
      'name' => 'logintoboggan_rules',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'LoginToboggan Rules Integration',
        'description' => 'Integrates LoginToboggan with Rules module',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'logintoboggan',
          1 => 'rules',
        ),
        'version' => '7.x-1.3',
        'project' => 'logintoboggan',
        'datestamp' => '1320873335',
        'php' => '5.2.4',
      ),
      'project' => 'logintoboggan',
      'version' => '7.x-1.3',
    ),
    'logintoboggan_variable' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/logintoboggan/contrib/logintoboggan_variable/logintoboggan_variable.module',
      'name' => 'logintoboggan_variable',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'LoginToboggan Variable Integration',
        'description' => 'Integrates LoginToboggan with Variable module',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'logintoboggan',
          1 => 'variable',
        ),
        'version' => '7.x-1.3',
        'project' => 'logintoboggan',
        'datestamp' => '1320873335',
        'php' => '5.2.4',
      ),
      'project' => 'logintoboggan',
      'version' => '7.x-1.3',
    ),
    'mailsystem' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/mailsystem/mailsystem.module',
      'name' => 'mailsystem',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'package' => 'Mail',
        'name' => 'Mail System',
        'description' => 'Provides a user interface for per-module and site-wide mail_system selection.',
        'php' => '5.0',
        'core' => '7.x',
        'configure' => 'admin/config/system/mailsystem',
        'dependencies' => 
        array (
          0 => 'filter',
        ),
        'version' => '7.x-2.34',
        'project' => 'mailsystem',
        'datestamp' => '1334082653',
      ),
      'project' => 'mailsystem',
      'version' => '7.x-2.34',
    ),
    'media' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/media/media.module',
      'name' => 'media',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7020',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Media',
        'description' => 'Provides the core Media API',
        'package' => 'Media',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'file_entity',
          1 => 'image',
        ),
        'files' => 
        array (
          0 => 'includes/MediaReadOnlyStreamWrapper.inc',
          1 => 'test/media.types.test',
          2 => 'test/media.entity.test',
        ),
        'configure' => 'admin/config/media/browser',
        'version' => '7.x-1.2',
        'project' => 'media',
        'datestamp' => '1341095504',
        'php' => '5.2.4',
      ),
      'project' => 'media',
      'version' => '7.x-1.2',
    ),
    'mediaelement' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/mediaelement/mediaelement.module',
      'name' => 'mediaelement',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'MediaElement.js',
        'description' => 'Provide MediaElement.js to be used on the entire site or just with Filefields.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'libraries',
        ),
        'files' => 
        array (
          0 => 'mediaelement.admin.inc',
          1 => 'mediaelement.install',
          2 => 'mediaelement.module',
        ),
        'configure' => 'admin/config/media/mediaelement',
        'version' => '7.x-1.2',
        'project' => 'mediaelement',
        'datestamp' => '1326568843',
        'php' => '5.2.4',
      ),
      'project' => 'mediaelement',
      'version' => '7.x-1.2',
    ),
    'media_internet' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/media/modules/media_internet/media_internet.module',
      'name' => 'media_internet',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Media Internet Sources',
        'description' => 'Provides an API for accessing media on various internet services',
        'package' => 'Media',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'media',
        ),
        'files' => 
        array (
          0 => 'media_internet.module',
        ),
        'version' => '7.x-1.2',
        'project' => 'media',
        'datestamp' => '1341095504',
        'php' => '5.2.4',
      ),
      'project' => 'media',
      'version' => '7.x-1.2',
    ),
    'media_youtube' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/media_youtube/media_youtube.module',
      'name' => 'media_youtube',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7012',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Media: YouTube',
        'description' => 'Provides YouTube support to the Media module.',
        'package' => 'Media',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'media_youtube.module',
          1 => 'includes/MediaInternetYouTubeHandler.inc',
          2 => 'includes/MediaYouTubeStreamWrapper.inc',
          3 => 'includes/MediaYouTubeStyles.inc',
          4 => 'includes/media_youtube.formatters.inc',
          5 => 'includes/media_youtube.styles.inc',
          6 => 'includes/media_youtube.variables.inc',
        ),
        'dependencies' => 
        array (
          0 => 'media_internet',
        ),
        'version' => '7.x-1.0-beta3',
        'project' => 'media_youtube',
        'datestamp' => '1331655643',
        'php' => '5.2.4',
      ),
      'project' => 'media_youtube',
      'version' => '7.x-1.0-beta3',
    ),
    'menu' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/menu/menu.module',
      'name' => 'menu',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7003',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Menu',
        'description' => 'Allows administrators to customize the site navigation menu.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'menu.test',
        ),
        'configure' => 'admin/structure/menu',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'menu_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/menu_test.module',
      'name' => 'menu_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Hook menu tests',
        'description' => 'Support module for menu hook testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'mimemail' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/mimemail/mimemail.module',
      'name' => 'mimemail',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7000',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Mime Mail',
        'description' => 'Send MIME-encoded emails with embedded images and attachments.',
        'dependencies' => 
        array (
          0 => 'mailsystem',
        ),
        'package' => 'Mail',
        'core' => '7.x',
        'configure' => 'admin/config/system/mimemail',
        'files' => 
        array (
          0 => 'mimemail.inc',
          1 => 'mimemail.install',
          2 => 'mimemail.module',
          3 => 'mimemail.rules.inc',
          4 => 'includes/mimemail.admin.inc',
          5 => 'includes/mimemail.mail.inc',
          6 => 'includes/mimemail.incoming.inc',
          7 => 'theme/mimemail-message.tpl.php',
          8 => 'theme/mimemail.theme.inc',
        ),
        'version' => '7.x-1.0-alpha1',
        'project' => 'mimemail',
        'datestamp' => '1324234543',
        'php' => '5.2.4',
      ),
      'project' => 'mimemail',
      'version' => '7.x-1.0-alpha1',
    ),
    'mimemail_action' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/mimemail/modules/mimemail_action/mimemail_action.module',
      'name' => 'mimemail_action',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Mime Mail Action',
        'description' => 'Provide actions for Mime Mail.',
        'package' => 'Mail',
        'dependencies' => 
        array (
          0 => 'mimemail',
          1 => 'trigger',
        ),
        'core' => '7.x',
        'files' => 
        array (
          0 => 'mimemail_action.module',
        ),
        'version' => '7.x-1.0-alpha1',
        'project' => 'mimemail',
        'datestamp' => '1324234543',
        'php' => '5.2.4',
      ),
      'project' => 'mimemail',
      'version' => '7.x-1.0-alpha1',
    ),
    'mimemail_compress' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/mimemail/modules/mimemail_compress/mimemail_compress.module',
      'name' => 'mimemail_compress',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Mime Mail CSS Compressor',
        'description' => 'Converts CSS to inline styles in an HTML message. (Requires the PHP DOM extension.)',
        'package' => 'Mail',
        'dependencies' => 
        array (
          0 => 'mimemail',
        ),
        'core' => '7.x',
        'files' => 
        array (
          0 => 'mimemail_compress.inc',
          1 => 'mimemail_compress.install',
          2 => 'mimemail_compress.module',
        ),
        'version' => '7.x-1.0-alpha1',
        'project' => 'mimemail',
        'datestamp' => '1324234543',
        'php' => '5.2.4',
      ),
      'project' => 'mimemail',
      'version' => '7.x-1.0-alpha1',
    ),
    'modernizr' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/modernizr/modernizr.module',
      'name' => 'modernizr',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Modernizr',
        'description' => 'Modernizr integration to Drupal',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'modernizr.module',
        ),
        'version' => '7.x-1.0',
        'project' => 'modernizr',
        'datestamp' => '1288647063',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'modernizr',
      'version' => '7.x-1.0',
    ),
    'module_filter' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/module_filter/module_filter.module',
      'name' => 'module_filter',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Module filter',
        'description' => 'Filter the modules list.',
        'core' => '7.x',
        'package' => 'Administration',
        'files' => 
        array (
          0 => 'module_filter.install',
          1 => 'module_filter.js',
          2 => 'module_filter.module',
          3 => 'module_filter.admin.inc',
          4 => 'module_filter.theme.inc',
          5 => 'css/module_filter.css',
          6 => 'css/module_filter_tab.css',
          7 => 'js/module_filter.js',
          8 => 'js/module_filter_tab.js',
        ),
        'configure' => 'admin/config/user-interface/modulefilter',
        'version' => '7.x-2.x-dev',
        'project' => 'module_filter',
        'datestamp' => '1341534644',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'module_filter',
      'version' => '7.x-2.x-dev',
    ),
    'module_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/module_test.module',
      'name' => 'module_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Module test',
        'description' => 'Support module for module system testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'moonmars' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars/moonmars.module',
      'name' => 'moonmars',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com',
        'description' => 'General support for moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_channels' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_channels/moonmars_channels.module',
      'name' => 'moonmars_channels',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Channels',
        'description' => 'Support for channels on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_comments' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_comments/moonmars_comments.module',
      'name' => 'moonmars_comments',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Comments',
        'description' => 'Support for comment on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_commerce' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_commerce/moonmars_commerce.module',
      'name' => 'moonmars_commerce',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Commerce',
        'description' => 'Support for commerce on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
          0 => 'currency_api',
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_events' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_events/moonmars_events.module',
      'name' => 'moonmars_events',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Events',
        'description' => 'Support for events on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_geo' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_geo/moonmars_geo.module',
      'name' => 'moonmars_geo',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Geography',
        'description' => 'Support for geographical stuff on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
          0 => 'geonames',
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_groups' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_groups/moonmars_groups.module',
      'name' => 'moonmars_groups',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Groups',
        'description' => 'Support for groups on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_items' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_items/moonmars_items.module',
      'name' => 'moonmars_items',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Items',
        'description' => 'Support for posted items on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_member' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x',
      'name' => 'moonmars_member',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'dependencies' => 
        array (
        ),
        'description' => '',
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_members' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_members/moonmars_members.module',
      'name' => 'moonmars_members',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Members',
        'description' => 'Support for members on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_posts' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x',
      'name' => 'moonmars_posts',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'dependencies' => 
        array (
        ),
        'description' => '',
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_projects' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_projects/moonmars_projects.module',
      'name' => 'moonmars_projects',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Projects',
        'description' => 'Support for projects on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_ratings' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_ratings/moonmars_ratings.module',
      'name' => 'moonmars_ratings',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Ratings',
        'description' => 'Support for ratings on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_text' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_text/moonmars_text.module',
      'name' => 'moonmars_text',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Text',
        'description' => 'Support for text processing on moonmars.com.',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_update' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/moonmars_update/moonmars_update.module',
      'name' => 'moonmars_update',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'moonmars.com Update',
        'description' => 'Support for running database update scripts on moonmars.com. **** Should only be enabled temporarily on live site. ****',
        'core' => '7.x',
        'package' => 'moonmars.com',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'moonmars_users' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x',
      'name' => 'moonmars_users',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'dependencies' => 
        array (
        ),
        'description' => '',
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'nice_menus' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/nice_menus/nice_menus.module',
      'name' => 'nice_menus',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Nice Menus',
        'description' => 'CSS/jQuery drop-down, drop-right and drop-left menus to be placed in blocks',
        'dependencies' => 
        array (
          0 => 'menu',
        ),
        'core' => '7.x',
        'configure' => 'admin/config/user-interface/nice_menus',
        'files' => 
        array (
          0 => 'nice_menus.install',
          1 => 'nice_menus.module',
        ),
        'version' => '7.x-2.0',
        'project' => 'nice_menus',
        'datestamp' => '1313468827',
        'php' => '5.2.4',
      ),
      'project' => 'nice_menus',
      'version' => '7.x-2.0',
    ),
    'node' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/node/node.module',
      'name' => 'node',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7013',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Node',
        'description' => 'Allows content to be submitted to the site and displayed on pages.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'node.module',
          1 => 'node.test',
        ),
        'required' => true,
        'configure' => 'admin/structure/types',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'node.css',
          ),
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'nodejs' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/nodejs/nodejs.module',
      'name' => 'nodejs',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Nodejs integration',
        'description' => 'Adds Node.js support to Drupal',
        'package' => 'Nodejs',
        'version' => '7.x-1.0',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'nodejs.module',
        ),
        'configure' => 'admin/config/nodejs',
        'project' => 'nodejs',
        'datestamp' => '1344654738',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'nodejs',
      'version' => '7.x-1.0',
    ),
    'nodejs_actions' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/nodejs/nodejs_actions/nodejs_actions.module',
      'name' => 'nodejs_actions',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Nodejs Actions',
        'description' => 'Provides actions that dispatch realtime user notifications via node.js.',
        'package' => 'Nodejs',
        'version' => '7.x-1.0',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'nodejs',
          1 => 'trigger',
        ),
        'project' => 'nodejs',
        'datestamp' => '1344654738',
        'php' => '5.2.4',
      ),
      'project' => 'nodejs',
      'version' => '7.x-1.0',
    ),
    'nodejs_ajax' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/nodejs/nodejs_ajax/nodejs_ajax.module',
      'name' => 'nodejs_ajax',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Nodejs/AJAX framework integration',
        'description' => 'Adds support for the Drupal AJAX framework to the Nodejs module',
        'package' => 'Nodejs',
        'version' => '7.x-1.0',
        'core' => '7.x',
        'project' => 'nodejs',
        'datestamp' => '1344654738',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'nodejs',
      'version' => '7.x-1.0',
    ),
    'nodejs_buddylist' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/nodejs/nodejs_buddylist/nodejs_buddylist.module',
      'name' => 'nodejs_buddylist',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Nodejs Buddylist',
        'description' => 'Allows for dynamic buddy list and user blocks',
        'package' => 'Nodejs',
        'version' => '7.x-1.0',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'nodejs',
          1 => 'flag_friend',
        ),
        'project' => 'nodejs',
        'datestamp' => '1344654738',
        'php' => '5.2.4',
      ),
      'project' => 'nodejs',
      'version' => '7.x-1.0',
    ),
    'nodejs_config' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/nodejs/nodejs_config/nodejs_config.module',
      'name' => 'nodejs_config',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Nodejs Config',
        'description' => 'Helps to configure the nodejs module.',
        'package' => 'Nodejs',
        'version' => '7.x-1.0',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'nodejs',
        ),
        'project' => 'nodejs',
        'datestamp' => '1344654738',
        'php' => '5.2.4',
      ),
      'project' => 'nodejs',
      'version' => '7.x-1.0',
    ),
    'nodejs_notify' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/nodejs/nodejs_notify/nodejs_notify.module',
      'name' => 'nodejs_notify',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Nodejs Notifications',
        'description' => 'Adds a client to pages for displaying realtime notification from node.js.',
        'package' => 'Nodejs',
        'version' => '7.x-1.0',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'nodejs',
        ),
        'project' => 'nodejs',
        'datestamp' => '1344654738',
        'php' => '5.2.4',
      ),
      'project' => 'nodejs',
      'version' => '7.x-1.0',
    ),
    'nodejs_subscribe' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/nodejs/nodejs_subscribe/nodejs_subscribe.module',
      'name' => 'nodejs_subscribe',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Nodejs subscribe',
        'description' => 'Adds realtime notifications for subscribed content.',
        'package' => 'Nodejs',
        'version' => '7.x-1.0',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'nodejs',
        ),
        'project' => 'nodejs',
        'datestamp' => '1344654738',
        'php' => '5.2.4',
      ),
      'project' => 'nodejs',
      'version' => '7.x-1.0',
    ),
    'nodejs_watchdog' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/nodejs/nodejs_watchdog/nodejs_watchdog.module',
      'name' => 'nodejs_watchdog',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Nodejs Watchdog',
        'description' => 'Adds watchdog messages to the dblog page in realtime.',
        'package' => 'Nodejs',
        'version' => '7.x-1.0',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'nodejs',
          1 => 'nodejs_ajax',
          2 => 'dblog',
        ),
        'project' => 'nodejs',
        'datestamp' => '1344654738',
        'php' => '5.2.4',
      ),
      'project' => 'nodejs',
      'version' => '7.x-1.0',
    ),
    'node_access_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/node/tests/node_access_test.module',
      'name' => 'node_access_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Node module access tests',
        'description' => 'Support module for node permission testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'node_reference' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/references/node_reference/node_reference.module',
      'name' => 'node_reference',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Node Reference',
        'description' => 'Defines a field type for referencing one node from another.',
        'package' => 'Fields',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
          1 => 'references',
          2 => 'options',
        ),
        'files' => 
        array (
          0 => 'node_reference.test',
        ),
        'version' => '7.x-2.0',
        'project' => 'references',
        'datestamp' => '1324596643',
        'php' => '5.2.4',
      ),
      'project' => 'references',
      'version' => '7.x-2.0',
    ),
    'node_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/node/tests/node_test.module',
      'name' => 'node_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Node module tests',
        'description' => 'Support module for node related testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'node_test_exception' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/node/tests/node_test_exception.module',
      'name' => 'node_test_exception',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Node module exception tests',
        'description' => 'Support module for node related exception testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'number' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/field/modules/number/number.module',
      'name' => 'number',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Number',
        'description' => 'Defines numeric field types.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
        ),
        'files' => 
        array (
          0 => 'number.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'openid' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/openid/openid.module',
      'name' => 'openid',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'OpenID',
        'description' => 'Allows users to log into your site using OpenID.',
        'version' => '7.15',
        'package' => 'Core',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'openid.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'openid_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/openid/tests/openid_test.module',
      'name' => 'openid_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'OpenID dummy provider',
        'description' => 'OpenID provider used for testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'openid',
        ),
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'options' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/field/modules/options/options.module',
      'name' => 'options',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Options',
        'description' => 'Defines selection, check box and radio button widgets for text and numeric fields.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
        ),
        'files' => 
        array (
          0 => 'options.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'overlay' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/overlay/overlay.module',
      'name' => 'overlay',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Overlay',
        'description' => 'Displays the Drupal administration interface in an overlay.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'page_manager' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/page_manager/page_manager.module',
      'name' => 'page_manager',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '99',
      'info' => 
      array (
        'name' => 'Page manager',
        'description' => 'Provides a UI and API to manage pages within the site.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'package' => 'Chaos tool suite',
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'panels' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/panels/panels.module',
      'name' => 'panels',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7301',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Panels',
        'description' => 'Core Panels display functions; provides no external UI, at least one other Panels module should be enabled.',
        'core' => '7.x',
        'package' => 'Panels',
        'configure' => 'admin/structure/panels',
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'files' => 
        array (
          0 => 'panels.module',
          1 => 'includes/common.inc',
          2 => 'includes/legacy.inc',
          3 => 'includes/plugins.inc',
          4 => 'plugins/views/panels_views_plugin_row_fields.inc',
        ),
        'version' => '7.x-3.2',
        'project' => 'panels',
        'datestamp' => '1332079243',
        'php' => '5.2.4',
      ),
      'project' => 'panels',
      'version' => '7.x-3.2',
    ),
    'panels_ipe' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/panels/panels_ipe/panels_ipe.module',
      'name' => 'panels_ipe',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Panels In-Place Editor',
        'description' => 'Provide a UI for managing some Panels directly on the frontend, instead of having to use the backend.',
        'package' => 'Panels',
        'dependencies' => 
        array (
          0 => 'panels',
        ),
        'core' => '7.x',
        'configure' => 'admin/structure/panels',
        'files' => 
        array (
          0 => 'panels_ipe.module',
        ),
        'version' => '7.x-3.2',
        'project' => 'panels',
        'datestamp' => '1332079243',
        'php' => '5.2.4',
      ),
      'project' => 'panels',
      'version' => '7.x-3.2',
    ),
    'panels_mini' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/panels/panels_mini/panels_mini.module',
      'name' => 'panels_mini',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Mini panels',
        'description' => 'Create mini panels that can be used as blocks by Drupal and panes by other panel modules.',
        'package' => 'Panels',
        'dependencies' => 
        array (
          0 => 'panels',
        ),
        'core' => '7.x',
        'files' => 
        array (
          0 => 'plugins/export_ui/panels_mini_ui.class.php',
        ),
        'version' => '7.x-3.2',
        'project' => 'panels',
        'datestamp' => '1332079243',
        'php' => '5.2.4',
      ),
      'project' => 'panels',
      'version' => '7.x-3.2',
    ),
    'panels_node' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/panels/panels_node/panels_node.module',
      'name' => 'panels_node',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Panel nodes',
        'description' => 'Create nodes that are divided into areas with selectable content.',
        'package' => 'Panels',
        'dependencies' => 
        array (
          0 => 'panels',
        ),
        'configure' => 'admin/structure/panels',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'panels_node.module',
        ),
        'version' => '7.x-3.2',
        'project' => 'panels',
        'datestamp' => '1332079243',
        'php' => '5.2.4',
      ),
      'project' => 'panels',
      'version' => '7.x-3.2',
    ),
    'path' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/path/path.module',
      'name' => 'path',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Path',
        'description' => 'Allows users to rename URLs.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'path.test',
        ),
        'configure' => 'admin/config/search/path',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'pathauto' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/pathauto/pathauto.module',
      'name' => 'pathauto',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7005',
      'weight' => '1',
      'info' => 
      array (
        'name' => 'Pathauto',
        'description' => 'Provides a mechanism for modules to automatically generate aliases for the content they manage.',
        'dependencies' => 
        array (
          0 => 'path',
          1 => 'token',
        ),
        'core' => '7.x',
        'files' => 
        array (
          0 => 'pathauto.test',
        ),
        'configure' => 'admin/config/search/path/patterns',
        'recommends' => 
        array (
          0 => 'redirect',
        ),
        'version' => '7.x-1.2',
        'project' => 'pathauto',
        'datestamp' => '1344525185',
        'php' => '5.2.4',
      ),
      'project' => 'pathauto',
      'version' => '7.x-1.2',
    ),
    'path_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/path_test.module',
      'name' => 'path_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Hook path tests',
        'description' => 'Support module for path hook testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'persistent_login' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/persistent_login/persistent_login.module',
      'name' => 'persistent_login',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '1',
      'schema_version' => '7002',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Persistent Login',
        'description' => 'Provides a \'Remember Me\' checkbox in the login form.',
        'core' => '7.x',
        'configure' => 'admin/config/system/persistent_login',
        'version' => '7.x-1.0-beta1',
        'project' => 'persistent_login',
        'datestamp' => '1341816136',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'persistent_login',
      'version' => '7.x-1.0-beta1',
    ),
    'php' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/php/php.module',
      'name' => 'php',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'PHP filter',
        'description' => 'Allows embedded PHP code/snippets to be evaluated.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'php.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'poll' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/poll/poll.module',
      'name' => 'poll',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7004',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Poll',
        'description' => 'Allows your site to capture votes on different topics in the form of multiple choice questions.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'poll.test',
        ),
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'poll.css',
          ),
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'prepro' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/prepro/prepro.module',
      'name' => 'prepro',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Preprocessor',
        'description' => 'Provides an API for modules to offer preprocessing for stylesheets and javascripts.',
        'core' => '7.x',
        'configure' => 'admin/config/media/prepro',
        'version' => '7.x-0.5',
        'project' => 'prepro',
        'datestamp' => '1340900536',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'prepro',
      'version' => '7.x-0.5',
    ),
    'profile' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/profile/profile.module',
      'name' => 'profile',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Profile',
        'description' => 'Supports configurable user profiles.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'profile.test',
        ),
        'configure' => 'admin/config/people/profile',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'queue_mail' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/queue_mail/queue_mail.module',
      'name' => 'queue_mail',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7000',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Queue Mail',
        'core' => '7.x',
        'description' => 'Queues all mail sent by your Drupal site so that it is sent via cron using the Drupal 7 Queues API. This is helpful for large traffic sites where sending a lot of emails per page request can slow things down considerably.',
        'package' => 'Mail',
        'files' => 
        array (
          0 => 'queue_mail.test',
        ),
        'configure' => 'admin/config/system/queue_mail',
        'dependencies' => 
        array (
          0 => 'system (>=7.12)',
        ),
        'version' => '7.x-1.0',
        'project' => 'queue_mail',
        'datestamp' => '1339180025',
        'php' => '5.2.4',
      ),
      'project' => 'queue_mail',
      'version' => '7.x-1.0',
    ),
    'queue_mail_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/queue_mail/queue_mail_test/queue_mail_test.module',
      'name' => 'queue_mail_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Queue Mail Test',
        'description' => 'Module for use by the queue mail module tests.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'queue_mail',
        ),
        'package' => 'Testing',
        'hidden' => true,
        'version' => '7.x-1.0',
        'project' => 'queue_mail',
        'datestamp' => '1339180025',
        'php' => '5.2.4',
      ),
      'project' => 'queue_mail',
      'version' => '7.x-1.0',
    ),
    'rates_relation' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/features/rates_relation/rates_relation.module',
      'name' => 'rates_relation',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Rates relation',
        'core' => '7.x',
        'package' => 'Features',
        'dependencies' => 
        array (
          0 => 'ctools',
          1 => 'relation',
        ),
        'features' => 
        array (
          'ctools' => 
          array (
            0 => 'relation:relation_type_default:1',
          ),
          'features_api' => 
          array (
            0 => 'api:1',
          ),
          'relation_type' => 
          array (
            0 => 'rates',
          ),
        ),
        'description' => '',
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'rates_relation_fields' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/features/rates_relation_fields/rates_relation_fields.module',
      'name' => 'rates_relation_fields',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Rates relation fields',
        'core' => '7.x',
        'package' => 'Features',
        'dependencies' => 
        array (
          0 => 'features',
          1 => 'field_sql_storage',
          2 => 'number',
        ),
        'features' => 
        array (
          'features_api' => 
          array (
            0 => 'api:1',
          ),
          'field' => 
          array (
            0 => 'relation-rates-field_multiplier',
            1 => 'relation-rates-field_rating',
          ),
        ),
        'description' => '',
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'rdf' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/rdf/rdf.module',
      'name' => 'rdf',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'RDF',
        'description' => 'Enriches your content with metadata to let other applications (e.g. search engines, aggregators) better understand its relationships and attributes.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'rdf.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'rdf_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/rdf/tests/rdf_test.module',
      'name' => 'rdf_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'RDF module tests',
        'description' => 'Support module for RDF module testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'references' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/references/references.module',
      'name' => 'references',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'References',
        'description' => 'Defines common base features for the various reference field types.',
        'package' => 'Fields',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
          1 => 'options',
        ),
        'files' => 
        array (
          0 => 'views/references_handler_relationship.inc',
          1 => 'views/references_handler_argument.inc',
          2 => 'views/references_plugin_display.inc',
          3 => 'views/references_plugin_style.inc',
          4 => 'views/references_plugin_row_fields.inc',
        ),
        'version' => '7.x-2.0',
        'project' => 'references',
        'datestamp' => '1324596643',
        'php' => '5.2.4',
      ),
      'project' => 'references',
      'version' => '7.x-2.0',
    ),
    'relation' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/relation/relation.module',
      'name' => 'relation',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7002',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Relation',
        'description' => 'Describes relationships between entities.',
        'core' => '7.x',
        'package' => 'Relation',
        'files' => 
        array (
          0 => 'relation.database.inc',
          1 => 'tests/relation.test',
          2 => 'tests/relation.rules.test',
          3 => 'tests/relation.views.test',
          4 => 'views/relation_handler_relationship.inc',
        ),
        'dependencies' => 
        array (
          0 => 'relation_endpoint',
        ),
        'version' => '7.x-1.0-rc3',
        'project' => 'relation',
        'datestamp' => '1343238481',
        'php' => '5.2.4',
      ),
      'project' => 'relation',
      'version' => '7.x-1.0-rc3',
    ),
    'relation_add' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x',
      'name' => 'relation_add',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'dependencies' => 
        array (
        ),
        'description' => '',
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'relation_dummy_field' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/relation/relation_dummy_field/relation_dummy_field.module',
      'name' => 'relation_dummy_field',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Relation Dummy Field',
        'description' => 'Dummy field to display relation data inline on entities.',
        'core' => '7.x',
        'package' => 'Relation',
        'dependencies' => 
        array (
          0 => 'relation',
        ),
        'files' => 
        array (
          0 => 'tests/relation_dummy_field.test',
        ),
        'version' => '7.x-1.0-rc3',
        'project' => 'relation',
        'datestamp' => '1343238481',
        'php' => '5.2.4',
      ),
      'project' => 'relation',
      'version' => '7.x-1.0-rc3',
    ),
    'relation_endpoint' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/relation/relation_endpoint.module',
      'name' => 'relation_endpoint',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Relation Endpoints Field',
        'description' => 'Helper module for Relation. Defines endpoints field (not usable except by relation).',
        'core' => '7.x',
        'package' => 'Relation',
        'version' => '7.x-1.0-rc3',
        'project' => 'relation',
        'datestamp' => '1343238481',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'relation',
      'version' => '7.x-1.0-rc3',
    ),
    'relation_entity_collector' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/relation/relation_entity_collector/relation_entity_collector.module',
      'name' => 'relation_entity_collector',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Relation Entity Collector block',
        'description' => 'A block to collect entities loaded on any page(s), and create relations from them.',
        'core' => '7.x',
        'package' => 'Relation',
        'dependencies' => 
        array (
          0 => 'relation',
          1 => 'block',
        ),
        'files' => 
        array (
          0 => 'tests/relation_entity_collector.test',
        ),
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'relation_entity_collector.css',
          ),
        ),
        'version' => '7.x-1.0-rc3',
        'project' => 'relation',
        'datestamp' => '1343238481',
        'php' => '5.2.4',
      ),
      'project' => 'relation',
      'version' => '7.x-1.0-rc3',
    ),
    'relation_rules_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/relation/tests/relation_rules_test.module',
      'name' => 'relation_rules_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Relation Tests',
        'description' => 'Support module for the Relation - Rules integration tests.',
        'package' => 'Testing',
        'core' => '7.x',
        'hidden' => true,
        'version' => '7.x-1.0-rc3',
        'project' => 'relation',
        'datestamp' => '1343238481',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'relation',
      'version' => '7.x-1.0-rc3',
    ),
    'relation_ui' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/relation/relation_ui.module',
      'name' => 'relation_ui',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Relation UI',
        'description' => 'Administrative interface to relation. Without this module, you cannot create or edit your relation types.',
        'package' => 'Relation',
        'core' => '7.x',
        'configure' => 'admin/structure/relation',
        'dependencies' => 
        array (
          0 => 'relation',
        ),
        'files' => 
        array (
          0 => 'relation_ui.module',
          1 => 'tests/relation_ui.test',
        ),
        'version' => '7.x-1.0-rc3',
        'project' => 'relation',
        'datestamp' => '1343238481',
        'php' => '5.2.4',
      ),
      'project' => 'relation',
      'version' => '7.x-1.0-rc3',
    ),
    'requirements1_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/requirements1_test.module',
      'name' => 'requirements1_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Requirements 1 Test',
        'description' => 'Tests that a module is not installed when it fails hook_requirements(\'install\').',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'requirements2_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/requirements2_test.module',
      'name' => 'requirements2_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Requirements 2 Test',
        'description' => 'Tests that a module is not installed when the one it depends on fails hook_requirements(\'install).',
        'dependencies' => 
        array (
          0 => 'requirements1_test',
          1 => 'comment',
        ),
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'rules' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/rules/rules.module',
      'name' => 'rules',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '1',
      'schema_version' => '7209',
      'weight' => '20',
      'info' => 
      array (
        'name' => 'Rules',
        'description' => 'React on events and conditionally evaluate actions.',
        'package' => 'Rules',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'rules.features.inc',
          1 => 'tests/rules.test',
          2 => 'includes/faces.inc',
          3 => 'includes/rules.core.inc',
          4 => 'includes/rules.processor.inc',
          5 => 'includes/rules.plugins.inc',
          6 => 'includes/rules.state.inc',
          7 => 'modules/php.eval.inc',
          8 => 'modules/rules_core.eval.inc',
          9 => 'modules/system.eval.inc',
          10 => 'ui/ui.controller.inc',
          11 => 'ui/ui.core.inc',
          12 => 'ui/ui.data.inc',
          13 => 'ui/ui.plugins.inc',
        ),
        'dependencies' => 
        array (
          0 => 'entity_token',
          1 => 'entity',
        ),
        'version' => '7.x-2.2',
        'project' => 'rules',
        'datestamp' => '1343980733',
        'php' => '5.2.4',
      ),
      'project' => 'rules',
      'version' => '7.x-2.2',
    ),
    'rules_admin' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/rules/rules_admin/rules_admin.module',
      'name' => 'rules_admin',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Rules UI',
        'description' => 'Administrative interface for managing rules.',
        'package' => 'Rules',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'rules_admin.module',
          1 => 'rules_admin.inc',
        ),
        'dependencies' => 
        array (
          0 => 'rules',
        ),
        'version' => '7.x-2.2',
        'project' => 'rules',
        'datestamp' => '1343980733',
        'php' => '5.2.4',
      ),
      'project' => 'rules',
      'version' => '7.x-2.2',
    ),
    'rules_i18n' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/rules/rules_i18n/rules_i18n.module',
      'name' => 'rules_i18n',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Rules translation',
        'description' => 'Allows translating rules.',
        'dependencies' => 
        array (
          0 => 'rules',
          1 => 'i18n_string',
        ),
        'package' => 'Multilingual - Internationalization',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'rules_i18n.i18n.inc',
          1 => 'rules_i18n.rules.inc',
          2 => 'rules_i18n.test',
        ),
        'version' => '7.x-2.2',
        'project' => 'rules',
        'datestamp' => '1343980733',
        'php' => '5.2.4',
      ),
      'project' => 'rules',
      'version' => '7.x-2.2',
    ),
    'rules_scheduler' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/rules/rules_scheduler/rules_scheduler.module',
      'name' => 'rules_scheduler',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Rules Scheduler',
        'description' => 'Schedule the execution of Rules components using actions.',
        'dependencies' => 
        array (
          0 => 'rules',
        ),
        'package' => 'Rules',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'rules_scheduler.admin.inc',
          1 => 'rules_scheduler.module',
          2 => 'rules_scheduler.install',
          3 => 'rules_scheduler.rules.inc',
          4 => 'rules_scheduler.test',
          5 => 'includes/rules_scheduler.views_default.inc',
          6 => 'includes/rules_scheduler.views.inc',
          7 => 'includes/rules_scheduler_views_filter.inc',
        ),
        'version' => '7.x-2.2',
        'project' => 'rules',
        'datestamp' => '1343980733',
        'php' => '5.2.4',
      ),
      'project' => 'rules',
      'version' => '7.x-2.2',
    ),
    'rules_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/rules/tests/rules_test.module',
      'name' => 'rules_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Rules Tests',
        'description' => 'Support module for the Rules tests.',
        'package' => 'Testing',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'rules_test.rules.inc',
          1 => 'rules_test.rules_defaults.inc',
        ),
        'hidden' => true,
        'version' => '7.x-2.2',
        'project' => 'rules',
        'datestamp' => '1343980733',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'rules',
      'version' => '7.x-2.2',
    ),
    'sassy' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/sassy/sassy.module',
      'name' => 'sassy',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Sassy  core SASS+SCSS compiler',
        'description' => 'Integrates the PHPSass library to allow automatic SASS/SCSS compilation',
        'core' => '7.x',
        'package' => 'Theming Tools',
        'configure' => 'admin/config/media/prepro',
        'files' => 
        array (
          0 => 'sassy.test',
        ),
        'dependencies' => 
        array (
          0 => 'libraries',
          1 => 'prepro',
        ),
        'version' => '7.x-2.12',
        'project' => 'sassy',
        'datestamp' => '1331311846',
        'php' => '5.2.4',
      ),
      'project' => 'sassy',
      'version' => '7.x-2.12',
    ),
    'sassy_bootstrap' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/sassy/extensions/bootstrap/sassy_bootstrap.module',
      'name' => 'sassy_bootstrap',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Sassy Bootstrap integration',
        'description' => 'Adds the Bootstrap namespace to Sassy @import statements, and makes available the Bootstrap JS plugins as libraries',
        'package' => 'Theming Tools',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'sassy',
        ),
        'version' => '7.x-2.12',
        'project' => 'sassy',
        'datestamp' => '1331311846',
        'php' => '5.2.4',
      ),
      'project' => 'sassy',
      'version' => '7.x-2.12',
    ),
    'sassy_compass' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/sassy/extensions/compass/sassy_compass.module',
      'name' => 'sassy_compass',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Sassy Compass integration',
        'description' => 'Adds the compass namespace to Sassy @import statements',
        'package' => 'Theming Tools',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'sassy',
        ),
        'files' => 
        array (
          0 => 'sassy_compass.test',
        ),
        'version' => '7.x-2.12',
        'project' => 'sassy',
        'datestamp' => '1331311846',
        'php' => '5.2.4',
      ),
      'project' => 'sassy',
      'version' => '7.x-2.12',
    ),
    'sassy_foundation' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/sassy/extensions/foundation/sassy_foundation.module',
      'name' => 'sassy_foundation',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Sassy Foundation integration',
        'description' => 'Adds the Foundation namespace to Sassy @import statements, and makes available the Foundation JS as a library',
        'package' => 'Theming Tools',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'sassy',
        ),
        'version' => '7.x-2.12',
        'project' => 'sassy',
        'datestamp' => '1331311846',
        'php' => '5.2.4',
      ),
      'project' => 'sassy',
      'version' => '7.x-2.12',
    ),
    'score_fields' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/features/score_fields/score_fields.module',
      'name' => 'score_fields',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Score fields',
        'core' => '7.x',
        'package' => 'Features',
        'dependencies' => 
        array (
          0 => 'features',
          1 => 'field_sql_storage',
          2 => 'number',
        ),
        'features' => 
        array (
          'features_api' => 
          array (
            0 => 'api:1',
          ),
          'field' => 
          array (
            0 => 'comment-comment_node_item-field_score',
            1 => 'node-group-field_score',
            2 => 'node-item-field_score',
            3 => 'user-user-field_score',
          ),
        ),
        'description' => '',
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'search' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/search/search.module',
      'name' => 'search',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7000',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Search',
        'description' => 'Enables site-wide keyword searching.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'search.extender.inc',
          1 => 'search.test',
        ),
        'configure' => 'admin/config/search/settings',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'search.css',
          ),
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'search_content' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/features/search_content/search_content.module',
      'name' => 'search_content',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Search Content',
        'description' => 'A view with exposed filters that works better than Drupal\'s default content search.',
        'core' => '7.x',
        'package' => 'Features',
        'dependencies' => 
        array (
          0 => 'ctools',
          1 => 'views',
        ),
        'features' => 
        array (
          'ctools' => 
          array (
            0 => 'views:views_default:3.0',
          ),
          'features_api' => 
          array (
            0 => 'api:1',
          ),
          'views_view' => 
          array (
            0 => 'search_content',
          ),
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'search_embedded_form' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/search/tests/search_embedded_form.module',
      'name' => 'search_embedded_form',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Search embedded form',
        'description' => 'Support module for search module testing of embedded forms.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'search_extra_type' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/search/tests/search_extra_type.module',
      'name' => 'search_extra_type',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Test search type',
        'description' => 'Support module for search module testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'select_province' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/select_province/select_province.module',
      'name' => 'select_province',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Select Province',
        'description' => 'Converts the autocomplete state/province textfield provided by the location module into a select box that has its options populated using AJAX when the country is selected.',
        'core' => '7.x',
        'package' => 'Location',
        'dependencies' => 
        array (
          0 => 'location',
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'session_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/session_test.module',
      'name' => 'session_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Session test',
        'description' => 'Support module for session data testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'shortcut' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/shortcut/shortcut.module',
      'name' => 'shortcut',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Shortcut',
        'description' => 'Allows users to manage customizable lists of shortcut links.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'shortcut.test',
        ),
        'configure' => 'admin/config/user-interface/shortcut',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'simpletest' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/simpletest.module',
      'name' => 'simpletest',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Testing',
        'description' => 'Provides a framework for unit and functional testing.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'simpletest.test',
          1 => 'drupal_web_test_case.php',
          2 => 'tests/actions.test',
          3 => 'tests/ajax.test',
          4 => 'tests/batch.test',
          5 => 'tests/bootstrap.test',
          6 => 'tests/cache.test',
          7 => 'tests/common.test',
          8 => 'tests/database_test.test',
          9 => 'tests/entity_crud_hook_test.test',
          10 => 'tests/entity_query.test',
          11 => 'tests/error.test',
          12 => 'tests/file.test',
          13 => 'tests/filetransfer.test',
          14 => 'tests/form.test',
          15 => 'tests/graph.test',
          16 => 'tests/image.test',
          17 => 'tests/lock.test',
          18 => 'tests/mail.test',
          19 => 'tests/menu.test',
          20 => 'tests/module.test',
          21 => 'tests/pager.test',
          22 => 'tests/password.test',
          23 => 'tests/path.test',
          24 => 'tests/registry.test',
          25 => 'tests/schema.test',
          26 => 'tests/session.test',
          27 => 'tests/tablesort.test',
          28 => 'tests/theme.test',
          29 => 'tests/unicode.test',
          30 => 'tests/update.test',
          31 => 'tests/xmlrpc.test',
          32 => 'tests/upgrade/upgrade.test',
          33 => 'tests/upgrade/upgrade.comment.test',
          34 => 'tests/upgrade/update.field.test',
          35 => 'tests/upgrade/upgrade.filter.test',
          36 => 'tests/upgrade/upgrade.forum.test',
          37 => 'tests/upgrade/upgrade.locale.test',
          38 => 'tests/upgrade/upgrade.menu.test',
          39 => 'tests/upgrade/upgrade.node.test',
          40 => 'tests/upgrade/upgrade.taxonomy.test',
          41 => 'tests/upgrade/upgrade.trigger.test',
          42 => 'tests/upgrade/upgrade.translatable.test',
          43 => 'tests/upgrade/update.trigger.test',
          44 => 'tests/upgrade/upgrade.upload.test',
          45 => 'tests/upgrade/update.user.test',
          46 => 'tests/upgrade/upgrade.user.test',
        ),
        'configure' => 'admin/config/development/testing/settings',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'social_links_and_groups_update' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/features/social_links_and_groups_update/social_links_and_groups_update.module',
      'name' => 'social_links_and_groups_update',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Social links and groups update',
        'core' => '7.x',
        'package' => 'Features',
        'dependencies' => 
        array (
          0 => 'features',
          1 => 'field_sql_storage',
          2 => 'filter',
          3 => 'link',
        ),
        'features' => 
        array (
          'features_api' => 
          array (
            0 => 'api:1',
          ),
          'field' => 
          array (
            0 => 'node-channel-field_academia_link',
            1 => 'node-channel-field_meetup_link',
          ),
          'filter' => 
          array (
            0 => 'simple',
          ),
        ),
        'description' => '',
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'standard' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/profiles/standard/standard.profile',
      'name' => 'standard',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '1000',
      'info' => 
      array (
        'name' => 'Standard',
        'description' => 'Install with commonly used features pre-configured.',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'block',
          1 => 'color',
          2 => 'comment',
          3 => 'contextual',
          4 => 'dashboard',
          5 => 'help',
          6 => 'image',
          7 => 'list',
          8 => 'menu',
          9 => 'number',
          10 => 'options',
          11 => 'path',
          12 => 'taxonomy',
          13 => 'dblog',
          14 => 'search',
          15 => 'shortcut',
          16 => 'toolbar',
          17 => 'overlay',
          18 => 'field_ui',
          19 => 'file',
          20 => 'rdf',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'statistics' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/statistics/statistics.module',
      'name' => 'statistics',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Statistics',
        'description' => 'Logs access statistics for your site.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'statistics.test',
        ),
        'configure' => 'admin/config/system/statistics',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'stylizer' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/stylizer/stylizer.module',
      'name' => 'stylizer',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Stylizer',
        'description' => 'Create custom styles for applications such as Panels.',
        'core' => '7.x',
        'package' => 'Chaos tool suite',
        'dependencies' => 
        array (
          0 => 'ctools',
          1 => 'color',
        ),
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'subpathauto' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/subpathauto/subpathauto.module',
      'name' => 'subpathauto',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Sub-pathauto',
        'description' => 'Provides support for extending sub-paths of URL aliases.',
        'core' => '7.x',
        'configure' => 'admin/config/search/path/subpaths',
        'files' => 
        array (
          0 => 'subpathauto.test',
        ),
        'version' => '7.x-1.2',
        'project' => 'subpathauto',
        'datestamp' => '1327514759',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'subpathauto',
      'version' => '7.x-1.2',
    ),
    'subscriptions_and_notifications' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/features/subscriptions_and_notifications/subscriptions_and_notifications.module',
      'name' => 'subscriptions_and_notifications',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Subscriptions and notifications',
        'core' => '7.x',
        'package' => 'Features',
        'dependencies' => 
        array (
          0 => 'ctools',
          1 => 'features',
          2 => 'field_sql_storage',
          3 => 'list',
          4 => 'menu',
          5 => 'node',
          6 => 'options',
          7 => 'relation',
          8 => 'text',
          9 => 'views',
        ),
        'features' => 
        array (
          'ctools' => 
          array (
            0 => 'relation:relation_type_default:1',
            1 => 'views:views_default:3.0',
          ),
          'features_api' => 
          array (
            0 => 'api:1',
          ),
          'field' => 
          array (
            0 => 'node-notification-field_notification_summary',
            1 => 'relation-has_subscriber-field_email_notification',
          ),
          'menu_custom' => 
          array (
            0 => 'user-menu',
          ),
          'menu_links' => 
          array (
            0 => 'user-menu:activity',
          ),
          'node' => 
          array (
            0 => 'notification',
          ),
          'relation_type' => 
          array (
            0 => 'has_subscriber',
          ),
          'views_view' => 
          array (
            0 => 'notifications',
          ),
        ),
        'description' => '',
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'syslog' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/syslog/syslog.module',
      'name' => 'syslog',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '1',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Syslog',
        'description' => 'Logs and records system events to syslog.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'syslog.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'system' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/system/system.module',
      'name' => 'system',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '1',
      'schema_version' => '7074',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'System',
        'description' => 'Handles general site configuration for administrators.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'system.archiver.inc',
          1 => 'system.mail.inc',
          2 => 'system.queue.inc',
          3 => 'system.tar.inc',
          4 => 'system.updater.inc',
          5 => 'system.test',
        ),
        'required' => true,
        'configure' => 'admin/config/system',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'system_dependencies_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/system_dependencies_test.module',
      'name' => 'system_dependencies_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'System dependency test',
        'description' => 'Support module for testing system dependencies.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'dependencies' => 
        array (
          0 => '_missing_dependency',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'system_incompatible_core_version_dependencies_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/system_incompatible_core_version_dependencies_test.module',
      'name' => 'system_incompatible_core_version_dependencies_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'System incompatible core version dependencies test',
        'description' => 'Support module for testing system dependencies.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'dependencies' => 
        array (
          0 => 'system_incompatible_core_version_test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'system_incompatible_core_version_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/system_incompatible_core_version_test.module',
      'name' => 'system_incompatible_core_version_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'System incompatible core version test',
        'description' => 'Support module for testing system dependencies.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '5.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'system_incompatible_module_version_dependencies_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/system_incompatible_module_version_dependencies_test.module',
      'name' => 'system_incompatible_module_version_dependencies_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'System incompatible module version dependencies test',
        'description' => 'Support module for testing system dependencies.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'dependencies' => 
        array (
          0 => 'system_incompatible_module_version_test (>2.0)',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'system_incompatible_module_version_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/system_incompatible_module_version_test.module',
      'name' => 'system_incompatible_module_version_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'System incompatible module version test',
        'description' => 'Support module for testing system dependencies.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'system_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/system_test.module',
      'name' => 'system_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'System test',
        'description' => 'Support module for system testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'system_test.module',
        ),
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'taxonomy' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/taxonomy/taxonomy.module',
      'name' => 'taxonomy',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7010',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Taxonomy',
        'description' => 'Enables the categorization of content.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'options',
        ),
        'files' => 
        array (
          0 => 'taxonomy.module',
          1 => 'taxonomy.test',
        ),
        'configure' => 'admin/structure/taxonomy',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'taxonomy_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/taxonomy_test.module',
      'name' => 'taxonomy_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Taxonomy test module',
        'description' => '"Tests functions and hooks not used in core".',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'dependencies' => 
        array (
          0 => 'taxonomy',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'text' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/field/modules/text/text.module',
      'name' => 'text',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7000',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Text',
        'description' => 'Defines simple text field types.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
        ),
        'files' => 
        array (
          0 => 'text.test',
        ),
        'required' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'themekey' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/themekey/themekey.module',
      'name' => 'themekey',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7103',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'ThemeKey',
        'description' => 'Map themes to Drupal paths or object properties.',
        'core' => '7.x',
        'package' => 'ThemeKey',
        'configure' => 'admin/config/user-interface/themekey/settings',
        'files' => 
        array (
          0 => 'themekey.install',
          1 => 'themekey-debug-messages.tpl.php',
          2 => 'themekey_validators.inc',
          3 => 'themekey_admin.inc',
          4 => 'themekey_base.inc',
          5 => 'themekey_build.inc',
          6 => 'themekey_cron.inc',
          7 => 'modules/themekey_browser_detection.php',
          8 => 'tests/themekey.test',
          9 => 'tests/ThemekeyDrupalPropertiesTestCase.test',
          10 => 'tests/ThemekeyNodePropertiesTestCase.test',
          11 => 'tests/ThemekeyMultipleNodePropertiesTestCase.test',
          12 => 'tests/ThemekeySystemPropertiesTestCase.test',
        ),
        'version' => '7.x-2.3',
        'project' => 'themekey',
        'datestamp' => '1343146960',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'themekey',
      'version' => '7.x-2.3',
    ),
    'themekey_compat' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/themekey/themekey_compat.module',
      'name' => 'themekey_compat',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'ThemeKey Compatibility',
        'description' => 'Integration of different theme switching modules into ThemeKey and it\'s theme switching rule chain.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'themekey',
        ),
        'package' => 'ThemeKey',
        'configure' => 'admin/config/user-interface/themekey/settings/compat',
        'version' => '7.x-2.3',
        'project' => 'themekey',
        'datestamp' => '1343146960',
        'php' => '5.2.4',
      ),
      'project' => 'themekey',
      'version' => '7.x-2.3',
    ),
    'themekey_debug' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/themekey/themekey_debug.module',
      'name' => 'themekey_debug',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'ThemeKey Debug',
        'description' => 'Debug ThemeKey',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'themekey',
        ),
        'package' => 'ThemeKey',
        'configure' => 'admin/config/user-interface/themekey/settings/debug',
        'version' => '7.x-2.3',
        'project' => 'themekey',
        'datestamp' => '1343146960',
        'php' => '5.2.4',
      ),
      'project' => 'themekey',
      'version' => '7.x-2.3',
    ),
    'themekey_example' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/themekey/themekey_example/themekey_example.module',
      'name' => 'themekey_example',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'ThemeKey Example',
        'description' => 'Implements parts of the ThemeKey API as an example for Developers.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'themekey',
        ),
        'package' => 'Development',
        'files' => 
        array (
          0 => 'themekey_example.module',
          1 => 'themekey_example_validators.inc',
          2 => 'themekey_example_mappers.inc',
        ),
        'version' => '7.x-2.3',
        'project' => 'themekey',
        'datestamp' => '1343146960',
        'php' => '5.2.4',
      ),
      'project' => 'themekey',
      'version' => '7.x-2.3',
    ),
    'themekey_features' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/themekey/themekey_features.module',
      'name' => 'themekey_features',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'ThemeKey Features (Experimental!)',
        'description' => 'Integrates ThemeKey with Features. Warning! Don\'t use in production! Highly Experimental!',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'themekey',
          1 => 'features',
        ),
        'package' => 'ThemeKey',
        'version' => '7.x-2.3',
        'project' => 'themekey',
        'datestamp' => '1343146960',
        'php' => '5.2.4',
      ),
      'project' => 'themekey',
      'version' => '7.x-2.3',
    ),
    'themekey_ui' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/themekey/themekey_ui.module',
      'name' => 'themekey_ui',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '6200',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'ThemeKey UI',
        'description' => 'Integrates ThemeKey with Drupal administration forms.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'themekey',
        ),
        'package' => 'ThemeKey',
        'configure' => 'admin/config/user-interface/themekey/settings/ui',
        'files' => 
        array (
          0 => 'themekey_ui.install',
          1 => 'themekey_ui.module',
          2 => 'themekey_ui_admin.inc',
          3 => 'themekey_ui_help.inc',
          4 => 'themekey_ui_helper.inc',
        ),
        'version' => '7.x-2.3',
        'project' => 'themekey',
        'datestamp' => '1343146960',
        'php' => '5.2.4',
      ),
      'project' => 'themekey',
      'version' => '7.x-2.3',
    ),
    'themekey_user_profile' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/themekey/themekey_user_profile.module',
      'name' => 'themekey_user_profile',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'ThemeKey User Profile',
        'description' => 'Allows users to select their own theme for this site. ThemeKey User Profile replaces the corresponding feature that existed in Drupal 6 Core but has been removed in Drupal 7 Core.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'themekey',
          1 => 'themekey_ui',
        ),
        'package' => 'ThemeKey',
        'configure' => 'admin/config/user-interface/themekey/settings/ui',
        'files' => 
        array (
          0 => 'themekey_user_profile.install',
          1 => 'themekey_user_profile.module',
          2 => 'themekey_user_profile_help.inc',
        ),
        'version' => '7.x-2.3',
        'project' => 'themekey',
        'datestamp' => '1343146960',
        'php' => '5.2.4',
      ),
      'project' => 'themekey',
      'version' => '7.x-2.3',
    ),
    'theme_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/theme_test.module',
      'name' => 'theme_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Theme test',
        'description' => 'Support module for theme system testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'token' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/token/token.module',
      'name' => 'token',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7001',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Token',
        'description' => 'Provides a user interface for the Token API and some missing core tokens.',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'token.module',
          1 => 'token.install',
          2 => 'token.tokens.inc',
          3 => 'token.pages.inc',
          4 => 'token.test',
        ),
        'version' => '7.x-1.2',
        'project' => 'token',
        'datestamp' => '1344634643',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'token',
      'version' => '7.x-1.2',
    ),
    'token_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/token/tests/token_test.module',
      'name' => 'token_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Token Test',
        'description' => 'Testing module for token functionality.',
        'package' => 'Testing',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'token_test.module',
        ),
        'hidden' => true,
        'version' => '7.x-1.2',
        'project' => 'token',
        'datestamp' => '1344634643',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'token',
      'version' => '7.x-1.2',
    ),
    'toolbar' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/toolbar/toolbar.module',
      'name' => 'toolbar',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Toolbar',
        'description' => 'Provides a toolbar that shows the top-level administration menu items and links from other modules.',
        'core' => '7.x',
        'package' => 'Core',
        'version' => '7.15',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'tracker' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/tracker/tracker.module',
      'name' => 'tracker',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => '7000',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Tracker',
        'description' => 'Enables tracking of recent content for users.',
        'dependencies' => 
        array (
          0 => 'comment',
        ),
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'tracker.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'translation' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/translation/translation.module',
      'name' => 'translation',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Content translation',
        'description' => 'Allows content to be translated into different languages.',
        'dependencies' => 
        array (
          0 => 'locale',
        ),
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'translation.test',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'translation_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/translation/tests/translation_test.module',
      'name' => 'translation_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Content Translation Test',
        'description' => 'Support module for the content translation tests.',
        'core' => '7.x',
        'package' => 'Testing',
        'version' => '7.15',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'trigger' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/trigger/trigger.module',
      'name' => 'trigger',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Trigger',
        'description' => 'Enables actions to be fired on certain system events, such as when new content is created.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'trigger.test',
        ),
        'configure' => 'admin/structure/trigger',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'trigger_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/trigger/tests/trigger_test.module',
      'name' => 'trigger_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Trigger Test',
        'description' => 'Support module for Trigger tests.',
        'package' => 'Testing',
        'core' => '7.x',
        'hidden' => true,
        'version' => '7.15',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'twitter' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/twitter/twitter.module',
      'name' => 'twitter',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Twitter',
        'description' => 'Adds integration with the Twitter microblogging service.',
        'php' => '5.1',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'twitter.lib.php',
          1 => 'twitter_views_field_handlers.inc',
          2 => 'tests/core.test',
          3 => 'tests/input_filters.test',
        ),
        'configure' => 'admin/config/services/twitter',
        'version' => '7.x-3.0-beta4',
        'project' => 'twitter',
        'datestamp' => '1322940643',
        'dependencies' => 
        array (
        ),
      ),
      'project' => 'twitter',
      'version' => '7.x-3.0-beta4',
    ),
    'twitter_actions' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/twitter/twitter_actions/twitter_actions.module',
      'name' => 'twitter_actions',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Twitter actions',
        'description' => 'Exposes Drupal actions to send Twitter messages.',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'twitter',
          1 => 'oauth_common',
        ),
        'version' => '7.x-3.0-beta4',
        'project' => 'twitter',
        'datestamp' => '1322940643',
        'php' => '5.2.4',
      ),
      'project' => 'twitter',
      'version' => '7.x-3.0-beta4',
    ),
    'twitter_post' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/twitter/twitter_post/twitter_post.module',
      'name' => 'twitter_post',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Twitter Post',
        'description' => 'Enables posting to twitter',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'twitter',
          1 => 'oauth_common',
        ),
        'version' => '7.x-3.0-beta4',
        'project' => 'twitter',
        'datestamp' => '1322940643',
        'php' => '5.2.4',
      ),
      'project' => 'twitter',
      'version' => '7.x-3.0-beta4',
    ),
    'twitter_signin' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/twitter/twitter_signin/twitter_signin.module',
      'name' => 'twitter_signin',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Twitter Signin',
        'description' => 'Adds support for "Sign in with Twitter"',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'twitter',
          1 => 'oauth_common',
        ),
        'configure' => 'admin/config/services/twitter/signin',
        'version' => '7.x-3.0-beta4',
        'project' => 'twitter',
        'datestamp' => '1322940643',
        'php' => '5.2.4',
      ),
      'project' => 'twitter',
      'version' => '7.x-3.0-beta4',
    ),
    'typekit_api' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/fontyourface/modules/typekit_api/typekit_api.module',
      'name' => 'typekit_api',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Typekit API',
        'description' => '@font-your-face provider with Typekit.com fonts.',
        'dependencies' => 
        array (
          0 => 'fontyourface',
        ),
        'package' => '@font-your-face',
        'core' => '7.x',
        'php' => '5.2.0',
        'version' => '7.x-2.4',
        'project' => 'fontyourface',
        'datestamp' => '1343611963',
      ),
      'project' => 'fontyourface',
      'version' => '7.x-2.4',
    ),
    'update' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/update/update.module',
      'name' => 'update',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7001',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Update manager',
        'description' => 'Checks for available updates, and can securely install or update modules and themes via a web interface.',
        'version' => '7.15',
        'package' => 'Core',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'update.test',
        ),
        'configure' => 'admin/reports/updates/settings',
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'update_script_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/update_script_test.module',
      'name' => 'update_script_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Update script test',
        'description' => 'Support module for update script testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'update_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/update/tests/update_test.module',
      'name' => 'update_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Update test',
        'description' => 'Support module for update module testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'update_test_1' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/update_test_1.module',
      'name' => 'update_test_1',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Update test',
        'description' => 'Support module for update testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'update_test_2' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/update_test_2.module',
      'name' => 'update_test_2',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Update test',
        'description' => 'Support module for update testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'update_test_3' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/update_test_3.module',
      'name' => 'update_test_3',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Update test',
        'description' => 'Support module for update testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'url_alter_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/url_alter_test.module',
      'name' => 'url_alter_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Url_alter tests',
        'description' => 'A support modules for url_alter hook testing.',
        'core' => '7.x',
        'package' => 'Testing',
        'version' => '7.15',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'user' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/user/user.module',
      'name' => 'user',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7018',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'User',
        'description' => 'Manages the user registration and login system.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'user.module',
          1 => 'user.test',
        ),
        'required' => true,
        'configure' => 'admin/config/people',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'user.css',
          ),
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'user_form_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/user/tests/user_form_test.module',
      'name' => 'user_form_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'User module form tests',
        'description' => 'Support module for user form testing.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'user_reference' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/references/user_reference/user_reference.module',
      'name' => 'user_reference',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'User Reference',
        'description' => 'Defines a field type for referencing a user from a node.',
        'package' => 'Fields',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'field',
          1 => 'references',
          2 => 'options',
        ),
        'version' => '7.x-2.0',
        'project' => 'references',
        'datestamp' => '1324596643',
        'php' => '5.2.4',
      ),
      'project' => 'references',
      'version' => '7.x-2.0',
    ),
    'views' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/views/views.module',
      'name' => 'views',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7301',
      'weight' => '10',
      'info' => 
      array (
        'name' => 'Views',
        'description' => 'Create customized lists and queries from your database.',
        'package' => 'Views',
        'core' => '7.x',
        'php' => '5.2',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'css/views.css',
          ),
        ),
        'dependencies' => 
        array (
          0 => 'ctools',
        ),
        'files' => 
        array (
          0 => 'handlers/views_handler_area.inc',
          1 => 'handlers/views_handler_area_result.inc',
          2 => 'handlers/views_handler_area_text.inc',
          3 => 'handlers/views_handler_area_view.inc',
          4 => 'handlers/views_handler_argument.inc',
          5 => 'handlers/views_handler_argument_date.inc',
          6 => 'handlers/views_handler_argument_formula.inc',
          7 => 'handlers/views_handler_argument_many_to_one.inc',
          8 => 'handlers/views_handler_argument_null.inc',
          9 => 'handlers/views_handler_argument_numeric.inc',
          10 => 'handlers/views_handler_argument_string.inc',
          11 => 'handlers/views_handler_argument_group_by_numeric.inc',
          12 => 'handlers/views_handler_field.inc',
          13 => 'handlers/views_handler_field_counter.inc',
          14 => 'handlers/views_handler_field_boolean.inc',
          15 => 'handlers/views_handler_field_contextual_links.inc',
          16 => 'handlers/views_handler_field_custom.inc',
          17 => 'handlers/views_handler_field_date.inc',
          18 => 'handlers/views_handler_field_entity.inc',
          19 => 'handlers/views_handler_field_markup.inc',
          20 => 'handlers/views_handler_field_math.inc',
          21 => 'handlers/views_handler_field_numeric.inc',
          22 => 'handlers/views_handler_field_prerender_list.inc',
          23 => 'handlers/views_handler_field_time_interval.inc',
          24 => 'handlers/views_handler_field_serialized.inc',
          25 => 'handlers/views_handler_field_machine_name.inc',
          26 => 'handlers/views_handler_field_url.inc',
          27 => 'handlers/views_handler_filter.inc',
          28 => 'handlers/views_handler_filter_boolean_operator.inc',
          29 => 'handlers/views_handler_filter_boolean_operator_string.inc',
          30 => 'handlers/views_handler_filter_date.inc',
          31 => 'handlers/views_handler_filter_equality.inc',
          32 => 'handlers/views_handler_filter_group_by_numeric.inc',
          33 => 'handlers/views_handler_filter_in_operator.inc',
          34 => 'handlers/views_handler_filter_many_to_one.inc',
          35 => 'handlers/views_handler_filter_numeric.inc',
          36 => 'handlers/views_handler_filter_string.inc',
          37 => 'handlers/views_handler_relationship.inc',
          38 => 'handlers/views_handler_relationship_groupwise_max.inc',
          39 => 'handlers/views_handler_sort.inc',
          40 => 'handlers/views_handler_sort_date.inc',
          41 => 'handlers/views_handler_sort_formula.inc',
          42 => 'handlers/views_handler_sort_group_by_numeric.inc',
          43 => 'handlers/views_handler_sort_menu_hierarchy.inc',
          44 => 'handlers/views_handler_sort_random.inc',
          45 => 'includes/base.inc',
          46 => 'includes/handlers.inc',
          47 => 'includes/plugins.inc',
          48 => 'includes/view.inc',
          49 => 'modules/aggregator/views_handler_argument_aggregator_fid.inc',
          50 => 'modules/aggregator/views_handler_argument_aggregator_iid.inc',
          51 => 'modules/aggregator/views_handler_argument_aggregator_category_cid.inc',
          52 => 'modules/aggregator/views_handler_field_aggregator_title_link.inc',
          53 => 'modules/aggregator/views_handler_field_aggregator_category.inc',
          54 => 'modules/aggregator/views_handler_field_aggregator_item_description.inc',
          55 => 'modules/aggregator/views_handler_field_aggregator_xss.inc',
          56 => 'modules/aggregator/views_handler_filter_aggregator_category_cid.inc',
          57 => 'modules/aggregator/views_plugin_row_aggregator_rss.inc',
          58 => 'modules/comment/views_handler_argument_comment_user_uid.inc',
          59 => 'modules/comment/views_handler_field_comment.inc',
          60 => 'modules/comment/views_handler_field_comment_depth.inc',
          61 => 'modules/comment/views_handler_field_comment_link.inc',
          62 => 'modules/comment/views_handler_field_comment_link_approve.inc',
          63 => 'modules/comment/views_handler_field_comment_link_delete.inc',
          64 => 'modules/comment/views_handler_field_comment_link_edit.inc',
          65 => 'modules/comment/views_handler_field_comment_link_reply.inc',
          66 => 'modules/comment/views_handler_field_comment_node_link.inc',
          67 => 'modules/comment/views_handler_field_comment_username.inc',
          68 => 'modules/comment/views_handler_field_ncs_last_comment_name.inc',
          69 => 'modules/comment/views_handler_field_ncs_last_updated.inc',
          70 => 'modules/comment/views_handler_field_node_comment.inc',
          71 => 'modules/comment/views_handler_field_node_new_comments.inc',
          72 => 'modules/comment/views_handler_field_last_comment_timestamp.inc',
          73 => 'modules/comment/views_handler_filter_comment_user_uid.inc',
          74 => 'modules/comment/views_handler_filter_ncs_last_updated.inc',
          75 => 'modules/comment/views_handler_filter_node_comment.inc',
          76 => 'modules/comment/views_handler_sort_comment_thread.inc',
          77 => 'modules/comment/views_handler_sort_ncs_last_comment_name.inc',
          78 => 'modules/comment/views_handler_sort_ncs_last_updated.inc',
          79 => 'modules/comment/views_plugin_row_comment_rss.inc',
          80 => 'modules/comment/views_plugin_row_comment_view.inc',
          81 => 'modules/contact/views_handler_field_contact_link.inc',
          82 => 'modules/field/views_handler_field_field.inc',
          83 => 'modules/field/views_handler_relationship_entity_reverse.inc',
          84 => 'modules/field/views_handler_argument_field_list.inc',
          85 => 'modules/field/views_handler_filter_field_list.inc',
          86 => 'modules/filter/views_handler_field_filter_format_name.inc',
          87 => 'modules/locale/views_handler_argument_locale_group.inc',
          88 => 'modules/locale/views_handler_argument_locale_language.inc',
          89 => 'modules/locale/views_handler_field_locale_group.inc',
          90 => 'modules/locale/views_handler_field_locale_language.inc',
          91 => 'modules/locale/views_handler_field_locale_link_edit.inc',
          92 => 'modules/locale/views_handler_filter_locale_group.inc',
          93 => 'modules/locale/views_handler_filter_locale_language.inc',
          94 => 'modules/locale/views_handler_filter_locale_version.inc',
          95 => 'modules/node/views_handler_argument_dates_various.inc',
          96 => 'modules/node/views_handler_argument_node_language.inc',
          97 => 'modules/node/views_handler_argument_node_nid.inc',
          98 => 'modules/node/views_handler_argument_node_type.inc',
          99 => 'modules/node/views_handler_argument_node_vid.inc',
          100 => 'modules/node/views_handler_argument_node_uid_revision.inc',
          101 => 'modules/node/views_handler_field_history_user_timestamp.inc',
          102 => 'modules/node/views_handler_field_node.inc',
          103 => 'modules/node/views_handler_field_node_link.inc',
          104 => 'modules/node/views_handler_field_node_link_delete.inc',
          105 => 'modules/node/views_handler_field_node_link_edit.inc',
          106 => 'modules/node/views_handler_field_node_revision.inc',
          107 => 'modules/node/views_handler_field_node_revision_link_delete.inc',
          108 => 'modules/node/views_handler_field_node_revision_link_revert.inc',
          109 => 'modules/node/views_handler_field_node_path.inc',
          110 => 'modules/node/views_handler_field_node_type.inc',
          111 => 'modules/node/views_handler_filter_history_user_timestamp.inc',
          112 => 'modules/node/views_handler_filter_node_access.inc',
          113 => 'modules/node/views_handler_filter_node_status.inc',
          114 => 'modules/node/views_handler_filter_node_type.inc',
          115 => 'modules/node/views_handler_filter_node_uid_revision.inc',
          116 => 'modules/node/views_plugin_argument_default_node.inc',
          117 => 'modules/node/views_plugin_argument_validate_node.inc',
          118 => 'modules/node/views_plugin_row_node_rss.inc',
          119 => 'modules/node/views_plugin_row_node_view.inc',
          120 => 'modules/profile/views_handler_field_profile_date.inc',
          121 => 'modules/profile/views_handler_field_profile_list.inc',
          122 => 'modules/profile/views_handler_filter_profile_selection.inc',
          123 => 'modules/search/views_handler_argument_search.inc',
          124 => 'modules/search/views_handler_field_search_score.inc',
          125 => 'modules/search/views_handler_filter_search.inc',
          126 => 'modules/search/views_handler_sort_search_score.inc',
          127 => 'modules/search/views_plugin_row_search_view.inc',
          128 => 'modules/statistics/views_handler_field_accesslog_path.inc',
          129 => 'modules/system/views_handler_argument_file_fid.inc',
          130 => 'modules/system/views_handler_field_file.inc',
          131 => 'modules/system/views_handler_field_file_extension.inc',
          132 => 'modules/system/views_handler_field_file_filemime.inc',
          133 => 'modules/system/views_handler_field_file_uri.inc',
          134 => 'modules/system/views_handler_field_file_status.inc',
          135 => 'modules/system/views_handler_filter_file_status.inc',
          136 => 'modules/taxonomy/views_handler_argument_taxonomy.inc',
          137 => 'modules/taxonomy/views_handler_argument_term_node_tid.inc',
          138 => 'modules/taxonomy/views_handler_argument_term_node_tid_depth.inc',
          139 => 'modules/taxonomy/views_handler_argument_term_node_tid_depth_modifier.inc',
          140 => 'modules/taxonomy/views_handler_argument_vocabulary_vid.inc',
          141 => 'modules/taxonomy/views_handler_argument_vocabulary_machine_name.inc',
          142 => 'modules/taxonomy/views_handler_field_taxonomy.inc',
          143 => 'modules/taxonomy/views_handler_field_term_node_tid.inc',
          144 => 'modules/taxonomy/views_handler_field_term_link_edit.inc',
          145 => 'modules/taxonomy/views_handler_filter_term_node_tid.inc',
          146 => 'modules/taxonomy/views_handler_filter_term_node_tid_depth.inc',
          147 => 'modules/taxonomy/views_handler_filter_vocabulary_vid.inc',
          148 => 'modules/taxonomy/views_handler_filter_vocabulary_machine_name.inc',
          149 => 'modules/taxonomy/views_handler_relationship_node_term_data.inc',
          150 => 'modules/taxonomy/views_plugin_argument_validate_taxonomy_term.inc',
          151 => 'modules/taxonomy/views_plugin_argument_default_taxonomy_tid.inc',
          152 => 'modules/system/views_handler_filter_system_type.inc',
          153 => 'modules/translation/views_handler_argument_node_tnid.inc',
          154 => 'modules/translation/views_handler_field_node_language.inc',
          155 => 'modules/translation/views_handler_field_node_link_translate.inc',
          156 => 'modules/translation/views_handler_field_node_translation_link.inc',
          157 => 'modules/translation/views_handler_filter_node_language.inc',
          158 => 'modules/translation/views_handler_filter_node_tnid.inc',
          159 => 'modules/translation/views_handler_filter_node_tnid_child.inc',
          160 => 'modules/translation/views_handler_relationship_translation.inc',
          161 => 'modules/upload/views_handler_field_upload_description.inc',
          162 => 'modules/upload/views_handler_field_upload_fid.inc',
          163 => 'modules/upload/views_handler_filter_upload_fid.inc',
          164 => 'modules/user/views_handler_argument_user_uid.inc',
          165 => 'modules/user/views_handler_argument_users_roles_rid.inc',
          166 => 'modules/user/views_handler_field_user.inc',
          167 => 'modules/user/views_handler_field_user_language.inc',
          168 => 'modules/user/views_handler_field_user_link.inc',
          169 => 'modules/user/views_handler_field_user_link_cancel.inc',
          170 => 'modules/user/views_handler_field_user_link_edit.inc',
          171 => 'modules/user/views_handler_field_user_mail.inc',
          172 => 'modules/user/views_handler_field_user_name.inc',
          173 => 'modules/user/views_handler_field_user_permissions.inc',
          174 => 'modules/user/views_handler_field_user_picture.inc',
          175 => 'modules/user/views_handler_field_user_roles.inc',
          176 => 'modules/user/views_handler_filter_user_current.inc',
          177 => 'modules/user/views_handler_filter_user_name.inc',
          178 => 'modules/user/views_handler_filter_user_permissions.inc',
          179 => 'modules/user/views_handler_filter_user_roles.inc',
          180 => 'modules/user/views_plugin_argument_default_current_user.inc',
          181 => 'modules/user/views_plugin_argument_default_user.inc',
          182 => 'modules/user/views_plugin_argument_validate_user.inc',
          183 => 'modules/user/views_plugin_row_user_view.inc',
          184 => 'plugins/views_plugin_access.inc',
          185 => 'plugins/views_plugin_access_none.inc',
          186 => 'plugins/views_plugin_access_perm.inc',
          187 => 'plugins/views_plugin_access_role.inc',
          188 => 'plugins/views_plugin_argument_default.inc',
          189 => 'plugins/views_plugin_argument_default_php.inc',
          190 => 'plugins/views_plugin_argument_default_fixed.inc',
          191 => 'plugins/views_plugin_argument_default_raw.inc',
          192 => 'plugins/views_plugin_argument_validate.inc',
          193 => 'plugins/views_plugin_argument_validate_numeric.inc',
          194 => 'plugins/views_plugin_argument_validate_php.inc',
          195 => 'plugins/views_plugin_cache.inc',
          196 => 'plugins/views_plugin_cache_none.inc',
          197 => 'plugins/views_plugin_cache_time.inc',
          198 => 'plugins/views_plugin_display.inc',
          199 => 'plugins/views_plugin_display_attachment.inc',
          200 => 'plugins/views_plugin_display_block.inc',
          201 => 'plugins/views_plugin_display_default.inc',
          202 => 'plugins/views_plugin_display_embed.inc',
          203 => 'plugins/views_plugin_display_extender.inc',
          204 => 'plugins/views_plugin_display_feed.inc',
          205 => 'plugins/views_plugin_display_page.inc',
          206 => 'plugins/views_plugin_exposed_form_basic.inc',
          207 => 'plugins/views_plugin_exposed_form.inc',
          208 => 'plugins/views_plugin_exposed_form_input_required.inc',
          209 => 'plugins/views_plugin_localization_core.inc',
          210 => 'plugins/views_plugin_localization.inc',
          211 => 'plugins/views_plugin_localization_none.inc',
          212 => 'plugins/views_plugin_pager.inc',
          213 => 'plugins/views_plugin_pager_full.inc',
          214 => 'plugins/views_plugin_pager_mini.inc',
          215 => 'plugins/views_plugin_pager_none.inc',
          216 => 'plugins/views_plugin_pager_some.inc',
          217 => 'plugins/views_plugin_query.inc',
          218 => 'plugins/views_plugin_query_default.inc',
          219 => 'plugins/views_plugin_row.inc',
          220 => 'plugins/views_plugin_row_fields.inc',
          221 => 'plugins/views_plugin_style.inc',
          222 => 'plugins/views_plugin_style_default.inc',
          223 => 'plugins/views_plugin_style_grid.inc',
          224 => 'plugins/views_plugin_style_list.inc',
          225 => 'plugins/views_plugin_style_jump_menu.inc',
          226 => 'plugins/views_plugin_style_rss.inc',
          227 => 'plugins/views_plugin_style_summary.inc',
          228 => 'plugins/views_plugin_style_summary_jump_menu.inc',
          229 => 'plugins/views_plugin_style_summary_unformatted.inc',
          230 => 'plugins/views_plugin_style_table.inc',
          231 => 'tests/handlers/views_handler_area_text.test',
          232 => 'tests/handlers/views_handler_argument_null.test',
          233 => 'tests/handlers/views_handler_field.test',
          234 => 'tests/handlers/views_handler_field_boolean.test',
          235 => 'tests/handlers/views_handler_field_custom.test',
          236 => 'tests/handlers/views_handler_field_counter.test',
          237 => 'tests/handlers/views_handler_field_date.test',
          238 => 'tests/handlers/views_handler_field_file_size.test',
          239 => 'tests/handlers/views_handler_field_math.test',
          240 => 'tests/handlers/views_handler_field_url.test',
          241 => 'tests/handlers/views_handler_field_xss.test',
          242 => 'tests/handlers/views_handler_filter_date.test',
          243 => 'tests/handlers/views_handler_filter_equality.test',
          244 => 'tests/handlers/views_handler_filter_in_operator.test',
          245 => 'tests/handlers/views_handler_filter_numeric.test',
          246 => 'tests/handlers/views_handler_filter_string.test',
          247 => 'tests/handlers/views_handler_sort_random.test',
          248 => 'tests/handlers/views_handler_sort_date.test',
          249 => 'tests/handlers/views_handler_sort.test',
          250 => 'tests/test_plugins/views_test_plugin_access_test_dynamic.inc',
          251 => 'tests/test_plugins/views_test_plugin_access_test_static.inc',
          252 => 'tests/styles/views_plugin_style_jump_menu.test',
          253 => 'tests/styles/views_plugin_style.test',
          254 => 'tests/views_access.test',
          255 => 'tests/views_analyze.test',
          256 => 'tests/views_basic.test',
          257 => 'tests/views_argument_default.test',
          258 => 'tests/views_argument_validator.test',
          259 => 'tests/views_exposed_form.test',
          260 => 'tests/views_glossary.test',
          261 => 'tests/views_groupby.test',
          262 => 'tests/views_handlers.test',
          263 => 'tests/views_module.test',
          264 => 'tests/views_pager.test',
          265 => 'tests/views_plugin_localization_test.inc',
          266 => 'tests/views_translatable.test',
          267 => 'tests/views_query.test',
          268 => 'tests/views_upgrade.test',
          269 => 'tests/views_test.views_default.inc',
          270 => 'tests/comment/views_handler_argument_comment_user_uid.test',
          271 => 'tests/comment/views_handler_filter_comment_user_uid.test',
          272 => 'tests/user/views_handler_field_user_name.test',
          273 => 'tests/user/views_user_argument_default.test',
          274 => 'tests/user/views_user_argument_validate.test',
          275 => 'tests/user/views_user.test',
          276 => 'tests/views_cache.test',
          277 => 'tests/views_view.test',
          278 => 'tests/views_ui.test',
        ),
        'version' => '7.x-3.3',
        'project' => 'views',
        'datestamp' => '1329946249',
      ),
      'project' => 'views',
      'version' => '7.x-3.3',
    ),
    'views_bulk_operations' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/views_bulk_operations/views_bulk_operations.module',
      'name' => 'views_bulk_operations',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Views Bulk Operations',
        'description' => 'Provides a way of selecting multiple rows and applying operations to them.',
        'dependencies' => 
        array (
          0 => 'entity',
          1 => 'views',
        ),
        'package' => 'Views',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'plugins/operation_types/base.class.php',
          1 => 'views/views_bulk_operations_handler_field_operations.inc',
        ),
        'version' => '7.x-3.0-rc1',
        'project' => 'views_bulk_operations',
        'datestamp' => '1328576162',
        'php' => '5.2.4',
      ),
      'project' => 'views_bulk_operations',
      'version' => '7.x-3.0-rc1',
    ),
    'views_content' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/ctools/views_content/views_content.module',
      'name' => 'views_content',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Views content panes',
        'description' => 'Allows Views content to be used in Panels, Dashboard and other modules which use the CTools Content API.',
        'package' => 'Chaos tool suite',
        'dependencies' => 
        array (
          0 => 'ctools',
          1 => 'views',
        ),
        'core' => '7.x',
        'files' => 
        array (
          0 => 'plugins/views/views_content_plugin_display_ctools_context.inc',
          1 => 'plugins/views/views_content_plugin_display_panel_pane.inc',
          2 => 'plugins/views/views_content_plugin_style_ctools_context.inc',
        ),
        'version' => '7.x-1.1',
        'project' => 'ctools',
        'datestamp' => '1344463011',
        'php' => '5.2.4',
      ),
      'project' => 'ctools',
      'version' => '7.x-1.1',
    ),
    'views_php' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/views_php/views_php.module',
      'name' => 'views_php',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Views PHP',
        'description' => 'Allows the usage of PHP to construct a view.',
        'package' => 'Views',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'views',
        ),
        'files' => 
        array (
          0 => 'plugins/views/views_php_handler_area.inc',
          1 => 'plugins/views/views_php_handler_field.inc',
          2 => 'plugins/views/views_php_handler_filter.inc',
          3 => 'plugins/views/views_php_handler_sort.inc',
          4 => 'plugins/views/views_php_plugin_access.inc',
          5 => 'plugins/views/views_php_plugin_cache.inc',
          6 => 'plugins/views/views_php_plugin_pager.inc',
          7 => 'plugins/views/views_php_plugin_query.inc',
          8 => 'plugins/views/views_php_plugin_wrapper.inc',
        ),
        'version' => '7.x-1.x-dev',
        'project' => 'views_php',
        'datestamp' => '1329828512',
        'php' => '5.2.4',
      ),
      'project' => 'views_php',
      'version' => '7.x-1.x-dev',
    ),
    'views_slideshow' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/views_slideshow/views_slideshow.module',
      'name' => 'views_slideshow',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Views Slideshow',
        'description' => 'Provides a View style that displays rows as a jQuery slideshow.  This is an API and requires Views Slideshow Cycle or another module that supports the API.',
        'dependencies' => 
        array (
          0 => 'views',
        ),
        'package' => 'Views',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'views_slideshow.module',
          1 => 'theme/views_slideshow.theme.inc',
          2 => 'views_slideshow.views.inc',
          3 => 'views_slideshow_plugin_style_slideshow.inc',
        ),
        'version' => '7.x-3.0',
        'project' => 'views_slideshow',
        'datestamp' => '1319589616',
        'php' => '5.2.4',
      ),
      'project' => 'views_slideshow',
      'version' => '7.x-3.0',
    ),
    'views_slideshow_cycle' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/views_slideshow/contrib/views_slideshow_cycle/views_slideshow_cycle.module',
      'name' => 'views_slideshow_cycle',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Views Slideshow: Cycle',
        'description' => 'Adds a Rotating slideshow mode to Views Slideshow.',
        'dependencies' => 
        array (
          0 => 'views_slideshow',
          1 => 'libraries',
        ),
        'package' => 'Views',
        'core' => '7.x',
        'files' => 
        array (
          0 => 'views_slideshow_cycle.module',
          1 => 'views_slideshow_cycle.views_slideshow.inc',
          2 => 'theme/views_slideshow_cycle.theme.inc',
        ),
        'version' => '7.x-3.0',
        'project' => 'views_slideshow',
        'datestamp' => '1319589616',
        'php' => '5.2.4',
      ),
      'project' => 'views_slideshow',
      'version' => '7.x-3.0',
    ),
    'views_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/views/tests/views_test.module',
      'name' => 'views_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Views Test',
        'description' => 'Test module for Views.',
        'package' => 'Views',
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'views',
        ),
        'hidden' => true,
        'version' => '7.x-3.3',
        'project' => 'views',
        'datestamp' => '1329946249',
        'php' => '5.2.4',
      ),
      'project' => 'views',
      'version' => '7.x-3.3',
    ),
    'views_ui' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/views/views_ui.module',
      'name' => 'views_ui',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '0',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Views UI',
        'description' => 'Administrative interface to views. Without this module, you cannot create or edit your views.',
        'package' => 'Views',
        'core' => '7.x',
        'configure' => 'admin/structure/views',
        'dependencies' => 
        array (
          0 => 'views',
        ),
        'files' => 
        array (
          0 => 'views_ui.module',
          1 => 'plugins/views_wizard/views_ui_base_views_wizard.class.php',
        ),
        'version' => '7.x-3.3',
        'project' => 'views',
        'datestamp' => '1329946249',
        'php' => '5.2.4',
      ),
      'project' => 'views',
      'version' => '7.x-3.3',
    ),
    'vr' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/custom/vr/vr.module',
      'name' => 'vr',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Virtual Reality Demo',
        'description' => 'Provides a demo of the virtual reality feature - testing WebGL and &lt;canvas&gt;.',
        'core' => '7.x',
        'package' => 'Astro Multimedia',
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'wysiwyg' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/wysiwyg/wysiwyg.module',
      'name' => 'wysiwyg',
      'type' => 'module',
      'owner' => '',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => '7200',
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Wysiwyg',
        'description' => 'Allows to edit content with client-side editors.',
        'package' => 'User interface',
        'core' => '7.x',
        'configure' => 'admin/config/content/wysiwyg',
        'files' => 
        array (
          0 => 'wysiwyg.module',
          1 => 'tests/wysiwyg.test',
        ),
        'version' => '7.x-2.1',
        'project' => 'wysiwyg',
        'datestamp' => '1308450722',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'wysiwyg',
      'version' => '7.x-2.1',
    ),
    'wysiwyg_imagefield' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/wysiwyg_imagefield/wysiwyg_imagefield.module',
      'name' => 'wysiwyg_imagefield',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'core' => '7.x',
        'dependencies' => 
        array (
          0 => 'image',
          1 => 'insert',
          2 => 'wysiwyg',
        ),
        'description' => 'An ImageField based IMCE alternative',
        'name' => 'Wysiwyg ImageField',
        'project' => 'wysiwyg_imagefield',
        'files' => 
        array (
          0 => 'wysiwyg_imagefield.module',
          1 => 'modules/filefield_sources.inc',
          2 => 'modules/help.inc',
          3 => 'modules/views.inc',
          4 => 'plugins/wysiwyg_imagefield.inc',
        ),
        'version' => '7.x-1.x-dev',
        'datestamp' => '1298620755',
        'php' => '5.2.4',
      ),
      'project' => 'wysiwyg_imagefield',
      'version' => '7.x-1.x-dev',
    ),
    'wysiwyg_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/modules/contrib/wysiwyg/tests/wysiwyg_test.module',
      'name' => 'wysiwyg_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Wysiwyg testing',
        'description' => 'Tests Wysiwyg module functionality. Do not enable.',
        'core' => '7.x',
        'package' => 'Testing',
        'hidden' => true,
        'dependencies' => 
        array (
          0 => 'wysiwyg',
        ),
        'files' => 
        array (
          0 => 'wysiwyg_test.module',
        ),
        'version' => '7.x-2.1',
        'project' => 'wysiwyg',
        'datestamp' => '1308450722',
        'php' => '5.2.4',
      ),
      'project' => 'wysiwyg',
      'version' => '7.x-2.1',
    ),
    'xmlrpc_test' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/modules/simpletest/tests/xmlrpc_test.module',
      'name' => 'xmlrpc_test',
      'type' => 'module',
      'owner' => '',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'XML-RPC Test',
        'description' => 'Support module for XML-RPC tests according to the validator1 specification.',
        'package' => 'Testing',
        'version' => '7.15',
        'core' => '7.x',
        'hidden' => true,
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
  ),
  'themes' => 
  array (
    'alpha' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/themes/omega/alpha/alpha.info',
      'name' => 'alpha',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Alpha',
        'description' => 'Alpha is the core basetheme for <a href="http://drupal.org/project/omega">Omega</a> and all its subthemes. It includes the most basic features of the Omega theme framework. This theme should not be used directly, instead you should create a subtheme based on one of the Omega or Alpha starterkits. Learn more about <a href="http://drupal.org/node/819170">Creating an Omega Subtheme</a> in the <a href="http://drupal.org/node/819164">Omega Handbook</a>.',
        'core' => '7.x',
        'engine' => 'phptemplate',
        'screenshot' => 'screenshot.png',
        'version' => '7.x-3.1',
        'regions' => 
        array (
          'page_top' => 'Page Top',
          'page_bottom' => 'Page Bottom',
          'content' => 'Content',
          'header' => 'Header',
          'footer' => 'Footer',
          'sidebar_first' => 'Sidebar First',
          'sidebar_second' => 'Sidebar Second',
        ),
        'zones' => 
        array (
          'content' => 'Content',
          'header' => 'Header',
          'footer' => 'Footer',
        ),
        'css' => 
        array (
          'alpha-reset.css' => 
          array (
            'name' => 'Reset',
            'description' => 'Created by <a href="http://meyerweb.com/eric/tools/css/reset/">Eric Meyer</a>.',
            'options' => 
            array (
              'weight' => '-20',
            ),
          ),
          'alpha-mobile.css' => 
          array (
            'name' => 'Mobile',
            'description' => 'Default stylesheet for mobile styles.',
            'options' => 
            array (
              'weight' => '-20',
            ),
          ),
          'alpha-alpha.css' => 
          array (
            'name' => 'Alpha',
            'description' => 'Default styles & resets for Alpha/Omega base theme.',
            'options' => 
            array (
              'weight' => '-20',
            ),
          ),
        ),
        'exclude' => 
        array (
          'misc/vertical-tabs.css' => 'This requires a description.',
          'modules/aggregator/aggregator.css' => 'This requires a description.',
          'modules/block/block.css' => 'This requires a description.',
          'modules/dblog/dblog.css' => 'This requires a description.',
          'modules/file/file.css' => 'This requires a description.',
          'modules/filter/filter.css' => 'This requires a description.',
          'modules/help/help.css' => 'This requires a description.',
          'modules/menu/menu.css' => 'This requires a description.',
          'modules/openid/openid.css' => 'This requires a description.',
          'modules/profile/profile.css' => 'This requires a description.',
          'modules/statistics/statistics.css' => 'This requires a description.',
          'modules/syslog/syslog.css' => 'This requires a description.',
          'modules/system/admin.css' => 'This requires a description.',
          'modules/system/maintenance.css' => 'This requires a description.',
          'modules/system/system.css' => 'This requires a description.',
          'modules/system/system.admin.css' => 'This requires a description.',
          'modules/system/system.base.css' => 'This requires a description.',
          'modules/system/system.maintenance.css' => 'This requires a description.',
          'modules/system/system.menus.css' => 'This requires a description.',
          'modules/system/system.messages.css' => 'This requires a description.',
          'modules/system/system.theme.css' => 'This requires a description.',
          'modules/taxonomy/taxonomy.css' => 'This requires a description.',
          'modules/tracker/tracker.css' => 'This requires a description.',
          'modules/update/update.css' => 'This requires a description.',
        ),
        'grids' => 
        array (
          'alpha_default' => 
          array (
            'name' => 'Default (960px)',
            'layouts' => 
            array (
              'fluid' => 'Fluid',
              'narrow' => 'Narrow',
              'normal' => 'Normal',
              'wide' => 'Wide',
            ),
            'columns' => 
            array (
              12 => '12 Columns',
              16 => '16 Columns',
              24 => '24 Columns',
            ),
          ),
          'alpha_fluid' => 
          array (
            'name' => 'Fluid',
            'layouts' => 
            array (
              'normal' => 'Normal',
            ),
            'columns' => 
            array (
              12 => '12 Columns',
              16 => '16 Columns',
              24 => '24 Columns',
            ),
          ),
        ),
        'settings' => 
        array (
          'alpha_grid' => 'alpha_default',
          'alpha_primary_alpha_default' => 'normal',
          'alpha_responsive' => '1',
          'alpha_layouts_alpha_fluid_primary' => 'normal',
          'alpha_layouts_alpha_fluid_normal_responsive' => '0',
          'alpha_layouts_alpha_fluid_normal_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_primary' => 'normal',
          'alpha_layouts_alpha_default_fluid_responsive' => '0',
          'alpha_layouts_alpha_default_fluid_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_fluid_weight' => '0',
          'alpha_layouts_alpha_default_narrow_responsive' => '1',
          'alpha_layouts_alpha_default_narrow_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_narrow_weight' => '1',
          'alpha_layouts_alpha_default_normal_responsive' => '1',
          'alpha_layouts_alpha_default_normal_media' => 'all and (min-width: 980px) and (min-device-width: 980px), all and (max-device-width: 1024px) and (min-width: 1024px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_normal_weight' => '2',
          'alpha_layouts_alpha_default_wide_responsive' => '1',
          'alpha_layouts_alpha_default_wide_media' => 'all and (min-width: 1220px)',
          'alpha_layouts_alpha_default_wide_weight' => '3',
          'alpha_viewport' => '1',
          'alpha_viewport_initial_scale' => '1',
          'alpha_viewport_min_scale' => '1',
          'alpha_viewport_max_scale' => '1',
          'alpha_viewport_user_scaleable' => '',
          'alpha_css' => 
          array (
            'alpha-reset.css' => 'alpha-reset.css',
            'alpha-alpha.css' => 'alpha-alpha.css',
            'alpha-mobile.css' => 'alpha-mobile.css',
          ),
          'alpha_debug_block_toggle' => '1',
          'alpha_debug_block_active' => '1',
          'alpha_debug_grid_toggle' => '1',
          'alpha_debug_grid_active' => '1',
          'alpha_debug_grid_roles' => 
          array (
            1 => '1',
            2 => '2',
            3 => '3',
          ),
          'alpha_toggle_messages' => '1',
          'alpha_toggle_action_links' => '1',
          'alpha_toggle_tabs' => '1',
          'alpha_toggle_breadcrumb' => '1',
          'alpha_toggle_page_title' => '1',
          'alpha_toggle_feed_icons' => '1',
          'alpha_hidden_title' => '',
          'alpha_hidden_site_name' => '',
          'alpha_hidden_site_slogan' => '',
          'alpha_zone_header_wrapper' => '',
          'alpha_zone_header_force' => '',
          'alpha_zone_header_section' => 'header',
          'alpha_zone_header_weight' => '',
          'alpha_zone_header_columns' => '12',
          'alpha_zone_header_primary' => '',
          'alpha_zone_header_css' => '',
          'alpha_zone_header_wrapper_css' => '',
          'alpha_zone_content_wrapper' => '',
          'alpha_zone_content_force' => '',
          'alpha_zone_content_section' => 'content',
          'alpha_zone_content_weight' => '',
          'alpha_zone_content_columns' => '12',
          'alpha_zone_content_primary' => '',
          'alpha_zone_content_css' => '',
          'alpha_zone_content_wrapper_css' => '',
          'alpha_zone_footer_wrapper' => '',
          'alpha_zone_footer_force' => '',
          'alpha_zone_footer_section' => 'footer',
          'alpha_zone_footer_weight' => '',
          'alpha_zone_footer_columns' => '12',
          'alpha_zone_footer_primary' => '',
          'alpha_zone_footer_css' => '',
          'alpha_zone_footer_wrapper_css' => '',
          'alpha_region_dashboard_inactive_force' => '',
          'alpha_region_dashboard_inactive_zone' => '',
          'alpha_region_dashboard_inactive_prefix' => '',
          'alpha_region_dashboard_inactive_columns' => '1',
          'alpha_region_dashboard_inactive_suffix' => '',
          'alpha_region_dashboard_inactive_weight' => '',
          'alpha_region_dashboard_inactive_css' => '',
          'alpha_region_dashboard_sidebar_force' => '',
          'alpha_region_dashboard_sidebar_zone' => '',
          'alpha_region_dashboard_sidebar_prefix' => '',
          'alpha_region_dashboard_sidebar_columns' => '1',
          'alpha_region_dashboard_sidebar_suffix' => '',
          'alpha_region_dashboard_sidebar_weight' => '',
          'alpha_region_dashboard_sidebar_css' => '',
          'alpha_region_dashboard_main_force' => '',
          'alpha_region_dashboard_main_zone' => '',
          'alpha_region_dashboard_main_prefix' => '',
          'alpha_region_dashboard_main_columns' => '1',
          'alpha_region_dashboard_main_suffix' => '',
          'alpha_region_dashboard_main_weight' => '',
          'alpha_region_dashboard_main_css' => '',
          'alpha_region_header_force' => '',
          'alpha_region_header_zone' => 'header',
          'alpha_region_header_prefix' => '',
          'alpha_region_header_columns' => '12',
          'alpha_region_header_suffix' => '',
          'alpha_region_header_weight' => '',
          'alpha_region_header_css' => '',
          'alpha_region_content_force' => '',
          'alpha_region_content_zone' => 'content',
          'alpha_region_content_prefix' => '',
          'alpha_region_content_columns' => '6',
          'alpha_region_content_suffix' => '',
          'alpha_region_content_weight' => '1',
          'alpha_region_content_css' => '',
          'alpha_region_sidebar_first_force' => '',
          'alpha_region_sidebar_first_zone' => 'content',
          'alpha_region_sidebar_first_prefix' => '',
          'alpha_region_sidebar_first_columns' => '3',
          'alpha_region_sidebar_first_suffix' => '',
          'alpha_region_sidebar_first_weight' => '2',
          'alpha_region_sidebar_first_css' => '',
          'alpha_region_sidebar_second_force' => '',
          'alpha_region_sidebar_second_zone' => 'content',
          'alpha_region_sidebar_second_prefix' => '',
          'alpha_region_sidebar_second_columns' => '3',
          'alpha_region_sidebar_second_suffix' => '',
          'alpha_region_sidebar_second_weight' => '3',
          'alpha_region_sidebar_second_css' => '',
          'alpha_region_footer_force' => '',
          'alpha_region_footer_zone' => 'footer',
          'alpha_region_footer_prefix' => '',
          'alpha_region_footer_columns' => '12',
          'alpha_region_footer_suffix' => '',
          'alpha_region_footer_weight' => '',
          'alpha_region_footer_css' => '',
        ),
        'project' => 'omega',
        'datestamp' => '1329681647',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'omega',
      'version' => '7.x-3.1',
    ),
    'astro' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/themes/astro/astro.info',
      'name' => 'astro',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Astro',
        'description' => 'Shiny sub-theme for moonmars.com',
        'core' => '7.x',
        'engine' => 'phptemplate',
        'screenshot' => 'screenshot.png',
        'base theme' => 'shiny',
        'regions' => 
        array (
          'page_top' => 'Page Top',
          'page_bottom' => 'Page Bottom',
          'content' => 'Content',
          'user_first' => 'User Bar First',
          'user_second' => 'User Bar Second',
          'branding' => 'Branding',
          'menu' => 'Menu',
          'sidebar_first' => 'Sidebar First',
          'sidebar_second' => 'Sidebar Second',
          'header_first' => 'Header First',
          'header_second' => 'Header Second',
          'preface_first' => 'Preface First',
          'preface_second' => 'Preface Second',
          'preface_third' => 'Preface Third',
          'postscript_first' => 'Postscript First',
          'postscript_second' => 'Postscript Second',
          'postscript_third' => 'Postscript Third',
          'postscript_fourth' => 'Postscript Fourth',
          'footer_first' => 'Footer First',
          'footer_second' => 'Footer Second',
        ),
        'zones' => 
        array (
          'user' => 'User',
          'branding' => 'Branding',
          'menu' => 'Menu',
          'header' => 'Header',
          'preface' => 'Preface',
          'content' => 'Content',
          'postscript' => 'Postscript',
          'footer' => 'Footer',
        ),
        'css' => 
        array (
          'global.scss' => 
          array (
            'name' => 'Custom global styles',
            'description' => 'This file holds all the globally active custom CSS of your theme (and mobile, apparently).',
            'options' => 
            array (
              'weight' => '10',
            ),
          ),
        ),
        'scripts' => 
        array (
          0 => 'js/astro.js',
        ),
        'settings' => 
        array (
          'alpha_grid' => 'alpha_default',
          'alpha_primary_alpha_default' => 'normal',
          'alpha_responsive' => '1',
          'alpha_layouts_alpha_fluid_primary' => 'normal',
          'alpha_layouts_alpha_fluid_normal_responsive' => '0',
          'alpha_layouts_alpha_fluid_normal_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_primary' => 'normal',
          'alpha_layouts_alpha_default_fluid_responsive' => '0',
          'alpha_layouts_alpha_default_fluid_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_fluid_weight' => '0',
          'alpha_layouts_alpha_default_narrow_responsive' => '1',
          'alpha_layouts_alpha_default_narrow_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_narrow_weight' => '1',
          'alpha_layouts_alpha_default_normal_responsive' => '1',
          'alpha_layouts_alpha_default_normal_media' => 'all and (min-width: 980px) and (min-device-width: 980px), all and (max-device-width: 1024px) and (min-width: 1024px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_normal_weight' => '2',
          'alpha_layouts_alpha_default_wide_responsive' => '1',
          'alpha_layouts_alpha_default_wide_media' => 'all and (min-width: 1220px)',
          'alpha_layouts_alpha_default_wide_weight' => '3',
          'alpha_viewport' => '1',
          'alpha_viewport_initial_scale' => '1',
          'alpha_viewport_min_scale' => '1',
          'alpha_viewport_max_scale' => '1',
          'alpha_viewport_user_scaleable' => '',
          'alpha_libraries' => 
          array (
            'omega_formalize' => 'omega_formalize',
            'omega_equalheights' => '',
            'omega_mediaqueries' => 'omega_mediaqueries',
          ),
          'alpha_css' => 
          array (
            'alpha-reset.css' => 'alpha-reset.css',
            'alpha-mobile.css' => 'alpha-mobile.css',
            'alpha-alpha.css' => 'alpha-alpha.css',
            'omega-text.css' => 'omega-text.css',
            'omega-branding.css' => 'omega-branding.css',
            'omega-menu.css' => 'omega-menu.css',
            'omega-forms.css' => 'omega-forms.css',
            'omega-visuals.css' => 'omega-visuals.css',
            'global.css' => 'global.css',
          ),
          'alpha_debug_block_toggle' => '1',
          'alpha_debug_block_active' => '1',
          'alpha_debug_grid_toggle' => '1',
          'alpha_debug_grid_active' => '1',
          'alpha_debug_grid_roles' => 
          array (
            1 => '1',
            2 => '2',
            3 => '3',
          ),
          'alpha_toggle_messages' => '1',
          'alpha_toggle_action_links' => '1',
          'alpha_toggle_tabs' => '1',
          'alpha_toggle_breadcrumb' => '1',
          'alpha_toggle_page_title' => '1',
          'alpha_toggle_feed_icons' => '1',
          'alpha_hidden_title' => '',
          'alpha_hidden_site_name' => '',
          'alpha_hidden_site_slogan' => '',
          'alpha_zone_user_equal_height_container' => '',
          'alpha_zone_user_wrapper' => '1',
          'alpha_zone_user_force' => '',
          'alpha_zone_user_section' => 'header',
          'alpha_zone_user_weight' => '1',
          'alpha_zone_user_columns' => '12',
          'alpha_zone_user_primary' => '',
          'alpha_zone_user_css' => '',
          'alpha_zone_user_wrapper_css' => '',
          'alpha_zone_branding_equal_height_container' => '',
          'alpha_zone_branding_wrapper' => '1',
          'alpha_zone_branding_force' => '',
          'alpha_zone_branding_section' => 'header',
          'alpha_zone_branding_weight' => '2',
          'alpha_zone_branding_columns' => '12',
          'alpha_zone_branding_primary' => '',
          'alpha_zone_branding_css' => '',
          'alpha_zone_branding_wrapper_css' => '',
          'alpha_zone_menu_equal_height_container' => '',
          'alpha_zone_menu_wrapper' => '1',
          'alpha_zone_menu_force' => '',
          'alpha_zone_menu_section' => 'header',
          'alpha_zone_menu_weight' => '3',
          'alpha_zone_menu_columns' => '12',
          'alpha_zone_menu_primary' => '',
          'alpha_zone_menu_css' => '',
          'alpha_zone_menu_wrapper_css' => '',
          'alpha_zone_header_equal_height_container' => '',
          'alpha_zone_header_wrapper' => '1',
          'alpha_zone_header_force' => '',
          'alpha_zone_header_section' => 'header',
          'alpha_zone_header_weight' => '4',
          'alpha_zone_header_columns' => '12',
          'alpha_zone_header_primary' => '',
          'alpha_zone_header_css' => '',
          'alpha_zone_header_wrapper_css' => '',
          'alpha_zone_preface_equal_height_container' => '',
          'alpha_zone_preface_wrapper' => '1',
          'alpha_zone_preface_force' => '',
          'alpha_zone_preface_section' => 'content',
          'alpha_zone_preface_weight' => '1',
          'alpha_zone_preface_columns' => '12',
          'alpha_zone_preface_primary' => '',
          'alpha_zone_preface_css' => '',
          'alpha_zone_preface_wrapper_css' => '',
          'alpha_zone_content_equal_height_container' => '',
          'alpha_zone_content_wrapper' => '1',
          'alpha_zone_content_force' => '1',
          'alpha_zone_content_section' => 'content',
          'alpha_zone_content_weight' => '2',
          'alpha_zone_content_columns' => '12',
          'alpha_zone_content_primary' => 'content',
          'alpha_zone_content_css' => '',
          'alpha_zone_content_wrapper_css' => '',
          'alpha_zone_postscript_equal_height_container' => '',
          'alpha_zone_postscript_wrapper' => '1',
          'alpha_zone_postscript_force' => '',
          'alpha_zone_postscript_section' => 'content',
          'alpha_zone_postscript_weight' => '3',
          'alpha_zone_postscript_columns' => '12',
          'alpha_zone_postscript_primary' => '',
          'alpha_zone_postscript_css' => '',
          'alpha_zone_postscript_wrapper_css' => '',
          'alpha_zone_footer_equal_height_container' => '',
          'alpha_zone_footer_wrapper' => '1',
          'alpha_zone_footer_force' => '',
          'alpha_zone_footer_section' => 'footer',
          'alpha_zone_footer_weight' => '1',
          'alpha_zone_footer_columns' => '12',
          'alpha_zone_footer_primary' => '',
          'alpha_zone_footer_css' => '',
          'alpha_zone_footer_wrapper_css' => '',
          'alpha_region_dashboard_sidebar_equal_height_container' => '',
          'alpha_region_dashboard_sidebar_equal_height_element' => '',
          'alpha_region_dashboard_sidebar_force' => '',
          'alpha_region_dashboard_sidebar_zone' => '',
          'alpha_region_dashboard_sidebar_prefix' => '',
          'alpha_region_dashboard_sidebar_columns' => '1',
          'alpha_region_dashboard_sidebar_suffix' => '',
          'alpha_region_dashboard_sidebar_weight' => '-50',
          'alpha_region_dashboard_sidebar_css' => '',
          'alpha_region_dashboard_inactive_equal_height_container' => '',
          'alpha_region_dashboard_inactive_equal_height_element' => '',
          'alpha_region_dashboard_inactive_force' => '',
          'alpha_region_dashboard_inactive_zone' => '',
          'alpha_region_dashboard_inactive_prefix' => '',
          'alpha_region_dashboard_inactive_columns' => '1',
          'alpha_region_dashboard_inactive_suffix' => '',
          'alpha_region_dashboard_inactive_weight' => '-50',
          'alpha_region_dashboard_inactive_css' => '',
          'alpha_region_dashboard_main_equal_height_container' => '',
          'alpha_region_dashboard_main_equal_height_element' => '',
          'alpha_region_dashboard_main_force' => '',
          'alpha_region_dashboard_main_zone' => '',
          'alpha_region_dashboard_main_prefix' => '',
          'alpha_region_dashboard_main_columns' => '1',
          'alpha_region_dashboard_main_suffix' => '',
          'alpha_region_dashboard_main_weight' => '-50',
          'alpha_region_dashboard_main_css' => '',
          'alpha_region_user_first_equal_height_container' => '',
          'alpha_region_user_first_equal_height_element' => '',
          'alpha_region_user_first_force' => '',
          'alpha_region_user_first_zone' => 'user',
          'alpha_region_user_first_prefix' => '',
          'alpha_region_user_first_columns' => '8',
          'alpha_region_user_first_suffix' => '',
          'alpha_region_user_first_weight' => '1',
          'alpha_region_user_first_css' => '',
          'alpha_region_user_second_equal_height_container' => '',
          'alpha_region_user_second_equal_height_element' => '',
          'alpha_region_user_second_force' => '',
          'alpha_region_user_second_zone' => 'user',
          'alpha_region_user_second_prefix' => '',
          'alpha_region_user_second_columns' => '4',
          'alpha_region_user_second_suffix' => '',
          'alpha_region_user_second_weight' => '2',
          'alpha_region_user_second_css' => '',
          'alpha_region_branding_equal_height_container' => '',
          'alpha_region_branding_equal_height_element' => '',
          'alpha_region_branding_force' => '1',
          'alpha_region_branding_zone' => 'branding',
          'alpha_region_branding_prefix' => '',
          'alpha_region_branding_columns' => '12',
          'alpha_region_branding_suffix' => '',
          'alpha_region_branding_weight' => '1',
          'alpha_region_branding_css' => '',
          'alpha_region_menu_equal_height_container' => '',
          'alpha_region_menu_equal_height_element' => '',
          'alpha_region_menu_force' => '1',
          'alpha_region_menu_zone' => 'menu',
          'alpha_region_menu_prefix' => '',
          'alpha_region_menu_columns' => '12',
          'alpha_region_menu_suffix' => '',
          'alpha_region_menu_weight' => '1',
          'alpha_region_menu_css' => '',
          'alpha_region_header_first_equal_height_container' => '',
          'alpha_region_header_first_equal_height_element' => '',
          'alpha_region_header_first_force' => '',
          'alpha_region_header_first_zone' => 'header',
          'alpha_region_header_first_prefix' => '',
          'alpha_region_header_first_columns' => '6',
          'alpha_region_header_first_suffix' => '',
          'alpha_region_header_first_weight' => '1',
          'alpha_region_header_first_css' => '',
          'alpha_region_header_second_equal_height_container' => '',
          'alpha_region_header_second_equal_height_element' => '',
          'alpha_region_header_second_force' => '',
          'alpha_region_header_second_zone' => 'header',
          'alpha_region_header_second_prefix' => '',
          'alpha_region_header_second_columns' => '6',
          'alpha_region_header_second_suffix' => '',
          'alpha_region_header_second_weight' => '2',
          'alpha_region_header_second_css' => '',
          'alpha_region_preface_first_equal_height_container' => '',
          'alpha_region_preface_first_equal_height_element' => '',
          'alpha_region_preface_first_force' => '',
          'alpha_region_preface_first_zone' => 'preface',
          'alpha_region_preface_first_prefix' => '',
          'alpha_region_preface_first_columns' => '4',
          'alpha_region_preface_first_suffix' => '',
          'alpha_region_preface_first_weight' => '1',
          'alpha_region_preface_first_css' => '',
          'alpha_region_preface_second_equal_height_container' => '',
          'alpha_region_preface_second_equal_height_element' => '',
          'alpha_region_preface_second_force' => '',
          'alpha_region_preface_second_zone' => 'preface',
          'alpha_region_preface_second_prefix' => '',
          'alpha_region_preface_second_columns' => '4',
          'alpha_region_preface_second_suffix' => '',
          'alpha_region_preface_second_weight' => '2',
          'alpha_region_preface_second_css' => '',
          'alpha_region_preface_third_equal_height_container' => '',
          'alpha_region_preface_third_equal_height_element' => '',
          'alpha_region_preface_third_force' => '',
          'alpha_region_preface_third_zone' => 'preface',
          'alpha_region_preface_third_prefix' => '',
          'alpha_region_preface_third_columns' => '4',
          'alpha_region_preface_third_suffix' => '',
          'alpha_region_preface_third_weight' => '3',
          'alpha_region_preface_third_css' => '',
          'alpha_region_content_equal_height_container' => '',
          'alpha_region_content_equal_height_element' => '',
          'alpha_region_content_force' => '',
          'alpha_region_content_zone' => 'content',
          'alpha_region_content_prefix' => '',
          'alpha_region_content_columns' => '6',
          'alpha_region_content_suffix' => '',
          'alpha_region_content_weight' => '2',
          'alpha_region_content_css' => '',
          'alpha_region_sidebar_first_equal_height_container' => '',
          'alpha_region_sidebar_first_equal_height_element' => '',
          'alpha_region_sidebar_first_force' => '',
          'alpha_region_sidebar_first_zone' => 'content',
          'alpha_region_sidebar_first_prefix' => '',
          'alpha_region_sidebar_first_columns' => '3',
          'alpha_region_sidebar_first_suffix' => '',
          'alpha_region_sidebar_first_weight' => '1',
          'alpha_region_sidebar_first_css' => '',
          'alpha_region_sidebar_second_equal_height_container' => '',
          'alpha_region_sidebar_second_equal_height_element' => '',
          'alpha_region_sidebar_second_force' => '',
          'alpha_region_sidebar_second_zone' => 'content',
          'alpha_region_sidebar_second_prefix' => '',
          'alpha_region_sidebar_second_columns' => '3',
          'alpha_region_sidebar_second_suffix' => '',
          'alpha_region_sidebar_second_weight' => '3',
          'alpha_region_sidebar_second_css' => '',
          'alpha_region_postscript_first_equal_height_container' => '',
          'alpha_region_postscript_first_equal_height_element' => '',
          'alpha_region_postscript_first_force' => '',
          'alpha_region_postscript_first_zone' => 'postscript',
          'alpha_region_postscript_first_prefix' => '',
          'alpha_region_postscript_first_columns' => '3',
          'alpha_region_postscript_first_suffix' => '',
          'alpha_region_postscript_first_weight' => '1',
          'alpha_region_postscript_first_css' => '',
          'alpha_region_postscript_second_equal_height_container' => '',
          'alpha_region_postscript_second_equal_height_element' => '',
          'alpha_region_postscript_second_force' => '',
          'alpha_region_postscript_second_zone' => 'postscript',
          'alpha_region_postscript_second_prefix' => '',
          'alpha_region_postscript_second_columns' => '3',
          'alpha_region_postscript_second_suffix' => '',
          'alpha_region_postscript_second_weight' => '2',
          'alpha_region_postscript_second_css' => '',
          'alpha_region_postscript_third_equal_height_container' => '',
          'alpha_region_postscript_third_equal_height_element' => '',
          'alpha_region_postscript_third_force' => '',
          'alpha_region_postscript_third_zone' => 'postscript',
          'alpha_region_postscript_third_prefix' => '',
          'alpha_region_postscript_third_columns' => '3',
          'alpha_region_postscript_third_suffix' => '',
          'alpha_region_postscript_third_weight' => '3',
          'alpha_region_postscript_third_css' => '',
          'alpha_region_postscript_fourth_equal_height_container' => '',
          'alpha_region_postscript_fourth_equal_height_element' => '',
          'alpha_region_postscript_fourth_force' => '',
          'alpha_region_postscript_fourth_zone' => 'postscript',
          'alpha_region_postscript_fourth_prefix' => '',
          'alpha_region_postscript_fourth_columns' => '3',
          'alpha_region_postscript_fourth_suffix' => '',
          'alpha_region_postscript_fourth_weight' => '4',
          'alpha_region_postscript_fourth_css' => '',
          'alpha_region_footer_first_equal_height_container' => '',
          'alpha_region_footer_first_equal_height_element' => '',
          'alpha_region_footer_first_force' => '',
          'alpha_region_footer_first_zone' => 'footer',
          'alpha_region_footer_first_prefix' => '',
          'alpha_region_footer_first_columns' => '12',
          'alpha_region_footer_first_suffix' => '',
          'alpha_region_footer_first_weight' => '1',
          'alpha_region_footer_first_css' => '',
          'alpha_region_footer_second_equal_height_container' => '',
          'alpha_region_footer_second_equal_height_element' => '',
          'alpha_region_footer_second_force' => '',
          'alpha_region_footer_second_zone' => 'footer',
          'alpha_region_footer_second_prefix' => '',
          'alpha_region_footer_second_columns' => '12',
          'alpha_region_footer_second_suffix' => '',
          'alpha_region_footer_second_weight' => '2',
          'alpha_region_footer_second_css' => '',
        ),
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'bartik' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/themes/bartik/bartik.info',
      'name' => 'bartik',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Bartik',
        'description' => 'A flexible, recolorable theme with many regions.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'css/layout.css',
            1 => 'css/style.css',
            2 => 'css/colors.css',
          ),
          'print' => 
          array (
            0 => 'css/print.css',
          ),
        ),
        'regions' => 
        array (
          'header' => 'Header',
          'help' => 'Help',
          'page_top' => 'Page top',
          'page_bottom' => 'Page bottom',
          'highlighted' => 'Highlighted',
          'featured' => 'Featured',
          'content' => 'Content',
          'sidebar_first' => 'Sidebar first',
          'sidebar_second' => 'Sidebar second',
          'triptych_first' => 'Triptych first',
          'triptych_middle' => 'Triptych middle',
          'triptych_last' => 'Triptych last',
          'footer_firstcolumn' => 'Footer first column',
          'footer_secondcolumn' => 'Footer second column',
          'footer_thirdcolumn' => 'Footer third column',
          'footer_fourthcolumn' => 'Footer fourth column',
          'footer' => 'Footer',
        ),
        'settings' => 
        array (
          'shortcut_module_link' => '0',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'email' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/themes/email/email.info',
      'name' => 'email',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Email',
        'description' => 'Plain theme for emails',
        'core' => '7.x',
        'engine' => 'phptemplate',
        'screenshot' => 'screenshot.png',
        'regions' => 
        array (
          'content' => 'Content',
        ),
        'css' => 
        array (
          'global.scss' => 
          array (
            'name' => 'Custom global styles',
            'description' => 'This file holds all the globally active custom CSS of your theme.',
            'options' => 
            array (
              'weight' => '1',
            ),
          ),
        ),
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'garland' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/themes/garland/garland.info',
      'name' => 'garland',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Garland',
        'description' => 'A multi-column theme which can be configured to modify colors and switch between fixed and fluid width layouts.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'style.css',
          ),
          'print' => 
          array (
            0 => 'print.css',
          ),
        ),
        'settings' => 
        array (
          'garland_width' => 'fluid',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'omega' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/themes/omega/omega/omega.info',
      'name' => 'omega',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Omega',
        'description' => '<a href="http://drupal.org/project/omega">Omega</a> extends the Omega theme framework with some additional features and makes them availabe to its subthemes. This theme should not be used directly, instead you should create a subtheme based on one of the Omega or Alpha starterkits. Learn more about <a href="http://drupal.org/node/819170">Creating an Omega Subtheme</a> in the <a href="http://drupal.org/node/819164">Omega Handbook</a>.',
        'core' => '7.x',
        'engine' => 'phptemplate',
        'screenshot' => 'screenshot.png',
        'version' => '7.x-3.1',
        'base theme' => 'alpha',
        'regions' => 
        array (
          'page_top' => 'Page Top',
          'page_bottom' => 'Page Bottom',
          'content' => 'Content',
          'user_first' => 'User Bar First',
          'user_second' => 'User Bar Second',
          'branding' => 'Branding',
          'menu' => 'Menu',
          'sidebar_first' => 'Sidebar First',
          'sidebar_second' => 'Sidebar Second',
          'header_first' => 'Header First',
          'header_second' => 'Header Second',
          'preface_first' => 'Preface First',
          'preface_second' => 'Preface Second',
          'preface_third' => 'Preface Third',
          'postscript_first' => 'Postscript First',
          'postscript_second' => 'Postscript Second',
          'postscript_third' => 'Postscript Third',
          'postscript_fourth' => 'Postscript Fourth',
          'footer_first' => 'Footer First',
          'footer_second' => 'Footer Second',
        ),
        'zones' => 
        array (
          'user' => 'User',
          'branding' => 'Branding',
          'menu' => 'Menu',
          'header' => 'Header',
          'preface' => 'Preface',
          'content' => 'Content',
          'postscript' => 'Postscript',
          'footer' => 'Footer',
        ),
        'css' => 
        array (
          'omega-text.css' => 
          array (
            'name' => 'Text Styles',
            'description' => 'Default text styles for Omega.',
            'options' => 
            array (
              'weight' => '-10',
            ),
          ),
          'omega-branding.css' => 
          array (
            'name' => 'Branding Styles',
            'description' => 'Provides positioning for the logo, title and slogan.',
            'options' => 
            array (
              'weight' => '-10',
            ),
          ),
          'omega-menu.css' => 
          array (
            'name' => 'Menu Styles',
            'description' => 'Provides positoning and basic CSS for primary and secondary menus.',
            'options' => 
            array (
              'weight' => '-10',
            ),
          ),
          'omega-forms.css' => 
          array (
            'name' => 'Form Styles',
            'description' => 'Provides basic form styles.',
            'options' => 
            array (
              'weight' => '-10',
            ),
          ),
          'omega-visuals.css' => 
          array (
            'name' => 'Omega Styles',
            'description' => 'Custom visual styles for Omega. (pagers, menus, etc.)',
            'options' => 
            array (
              'weight' => '-10',
            ),
          ),
        ),
        'libraries' => 
        array (
          'omega_formalize' => 
          array (
            'name' => 'Formalize',
            'description' => 'Formalize is a framework by <a href="http://formalize.me/" title="Formalize">Nathan Smith</a> for neat looking cross-browser forms with extended functionality.',
            'js' => 
            array (
              0 => 
              array (
                'file' => 'jquery.formalize.js',
                'options' => 
                array (
                  'weight' => '-20',
                ),
              ),
            ),
            'css' => 
            array (
              0 => 
              array (
                'file' => 'formalize.css',
                'options' => 
                array (
                  'weight' => '-20',
                ),
              ),
            ),
          ),
          'omega_mediaqueries' => 
          array (
            'name' => 'Media queries',
            'description' => 'Provides a tiny JavaScript library that can be used in your custom JavaScript.',
            'js' => 
            array (
              0 => 
              array (
                'file' => 'omega-mediaqueries.js',
                'options' => 
                array (
                  'weight' => '-19',
                ),
              ),
            ),
          ),
          'omega_equalheights' => 
          array (
            'name' => 'Equal heights',
            'description' => 'Allows you to force all regions of a zone or all blocks of a region to be of equal size. <span class="marker">This library reveals a corresponding checkbox on every region and zone configuration panel if activated.</span>',
            'js' => 
            array (
              0 => 
              array (
                'file' => 'omega-equalheights.js',
                'options' => 
                array (
                  'weight' => '-18',
                ),
              ),
            ),
          ),
        ),
        'plugins' => 
        array (
          'panels' => 
          array (
            'layouts' => 'panels/layouts',
          ),
        ),
        'settings' => 
        array (
          'alpha_grid' => 'alpha_default',
          'alpha_primary_alpha_default' => 'normal',
          'alpha_responsive' => '1',
          'alpha_layouts_alpha_fluid_primary' => 'normal',
          'alpha_layouts_alpha_fluid_normal_responsive' => '0',
          'alpha_layouts_alpha_fluid_normal_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_primary' => 'normal',
          'alpha_layouts_alpha_default_fluid_responsive' => '0',
          'alpha_layouts_alpha_default_fluid_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_fluid_weight' => '0',
          'alpha_layouts_alpha_default_narrow_responsive' => '1',
          'alpha_layouts_alpha_default_narrow_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_narrow_weight' => '1',
          'alpha_layouts_alpha_default_normal_responsive' => '1',
          'alpha_layouts_alpha_default_normal_media' => 'all and (min-width: 980px) and (min-device-width: 980px), all and (max-device-width: 1024px) and (min-width: 1024px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_normal_weight' => '2',
          'alpha_layouts_alpha_default_wide_responsive' => '1',
          'alpha_layouts_alpha_default_wide_media' => 'all and (min-width: 1220px)',
          'alpha_layouts_alpha_default_wide_weight' => '3',
          'alpha_viewport' => '1',
          'alpha_viewport_initial_scale' => '1',
          'alpha_viewport_min_scale' => '1',
          'alpha_viewport_max_scale' => '1',
          'alpha_viewport_user_scaleable' => '',
          'alpha_libraries' => 
          array (
            'omega_formalize' => 'omega_formalize',
            'omega_equalheights' => '',
            'omega_mediaqueries' => 'omega_mediaqueries',
          ),
          'alpha_css' => 
          array (
            'alpha-reset.css' => 'alpha-reset.css',
            'alpha-mobile.css' => 'alpha-mobile.css',
            'alpha-alpha.css' => 'alpha-alpha.css',
            'omega-text.css' => 'omega-text.css',
            'omega-branding.css' => 'omega-branding.css',
            'omega-menu.css' => 'omega-menu.css',
            'omega-forms.css' => 'omega-forms.css',
            'omega-visuals.css' => 'omega-visuals.css',
          ),
          'alpha_debug_block_toggle' => '1',
          'alpha_debug_block_active' => '1',
          'alpha_debug_grid_toggle' => '1',
          'alpha_debug_grid_active' => '1',
          'alpha_debug_grid_roles' => 
          array (
            1 => '1',
            2 => '2',
            3 => '3',
          ),
          'alpha_toggle_messages' => '1',
          'alpha_toggle_action_links' => '1',
          'alpha_toggle_tabs' => '1',
          'alpha_toggle_breadcrumb' => '1',
          'alpha_toggle_page_title' => '1',
          'alpha_toggle_feed_icons' => '1',
          'alpha_hidden_title' => '',
          'alpha_hidden_site_name' => '',
          'alpha_hidden_site_slogan' => '',
          'alpha_zone_user_equal_height_container' => '',
          'alpha_zone_user_wrapper' => '1',
          'alpha_zone_user_force' => '',
          'alpha_zone_user_section' => 'header',
          'alpha_zone_user_weight' => '1',
          'alpha_zone_user_columns' => '12',
          'alpha_zone_user_primary' => '',
          'alpha_zone_user_css' => '',
          'alpha_zone_user_wrapper_css' => '',
          'alpha_zone_branding_equal_height_container' => '',
          'alpha_zone_branding_wrapper' => '1',
          'alpha_zone_branding_force' => '',
          'alpha_zone_branding_section' => 'header',
          'alpha_zone_branding_weight' => '2',
          'alpha_zone_branding_columns' => '12',
          'alpha_zone_branding_primary' => '',
          'alpha_zone_branding_css' => '',
          'alpha_zone_branding_wrapper_css' => '',
          'alpha_zone_menu_equal_height_container' => '',
          'alpha_zone_menu_wrapper' => '1',
          'alpha_zone_menu_force' => '',
          'alpha_zone_menu_section' => 'header',
          'alpha_zone_menu_weight' => '3',
          'alpha_zone_menu_columns' => '12',
          'alpha_zone_menu_primary' => '',
          'alpha_zone_menu_css' => '',
          'alpha_zone_menu_wrapper_css' => '',
          'alpha_zone_header_equal_height_container' => '',
          'alpha_zone_header_wrapper' => '1',
          'alpha_zone_header_force' => '',
          'alpha_zone_header_section' => 'header',
          'alpha_zone_header_weight' => '4',
          'alpha_zone_header_columns' => '12',
          'alpha_zone_header_primary' => '',
          'alpha_zone_header_css' => '',
          'alpha_zone_header_wrapper_css' => '',
          'alpha_zone_preface_equal_height_container' => '',
          'alpha_zone_preface_wrapper' => '1',
          'alpha_zone_preface_force' => '',
          'alpha_zone_preface_section' => 'content',
          'alpha_zone_preface_weight' => '1',
          'alpha_zone_preface_columns' => '12',
          'alpha_zone_preface_primary' => '',
          'alpha_zone_preface_css' => '',
          'alpha_zone_preface_wrapper_css' => '',
          'alpha_zone_content_equal_height_container' => '',
          'alpha_zone_content_wrapper' => '1',
          'alpha_zone_content_force' => '1',
          'alpha_zone_content_section' => 'content',
          'alpha_zone_content_weight' => '2',
          'alpha_zone_content_columns' => '12',
          'alpha_zone_content_primary' => 'content',
          'alpha_zone_content_css' => '',
          'alpha_zone_content_wrapper_css' => '',
          'alpha_zone_postscript_equal_height_container' => '',
          'alpha_zone_postscript_wrapper' => '1',
          'alpha_zone_postscript_force' => '',
          'alpha_zone_postscript_section' => 'content',
          'alpha_zone_postscript_weight' => '3',
          'alpha_zone_postscript_columns' => '12',
          'alpha_zone_postscript_primary' => '',
          'alpha_zone_postscript_css' => '',
          'alpha_zone_postscript_wrapper_css' => '',
          'alpha_zone_footer_equal_height_container' => '',
          'alpha_zone_footer_wrapper' => '1',
          'alpha_zone_footer_force' => '',
          'alpha_zone_footer_section' => 'footer',
          'alpha_zone_footer_weight' => '1',
          'alpha_zone_footer_columns' => '12',
          'alpha_zone_footer_primary' => '',
          'alpha_zone_footer_css' => '',
          'alpha_zone_footer_wrapper_css' => '',
          'alpha_region_dashboard_sidebar_equal_height_container' => '',
          'alpha_region_dashboard_sidebar_equal_height_element' => '',
          'alpha_region_dashboard_sidebar_force' => '',
          'alpha_region_dashboard_sidebar_zone' => '',
          'alpha_region_dashboard_sidebar_prefix' => '',
          'alpha_region_dashboard_sidebar_columns' => '1',
          'alpha_region_dashboard_sidebar_suffix' => '',
          'alpha_region_dashboard_sidebar_weight' => '-50',
          'alpha_region_dashboard_sidebar_css' => '',
          'alpha_region_dashboard_inactive_equal_height_container' => '',
          'alpha_region_dashboard_inactive_equal_height_element' => '',
          'alpha_region_dashboard_inactive_force' => '',
          'alpha_region_dashboard_inactive_zone' => '',
          'alpha_region_dashboard_inactive_prefix' => '',
          'alpha_region_dashboard_inactive_columns' => '1',
          'alpha_region_dashboard_inactive_suffix' => '',
          'alpha_region_dashboard_inactive_weight' => '-50',
          'alpha_region_dashboard_inactive_css' => '',
          'alpha_region_dashboard_main_equal_height_container' => '',
          'alpha_region_dashboard_main_equal_height_element' => '',
          'alpha_region_dashboard_main_force' => '',
          'alpha_region_dashboard_main_zone' => '',
          'alpha_region_dashboard_main_prefix' => '',
          'alpha_region_dashboard_main_columns' => '1',
          'alpha_region_dashboard_main_suffix' => '',
          'alpha_region_dashboard_main_weight' => '-50',
          'alpha_region_dashboard_main_css' => '',
          'alpha_region_user_first_equal_height_container' => '',
          'alpha_region_user_first_equal_height_element' => '',
          'alpha_region_user_first_force' => '',
          'alpha_region_user_first_zone' => 'user',
          'alpha_region_user_first_prefix' => '',
          'alpha_region_user_first_columns' => '8',
          'alpha_region_user_first_suffix' => '',
          'alpha_region_user_first_weight' => '1',
          'alpha_region_user_first_css' => '',
          'alpha_region_user_second_equal_height_container' => '',
          'alpha_region_user_second_equal_height_element' => '',
          'alpha_region_user_second_force' => '',
          'alpha_region_user_second_zone' => 'user',
          'alpha_region_user_second_prefix' => '',
          'alpha_region_user_second_columns' => '4',
          'alpha_region_user_second_suffix' => '',
          'alpha_region_user_second_weight' => '2',
          'alpha_region_user_second_css' => '',
          'alpha_region_branding_equal_height_container' => '',
          'alpha_region_branding_equal_height_element' => '',
          'alpha_region_branding_force' => '1',
          'alpha_region_branding_zone' => 'branding',
          'alpha_region_branding_prefix' => '',
          'alpha_region_branding_columns' => '12',
          'alpha_region_branding_suffix' => '',
          'alpha_region_branding_weight' => '1',
          'alpha_region_branding_css' => '',
          'alpha_region_menu_equal_height_container' => '',
          'alpha_region_menu_equal_height_element' => '',
          'alpha_region_menu_force' => '1',
          'alpha_region_menu_zone' => 'menu',
          'alpha_region_menu_prefix' => '',
          'alpha_region_menu_columns' => '12',
          'alpha_region_menu_suffix' => '',
          'alpha_region_menu_weight' => '1',
          'alpha_region_menu_css' => '',
          'alpha_region_header_first_equal_height_container' => '',
          'alpha_region_header_first_equal_height_element' => '',
          'alpha_region_header_first_force' => '',
          'alpha_region_header_first_zone' => 'header',
          'alpha_region_header_first_prefix' => '',
          'alpha_region_header_first_columns' => '6',
          'alpha_region_header_first_suffix' => '',
          'alpha_region_header_first_weight' => '1',
          'alpha_region_header_first_css' => '',
          'alpha_region_header_second_equal_height_container' => '',
          'alpha_region_header_second_equal_height_element' => '',
          'alpha_region_header_second_force' => '',
          'alpha_region_header_second_zone' => 'header',
          'alpha_region_header_second_prefix' => '',
          'alpha_region_header_second_columns' => '6',
          'alpha_region_header_second_suffix' => '',
          'alpha_region_header_second_weight' => '2',
          'alpha_region_header_second_css' => '',
          'alpha_region_preface_first_equal_height_container' => '',
          'alpha_region_preface_first_equal_height_element' => '',
          'alpha_region_preface_first_force' => '',
          'alpha_region_preface_first_zone' => 'preface',
          'alpha_region_preface_first_prefix' => '',
          'alpha_region_preface_first_columns' => '4',
          'alpha_region_preface_first_suffix' => '',
          'alpha_region_preface_first_weight' => '1',
          'alpha_region_preface_first_css' => '',
          'alpha_region_preface_second_equal_height_container' => '',
          'alpha_region_preface_second_equal_height_element' => '',
          'alpha_region_preface_second_force' => '',
          'alpha_region_preface_second_zone' => 'preface',
          'alpha_region_preface_second_prefix' => '',
          'alpha_region_preface_second_columns' => '4',
          'alpha_region_preface_second_suffix' => '',
          'alpha_region_preface_second_weight' => '2',
          'alpha_region_preface_second_css' => '',
          'alpha_region_preface_third_equal_height_container' => '',
          'alpha_region_preface_third_equal_height_element' => '',
          'alpha_region_preface_third_force' => '',
          'alpha_region_preface_third_zone' => 'preface',
          'alpha_region_preface_third_prefix' => '',
          'alpha_region_preface_third_columns' => '4',
          'alpha_region_preface_third_suffix' => '',
          'alpha_region_preface_third_weight' => '3',
          'alpha_region_preface_third_css' => '',
          'alpha_region_content_equal_height_container' => '',
          'alpha_region_content_equal_height_element' => '',
          'alpha_region_content_force' => '',
          'alpha_region_content_zone' => 'content',
          'alpha_region_content_prefix' => '',
          'alpha_region_content_columns' => '6',
          'alpha_region_content_suffix' => '',
          'alpha_region_content_weight' => '2',
          'alpha_region_content_css' => '',
          'alpha_region_sidebar_first_equal_height_container' => '',
          'alpha_region_sidebar_first_equal_height_element' => '',
          'alpha_region_sidebar_first_force' => '',
          'alpha_region_sidebar_first_zone' => 'content',
          'alpha_region_sidebar_first_prefix' => '',
          'alpha_region_sidebar_first_columns' => '3',
          'alpha_region_sidebar_first_suffix' => '',
          'alpha_region_sidebar_first_weight' => '1',
          'alpha_region_sidebar_first_css' => '',
          'alpha_region_sidebar_second_equal_height_container' => '',
          'alpha_region_sidebar_second_equal_height_element' => '',
          'alpha_region_sidebar_second_force' => '',
          'alpha_region_sidebar_second_zone' => 'content',
          'alpha_region_sidebar_second_prefix' => '',
          'alpha_region_sidebar_second_columns' => '3',
          'alpha_region_sidebar_second_suffix' => '',
          'alpha_region_sidebar_second_weight' => '3',
          'alpha_region_sidebar_second_css' => '',
          'alpha_region_postscript_first_equal_height_container' => '',
          'alpha_region_postscript_first_equal_height_element' => '',
          'alpha_region_postscript_first_force' => '',
          'alpha_region_postscript_first_zone' => 'postscript',
          'alpha_region_postscript_first_prefix' => '',
          'alpha_region_postscript_first_columns' => '3',
          'alpha_region_postscript_first_suffix' => '',
          'alpha_region_postscript_first_weight' => '1',
          'alpha_region_postscript_first_css' => '',
          'alpha_region_postscript_second_equal_height_container' => '',
          'alpha_region_postscript_second_equal_height_element' => '',
          'alpha_region_postscript_second_force' => '',
          'alpha_region_postscript_second_zone' => 'postscript',
          'alpha_region_postscript_second_prefix' => '',
          'alpha_region_postscript_second_columns' => '3',
          'alpha_region_postscript_second_suffix' => '',
          'alpha_region_postscript_second_weight' => '2',
          'alpha_region_postscript_second_css' => '',
          'alpha_region_postscript_third_equal_height_container' => '',
          'alpha_region_postscript_third_equal_height_element' => '',
          'alpha_region_postscript_third_force' => '',
          'alpha_region_postscript_third_zone' => 'postscript',
          'alpha_region_postscript_third_prefix' => '',
          'alpha_region_postscript_third_columns' => '3',
          'alpha_region_postscript_third_suffix' => '',
          'alpha_region_postscript_third_weight' => '3',
          'alpha_region_postscript_third_css' => '',
          'alpha_region_postscript_fourth_equal_height_container' => '',
          'alpha_region_postscript_fourth_equal_height_element' => '',
          'alpha_region_postscript_fourth_force' => '',
          'alpha_region_postscript_fourth_zone' => 'postscript',
          'alpha_region_postscript_fourth_prefix' => '',
          'alpha_region_postscript_fourth_columns' => '3',
          'alpha_region_postscript_fourth_suffix' => '',
          'alpha_region_postscript_fourth_weight' => '4',
          'alpha_region_postscript_fourth_css' => '',
          'alpha_region_footer_first_equal_height_container' => '',
          'alpha_region_footer_first_equal_height_element' => '',
          'alpha_region_footer_first_force' => '',
          'alpha_region_footer_first_zone' => 'footer',
          'alpha_region_footer_first_prefix' => '',
          'alpha_region_footer_first_columns' => '12',
          'alpha_region_footer_first_suffix' => '',
          'alpha_region_footer_first_weight' => '1',
          'alpha_region_footer_first_css' => '',
          'alpha_region_footer_second_equal_height_container' => '',
          'alpha_region_footer_second_equal_height_element' => '',
          'alpha_region_footer_second_force' => '',
          'alpha_region_footer_second_zone' => 'footer',
          'alpha_region_footer_second_prefix' => '',
          'alpha_region_footer_second_columns' => '12',
          'alpha_region_footer_second_suffix' => '',
          'alpha_region_footer_second_weight' => '2',
          'alpha_region_footer_second_css' => '',
        ),
        'project' => 'omega',
        'datestamp' => '1329681647',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'omega',
      'version' => '7.x-3.1',
    ),
    'seven' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/themes/seven/seven.info',
      'name' => 'seven',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '1',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Seven',
        'description' => 'A simple one-column, tableless, fluid width administration theme.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'stylesheets' => 
        array (
          'screen' => 
          array (
            0 => 'reset.css',
            1 => 'style.css',
          ),
        ),
        'settings' => 
        array (
          'shortcut_module_link' => '1',
        ),
        'regions' => 
        array (
          'content' => 'Content',
          'help' => 'Help',
          'page_top' => 'Page top',
          'page_bottom' => 'Page bottom',
          'sidebar_first' => 'First sidebar',
        ),
        'regions_hidden' => 
        array (
          0 => 'sidebar_first',
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'shiny' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/themes/shiny/shiny.info',
      'name' => 'shiny',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Shiny',
        'description' => 'Awesome responsive cross-browser D7/HTML5/CSS3 theme based on Omega, SCSS, Compass and PIE.',
        'core' => '7.x',
        'engine' => 'phptemplate',
        'screenshot' => 'screenshot.png',
        'base theme' => 'omega',
        'regions' => 
        array (
          'page_top' => 'Page Top',
          'page_bottom' => 'Page Bottom',
          'content' => 'Content',
          'user_first' => 'User Bar First',
          'user_second' => 'User Bar Second',
          'branding' => 'Branding',
          'menu' => 'Menu',
          'sidebar_first' => 'Sidebar First',
          'sidebar_second' => 'Sidebar Second',
          'header_first' => 'Header First',
          'header_second' => 'Header Second',
          'preface_first' => 'Preface First',
          'preface_second' => 'Preface Second',
          'preface_third' => 'Preface Third',
          'postscript_first' => 'Postscript First',
          'postscript_second' => 'Postscript Second',
          'postscript_third' => 'Postscript Third',
          'postscript_fourth' => 'Postscript Fourth',
          'footer_first' => 'Footer First',
          'footer_second' => 'Footer Second',
        ),
        'zones' => 
        array (
          'user' => 'User',
          'branding' => 'Branding',
          'menu' => 'Menu',
          'header' => 'Header',
          'preface' => 'Preface',
          'content' => 'Content',
          'postscript' => 'Postscript',
          'footer' => 'Footer',
        ),
        'css' => 
        array (
          'global.scss' => 
          array (
            'name' => 'Your custom global styles',
            'description' => 'This file holds all the globally active custom CSS of your theme.',
            'options' => 
            array (
              'weight' => '10',
            ),
          ),
        ),
        'settings' => 
        array (
          'alpha_grid' => 'alpha_default',
          'alpha_primary_alpha_default' => 'normal',
          'alpha_responsive' => '1',
          'alpha_layouts_alpha_fluid_primary' => 'normal',
          'alpha_layouts_alpha_fluid_normal_responsive' => '0',
          'alpha_layouts_alpha_fluid_normal_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_primary' => 'normal',
          'alpha_layouts_alpha_default_fluid_responsive' => '0',
          'alpha_layouts_alpha_default_fluid_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_fluid_weight' => '0',
          'alpha_layouts_alpha_default_narrow_responsive' => '1',
          'alpha_layouts_alpha_default_narrow_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_narrow_weight' => '1',
          'alpha_layouts_alpha_default_normal_responsive' => '1',
          'alpha_layouts_alpha_default_normal_media' => 'all and (min-width: 980px) and (min-device-width: 980px), all and (max-device-width: 1024px) and (min-width: 1024px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_normal_weight' => '2',
          'alpha_layouts_alpha_default_wide_responsive' => '1',
          'alpha_layouts_alpha_default_wide_media' => 'all and (min-width: 1220px)',
          'alpha_layouts_alpha_default_wide_weight' => '3',
          'alpha_viewport' => '1',
          'alpha_viewport_initial_scale' => '1',
          'alpha_viewport_min_scale' => '1',
          'alpha_viewport_max_scale' => '1',
          'alpha_viewport_user_scaleable' => '',
          'alpha_libraries' => 
          array (
            'omega_formalize' => 'omega_formalize',
            'omega_equalheights' => '',
            'omega_mediaqueries' => 'omega_mediaqueries',
          ),
          'alpha_css' => 
          array (
            'alpha-reset.css' => 'alpha-reset.css',
            'alpha-mobile.css' => 'alpha-mobile.css',
            'alpha-alpha.css' => 'alpha-alpha.css',
            'omega-text.css' => 'omega-text.css',
            'omega-branding.css' => 'omega-branding.css',
            'omega-menu.css' => 'omega-menu.css',
            'omega-forms.css' => 'omega-forms.css',
            'omega-visuals.css' => 'omega-visuals.css',
            'global.css' => 'global.css',
          ),
          'alpha_debug_block_toggle' => '1',
          'alpha_debug_block_active' => '1',
          'alpha_debug_grid_toggle' => '1',
          'alpha_debug_grid_active' => '1',
          'alpha_debug_grid_roles' => 
          array (
            1 => '1',
            2 => '2',
            3 => '3',
          ),
          'alpha_toggle_messages' => '1',
          'alpha_toggle_action_links' => '1',
          'alpha_toggle_tabs' => '1',
          'alpha_toggle_breadcrumb' => '1',
          'alpha_toggle_page_title' => '1',
          'alpha_toggle_feed_icons' => '1',
          'alpha_hidden_title' => '',
          'alpha_hidden_site_name' => '',
          'alpha_hidden_site_slogan' => '',
          'alpha_zone_user_equal_height_container' => '',
          'alpha_zone_user_wrapper' => '1',
          'alpha_zone_user_force' => '',
          'alpha_zone_user_section' => 'header',
          'alpha_zone_user_weight' => '1',
          'alpha_zone_user_columns' => '12',
          'alpha_zone_user_primary' => '',
          'alpha_zone_user_css' => '',
          'alpha_zone_user_wrapper_css' => '',
          'alpha_zone_branding_equal_height_container' => '',
          'alpha_zone_branding_wrapper' => '1',
          'alpha_zone_branding_force' => '',
          'alpha_zone_branding_section' => 'header',
          'alpha_zone_branding_weight' => '2',
          'alpha_zone_branding_columns' => '12',
          'alpha_zone_branding_primary' => '',
          'alpha_zone_branding_css' => '',
          'alpha_zone_branding_wrapper_css' => '',
          'alpha_zone_menu_equal_height_container' => '',
          'alpha_zone_menu_wrapper' => '1',
          'alpha_zone_menu_force' => '',
          'alpha_zone_menu_section' => 'header',
          'alpha_zone_menu_weight' => '3',
          'alpha_zone_menu_columns' => '12',
          'alpha_zone_menu_primary' => '',
          'alpha_zone_menu_css' => '',
          'alpha_zone_menu_wrapper_css' => '',
          'alpha_zone_header_equal_height_container' => '',
          'alpha_zone_header_wrapper' => '1',
          'alpha_zone_header_force' => '',
          'alpha_zone_header_section' => 'header',
          'alpha_zone_header_weight' => '4',
          'alpha_zone_header_columns' => '12',
          'alpha_zone_header_primary' => '',
          'alpha_zone_header_css' => '',
          'alpha_zone_header_wrapper_css' => '',
          'alpha_zone_preface_equal_height_container' => '',
          'alpha_zone_preface_wrapper' => '1',
          'alpha_zone_preface_force' => '',
          'alpha_zone_preface_section' => 'content',
          'alpha_zone_preface_weight' => '1',
          'alpha_zone_preface_columns' => '12',
          'alpha_zone_preface_primary' => '',
          'alpha_zone_preface_css' => '',
          'alpha_zone_preface_wrapper_css' => '',
          'alpha_zone_content_equal_height_container' => '',
          'alpha_zone_content_wrapper' => '1',
          'alpha_zone_content_force' => '1',
          'alpha_zone_content_section' => 'content',
          'alpha_zone_content_weight' => '2',
          'alpha_zone_content_columns' => '12',
          'alpha_zone_content_primary' => 'content',
          'alpha_zone_content_css' => '',
          'alpha_zone_content_wrapper_css' => '',
          'alpha_zone_postscript_equal_height_container' => '',
          'alpha_zone_postscript_wrapper' => '1',
          'alpha_zone_postscript_force' => '',
          'alpha_zone_postscript_section' => 'content',
          'alpha_zone_postscript_weight' => '3',
          'alpha_zone_postscript_columns' => '12',
          'alpha_zone_postscript_primary' => '',
          'alpha_zone_postscript_css' => '',
          'alpha_zone_postscript_wrapper_css' => '',
          'alpha_zone_footer_equal_height_container' => '',
          'alpha_zone_footer_wrapper' => '1',
          'alpha_zone_footer_force' => '',
          'alpha_zone_footer_section' => 'footer',
          'alpha_zone_footer_weight' => '1',
          'alpha_zone_footer_columns' => '12',
          'alpha_zone_footer_primary' => '',
          'alpha_zone_footer_css' => '',
          'alpha_zone_footer_wrapper_css' => '',
          'alpha_region_dashboard_sidebar_equal_height_container' => '',
          'alpha_region_dashboard_sidebar_equal_height_element' => '',
          'alpha_region_dashboard_sidebar_force' => '',
          'alpha_region_dashboard_sidebar_zone' => '',
          'alpha_region_dashboard_sidebar_prefix' => '',
          'alpha_region_dashboard_sidebar_columns' => '1',
          'alpha_region_dashboard_sidebar_suffix' => '',
          'alpha_region_dashboard_sidebar_weight' => '-50',
          'alpha_region_dashboard_sidebar_css' => '',
          'alpha_region_dashboard_inactive_equal_height_container' => '',
          'alpha_region_dashboard_inactive_equal_height_element' => '',
          'alpha_region_dashboard_inactive_force' => '',
          'alpha_region_dashboard_inactive_zone' => '',
          'alpha_region_dashboard_inactive_prefix' => '',
          'alpha_region_dashboard_inactive_columns' => '1',
          'alpha_region_dashboard_inactive_suffix' => '',
          'alpha_region_dashboard_inactive_weight' => '-50',
          'alpha_region_dashboard_inactive_css' => '',
          'alpha_region_dashboard_main_equal_height_container' => '',
          'alpha_region_dashboard_main_equal_height_element' => '',
          'alpha_region_dashboard_main_force' => '',
          'alpha_region_dashboard_main_zone' => '',
          'alpha_region_dashboard_main_prefix' => '',
          'alpha_region_dashboard_main_columns' => '1',
          'alpha_region_dashboard_main_suffix' => '',
          'alpha_region_dashboard_main_weight' => '-50',
          'alpha_region_dashboard_main_css' => '',
          'alpha_region_user_first_equal_height_container' => '',
          'alpha_region_user_first_equal_height_element' => '',
          'alpha_region_user_first_force' => '',
          'alpha_region_user_first_zone' => 'user',
          'alpha_region_user_first_prefix' => '',
          'alpha_region_user_first_columns' => '8',
          'alpha_region_user_first_suffix' => '',
          'alpha_region_user_first_weight' => '1',
          'alpha_region_user_first_css' => '',
          'alpha_region_user_second_equal_height_container' => '',
          'alpha_region_user_second_equal_height_element' => '',
          'alpha_region_user_second_force' => '',
          'alpha_region_user_second_zone' => 'user',
          'alpha_region_user_second_prefix' => '',
          'alpha_region_user_second_columns' => '4',
          'alpha_region_user_second_suffix' => '',
          'alpha_region_user_second_weight' => '2',
          'alpha_region_user_second_css' => '',
          'alpha_region_branding_equal_height_container' => '',
          'alpha_region_branding_equal_height_element' => '',
          'alpha_region_branding_force' => '1',
          'alpha_region_branding_zone' => 'branding',
          'alpha_region_branding_prefix' => '',
          'alpha_region_branding_columns' => '12',
          'alpha_region_branding_suffix' => '',
          'alpha_region_branding_weight' => '1',
          'alpha_region_branding_css' => '',
          'alpha_region_menu_equal_height_container' => '',
          'alpha_region_menu_equal_height_element' => '',
          'alpha_region_menu_force' => '1',
          'alpha_region_menu_zone' => 'menu',
          'alpha_region_menu_prefix' => '',
          'alpha_region_menu_columns' => '12',
          'alpha_region_menu_suffix' => '',
          'alpha_region_menu_weight' => '1',
          'alpha_region_menu_css' => '',
          'alpha_region_header_first_equal_height_container' => '',
          'alpha_region_header_first_equal_height_element' => '',
          'alpha_region_header_first_force' => '',
          'alpha_region_header_first_zone' => 'header',
          'alpha_region_header_first_prefix' => '',
          'alpha_region_header_first_columns' => '6',
          'alpha_region_header_first_suffix' => '',
          'alpha_region_header_first_weight' => '1',
          'alpha_region_header_first_css' => '',
          'alpha_region_header_second_equal_height_container' => '',
          'alpha_region_header_second_equal_height_element' => '',
          'alpha_region_header_second_force' => '',
          'alpha_region_header_second_zone' => 'header',
          'alpha_region_header_second_prefix' => '',
          'alpha_region_header_second_columns' => '6',
          'alpha_region_header_second_suffix' => '',
          'alpha_region_header_second_weight' => '2',
          'alpha_region_header_second_css' => '',
          'alpha_region_preface_first_equal_height_container' => '',
          'alpha_region_preface_first_equal_height_element' => '',
          'alpha_region_preface_first_force' => '',
          'alpha_region_preface_first_zone' => 'preface',
          'alpha_region_preface_first_prefix' => '',
          'alpha_region_preface_first_columns' => '4',
          'alpha_region_preface_first_suffix' => '',
          'alpha_region_preface_first_weight' => '1',
          'alpha_region_preface_first_css' => '',
          'alpha_region_preface_second_equal_height_container' => '',
          'alpha_region_preface_second_equal_height_element' => '',
          'alpha_region_preface_second_force' => '',
          'alpha_region_preface_second_zone' => 'preface',
          'alpha_region_preface_second_prefix' => '',
          'alpha_region_preface_second_columns' => '4',
          'alpha_region_preface_second_suffix' => '',
          'alpha_region_preface_second_weight' => '2',
          'alpha_region_preface_second_css' => '',
          'alpha_region_preface_third_equal_height_container' => '',
          'alpha_region_preface_third_equal_height_element' => '',
          'alpha_region_preface_third_force' => '',
          'alpha_region_preface_third_zone' => 'preface',
          'alpha_region_preface_third_prefix' => '',
          'alpha_region_preface_third_columns' => '4',
          'alpha_region_preface_third_suffix' => '',
          'alpha_region_preface_third_weight' => '3',
          'alpha_region_preface_third_css' => '',
          'alpha_region_content_equal_height_container' => '',
          'alpha_region_content_equal_height_element' => '',
          'alpha_region_content_force' => '',
          'alpha_region_content_zone' => 'content',
          'alpha_region_content_prefix' => '',
          'alpha_region_content_columns' => '6',
          'alpha_region_content_suffix' => '',
          'alpha_region_content_weight' => '2',
          'alpha_region_content_css' => '',
          'alpha_region_sidebar_first_equal_height_container' => '',
          'alpha_region_sidebar_first_equal_height_element' => '',
          'alpha_region_sidebar_first_force' => '',
          'alpha_region_sidebar_first_zone' => 'content',
          'alpha_region_sidebar_first_prefix' => '',
          'alpha_region_sidebar_first_columns' => '3',
          'alpha_region_sidebar_first_suffix' => '',
          'alpha_region_sidebar_first_weight' => '1',
          'alpha_region_sidebar_first_css' => '',
          'alpha_region_sidebar_second_equal_height_container' => '',
          'alpha_region_sidebar_second_equal_height_element' => '',
          'alpha_region_sidebar_second_force' => '',
          'alpha_region_sidebar_second_zone' => 'content',
          'alpha_region_sidebar_second_prefix' => '',
          'alpha_region_sidebar_second_columns' => '3',
          'alpha_region_sidebar_second_suffix' => '',
          'alpha_region_sidebar_second_weight' => '3',
          'alpha_region_sidebar_second_css' => '',
          'alpha_region_postscript_first_equal_height_container' => '',
          'alpha_region_postscript_first_equal_height_element' => '',
          'alpha_region_postscript_first_force' => '',
          'alpha_region_postscript_first_zone' => 'postscript',
          'alpha_region_postscript_first_prefix' => '',
          'alpha_region_postscript_first_columns' => '3',
          'alpha_region_postscript_first_suffix' => '',
          'alpha_region_postscript_first_weight' => '1',
          'alpha_region_postscript_first_css' => '',
          'alpha_region_postscript_second_equal_height_container' => '',
          'alpha_region_postscript_second_equal_height_element' => '',
          'alpha_region_postscript_second_force' => '',
          'alpha_region_postscript_second_zone' => 'postscript',
          'alpha_region_postscript_second_prefix' => '',
          'alpha_region_postscript_second_columns' => '3',
          'alpha_region_postscript_second_suffix' => '',
          'alpha_region_postscript_second_weight' => '2',
          'alpha_region_postscript_second_css' => '',
          'alpha_region_postscript_third_equal_height_container' => '',
          'alpha_region_postscript_third_equal_height_element' => '',
          'alpha_region_postscript_third_force' => '',
          'alpha_region_postscript_third_zone' => 'postscript',
          'alpha_region_postscript_third_prefix' => '',
          'alpha_region_postscript_third_columns' => '3',
          'alpha_region_postscript_third_suffix' => '',
          'alpha_region_postscript_third_weight' => '3',
          'alpha_region_postscript_third_css' => '',
          'alpha_region_postscript_fourth_equal_height_container' => '',
          'alpha_region_postscript_fourth_equal_height_element' => '',
          'alpha_region_postscript_fourth_force' => '',
          'alpha_region_postscript_fourth_zone' => 'postscript',
          'alpha_region_postscript_fourth_prefix' => '',
          'alpha_region_postscript_fourth_columns' => '3',
          'alpha_region_postscript_fourth_suffix' => '',
          'alpha_region_postscript_fourth_weight' => '4',
          'alpha_region_postscript_fourth_css' => '',
          'alpha_region_footer_first_equal_height_container' => '',
          'alpha_region_footer_first_equal_height_element' => '',
          'alpha_region_footer_first_force' => '',
          'alpha_region_footer_first_zone' => 'footer',
          'alpha_region_footer_first_prefix' => '',
          'alpha_region_footer_first_columns' => '12',
          'alpha_region_footer_first_suffix' => '',
          'alpha_region_footer_first_weight' => '1',
          'alpha_region_footer_first_css' => '',
          'alpha_region_footer_second_equal_height_container' => '',
          'alpha_region_footer_second_equal_height_element' => '',
          'alpha_region_footer_second_force' => '',
          'alpha_region_footer_second_zone' => 'footer',
          'alpha_region_footer_second_prefix' => '',
          'alpha_region_footer_second_columns' => '12',
          'alpha_region_footer_second_suffix' => '',
          'alpha_region_footer_second_weight' => '2',
          'alpha_region_footer_second_css' => '',
        ),
        'dependencies' => 
        array (
        ),
        'version' => NULL,
        'php' => '5.2.4',
      ),
      'project' => '',
      'version' => NULL,
    ),
    'stark' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/themes/stark/stark.info',
      'name' => 'stark',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Stark',
        'description' => 'This theme demonstrates Drupal\'s default HTML markup and CSS styles. To learn how to build your own theme and override Drupal\'s default code, see the <a href="http://drupal.org/theme-guide">Theming Guide</a>.',
        'package' => 'Core',
        'version' => '7.15',
        'core' => '7.x',
        'stylesheets' => 
        array (
          'all' => 
          array (
            0 => 'layout.css',
          ),
        ),
        'project' => 'drupal',
        'datestamp' => '1343839327',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'drupal',
      'version' => '7.15',
    ),
    'starterkit_alpha_xhtml' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/themes/omega/starterkits/alpha-xhtml/starterkit_alpha_xhtml.info',
      'name' => 'starterkit_alpha_xhtml',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Alpha XHTML Starterkit',
        'description' => 'Default starterkit for <a href="http://drupal.org/project/omega">Alpha</a>. You should not directly edit this starterkit, but make your own copy. Information on this can be found in the <a href="http://himer.us/omega-docs">Omega Documentation</a>',
        'core' => '7.x',
        'engine' => 'phptemplate',
        'screenshot' => 'screenshot.png',
        'base theme' => 'alpha',
        'hidden' => true,
        'starterkit' => true,
        'regions' => 
        array (
          'page_top' => 'Page Top',
          'page_bottom' => 'Page Bottom',
          'content' => 'Content',
          'header' => 'Header',
          'footer' => 'Footer',
          'sidebar_first' => 'Sidebar First',
          'sidebar_second' => 'Sidebar Second',
        ),
        'zones' => 
        array (
          'content' => 'Content',
          'header' => 'Header',
          'footer' => 'Footer',
        ),
        'css' => 
        array (
          'global.css' => 
          array (
            'name' => 'Your custom global styles',
            'description' => 'This file holds all the globally active custom CSS of your theme.',
            'options' => 
            array (
              'weight' => '10',
            ),
          ),
        ),
        'settings' => 
        array (
          'alpha_grid' => 'alpha_default',
          'alpha_primary_alpha_default' => 'normal',
          'alpha_responsive' => '1',
          'alpha_layouts_alpha_fluid_primary' => 'normal',
          'alpha_layouts_alpha_fluid_normal_responsive' => '0',
          'alpha_layouts_alpha_fluid_normal_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_primary' => 'normal',
          'alpha_layouts_alpha_default_fluid_responsive' => '0',
          'alpha_layouts_alpha_default_fluid_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_fluid_weight' => '0',
          'alpha_layouts_alpha_default_narrow_responsive' => '1',
          'alpha_layouts_alpha_default_narrow_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_narrow_weight' => '1',
          'alpha_layouts_alpha_default_normal_responsive' => '1',
          'alpha_layouts_alpha_default_normal_media' => 'all and (min-width: 980px) and (min-device-width: 980px), all and (max-device-width: 1024px) and (min-width: 1024px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_normal_weight' => '2',
          'alpha_layouts_alpha_default_wide_responsive' => '1',
          'alpha_layouts_alpha_default_wide_media' => 'all and (min-width: 1220px)',
          'alpha_layouts_alpha_default_wide_weight' => '3',
          'alpha_viewport' => '1',
          'alpha_viewport_initial_scale' => '1',
          'alpha_viewport_min_scale' => '1',
          'alpha_viewport_max_scale' => '1',
          'alpha_viewport_user_scaleable' => '',
          'alpha_css' => 
          array (
            'alpha-reset.css' => 'alpha-reset.css',
            'alpha-alpha.css' => 'alpha-alpha.css',
            'alpha-mobile.css' => 'alpha-mobile.css',
            'global.css' => 'global.css',
          ),
          'alpha_debug_block_toggle' => '1',
          'alpha_debug_block_active' => '1',
          'alpha_debug_grid_toggle' => '1',
          'alpha_debug_grid_active' => '1',
          'alpha_debug_grid_roles' => 
          array (
            1 => '1',
            2 => '2',
            3 => '3',
          ),
          'alpha_toggle_messages' => '1',
          'alpha_toggle_action_links' => '1',
          'alpha_toggle_tabs' => '1',
          'alpha_toggle_breadcrumb' => '1',
          'alpha_toggle_page_title' => '1',
          'alpha_toggle_feed_icons' => '1',
          'alpha_hidden_title' => '',
          'alpha_hidden_site_name' => '',
          'alpha_hidden_site_slogan' => '',
          'alpha_zone_header_wrapper' => '',
          'alpha_zone_header_force' => '',
          'alpha_zone_header_section' => 'header',
          'alpha_zone_header_weight' => '',
          'alpha_zone_header_columns' => '12',
          'alpha_zone_header_primary' => '',
          'alpha_zone_header_order' => '0',
          'alpha_zone_header_css' => '',
          'alpha_zone_header_wrapper_css' => '',
          'alpha_zone_content_wrapper' => '',
          'alpha_zone_content_force' => '',
          'alpha_zone_content_section' => 'content',
          'alpha_zone_content_weight' => '',
          'alpha_zone_content_columns' => '12',
          'alpha_zone_content_primary' => '',
          'alpha_zone_content_order' => '0',
          'alpha_zone_content_css' => '',
          'alpha_zone_content_wrapper_css' => '',
          'alpha_zone_footer_wrapper' => '',
          'alpha_zone_footer_force' => '',
          'alpha_zone_footer_section' => 'footer',
          'alpha_zone_footer_weight' => '',
          'alpha_zone_footer_columns' => '12',
          'alpha_zone_footer_primary' => '',
          'alpha_zone_footer_order' => '0',
          'alpha_zone_footer_css' => '',
          'alpha_zone_footer_wrapper_css' => '',
          'alpha_region_dashboard_inactive_force' => '',
          'alpha_region_dashboard_inactive_zone' => '',
          'alpha_region_dashboard_inactive_prefix' => '',
          'alpha_region_dashboard_inactive_columns' => '',
          'alpha_region_dashboard_inactive_suffix' => '',
          'alpha_region_dashboard_inactive_weight' => '',
          'alpha_region_dashboard_inactive_position' => '',
          'alpha_region_dashboard_inactive_css' => '',
          'alpha_region_dashboard_sidebar_force' => '',
          'alpha_region_dashboard_sidebar_zone' => '',
          'alpha_region_dashboard_sidebar_prefix' => '',
          'alpha_region_dashboard_sidebar_columns' => '',
          'alpha_region_dashboard_sidebar_suffix' => '',
          'alpha_region_dashboard_sidebar_weight' => '',
          'alpha_region_dashboard_sidebar_position' => '',
          'alpha_region_dashboard_sidebar_css' => '',
          'alpha_region_dashboard_main_force' => '',
          'alpha_region_dashboard_main_zone' => '',
          'alpha_region_dashboard_main_prefix' => '',
          'alpha_region_dashboard_main_columns' => '',
          'alpha_region_dashboard_main_suffix' => '',
          'alpha_region_dashboard_main_weight' => '',
          'alpha_region_dashboard_main_position' => '',
          'alpha_region_dashboard_main_css' => '',
          'alpha_region_header_force' => '',
          'alpha_region_header_zone' => 'header',
          'alpha_region_header_prefix' => '',
          'alpha_region_header_columns' => '12',
          'alpha_region_header_suffix' => '',
          'alpha_region_header_weight' => '',
          'alpha_region_header_position' => '1',
          'alpha_region_header_css' => '',
          'alpha_region_content_force' => '',
          'alpha_region_content_zone' => 'content',
          'alpha_region_content_prefix' => '',
          'alpha_region_content_columns' => '6',
          'alpha_region_content_suffix' => '',
          'alpha_region_content_weight' => '1',
          'alpha_region_content_position' => '2',
          'alpha_region_content_css' => '',
          'alpha_region_sidebar_first_force' => '',
          'alpha_region_sidebar_first_zone' => 'content',
          'alpha_region_sidebar_first_prefix' => '',
          'alpha_region_sidebar_first_columns' => '3',
          'alpha_region_sidebar_first_suffix' => '',
          'alpha_region_sidebar_first_weight' => '2',
          'alpha_region_sidebar_first_position' => '1',
          'alpha_region_sidebar_first_css' => '',
          'alpha_region_sidebar_second_force' => '',
          'alpha_region_sidebar_second_zone' => 'content',
          'alpha_region_sidebar_second_prefix' => '',
          'alpha_region_sidebar_second_columns' => '3',
          'alpha_region_sidebar_second_suffix' => '',
          'alpha_region_sidebar_second_weight' => '3',
          'alpha_region_sidebar_second_position' => '3',
          'alpha_region_sidebar_second_css' => '',
          'alpha_region_footer_force' => '',
          'alpha_region_footer_zone' => 'footer',
          'alpha_region_footer_prefix' => '',
          'alpha_region_footer_columns' => '12',
          'alpha_region_footer_suffix' => '',
          'alpha_region_footer_weight' => '1',
          'alpha_region_footer_css' => '',
        ),
        'version' => '7.x-3.1',
        'project' => 'omega',
        'datestamp' => '1329681647',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'omega',
      'version' => '7.x-3.1',
    ),
    'starterkit_omega_html5' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/themes/omega/starterkits/omega-html5/starterkit_omega_html5.info',
      'name' => 'starterkit_omega_html5',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Omega HTML5 Starterkit',
        'description' => 'Default starterkit for <a href="http://drupal.org/project/omega">Omega</a>. You should not directly edit this starterkit, but make your own copy. Information on this can be found in the <a href="http://himer.us/omega-docs">Omega Documentation</a>',
        'core' => '7.x',
        'engine' => 'phptemplate',
        'screenshot' => 'screenshot.png',
        'base theme' => 'omega',
        'hidden' => true,
        'starterkit' => true,
        'regions' => 
        array (
          'page_top' => 'Page Top',
          'page_bottom' => 'Page Bottom',
          'content' => 'Content',
          'user_first' => 'User Bar First',
          'user_second' => 'User Bar Second',
          'branding' => 'Branding',
          'menu' => 'Menu',
          'sidebar_first' => 'Sidebar First',
          'sidebar_second' => 'Sidebar Second',
          'header_first' => 'Header First',
          'header_second' => 'Header Second',
          'preface_first' => 'Preface First',
          'preface_second' => 'Preface Second',
          'preface_third' => 'Preface Third',
          'postscript_first' => 'Postscript First',
          'postscript_second' => 'Postscript Second',
          'postscript_third' => 'Postscript Third',
          'postscript_fourth' => 'Postscript Fourth',
          'footer_first' => 'Footer First',
          'footer_second' => 'Footer Second',
        ),
        'zones' => 
        array (
          'user' => 'User',
          'branding' => 'Branding',
          'menu' => 'Menu',
          'header' => 'Header',
          'preface' => 'Preface',
          'content' => 'Content',
          'postscript' => 'Postscript',
          'footer' => 'Footer',
        ),
        'css' => 
        array (
          'global.css' => 
          array (
            'name' => 'Your custom global styles',
            'description' => 'This file holds all the globally active custom CSS of your theme.',
            'options' => 
            array (
              'weight' => '10',
            ),
          ),
        ),
        'settings' => 
        array (
          'alpha_grid' => 'alpha_default',
          'alpha_primary_alpha_default' => 'normal',
          'alpha_responsive' => '1',
          'alpha_layouts_alpha_fluid_primary' => 'normal',
          'alpha_layouts_alpha_fluid_normal_responsive' => '0',
          'alpha_layouts_alpha_fluid_normal_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_primary' => 'normal',
          'alpha_layouts_alpha_default_fluid_responsive' => '0',
          'alpha_layouts_alpha_default_fluid_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_fluid_weight' => '0',
          'alpha_layouts_alpha_default_narrow_responsive' => '1',
          'alpha_layouts_alpha_default_narrow_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_narrow_weight' => '1',
          'alpha_layouts_alpha_default_normal_responsive' => '1',
          'alpha_layouts_alpha_default_normal_media' => 'all and (min-width: 980px) and (min-device-width: 980px), all and (max-device-width: 1024px) and (min-width: 1024px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_normal_weight' => '2',
          'alpha_layouts_alpha_default_wide_responsive' => '1',
          'alpha_layouts_alpha_default_wide_media' => 'all and (min-width: 1220px)',
          'alpha_layouts_alpha_default_wide_weight' => '3',
          'alpha_viewport' => '1',
          'alpha_viewport_initial_scale' => '1',
          'alpha_viewport_min_scale' => '1',
          'alpha_viewport_max_scale' => '1',
          'alpha_viewport_user_scaleable' => '',
          'alpha_libraries' => 
          array (
            'omega_formalize' => 'omega_formalize',
            'omega_equalheights' => '',
            'omega_mediaqueries' => 'omega_mediaqueries',
          ),
          'alpha_css' => 
          array (
            'alpha-reset.css' => 'alpha-reset.css',
            'alpha-mobile.css' => 'alpha-mobile.css',
            'alpha-alpha.css' => 'alpha-alpha.css',
            'omega-text.css' => 'omega-text.css',
            'omega-branding.css' => 'omega-branding.css',
            'omega-menu.css' => 'omega-menu.css',
            'omega-forms.css' => 'omega-forms.css',
            'omega-visuals.css' => 'omega-visuals.css',
            'global.css' => 'global.css',
          ),
          'alpha_debug_block_toggle' => '1',
          'alpha_debug_block_active' => '1',
          'alpha_debug_grid_toggle' => '1',
          'alpha_debug_grid_active' => '1',
          'alpha_debug_grid_roles' => 
          array (
            1 => '1',
            2 => '2',
            3 => '3',
          ),
          'alpha_toggle_messages' => '1',
          'alpha_toggle_action_links' => '1',
          'alpha_toggle_tabs' => '1',
          'alpha_toggle_breadcrumb' => '1',
          'alpha_toggle_page_title' => '1',
          'alpha_toggle_feed_icons' => '1',
          'alpha_hidden_title' => '',
          'alpha_hidden_site_name' => '',
          'alpha_hidden_site_slogan' => '',
          'alpha_zone_user_equal_height_container' => '',
          'alpha_zone_user_wrapper' => '1',
          'alpha_zone_user_force' => '',
          'alpha_zone_user_section' => 'header',
          'alpha_zone_user_weight' => '1',
          'alpha_zone_user_columns' => '12',
          'alpha_zone_user_primary' => '',
          'alpha_zone_user_css' => '',
          'alpha_zone_user_wrapper_css' => '',
          'alpha_zone_branding_equal_height_container' => '',
          'alpha_zone_branding_wrapper' => '1',
          'alpha_zone_branding_force' => '',
          'alpha_zone_branding_section' => 'header',
          'alpha_zone_branding_weight' => '2',
          'alpha_zone_branding_columns' => '12',
          'alpha_zone_branding_primary' => '',
          'alpha_zone_branding_css' => '',
          'alpha_zone_branding_wrapper_css' => '',
          'alpha_zone_menu_equal_height_container' => '',
          'alpha_zone_menu_wrapper' => '1',
          'alpha_zone_menu_force' => '',
          'alpha_zone_menu_section' => 'header',
          'alpha_zone_menu_weight' => '3',
          'alpha_zone_menu_columns' => '12',
          'alpha_zone_menu_primary' => '',
          'alpha_zone_menu_css' => '',
          'alpha_zone_menu_wrapper_css' => '',
          'alpha_zone_header_equal_height_container' => '',
          'alpha_zone_header_wrapper' => '1',
          'alpha_zone_header_force' => '',
          'alpha_zone_header_section' => 'header',
          'alpha_zone_header_weight' => '4',
          'alpha_zone_header_columns' => '12',
          'alpha_zone_header_primary' => '',
          'alpha_zone_header_css' => '',
          'alpha_zone_header_wrapper_css' => '',
          'alpha_zone_preface_equal_height_container' => '',
          'alpha_zone_preface_wrapper' => '1',
          'alpha_zone_preface_force' => '',
          'alpha_zone_preface_section' => 'content',
          'alpha_zone_preface_weight' => '1',
          'alpha_zone_preface_columns' => '12',
          'alpha_zone_preface_primary' => '',
          'alpha_zone_preface_css' => '',
          'alpha_zone_preface_wrapper_css' => '',
          'alpha_zone_content_equal_height_container' => '',
          'alpha_zone_content_wrapper' => '1',
          'alpha_zone_content_force' => '1',
          'alpha_zone_content_section' => 'content',
          'alpha_zone_content_weight' => '2',
          'alpha_zone_content_columns' => '12',
          'alpha_zone_content_primary' => 'content',
          'alpha_zone_content_css' => '',
          'alpha_zone_content_wrapper_css' => '',
          'alpha_zone_postscript_equal_height_container' => '',
          'alpha_zone_postscript_wrapper' => '1',
          'alpha_zone_postscript_force' => '',
          'alpha_zone_postscript_section' => 'content',
          'alpha_zone_postscript_weight' => '3',
          'alpha_zone_postscript_columns' => '12',
          'alpha_zone_postscript_primary' => '',
          'alpha_zone_postscript_css' => '',
          'alpha_zone_postscript_wrapper_css' => '',
          'alpha_zone_footer_equal_height_container' => '',
          'alpha_zone_footer_wrapper' => '1',
          'alpha_zone_footer_force' => '',
          'alpha_zone_footer_section' => 'footer',
          'alpha_zone_footer_weight' => '1',
          'alpha_zone_footer_columns' => '12',
          'alpha_zone_footer_primary' => '',
          'alpha_zone_footer_css' => '',
          'alpha_zone_footer_wrapper_css' => '',
          'alpha_region_dashboard_sidebar_equal_height_container' => '',
          'alpha_region_dashboard_sidebar_equal_height_element' => '',
          'alpha_region_dashboard_sidebar_force' => '',
          'alpha_region_dashboard_sidebar_zone' => '',
          'alpha_region_dashboard_sidebar_prefix' => '',
          'alpha_region_dashboard_sidebar_columns' => '1',
          'alpha_region_dashboard_sidebar_suffix' => '',
          'alpha_region_dashboard_sidebar_weight' => '-50',
          'alpha_region_dashboard_sidebar_css' => '',
          'alpha_region_dashboard_inactive_equal_height_container' => '',
          'alpha_region_dashboard_inactive_equal_height_element' => '',
          'alpha_region_dashboard_inactive_force' => '',
          'alpha_region_dashboard_inactive_zone' => '',
          'alpha_region_dashboard_inactive_prefix' => '',
          'alpha_region_dashboard_inactive_columns' => '1',
          'alpha_region_dashboard_inactive_suffix' => '',
          'alpha_region_dashboard_inactive_weight' => '-50',
          'alpha_region_dashboard_inactive_css' => '',
          'alpha_region_dashboard_main_equal_height_container' => '',
          'alpha_region_dashboard_main_equal_height_element' => '',
          'alpha_region_dashboard_main_force' => '',
          'alpha_region_dashboard_main_zone' => '',
          'alpha_region_dashboard_main_prefix' => '',
          'alpha_region_dashboard_main_columns' => '1',
          'alpha_region_dashboard_main_suffix' => '',
          'alpha_region_dashboard_main_weight' => '-50',
          'alpha_region_dashboard_main_css' => '',
          'alpha_region_user_first_equal_height_container' => '',
          'alpha_region_user_first_equal_height_element' => '',
          'alpha_region_user_first_force' => '',
          'alpha_region_user_first_zone' => 'user',
          'alpha_region_user_first_prefix' => '',
          'alpha_region_user_first_columns' => '8',
          'alpha_region_user_first_suffix' => '',
          'alpha_region_user_first_weight' => '1',
          'alpha_region_user_first_css' => '',
          'alpha_region_user_second_equal_height_container' => '',
          'alpha_region_user_second_equal_height_element' => '',
          'alpha_region_user_second_force' => '',
          'alpha_region_user_second_zone' => 'user',
          'alpha_region_user_second_prefix' => '',
          'alpha_region_user_second_columns' => '4',
          'alpha_region_user_second_suffix' => '',
          'alpha_region_user_second_weight' => '2',
          'alpha_region_user_second_css' => '',
          'alpha_region_branding_equal_height_container' => '',
          'alpha_region_branding_equal_height_element' => '',
          'alpha_region_branding_force' => '1',
          'alpha_region_branding_zone' => 'branding',
          'alpha_region_branding_prefix' => '',
          'alpha_region_branding_columns' => '12',
          'alpha_region_branding_suffix' => '',
          'alpha_region_branding_weight' => '1',
          'alpha_region_branding_css' => '',
          'alpha_region_menu_equal_height_container' => '',
          'alpha_region_menu_equal_height_element' => '',
          'alpha_region_menu_force' => '1',
          'alpha_region_menu_zone' => 'menu',
          'alpha_region_menu_prefix' => '',
          'alpha_region_menu_columns' => '12',
          'alpha_region_menu_suffix' => '',
          'alpha_region_menu_weight' => '1',
          'alpha_region_menu_css' => '',
          'alpha_region_header_first_equal_height_container' => '',
          'alpha_region_header_first_equal_height_element' => '',
          'alpha_region_header_first_force' => '',
          'alpha_region_header_first_zone' => 'header',
          'alpha_region_header_first_prefix' => '',
          'alpha_region_header_first_columns' => '6',
          'alpha_region_header_first_suffix' => '',
          'alpha_region_header_first_weight' => '1',
          'alpha_region_header_first_css' => '',
          'alpha_region_header_second_equal_height_container' => '',
          'alpha_region_header_second_equal_height_element' => '',
          'alpha_region_header_second_force' => '',
          'alpha_region_header_second_zone' => 'header',
          'alpha_region_header_second_prefix' => '',
          'alpha_region_header_second_columns' => '6',
          'alpha_region_header_second_suffix' => '',
          'alpha_region_header_second_weight' => '2',
          'alpha_region_header_second_css' => '',
          'alpha_region_preface_first_equal_height_container' => '',
          'alpha_region_preface_first_equal_height_element' => '',
          'alpha_region_preface_first_force' => '',
          'alpha_region_preface_first_zone' => 'preface',
          'alpha_region_preface_first_prefix' => '',
          'alpha_region_preface_first_columns' => '4',
          'alpha_region_preface_first_suffix' => '',
          'alpha_region_preface_first_weight' => '1',
          'alpha_region_preface_first_css' => '',
          'alpha_region_preface_second_equal_height_container' => '',
          'alpha_region_preface_second_equal_height_element' => '',
          'alpha_region_preface_second_force' => '',
          'alpha_region_preface_second_zone' => 'preface',
          'alpha_region_preface_second_prefix' => '',
          'alpha_region_preface_second_columns' => '4',
          'alpha_region_preface_second_suffix' => '',
          'alpha_region_preface_second_weight' => '2',
          'alpha_region_preface_second_css' => '',
          'alpha_region_preface_third_equal_height_container' => '',
          'alpha_region_preface_third_equal_height_element' => '',
          'alpha_region_preface_third_force' => '',
          'alpha_region_preface_third_zone' => 'preface',
          'alpha_region_preface_third_prefix' => '',
          'alpha_region_preface_third_columns' => '4',
          'alpha_region_preface_third_suffix' => '',
          'alpha_region_preface_third_weight' => '3',
          'alpha_region_preface_third_css' => '',
          'alpha_region_content_equal_height_container' => '',
          'alpha_region_content_equal_height_element' => '',
          'alpha_region_content_force' => '',
          'alpha_region_content_zone' => 'content',
          'alpha_region_content_prefix' => '',
          'alpha_region_content_columns' => '6',
          'alpha_region_content_suffix' => '',
          'alpha_region_content_weight' => '2',
          'alpha_region_content_css' => '',
          'alpha_region_sidebar_first_equal_height_container' => '',
          'alpha_region_sidebar_first_equal_height_element' => '',
          'alpha_region_sidebar_first_force' => '',
          'alpha_region_sidebar_first_zone' => 'content',
          'alpha_region_sidebar_first_prefix' => '',
          'alpha_region_sidebar_first_columns' => '3',
          'alpha_region_sidebar_first_suffix' => '',
          'alpha_region_sidebar_first_weight' => '1',
          'alpha_region_sidebar_first_css' => '',
          'alpha_region_sidebar_second_equal_height_container' => '',
          'alpha_region_sidebar_second_equal_height_element' => '',
          'alpha_region_sidebar_second_force' => '',
          'alpha_region_sidebar_second_zone' => 'content',
          'alpha_region_sidebar_second_prefix' => '',
          'alpha_region_sidebar_second_columns' => '3',
          'alpha_region_sidebar_second_suffix' => '',
          'alpha_region_sidebar_second_weight' => '3',
          'alpha_region_sidebar_second_css' => '',
          'alpha_region_postscript_first_equal_height_container' => '',
          'alpha_region_postscript_first_equal_height_element' => '',
          'alpha_region_postscript_first_force' => '',
          'alpha_region_postscript_first_zone' => 'postscript',
          'alpha_region_postscript_first_prefix' => '',
          'alpha_region_postscript_first_columns' => '3',
          'alpha_region_postscript_first_suffix' => '',
          'alpha_region_postscript_first_weight' => '1',
          'alpha_region_postscript_first_css' => '',
          'alpha_region_postscript_second_equal_height_container' => '',
          'alpha_region_postscript_second_equal_height_element' => '',
          'alpha_region_postscript_second_force' => '',
          'alpha_region_postscript_second_zone' => 'postscript',
          'alpha_region_postscript_second_prefix' => '',
          'alpha_region_postscript_second_columns' => '3',
          'alpha_region_postscript_second_suffix' => '',
          'alpha_region_postscript_second_weight' => '2',
          'alpha_region_postscript_second_css' => '',
          'alpha_region_postscript_third_equal_height_container' => '',
          'alpha_region_postscript_third_equal_height_element' => '',
          'alpha_region_postscript_third_force' => '',
          'alpha_region_postscript_third_zone' => 'postscript',
          'alpha_region_postscript_third_prefix' => '',
          'alpha_region_postscript_third_columns' => '3',
          'alpha_region_postscript_third_suffix' => '',
          'alpha_region_postscript_third_weight' => '3',
          'alpha_region_postscript_third_css' => '',
          'alpha_region_postscript_fourth_equal_height_container' => '',
          'alpha_region_postscript_fourth_equal_height_element' => '',
          'alpha_region_postscript_fourth_force' => '',
          'alpha_region_postscript_fourth_zone' => 'postscript',
          'alpha_region_postscript_fourth_prefix' => '',
          'alpha_region_postscript_fourth_columns' => '3',
          'alpha_region_postscript_fourth_suffix' => '',
          'alpha_region_postscript_fourth_weight' => '4',
          'alpha_region_postscript_fourth_css' => '',
          'alpha_region_footer_first_equal_height_container' => '',
          'alpha_region_footer_first_equal_height_element' => '',
          'alpha_region_footer_first_force' => '',
          'alpha_region_footer_first_zone' => 'footer',
          'alpha_region_footer_first_prefix' => '',
          'alpha_region_footer_first_columns' => '12',
          'alpha_region_footer_first_suffix' => '',
          'alpha_region_footer_first_weight' => '1',
          'alpha_region_footer_first_css' => '',
          'alpha_region_footer_second_equal_height_container' => '',
          'alpha_region_footer_second_equal_height_element' => '',
          'alpha_region_footer_second_force' => '',
          'alpha_region_footer_second_zone' => 'footer',
          'alpha_region_footer_second_prefix' => '',
          'alpha_region_footer_second_columns' => '12',
          'alpha_region_footer_second_suffix' => '',
          'alpha_region_footer_second_weight' => '2',
          'alpha_region_footer_second_css' => '',
        ),
        'version' => '7.x-3.1',
        'project' => 'omega',
        'datestamp' => '1329681647',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'omega',
      'version' => '7.x-3.1',
    ),
    'starterkit_omega_xhtml' => 
    array (
      'filename' => '/var/aegir/platforms/moonmars-1.x/sites/all/themes/omega/starterkits/omega-xhtml/starterkit_omega_xhtml.info',
      'name' => 'starterkit_omega_xhtml',
      'type' => 'theme',
      'owner' => 'themes/engines/phptemplate/phptemplate.engine',
      'status' => '0',
      'bootstrap' => '0',
      'schema_version' => 0,
      'weight' => '0',
      'info' => 
      array (
        'name' => 'Omega XHTML Starter Kit',
        'description' => 'Default XHTML starterkit for <a href="http://drupal.org/project/omega">Omega</a>. You should not directly edit this starterkit, but make your own copy. Information on this can be found in the <a href="http://himer.us/omega-docs">Omega Documentation</a>.',
        'core' => '7.x',
        'engine' => 'phptemplate',
        'screenshot' => 'screenshot.png',
        'base theme' => 'omega',
        'hidden' => true,
        'starterkit' => true,
        'regions' => 
        array (
          'page_top' => 'Page Top',
          'page_bottom' => 'Page Bottom',
          'content' => 'Content',
          'user_first' => 'User Bar First',
          'user_second' => 'User Bar Second',
          'branding' => 'Branding',
          'menu' => 'Menu',
          'sidebar_first' => 'Sidebar First',
          'sidebar_second' => 'Sidebar Second',
          'header_first' => 'Header First',
          'header_second' => 'Header Second',
          'preface_first' => 'Preface First',
          'preface_second' => 'Preface Second',
          'preface_third' => 'Preface Third',
          'postscript_first' => 'Postscript First',
          'postscript_second' => 'Postscript Second',
          'postscript_third' => 'Postscript Third',
          'postscript_fourth' => 'Postscript Fourth',
          'footer_first' => 'Footer First',
          'footer_second' => 'Footer Second',
        ),
        'zones' => 
        array (
          'user' => 'User',
          'branding' => 'Branding',
          'menu' => 'Menu',
          'header' => 'Header',
          'preface' => 'Preface',
          'content' => 'Content',
          'postscript' => 'Postscript',
          'footer' => 'Footer',
        ),
        'css' => 
        array (
          'global.css' => 
          array (
            'name' => 'Your custom global styles',
            'description' => 'This file holds all the globally active custom CSS of your theme.',
            'options' => 
            array (
              'weight' => '10',
            ),
          ),
        ),
        'settings' => 
        array (
          'alpha_grid' => 'alpha_default',
          'alpha_primary_alpha_default' => 'normal',
          'alpha_responsive' => '1',
          'alpha_layouts_alpha_fluid_primary' => 'normal',
          'alpha_layouts_alpha_fluid_normal_responsive' => '0',
          'alpha_layouts_alpha_fluid_normal_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_primary' => 'normal',
          'alpha_layouts_alpha_default_fluid_responsive' => '0',
          'alpha_layouts_alpha_default_fluid_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_fluid_weight' => '0',
          'alpha_layouts_alpha_default_narrow_responsive' => '1',
          'alpha_layouts_alpha_default_narrow_media' => 'all and (min-width: 740px) and (min-device-width: 740px), (max-device-width: 800px) and (min-width: 740px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_narrow_weight' => '1',
          'alpha_layouts_alpha_default_normal_responsive' => '1',
          'alpha_layouts_alpha_default_normal_media' => 'all and (min-width: 980px) and (min-device-width: 980px), all and (max-device-width: 1024px) and (min-width: 1024px) and (orientation:landscape)',
          'alpha_layouts_alpha_default_normal_weight' => '2',
          'alpha_layouts_alpha_default_wide_responsive' => '1',
          'alpha_layouts_alpha_default_wide_media' => 'all and (min-width: 1220px)',
          'alpha_layouts_alpha_default_wide_weight' => '3',
          'alpha_viewport' => '1',
          'alpha_viewport_initial_scale' => '1',
          'alpha_viewport_min_scale' => '1',
          'alpha_viewport_max_scale' => '1',
          'alpha_viewport_user_scaleable' => '',
          'alpha_libraries' => 
          array (
            'omega_formalize' => 'omega_formalize',
            'omega_equalheights' => '',
            'omega_mediaqueries' => 'omega_mediaqueries',
          ),
          'alpha_css' => 
          array (
            'alpha-reset.css' => 'alpha-reset.css',
            'alpha-mobile.css' => 'alpha-mobile.css',
            'alpha-alpha.css' => 'alpha-alpha.css',
            'omega-text.css' => 'omega-text.css',
            'omega-branding.css' => 'omega-branding.css',
            'omega-menu.css' => 'omega-menu.css',
            'omega-forms.css' => 'omega-forms.css',
            'omega-visuals.css' => 'omega-visuals.css',
            'global.css' => 'global.css',
          ),
          'alpha_debug_block_toggle' => '1',
          'alpha_debug_block_active' => '1',
          'alpha_debug_grid_toggle' => '1',
          'alpha_debug_grid_active' => '1',
          'alpha_debug_grid_roles' => 
          array (
            1 => '1',
            2 => '2',
            3 => '3',
          ),
          'alpha_toggle_messages' => '1',
          'alpha_toggle_action_links' => '1',
          'alpha_toggle_tabs' => '1',
          'alpha_toggle_breadcrumb' => '1',
          'alpha_toggle_page_title' => '1',
          'alpha_toggle_feed_icons' => '1',
          'alpha_hidden_title' => '',
          'alpha_hidden_site_name' => '',
          'alpha_hidden_site_slogan' => '',
          'alpha_zone_user_equal_height_container' => '',
          'alpha_zone_user_wrapper' => '1',
          'alpha_zone_user_force' => '',
          'alpha_zone_user_section' => 'header',
          'alpha_zone_user_weight' => '1',
          'alpha_zone_user_columns' => '12',
          'alpha_zone_user_primary' => '',
          'alpha_zone_user_css' => '',
          'alpha_zone_user_wrapper_css' => '',
          'alpha_zone_branding_equal_height_container' => '',
          'alpha_zone_branding_wrapper' => '1',
          'alpha_zone_branding_force' => '',
          'alpha_zone_branding_section' => 'header',
          'alpha_zone_branding_weight' => '2',
          'alpha_zone_branding_columns' => '12',
          'alpha_zone_branding_primary' => '',
          'alpha_zone_branding_css' => '',
          'alpha_zone_branding_wrapper_css' => '',
          'alpha_zone_menu_equal_height_container' => '',
          'alpha_zone_menu_wrapper' => '1',
          'alpha_zone_menu_force' => '',
          'alpha_zone_menu_section' => 'header',
          'alpha_zone_menu_weight' => '3',
          'alpha_zone_menu_columns' => '12',
          'alpha_zone_menu_primary' => '',
          'alpha_zone_menu_css' => '',
          'alpha_zone_menu_wrapper_css' => '',
          'alpha_zone_header_equal_height_container' => '',
          'alpha_zone_header_wrapper' => '1',
          'alpha_zone_header_force' => '',
          'alpha_zone_header_section' => 'header',
          'alpha_zone_header_weight' => '4',
          'alpha_zone_header_columns' => '12',
          'alpha_zone_header_primary' => '',
          'alpha_zone_header_css' => '',
          'alpha_zone_header_wrapper_css' => '',
          'alpha_zone_preface_equal_height_container' => '',
          'alpha_zone_preface_wrapper' => '1',
          'alpha_zone_preface_force' => '',
          'alpha_zone_preface_section' => 'content',
          'alpha_zone_preface_weight' => '1',
          'alpha_zone_preface_columns' => '12',
          'alpha_zone_preface_primary' => '',
          'alpha_zone_preface_css' => '',
          'alpha_zone_preface_wrapper_css' => '',
          'alpha_zone_content_equal_height_container' => '',
          'alpha_zone_content_wrapper' => '1',
          'alpha_zone_content_force' => '1',
          'alpha_zone_content_section' => 'content',
          'alpha_zone_content_weight' => '2',
          'alpha_zone_content_columns' => '12',
          'alpha_zone_content_primary' => 'content',
          'alpha_zone_content_css' => '',
          'alpha_zone_content_wrapper_css' => '',
          'alpha_zone_postscript_equal_height_container' => '',
          'alpha_zone_postscript_wrapper' => '1',
          'alpha_zone_postscript_force' => '',
          'alpha_zone_postscript_section' => 'content',
          'alpha_zone_postscript_weight' => '3',
          'alpha_zone_postscript_columns' => '12',
          'alpha_zone_postscript_primary' => '',
          'alpha_zone_postscript_css' => '',
          'alpha_zone_postscript_wrapper_css' => '',
          'alpha_zone_footer_equal_height_container' => '',
          'alpha_zone_footer_wrapper' => '1',
          'alpha_zone_footer_force' => '',
          'alpha_zone_footer_section' => 'footer',
          'alpha_zone_footer_weight' => '1',
          'alpha_zone_footer_columns' => '12',
          'alpha_zone_footer_primary' => '',
          'alpha_zone_footer_css' => '',
          'alpha_zone_footer_wrapper_css' => '',
          'alpha_region_dashboard_sidebar_equal_height_container' => '',
          'alpha_region_dashboard_sidebar_equal_height_element' => '',
          'alpha_region_dashboard_sidebar_force' => '',
          'alpha_region_dashboard_sidebar_zone' => '',
          'alpha_region_dashboard_sidebar_prefix' => '',
          'alpha_region_dashboard_sidebar_columns' => '1',
          'alpha_region_dashboard_sidebar_suffix' => '',
          'alpha_region_dashboard_sidebar_weight' => '-50',
          'alpha_region_dashboard_sidebar_css' => '',
          'alpha_region_dashboard_inactive_equal_height_container' => '',
          'alpha_region_dashboard_inactive_equal_height_element' => '',
          'alpha_region_dashboard_inactive_force' => '',
          'alpha_region_dashboard_inactive_zone' => '',
          'alpha_region_dashboard_inactive_prefix' => '',
          'alpha_region_dashboard_inactive_columns' => '1',
          'alpha_region_dashboard_inactive_suffix' => '',
          'alpha_region_dashboard_inactive_weight' => '-50',
          'alpha_region_dashboard_inactive_css' => '',
          'alpha_region_dashboard_main_equal_height_container' => '',
          'alpha_region_dashboard_main_equal_height_element' => '',
          'alpha_region_dashboard_main_force' => '',
          'alpha_region_dashboard_main_zone' => '',
          'alpha_region_dashboard_main_prefix' => '',
          'alpha_region_dashboard_main_columns' => '1',
          'alpha_region_dashboard_main_suffix' => '',
          'alpha_region_dashboard_main_weight' => '-50',
          'alpha_region_dashboard_main_css' => '',
          'alpha_region_user_first_equal_height_container' => '',
          'alpha_region_user_first_equal_height_element' => '',
          'alpha_region_user_first_force' => '',
          'alpha_region_user_first_zone' => 'user',
          'alpha_region_user_first_prefix' => '',
          'alpha_region_user_first_columns' => '8',
          'alpha_region_user_first_suffix' => '',
          'alpha_region_user_first_weight' => '1',
          'alpha_region_user_first_css' => '',
          'alpha_region_user_second_equal_height_container' => '',
          'alpha_region_user_second_equal_height_element' => '',
          'alpha_region_user_second_force' => '',
          'alpha_region_user_second_zone' => 'user',
          'alpha_region_user_second_prefix' => '',
          'alpha_region_user_second_columns' => '4',
          'alpha_region_user_second_suffix' => '',
          'alpha_region_user_second_weight' => '2',
          'alpha_region_user_second_css' => '',
          'alpha_region_branding_equal_height_container' => '',
          'alpha_region_branding_equal_height_element' => '',
          'alpha_region_branding_force' => '1',
          'alpha_region_branding_zone' => 'branding',
          'alpha_region_branding_prefix' => '',
          'alpha_region_branding_columns' => '12',
          'alpha_region_branding_suffix' => '',
          'alpha_region_branding_weight' => '1',
          'alpha_region_branding_css' => '',
          'alpha_region_menu_equal_height_container' => '',
          'alpha_region_menu_equal_height_element' => '',
          'alpha_region_menu_force' => '1',
          'alpha_region_menu_zone' => 'menu',
          'alpha_region_menu_prefix' => '',
          'alpha_region_menu_columns' => '12',
          'alpha_region_menu_suffix' => '',
          'alpha_region_menu_weight' => '1',
          'alpha_region_menu_css' => '',
          'alpha_region_header_first_equal_height_container' => '',
          'alpha_region_header_first_equal_height_element' => '',
          'alpha_region_header_first_force' => '',
          'alpha_region_header_first_zone' => 'header',
          'alpha_region_header_first_prefix' => '',
          'alpha_region_header_first_columns' => '6',
          'alpha_region_header_first_suffix' => '',
          'alpha_region_header_first_weight' => '1',
          'alpha_region_header_first_css' => '',
          'alpha_region_header_second_equal_height_container' => '',
          'alpha_region_header_second_equal_height_element' => '',
          'alpha_region_header_second_force' => '',
          'alpha_region_header_second_zone' => 'header',
          'alpha_region_header_second_prefix' => '',
          'alpha_region_header_second_columns' => '6',
          'alpha_region_header_second_suffix' => '',
          'alpha_region_header_second_weight' => '2',
          'alpha_region_header_second_css' => '',
          'alpha_region_preface_first_equal_height_container' => '',
          'alpha_region_preface_first_equal_height_element' => '',
          'alpha_region_preface_first_force' => '',
          'alpha_region_preface_first_zone' => 'preface',
          'alpha_region_preface_first_prefix' => '',
          'alpha_region_preface_first_columns' => '4',
          'alpha_region_preface_first_suffix' => '',
          'alpha_region_preface_first_weight' => '1',
          'alpha_region_preface_first_css' => '',
          'alpha_region_preface_second_equal_height_container' => '',
          'alpha_region_preface_second_equal_height_element' => '',
          'alpha_region_preface_second_force' => '',
          'alpha_region_preface_second_zone' => 'preface',
          'alpha_region_preface_second_prefix' => '',
          'alpha_region_preface_second_columns' => '4',
          'alpha_region_preface_second_suffix' => '',
          'alpha_region_preface_second_weight' => '2',
          'alpha_region_preface_second_css' => '',
          'alpha_region_preface_third_equal_height_container' => '',
          'alpha_region_preface_third_equal_height_element' => '',
          'alpha_region_preface_third_force' => '',
          'alpha_region_preface_third_zone' => 'preface',
          'alpha_region_preface_third_prefix' => '',
          'alpha_region_preface_third_columns' => '4',
          'alpha_region_preface_third_suffix' => '',
          'alpha_region_preface_third_weight' => '3',
          'alpha_region_preface_third_css' => '',
          'alpha_region_content_equal_height_container' => '',
          'alpha_region_content_equal_height_element' => '',
          'alpha_region_content_force' => '',
          'alpha_region_content_zone' => 'content',
          'alpha_region_content_prefix' => '',
          'alpha_region_content_columns' => '6',
          'alpha_region_content_suffix' => '',
          'alpha_region_content_weight' => '2',
          'alpha_region_content_css' => '',
          'alpha_region_sidebar_first_equal_height_container' => '',
          'alpha_region_sidebar_first_equal_height_element' => '',
          'alpha_region_sidebar_first_force' => '',
          'alpha_region_sidebar_first_zone' => 'content',
          'alpha_region_sidebar_first_prefix' => '',
          'alpha_region_sidebar_first_columns' => '3',
          'alpha_region_sidebar_first_suffix' => '',
          'alpha_region_sidebar_first_weight' => '1',
          'alpha_region_sidebar_first_css' => '',
          'alpha_region_sidebar_second_equal_height_container' => '',
          'alpha_region_sidebar_second_equal_height_element' => '',
          'alpha_region_sidebar_second_force' => '',
          'alpha_region_sidebar_second_zone' => 'content',
          'alpha_region_sidebar_second_prefix' => '',
          'alpha_region_sidebar_second_columns' => '3',
          'alpha_region_sidebar_second_suffix' => '',
          'alpha_region_sidebar_second_weight' => '3',
          'alpha_region_sidebar_second_css' => '',
          'alpha_region_postscript_first_equal_height_container' => '',
          'alpha_region_postscript_first_equal_height_element' => '',
          'alpha_region_postscript_first_force' => '',
          'alpha_region_postscript_first_zone' => 'postscript',
          'alpha_region_postscript_first_prefix' => '',
          'alpha_region_postscript_first_columns' => '3',
          'alpha_region_postscript_first_suffix' => '',
          'alpha_region_postscript_first_weight' => '1',
          'alpha_region_postscript_first_css' => '',
          'alpha_region_postscript_second_equal_height_container' => '',
          'alpha_region_postscript_second_equal_height_element' => '',
          'alpha_region_postscript_second_force' => '',
          'alpha_region_postscript_second_zone' => 'postscript',
          'alpha_region_postscript_second_prefix' => '',
          'alpha_region_postscript_second_columns' => '3',
          'alpha_region_postscript_second_suffix' => '',
          'alpha_region_postscript_second_weight' => '2',
          'alpha_region_postscript_second_css' => '',
          'alpha_region_postscript_third_equal_height_container' => '',
          'alpha_region_postscript_third_equal_height_element' => '',
          'alpha_region_postscript_third_force' => '',
          'alpha_region_postscript_third_zone' => 'postscript',
          'alpha_region_postscript_third_prefix' => '',
          'alpha_region_postscript_third_columns' => '3',
          'alpha_region_postscript_third_suffix' => '',
          'alpha_region_postscript_third_weight' => '3',
          'alpha_region_postscript_third_css' => '',
          'alpha_region_postscript_fourth_equal_height_container' => '',
          'alpha_region_postscript_fourth_equal_height_element' => '',
          'alpha_region_postscript_fourth_force' => '',
          'alpha_region_postscript_fourth_zone' => 'postscript',
          'alpha_region_postscript_fourth_prefix' => '',
          'alpha_region_postscript_fourth_columns' => '3',
          'alpha_region_postscript_fourth_suffix' => '',
          'alpha_region_postscript_fourth_weight' => '4',
          'alpha_region_postscript_fourth_css' => '',
          'alpha_region_footer_first_equal_height_container' => '',
          'alpha_region_footer_first_equal_height_element' => '',
          'alpha_region_footer_first_force' => '',
          'alpha_region_footer_first_zone' => 'footer',
          'alpha_region_footer_first_prefix' => '',
          'alpha_region_footer_first_columns' => '12',
          'alpha_region_footer_first_suffix' => '',
          'alpha_region_footer_first_weight' => '1',
          'alpha_region_footer_first_css' => '',
          'alpha_region_footer_second_equal_height_container' => '',
          'alpha_region_footer_second_equal_height_element' => '',
          'alpha_region_footer_second_force' => '',
          'alpha_region_footer_second_zone' => 'footer',
          'alpha_region_footer_second_prefix' => '',
          'alpha_region_footer_second_columns' => '12',
          'alpha_region_footer_second_suffix' => '',
          'alpha_region_footer_second_weight' => '2',
          'alpha_region_footer_second_css' => '',
        ),
        'version' => '7.x-3.1',
        'project' => 'omega',
        'datestamp' => '1329681647',
        'dependencies' => 
        array (
        ),
        'php' => '5.2.4',
      ),
      'project' => 'omega',
      'version' => '7.x-3.1',
    ),
  ),
);
# Aegir additions
$_SERVER['db_type'] = $options['db_type'];
$_SERVER['db_port'] = $options['db_port'];
$_SERVER['db_host'] = $options['db_host'];
$_SERVER['db_user'] = $options['db_user'];
$_SERVER['db_passwd'] = $options['db_passwd'];
$_SERVER['db_name'] = $options['db_name'];
