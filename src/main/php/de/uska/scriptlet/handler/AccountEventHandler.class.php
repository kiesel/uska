<?php namespace de\uska\scriptlet\handler;

use de\uska\scriptlet\wrapper\AccountEventWrapper;
use rdbms\ConnectionManager;
use rdbms\SQLException;
use rdbms\Transaction;
use scriptlet\xml\workflow\Handler;

/**
 * Handler. <Add description>
 *
 * @purpose  <Add purpose>
 */
class AccountEventHandler extends Handler {

  /**
   * Constructor
   *
   */
  public function __construct() {
    parent::__construct();
    $this->setWrapper(new AccountEventWrapper());
  }
  
  /**
   * Retrieve identifier.
   *
   * @param   scriptlet.xml.XMLScriptletRequest request
   * @param   scriptlet.xml.workflow.Context context
   * @return  string
   */
  public function identifierFor($request, $context) {
    return $this->name.'#'.$request->getParam('event_id');
  }
  
  /**
   * Setup handler.
   *
   * @param   scriptlet.xml.XMLScriptletRequest request
   * @param   scriptlet.xml.workflow.Context context
   * @return  bool
   */
  public function setup($request, $context) {
    if (!$context->hasPermission('edit_points')) return false;
    $cm= ConnectionManager::getInstance();
    
    $event_id= $request->getParam('event_id');
    
    try {
      $db= $cm->getByHost('uska', 0);
      
      $query= $db->query('
        select
          p.player_id,
          p.firstname,
          p.lastname,
          e.points
        from
          player as p,
          event_attendee as a left outer join event_points as e
            on a.player_id= e.player_id
            and a.event_id= e.event_id
        where p.player_id= a.player_id
          and p.player_type_id= 1
          and a.attend= 1
          and a.event_id= %d
        order by p.lastname, p.firstname
        ',
        $event_id
      );
      
      $players= array();
      while ($query && $record= $query->next()) {
        $players[]= $record;
        
        if (is_numeric($record['points'])) {
          $this->setFormValue(sprintf('points[player_%d]', $record['player_id']), $record['points']);
        }
      }
    } catch (SQLException $e) {
      throw($e);
    }
    
    $this->setValue('players', $players);
    return true;
  }
  
  /**
   * Handle submitted data.
   *
   * @param   scriptlet.xml.XMLScriptletRequest request
   * @param   scriptlet.xml.workflow.Context context
   * @return  bool
   */
  public function handleSubmittedData($request, $context) {
    $cm= ConnectionManager::getInstance();
    try {
      $db= $cm->getByHost('uska', 0);
      
      $transaction= $db->begin(new Transaction('updpoints'));
      
      $submitted= $request->getParam('points');
      foreach ($this->getValue('players') as $p) {
        if (!isset($submitted[sprintf('player_%d', $p['player_id'])])) continue;
        
        $db->query('
          replace into event_points (
            event_id,
            player_id,
            points,
            lastchange,
            changedby
          ) values (
            %d,
            %d,
            %d,
            now(),
            %s
          )
          ',
          $this->getValue('event_id'),
          $p['player_id'],
          $submitted[sprintf('player_%d', $p['player_id'])],
          $context->user->getUsername().'@'.$this->getClassName()
        );
      }
    } catch (SQLException $e) {
      $this->addError($e->getMessage());
      $transaction->rollback();
      return false;
    }
    
    $transaction->commit();
    return true;
  }
  
  /**
   * In case of success, redirect the user to the event's point page.
   *
   * @param   &scriptlet.xml.workflow.WorkflowScriptletRequest request 
   * @param   &scriptlet.xml.XMLScriptletResponse response 
   * @param   &scriptlet.xml.Context context
   */
  public function finalize($request, $response, $context) {
    $response->forwardTo('event/viewpoints', 'event_id='.$this->getValue('event_id'));
  }
}