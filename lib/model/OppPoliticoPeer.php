<?php

/**
 * Subclass for performing query and update operations on the 'opp_politico' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppPoliticoPeer extends BaseOppPoliticoPeer
{
  
  public static function getPictureUrl($id)
	{
	  return sfConfig::get('sf_pol_images_host', "http://op_openparlamento_images.s3.amazonaws.com/") . "parlamentari/picture/" . $id . '.jpeg';
	}

	public static function getThumbUrl($id)
	{
	  return sfConfig::get('sf_pol_images_host', "http://op_openparlamento_images.s3.amazonaws.com/") . "parlamentari/thumb/" . $id . '.jpeg';
	}
	
	/**
   * estrazione di tutti i record storici di un dato politico
   *
   * @param string $politico_id
   * @param boolean $meta - only return meta information for the politician
   * @return RecordSet
   * @author Guglielmo Celata
   */
  public static function getKWPoliticoMetaRSById($politico_id, $con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);
		  
		$sql = sprintf("select p.nome, p.cognome, p.id as politico_id, c.id as carica_id, c.data_inizio, c.circoscrizione,  g.nome as gruppo_nome, g.acronimo as gruppo_acronimo from opp_carica c, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g where c.politico_id=p.id and cg.carica_id=c.id and cg.data_fine is null and cg.gruppo_id = g.id and p.id=%d limit 1", 
		               $politico_id);
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }
  
  
	
}
