<?php

/**
 * Subclass for representing a row from the 'opp_tipo_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppTipoAtto extends BaseOppTipoAtto
{
  /**
   * return D or N, according to the type of act
   * an SDDL type is D (Disegno di Legge)
   * while all others are N (Not a Disegno di Legge)
   * the pattern may vary in the future, that is why a switch is used
   *
   * @return char
   * @author Guglielmo Celata
   **/
  public function getTipo()
  {
    switch ($this->getDenominazione())
    {
      case 'SDDL':
        return 'D';
        break;
      default:
        return 'N';
        break;
    }
  }
}
