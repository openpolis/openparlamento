<?php
class attoComponents extends sfComponents
{
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
}

?>