<?php

/**
 * Subclass for representing a row from the 'opp_carica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCarica extends BaseOppCarica
{
  public function getReport()
  {
    $risultato = array('Assente' => 0, 'Astenuto' => 0, 'Contrario' => 0, 'Favorevole' => 0, 'In missione' => 0, 
					   'Partecipante votazione non valida' => 0, 'Presidente di turno' => 0, 'Richiedente la votazione e non votante' => 0, 
					   'Voto segreto' => 0);
	
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppCaricaPeer::ID);
	$c->addSelectColumn(OppCaricaPeer::DATA_INIZIO);
	$c->addSelectColumn(OppCaricaPeer::DATA_FINE);
	$c->addSelectColumn(OppCaricaPeer::CARICA);
	$c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
	$c->addAsColumn('CONT', 'COUNT(*)');
	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::LEFT_JOIN);
	$c->addGroupByColumn(OppCaricaPeer::ID);
	$c->addGroupByColumn(OppVotazioneHasCaricaPeer::VOTO);
	$c->add(OppCaricaPeer::ID, $this->getId(), Criteria::EQUAL);
	$c->addDescendingOrderByColumn(OppCaricaPeer::DATA_INIZIO);
	$c->addDescendingOrderByColumn(OppCaricaPeer::DATA_FINE);
	$rs = OppCaricaPeer::doSelectRS($c);  
	
	while ($rs->next())
    {
	  if(!isset($risultato['carica']))
	  {
	    $risultato['carica'] = $rs->getString(4);  
	  } 
	  $risultato[$rs->getString(6)] = $rs->getInt(7);
	}
	
	return $risultato;
    
  }
}

?>
