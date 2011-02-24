<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'scriptlet.xml.workflow.Wrapper',
    'scriptlet.xml.workflow.casters.ToBoolean',
    'scriptlet.xml.workflow.casters.ToDate',
    'scriptlet.xml.workflow.casters.ToInteger',
    'scriptlet.xml.workflow.casters.ToTrimmedString',
    'scriptlet.xml.workflow.checkers.LengthChecker',
    'scriptlet.xml.workflow.checkers.RegexpChecker'    
  );

  /**
   * Wrapper for EditEventHandler
   * Handler class
   * 
   * @see      xp://de.uska.scriptlet.handler.EditEventHandler
   * @purpose  Wrapper
   */
  class EditEventWrapper extends Wrapper {

    /**
     * Constructor
     *
     */  
    public function __construct() {
      $this->registerParamInfo(
        'event_id',
        Wrapper::OCCURRENCE_PASSBEHIND | Wrapper::OCCURRENCE_OPTIONAL,
        NULL,
        NULL,
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'team',
        Wrapper::OCCURRENCE_UNDEFINED,
        NULL,
        array('scriptlet.xml.workflow.casters.ToInteger'),
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'event_type',
        Wrapper::OCCURRENCE_UNDEFINED,
        NULL,
        array('scriptlet.xml.workflow.casters.ToInteger'),
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'name',
        Wrapper::OCCURRENCE_UNDEFINED,
        NULL,
        array('scriptlet.xml.workflow.casters.ToTrimmedString'),
        NULL,
        array('scriptlet.xml.workflow.checkers.LengthChecker', 4, 40)
      );
      $this->registerParamInfo(
        'description',
        Wrapper::OCCURRENCE_OPTIONAL,
        NULL,
        array('scriptlet.xml.workflow.casters.ToTrimmedString'),
        NULL,
        array('scriptlet.xml.workflow.checkers.LengthChecker', 15, 200)
      );
      $this->registerParamInfo(
        'target_date',
        Wrapper::OCCURRENCE_UNDEFINED,
        NULL,
        array('scriptlet.xml.workflow.casters.ToDate'),
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'target_time',
        Wrapper::OCCURRENCE_UNDEFINED,
        NULL,
        NULL,
        array('scriptlet.xml.workflow.checkers.RegexpChecker', '/^\d{1,2}[:\.\-]\d{1,2}$/'),
        NULL
      );
      $this->registerParamInfo(
        'deadline_date',
        Wrapper::OCCURRENCE_OPTIONAL,
        NULL,
        array('scriptlet.xml.workflow.casters.ToDate'),
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'deadline_time',
        Wrapper::OCCURRENCE_OPTIONAL,
        NULL,
        NULL,
        array('scriptlet.xml.workflow.checkers.RegexpChecker', '/^\d{1,2}[:\.\-]\d{1,2}$/'),
        NULL
      );
      $this->registerParamInfo(
        'max',
        Wrapper::OCCURRENCE_OPTIONAL,
        NULL,
        NULL,
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'req',
        Wrapper::OCCURRENCE_OPTIONAL,
        NULL,
        NULL,
        NULL,
        NULL
      );
      $this->registerParamInfo(
        'guests',
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
     * Returns the value of the parameter team
     *
     * @return  int
     */
    public function getTeam() {
      return $this->getValue('team');
    }

    /**
     * Returns the value of the parameter event_type
     *
     * @return  int
     */
    public function getEvent_type() {
      return $this->getValue('event_type');
    }

    /**
     * Returns the value of the parameter name
     *
     * @return  string
     */
    public function getName() {
      return $this->getValue('name');
    }

    /**
     * Returns the value of the parameter description
     *
     * @return  string
     */
    public function getDescription() {
      return $this->getValue('description');
    }

    /**
     * Returns the value of the parameter target_date
     *
     * @return  string
     */
    public function getTarget_date() {
      return $this->getValue('target_date');
    }

    /**
     * Returns the value of the parameter target_time
     *
     * @return  string
     */
    public function getTarget_time() {
      return $this->getValue('target_time');
    }

    /**
     * Returns the value of the parameter deadline_date
     *
     * @return  string
     */
    public function getDeadline_date() {
      return $this->getValue('deadline_date');
    }

    /**
     * Returns the value of the parameter deadline_time
     *
     * @return  string
     */
    public function getDeadline_time() {
      return $this->getValue('deadline_time');
    }

    /**
     * Returns the value of the parameter max
     *
     * @return  int
     */
    public function getMax() {
      return $this->getValue('max');
    }

    /**
     * Returns the value of the parameter req
     *
     * @return  int
     */
    public function getReq() {
      return $this->getValue('req');
    }

    /**
     * Returns the value of the parameter guests
     *
     * @return  bool
     */
    public function getGuests() {
      return $this->getValue('guests');
    }

  }
?>
