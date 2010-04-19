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

  /**
   * estrae tutte le firme per un determinato emendamento, prima di una determinata data
   *
   * @param string $emendamento_id 
   * @param string $data 
   * @return array di OppCaricaHasEmendamento
   * @author Guglielmo Celata
   */
  public static function getFirme($emendamento_id, $data)
  {
    $c = new Criteria();
    $c->add(self::EMENDAMENTO_ID, $emendamento_id);
    $c->add(self::DATA, $data, Criteria::LESS_THAN);
    
    return self::doSelectJoinOppCarica($c);
  }
  
  public static function countSignedByAtDate($carica_id, $date)
  {
    $c = new Criteria();
    $c->add(self::CARICA_ID, $carica_id);
    $c->add(self::DATA, $date);
    return self::doCount($c);
  }
  
}
