<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'de.uska.scriptlet.state.UskaState',
    'de.uska.markup.FormresultHelper'
  );

  /**
   * Events state
   *
   * @purpose  Display list of events
   */
  class EventsState extends UskaState {
  
    /**
     * Process this state.
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
     * @param   scriptlet.xml.XMLScriptletResponse response 
     * @param   scriptlet.xml.Context context
     */
    public function process($request, $response, $context) {
      // FIXME: Put into ini-file?
      static $types= array(
        'training'    => 1,
        'tournament'  => 2,
        'misc'        => 3,
        'enbw'        => 4
      );
      parent::process($request, $response, $context);
      
      $team= FALSE;
      $type= FALSE;
      $all=  FALSE;
      $day=  NULL;
      
      list($year, $month)= explode('-', Date::now()->toString('Y-m-d'));
      with ($env= $request->getQueryString()); {
        if (strlen($env)) @list($type, $all, $team, $year, $month, $day)= explode(',', $env);
      }

      $db= ConnectionManager::getInstance()->getByHost('uska', 0);
      $q= $db->query('
        select
          e.event_id,
          e.team_id,
          t.name as teamname,
          e.name,
          e.description,
          e.target_date,
          e.deadline,
          e.max_attendees,
          e.req_attendees,
          e.allow_guests,
          e.event_type_id,
          e.lastchange,
          e.changedby
        from
          event as e,
          team as t
        where t.team_id= e.team_id
          %c
          %c
          %c
          %c
          %c
          %c
        order by e.target_date asc
        ',
        ($team ? $db->prepare('and e.team_id= %d', $team) : ''),
        ($type && isset($types[$type]) ? $db->prepare('and e.event_type_id= %d', $types[$type]) : ''),
        ($all  ? '' : $db->prepare('and e.target_date > now()')),
        ($year ? $db->prepare('and year(e.target_date)= %d', $year) : ''),
        ($month ? $db->prepare('and month(e.target_date)= %d', $month) : ''),
        ($day  ? $db->prepare('and day(e.target_date)= %d', $day) : '')
      );
      
      $events= $response->addFormResult(new Node('events', NULL, array(
        'team'  => intval($team),
        'type'  => ($type ? $type : '0'),
        'all'   => intval($all),
        'year'  => intval($year),
        'month' => intval($month),
        'day'   => intval($day)
      )));
      while ($record= $q->next()) {
        $description= $record['description'];
        unset($record['description']);
        
        $n= $events->addChild(Node::fromArray($record, 'event'));
        $n->addChild(FormresultHelper::markupNodeFor('description', $description));
      }
      
      // Create context date
      $date= NULL;
      if ($year && $month) {
        $date= Date::fromString(sprintf('%d-%d-%d',
          $year,
          $month,
          $day ? $day : 1
        ));
      }
      
      $this->insertEventCalendar($request, $response, $team, $date);
    }
  }
?>
