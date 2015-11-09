<?php namespace de\uska\scriptlet\wrapper;

use scriptlet\xml\workflow\Wrapper;

/**
 * Wrapper for LoginHandler
 * Handler
 * 
 * @see      xp://de.uska.scriptlet.handler.LoginHandler
 * @purpose  Wrapper
 */
class LoginWrapper extends Wrapper {

  /**
   * Constructor
   *
   */  
  public function __construct() {
    $this->registerParamInfo(
      'username',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      array('scriptlet.xml.workflow.casters.ToTrimmedString'),
      null,
      array('scriptlet.xml.workflow.checkers.RegexpChecker', '/^[a-z0-9\.\_]{3,}$/')
    );
    $this->registerParamInfo(
      'password',
      Wrapper::OCCURRENCE_UNDEFINED,
      null,
      array('scriptlet.xml.workflow.casters.ToTrimmedString'),
      null,
      array('scriptlet.xml.workflow.checkers.RegexpChecker', '/^[A-Za-z0-9\.\_]{3,}$/')
    );
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

}