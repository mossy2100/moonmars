<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shaun
 * Date: 2012-08-19
 * Time: 3:30 PM
 * To change this template use File | Settings | File Templates.
 */
class MoonMarsNode extends Node {

  /**
   * Get the node's creator as a Member object.
   * Overrides base class method, which returns User.
   *
   * @return Member
   */
  public function creator() {
    return Member::create($this->uid());
  }

}
