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
  
  /**
   * estrazione di tutti i record relativi a un politico o gruppo, per una legislatura
   *
   * @param string $legislatura 
   * @param string $chi_tipo 
   * @param string $chi_id 
   * @return array of OppPoliticianHistoryCache
   * @author Guglielmo Celata
   */
  public static function retrieveByLegislaturaChiTipoChiId($legislatura, $chi_tipo, $chi_id, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(self::LEGISLATURA, $legislatura);
		$criteria->add(self::CHI_TIPO, $chi_tipo);
		$criteria->add(self::CHI_ID, $chi_id);
		$v = self::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
  }
}
