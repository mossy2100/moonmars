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
    // Member mentions

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
          $html = preg_replace("/$code_begin@($name)$code_end/i", '$1' . $member->tagLink() . '$3', $html);
        }
      }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Group references and hash tags

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
          $html = preg_replace("/$code_begin#($tag)$code_end/i", '$1' . $group->tagLink() . '$3', $html);
        }
        else {
          // Remember the tag:
          $tags[$tag] = $tag;
          // @todo Replace the tag reference with a link:
//          $html = preg_replace("/$code_begin#$tag$code_end/i", '$1' . $tag->tagLink() . '$3', $html);
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
      if (Member::equals($mentioned_member, $member)) {
        return TRUE;
      }
    }
    return FALSE;
  }

}
