<?php

/**
 * Subclass for representing a row from the 'opp_iter' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppIter extends BaseOppIter
{

public function getColor()
  {
  
  switch ($this->getId()) {
    case 15:    
    case 16:
    case 20:
    case 22:
    case 25:
    case 28:
    case 30:
    case 36:
    case 37:
    case 42:
    case 52:
    case 54:
    case 56:
    case 61:
    case 63:
    case 65:
       $color="green";
        break;
        
    case 11:    
    case 12:
    case 13:
    case 14:
    case 17:
    case 18:
    case 19:
    case 21:
    case 32:
    case 34:
    case 41:
    case 45:
    case 47:
    case 50:
    case 51:
    case 64:
        $color="red";
        break;
        
    default:
         $color="gold";
  }
  return $color;
  
  }
}
