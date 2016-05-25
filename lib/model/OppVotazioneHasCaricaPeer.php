<?php

/**
 * Subclass for performing query and update operations on the 'opp_votazione_has_carica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppVotazioneHasCaricaPeer extends BaseOppVotazioneHasCaricaPeer
{


  /**
   * returns key votes for the carica
   *
   * @param integer $carica_id 
   * @return array of OppVotazioneHasCarica
   * @author Guglielmo Celata
   */
  public static function getVotiChiaveCarica($carica_id)
  {
    $c = new Criteria();
    $c->addJoin(OppVotazionePeer::ID, sfLaunchingPeer::OBJECT_ID);
    $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);
    $c->addJoin(OppVotazionePeer::ID, self::VOTAZIONE_ID);
    $c->add(sfLaunchingPeer::OBJECT_MODEL, 'OppVotazione'); 
    $c->add(sfLaunchingPeer::LAUNCH_NAMESPACE, 'key_vote');
    $c->add(self::CARICA_ID, $carica_id);
    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
    return self::doSelect($c);
  }

  public static function countPresenzeVoti($carica_id, $data, $con = null)
  {
    if (is_null($con))
      $con = Propel::getConnection(self::DATABASE_NAME);
    
    $sql = sprintf("SELECT COUNT(*) cnt FROM opp_votazione_has_carica vc, opp_votazione v, opp_seduta s WHERE s.id=v.seduta_id and vc.votazione_id=v.id and vc.carica_id=%d and s.data < '%s' and vc.voto <> 'Assente'",
                        $carica_id, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return  $row['cnt'];
  }

  public static function countPresenzeVotiFinali($carica_id, $data, $con = null)
  {
    if (is_null($con))
      $con = Propel::getConnection(self::DATABASE_NAME);
    
    $sql = sprintf("SELECT COUNT(*) cnt FROM opp_votazione_has_carica vc, opp_votazione v, opp_seduta s WHERE s.id=v.seduta_id and vc.votazione_id=v.id and vc.carica_id=%d and s.data < '%s' and v.finale=1 and vc.voto <> 'Assente'",
                        $carica_id, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return  $row['cnt'];
  }

  /**
   * calcola il numero di voti in cui la maggioranza è stata battuta, ai quali la carica_id ha preso parte (non assente)
   *
   * @param string $carica_id 
   * @param string $data 
   * @param string $gruppo_magg_id  - il gruppo che identifica la maggioranza (Occhio)
   * @param string $con 
   * @return void
   * @author Guglielmo Celata
   */
  public static function countPresenzeVotiMaggBattuta($carica_id, $data, $gruppo_magg_id, $con = null)
  {
    if (is_null($con))
      $con = Propel::getConnection(self::DATABASE_NAME);
    
    $sql = sprintf("SELECT COUNT(*) cnt FROM opp_votazione_has_carica vc, opp_votazione v, opp_seduta s, opp_votazione_has_gruppo vg WHERE s.id=v.seduta_id and vc.votazione_id=v.id and vg.votazione_id=v.id and vc.carica_id=%d and s.data < '%s' and vg.gruppo_id=%d and (v.esito = 'Appr.' and vg.voto = 'Contrario' or v.esito = 'Resp.' and vg.voto = 'Favorevole') and vc.voto <> 'Assente'",
                        $carica_id, $data, $gruppo_magg_id);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return  $row['cnt'];
  }

  public static function countAssentiRibelliOpposizioneVotazioneMaggioranzaSalvata($votazione_id, $assente)
  {
    $c = new Criteria();
    $c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID,$votazione_id);
    $c->add(OppVotazioneHasCaricaPeer::MAGGIORANZA_SOTTO_SALVA, 2);
    if ($assente==1)
      $c->add(OppVotazioneHasCaricaPeer::VOTO, 'Assente');
    else
      $c->add(OppVotazioneHasCaricaPeer::VOTO, 'Assente', Criteria::NOT_EQUAL);
    return OppVotazioneHasCaricaPeer::doCount($c);
    
  }

  public static function countAssentiMaggioranzaVotazione($votazione_id, $data = null)
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    
    if (is_null($data)) {
      $votazione = OppVotazionePeer::retrieveByPK($votazione_id);
      $data = $votazione->getOppSeduta()->getData('Y-m-d');
    }

    $sql = sprintf("SELECT COUNT(*) cnt FROM opp_votazione_has_carica vc, opp_gruppo_is_maggioranza gm, opp_carica_has_gruppo cg, opp_votazione v, opp_carica c, opp_seduta s WHERE gm.MAGGIORANZA=1 AND gm.DATA_INIZIO<='%s' AND (gm.DATA_FINE>'%s' OR gm.DATA_FINE IS NULL ) AND cg.DATA_INIZIO <= '%s' AND (cg.DATA_FINE>'%s' OR cg.DATA_FINE IS NULL ) AND v.ID=%d AND vc.VOTO='Assente' AND vc.VOTAZIONE_ID = v.ID AND gm.GRUPPO_ID=cg.GRUPPO_ID AND cg.CARICA_ID=c.ID AND vc.CARICA_ID=c.ID AND s.ID=v.SEDUTA_ID",
                        $data, $data, $data, $data, $votazione_id);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return  $row['cnt'];
  }

  public static function countRibelliMaggioranzaVotazione($votazione_id, $data = null)
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    
    if (is_null($data)) {
      $votazione = OppVotazionePeer::retrieveByPK($votazione_id);
      $data = $votazione->getOppSeduta()->getData('Y-m-d');
    }
 
    $sql = sprintf("SELECT COUNT(*) cnt FROM opp_votazione_has_carica vc, opp_gruppo_is_maggioranza gm, opp_carica_has_gruppo cg, opp_votazione v, opp_carica c, opp_seduta s WHERE gm.MAGGIORANZA=1 AND gm.DATA_INIZIO<='%s' AND (gm.DATA_FINE>'%s' OR gm.DATA_FINE IS NULL ) AND cg.DATA_INIZIO <= '%s' AND (cg.DATA_FINE>'%s' OR cg.DATA_FINE IS NULL ) AND v.ID=%d AND vc.RIBELLE=1 AND vc.VOTAZIONE_ID = v.ID AND gm.GRUPPO_ID=cg.GRUPPO_ID AND cg.CARICA_ID=c.ID AND vc.CARICA_ID=c.ID AND s.ID=v.SEDUTA_ID",
                        $data, $data, $data, $data, $votazione_id);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return  $row['cnt'];
  }

  /**
   * conta il numero di ribellioni di una carica, a partire dalla opp_votazione_has_carica
   *
   * @param integer $carica_id 
   * @param integer $legislatura 
   * @param string  $data 
   * @return integer
   * @author Guglielmo Celata
   */
  public static function countRibellioniCaricaData($carica_id, $legislatura, $data)
  {
    $con = Propel::getConnection(self::DATABASE_NAME);

    $sql = sprintf("select count(vc.ribelle) n_ribellioni from opp_votazione_has_carica vc, opp_votazione v, opp_seduta s where vc.votazione_id=v.id and v.seduta_id=s.id and vc.ribelle = 1 and vc.carica_id=%d and s.data < '%s' and s.legislatura=%d",
                   $carica_id, $data,$legislatura);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next(); $row = $rs->getRow();
    return $row['n_ribellioni'];
  }
  
  /**
   * torna array con informazioni di dettaglio sul voto dei ribelli in una votazione
   *
   * @param int $votazione_id 
   * @return complex hash
   * @author Guglielmo Celata
   */
  public static function getVotoRibelli($votazione_id, $data = null)
  {
    
    $con = Propel::getConnection(self::DATABASE_NAME);
    
    if (is_null($data)) {
      $votazione = OppVotazionePeer::retrieveByPK($votazione_id);
      $data = $votazione->getOppSeduta()->getData('Y-m-d');
    }

    $sql = sprintf("SELECT p.id as politico_id, p.nome as politico_nome, p.cognome as politico_cognome, g.id as gruppo_id, g.nome as gruppo_nome, g.acronimo as gruppo_acronimo, vc.voto, vg.voto as voto_gruppo FROM opp_votazione_has_carica vc, opp_carica_has_gruppo cg, opp_votazione_has_gruppo vg, opp_gruppo g, opp_politico p, opp_carica c WHERE cg.DATA_INIZIO <= '%s' AND (cg.DATA_FINE>'%s' OR cg.DATA_FINE IS NULL ) AND g.NOME != 'Gruppo Misto' AND vc.RIBELLE=1 AND vc.CARICA_ID=c.ID AND c.POLITICO_ID=p.ID AND c.ID=cg.CARICA_ID AND cg.GRUPPO_ID=g.ID AND vc.VOTAZIONE_ID = %d AND  vg.votazione_id=vc.VOTAZIONE_ID AND vg.gruppo_id=g.id",
                        $data, $data, $votazione_id);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $ribelli = array();    
    while ($rs->next()) {      
      $ribelli []= $rs->getRow();
    }
    
    return $ribelli;
    
  }
  
  public static function getDatiPresenzaCaricaData($carica_id, $legislatura, $data)
  {
    $n_presenze = 0;
    $n_assenze = 0;
    $n_missioni = 0;

    $con = Propel::getConnection(self::DATABASE_NAME);

    $sql = sprintf("select vc.voto from opp_votazione_has_carica vc, opp_votazione v, opp_seduta s where vc.votazione_id=v.id and v.seduta_id=s.id and vc.carica_id=%d and s.data < '%s' and s.legislatura=%d",
                   $carica_id, $data, $legislatura);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    while ($rs->next()) {
      $row = $rs->getRow();
      switch ($row['voto']) {
        case 'Assente':
          $n_assenze++;
          break;
        case 'In missione':
          $n_missioni++;
          break;
        case 'Votazione annullata':
          break;
        default:
          $n_presenze++;
          break;
      }

    }
    return array($n_presenze, $n_assenze, $n_missioni);
  }


  public static function getVotoParlamentari($votazione_id, $data = null)
  {
    if (is_null($data)) {
      $votazione = OppVotazionePeer::retrieveByPK($votazione_id);
      $data = $votazione->getOppSeduta()->getData('Y-m-d');
    }
    
    $rs = self::getRSAllVotanti($votazione_id, $data);
    $voti = array();
    while ($rs->next()) {
      $voto = array();
      $voto['id'] = $rs->getInt(1);
      $voto['cognome'] = $rs->getString(2);
      $voto['nome'] = $rs->getString(3);
      $voto['nome_gruppo'] = $rs->getString(4);
      $voto['circoscrizione'] = $rs->getString(5);
      $voto['voto'] = $rs->getString(6);
      $voto['acronimo_gruppo'] = $rs->getString(7);
      $voti [] = $voto;
    }
    return $voti;
  }
  
  
  public static function getRSAllVotanti($votazione_id, $data = null)
  {
    if (is_null($data)) {
      $votazione = OppVotazionePeer::retrieveByPK($votazione_id);
      $data = $votazione->getOppSeduta()->getData('Y-m-d');
    }
    
    $c = new Criteria();

    $c->clearSelectColumns();
    $c->addSelectColumn(OppPoliticoPeer::ID);                // getInt(1)
    $c->addSelectColumn(OppPoliticoPeer::COGNOME);           // getString(2)
    $c->addSelectColumn(OppPoliticoPeer::NOME);              // getString(3)
    $c->addSelectColumn(OppGruppoPeer::NOME);                // getString(4)
    $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);      // getString(5)
    $c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);    // getString(6)
    $c->addSelectColumn(OppGruppoPeer::ACRONIMO);            // getString(7)
    $c->addSelectColumn(OppVotazioneHasCaricaPeer::RIBELLE);    // getInt(8)
    $c->addSelectColumn(OppVotazioneHasCaricaPeer::MAGGIORANZA_SOTTO_SALVA);    // getInt(9)

    $c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID);
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);
  	$c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID);
  	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);
  	$c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $votazione_id);
	  
  	$c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $data, Criteria::LESS_EQUAL);
  	$cton1 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, $data, Criteria::GREATER_THAN);
  	$cton2 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);
  	$cton1->addOr($cton2);
    $c->add($cton1);
	  
  	$c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
  	
  	return self::doSelectRS($c);
  }
  
  /**
   * torna array contenente il dettaglio del comportamento dei gruppi
   * - Gruppo Misto
   *   - favorevole  => N
   *   - contrario   => N
   *   - astenuto    => N
   *   - assente     => N
   *   - in missione => N
   *
   * @param integer $votazione_id 
   * @return complex hash
   * @author Guglielmo Celata
   */
  public static function doSelectGroupByGruppo($votazione_id, $data = null)
  {
    if (is_null($data)) {
      $votazione = OppVotazionePeer::retrieveByPK($votazione_id);
      $data = $votazione->getOppSeduta()->getData('Y-m-d');
    }
    
  	$risultato = array();

	  $c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppGruppoPeer::NOME);
  	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->addSelectColumn(OppGruppoPeer::ID);
  	$c->addAsColumn('CONT', 'COUNT(*)');
  	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::INNER_JOIN);

  	$c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $votazione_id);
  	$c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $data, Criteria::LESS_EQUAL);
  	$cton1 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, $data, Criteria::GREATER_THAN);
  	$cton2 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);
    $cton1->addOr($cton2);
    $c->add($cton1);
	
  	$c->addGroupByColumn(OppGruppoPeer::NOME);
  	$c->addGroupByColumn(OppVotazioneHasCaricaPeer::VOTO);
		  	
  	$rs = OppVotazioneHasCaricaPeer::doSelectRS($c);
	
  	while ($rs->next())
    {
	  
  	  if(!isset($risultato[$rs->getString(1)]))
  	  { 
  	    $risultato[$rs->getString(1)] = array('id' => $rs->getInt(3), 'Favorevole' => 0, 'Contrario' => 0, 'Astenuto' => 0, 'Assente' => 0, 'In missione' => 0);
  	  }
	  
  	  if(isset($risultato[$rs->getString(1)][$rs->getString(2)]))
  	    $risultato[$rs->getString(1)][$rs->getString(2)] = $rs->getInt(4);
	  
  	}
	
  	return $risultato;
		
  }

  

}

?>
