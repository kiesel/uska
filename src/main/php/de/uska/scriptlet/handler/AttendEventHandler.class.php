<?php namespace de\uska\scriptlet\handler;

use de\uska\db\Event;
use de\uska\db\Event_attendee;
use de\uska\db\Player;
use de\uska\scriptlet\wrapper\AttendEventWrapper;
use rdbms\SQLException;
use rdbms\Transaction;
use scriptlet\xml\workflow\Handler;
use util\Date;

/**
 * Set information about attendee status of player or guest.
 *
 * @purpose  Attend event
 */
class AttendEventHandler extends Handler {

  /**
   * Constructor.
   *
   */
  public function __construct() {
    $this->setWrapper(new AttendEventWrapper());
    parent::__construct();
  }
  
  /**
   * Retrieve identifier.
   *
   * @param   scriptlet.xml.XMLScriptletRequest request
   * @param   scriptlet.xml.workflow.Context context
   * @return  string
   */
  public function identifierFor($request, $context) {
    return $this->name.'.'.$request->getParam('event_id');
  }
  
  /**
   * Setup handler
   *
   * @param   scriptlet.xml.XMLScriptletRequest request
   * @param   scriptlet.xml.workflow.Context context
   * @return  bool
   */
  public function setup($request, $context) {
    $this->setFormValue('offers_seats', 0);
    if ($request->hasParam('guest')) $this->setValue('mode', 'addguest');

    $player_id= $context->user->getPlayer_id();
    
    // Check when editing foreign records
    if ($request->hasParam('player_id') && $request->getParam('player_id') != $player_id) {
      $player= Player::getByPlayer_id($request->getParam('player_id'));

      // Check that the user either has admin privileges, or is the creator
      // of the chosen guest player
      if (
        $context->hasPermission('create_player') || 
        ($player->getPlayer_type_id() == 2 && $player->getCreated_by() == $context->user->getPlayer_id())
      ) {
        $player_id= $request->getParam('player_id');
      }
    }
    
    // Fetch player if not previously fetched
    if (!$player instanceof Player) $player= Player::getByPlayer_id($player_id);
    
    // Check if we're updating or inserting later
    $attendee= Event_attendee::getByEvent_idPlayer_id($request->getParam('event_id'), $player_id);
    
    if ($attendee instanceof Event_attendee) {
      $this->setFormValue('attend', $attendee->getAttend());
      $this->setFormValue('offers_seats', $attendee->getOffers_seats());
      $this->setFormValue('needs_seat', $attendee->getNeeds_driver());
      $this->setFormValue('fetch_key', $attendee->getFetch_key());
      
      if ($this->getValue('mode') != 'addguest') {
        $this->setFormvalue('firstname', $player->getFirstname());
        $this->setFormValue('lastname', $player->getLastname());
      }
    }
    
    // Check that this event is still in the future. If not, only admins may change
    // the attending status
    $event= Event::getByEvent_id($request->getParam('event_id'));
    $deadline_date= $event->getDeadline();
    $target_date= $event->getTarget_date();
    if ((($deadline_date && $deadline_date->isBefore(Date::now())) || $target_date->isBefore(Date::now())) && !$context->hasPermission('create_event')) {
      $this->addError('date_expired', '*');
      return false;
    }

    $this->setValue('event_id', $request->getParam('event_id'));
    $this->setValue('player_id', $player_id);
    
    return true;
  }

  /**
   * Handle submitted data. Either create an event or update an existing one.
   *
   * @param   scriptlet.xml.XMLScriptletRequest request
   * @param   scriptlet.xml.workflow.Context context
   * @return  bool
   */
  public function handleSubmittedData($request, $context) {
    
    // Either user requires a driver or he can offer seats - not both.
    if ($this->wrapper->getNeeds_seat() && $this->wrapper->getOffers_seats() > 0) {
      $this->addError('mutex-fail', 'needs_seat');
      $this->addError('mutex-fail', 'offers_seats');
    }
    
    if (
      'addguest' == $this->getValue('mode') &&
      (0 == strlen($this->wrapper->getFirstname()) || 0 == strlen($this->wrapper->getLastname()))
    ) {
      $this->addError('missing', 'firstname');
      $this->addError('missing', 'lastname');
    }
    
    // Check if this is a guest attendee
    $event= Event::getByEvent_id($this->wrapper->getEvent_id());
    if ('addguest' == $this->getValue('mode')) {

      // Prevent adding guests to events without such.
      if (!$event->getAllow_guests()) {
        $this->addError('no_guests');
      }
    }

    if ($this->errorsOccured()) return false;
    
    $attendee= $this->wrapper->getPlayer_id();
    $transaction= Player::getPeer()->getConnection()->begin(new Transaction('attend'));
    try {
      
      if ('addguest' == $this->getValue('mode')) {

        // Create guest player
        $player= new Player();
        $player->setFirstname($this->wrapper->getFirstname());
        $player->setLastname($this->wrapper->getLastname());
        $player->setCreated_by($context->user->getPlayer_id());
        $player->setTeam_id($context->user->getTeam_id());
        $player->setChangedby($context->user->getUsername());
        $player->setLastchange(Date::now());
        $player->setPlayer_type_id(2);  // Guest
        $player->insert();
        
        $attendee= $player->getPlayer_id();
      }
      
      $eventattend= Event_attendee::getByEvent_idPlayer_id($this->wrapper->getEvent_id(), $attendee);
      if (!$eventattend instanceof Event_attendee) {
        $eventattend= new Event_attendee();
        $eventattend->setEvent_id($this->wrapper->getEvent_id());
        $eventattend->setPlayer_id($attendee);
      }
      
      $eventattend->setAttend($this->wrapper->getAttend());
      $eventattend->setOffers_seats($this->wrapper->getOffers_seats());
      $eventattend->setNeeds_driver((int)$this->wrapper->getNeeds_seat());
      $eventattend->setFetch_key((int)$this->wrapper->getFetch_key());
      $eventattend->setChangedby($context->user->getUsername());
      $eventattend->setLastchange(Date::now());
      $eventattend->save();
      
      $transaction->commit();
      return true;
    } catch (SQLException $e) {
      $transaction->rollback();
      throw $e;
    }
  }
  
  /**
   * In case of success, redirect the user to the event's page.
   *
   * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request 
   * @param   scriptlet.xml.XMLScriptletResponse response 
   * @param   scriptlet.xml.Context context
   */
  public function finalize($request, $response, $context) {
    $response->forwardTo('event/view', $this->getValue('event_id'));
  }
}