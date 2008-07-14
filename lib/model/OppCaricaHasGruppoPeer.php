<?php

/**
 * Subclass for performing query and update operations on the 'opp_carica_has_gruppo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaHasGruppoPeer extends BaseOppCaricaHasGruppoPeer
{
  public static function doSelectGruppiPerCarica($carica_id)
  {
    $gruppi = array();
	
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppGruppoPeer::NOME);
	$c->addSelectColumn(OppCaricaHasGruppoPeer::DATA_INIZIO);
	$c->addSelectColumn(OppCaricaHasGruppoPeer::DATA_FINE);
	$c->addSelectColumn(OppCaricaHasGruppoPeer::GRUPPO_ID);
	$c->addSelectColumn(OppCaricaHasGruppoPeer::RIBELLE);
	$c->add(OppCaricaHasGruppoPeer::CARICA_ID, $carica_id , Criteria::EQUAL);
    $c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::LEFT_JOIN);
    $c->addAscendingOrderByColumn(OppCaricaHasGruppoPeer::DATA_FINE);
    $rs = OppCaricaHasGruppoPeer::doSelectRS($c);
	
	while ($rs->next())
    {
	  $gruppi[$rs->getString(1)] = array('data_inizio' => $rs->getDate(2), 'data_fine' => $rs->getDate(3), 'gruppo_id' => $rs->getInt(4), 'ribelle' => $rs->getInt(5) );
	}	
    
	return $gruppi;
  }	
}

?>