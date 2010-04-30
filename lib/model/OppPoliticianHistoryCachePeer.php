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
  
  public static function fetchLastData()
  {
		$con = Propel::getConnection(self::DATABASE_NAME);
		
		$sql = sprintf("select distinct data from opp_politician_history_cache where chi_tipo='P' order by data desc");
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $rs->next();
    $row = $rs->getRow();
    return $row['data'];    
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
  
  
  public static function getClassificaParlamentariRS($ramo, $con = null)
  {
    $ramo = strtolower(substr($ramo, 0, 1));
    
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

    if ($ramo == 'g') {
      $sql = "select p.id as p_id, p.nome, p.cognome, c.indice from opp_politician_history_cache c, opp_carica ca, opp_politico p where c.chi_id=ca.id and ca.politico_id=p.id and c.chi_tipo='p' and c.ramo='g' order by c.indice desc";
    } else {
      $sql = "select p.id as p_id, p.nome, p.cognome, g.acronimo, c.indice from opp_politician_history_cache c, opp_carica ca, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g where c.chi_id=ca.id and ca.politico_id=p.id and cg.carica_id=ca.id and cg.data_fine is null and cg.gruppo_id = g.id and c.chi_tipo='p' and c.ramo='$ramo' order by c.indice desc";      
    }
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
  }  
      
  
}
