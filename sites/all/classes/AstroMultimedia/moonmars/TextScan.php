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
   * Mentioned members.
   *
   * @var array
   */
  protected $members;

  /**
   * Mentioned groups.
   *
   * @var array
   */
  protected $groups;

  /**
   * Mentioned tags.
   *
   * @var array
   */
  protected $tags;

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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Member tags

    // Regex fragments for actor tags:
    $rx_tag_begin = "(^|[^\w-])";
    $rx_tag_end = "($|[^\w-])";
    $rx_tag = "([\w-]+)";

    // Scan for member tags:
    $n_members = preg_match_all("/$rx_tag_begin" . Member::TAG_PREFIX . "$rx_tag$rx_tag_end/i", $html, $matches);
    $members = array();
    if ($n_members) {
      foreach ($matches[2] as $tag) {
        // Check if we have a member with this tag:
        $member = Member::createByName($tag);
        if ($member) {
          // Remember the member:
          $members[$member->uid()] = $member;
          // Replace the member reference with a link:
          $html = preg_replace("/$rx_tag_begin" . Member::TAG_PREFIX . "($tag)$rx_tag_end/i", '$1' . $member->tagLink() . '$3', $html);
        }
      }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Group tags

    // Scan for tags:
    $n_groups = preg_match_all("/$rx_tag_begin" . Group::TAG_PREFIX . "$rx_tag$rx_tag_end/i", $html, $matches);
    $groups = array();
    if ($n_groups) {
      foreach ($matches[2] as $tag) {
        // Check if we have a group with this tag:
        $group = Group::createByTag($tag);
        if ($group) {
          // Remember the group:
          $groups[$group->nid()] = $group;
          // Replace the group reference with a link:
          $html = preg_replace("/$rx_tag_begin" . Group::TAG_PREFIX . "($tag)$rx_tag_end/i", '$1' . $group->tagLink() . '$3', $html);
        }
      }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Topic tags

// @todo Since this code is a repeat of above, refactor it into a method that can be used for member, group and topic tags.
//    // Scan for tags:
//    $n_topics = preg_match_all("/$rx_tag_begin" . Topic::TAG_PREFIX . "$rx_tag$rx_tag_end/i", $html, $matches);
//    $topics = array();
//    if ($n_topics) {
//      foreach ($matches[2] as $tag) {
//        // Check if we have a topic with this tag:
//        $topic = Topic::createByTag($tag);
//        if ($topic) {
//          // Remember the topic:
//          $topics[$topic->nid()] = $topic;
//          // Replace the topic reference with a link:
//          $html = preg_replace("/$rx_tag_begin" . Topic::TAG_PREFIX . "($tag)$rx_tag_end/i", '$1' . $topic->tagLink() . '$3', $html);
//        }
//      }
//    }

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
    $this->members = $members;
    $this->groups = $groups;
    $this->tags = $tags;
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

  /**
   * Get the members mentioned in the item text.
   *
   * @return array
   */
  public function members() {
    return $this->members;
  }

  /**
   * Get the groups mentioned in the item text.
   *
   * @return array
   */
  public function groups() {
    return $this->groups;
  }

  /**
   * Get the tags mentioned in the item text.
   *
   * @return array
   */
  public function tags() {
    return $this->tags;
  }

  /**
   * Checks if the text mentions a member.
   *
   * @param Member $member
   * @return bool
   */
  public function mentions(Member $member) {
    $mentioned_members = $this->members();
    foreach ($mentioned_members as $mentioned_member) {
      if ($member->equals($mentioned_member)) {
        return TRUE;
      }
    }
    return FALSE;
  }

}
