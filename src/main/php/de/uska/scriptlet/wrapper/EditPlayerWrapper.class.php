<?php namespace de\uska\scriptlet\wrapper;

use scriptlet\xml\workflow\Wrapper;

/**
 * Wrapper for EditPlayerHandler
 * Handler class
 * 
 * @see      xp://de.uska.scriptlet.handler.EditPlayerHandler
 * @purpose  Wrapper
 */
class EditPlayerWrapper extends Wrapper {

  /**
   * Constructor
   *
   */  
  public function __construct() {
    $this->registerParamInfo(
      'player_id',
      Wrapper::OCCURRENCE_OPTIONAL | Wrapper::OCCURRENCE_PASSBEHIND,
      null,
      null,
      null,
      null
    );
    $this->registerParamInfo(
      'firstname',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      array('scriptlet.xml.workflow.casters.ToTrimmedString'),
      null,
      array('scriptlet.xml.workflow.checkers.LengthChecker', 2)
    );
    $this->registerParamInfo(
      'lastname',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      array('scriptlet.xml.workflow.casters.ToTrimmedString'),
      null,
      array('scriptlet.xml.workflow.checkers.LengthChecker', 3)
    );
    $this->registerParamInfo(
      'username',
      Wrapper::OCCURRENCE_OPTIONAL,
      null,
      array('scriptlet.xml.workflow.casters.ToTrimmedString'),
      null,
      array('scriptlet.xml.workflow.checkers.LengthChecker', 3)
    );
    $this->registerParamInfo(
      'password',
      Wrapper::OCCURRENCE_OPTIONAL,
      null,
      array('scriptlet.xml.workflow.casters.ToTrimmedString'),
      null,
      array('scriptlet.xml.workflow.checkers.RegexpChecker', '/^[A-Za-z0-9\.\_]{3,}$/')
    );
    $this->registerParamInfo(
      'email',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      array('scriptlet.xml.workflow.casters.ToEmailAddress'),
      null,
      null
    );
    $this->registerParamInfo(
      'team_id',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      null,
      null,
      null
    );
    $this->registerParamInfo(
      'position',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      null,
      null,
      null
    );
    $this->registerParamInfo(
      'mailinglist',
      Wrapper::OCCURRENCE_MULTIPLE | Wrapper::OCCURRENCE_OPTIONAL,
      null,
      null,
      null,
      null
    );
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
   * Returns the value of the parameter username
   *
   * @return  string
   */
  public function getUsername() {
    return $this->getValue('username');
  }

  /**
   * Returns the value of the parameter password
   *
   * @return  string
   */
  public function getPassword() {
    return $this->getValue('password');
  }

  /**
   * Returns the value of the parameter email
   *
   * @return  string
   */
  public function getEmail() {
    return $this->getValue('email');
  }

  /**
   * Returns the value of the parameter team_id
   *
   * @return  int
   */
  public function getTeam_id() {
    return $this->getValue('team_id');
  }

  /**
   * Returns the value of the parameter position
   *
   * @return  int
   */
  public function getPosition() {
    return $this->getValue('position');
  }

  /**
   * Returns the value of the parameter mailinglist
   *
   * @return  int[]
   */
  public function getMailinglist() {
    return $this->getValue('mailinglist');
  }

}