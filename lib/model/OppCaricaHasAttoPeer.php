<?php

/**
 * Subclass for performing query and update operations on the 'opp_carica_has_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaHasAttoPeer extends BaseOppCaricaHasAttoPeer
{
  public static function get_fattore_firma($tipo)
  {
    switch ($tipo)
    {
      case 'P':
        $val = 10;
        break;
      
      case 'R':
        $val = 6;
        break; 
        
      case 'C':
        $val = 3;
        break;
        
      default:
        $val = 0;
        break;
    }
    
    return $val;
  }
  
  /**
   * estrae tutte le firme per un determinato atto, prima di una determinata data
   *
   * @param string $atto_id 
   * @param string $data 
   * @return array di OppCaricaHasAtto
   * @author Guglielmo Celata
   */
  public static function getFirme($atto_id, $data)
  {
    $c = new Criteria();
    $c->add(self::ATTO_ID, $atto_id);
    $c->add(self::DATA, $data, Criteria::LESS_THAN);
    
    return self::doSelectJoinOppCarica($c);
  }
  
}
