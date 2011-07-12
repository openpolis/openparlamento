<?php

/**
 * Subclass for performing query and update operations on the 'opp_votazione' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppVotazionePeer extends BaseOppVotazionePeer
{

  public static function maggioranzaSottoCriteria()
  {
    $c = new Criteria();

    $c->addJoin(OppVotazionePeer::ID,OppVotazioneHasGruppoPeer::VOTAZIONE_ID);

    // Prendi il voto del Gruppo della PDL GRUPPO_ID=19;
    $crit0 = $c->getNewCriterion(OppVotazioneHasGruppoPeer::GRUPPO_ID, 19);
    $crit1 = $c->getNewCriterion(OppVotazionePeer::ESITO, 'Appr.');
    $crit2 = $c->getNewCriterion(OppVotazioneHasGruppoPeer::VOTO, 'Contrario');

    $crit1->addAnd($crit2);
    $crit3 = $c->getNewCriterion(OppVotazionePeer::ESITO, 'Resp.');
    $crit4 = $c->getNewCriterion(OppVotazioneHasGruppoPeer::VOTO, 'Favorevole');

    $crit3->addAnd($crit4);

    $crit1->addOr($crit3);

    $crit0->addAnd($crit1);

    $c->add($crit0);

    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
    $c->add(OppSedutaPeer::LEGISLATURA, '16', Criteria::EQUAL);
    
    return $c;
  }

  public static function getMaggioranzaSottoVotes($limit = 0)
  {
    $c = self::maggioranzaSottoCriteria();
    if ($limit != 0)
       $c->setLimit($limit);
    return OppVotazionePeer::doSelectJoinOppSeduta($c);        
  }


  /**
   * estrae gli ultimi due key votes, uno per la camera e uno per il senato
   *
   * @return array di OppVotazione
   * @author Guglielmo Celata
   */
  public static function getLastTwoKeyVotes($type = 'key')
  {
    $c = new Criteria();
    $c->addJoin(OppVotazionePeer::ID, sfLaunchingPeer::OBJECT_ID);
    $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);
    $c->add(sfLaunchingPeer::OBJECT_MODEL, 'OppVotazione'); 
    if ($type == 'key') {
      $c->add(sfLaunchingPeer::LAUNCH_NAMESPACE, 'key_vote');
    } else {
      $c->add(sfLaunchingPeer::LAUNCH_NAMESPACE, 'relevant_vote');      
    }
    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA); 

    $votazioni = array();
    
    $c->add(OppSedutaPeer::RAMO, 'C');
    $votazioni[0] = OppVotazionePeer::doSelectOne($c);
    
    $c->add(OppSedutaPeer::RAMO, 'S');
    $votazioni[1] = OppVotazionePeer::doSelectOne($c);
    
    return $votazioni;
  }
  
  public static function getKeyVotes($limit = 0, $namespace = 'key')
  {
    $c = new Criteria();
    $c->addJoin(OppVotazionePeer::ID, sfLaunchingPeer::OBJECT_ID);
    $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);
    $c->add(sfLaunchingPeer::OBJECT_MODEL, 'OppVotazione'); 
    if ($namespace == 'key') {
      $c->add(sfLaunchingPeer::LAUNCH_NAMESPACE, 'key_vote');
    } 
    if ($namespace == 'relevant') {
      $c->add(sfLaunchingPeer::LAUNCH_NAMESPACE, 'relevant_vote');      
    }
    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA); 
    if ($limit != 0)
       $c->setLimit($limit);
    return OppVotazionePeer::doSelect($c);    
  }
  
  public static function doSelectVotoGruppo($votazione_id, $gruppo)
  {
    
  $c= new Criteria();
  $c->add(OppVotazionePeer::ID,$votazione_id);
  $votazione=OppVotazionePeer::doSelectOne($c);
  $data_votazione=$votazione->getOppSeduta()->getData();
    
  $c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
	$c->addAsColumn('CONT', 'COUNT(*)');
	
	
	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::INNER_JOIN);
	$c->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, OppVotazionePeer::ID, Criteria::INNER_JOIN);	
	//$c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID, Criteria::INNER_JOIN);	
	$c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::INNER_JOIN);
	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::INNER_JOIN);
		
	$c->add(OppVotazioneHasCaricaPeer::VOTO, 'Assente', Criteria::NOT_EQUAL);	
	
	$cton1 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Favorevole', Criteria::EQUAL);
	$cton2 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Contrario', Criteria::EQUAL);
	$cton1->addOr($cton2);
    $cton3 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Astenuto', Criteria::EQUAL);
	$cton1->addOr($cton3);
    
    $c->add($cton1);
    
	$c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $votazione_id, Criteria::EQUAL);
	$c->add(OppGruppoPeer::NOME, $gruppo, Criteria::EQUAL);
	
	$c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $data_votazione, Criteria::LESS_EQUAL);
	$cton4 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, $data_votazione, Criteria::GREATER_EQUAL);
	$cton5 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);
    $cton4->addOr($cton5);
    $c->add($cton4);
	
	$c->addGroupByColumn(OppVotazioneHasCaricaPeer::VOTO);
	$c->addDescendingOrderByColumn('CONT');
	$c->setLimit(2);
	
	$rs = OppCaricaPeer::doSelectRS($c);
	
	$voto = 'nv';
	
    $voti = array();
	
	$i = 0;
    while ($rs->next())
    {
      $voti[$i] = array('voto' => $rs->getString(1), 'numero' => $rs->getInt(2));
      $i++;
    }
    
    if((count($voti)>1 && $voti[0]['numero'] != $voti[1]['numero']) || count($voti)==1) 
      $voto = $voti[0]['voto'];    
   
     return $voto;
  }
  
  public static function doSelectCountVotazioniPerPeriodo($data_inizio, $data_fine, $legislatura, $ramo)
  {
    $c = new Criteria();
	$c->addJoin(OppSedutaPeer::ID, OppVotazionePeer::SEDUTA_ID, Criteria::LEFT_JOIN);
	//$c->add(OppSedutaPeer::DATA, $data_inizio, Criteria::GREATER_EQUAL);
	$c->add(OppSedutaPeer::RAMO, $ramo, Criteria::EQUAL);
	$c->add(OppSedutaPeer::LEGISLATURA, $legislatura, Criteria::EQUAL);
	if($data_inizio!='') 
	  $c->add(OppSedutaPeer::DATA, $data_inizio, Criteria::GREATER_EQUAL);
	
	if($data_fine!='') 
	  $c->add(OppSedutaPeer::DATA, $data_fine, Criteria::LESS_EQUAL);
		
	return $count = OppVotazionePeer::doCount($c);
  }  
  
  public static function doSelectDataUltimaVotazione($data_inizio, $data_fine, $legislatura, $ramo)
  {
    $c = new Criteria();
	$c->addJoin(OppSedutaPeer::ID, OppVotazionePeer::SEDUTA_ID, Criteria::LEFT_JOIN);
	//$c->add(OppSedutaPeer::DATA, $data_inizio, Criteria::GREATER_EQUAL);
	$c->add(OppSedutaPeer::RAMO, $ramo, Criteria::EQUAL);
	$c->add(OppSedutaPeer::LEGISLATURA, $legislatura, Criteria::EQUAL);
	if($data_inizio!='') 
	  $c->add(OppSedutaPeer::DATA, $data_inizio, Criteria::GREATER_EQUAL);
	
	if($data_fine!='') 
	  $c->add(OppSedutaPeer::DATA, $data_fine, Criteria::LESS_EQUAL);
		
	$c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
	$result=OppSedutaPeer::doSelectOne($c);
	return $result->getData();
  }  
}
?>