<article<?php print $attributes; ?> xmlns="http://www.w3.org/1999/html">

  <div class='post-article-body'>
    <div class='user-picture'>
      <?php print $picture; ?>
    </div>

    <div class='post-content-wrapper' <?php print $content_attributes; ?>>
      <div class='post-content'>

        <div class='who_where_when_posted'>
          <?php echo $username; ?>
          <?php echo $created_datetime; ?>
        </div>

        <?php
        // Hide links now so we can render them later.
        hide($content['links']);
        print render($content);

        // Render the edit_comment_form if present:
        if (isset($edit_comment_form)) {
          echo $edit_comment_form;
        }
        ?>
      </div>
    </div>

    <div class='score-more-wrapper'>
      <div class='more-link-wrapper'>
        <a href='javascript:void(0)' class='more-link'>Read more <span class='expand-icon'>&#x25BC;</span></a>
      </div>
<!--      <div class='post-score-wrapper'>-->
<!--        Score: <span class='post-score'>--><?php //echo $score; ?><!--</span>-->
<!--      </div>-->
    </div> <!-- /score-more-wrapper -->

    <?php /*
    <div class='post-controls'>
      <?php if (user_is_logged_in()) { ?>
        <div class='rating-buttons'>
          <input type='button' class='rating-button rating-button-warning' data-rating='warning' title='Warning (-2 points)'>
          <input type='button' class='rating-button rating-button-dislike' data-rating='dislike' title='Dislike (-1 point)'>
          <input type='button' class='rating-button rating-button-indifferent' data-rating='indifferent' title='Meh (0 points)'>
          <input type='button' class='rating-button rating-button-like' data-rating='like' title='Like (1 point)'>
          <input type='button' class='rating-button rating-button-favourite' data-rating='favourite' title='Favourite (2 points)'>
        </div>
      <?php } ?>

      <div class='post-score-wrapper'>
        Score: <span class='post-score'><?php echo $score; ?></span>
      </div>

      <?php if ($user && $user->uid && !empty($content['links'])): ?>
        <nav class="links post-links clearfix"><?php print render($content['links']); ?></nav>
      <?php endif; ?>
    </div> <!-- /post-controls -->
    */ ?>

  </div>

</article>
