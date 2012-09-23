<?php
/**
 * Encapsulates a piece of text as entered in an item or comment.
 *
 * User: shaun
 * Date: 2012-08-25
 * Time: 11:20 AM
 */
class TextScan {

  /**
   * The HTML
   *
   * @var string
   */
  protected $html;

  /**
   * Mentioned members
   *
   * @var array
   */
  protected $members;

  /**
   * Mentioned groups
   *
   * @var array
   */
  protected $groups;

  /**
   * Mentioned [hash] tags/topics (TBD)
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
    $html = $text;

    // Make URLs into links:
    $scheme = "https?:\/\/";
    $domain_name = "[a-z0-9](([a-z0-9\-\.]+)?[a-z0-9])?";
    $ip_addr = "\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}";
    $port_path_query_fragment = "[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]";
    $url_rx = "/($scheme)(($domain_name)|($ip_addr))($port_path_query_fragment)?/i";
    $html = preg_replace($url_rx, "<a href='$0' target='_blank'>$0</a>", $html);

    // Regex fragments for actor codes:
    $code_begin = "(^|[^\w-])";
    $code_end = "($|[^\w-])";
    $code = "([\w-]+)";

    // Scan for mentioned members:
    $n_members = preg_match_all("/$code_begin@$code$code_end/i", $html, $matches);
    $members = array();
    if ($n_members) {
      foreach ($matches[2] as $name) {
        // Check if we have a member with this name:
        $member = Member::createByName($name);
        if ($member) {
          // Remember the member:
          $members[$member->uid()] = $member;
          // Replace the member reference with a link:
          $html = preg_replace("/$code_begin@($name)$code_end/i", '$1' . $member->atLink() . '$3', $html);
        }
      }
    }

    // Scan for hash tags:
    $n_tags = preg_match_all("/$code_begin#$code$code_end/i", $text, $matches);
    $groups = array();
    $tags = array();
    if ($n_tags) {
      foreach ($matches[2] as $tag) {
        $group = Group::createByTag($tag);
        if ($group) {
          // Remember the group:
          $groups[$group->nid()] = $group;
          // Replace the group reference with a link:
          $html = preg_replace("/$code_begin#($tag)$code_end/i", '$1' . $group->hashLink() . '$3', $html);
        }
        else {
          // Remember the tag:
          $tags[$tag] = $tag;
          // @todo Replace the tag reference with a link:
//          $html = preg_replace("/$code_begin#$tag$code_end/i", '$1' . $tag->hashLink() . '$3', $html);
        }
      }
    }

    // Insert emoticons if requested:
    if ($emoticons) {
      $html = moonmars_text_add_emoticons($html);
    }

    // Convert newlines to break tags:
    $html = nl2br($html);

    // Set the properties:
    $this->html = $html;
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
      if (Member::equals($mentioned_member, $member)) {
        return TRUE;
      }
    }
    return FALSE;
  }

}
