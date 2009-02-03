<?php

/**
 * Subclass for performing query and update operations on the 'opp_similarita' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppSimilaritaPeer extends BaseOppSimilaritaPeer
{
  
  /**
   * override del calcolo della distanza per i voti, che tiene conto della simmetricità della matrice
   *
   * @param string $pol_from_id 
   * @param string $pol_to_id 
   * @return void
   * @author Guglielmo Celata
   */
  public static function getVotingDistance($pol_from_id, $pol_to_id)
  {
    if ($pol_from_id == $pol_to_id) return 0;
    if ($pol_from_id > $pol_to_id) return self::getVotingDistance($pol_to_id, $pol_from_id);
    
    $dist = self::retrieveFromPK($pol_from_id, $pol_to_id);
    return $dist->getVotingDistance();
  }

  /**
   * override del calcolo della distanza per le firme, che tiene conto della simmetricità della matrice
   *
   * @param string $pol_from_id 
   * @param string $pol_to_id 
   * @return void
   * @author Guglielmo Celata
   */
  public static function getSigningSimilarity($pol_from_id, $pol_to_id)
  {
    if ($pol_from_id == $pol_to_id) return 0;
    if ($pol_from_id > $pol_to_id) return self::getVotingDistance($pol_to_id, $pol_from_id);
    
    $dist = self::retrieveFromPK($pol_from_id, $pol_to_id);
    return $dist->getSigningSimilarity();
  }
  
}
