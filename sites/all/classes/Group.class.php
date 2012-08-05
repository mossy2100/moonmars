<?php
/**
 * Group class.
 */
class Group extends Node {

  /**
   * The node type.
   */
  const nodeType = 'group';

  /**
   * The group's channel.
   *
   * @var string
   */
  protected $channel;

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get/set

  /**
   * Get the group's channel.
   *
   * @param bool $create
   * @return int
   */
  public function channel($create = TRUE) {
    if (!isset($this->channel)) {
      $this->channel = MmcEntity::getEntityChannel('node', $this->nid(), $create);
    }
    return $this->channel;
  }

  /**
   * Get the title for the group's channel.
   *
   * @return string
   */
  public function channelTitle() {
    return 'Group: ' . $this->title();
  }

  /**
   * Get a link to the group using the channel the title.
   * Note, this produces the same result as Channel::parentEntityLink(), but sometimes you have the group object
   * rather than the channel object.
   *
   * @return string
   */
  public function channelTitleLink() {
    return $this->link($this->channelTitle());
  }

  /**
   * Get/set the description.
   *
   * @param string $description
   * @return mixed
   */
  public function description($description = NULL) {
    return $this->field('field_description', LANGUAGE_NONE, 0, 'value', $description);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Logo

  /**
   * Get the group's logo.
   *
   * @return array
   */
  public function logo() {
    $this->load();
    return isset($this->entity->field_logo[LANGUAGE_NONE][0]) ? $this->entity->field_logo[LANGUAGE_NONE][0] : NULL;
  }

  /**
   * Render the logo HTML.
   *
   * @return array
   */
  public function renderLogo($style) {
    $logo = $this->logo();
    if ($logo) {
      $image_style = array(
        'style_name' => $style,
        'path'       => $logo['uri'],
        'alt'        => $this->title(),
      );
      return theme('image_style', $image_style);
    }
    return '';
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Membership

  /**
   * Get the members of the group.
   *
   * @param int $offset
   * @param int $limit
   * @return array
   */
  public function members($offset = NULL, $limit = NULL) {
    // Get the group's members in reverse order of that in which they joined.
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('member_uid'))
      ->condition('group_nid', $this->nid())
      ->orderBy('created', 'DESC');

    // Set a limit if specified:
    if ($offset !== NULL && $limit !== NULL) {
      $q->range($offset, $limit);
    }

    $rs = $q->execute();
    $members = array();
    foreach ($rs as $rec) {
      $members[] = Member::create($rec->member_uid);
    }

    return $members;
  }

  /**
   * Get the number of members in a group.
   *
   * @return int
   */
  public function memberCount() {
    $q = db_select('view_group_has_member', 'v')
      ->fields('v', array('rid'))
      ->condition('group_nid', $this->nid());
    $rs = $q->execute();
    return $rs->rowCount();
  }

  /**
   * Check if a user is a member of the group.
   *
   * @param Member $member
   * @return bool
   */
  public function hasMember(Member $member) {
    $rels = moonmars_relationships_get_relationships('has_member', 'node', $this->nid(), 'user', $member->uid());
    return (bool) $rels;
  }

  /**
   * Check if a user is an admin of the group.
   *
   * @todo Implement has_admin relationship
   *
   * @param Member $member
   * @return bool
   */
  public function hasAdmin(Member $member) {
    return $member->uid() == 1;

//    $rels = moonmars_relationships_get_relationships('has_admin', 'node', $this->nid(), 'user', $member->uid());
//    return (bool) $rels;
  }

  /**
   * Get the newest groups created.
   *
   * @static
   * @param $n
   */
  public static function newest($n) {
    $rs = db_select('node', 'n')
      ->fields('n', array('nid'))
      ->condition('type', 'group')
      ->condition('status', 1)
      ->orderBy('created', 'DESC')
      ->range(0, $n)
      ->execute();

    $groups = array();
    foreach ($rs as $rec) {
      $groups[] = Group::create($rec->nid);
    }
    return $groups;
  }

  /**
   * Get the total number of active (published) groups.
   *
   * @static
   * @return int
   */
  public static function count() {
    return db_select('node', 'n')
      ->fields('n', array('nid'))
      ->condition('type', 'group')
      ->condition('status', 1)
      ->execute()
      ->rowCount();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Rendering

  public function renderLinks() {
    return $this->channel()->renderLinks();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Debugging

  /**
   * Debugging function.
   */
  public function dpm() {
    dpm(array(
             'object_id' => get_object_id($this),
             'entity object id' => get_object_id($this->entity),
             'nid' => $this->nid(),
             'title' => $this->title(),
        ));
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Permissions

  /**
   * Get the mode for the group.
   *
   * @return string (open, restricted, closed or announce)
   */
  public function mode() {
    return $this->field('field_group_mode');
  }

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Notification

  /***
   * Send a notification message to all the members of a group.
   *
   * @param string $summary
   * @param string $text
   * @param Member $actor
   * @param Channel $channel
   * @param Item $item
   * @param ItemComment $comment
   */
  public function notify($summary, $text = NULL, Member $actor = NULL, Channel $channel = NULL, Item $item = NULL, ItemComment $comment = NULL) {
    $members = $this->members();
    foreach ($members as $member) {
      // Notify everyone in the group except the actor:
      if (!Member::equals($member, $actor)) {
        $member->notify($summary, $text, $actor, $channel, $item, $comment);
      }
    }
  }

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Search

  /**
   * Search groups.
   *
   * @static
   * @param array $params
   */
  public static function search($params) {

    $q = db_select('view_group', 'vg')
      ->fields('vg', array('nid'));

    // Search by text:
    if (isset($params['text'])) {
      $q->condition(
        db_or()->condition('title', $params['text'], 'LIKE')
               ->condition('description', $params['text'], 'LIKE')
      );
    }

    // Search type:
    if (isset($params['types'])) {
      $q->condition('type', $params['types']);
    }

    // Search scale:
    if (isset($params['scale'])) {
      $q->condition('scale', $params['scale']);
    }

    // Get the results:
    $rs = $q->execute();
    $results = array();
    foreach ($rs as $rec) {
      $results[] = $rec->nid;
    }
    return $results;
  }


}
