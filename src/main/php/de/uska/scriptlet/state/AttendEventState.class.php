<?php namespace de\uska\scriptlet\state;

use de\uska\scriptlet\handler\AttendEventHandler;
use de\uska\scriptlet\state\UskaState;

/**
 * (Insert class' description here)
 *
 * @ext      extension
 * @see      reference
 * @purpose  purpose
 */
class AttendEventState extends UskaState {
  
  /**
   * (Insert method's description here)
   *
   * @param   
   * @return  
   */
  public function requiresAuthentication() { return true; }

  /**
   * (Insert method's description here)
   *
   * @param   
   * @return  
   */
  public function setup($request, $response, $context) {
    $this->addHandler(new AttendEventHandler());
    parent::setup($request, $response, $context);
  }
}