<?php

/**
 * @file
 * Default theme implementation to provide an HTML container for comments.
 *
 * Available variables:
 * - $content: The array of content-related elements for the node. Use
 *   render($content) to print them all, or
 *   print a subset such as render($content['comment_form']).
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default value has the following:
 *   - comment-wrapper: The current template type, i.e., "theming hook".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * The following variables are provided for contextual information.
 * - $node: Node object the comments are attached to.
 * The constants below the variables show the possible values and should be
 * used for comparison.
 * - $display_mode
 *   - COMMENT_MODE_FLAT
 *   - COMMENT_MODE_THREADED
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess_comment_wrapper()
 * @see theme_comment_wrapper()
 */
?>
<div id="comments" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php print render($content['comments']); ?>
  <?php if ($content['comment_form']): ?>
    <?php print render($content['comment_form']); ?>
  <?php endif; ?>

  <article class="new-comment-form-article comment comment-new comment-by-viewer clearfix" data-nid="<?php echo $node->nid; ?>">
    <div class='post-article-body'>
      <div class='user-picture'>
        <div class='avatar-tooltip'>
          <a class='avatar-link' href='/users/mossy2100'><img class="avatar-icon" typeof="foaf:Image" src="http://moonmars/sites/default/files/styles/icon-40x40/public/pictures/picture-1-1333963882.jpg" width="40" height="40" alt="mossy2100" /></a>
          <div class='user-tooltip' title='Visit mossy2100&apos;s profile'><img class="avatar-icon" typeof="foaf:Image" src="http://moonmars/sites/default/files/styles/icon-40x40/public/pictures/picture-1-1333963882.jpg" width="40" height="40" alt="mossy2100" /><div class='user-tooltip-text'><strong>mossy2100</strong><br>Shaun Moss<br>M/41</div></div>
        </div>
      </div>

      <div class='post-content-wrapper'>
        <div class='post-content'>
          <a class='username' href='/users/mossy2100' title='Visit mossy2100&apos;s profile.'>mossy2100</a><time>now</time>
          <form class='comment-form new-comment-form'>
            <textarea class='new-comment-textarea'></textarea>
            <div class='new-comment-controls'>
              <input data-nid='<?php echo $node->nid; ?>' class='new-comment-button' type='button' value='Post'>
            </div>
          </form>
        </div>
      </div>
    </div>
  </article>

</div>
