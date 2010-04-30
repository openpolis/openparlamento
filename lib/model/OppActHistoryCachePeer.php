<?php

/**
 * Subclass for performing query and update operations on the 'opp_act_history_cache' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppActHistoryCachePeer extends BaseOppActHistoryCachePeer
{
  
  /**
   * prende l'ultimo valore della data dai record A
   *
   * @return void
   * @author Guglielmo Celata
   */
  public static function fetchLastData()
  {
		$con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select distinct data from opp_act_history_cache where chi_tipo='A' order by data desc");
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
   * @return array of OppActHistoryCache
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
   * torna l'indice trovato nella cache, per un atto (chi_tipo = 'A', chi_id)
   * a una determinata data (deve essere ESATTA)
   *
   * @param string $data 
   * @param string $atto_id 
   * @param string $con 
   * @return float
   * @author Guglielmo Celata
   */
  public static function getIndiceForAttoData($atto_id, $data, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		
		$sql = sprintf("select indice from opp_act_history_cache where chi_tipo='A' and chi_id=%d and data='%s'",
                   $atto_id, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $rs->next();
    $row = $rs->getRow();
    return $row['indice'];
    
  }
  
}

