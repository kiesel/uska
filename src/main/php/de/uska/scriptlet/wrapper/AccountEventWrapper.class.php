<?php namespace de\uska\scriptlet\wrapper;

use scriptlet\xml\workflow\Wrapper;

/**
 * Wrapper for AccountEventHandler
 * Handler class
 * 
 * @see      xp://de.uska.scriptlet.handler.AccountEventHandler
 * @purpose  Wrapper
 */
class AccountEventWrapper extends Wrapper {

  /**
   * Constructor
   *
   */  
  public function __construct() {
    $this->registerParamInfo(
      'event_id',
      Wrapper::OCCURRENCE_PASSBEHIND,
      null,
      null,
      null,
      null
    );
    $this->registerParamInfo(
      'points',
      Wrapper::OCCURRENCE_MULTIPLE,
      null,
      null,
      null,
      null
    );
  }

  /**
   * Returns the value of the parameter event_id
   *
   * @return  int
   */
  public function getEvent_id() {
    return $this->getValue('event_id');
  }

  /**
   * Returns the value of the parameter points
   *
   * @return  int[]
   */
  public function getPoints() {
    return $this->getValue('points');
  }

}