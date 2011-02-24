<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'scriptlet.xml.workflow.Handler',
    'de.uska.scriptlet.wrapper.EditPlayerWrapper',
    'de.uska.db.Player'
  );

  /**
   * Handler to add or edit players
   *
   * @purpose  Edit player
   */
  class EditPlayerHandler extends Handler {
      
    /**
     * Constructor.
     *
     */
    public function __construct() {
      $this->setWrapper(new EditPlayerWrapper());
      parent::__construct();
    }
    
    /**
     * Get identifier.
     *
     * @param   scriptlet.xml.workflow.WorkflowScriptletRequest request
     * @param   scriptlet.xml.Context context
     * @return  string
     */
    public function identifierFor($request, $context) {
      return $this->name.'.'.$request->getParam('player_id', 'new');
    }
    
    /**
     * Setup handler
     *
     * @param   scriptlet.xml.XMLScriptletRequest request
     * @param   scriptlet.xml.workflow.Context context
     * @return  bool
     */
    public function setup($request, $context) {
      if (
        $request->hasParam('player_id') && 
        ($player= Player::getByPlayer_id($request->getParam('player_id')))
      ) {
      
        // Check for admin permission, if not editing himself
        if (
          $player->getPlayer_id() != $context->user->getPlayer_id() &&
          !$context->hasPermission('create_player')
        ) {
          $this->addError('edit', 'permission_denied');
          return FALSE;
        }
      
        // Fetch team
        $this->setFormValue('team_id', $player->getTeam_id());
        $this->setFormValue('player_id', $player->getPlayer_id());
        $this->setFormValue('firstname', $player->getFirstName());
        $this->setFormValue('lastname', $player->getLastName());
        $this->setFormValue('username', $player->getUsername());
        $this->setFormValue('email', $player->getEmail());
        $this->setFormValue('position', $player->getPosition());
        $this->setFormValue('team_id', $player->getTeam_id());
        $this->setValue('mode', 'update');
      } else {
        $this->setFormValue('player_id', 'new');
        $this->setValue('mode', 'create');
      }
      
      // Select teams
      $prop= PropertyManager::getInstance()->getProperties('product');
      $teams= ConnectionManager::getInstance()->getByHost('uska', 0)->select('
          team_id,
          name
        from
          team
        where team_id in (%d)',
        $prop->readArray($request->getProduct(), 'teams')
      );

      $this->setValue('teams', $teams);
      return TRUE;
    }
      
    /**
     * Handle submitted data. Either create an event or update an existing one.
     *
     * @param   &scriptlet.xml.XMLScriptletRequest request
     * @param   &scriptlet.xml.workflow.Context context
     * @return  bool
     */
    public function handleSubmittedData($request, $context) {
      $cat= Logger::getInstance()->getCategory();
      
      switch ($this->getValue('mode')) {
        case 'update':
          $player= Player::getByPlayer_id($this->wrapper->getPlayer_id());
          break;
        
        case 'create':
        default:
          $player= new Player();
          $player->setPlayer_type_id(1);  // Normal player
          break;
      }
      
      // Take over new values
      $player->setFirstName($this->wrapper->getFirstname());
      $player->setLastName($this->wrapper->getLastname());
      
      // Only admins may change usernames
      if (
        strlen($this->wrapper->getUsername()) &&
        $context->hasPermission('create_player')
      ) {
        $player->setUsername($this->wrapper->getUsername());
      }
      
      // Update password only if new one is given
      if (strlen ($this->wrapper->getPassword())) {
        $player->setPassword(md5($this->wrapper->getPassword()));
      }
      
      // update email, remember old one for ezmlm updates
      $email= $this->wrapper->getEmail();
      $oldemail= NULL;
      if ($player->getEmail() != $email->localpart.'@'.$email->domain) $oldemail= $player->getEmail();
      $player->setEmail($email->localpart.'@'.$email->domain);
      $player->setPosition($this->wrapper->getPosition());
      $player->setTeam_id($this->wrapper->getTeam_id());
      
      if (NULL === $player->getCreated_by()) {
        $player->setCreated_by($context->user->getPlayer_id());
      }
      
      $player->setChangedby($context->user->getUsername());
      $player->setLastchange(Date::now());
      
      // Now insert or update...
      try {
        $transaction= Player::getPeer()->getConnection()->begin(new Transaction('editplayer'));
        
        if ($this->getValue('mode') == 'update') {
          $player->update();
        } else {
          $player->insert();
        }
      } catch (SQLException $e) {
        $transaction->rollback();
        $this->addError('dberror', '*', $e->getMessage());
        return FALSE;
      }
      
      $transaction->commit();
      return TRUE;
    }
  }
?>
