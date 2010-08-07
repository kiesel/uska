<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'de.uska.scriptlet.state.UskaState',
    'de.uska.scriptlet.handler.LoginHandler'
  );
  
  /**
   * Login state.
   *
   * @purpose  Provide login form
   */
  class LoginState extends UskaState {
  
    /**
     * Constructor
     *
     */
    public function __construct() {
      parent::__construct();
      $this->addHandler(new LoginHandler());
    }  

    /**
     * Setup the state
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
     * @param   scriptlet.xml.XMLScriptletResponse response 
     * @param   scriptlet.xml.Context context
     */
    public function setup($request, $response, $context) {
      parent::setup($request, $response, $context);
      
      if ($request->hasParam('logout')) {
        $this->cat->debug('Logging out');

        // Store hint in session, to easily tell if user is logged in
        $request->session->removeValue('logged-in');

        $context->setUser($n= NULL);
        $response->setCookie(new Cookie('psessionid', '', time() - 1000, '/'));
      
        $uri= $request->getURI();
        $response->sendRedirect(sprintf('%s://%s/xml/login',
          $uri['scheme'],
          $uri['host']
        ));
        return FALSE;
      }
    }
  }
?>
