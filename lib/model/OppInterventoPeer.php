<?php

/**
 * Subclass for performing query and update operations on the 'opp_intervento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppInterventoPeer extends BaseOppInterventoPeer
{
  /**
   * torna il numero di sedute con almeno un intervento di un parlamentare
   *
   * @param string $carica 
   * @param string $data - data limite
   * @return integer
   * @author Guglielmo Celata
   */
  public static function getNSeduteConInterventiCarica($carica, $data)
  {
    $c = new Criteria();
    $c->add(self::CARICA_ID, $carica->getId());
    $c->addGroupByColumn(self::SEDE_ID);
    $c->addGroupByColumn(self::DATA);
    
    $res = self::doSelect($c);
    return count($res);
  }
}
