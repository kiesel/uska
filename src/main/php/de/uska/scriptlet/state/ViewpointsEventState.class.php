<?php namespace de\uska\scriptlet\state;

use de\uska\db\Event;
use de\uska\markup\FormresultHelper;
use de\uska\scriptlet\state\UskaState;
use rdbms\ConnectionManager;
use xml\Node;

/**
 * View details for an event
 *
 * @purpose  View event
 */
class ViewpointsEventState extends UskaState {
  
  /**
   * Process this state.
   *
   * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
   * @param   scriptlet.xml.XMLScriptletResponse response 
   * @param   scriptlet.xml.Context context
   * @return  bool
   */
  public function process($request, $response, $context) {
    parent::process($request, $response, $context);
    
    $eventid= $request->getParam('event_id', 0);
    $teamid= $request->getParam('team_id', 0);
    
    // Bail out
    if (!$eventid && !$teamid) return true;
    
    $eventid && $event= Event::getByEvent_id($eventid);

    $db= ConnectionManager::getInstance()->getByHost('uska', 0);
    $query= $db->query('
      select
        p.player_id,
        p.firstname,
        p.lastname,
        sum(t.points) as points,
        count(*) as attendcount
      from
       player as p,
       event_points as t,
       event as e
      where t.player_id= p.player_id
        and t.event_id= e.event_id
        and e.event_type_id= 1      -- training
        %1$c
        %2$c
      group by
        p.player_id
      order by
        lastname, firstname
      ',
      ($eventid ? $db->prepare('and t.event_id= %d', $event->getEvent_id()) : ''),
      ($teamid ? $db->prepare('and e.team_id= %d', $teamid) : '')
    );
    
    // Convert event object into array, so we can add it without
    // the description member (which needs markup processing)
    if ($event) {
      $eventarr= (array)$event;
      unset($eventarr['description']);
      
      // Protection against private / protected members
      foreach ($eventarr as $key => $value) {
        if (false !== strpos($key, "\0")) unset($eventarr[$key]);
      }

      $node= $response->addFormResult(Node::fromArray($eventarr, 'event'));
      $node->addChild(FormresultHelper::markupNodeFor('description', $event->getDescription()));
    }
    
    $n= $response->addFormResult(new Node('attendeeinfo'));
    while ($query && $record= $query->next()) {
      $t= $n->addChild(new Node('player', null, $record));
    }
  }
}