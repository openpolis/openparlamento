<?php

/**
 * Subclass for representing a row from the 'opp_gruppo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppGruppo extends BaseOppGruppo
{
  /**
   * controlla se il gruppo, alla data specificata, è nella maggioranza o no
   *
   * @param string $date 
   * @return boolean
   * @author Guglielmo Celata
   */
  public function isMaggioranza($date)
  {
    return OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($this->getId(), $date);
  }
}
