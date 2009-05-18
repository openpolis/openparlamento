<?php

/**
 * default actions.
 *
 * @package    openparlamento
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class defaultActions extends sfActions
{
  
  /**
   * Executes index action
   *
   */
  public function executeGetLoggedUser()
  {
    sfConfig::set('sf_web_debug', false);
    $user = $this->getUser();
    $opp_user = OppUserPeer::retrieveByPK($user->getId());
    if ($user->isAuthenticated())
    {
      $this->json_out = '{"name": "' . (string)$opp_user . '"}';
    } else {
      $this->json_out = '{"err": "L\'utente corrente non e\' loggato."}';
    }
 
  }

  public function executeGraficoDistanze()
  {
    $this->tipo = $this->getRequestParameter('tipo');
    if ($this->tipo=='votes_16_C')
       $this->getResponse()->setTitle('le distanze tra i deputati - '.sfConfig::get('app_main_title'));
    else 
       $this->getResponse()->setTitle('le distanze tra i senatori - '.sfConfig::get('app_main_title'));   
  }
  
  public function executeClassifiche()
  {
   
       $this->getResponse()->setTitle('le classifiche - '.sfConfig::get('app_main_title'));   
  }
  
  public function executeIndex()
  {
    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'module', 'module', 
                                                  array('acts_filter', 'sf_admin/opp_atto/sort',
                                                        'votes_filter', 'sf_admin/opp_votazione/sort',
                                                        'pol_camera_filter', 'pol_senato_filter', 'sf_admin/opp_carica/sort',
                                                        'argomento/atti_filter', 'argomento_leggi/sort', 'argomento_nonleg/sort',
                                                        'monitoring_filter'));
   
    // ultime attivita' della community                                                    
    $this->latest_activities = CommunityNewsPeer::getLatestActivities(5);
    
    // ultime news dal parlamento
    $c = NewsPeer::getHomeNewsCriteria();
    $c->addDescendingOrderByColumn(NewsPeer::DATE);
    $itemsperpage = 7;
    $pager = new deppNewsPager('News', $itemsperpage);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->pager = $pager;  
    
    
    
    // atti e voti in evidenza
     $this->lanci=array();
     $c = new Criteria();
     $c->addDescendingOrderByColumn(sfLaunchingPeer::PRIORITY);
     $evidences=sfLaunchingPeer::doSelect($c);
     foreach ($evidences as $evidence) {
        $c1= new Criteria();
        
     	if ($evidence->getObjectModel()=='OppAtto') {
     		$c1->add(OppAttoPeer::ID,$evidence->getObjectId());
     		$this->lanci[]=array(OppAttoPeer::doSelectOne($c1),$evidence->getObjectModel());
     	}
     	else
     	{
     		$c1->add(OppVotazionePeer::ID,$evidence->getObjectId());
     		$this->lanci[]=array(OppVotazionePeer::doSelectOne($c1),$evidence->getObjectModel());
     	}
     }	
     
     // post del blog
     $this->post_pager = sfSimpleBlogPostPeer::getTaggedPager(
      'in evidenza',
      sfConfig::get('app_sfSimpleBlog_post_max_per_page', 10),
      $this->getRequestParameter('page', 1)
       ); 	
     	
     	
     
    
                                                          
  }
  
  public function executeError404()
  {
    return $this->redirect('@homepage');
  }
  
}

?>
