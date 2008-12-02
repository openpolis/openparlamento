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
  
}

?>