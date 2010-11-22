<?php

/**
 * Subclass for performing query and update operations on the 'opp_carica_interna' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaInternaPeer extends BaseOppCaricaInternaPeer
{
  public static function getPermanentiAttuali($carica_id, $con = null)
  {
    // retrieve delle cariche interne attuali  e permanenti
    $c = new Criteria();
    $c->add(self::CARICA_ID, $carica_id);
    $c->add(self::DATA_FINE, NULL, Criteria::ISNULL);
    $c->addJoin(OppSedePeer::ID, self::SEDE_ID);
    $c->addJoin(OppTipoCaricaPeer::ID, self::TIPO_CARICA_ID);
    $c->add(OppSedePeer::TIPOLOGIA, 'Commissione permanente');
    return self::doSelect($c);    
  }
  
}
