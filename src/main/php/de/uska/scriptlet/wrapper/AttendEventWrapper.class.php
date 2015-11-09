<?php namespace de\uska\scriptlet\wrapper;

use scriptlet\xml\workflow\Wrapper;

/**
 * Wrapper for AttendEventHandler
 * Handler
 * 
 * @see      xp://de.uska.scriptlet.handler.AttendEventHandler
 * @purpose  Wrapper
 */
class AttendEventWrapper extends Wrapper {

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
      'player_id',
      Wrapper::OCCURRENCE_PASSBEHIND,
      null,
      null,
      null,
      null
    );
    $this->registerParamInfo(
      'firstname',
      Wrapper::OCCURRENCE_OPTIONAL,
      null,
      null,
      null,
      null
    );
    $this->registerParamInfo(
      'lastname',
      Wrapper::OCCURRENCE_OPTIONAL,
      null,
      null,
      null,
      null
    );
    $this->registerParamInfo(
      'attend',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      null,
      null,
      array('scriptlet.xml.workflow.checkers.IntegerRangeChecker', 0, 2)
    );
    $this->registerParamInfo(
      'needs_seat',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      array('scriptlet.xml.workflow.casters.ToBoolean'),
      null,
      null
    );
    $this->registerParamInfo(
      'offers_seats',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      null,
      null,
      array('scriptlet.xml.workflow.checkers.IntegerRangeChecker', 0, 10)
    );
    $this->registerParamInfo(
      'fetch_key',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      array('scriptlet.xml.workflow.casters.ToBoolean'),
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
   * Returns the value of the parameter player_id
   *
   * @return  int
   */
  public function getPlayer_id() {
    return $this->getValue('player_id');
  }

  /**
   * Returns the value of the parameter firstname
   *
   * @return  string
   */
  public function getFirstname() {
    return $this->getValue('firstname');
  }

  /**
   * Returns the value of the parameter lastname
   *
   * @return  string
   */
  public function getLastname() {
    return $this->getValue('lastname');
  }

  /**
   * Returns the value of the parameter attend
   *
   * @return  int
   */
  public function getAttend() {
    return $this->getValue('attend');
  }

  /**
   * Returns the value of the parameter needs_seat
   *
   * @return  bool
   */
  public function getNeeds_seat() {
    return $this->getValue('needs_seat');
  }

  /**
   * Returns the value of the parameter offers_seats
   *
   * @return  int
   */
  public function getOffers_seats() {
    return $this->getValue('offers_seats');
  }

  /**
   * Returns the value of the parameter fetch_key
   *
   * @return  bool
   */
  public function getFetch_key() {
    return $this->getValue('fetch_key');
  }

}