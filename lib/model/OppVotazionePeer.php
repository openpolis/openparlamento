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
  public static function maggioranzaVariabileBipartizanCriteria($leg = 17, $votazione_id = 0)
  {
    $c = new Criteria();
    if ($votazione_id>0)
      $c->add(OppVotazionePeer::ID, $votazione_id);
    $votazioni = OppVotazionePeer::doSelect($c);
    foreach ($votazioni as $c)
    {
      $g_maggioranza = OppGruppoIsMaggioranzaPeer::GruppiMaggioranzaMinoranzaNelRamoAllaData($votazione->getOppSeduta()->getRamo(),$votazione->getOppSeduta()->getData(), 1);
      $g_minoranza = OppGruppoIsMaggioranzaPeer::GruppiMaggioranzaMinoranzaNelRamoAllaData($votazione->getOppSeduta()->getRamo(),$votazione->getOppSeduta()->getData(), 2);
      $magg=array();
      $min=array();
      foreach ($g_maggioranza as $m)
      {
        $magg[]=$m->getGruppoId();
      }
      foreach ($g_minoranza as $m)
      {
        $min[]=$m->getGruppoId();
      }
      
    }
    
  }
  public static function maggioranzaSalva($leg = 17, $votazione_id = 0)
  {
    $maggioranza_salva=array();
    $c = new Criteria(); 
    $c->addJoin(OppVotazionePeer::SEDUTA_ID,OppSedutaPeer::ID);
    $c->add(OppVotazionePeer::IS_MAGGIORANZA_SOTTO_SALVA, 1 , Criteria::NOT_EQUAL);
    $crit0 = $c->getNewCriterion(OppVotazionePeer::ESITO, 'Appr.');
    $crit1 = $c->getNewCriterion(OppVotazionePeer::ESITO, 'Resp.');
    $crit0->addOr($crit1);
    $c->add($crit0);
    $c->add(OppSedutaPeer::LEGISLATURA, $leg, Criteria::EQUAL);
    $c->add(OppVotazionePeer::TITOLO, '%annullata%' , Criteria::NOT_LIKE);
	// Prendi solo votazioni durante il Governo Renzi
	$c->add(OppSedutaPeer::DATA, '2014-02-22', Criteria::GREATER_EQUAL);
    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
    if ($votazione_id>0)
       $c->add(OppVotazionePeer::ID, $votazione_id);
    $votazioni_magg_su=OppVotazionePeer::doSelect($c);
    
    foreach ($votazioni_magg_su as $votazione)
    {
      //echo $votazione->getId();
      if ($votazione->getOppSeduta()->getRamo()=='C')
        $ramo='camera';
      else
        $ramo='senato';
       
      $arr_opposizione=array();
      $c= new Criteria();
      $c->addJoin(OppGruppoPeer::ID,OppGruppoRamoPeer::GRUPPO_ID);
      $c->add(OppGruppoRamoPeer::DATA_INIZIO, $votazione->getOppSeduta()->getData(), Criteria:: LESS_EQUAL);
      $crit0 = $c->getNewCriterion(OppGruppoRamoPeer::DATA_FINE, NULL, Criteria::ISNULL);
      $crit1 = $c->getNewCriterion(OppGruppoRamoPeer::DATA_FINE, $votazione->getOppSeduta()->getData(), Criteria::GREATER_EQUAL);
      $crit0->addOr($crit1);
      $c->add($crit0);
      $c->add(OppGruppoRamoPeer::RAMO, $votazione->getOppSeduta()->getRamo());
      $gruppi = OppGruppoPeer::doSelect($c);
      foreach ($gruppi as $g)
      { 
        if (!OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($g->getId(), $votazione->getOppSeduta()->getData()) && $g->getNome()!='Gruppo Misto')
        {
          $voto_gruppo=OppVotazioneHasGruppoPeer::getVotoGruppoVotazione($g->getId(), $votazione->getId());
          
          if (($votazione->getEsito()=='APPROVATA' && $voto_gruppo=='Contrario' && $ramo=='camera') ||
          ($votazione->getEsito()=='RESPINTA' && $voto_gruppo=='Favorevole' && $ramo=='camera') ||
          ($votazione->getEsito()=='APPROVATA' && ($voto_gruppo=='Contrario' || $voto_gruppo=='Astenuto') && $ramo=='senato') ||
          ($votazione->getEsito()=='RESPINTA' && $voto_gruppo=='Favorevole' && $ramo=='senato'))
          {
            //echo "\n".$votazione->getEsito()."-".$voto_gruppo."- $ramo\n";
            //echo "\n".$g->getId()."\n\n";
            $c = new Criteria();
            $c->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $g->getId());
            $c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $votazione->getOppSeduta()->getData(), Criteria:: LESS_EQUAL);
            $crit0 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, NULL, Criteria::ISNULL);
            $crit1 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, $votazione->getOppSeduta()->getData(), Criteria::GREATER_EQUAL);
            $crit0->addOr($crit1);
            $c->add($crit0);
            $parlamentari = OppCaricaHasGruppoPeer::doSelect($c);
            //$parlamentari = OppCaricaHasGruppoPeer::getParlamentariGruppoData($g->getId(),$votazione->getOppSeduta()->getData());
            foreach ($parlamentari as $p)
            {
              $arr_opposizione[]=$p->getCaricaId();
            }
          }
        }
      }  

      $c= new Criteria();
      $c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID,$votazione->getId());
      $c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$arr_opposizione, Criteria::IN);
      
      if ($votazione->getEsito()=='APPROVATA' && $votazione->getOppSeduta()->getRamo()=='C')
      {
        $crit0 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Assente');
        $crit1 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Favorevole');
        $crit2 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Astenuto');
        $crit0->addOr($crit1);
        $crit0->addOr($crit2);
        $c->add($crit0);
      }
      elseif ($votazione->getEsito()=='RESPINTA')
      {
        $crit0 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Assente');
        $crit1 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Contrario');
        $crit2 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Astenuto');
        $crit0->addOr($crit1);
        $crit0->addOr($crit2);
        $c->add($crit0);
      }
       elseif ($votazione->getEsito()=='APPROVATA' && $votazione->getOppSeduta()->getRamo()=='S')
      {
          $crit0 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Assente');
          $crit1 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Favorevole');
          $crit0->addOr($crit1);
          $c->add($crit0);
      }
      $cn=OppVotazioneHasCaricaPeer::doCount($c);
      if ($cn>=$votazione->getMargine())
      {
         //echo "!!!!!!!$cn  ".$votazione->getId()."\n";
         $maggioranza_salva[]=$votazione;
      }
    }  
    return $maggioranza_salva;
  }
  
  public static function isMaggioranzaUnitaSuVotazione($votazione_id)
  {
    $votazione=OppVotazionePeer::retrieveByPk($votazione_id);
    $gruppi=OppGruppoRamoPeer::getGruppiRamo($votazione->getOppSeduta()->getRamo(), $votazione->getOppSeduta()->getData());
    $array_gruppi=array();
    foreach ($gruppi as $gruppo)
    {
      // controlla se il gruppo alla data faceva parte della maggioranza
      if (OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($gruppo->getGruppoId(), $votazione->getOppSeduta()->getData()))
        $array_gruppi[]=$gruppo->getGruppoId();
    }  
    $voto_magg="";
    
    foreach ($array_gruppi as $k=>$g)
    {
      $c= new Criteria();
      $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $g);
      $c->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $votazione_id);
      $voto_gruppo=OppVotazioneHasGruppoPeer::doSelectOne($c);
      if ($voto_magg=="" && $voto_gruppo->getVoto()!='nv')
        $voto_magg=$voto_gruppo->getVoto();
      elseif ($voto_gruppo->getVoto()!='nv')
      {
        if ($voto_gruppo->getVoto()!=$voto_magg)
          return false;
      }  
    }
    return true;
  }  
  
  public static function maggioranzaSottoCriteria($leg = 17, $votazione_id = 0)
  {
    
    $c = new Criteria();
      
    $c->addJoin(OppVotazionePeer::ID,OppVotazioneHasGruppoPeer::VOTAZIONE_ID);
    $c->addJoin(OppVotazionePeer::SEDUTA_ID,OppSedutaPeer::ID);
    

    // Prendi il voto del Gruppo della PD GRUPPO_ID=71;
    $crit0 = $c->getNewCriterion(OppVotazioneHasGruppoPeer::GRUPPO_ID, 71);
    $crit1 = $c->getNewCriterion(OppVotazionePeer::ESITO, 'Appr.');
    $crit2 = $c->getNewCriterion(OppVotazioneHasGruppoPeer::VOTO, 'Contrario');

    $crit1->addAnd($crit2);
    $crit3 = $c->getNewCriterion(OppVotazionePeer::ESITO, 'Appr.');
    $crit4 = $c->getNewCriterion(OppVotazioneHasGruppoPeer::VOTO, 'Astenuto');
    $crit5 = $c->getNewCriterion(OppSedutaPeer::RAMO, 'S');

    $crit3->addAnd($crit4);
    $crit3->addAnd($crit5);

    $crit1->addOr($crit3);
    $crit6 = $c->getNewCriterion(OppVotazionePeer::ESITO, 'Resp.');
    $crit7 = $c->getNewCriterion(OppVotazioneHasGruppoPeer::VOTO, 'Favorevole');

    $crit6->addAnd($crit7);

    $crit1->addOr($crit6);

    $crit0->addAnd($crit1);

    $c->add($crit0);

    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
    $c->add(OppSedutaPeer::LEGISLATURA, $leg, Criteria::EQUAL);
    $c->add(OppVotazionePeer::TITOLO, '%annullata%' , Criteria::NOT_LIKE);
	// Prendi solo votazioni durante il Governo Renzi
	 $c->add(OppSedutaPeer::DATA, '2014-02-22', Criteria::GREATER_EQUAL);
    
    if ($votazione_id>0)
       $c->add(OppVotazionePeer::ID, $votazione_id);
    
    return $c;
  }
  
  public static function getVotazioniMaggioranzaSotto($leg=17)
  {
    $c = new Criteria();
    $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);
    $c->add(OppSedutaPeer::LEGISLATURA, $leg);
    $c->add(OppVotazionePeer::IS_MAGGIORANZA_SOTTO_SALVA, 1);
    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
    return $c;         
  }
  
  public static function getVotazioniMaggioranzaSalva($leg=17)
  {
    $c = new Criteria();
    $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);
    $c->add(OppSedutaPeer::LEGISLATURA, $leg);
    $c->add(OppVotazionePeer::IS_MAGGIORANZA_SOTTO_SALVA, 2);
    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
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
	$c->addJoin(OppSedutaPeer::ID, OppVotazionePeer::SEDUTA_ID);
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
