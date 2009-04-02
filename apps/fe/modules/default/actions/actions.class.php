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
      $this->json_out = '{"name": "' . $opp_user->getFirstName().' '.$opp_user->getLastName() . '"}';
    } else {
      $this->json_out = '{"err": "L\'utente corrente non e\' loggato."}';
    }
 
  }

  
  public function executeIndex()
  {
    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'module', 'module', 
                                                  array('acts_filter', 'sf_admin/opp_atto/sort',
                                                        'votes_filter', 'sf_admin/opp_votazione/sort',
                                                        'pol_camera_filter', 'pol_senato_filter', 'sf_admin/opp_carica/sort',
                                                        'argomento/atti_filter', 'argomento_leggi/sort', 'argomento_nonleg/sort',
                                                        'monitoring_filter'));
                                                        
    $this->latest_activities = CommunityNewsPeer::getLatestActivities(10);                                                    
  }
  
  public function executeError404()
  {
    return $this->redirect('@homepage');
  }
  
}

?>
