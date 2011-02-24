<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'scriptlet.xml.workflow.Wrapper',
    'scriptlet.xml.workflow.casters.ToBoolean',
    'scriptlet.xml.workflow.checkers.IntegerRangeChecker'    
  );

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
        NULL,
        NULL,
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'player_id',
        Wrapper::OCCURRENCE_PASSBEHIND,
        NULL,
        NULL,
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'firstname',
        Wrapper::OCCURRENCE_OPTIONAL,
        NULL,
        NULL,
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'lastname',
        Wrapper::OCCURRENCE_OPTIONAL,
        NULL,
        NULL,
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'attend',
        Wrapper::OCCURRENCE_UNDEFINED,
        NULL,
        NULL,
        NULL,
        array('scriptlet.xml.workflow.checkers.IntegerRangeChecker', 0, 2)
      );
      $this->registerParamInfo(
        'needs_seat',
        Wrapper::OCCURRENCE_UNDEFINED,
        NULL,
        array('scriptlet.xml.workflow.casters.ToBoolean'),
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'offers_seats',
        Wrapper::OCCURRENCE_UNDEFINED,
        NULL,
        NULL,
        NULL,
        array('scriptlet.xml.workflow.checkers.IntegerRangeChecker', 0, 10)
      );
      $this->registerParamInfo(
        'fetch_key',
        Wrapper::OCCURRENCE_UNDEFINED,
        NULL,
        array('scriptlet.xml.workflow.casters.ToBoolean'),
        NULL,
        NULL
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
?>
