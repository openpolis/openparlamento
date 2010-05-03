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
                   $carica_id, $data, $legislatura);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next(); $row = $rs->getRow();
    return $row['n_ribellioni'];
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


  public static function doSelectGroupByGruppo($votazione_id)
  {
    
	  $c = new Criteria();
    $c->add(OppVotazionePeer::ID, $votazione_id, Criteria::EQUAL );
    $votazione = OppVotazionePeer::doSelectJoinOppSeduta($c);
    $votazione = $votazione[0];
	
  	$risultato = array();
		
  	$c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppGruppoPeer::NOME);
  	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->addAsColumn('CONT', 'COUNT(*)');
  	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::INNER_JOIN);
  	$c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $votazione_id, Criteria::EQUAL);
	
  	$c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $votazione->getOppSeduta()->getData(), Criteria::LESS_EQUAL);
  	$cton1 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, $votazione->getOppSeduta()->getData(), Criteria::GREATER_EQUAL);
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
  	    $risultato[$rs->getString(1)] = array('Favorevole' => 0, 'Contrario' => 0, 'Astenuto' => 0, 'Assente' => 0, 'In missione' => 0);
  	  }
	  
  	  if(isset($risultato[$rs->getString(1)][$rs->getString(2)]))
  	    $risultato[$rs->getString(1)][$rs->getString(2)] = $rs->getInt(3);
	  
  	}
	
  	return $risultato;
		
  }

}

?>
