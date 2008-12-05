<?php
/**
 * monitoring components.
 *
 * @package    openparlamento
 * @subpackage monitoring
 * @author     Guglielmo Celata
 * @version    SVN: $Id: components.class.php 1415 2006-06-11 08:33:51Z fabien $
 */
class monitoringComponents extends sfComponents
{
  public function executeSubmenu()
  {
    $this->sub_menu_items = array('news' => 'Le tue notizie',
                                  'acts' => 'DDL e Atti monitorati',
                                  'politicians' => 'Parlamentari monitorati',
                                  'tags' => 'Gestione argomenti');
  }
  
  
  public function executeManageItem()
  {
    if ($this->getUser()->isAuthenticated())
    {
      $user = OppUserPeer::retrieveByPK($this->getUser()->getId());
      
      if ($user->getNMaxMonitoredItems())
      {
        $monitored = $user->countMonitoredObjects('OppAtto') + $user->countMonitoredObjects('OppPolitico');
        $this->remaining_items = $user->getNMaxMonitoredItems() - $monitored;
      }
      $this->is_monitoring = $user->isMonitoring($this->item_model, $this->item_pk);
    }
  }
  
  
  public function executeActsForType()
  {
    $this->type_id = $this->type->getId();
    $this->type_denominazione = $this->type->getDenominazione();
    
    // filtri per ramo e stato avanzamento
    $act_filtering_criteria = null;
    if (array_key_exists('act_ramo', $this->filters))
    {
      if (is_null($act_filtering_criteria))
        $act_filtering_criteria = new Criteria();
      $act_filtering_criteria->add(OppAttoPeer::RAMO, $this->filters['act_ramo']);
    }
    if (array_key_exists('act_stato', $this->filters))
    {
      if (is_null($act_filtering_criteria))
        $act_filtering_criteria = new Criteria();
      if ($this->filters['act_stato'] == 0)
        $act_filtering_criteria->add(OppAttoPeer::COMPLETO, null, Criteria::ISNULL);      
      else
        $act_filtering_criteria->add(OppAttoPeer::COMPLETO, $this->filters['act_stato']);      
    }

    $indirectly_monitored_acts = OppAttoPeer::doSelectIndirectlyMonitoredByUser($this->user, 
      $this->type, $this->tag_filtering_criteria, $this->my_monitored_tags_pks, $act_filtering_criteria);
    
    if (!array_key_exists('tag_id', $this->filters))
      $directly_monitored_acts = OppAttoPeer::doSelectDirectlyMonitoredByUser($this->user, $this->type);
    else
      $directly_monitored_acts = array();
    
    $this->monitored_acts = OppAttoPeer::merge($indirectly_monitored_acts, $directly_monitored_acts);
    
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
