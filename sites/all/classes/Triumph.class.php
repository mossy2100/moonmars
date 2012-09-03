<?php
/**
 * User: shaun
 * Date: 2012-08-30
 * Time: 5:29 AM
 */
class Triumph {

  /**
   * The unique ID (PK).
   *
   * @var int
   */
  protected $triumphId;

  /**
   * The triumph type, e.g. new-item, update-group, etc.
   *
   * @var string
   */
  protected $triumphType;

  /**
   * When the triumph was created.
   *
   * @var StarDateTime
   */
  protected $dtCreated;

  /**
   * Whether or not notifications have been created yet.
   *
   * @var bool
   */
  protected $nxnsCreated;

  /**
   * Actors involved in the triumph.
   * Keys are actor roles. Values are entities such as Member, Group, Channel, Item, ItemComment.
   *
   * @var array
   */
  protected $actors;

  /**
   * Recipients of nxns about this triumph.
   * Keys are uids. Values are Member objects.
   *
   * @var array
   */
  protected $recipients;

  /**
   * Nxns created for about this triumph.
   * Keys are nxn_ids. Values are Nxn2 objeects.
   *
   * @var array
   */
  protected $nxns;

  /**
   * Constructor
   *
   * @param $param
   *   This maybe a triumph id for an existing one, or a triumph type for when creating a new one.
   */
  public function __construct($param) {
    if (is_uint($param)) {
      // Existing triumph:
      $this->triumphId    = (int) $param;
    }
    elseif (is_string($param)) {
      // New triumph:
      $this->triumphType  = $param;
      $this->dtCreated    = time();
      $this->nxnsCreated  = FALSE;
      $this->actors       = array();
      $this->recipients   = array();
    }
    else {
      trigger_error("Invalid parameter to Triumph constructor.", E_USER_WARNING);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Load/save

  /**
   * Load the triumph.
   */
  public function load() {
    if ($this->triumphId) {
      // Get the triumph record:
      $q = db_select('moonmars_triumph', 'mt')
        ->fields('mt')
        ->condition('triumph_id', $this->triumphId);
      $rs = $q->execute();
      $rec = $rs->fetchObject();

      if ($rec) {
        // Set properties:
        $this->triumphType  = $rec->triumph_type;
        $this->dtCreated    = new StarDateTime($rec->ts_created);
        $this->nxnsCreated  = (bool) $rec->nxns_created;
      }
      else {
        trigger_error("Triumph::load() -> Triumph $this->triumphId not found.", E_USER_WARNING);
      }
    }
    else {
      trigger_error("Triumph:load() -> Can't load the triumph without an id.", E_USER_WARNING);
    }
  }

  /**
   * Save the triumph.
   */
  public function save() {
    // Save the triumph record:
    $fields = array(
      'triumph_type' => $this->triumphType,
      'ts_created'   => $this->dtCreated->timestamp(),
      'nxns_created' => (int) $this->nxnsCreated,
    );

    if ($this->triumphId) {
      // Update an existing triumph.
      $q = db_update('moonmars_triumph')
        ->fields($fields)
        ->condition('triumph_id', $this->triumphId);
      $q->execute();

      // Delete existing triumph actor records:
      $q2 = db_delete('moonmars_triumph_actor')
        ->condition('triumph_id', $this->triumphId);
      $q2->execute();
    }
    else {
      $q = db_insert('moonmars_triumph')
        ->fields($fields);
      $this->triumphId = $q->execute();
    }

    // Insert new triumph actor records:
    foreach ($this->actors as $actor_role => $actor) {
      $actor_fields = array(
        'triumph_id'  => $this->triumphId,
        'actor_role'  => $actor_role,
        'entity_type' => $actor->entityType(),
        'entity_id'   => $actor->id(),
      );
      $q3 = db_insert('moonmars_triumph_actor')
        ->fields($actor_fields);
      $q3->execute();
    }

    return $this;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get/set

  /**
   * Get the triumph type.
   *
   * @return string
   */
  public function triumphType() {
    if (!isset($this->triumphType)) {
      $this->load();
    }

    return $this->triumphType;
  }

  /**
   * Get the triumph id.
   *
   * @return int
   */
  public function id() {
    return $this->triumphId;
  }

  /**
   * Get the datetime when the triumph was created.
   *
   * @return StarDateTime
   */
  public function dtCreated() {
    if (!isset($this->dtCreated)) {
      $this->load();
    }

    return $this->dtCreated;
  }

  /**
   * Check if the nxns have been created yet.
   *
   * @return bool
   */
  public function nxnsCreated() {
    if (!isset($this->nxnsCreated)) {
      $this->load();
    }

    return $this->nxnsCreated;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Entities

  /**
   * Get the actors.
   */
  public function actors() {
    if (!isset($this->actors) && $this->triumphId) {
      // Get the actors:
      $q = db_select('moonmars_triumph_actor', 'te')
        ->fields('te')
        ->condition('triumph_id', $this->triumphId);
      $rs = $q->execute();
      foreach ($rs as $rec) {
        $this->actors[$rec->actor_role] = MoonMarsEntity::getEntity($rec->entity_type, $rec->entity_id);
      }
    }
    return $this->actors;
  }

  /**
   * Get an actor involved in the triumph.
   *
   * @return EntityBase
   */
  public function actor($actor_role) {
    $this->actors();
    return isset($this->actors[$actor_role]) ? $this->actors[$actor_role] : NULL;
  }

  /**
   * Add an actor to the triumph.
   *
   * @param $actor_role
   * @param EntityBase $actor
   * @return Triumph
   */
  public function addActor($actor_role, $actor) {
    $this->actors[$actor_role] = $actor;
    return $this;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Recipients

  /**
   * Add a nxn recipient.
   *
   * @param Member $member
   * @return Triumph
   */
  public function addRecipient(Member $member) {
    // By using the member uid as the key, we prevent duplicates.
    $this->recipients[$member->uid()] = $member;
    return $this;
  }

  /**
   * Find nxn recipients for this triumph.
   */
  protected function findRecipients() {

    // Get the channel if relevant:
    switch ($this->triumphType) {
      case 'new-item':
        $channel = $this->actor('item')->channel();
        break;

      case 'new-comment':
        $channel = $this->actor('comment')->item()->channel();
        break;

      default:
        $channel = NULL;
    }

    // Get the channel's parent if relevant:
    $parent_entity = $channel ? $channel->parentEntity() : NULL;

    // Initialise recipients array:
    $this->recipients = array();

    // Scan through our nxn definitions looking for matching triumph types:
    $definitions = moonmars_nxn_definitions();
    foreach ($definitions as $nxn_category => $nxn_category_info) {
      foreach ($nxn_category_info['triumph types'] as $triumph_type => $triumph_type_info) {

        // Check if the triumph type matches:
        if ($this->triumphType != $triumph_type) {
          continue;
        }

        // Default to no recipient candidates:
        $candidates = NULL;

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // FILTER: Which members may want to be notified about this triumph? These are $candidates.
        // This logic spares us from checking every single member of the site, saving time before we check conditions.

        switch ($nxn_category) {
          case 'site':
            switch ($this->triumphType) {
              case 'new-member':
                // Only if the member is joining the site, not a group:
                if (!$this->actor('group')) {
                  $candidates = Nxn2::mayWant($nxn_category, $this->triumphType);
                }
                break;

              case 'new-group':
              case 'new-item':
              case 'new-comment':
                $candidates = Nxn2::mayWant($nxn_category, $this->triumphType);
                break;

              case 'new-follower':
                $candidates = array($this->actor('followee'));
                break;
            }

            break;

          case 'news':
            // If something was posted in the News channel, lookup who may wants News notifications.
            if ($channel && $channel->nid() == MOONMARS_NEWS_CHANNEL_NID) {
              $candidates = Nxn2::mayWant($nxn_category, $this->triumphType);
            }
            break;

          case 'channel':
            // The only member to consider is the one whose channel the item or comment is being posted in.
            if ($parent_entity && $parent_entity instanceof Member) {
              $candidates = array($parent_entity);
            }
            break;

          case 'followee':
            switch ($this->triumphType) {
              case 'new-item':
                $followee = $this->actor('item')->creator();
                break;

              case 'new-comment':
                $followee = $this->actor('comment')->creator();
                break;

              case 'new-member':
                // Only if the member is joining a group, not the site:
                $followee = $this->actor('group') ? $this->actor('member') : NULL;
                break;

              case 'update-member':
                $followee = $this->actor('member');
                break;

              default:
                $followee = NULL;
            }
            if ($followee) {
              $candidates = $followee->followers();
            }
            break;

          case 'group':
            switch ($this->triumphType) {
              case 'new-item':
              case 'new-comment':
                if ($parent_entity && $parent_entity instanceof Group) {
                  $group = $parent_entity;
                }
                break;

              case 'new-group':
                // Note: if the new group is not a subgroup then $group will be NULL, which is OK.
                $group = $this->actor('parent group');
                break;

              case 'new-member':
              case 'update-group':
                // Note: if the triumph type is 'new-member', but the member is joining the site, not a group, then
                // $group will be NULL, which is OK.
                $group = $this->actor('group');
                break;

              default:
                $group = NULL;
            }
            if ($group) {
              $candidates = $group->members();
            }
            break;
        } // switch nxn_category

        // If we didn't find any nxn recipient candidates yet, continue:
        if (!$candidates) {
          continue;
        }

        // Now check who really does want a nxn, based on their preferences:
        foreach ($candidates as $member) {
          // Get the member's preferences for this type of triumph in this nxn category.
          $nxn_prefs = $member->nxnPref($nxn_category, $this->triumphType);

          switch ($nxn_prefs['wants']) {

            case MOONMARS_NXN_NO:
              // Do not add member to recipients.
              // This case block is just here for completeness and readability.
              break;

            case MOONMARS_NXN_YES:
              // Add them to the recipients:
              $this->addRecipient($member);
              break;

            case MOONMARS_NXN_SOME:
              // Check the conditions:
              $selected_conditions = array_keys(array_filter($nxn_prefs['conditions']));
              foreach ($selected_conditions as $nxn_condition) {
                switch ($nxn_condition) {
                  case 'country':
                    // Applies to triumph types: new-member
                    // Notify the member of the new member is from the same country as them.
                    if ($this->actor('member')->countryCode() == $member->countryCode()) {
                      $this->addRecipient($member);
                    }
                    break;

                  case 'event':
                  case 'project':
                    // Applies to triumph types: new-group
                    // Notify the member if the group type matches.
                    // Could be extended to all group types.
                    if ($this->actor('group')->groupType() == $nxn_condition) {
                      $this->addRecipient($member);
                    }
                    break;

                  case 'mention':
                    // Applies to triumph types: new-item, new-comment
                    $actor_role = substr($this->triumphType, 4);
                    if ($this->actors[$actor_role]->textScan()->mentions($member)) {
                      $this->addRecipient($member);
                    }
                    break;

                  case 'topic':
                    // Applies to triumph types: new-group, new-item, new-comment
                    // @todo
      //              $actor_role = substr($this->triumphType, 4);
                    //        if ($this->actors[$actor_role]->matchesMemberTopics($member)) {
                    //         $this->addRecipient($member);
                    //        }
                    break;

                  case 'item':
                    // Applies to triumph types: new-comment
                    // Applies to new comments.
                    // Notify the member if the comment is on an item they posted:
                    if ($this->actor('comment')->item()->uid() == $member->uid()) {
                      $this->addRecipient($member);
                    }
                    break;

                  case 'comment':
                    // Applies to triumph types: new-comment
                    // Notify the member if the comment is on an item they've commented on:
                    if ($member->commentedOn($this->actor('comment')->item())) {
                      $this->addRecipient($member);
                    }
                    break;

                } // switch conditions
              } // foreach
              break;

          } // switch wants
        } // foreach members
      } // for each triumph type
    } // for each nxn category
  } // findRecipients

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Notifications

  /**
   * Create the nxn records for this triumph.
   */
  public function createNxns() {
    foreach ($this->recipients as $recipient) {
      $nxn = new Nxn2($this, $recipient);
      $nxn->save();
    }
    $this->nxnsCreated = TRUE;
  }

  /**
   * Get the nxns. Do I need this? Do I even need the nxn array?
   *
   * @return array
   */
  public function nxns() {
    if (!isset($this->nxns) && $this->triumphId) {
      // Get the nxns:
      $q = db_select('moonmars_nxn', 'nxn')
        ->fields('nxn', array('nxn_id'))
        ->condition('triumph_id', $this->triumphId);
      $rs = $q->execute();
      foreach ($rs as $rec) {
        $this->nxns[$rec->nxn_id] = new Nxn2($rec->nxn_id);
      }
    }
    return $this->nxns;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // High-level static methods for creating new Triumphs and associated notifications.

  /**
   * Create a new-member triumph.
   *
   * @static
   * @param Member $member
   * @param Group $group
   *   The group when a member joins a group, NULL when a member joins the site.
   */
  public static function newMember(Member $member, Group $group = NULL) {
    $triumph = new Triumph('new-member');
    $triumph->addActor('member', $member);
    if ($group) {
      $triumph->addActor('group', $group);
    }
    $triumph->save();
    return $triumph;
  }

  /**
   * Create a new-group triumph.
   *
   * @static
   * @param Group $group
   * @param Group $parent_group
   *   The parent group when a sub group is created, NULL when a top-level group is created.
   */
  public static function newGroup(Group $group, Group $parent_group = NULL) {
    $triumph = new Triumph('new-group');
    $triumph->addActor('group', $group);
    if ($parent_group) {
      $triumph->addActor('parent group', $parent_group);
    }
    $triumph->save();
    return $triumph;
  }

  /**
   * Create a new-item triumph.
   *
   * @static
   * @param $item
   */
  public static function newItem($item) {
    $triumph = new Triumph('new-item');
    $triumph->addActor('item', $item);
    $triumph->save();
    return $triumph;
  }

  /**
   * Create a new-comment triumph.
   *
   * @static
   * @param $comment
   */
  public static function newComment($comment) {
    $triumph = new Triumph('new-comment');
    $triumph->addActor('comment', $comment);
    $triumph->save();
    return $triumph;
  }

  /**
   * Create a new-follower triumph.
   *
   * @static
   * @param Member $follower
   * @param Member $followee
   */
  public static function newFollower(Member $follower, Member $followee) {
    $triumph = new Triumph('new-follower');
    $triumph->addActor('follower', $follower);
    $triumph->addActor('followee', $followee);
    $triumph->save();
    return $triumph;
  }

  /**
   * Create an update-member triumph.
   *
   * @static
   * @param Member $member
   */
  public static function updateMember(Member $member) {
    $triumph = new Triumph('update-member');
    $triumph->addActor('member', $member);
    $triumph->save();
    return $triumph;
  }
  
  /**
   * Create an update-group triumph.
   *
   * @static
   * @param Group $group
   */
  public static function updateGroup(Group $group) {
    $triumph = new Triumph('update-group');
    $triumph->addActor('group', $group);
    $triumph->save();
    return $triumph;
  }

} // class
