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

  public static function getItinera($atto_id, $data)
  {
    $c = new Criteria();
    $c->add(self::ATTO_ID, $atto_id);
    $c->add(self::DATA, $data, Criteria::LESS_THAN);
    $c->addGroupByColumn(self::ATTO_ID);
    $c->addGroupByColumn(self::ITER_ID);    
    
    return self::doSelectJoinOppIter($c);
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
    $sql = sprintf("select ai.data, i.id as iter_id from opp_iter i, opp_atto_has_iter ai where ai.atto_id=%d and ai.data < '%s' and ai.iter_id=i.id and i.id in (4, 7, 58, 57, 54, 52, 36, 30, 20, 16) group by iter_id;",
                   $atto_id, $data);
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }
  
}
