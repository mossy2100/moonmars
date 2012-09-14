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
   * When the notifications were created.
   *
   * @var StarDateTime
   */
  protected $dtNxnsCreated;

  /**
   * Nxns created for about this triumph.
   * Keys are nxn_ids. Values are Nxn objeects.
   *
   * @var array
   */
  protected $nxns;

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
   * @var EntitySet
   */
  protected $recipients;

  /**
   * Constructor
   *
   * @param $param
   *   This maybe a triumph id for an existing one, or a triumph type for when creating a new one.
   *
   * Triumph types:
   *   new-member
   *   new-group
   *   new-item
   *   new-comment
   *   new-follower
   *   new-page
   *   update-member
   *   new-admin
   *   want-admin
   *   update-group
   * Check moonmars_nxn_definitions() for definitive list.
   */
  public function __construct($param) {
    if (is_uint($param)) {
      // Existing triumph:
      $this->triumphId    = (int) $param;
    }
    elseif (is_string($param) && in_array($param, moonmars_nxn_triumph_types())) {
      // New triumph:
      $this->triumphType  = $param;
      $this->dtCreated    = new StarDateTime();
      $this->nxnsCreated  = FALSE;
      $this->actors       = array();
      $this->recipients   = NULL;
    }
    elseif ($param instanceof stdClass) {
      // Assume this is a database record:
      $this->copyRec($param);
    }
    else {
      trigger_error("Invalid parameter to Triumph constructor.", E_USER_WARNING);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Load/save

  /**
   * Copy a database record into properties.
   *
   * @param $rec
   */
  public function copyRec($rec) {
    $this->triumphId = (int) $rec->triumph_id;
    $this->triumphType = $rec->triumph_type;
    $this->dtCreated = new StarDateTime($rec->ts_created);
    $this->nxnsCreated = (bool) $rec->nxns_created;
    $this->dtNxnsCreated = new StarDateTime($rec->nxns_created);
    return $this;
  }

  /**
   * Load the triumph.
   */
  public function load() {
    if ($this->triumphId) {
      // Get the triumph record:
      $q = db_select('moonmars_triumph', 'mmt')
        ->fields('mmt')
        ->condition('triumph_id', $this->triumphId);
      $rs = $q->execute();
      $rec = $rs->fetchObject();

      if ($rec) {
        // Set properties:
        $this->copyRec($rec);
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
      'triumph_type'    => $this->triumphType,
      'ts_created'      => $this->dtCreated->timestamp(),
      'nxns_created'    => (int) $this->nxnsCreated,
      'ts_nxns_created' => isset($this->dtNxnsCreated) ? $this->dtNxnsCreated->timestamp() : NULL,
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
      // Insert a new triumph:
      $q = db_insert('moonmars_triumph')
        ->fields($fields);
      // Get the new triumphId:
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
      $q = db_select('moonmars_triumph_actor', 'ta')
        ->fields('ta', array('actor_role', 'entity_type', 'entity_id'))
        ->condition('triumph_id', $this->triumphId);
      $rs = $q->execute();
      foreach ($rs as $rec) {
        $this->actors[$rec->actor_role] = moonmars_actors_get_actor($rec->entity_type, $rec->entity_id);
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
   * Get the nxn recipients for this triumph.
   *
   * @return EntitySet
   */
  protected function recipients() {
    // Check if we already did this:
    if (isset($this->recipients)) {
      return $this->recipients;
    }

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
    $this->recipients = new EntitySet();

    // Scan through our nxn definitions looking for matching triumph types:
    $definitions = moonmars_nxn_definitions();

    // Go through each nxn category:
    foreach ($definitions as $nxn_category => $nxn_category_info) {

      // Go through each triumph type, acting on matches:
      foreach ($nxn_category_info['triumph types'] as $triumph_type => $triumph_type_info) {

        // Check if the triumph type matches:
        if ($this->triumphType != $triumph_type) {
          continue;
        }

        // Initialise set of recipient candidates:
        $candidates = new EntitySet();

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Step 1.
        // Find which members MAY want to be notified about this triumph? These are stored in $candidates.
        // This logic spares us from checking every single member of the site, saving time before we check conditions.
        switch ($nxn_category) {
          case 'site':
            switch ($this->triumphType) {
              case 'new-member':
                // Only add recipients if the member is joining the site, not a group:
                if (!$this->actor('group')) {
                  $candidates->add(Nxn::mayWant($nxn_category, $this->triumphType));
                }
                break;

              case 'new-group':
              case 'new-item':
              case 'new-comment':
                $candidates->add(Nxn::mayWant($nxn_category, $this->triumphType));
                break;

              case 'new-follower':
                $candidates->add($this->actor('followee'));
                break;
            } // switch triumph type
            break;

          case 'news':
            // If something was posted in the News channel, lookup who may want News notifications.
            // Note that $channel will be NULL unless this is a new-item or new-comment.
            if ($channel && $channel->isNewsChannel()) {
              $candidates->add(Nxn::mayWant($nxn_category, $this->triumphType));
            }
            break;

          case 'channel':
            // The only member to consider is the one whose channel the item or comment is being posted in.
            // Note that $parent_entity will be NULL unless this is a new-item or new-comment.
            if ($parent_entity && $parent_entity instanceof Member) {
              $candidates->add($parent_entity);
            }
            break;

          case 'followee':
            // Get the member whose followers may want to be notified.
            $followee = NULL;

            switch ($this->triumphType) {
              case 'new-item':
                // The member who posted the new item:
                $followee = $this->actor('item')->creator();
                break;

              case 'new-comment':
                // The member who posted the new comment:
                $followee = $this->actor('comment')->creator();
                break;

              case 'new-follower':
                // The member who followed someone:
                $followee = $this->actor('follower');
                break;

              case 'new-member':
                // The member who joined the group or site:
                // (Although a member joining the site will not have any followers yet.)
                $followee = $this->actor('member');
                break;

              case 'update-member':
                // The member whose profile was updated:
                $followee = $this->actor('member');
                break;
            }

            // Add the member's followers:
            if ($followee) {
              $candidates->add($followee->followers());
            }
            break;

          case 'group':
            // Get the group that the triumph has occurred in or to.
            $group = NULL;

            switch ($this->triumphType) {
              case 'new-member':
                // The group with the new member.
                $group = $this->actor('group');
                break;

              case 'new-group':
                // The group with the new subgroup.
                // Note: if the new group is not a subgroup then $this->actor('parent group') will be NULL, which is OK.
                $group = $this->actor('parent group');
                break;

              case 'new-item':
              case 'new-comment':
                // If a new item or comment is posted in a group channel, the group:
                if ($parent_entity && $parent_entity instanceof Group) {
                  $group = $parent_entity;
                }
                break;

              case 'update-group':
                // The group being updated.
                // Note: if the triumph type is 'new-member', but the member is joining the site, not a group, then
                // $group will be NULL, which is OK.
                $group = $this->actor('group');
                break;
            } // switch

            // Add the group members:
            if ($group) {
              $candidates->add($group->members());
            }
            break;
        } // switch nxn_category

        // If we didn't find any recipient candidates, continue:
        if (!$candidates->count()) {
          continue;
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Step 2.
        // Remove the member responsible for the triumph from the recipient candidates, since they already know.
        switch ($this->triumphType) {
          case 'new-member':
            // No need to notify the new member:
            $candidates->remove($this->actor('member'));
            break;

          case 'new-group':
            // No need to notify the group creator:
            $candidates->remove($this->actor('group')->creator());
            break;

          case 'new-item':
            // No need to notify the poster of the item:
            $candidates->remove($this->actor('item')->creator());
            break;

          case 'new-comment':
            // No need to notify the poster of the comment:
            $candidates->remove($this->actor('comment')->creator());
            break;

          case 'new-follower':
            // No need to notify the follower:
            $candidates->remove($this->actor('follower'));
            break;

          case 'update-member':
            // No need to notify the updater (usually this is the member whose profile has been updated):
            $candidates->remove($this->actor('updater'));
            break;

          case 'update-group':
            // No need to notify the updater (this will be a group or site admin):
            $candidates->remove($this->actor('updater'));
            break;
        }

        // If there aren't any candidates left, continue:
        if (!$candidates->count()) {
          continue;
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Step 3.
        // Check who really does want a nxn, based on their preferences.
        foreach ($candidates->entities() as $member) {

          // Get the member's preferences for this type of triumph in this nxn category.
          $nxn_prefs = $member->nxnPref($nxn_category, $this->triumphType);

          switch ($nxn_prefs['wants']) {
            case MOONMARS_NXN_NO:
              // Do not add member to recipients.
              // This case block is just here for completeness and readability.
              break;

            case MOONMARS_NXN_YES:
              // Add them to the recipients:
              $this->recipients->add($member);
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
                      $this->recipients->add($member);
                    }
                    break;

                  case 'event':
                  case 'project':
                    // Applies to triumph types: new-group
                    // Notify the member if the group type matches.
                    // Could perhaps be extended to all group types, not just events and projects.
                    if ($this->actor('group')->groupType() == $nxn_condition) {
                      $this->recipients->add($member);
                    }
                    break;

                  case 'mention':
                    // Applies to triumph types: new-item, new-comment.
                    // Get the actor role 'item' or 'comment':
                    $actor_role = substr($this->triumphType, 4);
                    if ($this->actor($actor_role)->textScan()->mentions($member)) {
                      $this->recipients->add($member);
                    }
                    break;

                  case 'topic':
                    // Applies to triumph types: new-group, new-item, new-comment
                    // @todo
      //              $actor_role = substr($this->triumphType, 4);
                    //        if ($this->actors[$actor_role]->matchesMemberTopics($member)) {
                    //         $this->recipients->add($member);
                    //        }
                    break;

                  case 'item':
                    // Applies to triumph types: new-comment
                    // Notify the member if the comment is on an item they posted:
                    if (Member::equals($member, $this->actor('comment')->item()->creator())) {
                      $this->recipients->add($member);
                    }
                    break;

                  case 'comment':
                    // Applies to triumph types: new-comment
                    // Notify the member if the comment is on an item they've commented on:
                    if ($member->commentedOn($this->actor('comment')->item())) {
                      $this->recipients->add($member);
                    }
                    break;

                } // switch conditions
              } // foreach
              break;

          } // switch wants
        } // foreach members
      } // for each triumph type
    } // for each nxn category

    return $this->recipients;
  } // findRecipients

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Notifications

  /**
   * Create the nxns for this triumph.
   *
   * @return int
   *   The number of nxns created.
   */
  public function createNxns() {
    $n = 0;
    foreach ($this->recipients()->entities() as $recipient) {
      $nxn = new Nxn($this, $recipient);
      $nxn->save();
      $n++;
    }
    $this->nxnsCreated = TRUE;
    $this->dtNxnsCreated = StarDateTime::now();
    return $n;
  }

  /**
   * Find any triumphs for which nxns haven't been created yet, and create them.
   *
   * @static
   * @return int
   *   The total number of nxns created.
   */
  public static function createOutstandingNxns() {
    // Look for any triumphs for which we didn't create nxns yet:
    $q = db_select('moonmars_triumph', 'mmt')
      ->fields('mmt')
      ->condition('nxns_created', 0);
    $rs = $q->execute();
    // Create the nxns:
    $n = 0;
    foreach ($rs as $rec) {
      $triumph = new Triumph($rec);
      // The call to createNxns() followed by save() will update the nxns_created field:
      $n += $triumph->createNxns();
      $triumph->save();
    }
    return $n;
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
        $this->nxns[$rec->nxn_id] = new Nxn($rec->nxn_id);
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
  public static function updateMember(Member $member, Member $updater) {
    $triumph = new Triumph('update-member');
    $triumph->addActor('member', $member);
    $triumph->addActor('updater', $updater);
    $triumph->save();
    return $triumph;
  }

  /**
   * Create an update-group triumph.
   *
   * @static
   * @param Group $group
   */
  public static function updateGroup(Group $group, Member $updater) {
    $triumph = new Triumph('update-group');
    $triumph->addActor('group', $group);
    $triumph->addActor('updater', $updater);
    $triumph->save();
    return $triumph;
  }

} // class
