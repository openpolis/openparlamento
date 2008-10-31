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
    $this->sub_menu_items = array('tags' => 'Argomenti',
                                  'acts' => 'Atti',
                                  'politicians' => 'Politici',
                                  'bookmarks' => 'Preferiti');
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
    $this->user = OppUserPeer::retrieveByPK($this->getUser()->getId());

    $type = OppTipoAttoPeer::retrieveByPK($this->type_id);
    
    $indirectly_monitored_acts = OppAttoPeer::doSelectIndirectlyMonitoredByUser($this->user, $type, $this->tag_filtering_criteria);
    if (is_null($this->tag_filtering_criteria))
      $directly_monitored_acts = OppAttoPeer::doSelectDirectlyMonitoredByUser($this->user, $type);
    else
      $directly_monitored_acts = array();

    $this->monitored_acts = OppAttoPeer::merge($indirectly_monitored_acts, $directly_monitored_acts);
    
    $this->my_monitored_tags_pks = OppAttoPeer::transformIntoPKs($this->user->getMonitoredObjects('Tag'));
  }
  
}

?>
