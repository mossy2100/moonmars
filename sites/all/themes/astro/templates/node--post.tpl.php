<article<?php print $attributes; ?>>

  <div class='article-body'>
    <div class='user-picture'>
      <?php print $picture; ?>
    </div>

    <div class='post-content-wrapper' <?php print $content_attributes; ?>>
      <div class='post-content'>
        <?php
        echo $name;
        echo $created_datetime;

        // Hide comments and links now so we can render them later.
        hide($content['comments']);
        hide($content['links']);
        print render($content);
        ?>
      </div>
    </div>

    <div class='score-more-wrapper'>
      <div class='more-link-wrapper'>
        <a href='javascript:void(0)' class='more-link'>Read more <span class='expand-icon'>&#x25BC;</span></a>
      </div>
      <div class='post-score-wrapper'>
        Score: <span class='post-score'><?php echo $score; ?></span>
      </div>
    </div> <!-- /score-more-wrapper -->

    <div class='user-content-controls'>
      <?php if (user_is_logged_in()) { ?>
      <div class='rating-buttons'>
        <a class='rating-button rating-button-warning' href='javascript:ratePost("report")' title='Report (-2 points)'></a>
        <a class='rating-button rating-button-dislike' href='javascript:ratePost("dislike")' title='Dislike (-1 point)'></a>
        <a class='rating-button rating-button-meh' href='javascript:ratePost("meh")' title='Meh (0 points)'></a>
        <a class='rating-button rating-button-like' href='javascript:ratePost("like")' title='Like (1 point)'></a>
        <a class='rating-button rating-button-love' href='javascript:ratePost("favourite")' title='Favourite (2 points)'></a>
      </div>
      <?php } ?>

      <div class='user-content-score-wrapper'>
        Score: <span class='post-score'><?php echo $score; ?></span>
      </div>

      <?php if (!empty($content['links'])): ?>
        <nav class="links post-links clearfix"><?php print render($content['links']); ?></nav>
      <?php endif; ?>
    </div> <!-- /post-controls -->
  </div>

  <?php print render($content['comments']); ?>

</article>
