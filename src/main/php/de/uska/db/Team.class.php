<?php namespace de\uska\db;

use lang\XPClass;
use rdbms\Criteria;
use rdbms\DataSet;
use rdbms\FieldType;
use rdbms\Peer;
use util\HashmapIterator;

/**
 * Class wrapper for table team, database uska
 * (This class was auto-generated, so please do not change manually)
 *
 * @purpose  Datasource accessor
 */
class Team extends DataSet {
  public
    $team_id            = 0,
    $name               = '';

  protected
    $cache= array(
      'EventTeam' => array(),
      'PlayerTeam' => array(),
    );

  static function __static() { 
    with ($peer= self::getPeer()); {
      $peer->setTable('team');
      $peer->setConnection('uska');
      $peer->setIdentity('team_id');
      $peer->setPrimary(array('team_id'));
      $peer->setTypes(array(
        'team_id'             => array('%d', FieldType::INT, false),
        'name'                => array('%s', FieldType::VARCHAR, false)
      ));
      $peer->setRelations(array(
        'EventTeam' => array(
          'classname' => 'de.uska.db.Event',
          'key'       => array(
            'team_id' => 'team_id',
          ),
        ),
        'PlayerTeam' => array(
          'classname' => 'de.uska.db.Player',
          'key'       => array(
            'team_id' => 'team_id',
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
   * @param   int team_id
   * @return  de.uska.db.Team entity object
   * @throws  rdbms.SQLException in case an error occurs
   */
  public static function getByTeam_id($team_id) {
    $r= self::getPeer()->doSelect(new Criteria(array('team_id', $team_id, EQUAL)));
    return $r ? $r[0] : null;
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
   * Retrieves an array of all Event entities referencing
   * this entity by team_id=>team_id
   *
   * @return  de.uska.db.Event[] entities
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getEventTeamList() {
    if ($this->cached['EventTeam']) return array_values($this->cache['EventTeam']);
    return XPClass::forName('de.uska.db.Event')
      ->getMethod('getPeer')
      ->invoke(null)
      ->doSelect(new Criteria(
        array('team_id', $this->getTeam_id(), EQUAL)
    ));
  }

  /**
   * Retrieves an iterator for all Event entities referencing
   * this entity by team_id=>team_id
   *
   * @return  rdbms.ResultIterator<de.uska.db.Event>
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getEventTeamIterator() {
    if ($this->cached['EventTeam']) return new HashmapIterator($this->cache['EventTeam']);
    return XPClass::forName('de.uska.db.Event')
      ->getMethod('getPeer')
      ->invoke(null)
      ->iteratorFor(new Criteria(
        array('team_id', $this->getTeam_id(), EQUAL)
    ));
  }

  /**
   * Retrieves an array of all Player entities referencing
   * this entity by team_id=>team_id
   *
   * @return  de.uska.db.Player[] entities
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getPlayerTeamList() {
    if ($this->cached['PlayerTeam']) return array_values($this->cache['PlayerTeam']);
    return XPClass::forName('de.uska.db.Player')
      ->getMethod('getPeer')
      ->invoke(null)
      ->doSelect(new Criteria(
        array('team_id', $this->getTeam_id(), EQUAL)
    ));
  }

  /**
   * Retrieves an iterator for all Player entities referencing
   * this entity by team_id=>team_id
   *
   * @return  rdbms.ResultIterator<de.uska.db.Player>
   * @throws  rdbms.SQLException in case an error occurs
   */
  public function getPlayerTeamIterator() {
    if ($this->cached['PlayerTeam']) return new HashmapIterator($this->cache['PlayerTeam']);
    return XPClass::forName('de.uska.db.Player')
      ->getMethod('getPeer')
      ->invoke(null)
      ->iteratorFor(new Criteria(
        array('team_id', $this->getTeam_id(), EQUAL)
    ));
  }
}