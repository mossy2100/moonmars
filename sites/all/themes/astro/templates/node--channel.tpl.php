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
    // If the logged-in member can post items in this channel, show the new item form.
    if ($current_member && $current_member->canPostItem($channel)) {
      ?>
      <div class='post-form-wrapper'>
        <h2>Share something</h2>

        <div class='post-article-body'>

          <div class='user-picture'>
            <?php echo $current_member->avatarTooltip(); ?>
          </div>

          <div class='post-content-wrapper' <?php print $content_attributes; ?>>
            <div class='post-content'>

              <div class='who_where_when_posted'>
                <?php
                // Current member's username with link and tooltip:
                echo $current_member->tooltipLink();
                ?>
              </div>

              <?php
              // Remember that we're on a channel page:
              $GLOBALS['channel_nid'] = $channel->nid();

              // New item form:
              echo render(node_add('item'));
              ?>

            </div>
          </div>

        </div>
      </div>
      <?php
    } ?>

    <?php
    // Channel items:
    echo $items;
    ?>

  </div>

</article>