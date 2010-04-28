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
   * torna un array associativo di politici che si occupano di certi argomenti, 
   * ordinati in base al punteggio, con eventuale limit
   *
   * @param array $argomenti_ids 
   * @param string $ramo (C o S)
   * @return array di hash, con chiave carica_id
   *          - politico_id,
   *          - nome, cognome, acronimo,
   *          - punteggio
   * @author Guglielmo Celata
   */
  public static function getClassificaPoliticiSiOccupanoDiArgomenti($argomenti_ids, $ramo, $data, $limit = null)
  {
    
    // definizione array tipi di cariche
    if ($ramo == 'C') {
      $tipi_cariche = array(1);
    } else {      
      $tipi_cariche = array(4, 5);
    }

    // estrazione di tutte le firme relative ad atti taggati con argomento
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select p.nome, p.cognome, p.id as politico_id, g.acronimo, c.id as carica_id, ca.tipo, ca.atto_id, ah.indice from opp_carica c, opp_carica_has_atto ca, opp_carica_has_gruppo cg, opp_gruppo g, sf_tagging t, opp_act_history_cache ah, opp_politico p where p.id=c.politico_id and c.id=ca.carica_id and cg.carica_id=c.id and cg.gruppo_id=g.id and t.taggable_id=ca.atto_id and t.taggable_model='OppAtto' and ah.chi_tipo='A' and ah.data='%s' and ah.chi_id=ca.atto_id and c.tipo_carica_id in (%s) and c.data_fine is null and cg.data_fine is null and t.tag_id in (%s) group by ca.atto_id, ca.carica_id",
                   $data, implode(", ", $tipi_cariche), implode(", ", $argomenti_ids));

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    // costruzione array associativo dei politici
    $politici = array();
    while ($rs->next())
    {
      $row = $rs->getRow();
      $carica_id = $row['carica_id'];
      $atto_id = $row['atto_id'];
      $tipo = $row['tipo'];
      $punti_atto = $row['indice'];
      $politico_id = $row['politico_id'];
      $nome = $row['nome'];
      $cognome = $row['cognome'];
      $acronimo = $row['acronimo'];
      

      if (!array_key_exists($carica_id, $politici))
        $politici[$carica_id] = array('politico_id' => $politico_id, 
                                      'nome' => $nome, 'cognome' => $cognome, 'acronimo' => $acronimo, 
                                      'punteggio' => 0);

      $politici[$carica_id]['punteggio'] += OppCaricaHasAttoPeer::get_nuovo_fattore_firma($tipo) * $punti_atto;
    }

    // ordinamento per rilevanza, prima dello slice
    usort($politici, array("OppCaricaPeer", "comparisonIndice"));

    // slice dell'array, se specificata l'opzione limit
    if (!is_null($limit) && count($politici) > $limit)
    {
      $politici = array_slice($politici, 0, $limit, true);
    }

    return $politici;
  }
  
  
  public static function comparisonIndice($a, $b)
  {
    if ($a['punteggio'] == $b['punteggio']) {
        return 0;
    }
    return ($a['punteggio'] < $b['punteggio']) ? 1 : -1;
  }
  
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
   * torna array di OppCarica a partire da un array di ID (id di carica e NON politico)
   *
   * @param array $ids 
   * @return array of OppCarica
   * @author Guglielmo Celata
   */
  public function fetchFromIDArray($ids)
  {
    $c = new Criteria();
    $c->add(self::ID, $ids, Criteria::IN);
    return self::doSelect($c);
  }

  /**
   * estrae i parlamentari di un ramo, per una legislatura, attivi durante una settimana 
   * se ramo e settimana non sono specificati, l'estrazione riguarda tutti i rami/periodi
   * @param string  $ramo ['', 'camera', 'senato', 'governo']
   * @param integer $legislatura 
   * @param string  $settimana ['', 'y-m-d']
   * @return array di OppCaricaObject (join con OppPolitico)
   * @author Guglielmo Celata
   */
  public static function getParlamentariRamoSettimana($ramo, $settimana, $offset = null, $limit = null)
  {
    // calcolo della legislatura
    if ($settimana != '')
      $legislatura = OppLegislaturaPeer::getCurrent($settimana);
    else
      $legislatura = OppLegislaturaPeer::getCurrent();
      
    $c = new Criteria();
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);
    $c->addAscendingOrderByColumn(OppCaricaPeer::TIPO_CARICA_ID);
    $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
    
    if ($ramo == 'camera')
    {
      $c->add(OppCaricaPeer::LEGISLATURA, $legislatura, Criteria::EQUAL);
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, '1', Criteria::EQUAL);
    }
    else if ($ramo == 'senato')
    {
      // in questo modo considero i senatori a vita
      $cton = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $legislatura, Criteria::EQUAL);
      $cton1 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, null, Criteria::EQUAL);
      $cton->addOr($cton1);
      $c->add($cton);
 	    $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(4, 5), Criteria::IN);
    } 
    else if ($ramo == 'governo')
    {
      // considero presidente del consiglio, ministri, vicemoinistri e sottosegretari
 	    $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(2, 3, 6, 7), Criteria::IN);
    } 
    
    else if ($ramo == '')
    {

      /**
       * criteri composti per estrarre deputati, senatori e senatori a vita
       * (oppCarica.legislatura = leg OR oppCarica.legislatura IS NULL) AND 
       * (oppCarica.tipo_carica in (4, 5)  OR (oppCarica.legislatura = leg AND oppCarica.tipo_carica = 1))
       *
       **/
      $crit0 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $legislatura);
      $crit1 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, null, Criteria::ISNULL);
      $crit2 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, array(4, 5), Criteria::IN);
      $crit3 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $legislatura);
      $crit4 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 1);

      $crit0->addOr($crit1);
      $crit3->addAnd($crit4);
      $crit2->addOr($crit3);
      $crit0->addAnd($crit2);

      $c->add($crit0);
      
    }
    
    // in carica al momento del calcolo
    if ($settimana != '') {
      $cton0 = $c->getNewCriterion(OppCaricaPeer::DATA_INIZIO, strtotime("+1 week", strtotime($settimana)), Criteria::LESS_THAN);
      $cton1 = $c->getNewCriterion(OppCaricaPeer::DATA_FINE, $settimana, Criteria::GREATER_EQUAL);
      $cton2 = $c->getNewCriterion(OppCaricaPeer::DATA_FINE, null, Criteria::ISNULL);
      
      $cton1->addOr($cton2);
      $cton0->addAnd($cton1);
      $c->add($cton0);
    } else {
      $c->add(OppCaricaPeer::DATA_FINE, null, Criteria::EQUAL);
    }
    
    if ($offset) $c->setOffset($offset);
    if ($limit) $c->setLimit($limit);
    return self::doSelect($c);
  }


  public static function getActiveMPs($ramo, $limit = 0)
  {
    
    if (!in_array($ramo, array('C', 'S')))
      throw new Exception("Ramo must be 'C' or 'S'");
      
    $c = new Criteria();
    if ($ramo == 'C')
    {
      $c->add(self::TIPO_CARICA_ID, 1);
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, '1', Criteria::EQUAL);
      
    }
    else
    {
      $c->add(self::TIPO_CARICA_ID, array(4, 5), Criteria::IN);

      $cton = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, '4', Criteria::EQUAL);
      $cton1 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, '5', Criteria::EQUAL);
      $cton->addOr($cton1);
      $c->add($cton);
      
    }

    $c->add(OppCaricaPeer::LEGISLATURA, '16', Criteria::EQUAL);
    $c->add(self::DATA_FINE, null, Criteria::ISNULL);
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);

    if ($limit > 0)
      $c->setLimit($limit);
      
    return OppCaricaPeer::doSelect($c);
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
    if (!in_array($ramo, array('C', 'S')))
      throw new Exception("Ramo must be 'C' or 'S'");
      
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
