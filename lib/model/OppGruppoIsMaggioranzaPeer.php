<?php

/**
 * Subclass for performing query and update operations on the 'opp_gruppo_is_maggioranza' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppGruppoIsMaggioranzaPeer extends BaseOppGruppoIsMaggioranzaPeer
{
  public static function isGruppoMaggioranza($gruppo_id, $date = '')
  {
    $c = new Criteria();
    $c->add(self::GRUPPO_ID, $gruppo_id);
  	if ($date == '') {
      $c->add(self::DATA_FINE, NULL, Criteria::ISNULL);
  	} else {
  	  $c->add(self::DATA_INIZIO, $date, Criteria::LESS_EQUAL);
  	  
  	  $cton0 = $c->getNewCriterion(self::DATA_FINE, null, Criteria::ISNULL);
  	  $cton1 = $c->getNewCriterion(self::DATA_FINE, $date, Criteria::GREATER_THAN);
  	  $cton0->addOr($cton1);
  	  $c->add($cton0);
  	}
  	
  	$res = self::doSelectOne($c);
  	return $res->getMaggioranza();
    
  }
}
