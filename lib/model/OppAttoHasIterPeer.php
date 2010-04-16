<?php

/**
 * Subclass for performing query and update operations on the 'opp_atto_has_iter' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAttoHasIterPeer extends BaseOppAttoHasIterPeer
{

  public static function getItinera($atto_id, $data)
  {
    $c = new Criteria();
    $c->add(self::ATTO_ID, $atto_id);
    $c->add(self::DATA, $data, Criteria::LESS_THAN);
    $c->addGroupByColumn(self::ATTO_ID);
    $c->addGroupByColumn(self::ITER_ID);    
    
    return self::doSelectJoinOppIter($c);
  }
  
}
