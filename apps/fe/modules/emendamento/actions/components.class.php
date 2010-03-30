<?php

/**
 * emendamento components
 *
 * @package default
 * @author Guglielmo Celata
 */
class emendamentoComponents extends sfComponents
{
  
  public function executeVotazioni()
  {
    
    $c=new Criteria();
    $c->addJoin(OppVotazionePeer::ID,OppVotazioneHasEmendamentoPeer::VOTAZIONE_ID);
    $c->add(OppVotazioneHasEmendamentoPeer::EMENDAMENTO_ID,$this->emendamento->getId());
    $this->votazioni=OppVotazionePeer::doSelect($c);
    
    $this->limit = 2;
	  $this->limit_count = 0;
	
	  $this->votazioni_count = count($this->votazioni);
  }
  
}

