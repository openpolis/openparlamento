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
    $this->sub_menu_items = array('news' => 'Le mie notizie',
                                  'acts' => 'I miei atti',
                                  'politicians' => 'I miei parlamentari',
                                  'tags' => 'I miei argomenti');
    if ($this->getUser()->hasCredential('amministratore'))
      $this->sub_menu_items['alerts'] = 'I miei avvisi';
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
  
  protected function calcolaIndice($atto,$tipo)
  {
    if ($atto==1)
    {
      if ($tipo=="P") return "10";
      if ($tipo=="C") return "3";
      if ($tipo=="R") return "6";
    }
    if ($atto==2)
    {
      if ($tipo=="P") return "6";
      if ($tipo=="C") return "2";
    }
    if ($atto>=3 || $atto<=6)
    {
      if ($tipo=="P") return "3";
      if ($tipo=="C") return "1";
    }
    if ($atto>=7 || $atto<=9)
    {
      if ($tipo=="P") return "5";
      if ($tipo=="C") return "2";
    }
    if ($atto>=10 || $atto<=11)
    {
      if ($tipo=="P") return "4";
      if ($tipo=="C") return "2";
    }
  }
  
  public function executeUserVspolitician()
  {
    $arr=array();
    $user_id = $this->user->getId();
    $num=$this->num;
    $c = new Criteria();
    $c->add(sfVotingPeer::USER_ID, $user_id);
    $voting_objects = sfVotingPeer::doSelect($c);
    foreach ($voting_objects as $voting_object)
    {
      $c = new Criteria();
      $c->addJoin(OppAttoPeer::ID,OppCaricaHasAttoPeer::ATTO_ID);
      $c->add(OppAttoPeer::ID,$voting_object->getVotableID());
      $firme = OppCaricaHasAttoPeer::doSelect($c);
      foreach ($firme as $firma)
      {
        $value=$this->calcolaIndice($firma->getOppAtto()->getTipoAttoId(),$firma->getTipo());
        
        if (!array_key_exists($firma->getCaricaId(),$arr)) $arr[$firma->getCaricaId()]=$value*$voting_object->getVoting();
        else $arr[$firma->getCaricaId()]= $arr[$firma->getCaricaId()] + $value*$voting_object->getVoting();
        
      }
    }
    $this->vicini=array();
    $this->lontani=array();
     if (count($voting_objects)>0) 
     {
      arsort($arr);
      $vicini=array_slice($arr,0,$num,true);
      $max_valore_abs=max(abs(min($arr)),max($arr));
      $normalize=100/$max_valore_abs;
      foreach($vicini as $key=>$vicino)
      {
        if ($vicino>0)
        {
          $c= new Criteria();
          $c->add(OppCaricaPeer::ID,$key);
          $carica=OppCaricaPeer::doSelectOne($c);
          $this->vicini[]=array($vicino*$normalize,$carica);
        }
        else break;
      }
      $lontani=array_slice($arr,count($arr)-$num,count($arr),true);
      asort($lontani);
      foreach ($lontani as $key=>$lontano)
      {
        if ($lontano<0)
        {
          $c= new Criteria();
          $c->add(OppCaricaPeer::ID,$key);
          $carica=OppCaricaPeer::doSelectOne($c);
          $this->lontani[]=array($lontano*$normalize,$carica);
        }
      }
    }
    
  }
  
}

?>
