<?php

/**
 * Subclass for performing query and update operations on the 'opp_teseott' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppTeseottPeer extends BaseOppTeseottPeer
{
  
  public static function retrieveTagsFromTTPK($id)
  {
    $c = new Criteria();
    $c->add(OppTagHasTtPeer::TESEOTT_ID, $id);
    $c->addJoin(OppTagHasTtPeer::TAG_ID, TagPeer::ID);
    $c->addAscendingOrderByColumn(TagPeer::TRIPLE_VALUE);
    return TagPeer::doSelect($c);
  }

  
}
