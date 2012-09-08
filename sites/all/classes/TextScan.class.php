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

    // Scan for mentioned members:
    $n_members = preg_match_all("/(^|\s)\@([a-z0-9\_\-]+)\b/i", $html, $matches);
    $members = array();
    if ($n_members) {
      foreach ($matches[2] as $name) {
        // Check if we have a member with this name:
        $member = Member::searchByName($name);
        if ($member) {
          $members[$member->uid()] = $member;
          $html = preg_replace("/(^|\s)(\@$name)\b/i", "$1" . $member->link(), $html);
        }
      }
    }

//  // Scan for hash tags:
//  $n_tags = preg_match_all("/(^|\s)\@([a-z0-9\_\-]+)\b/i", $text, $matches);
    $tags = array();
//  if ($n_tags) {
//    $html = $text;
//    foreach ($matches[2] as $name) {
//      // Check if we have a tag with this name:
//      $tag = Member::create($name);
//      if ($tag) {
//        $tags[$tag->uid()] = $tag;
//        $html = preg_replace("/(^|\s)(\@$name)\b/i", "$1" . $tag->link(NULL, TRUE), $html);
//      }
//    }
//  }

    // Scan for mentioned groups:
    $n_groups = preg_match_all("/\[([^\]]+)\]/", $text, $matches);
    $groups = array();
    if ($n_groups) {
      foreach ($matches[1] as $group_title) {
        $group = Group::createByTitle($group_title);
        if ($group) {
          $groups[$group->nid()] = $group;
          $html = str_replace("[$group_title]", $group->link(), $html);
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
   * Checks if an item mentions a member.
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
