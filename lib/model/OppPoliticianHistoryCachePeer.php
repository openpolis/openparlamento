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

  public static function getIndexChartsPoliticians($ramo, $data, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);

		$sql = sprintf("select pc.id, p.id as politico_id, p.nome, p.cognome, g.acronimo, c.circoscrizione, pc.assenze/(pc.presenze+pc.missioni+pc.assenze)*100.0 as perc_assenze, pc.assenze as assenze, (pc.presenze+pc.missioni+pc.assenze) as votazioni, pc.indice, pc.indice_pos from opp_politician_history_cache pc, opp_carica c, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g where p.id=c.politico_id and c.id=pc.chi_id and cg.carica_id=c.id and cg.gruppo_id=g.id and cg.data_fine is null and c.data_fine is null and pc.chi_tipo='P' and pc.data='%s' and pc.ramo='%s' and p.id not in (select politico_id from opp_carica where tipo_carica_id in (2,3,5,6,7) and data_fine is null) and p.id not in (%s) and c.data_inizio <  '%s' - interval 365 day", $data, $ramo, implode(",", OppPoliticoPeer::getPresidentiCamereIds()), $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $items = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $items []= $row;
    }
    
    return $items;
  }
  
  public static function getIndexChartsRegions($ramo, $data, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);

		$sql = sprintf("select pc.id, if( c.circoscrizione is null, 'Senatori a vita', if(c.circoscrizione in ('America meridionale', 'America settentrionale e centrale', 'Asia-Africa-Oceania-Antartide', 'Europa'), 'Estero', if(substr(c.circoscrizione, length(c.circoscrizione)) in ('1', '2', '3'),left(c.circoscrizione, length(c.circoscrizione)-1), c.circoscrizione))) as regione, count(*) as n, sum(pc.assenze)/sum(pc.presenze+pc.missioni+pc.assenze)*100.0 as perc_assenze, sum(pc.indice) as indice_totale, sum(pc.indice)/count(*) as indice_medio from opp_politician_history_cache pc, opp_carica c, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g where p.id=c.politico_id and c.id=pc.chi_id and cg.carica_id=c.id and cg.gruppo_id=g.id and cg.data_fine is null and c.data_fine is null and pc.chi_tipo='P' and pc.data='%s' and pc.ramo='%s' and p.id not in (select politico_id from opp_carica where tipo_carica_id in (2,3,5,6,7) and data_fine is null) and p.id not in (%s) and c.data_inizio <  '%s' - interval 365 day group by if(c.circoscrizione in ('America meridionale', 'America settentrionale e centrale', 'Asia-Africa-Oceania-Antartide', 'Europa'), 'Estero', if(substr(c.circoscrizione, length(c.circoscrizione)) in ('1', '2', '3'), left(c.circoscrizione, length(c.circoscrizione)-1), c.circoscrizione))", $data, $ramo, implode(",", OppPoliticoPeer::getPresidentiCamereIds()), $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $items = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $items []= $row;
    }

    return $items;
  }


  public static function getIndexChartsGroups($ramo, $data, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);

		$sql = sprintf("select pc.id, g.acronimo, g.nome as gruppo, count(*) as n, sum(pc.assenze)/sum(pc.presenze+pc.missioni+pc.assenze)*100.0 as perc_assenze, sum(pc.indice) as indice_totale, sum(pc.indice)/count(*) as indice_medio from opp_politician_history_cache pc, opp_carica c, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g where p.id=c.politico_id and c.id=pc.chi_id and cg.carica_id=c.id and cg.gruppo_id=g.id and cg.data_fine is null and c.data_fine is null and pc.chi_tipo='P' and pc.data='%s' and pc.ramo='%s' and p.id not in (select politico_id from opp_carica where tipo_carica_id in (2,3,5,6,7) and data_fine is null) and p.id not in (%s) and c.data_inizio <  '%s' - interval 365 day group by g.acronimo", $data, $ramo, implode(",", OppPoliticoPeer::getPresidentiCamereIds()), $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $items = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $items []= $row;
    }

    return $items;
  }

  public static function getIndexChartsSex($ramo, $data, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);

		$sql = sprintf("select pc.id, p.sesso, count(*) as n, sum(pc.assenze)/sum(pc.presenze+pc.missioni+pc.assenze)*100.0 as perc_assenze, sum(pc.indice) as indice_totale, sum(pc.indice)/count(*) as indice_medio from opp_politician_history_cache pc, opp_carica c, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g where p.id=c.politico_id and c.id=pc.chi_id and cg.carica_id=c.id and cg.gruppo_id=g.id and cg.data_fine is null and c.data_fine is null and pc.chi_tipo='P' and pc.data='%s' and pc.ramo='%s' and p.id not in (select politico_id from opp_carica where tipo_carica_id in (2,3,5,6,7) and data_fine is null) and p.id not in (%s)  and c.data_inizio <  '%s' - interval 365 day group by p.sesso", $data, $ramo, implode(",", OppPoliticoPeer::getPresidentiCamereIds()), $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $items = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $items []= $row;
    }

    return $items;
  }
  
  
  public static function getIndexChartsPoliticiansInConstituency($ramo, $data, $circoscrizione_slug, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);

    $circoscrizione = self::getCircoscrizioneNameFromSlug($circoscrizione_slug);

    $sql = sprintf("select pc.id, p.id as politico_id, p.nome, p.cognome, g.acronimo, c.circoscrizione, pc.assenze/(pc.presenze+pc.missioni+pc.assenze)*100.0 as perc_assenze, pc.assenze as assenze, (pc.presenze+pc.missioni+pc.assenze) as votazioni, pc.indice from opp_politician_history_cache pc, opp_carica c, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g where p.id=c.politico_id and c.id=pc.chi_id and cg.carica_id=c.id and cg.gruppo_id=g.id and cg.data_fine is null and c.data_fine is null and pc.chi_tipo='P' and pc.data='%s' and pc.ramo='%s' and c.circoscrizione='%s' and p.id not in (select politico_id from opp_carica where tipo_carica_id in (2,3,5,6,7) and data_fine is null) and p.id not in (%s) and c.data_inizio <  '%s' - interval 365 day order by pc.indice desc", $data, $ramo, $circoscrizione, implode(",", OppPoliticoPeer::getPresidentiCamereIds()), $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $items = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $items []= $row;
    }

    return $items;
  }
  
  public static function getCircoscrizioneNameFromSlug($value)
  {
    $value = preg_replace('/([a-z]+)-([123])/', '$1 $2', $value);
    
    switch ($value) {
      case 'emilia-romagna':
        return "Emilia-Romagna";
        break;

      case 'valle-d-aosta':
        return "Valle D\'Aosta";
        break;

      case 'friuli-venezia-giulia':
        return "Friuli-Venezia Giulia";
        break;

      case 'trentino-alto-adige':
        return "Trentino-Alto adige";
        break;
      
      default:
        return ucfirst($value);
        break;
    }
  }
  
  public static function getIndexChartsTopPoliticians($ramo, $data, $limit, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);

    $sql = sprintf(
      "select pc.id, p.id as politico_id, p.nome, p.cognome, p.sesso," .
      "  g.acronimo, g.nome, " .
      "  c.circoscrizione, " .
      "  pc.assenze/(pc.presenze+pc.missioni+pc.assenze)*100.0 as perc_assenze, pc.assenze as assenze, " .
      "  pc.presenze/(pc.presenze+pc.missioni+pc.assenze)*100.0 as perc_presenze, pc.presenze as presenze, " .
      "  pc.missioni/(pc.presenze+pc.missioni+pc.assenze)*100.0 as perc_missioni, pc.missioni as missioni, " .
      "  (pc.presenze+pc.missioni+pc.assenze) as votazioni, " .
      "  pc.indice " .
      "from opp_politician_history_cache pc, " .
      "  opp_carica c, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g " .
      "where p.id=c.politico_id and c.id=pc.chi_id and cg.carica_id=c.id and cg.gruppo_id=g.id and " .
      "  cg.data_fine is null and c.data_fine is null and " .
      "  pc.chi_tipo='P' and pc.data='%s' and pc.ramo='%s' and " .
      "  p.id not in (select politico_id from opp_carica where tipo_carica_id in (2,3,5,6,7) and data_fine is null) and " .
      "  p.id not in (686427, 687024) " .
      "order by pc.indice desc limit %s",
      $data, $ramo, $limit
    );

    $stm = $con->createStatement();
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $items = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $items []= $row;
    }

    return $items;
  }
  

  public static function countRecordsRamoData($ramo, $data, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		  
	$sql = sprintf(
        "select count(*) as num from opp_politician_history_cache where chi_tipo='P' and ramo='%s' and data='%s'",
        $ramo, $data
    );
    $stm = $con->createStatement();
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
    $rs->next();
    $row = $rs->getRow();
    return $row['num'];    
  }

  public static function getSommaDatoRamoData($ramo, $data, $nome, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select sum(%s) as somma from opp_politician_history_cache where chi_tipo='P' and ramo='%s' and data='%s'",
		               $nome, $ramo, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $rs->next();
    $row = $rs->getRow();
    return $row['somma'];    
  }
 
  /**
   * raccoglie i dati relativi a un ramo per una data e li aggrega (somma e numero)
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
      $res[$nome] = self::getSommaDatoRamoData($ramo, $data, $nome, $con);
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

  public static function getSommaDatoGruppoRamoData($gruppo_id, $ramo, $data, $nome, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select sum(%s) as somma from opp_politician_history_cache where chi_tipo='P' and gruppo_id=%d and ramo='%s' and data='%s'", $nome, $gruppo_id, $ramo, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $rs->next();
    $row = $rs->getRow();
    return $row['somma'];    
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
      $res[$nome] = self::getSommaDatoGruppoRamoData($gruppo_id, $ramo, $data, $nome, $con);
    }
    return $res;
  }
  
  public static function fetchLastData($type = 'P', $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select distinct data from opp_politician_history_cache where chi_tipo='$type' order by data desc");
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $rs->next();
    $row = $rs->getRow();
    return $row['data'];    
  }
  
  public static function extractDates($type = 'P', $con = null, $limit = 10)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select distinct data from opp_politician_history_cache where chi_tipo='$type' order by data desc limit $limit");
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
   * estrazione dei valori delta (presenze, ribellioni, indice)
   * per politici di un certo ramo, a partire da una data, con limite
   * è estratto il delta tra i dati a fine mese precedente e ancora precedente, rispetto alla data
   *
   * @param string $data_1
   * @param string $data_2
   * @param string $ramo (C o S)
   * @param string $ (C o S)
   * @param string $dato
   * @return RecordSet
   * @author Guglielmo Celata
   */
  public static function getDeltaPoliticiRSByDataRamo($data_1, $data_2, $ramo, $dato, $con = null)
  {
    if ($data_1 <= $data_2 )
      throw new Exception("data_2 must be greater than data_1");

      
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		  
    if ($data_2 != 0)
    {
      $data_2 = date('Y-m-d', strtotime('-1 day', strtotime($data_2)));
  		$sql = sprintf("select p.nome, p.cognome, p.id as politico_id, g.nome as gruppo_nome, g.acronimo as gruppo_acronimo, p1.presenze-p2.presenze as n_presenze, p1.%s-p2.%s delta, p1.%s_delta as trend, p1.presenze+p1.assenze+p1.missioni-p2.presenze-p2.assenze-p2.missioni as n_votazioni from opp_politician_history_cache p1, opp_politician_history_cache p2, opp_carica_has_gruppo cg, opp_gruppo g, opp_carica c, opp_politico p where p1.chi_id=p2.chi_id and p1.chi_id=c.id and cg.carica_id=c.id and cg.data_fine is null and cg.gruppo_id = g.id and c.politico_id=p.id and p1.data='%s' and p2.data='%s' and p1.chi_tipo='P' and p1.ramo='%s' order by delta desc, trend desc", 
  		               $dato, $dato, $dato, $data_1, $data_2, $ramo);      
    } else {
      $sql = sprintf("select p.nome, p.cognome, p.id as politico_id, g.nome as gruppo_nome, g.acronimo as gruppo_acronimo, p1.presenze as n_presenze, p1.%s delta, p1.%s_delta as trend, p1.presenze+p1.assenze+p1.missioni as n_votazioni from opp_politician_history_cache p1, opp_carica_has_gruppo cg, opp_gruppo g, opp_carica c, opp_politico p where p1.chi_id=c.id and cg.carica_id=c.id and cg.data_fine is null and cg.gruppo_id = g.id and c.politico_id=p.id and p1.data='%s' and p1.chi_tipo='P' and p1.ramo='%s' order by delta desc, trend desc", 
  		               $dato, $dato, $data_1, $ramo);
    }
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
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
