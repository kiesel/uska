<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'scriptlet.xml.workflow.AbstractXMLScriptlet',
    'scriptlet.RequestAuthenticator',
    'xml.DomXSLProcessor'
  );

  /**
   * Scriptlet for USKA site
   *
   * @purpose  Standard scriptlet
   */
  class UskaScriptlet extends AbstractXMLScriptlet {
  
    /**
     * Sets the responses XSL stylesheet
     *
     * @param   scriptlet.scriptlet.XMLScriptletRequest request
     * @param   scriptlet.scriptlet.XMLScriptletResponse response
     */
    protected function _setStylesheet($request, $response) {
      $response->setStylesheet(sprintf(
        '%s/%s.xsl',
        $request->getProduct(),
        $request->getStateName()
      ));
    }
    
    /**
     * Decide whether a context is needed. Whenever a session is required
     * we also need a context.
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request
     * @return  bool
     */
    public function wantsContext($request) {
      return TRUE;
    }
    
    /**
     * Check whether we need a session
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest
     * @return  bool
     */
    public function needsSession($request) {
      return TRUE;
    }
    
    /**
     * Creates a session. 
     *
     * @return  bool processed
     * @param   scriptlet.HttpScriptletRequest request 
     * @param   scriptlet.HttpScriptletResponse response 
     */
    public function doCreateSession($request, $response) {
      Logger::getInstance()->getCategory()->debug('Storing session', $request->session->getId(), 'as cookie');
      $response->setCookie(new Cookie(
        'psessionid',
        $request->session->getId(),
        0,
        '/'
      ));
      
      return $this->doRedirect($request, $response);
    }

    public function getAuthenticator($request) {
      return newinstance('scriptlet.RequestAuthenticator', array(), '{
        public function authenticate($request, $response, $context) {
          $cat= Logger::getInstance()->getCategory();
          $cat->debug($this->getClassName(), "~ Authentication to be performed for", $request->getURL()->getURL(), "?");

          if (!$request->state->requiresAuthentication()) {
            $cat->debug($this->getClassName(), "~ No auth because state not requiring it.");
            return; // Skip
          }

          // HACK: Actually, we should use $context->getUser(), but currently context
          // is never passed in. So, apply workaround instead.
          if (1 == $request->session->getValue("logged-in")) {
            $cat->debug($this->getClassName(), "~ No auth because user is already authenticated");
            return; // OK
          }

          $cat->info("Authentication required - initiating login...");

          // Dispatch - LoginHandler will redirect to original state
          $request->session->putValue("authreturn", $request->getURL());
		  $cat->debug($this->getClassName(), "~ Return URL is", $request->getURL()->getURL());
          $response->forwardTo("login");
		  
		  // Indicate no further processing is to be done
		  return FALSE;
        }
      }');
    }
  }
?>
