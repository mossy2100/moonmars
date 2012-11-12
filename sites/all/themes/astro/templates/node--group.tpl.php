<article class='group'>
  <div class='group-description'>
    <?php
    // Group description:
    echo $description;
    ?>
  </div>

  <?php
  // Group channel:
  echo $channel->render();
  drupal_set_title($group_tag);
  ?>
</article>
