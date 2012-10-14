<?php
namespace AstroMultimedia\MoonMars;

use \AstroMultimedia\Drupal\Entity;

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
  const pageSize = 10;

  /**
   * The parent entity of the channel.
   *
   * @var array
   */
  protected $parentEntity;

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Static methods that return Channels.

  /**
   * Get a channel given a channel title.
   *
   * @static
   * @param $channel_title
   * @return Channel
   */
  public static function createByTitle($channel_title) {
    $rec = db_select('node', 'n')
      ->fields('n', array('nid'))
      ->condition('title', $channel_title)
      ->condition('type', 'channel')
      ->execute()
      ->fetch();
    return $rec ? new self($rec->nid) : FALSE;
  }

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
  // Parent entity-related methods.

  /**
   * Get the entity that a channel belongs to.
   *
   * @return array
   */
  public function parentEntity() {
    // Check if we remembered the result in the parentEntity property:
    if (!isset($this->parentEntity)) {
      // Search for the has_channel relationship:
      $rels = Relation::searchBinary('has_channel', NULL, $this);
      if (!empty($rels)) {
        $this->parentEntity = $rels[0]->endpoint(0);
      }
    }

    return $this->parentEntity;
  }

  /**
   * Get a link to a channel's entity's page.
   *
   * @return string
   *   Or FALSE if parent entity not found - should never happen.
   */
  public function parentEntityLink($brackets = FALSE) {
    $entity = $this->parentEntity();
    if (!$entity) {
      return FALSE;
    }

    $label = $brackets ? ('[' . $this->title() . ']') : $this->title();
    return l($label, $entity->alias());
  }

  /**
   * Get the parent entity's name or title.
   *
   * @return string
   *   Or FALSE if parent entity not found - should never happen.
   */
  public function parentEntityName() {
    $entity = $this->parentEntity();
    if (!$entity) {
      return FALSE;
    }

    // Member:
    if ($entity instanceof Member) {
      return $entity->name();
    }

    // Node:
    return $entity->title();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Alias and title methods.

  /**
   * Update the path alias for the channel.
   *
   * @return string
   */
  public function resetAlias() {
    // Get the parent entity:
    $parent_entity = $this->parentEntity();
    if (!$parent_entity) {
      return FALSE;
    }

    // Set the alias:
    $alias = $parent_entity->alias() . '/channel';
    $this->alias($alias);

    // Make sure pathauto doesn't clobber the new alias:
    $this->entity->path['pathauto'] = FALSE;

    return $alias;
  }

  /**
   * Reset the channel's title. Call this if the parent entity's title or name changes.
   *
   * @return Channel
   */
  public function resetTitle() {
    $entity = $this->parentEntity();
    $title = $entity ? $entity->channelTitle() : FALSE;
    if ($title) {
      $this->title($title);
    }
    return $this;
  }

  /**
   * Reset a channel's alias and title to match the parent entity.
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
   * Get the items in the channel.
   *
   * @param int $offset
   * @param int $limit
   * @param string $order_by_field
   * @param string $order_by_direction
   * @return array
   */
  public function items($offset = NULL, $limit = NULL, $order_by_field = 'changed', $order_by_direction = 'DESC') {
    // Look for relationship records:
    $q = db_select('view_channel_has_item', 'vci')
      ->fields('vci', array('item_nid'))
      ->condition('channel_nid', $this->nid())
      ->condition('item_status', 1);

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
      $item = Item::create($rec->item_nid);
//      $item->load();
      $items[] = $item;
    }
    return $items;
  }

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
   * Get the total number of items in the channel.
   *
   * @return array
   */
  public function itemCount() {
    // Look for relationship records:
    $q = db_select('view_channel_has_item', 'vci')
      ->fields('vci', array('item_nid'))
      ->condition('channel_nid', $this->nid())
      ->condition('item_status', 1);

    // Get the items and return the count:
    $rs = $q->execute();
    return $rs->rowCount();
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
    pager_default_initialize($total_n_items, self::pageSize);
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
    $order_by_field = ($this->nid() == MOONMARS_NEWS_CHANNEL_NID) ? 'item_created' : 'changed';
    $items = $this->items($page * self::pageSize, self::pageSize, $order_by_field);

    // Get the total item count:
    $total_n_items = $this->itemCount();

    // Render the page of items:
    return self::renderItemsPage($items, $total_n_items);
  }

  /**
   * Return the links for this channel's entity.
   *
   * @return string
   */
  public function renderLinks() {
    $html = '';
    $entity = $this->parentEntity();

    // Social links:
    $social_links = '';
    $social_link_fields = moonmars_channels_social_links();
    foreach ($social_link_fields as $social_site => $info) {
      $link_field = $info['field'];
      $url = $this->field($link_field, LANGUAGE_NONE, 0, 'url');
      if ($url) {
        $title = "Visit " . (($entity instanceof Member) ? $entity->name() : $entity->title()) . "'s " . $info['description'];
        $title = htmlspecialchars($title, ENT_QUOTES);
        $social_links .= "<a class='social-link social-link-{$social_site}' href='$url' target='_blank' title='$title'></a>\n";
      }
    }

    // Skype link:
    if ($entity instanceof Member) {
      $skype_name = $entity->field('field_skype');
      if ($skype_name) {
        $title = htmlspecialchars("Chat with " . $entity->name() . " on Skype", ENT_QUOTES);
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
