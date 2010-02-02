<?php

/**
 * Subclass for performing query and update operations on the 'opp_atto_has_emendamento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAttoHasEmendamentoPeer extends BaseOppAttoHasEmendamentoPeer
{
  public static function countPresentedRelatedToAtDate($atto_id, $date)
  {
    $c = new Criteria();
    $c->add(self::ATTO_ID, $atto_id);
    $c->addJoin(self::EMENDAMENTO_ID, OppEmendamentoPeer::ID);
    $c->add(OppEmendamentoPeer::DATA_PRES, $date);
    return self::doCount($c);
  }

  
}
