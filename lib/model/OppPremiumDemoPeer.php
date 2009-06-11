<?php

/**
 * Subclass for performing query and update operations on the 'opp_premium_demo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppPremiumDemoPeer extends BaseOppPremiumDemoPeer
{
  protected static  $eta_str = array(1 => 'meno di 18', 
                                     2 => 'da 18 a 35',
                                     3 => 'da 36 a 45',
                                     4 => 'da 46 a 55',
                                     5 => 'oltre 55');

  protected static  $attivita_str = array(1 => 'studentessa/e', 
                                          2 => 'avvocatessa/o',
                                          3 => 'commercialista',
                                          4 => 'giornalista',
                                          5 => 'consulente',
                                          6 => 'commerciante',
                                          7 => 'imprenditrice/tore',
                                          8 => 'altro',
                                          9 => 'dip. pubblico',
                                          10 => 'dip. privato',
                                          11 => 'dip. no-profit',
                                          12 => 'amm. europeo',
                                          13 => 'amm. nazionale',
                                          14 => 'amm. regionale',
                                          15 => 'amm. provinciale',
                                          16 => 'amm. comunale',
                                          );

  protected static $perche_str = array(1 => 'lavoro',
                                       2 => 'interesse personale',
                                       3 => 'studio/ricerca',
                                       4 => 'altro',
                                      );


  static public function getEtas()
  {
    return self::$eta_str;
  }

  static public function getAttivitas()
  {
    return self::$attivita_str;
  }

  static public function getPerches()
  {
    return self::$perche_str;
  }

  static public function getEtaAsString($eta)
  {
    return self::$eta_str[$eta];
  }

  static public function getAttivitaAsString($attivita)
  {
    return self::$attivita_str[$attivita];
  }

  static public function getPercheAsString($perche)
  {
    return self::$perche_str[$perche];
  }
	
}
