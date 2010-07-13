<?php

/**
 * Subclass for performing query and update operations on the 'opp_iter' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppIterPeer extends BaseOppIterPeer
{

  // mappa gli iter_id in iter per il calcolo dell'indice di attività
  public static $iter_per_indice = array(
    4 => 'discusso_in_comm',
    7 => 'discusso_in_ass',
    58 => 'votato', 57 => 'votato', 54 => 'votato', 52 => 'votato', 36 => 'votato', 30 => 'votato',
    58 => 'approvato', 57 => 'approvato', 54 => 'approvato', 52 => 'approvato', 36 => 'approvato', 30 => 'approvato',
    20 => 'approvato_camera',
    16 => 'diventato_legge' ,
    11 => 'concluso', 13 => 'concluso', 28 => 'concluso', 40 => 'concluso', 41 => 'concluso', 42 => 'concluso', 45 => 'concluso', 50 => 'concluso', 56 => 'concluso'  
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
