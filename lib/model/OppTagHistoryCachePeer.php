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
  
  public static function getHistory($chi_tipo, $chi_id, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		
		$storico = array();

    $sql = sprintf("select th.chi_id, th.indice, th.data from opp_tag_history_cache th where th.chi_tipo='%s' and th.chi_id=%s order by th.data", $chi_tipo, $chi_id);

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    while ($rs->next())
    {
      $row = $rs->getRow();
      
      $data = $row['data'];
      $rilevanza = $row['indice'];
      
      if (!array_key_exists($data, $storico))
        $storico[$data] = 0;

      $storico[$data] += $rilevanza;
    }  
    
    return $storico;      
    
  }

  
  public static function getAggregatedHistory($chi_tipo, $chi_ids, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		
		$storico = array();

    $sql = sprintf("select sum(th.indice) as i, th.data from opp_tag_history_cache th where th.chi_tipo='%s' and th.chi_id in (%s) group by data order by th.data", $chi_tipo, implode(',', $chi_ids));

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    while ($rs->next())
    {
      $row = $rs->getRow();
      
      $data = $row['data'];
      $rilevanza = $row['i'];
      
      if (!array_key_exists($data, $storico))
        $storico[$data] = 0;

      $storico[$data] += $rilevanza;
    }  
    
    return $storico;      
    
  }
  
  public static function getGeoAggregatedHistory($chi_tipo, $location_ids, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		
		$storico = array();

    $sql = sprintf("select sum(th.indice) as i, th.data from opp_tag_history_cache th, sf_tag t where t.id=th.chi_id and th.chi_tipo='%s' and t.triple_namespace='op_geo' and t.triple_key in (%s) group by data order by th.data", $chi_tipo, implode(',', $chi_ids));

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    while ($rs->next())
    {
      $row = $rs->getRow();
      
      $data = $row['data'];
      $rilevanza = $row['i'];
      
      if (!array_key_exists($data, $storico))
        $storico[$data] = 0;

      $storico[$data] += $rilevanza;
    }  
    
    return $storico;      
    
  }
  
  
  /**
   * retrieve di un record dati data, tipo e id
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
