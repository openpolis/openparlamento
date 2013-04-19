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
		  
		$sql = sprintf("select p.nome, p.cognome, p.id as politico_id, c.id as carica_id, c.data_inizio, c.circoscrizione, c.tipo_carica_id, g.nome as gruppo_nome, g.acronimo as gruppo_acronimo from opp_carica c, opp_politico p, opp_carica_has_gruppo cg, opp_gruppo g where c.politico_id=p.id and cg.carica_id=c.id and cg.data_fine is null and cg.gruppo_id = g.id and p.id=%d limit 1", 
		               $politico_id);
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }
  
  /**
   * torna array di id dei politici presidenti delle camere
   * per ora è codice statico, ma è l'unico punto che si deve modificare al cambio di legislatura
   *
   * @param string $ramo (camera o senato o null)
   * @return void
   * @author Guglielmo Celata
   */
  public static function getPresidentiCamereIds($ramo = null)
  {
    $pres_camera = 686427;  # boldrini
    $pres_senato = 687024; # grasso
    if ($ramo == 'camera') {
      return array($pres_camera);
    }
    if ($ramo == 'senato') {
      return array($pres_senato);
    }
    return array($pres_camera, $pres_senato);
  }

  /**
   * torna array di id per i politici membri del governo
   * si tratta dell'id della tabella opp_politico (o opp_carica.politico_id)
   *
   * @return array of integers
   * @author Guglielmo Celata
   */
  public static function getMembriGovernoIds($con = null)
  {
    if (is_null($con))
		  $con = Propel::getConnection(self::DATABASE_NAME);

    $sql = sprintf("select politico_id from opp_carica where tipo_carica_id in (2,3,5,6,7) and data_fine is null");
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $items = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $items []= $row['politico_id'];
    }

    return $items;
  }

  
  
  
	
}
