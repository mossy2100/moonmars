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
   * Mentioned actors.
   *
   * @var array
   */
  protected $actors;

  /**
   * Constructor
   *
   * @param string $text
   * @param bool $emoticons
   */
  public function __construct($text, $emoticons = TRUE) {
    // Remember the provided text:
    $this->text = $text;

    // Convert to HTML entities:
    $html = moonmars_text_html_entities($text);

    // Convert URLs to links:
    $links = moonmars_text_embed_links($html);
    $html = $links['html'];
    $urls = $links['urls'];

    $actors = array();

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Member tags

    // Regex fragments for actor tags:
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
          $actors[$member->uid()] = $member;
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
          $actors[$group->nid()] = $group;
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
          $actors[$topic->nid()] = $topic;
          // Replace the topic mention with a link:
          $html = preg_replace("/$rx_tag_begin" . Topic::TAG_PREFIX . "($tag)$rx_tag_end/i", '$1' . $topic->tagLink() . '$3', $html);
        }
      }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Emoticons, symbols, newlines

    // Insert emoticons if requested:
    if ($emoticons) {
      $html = moonmars_text_add_emoticons($html);
    }

    // Convert newlines to break tags:
    $html = nl2br($html);

    // Set the properties:
    $this->html = $html;
    $this->urls = $urls;
    $this->actors = $actors;
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
   * Checks if the text mentions an actor.
   *
   * @param IActor $actor
   * @return bool
   */
  public function mentions(IActor $actor) {
    $mentioned_actors = $this->actors();
    foreach ($mentioned_actors as $mentioned_actor) {
      if ($actor->equals($mentioned_actor)) {
        return TRUE;
      }
    }
    return FALSE;
  }

}
