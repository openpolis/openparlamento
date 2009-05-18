<?php
class parlamentareComponents extends sfComponents
{

  public function executeMonitoringalso()
  {
    $this->monitorers_pks = $this->item->getAllMonitoringUsersPKs();
    $this->monitored_models_pks = MonitoringPeer::getModelsPKsMonitoredByUsers($this->monitorers_pks);
  }
    
  public function executeSioccupadi()
  {
    $options = array('limit' => 20, 'sort_by_relevance' => true);
    
    // estrazione tag, tipo firma, tipo atto
    // questo dovrebbe andare in TagPeer, ma romperebbe la neutralità del plugin
    $c = new Criteria();
    $c->addJoin(OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID);
    $c->addJoin(TaggingPeer::TAGGABLE_ID, OppAttoPeer::ID);
    $c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
    $c->add(OppCaricaHasAttoPeer::CARICA_ID, $this->carica->getId());
    $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
    $c->clearSelectColumns();
    $c->addSelectColumn(TagPeer::TRIPLE_VALUE);
    $c->addSelectColumn(OppCaricaHasAttoPeer::TIPO);
    $c->addSelectColumn(OppAttoPeer::TIPO_ATTO_ID);

    // costruzione array associativo dei tag
    $tags = array();
    $rs = TagPeer::doSelectRS($c);
    while ($rs->next())
    {
      $value = $rs->getString(1);
      $tipo = $rs->getString(2);
      $tipo_atto_id = $rs->getInt(3);
      
      if (!array_key_exists($value, $tags))
        $tags[$value] = 0;
      
      $tags[$value] += OppCaricaHasAttoPeer::get_fattore_firma($tipo) * OppAttoPeer::get_fattore_tipo_atto($tipo_atto_id);
    }
    
    // ordinamento per rilevanza, prima dello slice
    arsort($tags);

    // slice dell'array, se specificata l'opzione limit
    if (isset($options['limit']) && count($tags) > $options['limit'])
    {
      $this->n_remaining_tags = count($tags) - $options['limit'];
      $tags = array_slice($tags, 0, $options['limit'], true);
    }
    
    // ordinamento per triple_value, in caso sort_by_relevance non sia specificato
    if (!isset($options['sort_by_relevance']) || (true !== $options['sort_by_relevance']))
    {
      krsort($tags);
    }
    
    $this->tags = $tags;
  }
  
  
  public function executeVotacome()
  {
    try
    {
      $this->nearest = $this->carica->getNearestVoters('voting', $this->acronimo);      
    } catch (Exception $e) {
      sfLogger::getInstance()->error($e->getMessage());
    }
  }
  
  public function executeFirmacon()
  {
    try
    {
      $this->nearest = $this->carica->getNearestVoters('signing', $this->acronimo);      
    } catch (Exception $e) {
      sfLogger::getInstance()->error($e->getMessage());
    }
  }
  
  /**
   * estrae tutti gli atti presentati dal parlamentare nel corso della legislatura
   * sono considerate tutte le cariche ricoperte
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function executeAttiPresentati()
  {
  
    $cariche_ids = $this->parlamentare->getCaricheCorrentiIds();
    if (count($cariche_ids) == 0)
    {
      $this->atti_presentati = array();
      return;
    }
    
    $cariche_ids_as_string = join($cariche_ids, ",");

    /* select raw 
    select ta.descrizione, ca.tipo, count(ta.id) 
     from opp_carica_has_atto ca, opp_atto a, opp_tipo_atto ta 
     where ca.atto_id=a.id and a.tipo_atto_id=ta.id and carica_id=$carica->getId() 
     group by ta.id, ca.tipo
     order by ta.id;
    */
    $connection = Propel::getConnection();
    $query = "SELECT %s AS tipo, %s AS tipo_id, %s AS firma, count(%s) AS cnt " .
             "FROM %s, %s, %s " . 
             "WHERE %s=%s and %s=%s and %s in ($cariche_ids_as_string)" . 
             "GROUP BY %s, %s " . 
             "ORDER BY %s";

    $query = sprintf($query, OppTipoAttoPeer::DESCRIZIONE, OppTipoAttoPeer::ID, 
                             OppCaricaHasAttoPeer::TIPO, OppTipoAttoPeer::ID,
                             OppCaricaHasAttoPeer::TABLE_NAME, OppAttoPeer::TABLE_NAME, OppTipoAttoPeer::TABLE_NAME,
                             OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID, 
                             OppAttoPeer::TIPO_ATTO_ID, OppTipoAttoPeer::ID,
                             OppCaricaHasAttoPeer::CARICA_ID,
                             OppTipoAttoPeer::ID, OppCaricaHasAttoPeer::TIPO, 
                             OppTipoAttoPeer::ID);
    
    
    
    $statement = $connection->prepareStatement($query);
    $rs = $statement->executeQuery();
    $atti = array();
    while ($rs->next())
    {
      $tipo = $rs->getString('tipo');
      $tipo_id = $rs->getString('tipo_id');
      if (!array_key_exists($tipo, $atti))
      {
        $atti[$tipo] = array('id' => $tipo_id, 'C' => 0, 'P' => 0,'R' => 0);
      }
      $firma = $rs->getString('firma');
      $cnt = $rs->getInt('cnt');
      $atti[$tipo][$firma] = $cnt;
    }
    
    $this->atti_presentati = $atti;
    
  }
  
     public function executeVotiComparati()
  {
    
       $perc=$this->compare*100/$this->numero_voti;
       $this->perc=round($perc,1);
       $x=100/max($this->parlamentare1->getPresenze(),$this->parlamentare2->getPresenze());
       
       $this->gchartVoti="http://chart.apis.google.com/chart?cht=v&chd=t:100,100,0,".$perc."&chs=250x100&chdl=".$this->parlamentare1->getOppPolitico()->getCognome()."|".$this->parlamentare2->getOppPolitico()->getCognome();   
       
         
         
       
  }
  
  public function executeTendinaParlamentari()
    {  
        if ($this->ramo==1) $this->tipo_carica=1;
        else $this->tipo_carica=4;
        
        $c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppPoliticoPeer::ID);
	$c->addSelectColumn(OppPoliticoPeer::COGNOME);
	$c->addSelectColumn(OppPoliticoPeer::NOME);   
        $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);
        $c->add(OppCaricaPeer::LEGISLATURA, '16', Criteria::EQUAL);
        $c->add(OppCaricaPeer::TIPO_CARICA_ID, $this->tipo_carica, Criteria::EQUAL);
        $c->add(OppCaricaPeer::DATA_FINE, null, Criteria::EQUAL); 
        $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
        $this->parlamentari = OppCaricaPeer::doSelectRS($c);
        
    }
      
 public function executeChooseParlamentari()
  {
    $parlamentare1 = $this->getRequestParameter('parlamentare1');
    $parlamentare2 = $this->getRequestParameter('parlamentare2');
    $this->redirect('votazione/list');
  }
}