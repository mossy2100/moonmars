<?php
if ($page) {
  // Display the channel when viewing the group node in its own page.

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

      <div class='post-form-wrapper'>
        <?php echo render(node_add('item')); ?>
      </div>

      <div class='group-channel'>
        <?php echo views_embed_view('channel', 'page_1', $node->nid); ?>
      </div>

    </div>

  </article>
  <?php
}
else {
  // Default node display for viewing the node in a block or a view:
  ?>
  <article<?php print $attributes; ?>>
    <?php print $user_picture; ?>
    <?php print render($title_prefix); ?>
    <?php if (!$page && $title): ?>
    <header>
      <h2<?php print $title_attributes; ?>><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
    </header>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    <?php if ($display_submitted): ?>
    <footer class="submitted"><?php print $date; ?> -- <?php print $name; ?></footer>
    <?php endif; ?>

    <div<?php print $content_attributes; ?>>
      <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print render($content);
      ?>
    </div>

    <div class="clearfix">
      <?php if (!empty($content['links'])): ?>
      <nav class="links node-links clearfix"><?php print render($content['links']); ?></nav>
      <?php endif; ?>

      <?php print render($content['comments']); ?>
    </div>
  </article>
  <?php
}
?>
