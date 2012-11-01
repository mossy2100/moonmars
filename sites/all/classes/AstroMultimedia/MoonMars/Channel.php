<?php
namespace AstroMultimedia\MoonMars;

/**
 * Channel class - encapsulates a channel node.
 */
class Channel extends Node {

  /**
   * The node type.
   */
  const NODE_TYPE = 'channel';

  /**
   * The default page size for channels.
   */
  const PAGE_SIZE = 10;

  /**
   * The star this channel belongs to.
   *
   * @var IStar
   */
  protected $star;

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Static methods

  /**
   * Get/set the current channel.
   *
   * @static
   * @param null|Channel $channel
   * @return Channel
   */
  public static function currentChannel($channel = NULL) {
    if ($channel === NULL) {
      // Get the current channel:
      return (isset($_SESSION['current_channel_nid']) && $_SESSION['current_channel_nid']) ? self::create($_SESSION['current_channel_nid']) : NULL;
    }
    else {
      // Remember the current channel nid in the session:
      $_SESSION['current_channel_nid'] = $channel->nid();
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Actor-related methods.

  /**
   * Get the star whose channel this is.
   *
   * @return IStar
   */
  public function star() {
    if (!isset($this->star)) {
      // Search for the has_channel relationship:
      $rels = Relation::searchBinary('has_channel', NULL, $this);
      if (!empty($rels)) {
        $this->star = $rels[0]->endpoint(0);
      }
    }
    return $this->star;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Alias and title methods.

  /**
   * Update the path alias for the channel.
   *
   * @return string
   */
  public function resetAlias() {
    // Get the star:
    $star = $this->star();
    if (!$star) {
      return FALSE;
    }

    // Set the alias:
    $alias = $star->alias() . '/channel';
    $this->alias($alias);

    // Make sure pathauto doesn't clobber the new alias:
    $this->entity->path['pathauto'] = FALSE;

    return $alias;
  }

  /**
   * Reset the channel's title. Call this if the star's tag or name changes.
   *
   * @return Channel
   */
  public function resetTitle() {
    $star = $this->star();
    $title = $star ? $star->channelTitle() : FALSE;
    if ($title) {
      $this->title($title);
    }
    return $this;
  }

  /**
   * Reset a channel's alias and title to match the star.
   */
  public function resetAliasAndTitle() {
    $this->load();
    $this->resetAlias();
    $this->resetTitle();
    $this->save();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Item-related methods.

  /**
   * Checks if an item is in the channel.
   *
   * @param Item $item
   * @return bool
   */
  public function hasItem(Item $item) {
    return (bool) Relation::searchBinary('has_item', $this, $item);
  }

  /**
   * Post an item in a channel.
   *
   * @param Item $item
   * @return Relation
   */
  public function postItem(Item $item) {
    // Create a new relationship:
    return Relation::createNewBinary('has_item', $this, $item);
  }

  /**
   * Get the query to obtain the items linked to a channel.
   * This function is *not* for finding which items to *display* in a channel. Use the itemQuery() method in the
   * star class for that.
   *
   * @return SelectQuery
   */
  public function itemQuery() {
    // Check if the star has an itemQuery method, in which case override, and get the items display in
    // this channel (not necessarily posted in).
    // This really needs to be refactored or something.
    $star = $this->star();
    if  ($star && method_exists($star, 'itemQuery')) {
      return $star->itemQuery();
    }

    // Get all the items posted in this channel:
    $q = db_select('view_channel_has_item', 'vchi')
      ->fields('vchi', array('item_nid'))
      ->condition('channel_nid', $this->nid());
    return $q;
  }

  /**
   * Get the items in the channel.
   *
   * @param int $offset
   * @param int $limit
   * @param string $order_by_field
   * @param string $order_by_direction
   * @return array
   */
  public function items($offset = NULL, $limit = NULL, $order_by_field = 'item_modified', $order_by_direction = 'DESC') {
    $q = $this->itemQuery();

    // Add LIMIT clause:
    if ($offset !== NULL && $limit !== NULL) {
      $q->range($offset, $limit);
    }

    // Add ORDER BY clause:
    $q->orderBy($order_by_field, $order_by_direction);

    // Get the items:
    $rs = $q->execute();
    $items = array();
    foreach ($rs as $rec) {
      $items[] = Item::create($rec->item_nid);
    }
    return $items;
  }

  /**
   * Get the total number of items in the channel.
   *
   * @return array
   */
  public function itemCount() {
    return $this->itemQuery()->countQuery()->execute()->fetchField();
  }

  /**
   * Render a page of items, with pagination.
   *
   * @return string
   */
  public static function renderItemsPage($items, $total_n_items) {
    // Render the items:
    $items_html = Item::renderMultiple($items);

    // Render the pager:
    pager_default_initialize($total_n_items, self::PAGE_SIZE);
    $pager_html = theme('pager', array('quantity' => $total_n_items));

    return "
      <div id='channel'>
        <div id='channel-items'>$items_html</div>
        <div id='channel-pager'>$pager_html</div>
      </div>";
  }

  /**
   * Render a channel's items.
   *
   * @return string
   */
  public function renderItems() {
    // Get the page number:
    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 0;

    // Get the items from this channel:
    $order_by_field = ($this->nid() == MOONMARS_NEWS_CHANNEL_NID) ? 'item_created' : 'item_modified';
    $items = $this->items($page * self::PAGE_SIZE, self::PAGE_SIZE, $order_by_field);

    // Get the total item count:
    $total_n_items = $this->itemCount();

    // Render the page of items:
    return self::renderItemsPage($items, $total_n_items);
  }

  /**
   * Get all the items posted in this channel that have been modified (created, changed or commented on) within a
   * datetime range.
   *
   * @param int $ts_start
   * @param int $ts_end
   * @return array
   */
  public function itemsPostedIn($ts_start, $ts_end) {
    $q = db_select('view_channel_has_item', 'vchi')
      ->fields('vchi', array('nid', 'item_modified'))
      ->condition('channel_nid', $this->nid())
      ->condition('item_modified', array($ts_start, $ts_end), 'BETWEEN')
      ->orderBy('item_modified');
    $rs = $q->execute();
    $items = array();
    foreach ($rs as $rec) {
      $items[$rec->nid] = Item::create($rec->item_modified);
    }
    return $items;
  }

  /**
   * Get all the items to display in this channel, i.e. that are tagged with the channel owner's tag.
   *
   * @param int $ts_start
   * @param int $ts_end
   * @return array
   */
  public function itemsToDisplayIn($ts_start, $ts_end) {
    $owner = $this->owner();



        

  }

//  /**
//   * Get the min and max modified timestamp of items in this group.
//   *
//   * @todo Check for restricted/closed groups. Need Member::canSeeItem() method.
//   */
//  public function loadMinMaxItemModified() {
//    $q = $this->itemQuery()
//      ->fields('vchi', "MIN(item_modified) AS min_item_modified, MAX(item_modified) AS max_item_modified");
//    dbg($q);
//    $rec = $q->execute()->fetchAssoc();
//    dbg($rec);
//    $this->minItemModified = $rec->min_item_modified;
//    $this->maxItemModified = $rec->max_item_modified;
//  }
//
//  /**
//   * Get the min modified timestamp of items in this channel.
//   *
//   * @todo Check for restricted/closed groups. Need Member::canSeeItem() method.
//   *
//   * @return SelectQuery
//   */
//  public function minItemModified() {
//    if (!isset($this->minItemModified)) {
//      $this->loadMinMaxItemModified();
//    }
//    return $this->minItemModified;
//  }
//
//  /**
//   * Get the max modified timestamp of items in this channel.
//   *
//   * @todo Check for restricted/closed groups. Need Member::canSeeItem() method.
//   *
//   * @return SelectQuery
//   */
//  public function maxItemModified() {
//    if (!isset($this->maxItemModified)) {
//      $this->loadMaxMaxItemModified();
//    }
//    return $this->maxItemModified;
//  }


//  public function renderPage($first) {
//    if ($first) {
//      $ts_end = REQUEST_TIME;
//      $ts_start = $ts_end - DateTime::SECONDS_PER_DAY;
//      $new_items = $this->itemsPostedIn($ts_start, $ts_end);
//      $_SESSION['channel_items_cache'][$this->nid()] = [
//        'items' => $new_items,
//        'ts_min' => $new_items[0],
//        'ts_max' => $new_items[count($new_items) - 1],
//      ];
//    }
//    else {
//      $items = $_SESSION['channel_items_cache'][$this->nid()]
//    }
//
//
//  }

  /**
   * Return the links for this channel's star.
   *
   * @return string
   */
  public function renderLinks() {
    $html = '';
    $star = $this->star();

    // Social links:
    $social_links = '';
    $social_link_fields = moonmars_channels_social_links();
    foreach ($social_link_fields as $social_site => $info) {
      $link_field = $info['field'];
      $url = $this->field($link_field, LANGUAGE_NONE, 0, 'url');
      if ($url) {
        $title = "Visit " . (($star instanceof Member) ? $star->name() : $star->title()) . "'s " . $info['description'];
        $title = htmlspecialchars($title, ENT_QUOTES);
        $social_links .= "<a class='social-link social-link-{$social_site}' href='$url' target='_blank' title='$title'></a>\n";
      }
    }

    // Skype link:
    if ($star instanceof Member) {
      $skype_name = $star->field('field_skype');
      if ($skype_name) {
        $title = htmlspecialchars("Chat with " . $star->name() . " on Skype", ENT_QUOTES);
        $social_links .= "<a class='social-link social-link-skype' href='skype:$skype_name?chat' title='$title'></a>\n";
      }
    }

    if ($social_links) {
      $html .= "<div class='social-links clearfix'>\n$social_links\n</div>\n";
    }

    return $html;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // News

  /**
   * Check if this is the Site News channel.
   *
   * @return bool
   */
  public function isNewsChannel() {
    return $this->nid() == MOONMARS_NEWS_CHANNEL_NID;
  }

}
