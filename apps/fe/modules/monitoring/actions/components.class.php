<?php
/**
 * monitoring components.
 *
 * @package    openparlamento
 * @subpackage monitoring
 * @author     Guglielmo Celata
 */
class monitoringComponents extends sfComponents
{
  public function executeSubmenu()
  {
    $this->sub_menu_items = array('news' => 'Le tue notizie',
                                  'acts' => 'I tuoi atti',
                                  'politicians' => 'I tuoi parlamentari',
                                  'tags' => 'I tuoi argomenti');
  }
  
  
  public function executeManageItem()
  {

    $this->item_model = get_class($this->item);
    switch ($this->item_model)
    {
      case 'OppPolitico':
        $this->item_type = 'politico';
        break;
      case 'OppAtto':
        $this->item_type = 'atto';
        break;
      case 'Tag';
        $this->item_type = 'argomento';
        break;
    }
    
    sfLogger::getInstance()->info('xxx: ' . $this->item_type);

    if ($this->item_type == 'atto' || $this->item_type == 'politico')
      $this->nMonitoringUsers = $this->item->countAllMonitoringUsers();
    else
      $this->nMonitoringUsers = count($this->item->getMonitoringUsersPKs());

    if ($this->getUser()->isAuthenticated())
    {
      $user = OppUserPeer::retrieveByPK($this->getUser()->getId());
      
      $this->item_pk = $this->item->getPrimaryKey();
        
      $this->is_monitoring = $user->isMonitoring($this->item_model, $this->item_pk);
    }
  }
  
  public function executeActsForType()
  {
    $this->type_id = $this->type->getId();
    $this->type_denominazione = $this->type->getDescrizione();
    
    
    // filtri per ramo e stato avanzamento
    $act_filtering_criteria = null;
    if ($this->filters['act_ramo'] != '0')
    {
      if (is_null($act_filtering_criteria))
        $act_filtering_criteria = new Criteria();
      
      $act_filtering_criteria->add(OppAttoPeer::RAMO, $this->filters['act_ramo']);
    }
    if ($this->filters['act_stato'] != '0')
    {
      if (is_null($act_filtering_criteria))
        $act_filtering_criteria = new Criteria();
      
      $act_filtering_criteria->add(OppAttoPeer::STATO_COD, $this->filters['act_stato']);      
    }

    $blocked_items_pks = sfBookmarkingPeer::getAllNegativelyBookmarkedIds($this->user_id);
    if (array_key_exists('OppAtto', $blocked_items_pks))
    {
      if (is_null($act_filtering_criteria))
        $act_filtering_criteria = new Criteria();
      $blocked_acts_pks = $blocked_items_pks['OppAtto'];
      $act_filtering_criteria->add(OppAttoPeer::ID, $blocked_acts_pks, Criteria::NOT_IN);
    }


    $indirectly_monitored_acts = OppAttoPeer::doSelectIndirectlyMonitoredByUser($this->user, 
      $this->type, $this->tag_filtering_criteria, $this->my_monitored_tags_pks, $act_filtering_criteria);
    
    if ($this->filters['tag_id'] == '0')
      $directly_monitored_acts = OppAttoPeer::doSelectDirectlyMonitoredByUser($this->user, $this->type, $act_filtering_criteria);
    else
      $directly_monitored_acts = array();
    
    $monitored_acts = OppAttoPeer::merge($indirectly_monitored_acts, $directly_monitored_acts);
    $this->n_total_acts = count($monitored_acts);
    if ($this->filters['act_type_id'] == 0) 
      $monitored_acts = array_slice($monitored_acts, 0, sfConfig::get('app_monitored_acts_per_type_limit'));
    
    $this->monitored_acts = $monitored_acts;
    
  }

  public function executeActLine()
  {
    $this->act_id = $this->act->getId();
    $this->act_has_been_positively_bookmarked = $this->act->hasBeenPositivelyBookmarked($this->user_id);
    $this->act_has_been_negatively_bookmarked = $this->act->hasBeenNegativelyBookmarked($this->user_id);
    $this->user_is_monitoring_act = $this->user->isMonitoring('OppAtto', $this->act_id);
  }
  
}

?>
