<article<?php print $attributes; ?> xmlns="http://www.w3.org/1999/html">

  <div class='user-picture'>
    <?php print $picture; ?>
  </div>

  <div class='post-content-wrapper' <?php print $content_attributes; ?>>
    <div class='post-content'>
      <?php
      echo $username;
      echo $created_datetime;

      // Hide links now so we can render them later.
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

  <div class='post-controls'>
    <?php if (user_is_logged_in()) { ?>
    <div class='rating-buttons'>
      <a class='rating-button rating-button-warning' href='javascript:rateComment("report")' title='Report (-2 points)'></a>
      <a class='rating-button rating-button-dislike' href='javascript:rateComment("dislike")' title='Dislike (-1 point)'></a>
      <a class='rating-button rating-button-meh' href='javascript:rateComment("meh")' title='Meh (0 points)'></a>
      <a class='rating-button rating-button-like' href='javascript:rateComment("like")' title='Like (1 point)'></a>
      <a class='rating-button rating-button-love' href='javascript:rateComment("favourite")' title='Favourite (2 points)'></a>
    </div>
    <?php } ?>

    <div class='post-score-wrapper'>
      Score: <span class='post-score'><?php echo $score; ?></span>
    </div>

    <?php if (!empty($content['links'])): ?>
      <nav class="links post-links clearfix"><?php print render($content['links']); ?></nav>
    <?php endif; ?>
  </div> <!-- /post-controls -->

</article>
