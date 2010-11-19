<?php

/**
 * Subclass for performing query and update operations on the 'opp_gruppo_ramo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppGruppoRamoPeer extends BaseOppGruppoRamoPeer
{
  /**
   * estrae tutti i gruppi di un ramo, attivi alla data passata
   *
   * @param string $ramo 
   * @param string $data 
   * @return array di OppGruppoRamo, join con OppGruppo
   * @author Guglielmo Celata
   */
  public static function getGruppiRamo($ramo, $data = null, $con = null)
  {
    $c = new Criteria();
    if (!is_null($data)) {
      $c->add(self::RAMO, $ramo);
      
      $c_or_data_fine = $c->getNewCriterion(self::DATA_FINE, $data, Criteria::GREATER_EQUAL);
      $c_or_data_fine->addOr(self::DATA_FINE, null, Criteria::ISNULL);
      
      $c_data = $c->getNewCriterion(self::DATA_INIZIO, $data, Criteria::LESS_EQUAL);
      $c_data->addAnd($c_or_data_fine);
      
      $c->add($c_data);
    } else {
      $c->add(self::DATA_FINE, null, Criteria::ISNULL);      
    }
    $c->add(self::RAMO, $ramo);

    return self::doSelectJoinOppGruppo($c, $con);
  }
}
