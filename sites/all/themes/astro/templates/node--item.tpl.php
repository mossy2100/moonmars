<article<?php print $attributes; ?> data-nid='<?php echo $node->nid; ?>'>

  <div class='post-article-body'>

    <div class='user-picture'>
      <?php echo $avatar; ?>
    </div>

    <div class='post-content-wrapper' <?php echo $content_attributes; ?>>
      <div class='post-content'>

        <div class='who_where_when_posted'>
          <?php
          // Who, where and when the item was posted:
          echo $poster->tooltipLink() . " $item_channel_string $created_datetime";
          ?>
        </div>

        <?php
        // Hide comments and links now so we can render them later.
        hide($content['comments']);
        hide($content['links']);
        echo render($content);
        ?>
      </div>
    </div>

    <?php
    /*
    <div class='score-more-wrapper'>
      <div class='more-link-wrapper'>
        <a href='javascript:void(0)' class='more-link'>Read more <span class='expand-icon'>&#x25BC;</span></a>
      </div>
      <div class='post-score-wrapper'>
        Score: <span class='post-score'><?php echo $score; ?></span>
      </div>
    </div> <!-- /score-more-wrapper -->
    */
    ?>

    <div class='post-controls top-post-controls'>

      <?php
      echo $rating_buttons;
      ?>

      <div class='post-score-wrapper'>
        Score: <span class='post-score score-node-<?php echo $item->nid(); ?>'><?php echo $score; ?></span>
      </div>

      <?php
      // Top links for comment/edit/delete/remove item:
      echo $links1;
      ?>

    </div> <!-- /post-controls -->

    <?php
    // Comments:
    echo $comments;

    // Bottom comment link:
    echo $links2;
    ?>

    <?php
      // New comment form:
      if ($current_member && $current_member->canPostComment($item)) {
      ?>
      <article id="new-comment-form-article-<?php echo $node->nid; ?>" class="new-comment-form-article comment comment-new comment-by-viewer clearfix" data-nid="<?php echo $node->nid; ?>">
        <div class='post-article-body' <?php echo $current_member->commentStyle(); ?>>
          <div class='user-picture'>
            <?php echo $current_member->avatarTooltip(); ?>
          </div>
          <div class='post-content-wrapper'>
            <div class='post-content'>

              <div class='who_where_when_posted'>
                <?php echo $current_member->tooltipLink(); ?>
              </div>

              <form class='comment-form new-comment-form clearfix'>
                <textarea class='new-comment-textarea'></textarea>
                <div class='comment-buttons'>
                  <input data-nid='<?php echo $node->nid; ?>' class='form-button cancel-comment-button' type='button' value='Cancel'>
                  <input data-nid='<?php echo $node->nid; ?>' class='form-button new-comment-button' type='button' value='Post'>
                </div>
                <div class='comment-description'>Write something to share.</div>
              </form>
            </div>
          </div>
        </div>
      </article>
      <?php
    }
    elseif (!$current_member && isset($parent_entity) && ($parent_entity instanceof Group) && $parent_entity->mode() == 'open') {
      // Tell the user they can comment if they login or register:
      ?>
      <p class='comment-instruction'>
        <a href='/login?destination=<?php echo $parent_entity->alias(); ?>'>Login</a> or
        <a href='/register?destination=<?php echo $parent_entity->alias(); ?>'>register</a>
        to <!-- rate and --> post comments.
      </p>
      <?php
    }
    ?>

  </div>

</article>
