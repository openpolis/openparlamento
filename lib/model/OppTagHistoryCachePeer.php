<?php

/**
 * Subclass for performing query and update operations on the 'opp_tag_history_cache' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppTagHistoryCachePeer extends BaseOppTagHistoryCachePeer
{
  
  
  /**
   * prende l'ultimo valore della data dai record S
   *
   * @return void
   * @author Guglielmo Celata
   */
  public static function fetchLastData()
  {
		$con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select distinct data from opp_tag_history_cache where chi_tipo='S' order by data desc");
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $rs->next();
    $row = $rs->getRow();
    return $row['data'];    
  }
  
  public static function extractDates($type = 'S', $con = null, $limit = 10)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select distinct data from opp_tag_history_cache where chi_tipo='$type' order by data desc limit $limit");
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $dates = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $data = $row['data'];
      $dates[$data] = $data;
    }
    
    return $dates;
  }
  
  /**
   * estrazione di tutti i record relativi a un atto per una legislatura
   *
   * @param string $data 
   * @param string $chi_tipo 
   * @param string $chi_id 
   * @return array of OppTagHistoryCache
   * @author Guglielmo Celata
   */
  public static function retrieveByDataChiTipoChiId($data, $chi_tipo, $chi_id, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(self::DATA, $data);
		$criteria->add(self::CHI_TIPO, $chi_tipo);
		$criteria->add(self::CHI_ID, $chi_id);
		$v = self::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
  }
  
  /**
   * estrae tutti i record a partire da una data
   *
   * @param string $data 
   * @return RecordSet come array associativo
   * @author Guglielmo Celata
   */
  public static function getRSByData($data, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		
		$sql = sprintf("select * from opp_tag_history_cache where data='%s' ", $data);
		
    $stm = $con->createStatement();
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }
  
  
}
