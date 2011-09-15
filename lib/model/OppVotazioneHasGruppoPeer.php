<?php

/**
 * Subclass for performing query and update operations on the 'opp_votazione_has_gruppo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppVotazioneHasGruppoPeer extends BaseOppVotazioneHasGruppoPeer
{
  public static function getVotoGruppoVotazione($gruppo_id, $votazione_id)
  {
    $c= new Criteria;
  	$c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $gruppo_id);
  	$c->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $votazione_id);
  	$voto= OppVotazioneHasGruppoPeer::doSelectOne($c);
  	if ($voto)
  	  return $voto->getVoto();
  	else
  	  return null;
  }  
}
