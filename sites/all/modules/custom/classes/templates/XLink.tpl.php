<?php
// $Id$

/**
 * @file
 * 
 * Contains the XLink class, which encapsulates a hyperlink.
 */

/**
 * This class was created for the 'link' CCK field type, as provided by the link
 * module.
 * 
 * @version <dt_generated>
 * @author shaunmoss
 */
class XLink {

  /**
   * The link's URL.
   * 
   * @var string
   */
  protected $url = '';
  
  /**
   * The link's title or label.
   * 
   * @var string
   */
  protected $title = '';
  
  /**
   * The link element's attributes.
   * 
   * @var array
   */
  protected $attributes = array();
  
  /**
   * Constructor.
   *
   * @param mixed $link
   *   This can be a CCK array containing all the link properties, a URL, or
   *   NULL.
   * @param string $title
   * @param array $attributes 
   */
  public function __construct($link = NULL, $title = NULL, $attributes = NULL) {
    // Convert an object parameter to an array:
    if (is_object($link)) {
      $link = (array) $link;
    }
    
    // Extract information from the array (designed for CCK fields).
    if (is_array($link)) {
      
      // Get the URL:
      if (array_key_exists('url', $link)) {
        $this->setUrl($link['url']);
      }
      
      // Get the title:
      if (array_key_exists('title', $link)) {
        $this->setTitle($link['title']);
      }
      
      // Get the attributes:
      if (array_key_exists('attributes', $link)) {
        $this->setAttributes($link['attributes']);
      }
    }
    elseif (is_string($link)) {
      // Assume $link parameter is the URL:
      $this->setUrl($link);
    }
    
    // If title is provided, set it:
    if (!is_null($title)) {
      $this->setTitle($title);
    }
    
    // If attributes are provided, set them:
    if (!is_null($attributes)) {
      $this->setAttributes($attributes);
    }
  }


  //////////////////////////////////////////////////////////////////////////////
  // Overload methods.

  /**
   * Passes the request through to the corresponding get method (getTitle(),
   * etc.), which will take care of loading fields from the database, etc.
   * For example $date->hour can be used instead of $date->getHour().
   *
   * @param string $name
   * @return mixed
   */
  public function __get($name) {
    // Look for a matching 'get' method:
    $method = 'get' . ucfirst($name);
    if (method_exists($this, $method)) {
      return $this->$method();
    }

    // Look for a matching attribute:
    if (array_key_exists($name, $this->attributes)) {
      return $this->attributes[$name];
    }

    // Unknown virtual property:
    return NULL;
  }

  /**
   * Passes the request through to the corresponding set method.
   * For example, $date->month = 5 can be used instead of $date->setMonth(5).
   *
   * @param string $name
   * @param mixed $value
   */
  public function __set($name, $value) {
    // Look for a matching 'set' method:
    $method = 'set' . ucfirst($name);
    if (method_exists($this, $method)) {
      return $this->$method($value);
    }
    
    // Set an attribute:
    $this->attributes[$name] = $value;
    
    // Return the $this object to allow method chaining:
    return $this;
  }


  //////////////////////////////////////////////////////////////////////////////
  // Accessor and mutator methods.

  /**
   * Get the URL.
   *
   * @return string
   */
  public function getUrl() {
    return $this->url;
  }
  
  /**
   * Set the URL.
   * 
   * @param string $url
   * @return XLink 
   */
  public function setUrl($url) {
    $this->url = (string) $url;
    return $this;
  }

  /**
   * Get the title.
   * 
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }
  
  /**
   * Set the title.
   * 
   * @param string $title
   * @return XLink 
   */
  public function setTitle($title) {
    $this->title = (string) $title;
    return $this;
  }

  /**
   * Get the attributes.
   * 
   * @return array
   */
  public function getAttributes() {
    return $this->attributes;
  }
  
  /**
   * Set the attributes.
   * 
   * @param array $attributes
   * @return XLink 
   */
  public function setAttributes($attributes) {
    $this->attributes = classes_convert_to_array($attributes);
    return $this;
  }

  
  //////////////////////////////////////////////////////////////////////////////
  // Conversion methods.

  /**
   * Convert the object to an array. This exposes the values of the protected
   * and private properties of the object, which is useful when debugging.
   */
  public function toArray() {
    return get_object_vars($this);
  }
  
}
