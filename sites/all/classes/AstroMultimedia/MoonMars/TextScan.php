<?php
namespace AstroMultimedia\MoonMars;

/**
 * Encapsulates a piece of text as entered in an item or comment.
 *
 * User: shaun
 * Date: 2012-08-25
 * Time: 11:20 AM
 */
class TextScan {

  /**
   * The original text.
   *
   * @var string
   */
  protected $text;

  /**
   * The HTML version of the provided text.
   *
   * @var string
   */
  protected $html;

  /**
   * Mentioned URLs.
   *
   * @var array
   */
  protected $urls;

  /**
   * Mentioned stars.
   *
   * @var array
   */
  protected $stars;

  /**
   * Constructor
   *
   * @param string $text
   * @param bool $emoticons
   */
  public function __construct($text, $emoticons = TRUE) {
    // Remember the provided text:
    $this->text = $text;

    // Substitute emoticons with placeholders that can't be interpreted as HTML:
    if ($emoticons) {
      foreach (moonmars_text_emoticons() as $emoticon_name => $emoticon_code) {
        $text = str_replace($emoticon_code, "[[$emoticon_name]]", $text);
      }
    }

    // Convert to HTML entities:
    $html = moonmars_text_html_entities($text);

    // Convert URLs to links:
    $links = moonmars_text_embed_links($html);
    $html = $links['html'];
    $urls = $links['urls'];

    $stars = array();

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Member tags

    // Regex fragments for star tags:
    $rx_tag_begin = "(^|[^\w-])";
    $rx_tag_end = "($|[^\w-])";
    $rx_tag = "([\w-]+)";

    // Scan for member tags:
    $n_members = preg_match_all("/$rx_tag_begin" . Member::TAG_PREFIX . "$rx_tag$rx_tag_end/i", $html, $matches);
    if ($n_members) {
      foreach ($matches[2] as $tag) {
        // Check if we have a member with this tag:
        $member = Member::findByTag($tag);
        if ($member) {
          // Remember the member:
          $stars[$member->uid()] = $member;
          // Replace the member mention with a link:
          $html = preg_replace("/$rx_tag_begin" . Member::TAG_PREFIX . "($tag)$rx_tag_end/i", '$1' . $member->tagLink() . '$3', $html);
        }
      }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Group tags

    // Scan for tags:
    $n_groups = preg_match_all("/$rx_tag_begin" . Group::TAG_PREFIX . "$rx_tag$rx_tag_end/i", $html, $matches);
    if ($n_groups) {
      foreach ($matches[2] as $tag) {
        // Check if we have a group with this tag:
        $group = Group::findByTag($tag);
        if ($group) {
          // Remember the group:
          $stars[$group->nid()] = $group;
          // Replace the group mention with a link:
          $html = preg_replace("/$rx_tag_begin" . Group::TAG_PREFIX . "($tag)$rx_tag_end/i", '$1' . $group->tagLink() . '$3', $html);
        }
      }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Topic tags

    // Scan for tags:
    $n_topics = preg_match_all("/$rx_tag_begin" . Topic::TAG_PREFIX . "$rx_tag$rx_tag_end/i", $html, $matches);
    if ($n_topics) {
      foreach ($matches[2] as $tag) {
        // Check if we have a topic with this tag:
        $topic = Topic::findByTag($tag);
        if ($topic) {
          // Remember the topic:
          $stars[$topic->nid()] = $topic;
          // Replace the topic mention with a link:
          $html = preg_replace("/$rx_tag_begin" . Topic::TAG_PREFIX . "($tag)$rx_tag_end/i", '$1' . $topic->tagLink() . '$3', $html);
        }
      }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Emoticons, symbols, newlines

    // Replace emoticon placeholders with images:
    if ($emoticons) {
      global $base_url;
      $emoticon_path = $base_url . '/' . drupal_get_path('theme', 'astro') . '/images/emoticons';
      foreach (moonmars_text_emoticons() as $emoticon_name => $emoticon_code) {
        $html = str_replace("[[$emoticon_name]]", "<img class='emoticon' src='$emoticon_path/$emoticon_name.png'>", $html);
      }
    }

    // Convert newlines to break tags:
    $html = nl2br($html);

    // Set the properties:
    $this->html = $html;
    $this->urls = $urls;
    $this->stars = $stars;
  }

  /**
   * Get the text as HTML.
   *
   * @return string
   */
  public function html() {
    return $this->html;
  }

  /**
   * Get the URLs mentioned in the item text.
   *
   * @return array
   */
  public function urls() {
    return $this->urls;
  }

//  /**
//   * Get the members mentioned in the item text.
//   *
//   * @return array
//   */
//  public function members() {
//    return $this->members;
//  }
//
//  /**
//   * Get the groups mentioned in the item text.
//   *
//   * @return array
//   */
//  public function groups() {
//    return $this->groups;
//  }
//
//  /**
//   * Get the topics mentioned in the item text.
//   *
//   * @return array
//   */
//  public function topics() {
//    return $this->topics;
//  }

  /**
   * Checks if the text mentions an star.
   *
   * @param IStar $star
   * @return bool
   */
  public function mentions(IStar $star) {
    $mentioned_stars = $this->stars();
    foreach ($mentioned_stars as $mentioned_star) {
      if ($star->equals($mentioned_star)) {
        return TRUE;
      }
    }
    return FALSE;
  }

}
