<?php

/**
 * Subclass for performing query and update operations on the 'opp_votazione' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppVotazionePeer extends BaseOppVotazionePeer
{
  public static function doSelectVotoGruppo($votazione_id, $gruppo)
  {
    $c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
	$c->addAsColumn('CONT', 'COUNT(*)');
		
	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::INNER_JOIN);
	$c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::INNER_JOIN);
	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::INNER_JOIN);
	
	$c->add(OppVotazioneHasCaricaPeer::VOTO, 'Assente', Criteria::NOT_EQUAL);	
	$c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $votazione_id, Criteria::EQUAL);
	$c->add(OppGruppoPeer::NOME, $gruppo, Criteria::EQUAL);
	
	$c->addGroupByColumn(OppVotazioneHasCaricaPeer::VOTO);
	$c->addDescendingOrderByColumn('CONT');
	$c->setLimit(1);
	
	$rs = OppCaricaPeer::doSelectRS($c);
		
	
	while ($rs->next())
    {
	  return $rs->getString(1);
	}
	
  }  
}
?>