<?php

/**
 * Subclass for representing a row from the 'opp_similarita' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppSimilarita extends BaseOppSimilarita
{

  /**
   * aumenta il valore del campo voting_similarity della quantità $inc
   *
   * @param string $inc 
   * @return void
   * @author Guglielmo Celata
   */
  public function increaseVotingSimilarity($inc)
  {
    $this->setVotingSimilarity($inc + $this->getVotingSimilarity());
  }

}
