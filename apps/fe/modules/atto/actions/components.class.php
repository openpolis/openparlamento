<?php
class attoComponents extends sfComponents
{
  public function executeMonitor_n_vote()
  {
    
  }
  
  public function executeItemshortinline()
  {
    switch(get_class($this->item)){
      case 'OppPolitico':
        $str = $this->item->__toString();
        $url = '@parlamentare?id='.$this->item->getId();
        break;
      case 'OppAtto':
        $str = $this->item->getRamo() .".". $this->item->getNumfase();
        $url = '@singolo_atto?id='.$this->item->getId();
        break;
      case 'Tag':
        $str = $this->item->getTripleValue();
        $url = '@argomento?triple_value='.$this->item->getTripleValue();
        break;
    }
    $this->str = $str . " (".$this->item->getNMonitoringUsers().")"; 
    $this->url=$url;
  }

  public function executeProusersdo()
  {
    $pro_users_pks = $this->item->getVotingUsersPKs(1);

    $voted_items = sfVotingPeer::getItemsFavouredByUsers($pro_users_pks, 'OppAtto');
    uasort($voted_items, 'sfVotingPeer::compareItemsByProUsers');
    $this->pro_acts = array_slice($voted_items, 0, 10);

    $voted_items = sfVotingPeer::getItemsOpposedByUsers($pro_users_pks, 'OppAtto');
    uasort($voted_items, 'sfVotingPeer::compareItemsByAntiUsers');
    $this->anti_acts = array_slice($voted_items, 0, 10);
  }

  public function executeAntiusersdo()
  {
    $anti_users_pks = $this->item->getVotingUsersPKs(-1);

    $voted_items = sfVotingPeer::getItemsFavouredByUsers($anti_users_pks, 'OppAtto');
    uasort($voted_items, 'sfVotingPeer::compareItemsByProUsers');
    $this->pro_acts = array_slice($voted_items, 0, 10);

    $voted_items = sfVotingPeer::getItemsOpposedByUsers($anti_users_pks, 'OppAtto');
    uasort($voted_items, 'sfVotingPeer::compareItemsByAntiUsers');
    $this->anti_acts = array_slice($voted_items, 0, 10);
  }
  
  public function executeMonitoringusersdo()
  {
    $this->monitorers_pks = $this->item->getAllMonitoringUsersPKs();
    $this->monitored_models_pks = MonitoringPeer::getModelsPKsMonitoredByUsers($this->monitorers_pks);
  }
  
  
  public function executeDdlConversione()
  {
    $c = new Criteria();
    $c->add(OppAttoPeer::ID, $this->ddl->getSucc(), Criteria::EQUAL);
    $this->ddl_di_conversione = OppAttoPeer::doSelectOne($c);  
  }
  
  public function executeStatoAttoNonLegislativo()
  {
    $c = new Criteria();
    $c->add(OppAttoPeer::ID, $this->ddl->getPred(), Criteria::EQUAL);
    $this->ultimo_atto = OppAttoPeer::doSelectOne($c);
  }
  
  public function executeDocumenti()
  {
    $this->documenti = $this->atto->getOppDocumentos();
	$this->documenti_count = $this->atto->countOppDocumentos();
	
	$this->limit = 5;
	$this->limit_count = 0;
	
	$this->tipo_atto = $this->atto->getOppTipoAtto()->getDescrizione();
  }
  
  public function executeFirmatari()
  {
    $this->primi_array_index = array();
    foreach($this->primi_firmatari as $id => $primo_firmatario)
      array_push($this->primi_array_index, $id);
	
	$this->rel_array_index = array();
    foreach($this->relatori as $id => $relatore)
      array_push($this->rel_array_index, $id);
       
  }
  
  public function executeVotazioni()
  {
    $this->limit = 2;
	$this->limit_count = 0;
	
	$this->votazioni_count = count($this->votazioni);
  }
  
  public function executeInterventi()
  {
    $this->limit = 2;
	$this->limit_count = 0;
	
	$this->interventi_count = count($this->interventi);
  }
  
  public function executeCommissioni()
  {
    $this->consultive_count = 0;
  }
  public function executeRelazioni()
  {
    $this->relazioni =  OppAttoPeer::getRelazioni($this->atto->getId());
  }
}

?>