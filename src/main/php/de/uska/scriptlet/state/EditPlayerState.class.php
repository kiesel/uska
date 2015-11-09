<?php namespace de\uska\scriptlet\state;

use de\uska\scriptlet\handler\EditPlayerHandler;
use de\uska\scriptlet\state\UskaState;

/**
 * Edit or create players.
 *
 * @purpose  Edit players
 */
class EditPlayerState extends UskaState {

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
    $this->addHandler(new EditPlayerHandler());
    parent::setup($request, $response, $context);
  }
}