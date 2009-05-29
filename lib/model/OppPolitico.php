<?php

/**
 * Subclass for representing a row from the 'opp_politico' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppPolitico extends BaseOppPolitico
{


  public function getCaricaDepSenCorrente()
  {
    $c = new Criteria();
    $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(1, 4, 5), Criteria::IN);
    $c->add(OppCaricaPeer::DATA_FINE, null, Criteria::ISNULL);
    $c->add(OppCaricaPeer::POLITICO_ID, $this->getId());
    return OppCaricaPeer::doSelectOne($c);
  }

  /**
   * estrae l'elenco di cariche di un parlamentare, per la legislatura corrente
   * se il parlamentare è un senatore a vita, vengono estratte solo le cariche attuali (la legislatura non conta)
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function getCaricheCorrentiIds()
  {
    $c = new Criteria();
    
    $cton = $c->getNewCriterion(OppCaricaPeer::POLITICO_ID, $this->getId());
    $cton->addAnd($c->getNewCriterion(OppCaricaPeer::LEGISLATURA, sfConfig::get('app_legislatura_corrente')));
    
    $cton_vita = $c->getNewCriterion(OppCaricaPeer::POLITICO_ID, $this->getId());
    $cton_vita->addAnd($c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 5));
    $cton_vita->addAnd($c->getNewCriterion(OppCaricaPeer::DATA_FINE, null, Criteria::ISNULL));

    $cton->addOr($cton_vita); 
    $c->add($cton);  


    $c->clearSelectColumns(); 
    $c->addSelectColumn(OppCaricaPeer::ID);
    $rs = OppCaricaPeer::doSelectRS($c);

    $cariche = array();
    while ($rs->next())
      $cariche []= $rs->getInt(1);

    return $cariche;
  }
  
  public function getGruppoCorrente()
  {
    $c = new Criteria();
    $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(1, 4, 5), Criteria::IN);
    $c->add(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);
   // dava errore per i senatori a vita 
   // $c->add(OppCaricaPeer::LEGISLATURA, 16);
    $c->add(OppCaricaPeer::POLITICO_ID, $this->getId());
    $c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID);
    $c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);
    return OppGruppoPeer::doSelectOne($c);
  }
  
  public function countAllMonitoringUsers()
  {
    return count($this->getAllMonitoringUsersPKs());
  }
  
  public function getAllMonitoringUsersPKs()
  {
    return $this->getMonitoringUsersPKs();
  }
  
  
  /**
   * string representation for Politician
   *
   * @return String
   * @author Guglielmo Celata
   **/
  public function __toString()
  {
    return $this->getNome() . " " . strtoupper($this->getCognome());
  }
  
  
  public function getVoti($page=1)
  {
    $voti = array();

    $c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppVotazionePeer::ID);
  	$c->addSelectColumn(OppSedutaPeer::RAMO);
  	$c->addSelectColumn(OppSedutaPeer::LEGISLATURA);
  	$c->addSelectColumn(OppSedutaPeer::DATA);
  	$c->addSelectColumn(OppVotazionePeer::TITOLO);
  	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->addSelectColumn(OppVotazionePeer::ESITO);
  	$c->addSelectColumn(OppGruppoPeer::NOME);
  	$c->addSelectColumn(OppVotazioneHasGruppoPeer::VOTO);
		
  	$c->addJoin(OppCaricaPeer::ID, OppVotazioneHasCaricaPeer::CARICA_ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, OppVotazionePeer::ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID, Criteria::INNER_JOIN);
	
  	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::INNER_JOIN);
	
  	$c->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, OppVotazioneHasGruppoPeer::VOTAZIONE_ID, Criteria::INNER_JOIN);
	
  	$c->add(OppCaricaPeer::POLITICO_ID, $this->getId(), Criteria::EQUAL);
	
  	$c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, OppSedutaPeer::DATA, Criteria::LESS_EQUAL);
	
  	$cton1 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, OppSedutaPeer::DATA, Criteria::GREATER_EQUAL);
  	$cton2 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);
  	$cton1->addOr($cton2);
    $c->add($cton1);
	
	  $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, OppVotazioneHasGruppoPeer::GRUPPO_ID.'='.OppGruppoPeer::ID, Criteria::CUSTOM);
	
	  $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
	
  	if($page!=1)
  	  $c->setOffset(sfConfig::get('app_pagination_limit')*$page);  
	
  	$c->setLimit(sfConfig::get('app_pagination_limit'));
	
    $rs = OppVotazioneHasCaricaPeer::doSelectRS($c);
	 	
	  while ($rs->next())
    {
		  
	  //$voto_gruppo = OppVotazionePeer::doSelectVotoGruppo($rs->getInt(1), $rs->getString(8));
	  	  
	    $voti[$rs->getInt(1)] = array('ramo' => ($rs->getString(2)=='C' ? 'Camera' : 'Senato'), 
	                                  'legislatura' => $rs->getString(3), 
									                  'data' => $rs->getDate(4, 'Y-m-d'), 
	                                  'titolo' => str_replace(';NULL', '', $rs->getString(5)),
	                                  'voto' => $rs->getString(6), 'voto_gruppo' => $rs->getString(9), 
									                  'esito' => Text::decodeEsito($rs->getString(7)) );
									
		   
	  }
		
	  return $voti;
  }
  
  public function getVotiCount()
  {
    $c = new Criteria();
	$c->addJoin(OppPoliticoPeer::ID, OppCaricaPeer::POLITICO_ID, Criteria::INNER_JOIN);
	$c->addJoin(OppCaricaPeer::ID, OppVotazioneHasCaricaPeer::CARICA_ID, Criteria::INNER_JOIN);
	$c->Add(OppPoliticoPeer::ID, $this->getId());
	return OppVotazioneHasCaricaPeer::doCount($c);
  }
  
  public function getRibelleReport($carica_id, $ramo, $gruppo, $data_inizio, $data_fine)
  {
    $esiti_gruppo = array();
  	$count = 0;
	
  	//determinazione voto esito gruppo nel periodo considerato
    $c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppVotazionePeer::ID);
  	$c->addSelectColumn(OppSedutaPeer::DATA);
  	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->addAsColumn('CONT', 'COUNT(*)');
  	$c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppVotazionePeer::ID, OppVotazioneHasCaricaPeer::VOTAZIONE_ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::INNER_JOIN);
  	$c->add(OppSedutaPeer::RAMO, $ramo, Criteria::EQUAL);
  	$c->add(OppSedutaPeer::DATA, $data_inizio, Criteria::GREATER_EQUAL);
	
  	if($data_fine!='') 
  	  $c->add(OppSedutaPeer::DATA, $data_fine, Criteria::LESS_EQUAL);
	
  	$c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $data_inizio, Criteria::GREATER_EQUAL);
	
  	if($data_fine!='') 
  	  $c->add(OppCaricaHasGruppoPeer::DATA_FINE, $data_fine, Criteria::LESS_EQUAL);
	
  	$c->add(OppGruppoPeer::NOME, $gruppo, Criteria::EQUAL);
  	$c->addGroupByColumn(OppVotazionePeer::ID);
  	$c->addGroupByColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->addAscendingOrderByColumn(OppVotazionePeer::ID);
  	$c->addDescendingOrderByColumn('CONT');
	
  	$rs = OppVotazionePeer::doSelectRS($c);
	
  	while ($rs->next())
      {
  	  if(!isset($esiti_gruppo[$rs->getInt(1)]))
  	    $esiti_gruppo[$rs->getInt(1)] = $rs->getString(3);
  	}
	
  	$c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppVotazionePeer::ID);
  	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
	
  	$c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppVotazionePeer::ID, OppVotazioneHasCaricaPeer::VOTAZIONE_ID, Criteria::INNER_JOIN);
  	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::INNER_JOIN);
	
  	$c->add(OppSedutaPeer::RAMO, $ramo, Criteria::EQUAL);
  	$c->add(OppVotazioneHasCaricaPeer::CARICA_ID, $carica_id, Criteria::EQUAL);
  	$c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $data_inizio, Criteria::GREATER_EQUAL);
  	$c->add(OppSedutaPeer::DATA, $data_inizio, Criteria::GREATER_EQUAL);
  	if($data_fine!='') 
  	  $c->add(OppSedutaPeer::DATA, $data_fine, Criteria::LESS_EQUAL);
	
  	if($data_fine!='') 
  	  $c->add(OppCaricaHasGruppoPeer::DATA_FINE, $data_fine, Criteria::LESS_EQUAL);
	
  	$c->addAscendingOrderByColumn(OppVotazionePeer::ID);
	
  	$rs1 = OppVotazionePeer::doSelectRS($c);

    while ($rs1->next())
    {
	  if ($rs1->getString(2)=='Astenuto' || $rs1->getString(2)=='Contrario' || $rs1->getString(2)=='Favorevole')
      
      {
        if($esiti_gruppo[$rs1->getInt(1)]!='' && $rs1->getString(2)!=$esiti_gruppo[$rs1->getInt(1)])
          $count++;
      }
    }
	
    return $count;    
  }
  
  /**
   * delete all news related to this object before deleting the object
   *
   * @param string $con 
   * @return void
   * @author Guglielmo Celata
   */
  public function delete($con=null)
  {
    try
    {
      $c = new Criteria();
      $c->add(NewsPeer::RELATED_MONITORABLE_MODEL, 'OppPolitico');
      $c->add(NewsPeer::RELATED_MONITORABLE_ID, $this->getPrimaryKey());
      NewsPeer::doDelete($c);          
    }
    catch (Exception $e)
    {
      throw new deppPropelActAsNewsGeneratorException(
        'Unable to delete related monitorable object records');
    }
    
    parent::delete($con);
  }

  /* --------- funzioni per indicizzazione sfLucene ---------- */
  
  public function getPolId()
  {
    return $this->getId();
  }

  public function getNominativo()
  {
    return $this->__toString();
  }
  
  /**
   * torna l'oggetto Apache_Solr_Document da indicizzare
   *
   * @return Apache_Solr_Document
   * @author Guglielmo Celata
   */
  public function intoSolrDocument()
  {
    $document = new Apache_Solr_Document();
    
    $id = $this->getId();
    $document->id = md5('OppPolitico' . $id);
    $document->sfl_model = 'OppPolitico';
    $document->sfl_type = 'model';

    $document->propel_id = $id;
    $document->nominativo = $this->getNome() . " " . $this->getCognome();            

    // ritorna il documento da aggiungere
    return $document;
  }
    
}

// add the ActAsMonitorable behavior
// the field OppUserPeer::N_MONITORED_POLITICOS 
// holds the number of objects of this type monitored
sfPropelBehavior::add(
  'OppPolitico', 
  array('deppPropelActAsMonitorableBehavior' =>
        array('count_monitoring_users_field'  => 'NMonitoringUsers',    // refers to OppPoliticoPeer::N_MONITORING_USERS
              'monitorer_model'               => 'OppUser',             // user profile model (to set the cache)
              'count_monitored_objects_field' => 'NMonitoredPoliticos', // refers to OppUserPeer::N_MONITORED_ATTOS
       )));

sfSolrPropelBehavior::getInitializer()->setupModel('OppPolitico');