<?php

/**
 * Subclass for performing query and update operations on the 'opp_em_iter' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppEmIterPeer extends BaseOppEmIterPeer
{  
  
  // mappa gli iter_id in iter per il calcolo dell'indice di attività
  public static $iter_per_indice = array(
    112 => 'votato', 113 => 'votato',
    112 => 'approvato',
  );

  /**
   * trasforma gli iter_id in iter per il calcolo dell'indice di attività
   *
   * @param string $iter_id 
   * @return integer (se non c'è mapping è 0)
   * @author Guglielmo Celata
   */
  public static function getIterPerIndice($iter_id)
  {
    if (array_key_exists($iter_id, self::$iter_per_indice))
      return self::$iter_per_indice[$iter_id];
    else
      return null;
  }

}
