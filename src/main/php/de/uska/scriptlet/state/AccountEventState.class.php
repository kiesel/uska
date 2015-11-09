<?php namespace de\uska\scriptlet\state;

use de\uska\scriptlet\handler\AccountEventHandler;
use de\uska\scriptlet\state\UskaState;

/**
 * Account points for event
 *
 * @purpose  Accounts points
 */
class AccountEventState extends UskaState {
  
  /**
   * Indicate this state requires authentication.
   *
   * @return  bool
   */
  public function requiresAuthentication() { return true; }

  /**
   * Setup the state
   *
   * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
   * @param   scriptlet.xml.XMLScriptletResponse response 
   * @param   scriptlet.xml.Context context
   */
  public function setup($request, $response, $context) {
    $this->addHandler(new AccountEventHandler());
    parent::setup($request, $response, $context);
  }
}