<?php
// Display the add item form and the channel.

// Get the node_add() function:
require_once DRUPAL_ROOT . '/' . drupal_get_path('module', 'node') . '/node.pages.inc';

?>
<article<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php if (!$page && $title): ?>
  <header>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
  </header>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <div<?php print $content_attributes; ?>>

    <?php
    if (moonmars_items_can_post()) {
      ?>
      <div class='post-form-wrapper'>
        <h2>Share something</h2>

        <div class='post-article-body'>

          <div class='user-picture'>
            <?php echo $new_item_picture; ?>
          </div>

          <div class='post-content-wrapper' <?php print $content_attributes; ?>>
            <div class='post-content'>
              <?php echo $new_item_username; ?>
              <?php echo render(node_add('item')); ?>
            </div>
          </div>
        </div>
      </div>
      <?php
    } ?>

    <?php echo $items; ?>

  </div>

</article>
