<article<?php echo $attributes; ?> xmlns="http://www.w3.org/1999/html">

  <div class='post-article-body <?php echo $highlight; ?>' <?php echo $poster->commentStyle(); ?>>
    <div class='user-picture'>
      <?php echo $avatar; ?>
    </div>

    <div class='post-content-wrapper' <?php echo $content_attributes; ?>>
      <div class='post-content'>

        <div class='who_where_when_posted'>
          <?php
          // Who and when the item was posted:
          echo $poster->tooltipLink() . " $created_datetime";
          ?>
        </div>

        <?php
        // Hide the default links:
        hide($content['links']);
        echo render($content);

        // Render the edit_comment_form if present:
        if (isset($edit_comment_form)) {
          echo $edit_comment_form;
        }
        ?>
      </div>
    </div>

    <?php /*
    <div class='score-more-wrapper'>
      <div class='more-link-wrapper'>
        <a href='javascript:void(0)' class='more-link'>Read more <span class='expand-icon'>&#x25BC;</span></a>
      </div>
      <div class='score-wrapper'>
        Score: <span class='post-score'><?php echo $score; ?></span>
      </div>
    </div> <!-- /score-more-wrapper -->
    */ ?>

    <div class='post-controls top-post-controls' <?php echo $poster->commentBorderStyle(); ?>>

      <?php
      echo $rating_buttons;
      ?>

      <div class='score-wrapper'>
        Score: <span class='score score-comment-<?php echo $item_comment->cid(); ?>'><?php echo $score; ?></span>
      </div>

      <?php if (!$item_comment->published()) { ?>
        <div class='unpublished'>unpublished</div>
      <?php } ?>

      <?php
      // Links for edit/delete comment:
      echo $links;
      ?>

    </div> <!-- /post-controls -->

  </div>

</article>
