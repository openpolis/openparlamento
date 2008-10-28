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

  public function getTags()
  {
    $c = new Criteria();
    $c->add(OppTagHasTtPeer::TESEOTT_ID, $this->getId());
    $c->addJoin(OppTagHasTtPeer::TAG_ID, TagPeer::ID);
    $c->addAscendingOrderByColumn(TagPeer::TRIPLE_VALUE);
    return TagPeer::doSelect($c);
  }
  
  
  public function getTeseos()
  {
    $c = new Criteria();
  	$c->add(OppTeseoHasTeseottPeer::TESEOTT_ID, $this->getId(), Criteria::EQUAL );
  	$c->addJoin(OppTeseoHasTeseottPeer::TESEO_ID, OppTeseoPeer::ID, Criteria::RIGHT_JOIN);
  	$c->addAscendingOrderByColumn(OppTeseoPeer::DENOMINAZIONE);
  	$teseos = OppTeseoPeer::doSelect($c);
	
  	return $teseos;
  }

}

?>
