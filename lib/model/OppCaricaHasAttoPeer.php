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
  
}
