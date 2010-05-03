<?php

/**
 * Subclass for performing query and update operations on the 'opp_tipo_carica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppTipoCaricaPeer extends BaseOppTipoCaricaPeer
{
  /**
   * torna il ramo e il prefisso (On, Sen) dato un certo tipo di carica
   *
   * @param string $tipo_carica_id 
   * @return void
   * @author Guglielmo Celata
   */
  public static function getRamoPrefisso($tipo_carica_id)
  {
    switch ($tipo_carica_id) {
      case 1:
        $ramo = 'C';
        $prefisso = 'On.';
        break;
      case 4:
      case 5:
        $ramo = 'S';
        $prefisso = 'Sen.';
        break;
      case 2:
      case 3:
      case 6:
      case 7:
        $ramo = 'G';
        $prefisso = '';
        break;
      
      default:
        $ramo = '';
        $prefisso = '';
        break;
    }
    
    return array($ramo, $prefisso);
  }
  
}
