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
    
      // Remember user if he requests so
      if ($request->getParam('remember') == 'yes') {
        $secret= PropertyManager::getInstance()->getProperties('product')->readString('login', 'secret');
        
        $response->setCookie(new Cookie(
          UskaState::LOGINCOOKIE,
          $context->user->getUsername().'|'.md5($context->user->getUsername().$secret),
          time() + (86400 * 365),  // one year
          '/'
        ));
      }

      $return= $request->session->getValue('authreturn');

      if ($return) {
        $this->cat->debug('Redirect to', $return);
        
        $request->session->removeValue('authreturn');
        $response->sendRedirect(sprintf('%s://%s%s%s',
          $return['scheme'],
          $return['host'],
          $return['path'],
          $return['query'] ? '?'.$return['query']: ''
        ));
      }
    }
  }
?>
