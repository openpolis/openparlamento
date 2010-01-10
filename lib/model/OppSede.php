<?php

/**
 * Subclass for representing a row from the 'opp_sede' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppSede extends BaseOppSede
{
  public function __toString()
  {
    return $this->getRamo() . " " . $this->getDenominazione();
  }
}
