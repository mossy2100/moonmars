<article<?php print $attributes; ?> data-nid='<?php echo $node->nid; ?>'>

  <div class='post-article-body'>
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

<!--      --><?php //if (!empty($content['links'])): ?>
<!--        <nav class="links post-links clearfix">--><?php //print render($content['links']); ?><!--</nav>-->
<!--      --><?php //endif; ?>

    </div> <!-- /post-controls -->
  </div>

  <?php print render($content['comments']); ?>

  <!-- new comment form -->
  <?php
  if (isset($group)) {
    if ($user && $user->uid) {
      if (moonmars_groups_is_member($group, $user)) {
        ?>
        <article class="new-comment-form-article comment comment-new comment-by-viewer clearfix" data-nid="<?php echo $node->nid; ?>">
          <div class='post-article-body'>
            <div class='user-picture'>
              <?php echo $new_comment_picture; ?>
            </div>
            <div class='post-content-wrapper'>
              <div class='post-content'>
                <?php
                echo $new_comment_username;
                echo $new_comment_created_datetime;
                ?>
                <form class='comment-form new-comment-form clearfix'>
                  <textarea class='new-comment-textarea'></textarea>
                  <div class='new-comment-controls'>
                    <input data-nid='<?php echo $node->nid; ?>' class='new-comment-button' type='button' value='Post'>
                  </div>
                  <div class='comment-description'>Write something to share.</div>
                </form>
              </div>
            </div>
          </div>
        </article>
        <?php
      }
      else {
        ?>
        <p class='comment-instruction'>Join the group to rate and post comments.</p>
        <?php
      }
    }
    else {
      ?>
      <p class='comment-instruction'>
        <a href='/user?destination=<?php echo drupal_get_path_alias("node/$node->nid"); ?>'>Login</a> or
        <a href='/user/register?destination=<?php echo drupal_get_path_alias("node/$node->nid"); ?>'>register</a>
        to rate and post comments.
      </p>
      <?php
    }
  }
  ?>

</article>
