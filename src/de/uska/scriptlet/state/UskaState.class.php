<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'scriptlet.xml.workflow.AbstractState',
    'de.uska.db.Player'
  );

  /**
   * Base state for all uska states.
   *
   * @purpose  Base state
   */
  class UskaState extends AbstractState {
    const
      LOGINCOOKIE   = 'uska-loginname';
      
    /**
     * Constructor.
     *
     */
    public function __construct() {
      $this->cat= Logger::getInstance()->getCategory();
    }
    
    /**
     * Setup this state. Sets up database connection and redirects
     * to login form in case the state needs an authenticated user.
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
     * @param   scriptlet.xml.XMLScriptletResponse response 
     * @param   scriptlet.xml.Context context
     */
    public function setup($request, $response, $context) {
      $autologin= FALSE;
    
      // Login user, if auto-login is enabled through cookie
      if ($request->hasCookie(self::LOGINCOOKIE)) {
        list ($username, $hash)= explode('|', $request->getCookie(self::LOGINCOOKIE)->getValue());
        if ($hash == md5($username.PropertyManager::getInstance()->getProperties('product')->readString('login', 'secret'))) {
          $autologin= TRUE;
        }
      }
    
      // Automatically handle authentication if state indicates so
      if ($this->requiresAuthentication() || $autologin) {
        if (!$context->user instanceof Player) {

          // Store return point in session
          $request->session->putValue('authreturn', $request->getURI());

          // Send redirect
          $response->forwardTo('login');
          
          return FALSE;
        }
      }
      
      $response->addFormResult(Node::fromArray(
        PropertyManager::getInstance()->getProperties('product')->readSection('web'),
        'config'
      ));
    
      parent::setup($request, $response, $context);
    }
  
    /**
     * Insert all teams into the result tree.
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
     * @param   scriptlet.xml.XMLScriptletResponse response 
     */
    public function insertTeams($request, $response) {
      $teams= ConnectionManager::getInstance()->getByHost('uska', 0)->select('
          team_id,
          name
        from
          team
        where team_id in (%d)',
        PropertyManager::getInstance()->getProperties('product')->readArray($request->getProduct(), 'teams')
      );
      
      $response->addFormResult(Node::fromArray($teams, 'teams'));
    }
    
    /**
     * Insert event calendar into result tree.
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
     * @param   scriptlet.xml.XMLScriptletResponse response 
     */
    public function insertEventCalendar($request, $response, $team= NULL, $contextDate= NULL) {
      if (!$contextDate) $contextDate= Date::now();
      
      $month= $response->addFormResult(new Node('month', NULL, array(
        'num'   => $contextDate->getMonth(),    // Month number, e.g. 4 = April
        'year'  => $contextDate->getYear(),     // Year
        'days'  => $contextDate->toString('t'), // Number of days in the given month
        'start' => (date('w', mktime(            // Week day of the 1st of the given month
          0, 0, 0, $contextDate->getMonth(), 1, $contextDate->getYear()
        )) + 6) % 7
      )));
  
      $db= ConnectionManager::getInstance()->getByHost('uska', 0);
      $calendar= $db->query('
        select
          dayofmonth(target_date) as day,
          count(*) as numevents
        from
          event as e
        where year(target_date) = %d
          and month(target_date) = %d
          %c
        group by day',
        $contextDate->getYear(),
        $contextDate->getMonth(),
        ($team ? $db->prepare('and team_id= %d', $team) : '')
      );
      
      while ($record= $calendar->next()) {
        $month->addChild(new Node('entries', $record['numevents'], array(
          'day' => $record['day']
        )));
      }
    }
  }
?>
