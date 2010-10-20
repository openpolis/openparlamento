<?php

/**
 * Subclass for performing query and update operations on the 'opp_atto_has_iter' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAttoHasIterPeer extends BaseOppAttoHasIterPeer
{

  /**
   * estrae gli *itinera* di un atto, a una certa data
   *
   * @param integer $atto_id 
   * @param string  $data 
   * @return array di hash ('iter_id' => ID, 'data' => DATE)
   * @author Guglielmo Celata
   */
  public static function getItinera($atto_id, $data)
  {
    $rs = self::getItineraAttoDataRS($atto_id, $data);
    
    $itinera = array();
    while ($rs->next()) {
      $itinera []= $rs->getRow();
    }
    
    return $itinera;
  }

  /**
   * legge gli itinera interessanti di un singolo atto
   * interessanti sono quelli cui vengono sassegnati dei punti
   *
   * @param string $atto_id 
   * @param string $data 
   * @return void
   * @author Guglielmo Celata
   */
  public function getItineraAttoDataRS($atto_id, $data)
  {
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select ai.data, i.id as iter_id from opp_iter i, opp_atto_has_iter ai where ai.atto_id=%d and ai.data < '%s' and ai.iter_id=i.id and i.id in (4, 7, 58, 57, 54, 52, 36, 30, 22, 25, 20, 16, 11, 13, 40, 41, 42, 45, 50, 56) group by iter_id irder by ai.id;",
                   $atto_id, $data);
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }
  
}
