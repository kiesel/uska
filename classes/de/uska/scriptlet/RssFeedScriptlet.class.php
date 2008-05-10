<?php
/* This class is part of the XP framework
 *
 * $Id: WebsiteScriptlet.class.php 8974 2006-12-27 17:29:09Z friebe $ 
 */

  uses(
    'net.xp_framework.util.markup.MarkupBuilder',
    'scriptlet.HttpScriptlet',
  	'xml.rdf.RDFNewsFeed'
  );

  /**
   * Website scriptlet for http://xp-framework.info/
   *
   * @see      http://xp-framework.info/
   * @purpose  Scriptlet
   */
  class RssFeedScriptlet extends HttpScriptlet {
    const
      DEFAULT_TEAM  = 1;
      
    /**
     * Sanitize output for use in a URL
     *
     * @param   string name
     * @return  string
     */
    protected function sanitizeHref($name) {
      return preg_replace('#[^a-zA-Z0-9\-\._]#', '_', $name);
    }
    
    /**
     * Processes the request
     *
     * @param   rdbms.DBConnection db
     * @param   int id 
     */
    public function fetchEntries($db, $id) {
      return $db->query('
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
          and t.team_id= %d
          and e.target_date >= now()
        order by e.target_date asc
        limit 0, 5
        ',
        $id
      );
    }
  
    public function doGet($request, $response) {
      $db= ConnectionManager::getInstance()->getByHost('uska', 0);
      $teamId= $request->getParam('c', self::DEFAULT_TEAM);
      $q= $this->fetchEntries($db, $teamId);
      
      $feed= new RDFNewsFeed();
      $url= $request->getURL();
      
      $feed->setChannel(
      	'Trainings',
      	sprintf('%s://%s/events',
      	  $url->getScheme(),
      	  $url->getHost()
      	),
      	'XP Framework',
      	NULL,
      	'de-DE',
      	'devnull@schlund.de'
      );
      
      $seen= array();
      
      // Add items to feed, build markup
      $markupBuilder= new MarkupBuilder();
      while ($q && $r= $q->next()) {
        if (isset($seen[$r['event_id']])) continue;

      	$feed->addItem(
      	  $r['name'],
      	  sprintf('%s://%s/xml/event/view?%d',
      	    $url->getScheme(),
      	    $url->getHost(),
      	    $r['event_id']
      	  ),
      	  $markupBuilder->markupFor($r['description']),
      	  $r['target_date']
      	);
      	$seen[$r['id']]= TRUE;
      }
      
      // Write out prepared tree
      $response->setHeader('Content-type', 'application/xml; charset=iso-8859-1');
      
      $rdf= $feed->getDeclaration()."\n".$feed->getSource(0);
      $response->setHeader('Content-length', strlen($rdf));
      $response->write($rdf);
    }
  }
?>
