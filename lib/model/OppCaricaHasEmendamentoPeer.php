<?php

/**
 * Subclass for performing query and update operations on the 'opp_carica_has_emendamento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaHasEmendamentoPeer extends BaseOppCaricaHasEmendamentoPeer
{
  public static function countSignedByAtDate($carica_id, $date)
  {
    $c = new Criteria();
    $c->add(self::CARICA_ID, $carica_id);
    $c->add(self::DATA, $date);
    return self::doCount($c);
  }
  
}
