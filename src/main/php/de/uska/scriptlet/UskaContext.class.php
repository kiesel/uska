<?php namespace de\uska\scriptlet;

use de\uska\db\Player;
use rdbms\ConnectionManager;
use scriptlet\Cookie;
use scriptlet\xml\workflow\Context;
use util\PropertyManager;
use xml\Node;

/**
 * Provide context information for uska.
 *
 * @purpose  Uska context
 */
class UskaContext extends Context {
  public
    $user=          null,
    $permissions=   null,
    $eventtypes=    array();
  
  /**
   * Set up the context.
   *
   * @param   scriptlet.xml.XMLScriptletRequest request
   */
  public function setup($request) {
    $cm= ConnectionManager::getInstance();
    $db= $cm->getByHost('uska', 0);
    
    $this->eventtypes= array();
    $q= $db->query('select event_type_id, name, description from event_type');
    while ($q && $r= $q->next()) { $this->eventtypes[$r['event_type_id']]= array(
      'type'  => $r['name'],
      'name'  => $r['description']
      );
    }
  }
  
  /**
   * Process the context.
   *
   * @param   scriptlet.HttpScriptletRequest request
   * @throws  lang.IllegalAccessException to indicate an error
   */
  public function process($request) {
  }

  /**
   * Insert status information to result tree
   *
   * @param   scriptlet.xml.XMLScriptletResponse response
   */
  public function insertStatus($response) {
    if (isset($this->_forwardTo)) {

      // Forward to same page without session (session hijacking)
      $response->sendRedirect($this->_forwardTo);
      return;
    }
    
    if ($this->user) {
      $n= $response->addFormResult(Node::fromObject($this->user, 'user'));
      $n->addChild(Node::fromArray(array_keys($this->permissions), 'permissions'));
    }
    
    $enode= $response->addFormResult(new \node('eventtypes'));
    foreach ($this->eventtypes as $id => $desc) {
      $enode->addChild(new Node('type', $desc['name'], array(
        'id' => $id,
        'type' => $desc['type']
      )));
    }
  }
  
  /**
   * Set user.
   *
   * @param   de.uska.db.Player user
   */
  public function setUser($user) {
    $this->user= $user;
    $this->setChanged();
  }
  
  /**
   * Set permissions
   *
   * @param   array perms
   */
  public function setPermissions($perm) {
    $this->permissions= $perm;
    $this->setChanged();
  }
  
  /**
   * Check whether user has a certain permission
   *
   * @param   string name
   * @return  bool
   */
  public function hasPermission($name) {
    return isset($this->permissions[$name]);
  }
  
  /**
   * Authenticate user by password
   *
   * @param   de.uska.db.Player player
   * @param   string password
   * @return  bool
   */
  public function authenticateUserByPassword($player, $password) {
    if (!$player instanceof Player) return false;
    if ($player->getPassword() != md5($password)) return false;
  
    return $this->authenticateUser($player);
  }    
  
  /**
   * Authenticate user by cookie
   *
   * @param   scriptlet.Cookie cookie
   * @return  bool
   */
  public function authenticateUserByCookie(Cookie $cookie) {
    list ($username, $hash)= explode('|', $cookie->getValue());
    if ($hash !== md5($username.PropertyManager::getInstance()->getProperties('product')->readString('login', 'secret')))
      return false;

    return $this->authenticateUser(Player::getByUsername($username));
  }
  
  /**
   * Perform user login
   *
   * @param   de.uska.db.Player player
   * @return  bool
   */
  protected function authenticateUser(Player $player) {
    if (!$player instanceof Player) return false;
    if ($player->getBz_id() != 20000) return false;
  
    $this->setUser($player);
    $perms= ConnectionManager::getInstance()->getByHost('uska', 0)->select('
        p.name
      from
        plain_right_matrix as prm,
        permission as p
      where p.permission_id= prm.permission_id
        and prm.player_id= %d',
      $player->getPlayer_id()
    );
    
    $cperms= array();
    foreach ($perms as $p) { $cperms[$p['name']]= true; }
    $this->setPermissions($cperms);
    
    return true;
  }
}