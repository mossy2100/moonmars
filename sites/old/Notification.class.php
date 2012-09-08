<?php
/**
 * Encapsulates an notification node.
 */
class Notification extends MoonMarsNode {

  /**
   * The node type.
   */
  const NODE_TYPE = 'notification';

  /**
   * Constructor.
   */
  protected function __construct() {
    return parent::__construct();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Get and set methods.

  /**
   * Get/set the notification message.
   *
   * @param null|string $message
   */
  public function message($message = NULL) {
    return $this->field('field_notification_message', LANGUAGE_NONE, 0, 'value', $message);
  }

  /**
   * Get the notification recipient.
   * Overrides base class method, which returns User.
   *
   * @return Member
   */
  public function recipient() {
    return Member::create($this->uid());
  }

}
