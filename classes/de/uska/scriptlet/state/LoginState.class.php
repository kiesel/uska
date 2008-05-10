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
      
      // Check for auto-login
      if ($request->hasCookie(UskaState::LOGINCOOKIE)) {
        if (TRUE === $context->authenticateUserByCookie($request->getCookie(UskaState::LOGINCOOKIE))) {
          $this->cat->info('Logged in user by cookie:', $context->user);
          
          $return= $request->session->getValue('authreturn');

          if ($return) {
            $this->cat->debug('Returning to', $return);

            $request->session->removeValue('authreturn');
            $response->sendRedirect(sprintf('%s://%s%s%s',
              $return['scheme'],
              $return['host'],
              $return['path'],
              $return['query'] ? '?'.$return['query']: ''
            ));
            return FALSE;
          }
        }
      }

      parent::setup($request, $response, $context);
      
      if ($request->hasParam('logout')) {
        $context->setUser($n= NULL);
        $response->setCookie(new Cookie(UskaState::LOGINCOOKIE, '', time() - 1000, '/'));
        $response->setCookie(new Cookie('session_id', '', time() - 1000, '/'));
      
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
