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
    12 => 'votato',  53 => 'votato', 
    57 => 'approvato', 54 => 'approvato', 52 => 'approvato', 36 => 'approvato', 30 => 'approvato', 58 => 'approvato',
    20 => 'approvato', 22 => 'approvato', 25 => 'approvato', 61 => 'approvato', 37 => 'approvato',
    16 => 'diventato_legge' ,
    11 => 'assorbito',
    42 => 'svolto', 56 => 'svolto'
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
