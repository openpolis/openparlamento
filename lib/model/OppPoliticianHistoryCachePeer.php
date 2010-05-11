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
   * estrazione di un record a partire da ramo e data
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
   * estrazione di un record a partire da ramo, tipo, id e data
   *
   * @param string $data 
   * @param string $chi_tipo 
   * @param string $chi_id 
   * @param string $ramo 
   * @return array of OppPoliticianHistoryCache
   * @author Guglielmo Celata
   */
  public static function retrieveByDataChiTipoChiIdRamo($data, $chi_tipo, $chi_id, $ramo, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$c = new Criteria();
		$c->add(self::DATA, $data);
		$c->add(self::CHI_TIPO, $chi_tipo);
		$c->add(self::CHI_ID, $chi_id);
		$c->add(self::RAMO, $ramo);
		$v = self::doSelect($c, $con);

		return !empty($v) ? $v[0] : null;
  }


  /**
   * estrazione di tutti i record per un ramo (per KW), per tutte le date
   *
   * @param string $ramo
   * @return RecordSet
   * @author Guglielmo Celata
   */
  public static function getKWRamoRS($ramo, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		  
		$sql = sprintf("select ph.presenze, ph.assenze, ph.missioni, ph.indice, ph.ribellioni, ph.presenze_delta, ph.assenze_delta, ph.missioni_delta, ph.indice_delta, ph.ribellioni_delta, ph.data from opp_politician_history_cache ph where ph.chi_tipo='R' and ph.ramo='%s' order by ph.data desc", 
		               $ramo);
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }

  /**
   * estrazione di tutti i record per gruppi (per KW) a partire dalla e data e dal ramo
   *
   * @param string $data 
   * @param string $ramo
   * @param string $order_by
   * @return RecordSet
   * @author Guglielmo Celata
   */
  public static function getKWGruppoRSByDataRamo($data, $ramo, $order_by = null, $order_type = 'asc', $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		  
		$order_clause = '';
		if (!is_null($order_by))
		  $order_clause = "order by $order_by $order_type";
		  
		$sql = sprintf("select ph.presenze, ph.assenze, ph.missioni, ph.indice, ph.ribellioni, ph.presenze_delta, ph.assenze_delta, ph.missioni_delta, ph.indice_delta, ph.ribellioni_delta, g.nome, g.acronimo, g.id as gruppo_id from opp_politician_history_cache ph, opp_gruppo g where ph.chi_id=g.id and ph.chi_tipo='G' and ph.ramo='%s' and ph.data='%s' %s", 
		               $ramo, $data, $order_clause);
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }

  /**
   * estrazione di tutti i record per politici (per KW) a partire da tipo e data
   *
   * @param string $data 
   * @param string $chi_tipo 
   * @param string $order_by
   * @return RecordSet
   * @author Guglielmo Celata
   */
  public static function getKWPoliticiRSByDataRamo($data, $ramo, $order_by = null, $order_type = 'asc', $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		  
		$order_clause = '';
		if (!is_null($order_by))
		  $order_clause = "order by $order_by $order_type";
		  
		$sql = sprintf("select ph.presenze, ph.assenze, ph.missioni, ph.indice, ph.ribellioni, ph.presenze_delta, ph.assenze_delta, ph.missioni_delta, ph.indice_delta, ph.ribellioni_delta, p.nome, p.cognome, p.id as politico_id, c.id as carica_id, c.data_inizio, c.circoscrizione,  g.nome as gruppo_nome, g.acronimo as gruppo_acronimo from opp_politician_history_cache ph, opp_carica c, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g where ph.chi_id=c.id and c.politico_id=p.id and cg.carica_id=c.id and cg.data_fine is null and cg.gruppo_id = g.id and ph.chi_tipo='P' and ph.ramo='%s' and ph.data='%s' %s", 
		               $ramo, $data, $order_clause);
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }

  /**
   * estrazione di tutti i record storici di un dato politico
   *
   * @param string $politico_id
   * @param boolean $meta - only return meta information for the politician
   * @return RecordSet
   * @author Guglielmo Celata
   */
  public static function getKWDatiPoliticoRSById($politico_id, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		  
		$sql = sprintf("select ph.data, ph.presenze, ph.assenze, ph.missioni, ph.indice, ph.ribellioni, ph.presenze_delta, ph.assenze_delta, ph.missioni_delta, ph.indice_delta, ph.ribellioni_delta from opp_politician_history_cache ph, opp_carica c, opp_politico p where ph.chi_id=c.id and c.politico_id=p.id and ph.chi_tipo='P' and p.id=%d order by ph.data desc", 
		               $politico_id);
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }


  /**
   * conta di tutti i record a partire da tipo e data
   *
   * @param string $data 
   * @param string $chi_tipo 
   * @return integer
   * @author Guglielmo Celata
   */
  public static function countByDataRamoChiTipo($data, $ramo, $chi_tipo, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$sql = sprintf("select count(*) as num from opp_politician_history_cache ph where ph.chi_tipo='%s' and ph.ramo='%s' and ph.data='%s'", 
		               $chi_tipo, $ramo, $data);
    $stm = $con->createStatement();
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return $row['num'];
  }
  

  /**
   * estrae tutti i record a partire da data, tipo e ramo (tipo e ramo non obbligatorio)
   *
   * @param string $data 
   * @param string $chi_tipo 
   * @return RecordSet
   * @author Guglielmo Celata
   */
  public static function getRSByDataRamoChiTipo($data, $ramo = null, $chi_tipo = null, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		
		$sql = sprintf("select * from opp_politician_history_cache ph where ph.data='%s' ", 
		               $data);
		if (!is_null($ramo)) $sql .= sprintf("and ramo = '%s' ", $ramo);
		if (!is_null($chi_tipo)) $sql .= sprintf("and chi_tipo = '%s' ", $chi_tipo);
		
    $stm = $con->createStatement();
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
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
