<?php

/**
 * Subclass for performing query and update operations on the 'opp_votazione_has_carica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppVotazioneHasCaricaPeer extends BaseOppVotazioneHasCaricaPeer
{
  public static function doSelectGroupByGruppo($votazione_id)
  {
    
	$c = new Criteria();
    $c->add(OppVotazionePeer::ID, $votazione_id, Criteria::EQUAL );
    $votazione = OppVotazionePeer::doSelectJoinOppSeduta($c);
    $votazione = $votazione[0];
	
	$risultato = array();
		
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppGruppoPeer::NOME);
	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
	$c->addAsColumn('CONT', 'COUNT(*)');
	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::INNER_JOIN);
	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::INNER_JOIN);
	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::INNER_JOIN);
	$c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $votazione_id, Criteria::EQUAL);
	
	$c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $votazione->getOppSeduta()->getData(), Criteria::LESS_EQUAL);
	$cton1 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, $votazione->getOppSeduta()->getData(), Criteria::GREATER_EQUAL);
	$cton2 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);
    $cton1->addOr($cton2);
    $c->add($cton1);
	
	$c->addGroupByColumn(OppGruppoPeer::NOME);
	$c->addGroupByColumn(OppVotazioneHasCaricaPeer::VOTO);
		  	
	$rs = OppVotazioneHasCaricaPeer::doSelectRS($c);
	
	while ($rs->next())
    {
	  
	  if(!isset($risultato[$rs->getString(1)]))
	  { 
	    $risultato[$rs->getString(1)] = array('Favorevole' => 0, 'Contrario' => 0, 'Astenuto' => 0, 'Assente' => 0, 'In missione' => 0);
	  }
	  
	  if(isset($risultato[$rs->getString(1)][$rs->getString(2)]))
	    $risultato[$rs->getString(1)][$rs->getString(2)] = $rs->getInt(3);
	  
	}
	
	return $risultato;
		
  }

}

?>
