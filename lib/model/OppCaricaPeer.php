<?php

/**
 * Subclass for performing query and update operations on the 'opp_carica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaPeer extends BaseOppCaricaPeer
{
  public static function doSelectFullReport($politico_id)
  {
    $risultato = array();
	
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppCaricaPeer::ID);
	$c->addSelectColumn(OppCaricaPeer::DATA_INIZIO);
	$c->addSelectColumn(OppCaricaPeer::DATA_FINE);
	$c->addSelectColumn(OppCaricaPeer::CARICA);
	$c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
	$c->addSelectColumn(OppCaricaPeer::INDICE);
	$c->addSelectColumn(OppCaricaPeer::POSIZIONE);
	$c->addAsColumn('CONT', 'COUNT(*)');
	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::LEFT_JOIN);
	$c->addGroupByColumn(OppCaricaPeer::ID);
	$c->addGroupByColumn(OppVotazioneHasCaricaPeer::VOTO);
	$c->add(OppCaricaPeer::POLITICO_ID, $politico_id, Criteria::EQUAL);
	$c->addDescendingOrderByColumn(OppCaricaPeer::DATA_INIZIO);
	$c->addDescendingOrderByColumn(OppCaricaPeer::DATA_FINE);
	$rs = OppCaricaPeer::doSelectRS($c);  
	
	while ($rs->next())
    {
	  
	  if(!isset($risultato[$rs->getInt(1)]))
	  { 
	    $risultato[$rs->getInt(1)] = array('data_inizio' => $rs->getDate(2), 'data_fine' => $rs->getDate(3),
		                                   'carica' => $rs->getString(4), 'circoscrizione' => $rs->getString(5), 
		                                   'Assente' => 0, 'Astenuto' => 0, 'Contrario' => 0, 'Favorevole' => 0, 'In missione' => 0, 
										   'Partecipante votazione non valida' => 0, 'Presidente di turno' => 0, 'Richiedente la votazione e non votante' => 0, 
										   'Voto segreto' => 0, 'Indice' => $rs->getFloat(7), 'Posizione' => $rs->getInt(8) );
	  }
	  
	  $risultato[$rs->getInt(1)][$rs->getString(6)] = $rs->getInt(9);
	  	  
	}
	
	return $risultato;
	
  }

}

?>
