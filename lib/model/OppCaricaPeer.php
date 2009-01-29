<?php

/**
 * Subclass for performing query and update operations on the 'opp_carica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaPeer extends BaseOppCaricaPeer
{
  /**
   * return an associative array of all the constituencies
   * a zero option is included at the beginning, if specified
   *
   * @param string $ramo 
   * @param boolean $include_zero
   * @return array of strings
   * @author Guglielmo Celata
   */
  public static function getAllConstituencies($ramo, $include_zero = false)
  {
    $c = new Criteria();
    if ($ramo == 'camera')
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
    else
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, 4);
    $c->clearSelectColumns();
    $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
    $c->setDistinct();
    $rs = OppCaricaPeer::doSelectRS($c);
    if ($include_zero)
      $all_constituencies = array('0' => $include_zero);
    else
      $all_constituencies = array();
      
    while ($rs->next())
    {
      $all_constituencies[$rs->getString(1)]= $rs->getString(1);
    }
    return $all_constituencies;
  }
  
  public static function doSelectFullReport($politico_id)
  {
    $risultato = array();
	
  	$c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppCaricaPeer::ID);
  	$c->addSelectColumn(OppCaricaPeer::DATA_INIZIO);
  	$c->addSelectColumn(OppCaricaPeer::DATA_FINE);
  	$c->addSelectColumn(OppCaricaPeer::CARICA);
  	$c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
  	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->addSelectColumn(OppCaricaPeer::INDICE);
  	$c->addSelectColumn(OppCaricaPeer::POSIZIONE);
  	$c->addAsColumn('CONT', 'COUNT(*)');
  	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::LEFT_JOIN);
  	$c->addGroupByColumn(OppCaricaPeer::ID);
  	$c->addGroupByColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->add(OppCaricaPeer::POLITICO_ID, $politico_id, Criteria::EQUAL);
  	$c->addDescendingOrderByColumn(OppCaricaPeer::DATA_INIZIO);
  	$c->addDescendingOrderByColumn(OppCaricaPeer::DATA_FINE);
  	$rs = OppCaricaPeer::doSelectRS($c);  
	
  	while ($rs->next())
    {
	  
  	  if(!isset($risultato[$rs->getInt(1)]))
  	  { 
	    
  		$risultato[$rs->getInt(1)] = array('data_inizio' => $rs->getDate(2, 'Y-m-d'), 'data_fine' => $rs->getDate(3, 'Y-m-d'),
  		                                   'carica' => $rs->getString(4), 'circoscrizione' => $rs->getString(5), 
  		                                   'Assente' => 0, 'Astenuto' => 0, 'Contrario' => 0, 'Favorevole' => 0, 'In missione' => 0, 
  										   'Partecipante votazione non valida' => 0, 'Presidente di turno' => 0, 'Richiedente la votazione e non votante' => 0, 
  										   'Voto segreto' => 0, 'Indice' => $rs->getFloat(7), 'Posizione' => $rs->getInt(8) );
  	  }
	  
  	  $risultato[$rs->getInt(1)][$rs->getString(6)] = $rs->getInt(9);
	  	  
  	}
	
	  return $risultato;
	
  }
  
  public static function doSelectPresenzePerGruppo($carica_id, $data_inizio, $data_fine)
  {
    $c = new Criteria();
  	$c->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, OppVotazionePeer::ID, Criteria::LEFT_JOIN);
  	$c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID, Criteria::LEFT_JOIN);
  	$c->add(OppVotazioneHasCaricaPeer::CARICA_ID, $carica_id, Criteria::EQUAL);
  	$c->add(OppSedutaPeer::DATA, $data_inizio, Criteria::GREATER_EQUAL);
	
  	if($data_fine!='') 
  	  $c->add(OppSedutaPeer::DATA, $data_fine, Criteria::LESS_EQUAL);
	
  	$cton1 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_2'), Criteria::EQUAL);
  	$cton2 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_3'), Criteria::EQUAL);
    $cton1->addOr($cton2);
	  $cton3 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_4'), Criteria::EQUAL);
    $cton1->addOr($cton3);
	  $cton4 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_6'), Criteria::EQUAL);
    $cton1->addOr($cton4);
	  $cton5 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_7'), Criteria::EQUAL);
    $cton1->addOr($cton5);
	  $cton6 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_8'), Criteria::EQUAL);
    $cton1->addOr($cton6);
	  $cton7 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_9'), Criteria::EQUAL);
    $cton1->addOr($cton7);
    $c->add($cton1);
	
	  return $totale = OppVotazioneHasCaricaPeer::doCount($c);   
  }

  /**
   * return the number of MPs in the given section (C or S)
   *
   * @param string $ramo 
   * @return void
   * @author Guglielmo Celata
   */
  public static function getNParlamentari($ramo)
  {
    $c = new Criteria();
    $c->add(self::DATA_FINE, null, Criteria::ISNULL);
    if ($ramo == 'C')
      $c->add(self::TIPO_CARICA_ID, 1);
    else
      $c->add(self::TIPO_CARICA_ID, array(4, 5), Criteria::IN);
    
    return self::doCount($c);
  }

  /**
   * returns the sum of the given field for all the MPs
   * in the given parliament section
   *
   * @param string $section 
   * @param string $field - the field to sum
   * @return void
   * @author Guglielmo Celata
   */
  public static function getSomma($field, $section)
  {
    $con=Propel::getConnection(self::DATABASE_NAME); 
    
    $sql = "SELECT sum($field) from opp_carica where data_fine is null and ";
    if ($section == 'C') $sql .= "tipo_carica_id = 1;";
    else $sql .= "tipo_carica_id in (4,5);";
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_NUM);
    if ($rs->next()) 
      return $rs->getInt(1);
    else
      return 0;
  }

}

?>
