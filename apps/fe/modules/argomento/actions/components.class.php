<?php

class argomentoComponents extends sfComponents
{
  public function executeElencoDdl()
  {
    $this->atti = OppTeseoPeer::doSelectAtto($this->teseo_id);
  }
  
  /**
   * torna il numero di interventi sugli atti con un certo tag 
   * tutti gli atti degli argomenti
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function executeQuantodiscusso()
  {
    $interventi_max = sfSupra::getVariable('numero_interventi_max');

    $c = new Criteria();
    $c->addJoin(OppInterventoPeer::ATTO_ID, OppAttoPeer::ID);
    $c->addJoin(TaggingPeer::TAGGABLE_ID, OppAttoPeer::ID);
    $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
    $c->add(TaggingPeer::TAG_ID, $this->tag->getId());
    $this->interventi = OppInterventoPeer::doCount($c);
    $this->interventi_perc = 100 * $this->interventi / $interventi_max;

    $this->interventi_avg = sfSupra::getVariable('numero_interventi_avg');
    $this->interventi_avg_perc = 100 * $this->interventi_avg / $interventi_max;
  
  }
  
  
  public function executeDeputatisioccupanodi()
  {
   $options = array('limit' => 10, 'sort_by_relevance' => true);
   //$options = array('sort_by_relevance' => true);
     
      
      
    // estrazione cariche, tipo firma, tipo atto
    $c = new Criteria();
    $c->addJoin(OppCaricaPeer::ID, OppCaricaHasAttoPeer::CARICA_ID);
    $c->addJoin(OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID);
    $c->addJoin(TaggingPeer::TAGGABLE_ID, OppAttoPeer::ID);
    $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
    $c->add(OppCaricaPeer::DATA_FINE, NULL);
    $c->add(TaggingPeer::TAG_ID, $this->tag->getId());
    $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
    $c->clearSelectColumns();
    $c->addSelectColumn(OppCaricaPeer::ID);
    $c->addSelectColumn(OppCaricaHasAttoPeer::TIPO);
    $c->addSelectColumn(OppAttoPeer::TIPO_ATTO_ID);

    // costruzione array associativo dei politici
    $politici = array();
    $rs = OppCaricaPeer::doSelectRS($c);
    while ($rs->next())
    {
      $carica_id = $rs->getInt(1);
      $tipo = $rs->getString(2);
      $tipo_atto_id = $rs->getInt(3);

      if (!array_key_exists($carica_id, $politici))
        $politici[$carica_id] = 0;

      $politici[$carica_id] += OppCaricaHasAttoPeer::get_fattore_firma($tipo) *
                                 OppAttoPeer::get_fattore_tipo_atto($tipo_atto_id);
    }

    // ordinamento per rilevanza, prima dello slice
    arsort($politici);

    // slice dell'array, se specificata l'opzione limit
    $this->n_remaining_politici = 0;
    if (isset($options['limit']) && count($politici) > $options['limit'])
    {
      $this->n_remaining_politici = count($politici) - $options['limit'];
      $politici = array_slice($politici, 0, $options['limit'], true);
    }

    // ordinamento per triple_value, in caso sort_by_relevance non sia specificato
    if (!isset($options['sort_by_relevance']) || (true !== $options['sort_by_relevance']))
    {
      krsort($politici);
    }

    $this->politici = $politici;
  }
  
   public function executeSenatorisioccupanodi()
  {
   $options = array('limit' => 10, 'sort_by_relevance' => true);
   //$options = array('sort_by_relevance' => true);
    
    // estrazione cariche, tipo firma, tipo atto
    $c = new Criteria();
    $c->addJoin(OppCaricaPeer::ID, OppCaricaHasAttoPeer::CARICA_ID);
    $c->addJoin(OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID);
    $c->addJoin(TaggingPeer::TAGGABLE_ID, OppAttoPeer::ID);
    $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(4,5), Criteria::IN);
    $c->add(OppCaricaPeer::DATA_FINE, NULL);
    $c->add(TaggingPeer::TAG_ID, $this->tag->getId());
    $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
    $c->clearSelectColumns();
    $c->addSelectColumn(OppCaricaPeer::ID);
    $c->addSelectColumn(OppCaricaHasAttoPeer::TIPO);
    $c->addSelectColumn(OppAttoPeer::TIPO_ATTO_ID);

    // costruzione array associativo dei politici
    $politici = array();
    $rs = OppCaricaPeer::doSelectRS($c);
    while ($rs->next())
    {
      $carica_id = $rs->getInt(1);
      $tipo = $rs->getString(2);
      $tipo_atto_id = $rs->getInt(3);

      if (!array_key_exists($carica_id, $politici))
        $politici[$carica_id] = 0;

      $politici[$carica_id] += OppCaricaHasAttoPeer::get_fattore_firma($tipo) *
                                 OppAttoPeer::get_fattore_tipo_atto($tipo_atto_id);
    }

    // ordinamento per rilevanza, prima dello slice
    arsort($politici);

    // slice dell'array, se specificata l'opzione limit
    $this->n_remaining_politici = 0;
    if (isset($options['limit']) && count($politici) > $options['limit'])
    {
      $this->n_remaining_politici = count($politici) - $options['limit'];
      $politici = array_slice($politici, 0, $options['limit'], true);
    }

    // ordinamento per triple_value, in caso sort_by_relevance non sia specificato
    if (!isset($options['sort_by_relevance']) || (true !== $options['sort_by_relevance']))
    {
      krsort($politici);
    }

    $this->politici = $politici;
  }
  
  public function executeArgomenticorrelati()
  {
    $this->related_tags = TagPeer::getRelatedTags($this->tag->getName(), array('limit' => 20));
  }
  
  
  public function executeAttiTaggati()
  {

    /* select raw 
      select ta.descrizione, ta.id, count(tg.id) 
       from sf_tag t, sf_tagging tg, opp_atto a, opp_tipo_atto ta 
       where t.triple_value='ARTIGIANATO' 
             and tg.tag_id=t.id 
             and tg.taggable_model='OppAtto' 
             and tg.taggable_id=a.id 
             and ta.id=a.tipo_atto_id 
       group by ta.id 
       order by ta.id;
    */
    $connection = Propel::getConnection();
    $rami=array('C','S');
     $atti = array(); 
    foreach ($rami as $ramo) {
    
    $query = "SELECT %s AS tipo, %s AS tipo_id, count(%s) AS cnt " .
             "FROM %s, %s, %s, %s " . 
             "WHERE %s='%s' and %s=%s and %s='%s' and %s=%s and %s=%s and %s='%s' " . 
             "GROUP BY %s " . 
             "ORDER BY %s";

    $query = sprintf($query, OppTipoAttoPeer::DESCRIZIONE, OppTipoAttoPeer::ID, TaggingPeer::ID,                              
                             TagPeer::TABLE_NAME, TaggingPeer::TABLE_NAME, 
                             OppAttoPeer::TABLE_NAME, OppTipoAttoPeer::TABLE_NAME,
                             TagPeer::TRIPLE_VALUE, addslashes($this->triple_value),
                             TaggingPeer::TAG_ID, TagPeer::ID, 
                             TaggingPeer::TAGGABLE_MODEL, 'OppAtto',
                             TaggingPeer::TAGGABLE_ID, OppAttoPeer::ID,
                             OppAttoPeer::TIPO_ATTO_ID, OppTipoAttoPeer::ID,
                             OppAttoPeer::RAMO, $ramo,
                             OppTipoAttoPeer::ID, 
                             OppTipoAttoPeer::ID); 
    
    
    
    $statement = $connection->prepareStatement($query);
    $rs = $statement->executeQuery();
   
    while ($rs->next())
    {
      $tipo = $rs->getString('tipo');
      $tipo_id = $rs->getString('tipo_id');
      $cnt = $rs->getInt('cnt');
      if ($ramo=='C') 
          $atti[$tipo] = array('id' => $tipo_id, 'nc' => $cnt);
      else
          $atti[$tipo]['ns']=$cnt;    
          
      if (in_array($tipo_id, array('1', '12', '15', '16', '17')))
        $atti[$tipo]['routing'] = 'leggi';
      else
        $atti[$tipo]['routing'] = 'nonleg';
        
      if ($atti[$tipo]['routing'] == 'leggi')
      {
        switch ($tipo_id)
        {
          case 1:
            $atti[$tipo]['type_filter'] = 'DDL';
            break;
          case 12:
            $atti[$tipo]['type_filter'] = 'DL';
            break;
          case 15:
          case 16:
          case 17:
            $atti[$tipo]['type_filter'] = 'DLEG';
            break;
        }
      } else 
        $atti[$tipo]['type_filter'] = $tipo_id;
    }
    
   
  }
  
   $this->atti_taggati = $atti;
  }

}

?>	