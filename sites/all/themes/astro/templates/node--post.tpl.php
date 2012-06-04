<article<?php print $attributes; ?>>

  <div class='user-picture'>
    <?php print $picture; ?>
  </div>

  <div class='comment-content-wrapper' <?php print $content_attributes; ?>>
    <div class='comment-content'>
      <?php
      echo $username;
      echo $comment_datetime;
      hide($content['links']);
      echo render($content);
      ?>
    </div>
  </div>

  <div class="clearfix">
    <?php if (!empty($content['links'])): ?>
      <nav class="links node-links clearfix"><?php print render($content['links']); ?></nav>
    <?php endif; ?>

    <?php print render($content['comments']); ?>
  </div>
</article>