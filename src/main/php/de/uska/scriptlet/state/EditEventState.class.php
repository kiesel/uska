<?php namespace de\uska\scriptlet\state;

use de\uska\scriptlet\handler\EditEventHandler;
use de\uska\scriptlet\state\UskaState;

/**
 * Edit single event
 *
 * @ext      extension
 * @see      reference
 * @purpose  purpose
 */
class EditEventState extends UskaState {

  /**
   * Retrieve whether authentication is needed.
   *
   * @return  bool
   */
  public function requiresAuthentication() {
    return true;
  }
  
  /**
   * Setup the state
   *
   * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
   * @param   scriptlet.xml.XMLScriptletResponse response 
   * @param   scriptlet.xml.Context context
   */
  public function setup($request, $response, $context) {
    $this->addHandler(new EditEventHandler());
    parent::setup($request, $response, $context);
  }
}