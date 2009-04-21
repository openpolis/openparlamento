<?php

/**
 * community actions.
 *
 * @package    op_openparlamento
 * @subpackage community
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class communityActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    // ultime 10 attivita' della community
    $this->latest_activities = CommunityNewsPeer::getLatestActivities(10);
    
    
  }
  
   public function executeBoxparlamentari()
  {
    $this->type = $this->getRequestParameter('type'); 
  }
  
   public function executeAttiutenti()
  {
    $this->type = $this->getRequestParameter('type'); 
  }
  
}
