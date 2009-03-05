<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'scriptlet.xml.workflow.AbstractXMLScriptlet',
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
      return $this->needsSession($request) || $request->hasSession();
    }
    
    /**
     * Check whether we need a session
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest
     * @return  bool
     */
    public function needsSession($request) {

      // Check whether user has auto-login cookie - in that case, we need a
      // context
      if ($request->hasCookie(UskaState::LOGINCOOKIE)) {
        Logger::getInstance()->getCategory()->debug('Want session due to cookie');
        return TRUE;
      }
      
      $result= parent::needsSession($request);
      Logger::getInstance()->getCategory()->debug('Needs session=', $result);
      return $result;
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
        'session_id',
        $request->session->getId(),
        0,
        '/'
      ));
      
      return $this->doRedirect($request, $response);
    }
  }
?>
