<?php

/**
 * Subclass for performing query and update operations on the 'opp_emendamento_has_iter' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppEmendamentoHasIterPeer extends BaseOppEmendamentoHasIterPeer
{

  /**
   * estrae gli *itinera* di un emendamento, a una certa data
   *
   * @param integer $emendamento_id 
   * @param string  $data 
   * @return array di hash ('iter_id' => ID, 'data' => DATE)
   * @author Guglielmo Celata
   */
  public static function getItinera($emendamento_id, $data)
  {
    $rs = self::getItineraEmendamentoDataRS($emendamento_id, $data);
    
    $itinera = array();
    while ($rs->next()) {
      $itinera []= $rs->getRow();
    }
    
    return $itinera;
  }

  /**
   * legge gli itinera interessanti di un singolo emendamento
   * interessanti sono quelli cui vengono sassegnati dei punti
   *
   * @param string $atto_id 
   * @param string $data 
   * @return void
   * @author Guglielmo Celata
   */
  public function getItineraEmendamentoDataRS($emendamento_id, $data)
  {
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select data, em_iter_id from opp_emendamento_has_iter where emendamento_id=%d and data < '%s' and em_iter_id in (1, 2) group by emendamento_id, em_iter_id;",
                   $emendamento_id, $data);
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }
  
}
