<?php

/**
 * Subclass for representing a row from the 'opp_teseott' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppTeseott extends BaseOppTeseott
{
  public function getTeseos()
  {
    $c = new Criteria();
	$c->add(OppTeseoHasTeseottPeer::TESEOTT_ID, $this->getId(), Criteria::EQUAL );
	$c->addJoin(OppTeseoHasTeseottPeer::TESEO_ID, OppTeseoPeer::ID, Criteria::LEFT_JOIN);
	$c->addAscendingOrderByColumn(OppTeseoPeer::DENOMINAZIONE);
	$teseos = OppTeseoPeer::doSelect($c);
	
	return $teseos;
  }

}

?>
