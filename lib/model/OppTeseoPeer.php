<?php

/**
 * Subclass for performing query and update operations on the 'opp_teseo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppTeseoPeer extends BaseOppTeseoPeer
{
  public static function doSelectAtto($atto_id)
  {
    $atti = array(); 
	
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppAttoPeer::ID);
	$c->addSelectColumn(OppAttoPeer::RAMO);
	$c->addSelectColumn(OppAttoPeer::NUMFASE);
	$c->addSelectColumn(OppAttoPeer::TITOLO);
	$c->setDistinct(OppAttoPeer::ID);
	$c->add(OppAttoHasTeseoPeer::TESEO_ID, $atto_id, Criteria::IN);
	$c->addJoin(OppAttoHasTeseoPeer::ATTO_ID, OppAttoPeer::ID, Criteria::LEFT_JOIN);
	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
	$c->add(OppAttoPeer::TIPO_ATTO_ID, 1, Criteria::EQUAL);
	$rs = OppAttoHasTeseoPeer::doSelectRS($c);
	
	while ($rs->next())
    {
	  $atti[$rs->getInt(1)] = $rs->getString(2).'.'.$rs->getString(3).' '.$rs->getString(4);  
	}
	return $atti;  
  }

}

?>
