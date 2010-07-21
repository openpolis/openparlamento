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
  
}
