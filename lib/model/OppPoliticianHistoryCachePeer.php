<?php

/**
 * Subclass for performing query and update operations on the 'opp_politician_history_cache' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppPoliticianHistoryCachePeer extends BaseOppPoliticianHistoryCachePeer
{


  public static function countRecordsRamoData($ramo, $data, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		  
		$sql = sprintf("select count(*) as num from opp_politician_history_cache where chi_tipo='P' and ramo='%s' and data='%s'", 
		               $ramo, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
    $rs->next();
    $row = $rs->getRow();
    return $row['num'];    
  }

  public static function getMediaDatoRamoData($ramo, $data, $nome, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select sum(%s)/count(%s) as avg from opp_politician_history_cache where chi_tipo='P' and ramo='%s' and data='%s'",
		               $nome, $nome, $ramo, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $rs->next();
    $row = $rs->getRow();
    return $row['avg'];    
  }
 
  /**
   * raccoglie i dati relativi a un ramo per una data e li aggrega (media e numero)
   * tornando un risultato
   *
   * @param string  $ramo 
   * @param string  $data 
   * @return hash di interi
   *         - indice
   *         - presenze
   *         - assenze
   *         - missioni
   *         - ribellioni
   * @author Guglielmo Celata
   */
  public static function aggregaDatiRamoData($ramo, $data, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);

    $dati = array('indice', 'presenze', 'assenze', 'missioni', 'ribellioni');
    foreach ($dati as $nome) {
      $res[$nome] = self::getMediaDatoRamoData($ramo, $data, $nome, $con);
    }
    return $res;
  }

  public static function countRecordsGruppoRamoData($gruppo_id, $ramo, $data, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		  
		$sql = sprintf("select count(*) as num from opp_politician_history_cache where chi_tipo='P' and gruppo_id=%d and ramo='%s' and data='%s'", $gruppo_id, $ramo, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
    $rs->next();
    $row = $rs->getRow();
    return $row['num'];    
  }

  public static function getMediaDatoGruppoRamoData($gruppo_id, $ramo, $data, $nome, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select sum(%s)/count(%s) as avg from opp_politician_history_cache where chi_tipo='P' and gruppo_id=%d and ramo='%s' and data='%s'", $nome, $nome, $gruppo_id, $ramo, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $rs->next();
    $row = $rs->getRow();
    return $row['avg'];    
  }
 
  /**
   * raccoglie i dati relativi a un gruppo per una data e li aggrega (media e numero)
   * tornando un risultato
   *
   * @param integer $gruppo_id 
   * @param string  $ramo 
   * @param string  $data 
   * @return hash di interi
   *         - indice
   *         - presenze
   *         - assenze
   *         - missioni
   *         - ribellioni
   * @author Guglielmo Celata
   */
  public static function aggregaDatiGruppoRamoData($gruppo_id, $ramo, $data, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);

    $dati = array('indice', 'presenze', 'assenze', 'missioni', 'ribellioni');
    foreach ($dati as $nome) {
      $res[$nome] = self::getMediaDatoGruppoRamoData($gruppo_id, $ramo, $data, $nome, $con);
    }
    return $res;
  }
  
  public static function fetchLastData($con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select distinct data from opp_politician_history_cache where chi_tipo='P' order by data desc");
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $rs->next();
    $row = $rs->getRow();
    return $row['data'];    
  }

  /**
   * estrazione di tutti i record relativi a un ramo, per una data
   *
   * @param string $data 
   * @param string $chi_tipo 
   * @param string $ramo
   * @return array of OppPoliticianHistoryCache
   * @author Guglielmo Celata
   */
  public static function retrieveByDataChiTipoRamo($data, $chi_tipo, $ramo, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(self::DATA, $data);
		$criteria->add(self::CHI_TIPO, $chi_tipo);
		$criteria->add(self::CHI_ID, 0);
		$criteria->add(self::RAMO, $ramo);
		$v = self::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
  }

  
  /**
   * estrazione di tutti i record relativi a un politico o gruppo, per una data
   *
   * @param string $data 
   * @param string $chi_tipo 
   * @param string $chi_id 
   * @return array of OppPoliticianHistoryCache
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
  
  
  public static function getClassificaParlamentariNuovoRS($ramo, $con = null)
  {
    $ramo = strtolower(substr($ramo, 0, 1));
    
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

    if ($ramo == 'g') {
      $sql = "select p.id as p_id, p.nome, p.cognome, c.indice from opp_politician_history_cache c, opp_carica ca, opp_politico p where c.chi_id=ca.id and ca.politico_id=p.id and c.chi_tipo='n' and c.ramo='g' order by c.indice desc";
    } else {
      $sql = "select p.id as p_id, p.nome, p.cognome, g.acronimo, c.indice from opp_politician_history_cache c, opp_carica ca, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g where c.chi_id=ca.id and ca.politico_id=p.id and cg.carica_id=ca.id and cg.data_fine is null and cg.gruppo_id = g.id and c.chi_tipo='n' and c.ramo='$ramo' order by c.indice desc";      
    }
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
  }  
      
  
}
