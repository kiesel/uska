<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'scriptlet.xml.workflow.Handler',
    'de.uska.scriptlet.wrapper.LoginWrapper',
    'de.uska.db.Player'
  );
  
  /**
   * Handler for login
   *
   * @purpose  Login
   */
  class LoginHandler extends Handler {
    public
      $cat=     NULL;

    /**
     * Constructor.
     *
     */
    public function __construct() {
      parent::__construct();
      $this->setWrapper(new LoginWrapper());
      
      $this->cat= Logger::getInstance()->getCategory();
    }
    
    /**
     * Handle submitted data
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
     * @param   scriptlet.xml.Context context
     */
    public function handleSubmittedData($request, $context) {
      $wrapper= $this->getWrapper();
      
      $result= $context->authenticateUserByPassword(
        Player::getByUsername($wrapper->getUsername()),
        $wrapper->getPassword()
      );

      if (FALSE === $result) {
        $this->addError('mismatch');
        return FALSE;
      }
      
      return TRUE;
    }
    
    /**
     * Finalize this handler
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
     * @param   scriptlet.xml.XMLScriptletResponse response 
     * @param   scriptlet.xml.Context context
     */
    public function finalize($request, $response, $context) {
    
      // Store hint in session, to easily tell if user is logged in
      $request->session->putValue('logged-in', 1);

      $return= $request->session->getValue('authreturn');
	  $this->cat->debug('Have return page:', $return);

      if ($return instanceof HttpScriptletURL) {
        $this->cat->debug('Redirect to', $return->getURL());
        
        $request->session->removeValue('authreturn');
        $response->sendRedirect($return->getURL());
      }
    }
  }
?>
