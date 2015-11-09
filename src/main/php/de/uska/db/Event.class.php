<?php namespace de\uska\db;

use lang\XPClass;
use rdbms\Criteria;
use rdbms\DataSet;
use rdbms\FieldType;
use rdbms\Peer;
use util\HashmapIterator;

/**
 * Class wrapper for table event, database uska
 * (This class was auto-generated, so please do not change manually)
 *
 * @purpose  Datasource accessor
 */
class Event extends DataSet {
  public
    $event_id           = 0,
    $team_id            = 0,
    $name               = '',
    $description        = null,
    $target_date        = null,
    $deadline           = null,
    $max_attendees      = null,
    $req_attendees      = null,
    $allow_guests       = null,
    $event_type_id      = 0,
    $changedby          = '',
    $lastchange         = null;

  protected
    $cache= array(
      'Team' => array(),
      'Event_type' => array(),
      'Event_attendeeEvent' => array(),
      'Event_pointsEvent' => array(),
      'Event_type_aclEvent_type' => array(),
    );

  static function __static() { 
    with ($peer= self::getPeer()); {
      $peer->setTable('event');
      $peer->setConnection('uska');
      $peer->setIdentity('event_id');
      $peer->setPrimary(array('event_id'));
      $peer->setTypes(array(
        'event_id'            => array('%d', FieldType::INT, false),
        'team_id'             => array('%d', FieldType::INT, false),
        'name'                => array('%s', FieldType::VARCHAR, false),
        'description'         => array('%s', FieldType::TEXT, true),
        'target_date'         => array('%s', FieldType::DATETIME, false),
        'deadline'            => array('%s', FieldType::DATETIME, true),
        'max_attendees'       => array('%d', FieldType::INT, true),
        'req_attendees'       => array('%d', FieldType::INT, true),
        'allow_guests'        => array('%d', FieldType::INT, true),
        'event_type_id'       => array('%d', FieldType::INT, false),
        'changedby'           => array('%s', FieldType::VARCHAR, false),
        'lastchange'          => array('%s', FieldType::DATETIME, false)
      ));
      $peer->setRelations(array(
        'Team' => array(
          'classname' => 'de.uska.db.Team',
          'key'       => array(
            'team_id' => 'team_id',
          ),
        ),
        'Event_type' => array(
          'classname' => 'de.uska.db.Event_type',
          'key'       => array(
            'event_type_id' => 'event_type_id',
          ),
        ),
        'Event_attendeeEvent' => array(
          'classname' => 'de.uska.db.Event_attendee',
          'key'       => array(
            'event_id' => 'event_id',
          ),
        ),
        'Event_pointsEvent' => array(
          'classname' => 'de.uska.db.Event_points',
          'key'       => array(
            'event_id' => 'event_id',
          ),
        ),
        'Event_type_aclEvent_type' => array(
          'classname' => 'de.uska.db.Event_type_acl',
          'key'       => array(
            'event_type_id' => 'event_type_id',
          ),
        ),
      ));
    }
  }  

  /**
   * Retrieve associated peer
   *
   * @return  rdbms.Peer
   */
  public static function getPeer() {
    return Peer::forName(__CLASS__);
  }

  /**
   * column factory
   *
   * @param   string name
   * @return  rdbms.Column
   * @throws  lang.IllegalArgumentException
   */
  public static function column($name) {
    return Peer::forName(__CLASS__)->column($name);
  }

  /**
   * Gets an instance of this object by index "PRIMARY"
   * 
   * @param   int event_id
   * @return  de.uska.db.Event entity object
   * @throws  rdbms.SQLException in case an error occurs
   */
  public static function getByEvent_id($event_id) {
    $r= self::getPeer()->doSelect(new Criteria(array('event_id', $event_id, EQUAL)));
    return $r ? $r[0] : null;
  }

  /**
   * Gets an instance of this object by index "target_date"
   * 
   * @param   util.Date target_date
   * @return  de.uska.db.Event[] entity objects
   * @throws  rdbms.SQLException in case an error occurs
   */
  public static function getByTarget_date($target_date) {
    return self::getPeer()->doSelect(new Criteria(array('target_date', $target_date, EQUAL)));
  }

  /**
   * Gets an instance of this object by index "team_id"
   * 
   * @param   int team_id
   * @return  de.uska.db.Event[] entity objects
   * @throws  rdbms.SQLException in case an error occurs
   */
  public static function getByTeam_id($team_id) {
    return self::getPeer()->doSelect(new Criteria(array('team_id', $team_id, EQUAL)));
  }

  /**
   * Gets an instance of this object by index "event_type_id"
   * 
   * @param   int event_type_id
   * @return  de.uska.db.Event[] entity objects
   * @throws  rdbms.SQLException in case an error occurs
   */
  public static function getByEvent_type_id($event_type_id) {
    return self::getPeer()->doSelect(new Criteria(array('event_type_id', $event_type_id, EQUAL)));
  }

  /**
   * Retrieves event_id
   *
   * @return  int
   */
  public function getEvent_id() {
    return $this->event_id;
  }
    
  /**
   * Sets event_id
   *
   * @param   int event_id
   * @return  int the previous value
   */
  public function setEvent_id($event_id) {
    return $this->_change('event_id', $event_id);
  }

  /**
   * Retrieves team_id
   *
   * @return  int
   */
  public function getTeam_id() {
    return $this->team_id;
  }
    
  /**
   * Sets team_id
   *
   * @param   int team_id
   * @return  int the previous value
   */
  public function setTeam_id($team_id) {
    return $this->_change('team_id', $team_id);
  }

  /**
   * Retrieves name
   *
   * @return  string
   */
  public function getName() {
    return $this->name;
  }
    
  /**
   * Sets name
   *
   * @param   string name
   * @return  string the previous value
   */
  public function setName($name) {
    return $this->_change('name', $name);
  }

  /**
   * Retrieves description
   *
   * @return  string
   */
  public function getDescription() {
    return $this->description;
  }
    
  /**
   * Sets description
   *
   * @param   string description
   * @return  string the previous value
   */
  public function setDescription($description) {
    return $this->_change('description', $description);
  }

  /**
   * Retrieves target_date
   *
   * @return  util.Date
   */
  public function getTarget_date() {
    return $this->target_date;
  }
    
  /**
   * Sets target_date
   *
   * @param   util.Date target_date
   * @return  util.Date the previous value
   */
  public function setTarget_date($target_date) {
    return $this->_change('target_date', $target_date);
  }

  /**
   * Retrieves deadline
   *
   * @return  util.Date
   */
  public function getDeadline() {
    return $this->deadline;
  }
    
  /**
   * Sets deadline
   *
   * @param   util.Date deadline
   * @return  util.Date the previous value
   */
  public function setDeadline($deadline) {
    return $this->_change('deadline', $deadline);
  }

  /**
   * Retrieves max_attendees
   *
   * @return  int
   */
  public function getMax_attendees() {
    return $this->max_attendees;
  }
    
  /**
   * Sets max_attendees
   *
   * @param   int max_attendees
   * @return  int the previous value
   */
  public function setMax_attendees($max_attendees) {
    return $this->_change('max_attendees', $max_attendees);
  }

  /**
   * Retrieves req_attendees
   *
   * @return  int
   */
  public function getReq_attendees() {
    return $this->req_attendees;
  }
    
  /**
   * Sets req_attendees
   *
   * @param   int req_attendees
   * @return  int the previous value
   */
  public function setReq_attendees($req_attendees) {
    return $this->_change('req_attendees', $req_attendees);
  }

  /**
   * Retrieves allow_guests
   *
   * @return  int
   */
  public function getAllow_guests() {
    return $this->allow_guests;
  }
    
  /**
   * Sets allow_guests
   *
   * @param   int allow_guests
   * @return  int the previous value
   */
  public function setAllow_guests($allow_guests) {
    return $this->_change('allow_guests', $allow_guests);
  }

  /**
   * Retrieves event_type_id
   *
   * @return  int
   */
  public function getEvent_type_id() {
    return $this->event_type_id;
  }
    
  /**
   * Sets event_type_id
   *
   * @param   int event_type_id
   * @return  int the previous value
   */
  public function setEvent_type_id($event_type_id) {
    return $this->_change('event_type_id', $event_type_id);
  }

  /**
   * Retrieves changedby
   *
   * @return  string
   */
  public function getChangedby() {
    return $this->changedby;
  }
    
  /**
   * Sets changedby
   *
   * @param   string changedby
   * @return  string the previous value
   */
  public function setChangedby($changedby) {
    return $this->_change('changedby', $changedby);
  }

  /**
   * Retrieves lastchange
   *
   * @return  util.Date
   */
  public function getLastchange() {
    return $this->lastchange;
  }
    
  /**
   * Sets lastchange
   *
   * @param   util.Date lastchange
   * @return  util.Date the previous value
   */
  public function setLastchange($lastchange) {
    return $this->_change('lastchange', $lastchange);
  }

  /**
   * Retrieves the Team entity
   * referenced by team_id=>team_id
   *
   * @return  de.uska.db.Team entity
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getTeam() {
    $r= ($this->cached['Team']) ?
      array_values($this->cache['Team']) :
      XPClass::forName('de.uska.db.Team')
        ->getMethod('getPeer')
        ->invoke(null)
        ->doSelect(new Criteria(
        array('team_id', $this->getTeam_id(), EQUAL)
    ));
    return $r ? $r[0] : null;
  }

  /**
   * Retrieves the Event_type entity
   * referenced by event_type_id=>event_type_id
   *
   * @return  de.uska.db.Event_type entity
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getEvent_type() {
    $r= ($this->cached['Event_type']) ?
      array_values($this->cache['Event_type']) :
      XPClass::forName('de.uska.db.Event_type')
        ->getMethod('getPeer')
        ->invoke(null)
        ->doSelect(new Criteria(
        array('event_type_id', $this->getEvent_type_id(), EQUAL)
    ));
    return $r ? $r[0] : null;
  }

  /**
   * Retrieves an array of all Event_attendee entities referencing
   * this entity by event_id=>event_id
   *
   * @return  de.uska.db.Event_attendee[] entities
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getEvent_attendeeEventList() {
    if ($this->cached['Event_attendeeEvent']) return array_values($this->cache['Event_attendeeEvent']);
    return XPClass::forName('de.uska.db.Event_attendee')
      ->getMethod('getPeer')
      ->invoke(null)
      ->doSelect(new Criteria(
        array('event_id', $this->getEvent_id(), EQUAL)
    ));
  }

  /**
   * Retrieves an iterator for all Event_attendee entities referencing
   * this entity by event_id=>event_id
   *
   * @return  rdbms.ResultIterator<de.uska.db.Event_attendee>
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getEvent_attendeeEventIterator() {
    if ($this->cached['Event_attendeeEvent']) return new HashmapIterator($this->cache['Event_attendeeEvent']);
    return XPClass::forName('de.uska.db.Event_attendee')
      ->getMethod('getPeer')
      ->invoke(null)
      ->iteratorFor(new Criteria(
        array('event_id', $this->getEvent_id(), EQUAL)
    ));
  }

  /**
   * Retrieves an array of all Event_points entities referencing
   * this entity by event_id=>event_id
   *
   * @return  de.uska.db.Event_points[] entities
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getEvent_pointsEventList() {
    if ($this->cached['Event_pointsEvent']) return array_values($this->cache['Event_pointsEvent']);
    return XPClass::forName('de.uska.db.Event_points')
      ->getMethod('getPeer')
      ->invoke(null)
      ->doSelect(new Criteria(
        array('event_id', $this->getEvent_id(), EQUAL)
    ));
  }

  /**
   * Retrieves an iterator for all Event_points entities referencing
   * this entity by event_id=>event_id
   *
   * @return  rdbms.ResultIterator<de.uska.db.Event_points>
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getEvent_pointsEventIterator() {
    if ($this->cached['Event_pointsEvent']) return new HashmapIterator($this->cache['Event_pointsEvent']);
    return XPClass::forName('de.uska.db.Event_points')
      ->getMethod('getPeer')
      ->invoke(null)
      ->iteratorFor(new Criteria(
        array('event_id', $this->getEvent_id(), EQUAL)
    ));
  }

  /**
   * Retrieves an array of all Event_type_acl entities referencing
   * this entity by event_type_id=>event_type_id
   *
   * @return  de.uska.db.Event_type_acl[] entities
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getEvent_type_aclEvent_typeList() {
    if ($this->cached['Event_type_aclEvent_type']) return array_values($this->cache['Event_type_aclEvent_type']);
    return XPClass::forName('de.uska.db.Event_type_acl')
      ->getMethod('getPeer')
      ->invoke(null)
      ->doSelect(new Criteria(
        array('event_type_id', $this->getEvent_type_id(), EQUAL)
    ));
  }

  /**
   * Retrieves an iterator for all Event_type_acl entities referencing
   * this entity by event_type_id=>event_type_id
   *
   * @return  rdbms.ResultIterator<de.uska.db.Event_type_acl>
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getEvent_type_aclEvent_typeIterator() {
    if ($this->cached['Event_type_aclEvent_type']) return new HashmapIterator($this->cache['Event_type_aclEvent_type']);
    return XPClass::forName('de.uska.db.Event_type_acl')
      ->getMethod('getPeer')
      ->invoke(null)
      ->iteratorFor(new Criteria(
        array('event_type_id', $this->getEvent_type_id(), EQUAL)
    ));
  }
}