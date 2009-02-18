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
  
    public function executeNumeroAtti()
  {
    $C_atti=array();
    $S_atti=array();
   for ($y=1;$y<=2;$y++) { 
    if ($y==1) $ramo='C';
    else $ramo='S'; 
   
    for ($x=1;$x<18;$x++) {	
	    $c = new Criteria();
	    $c->addJoin(TaggingPeer::TAGGABLE_ID, OppAttoPeer::ID);
	    $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
	    $c->add(TaggingPeer::TAG_ID, $this->tag->getId());
	    $c->add(OppAttoPeer::TIPO_ATTO_ID, $x);
	    $c->add(OppAttoPeer::RAMO, $ramo);
	    $atti = TaggingPeer::doCount($c);
	    if ($ramo=='C')  array_push($C_atti,$atti);
	    else  array_push($S_atti,$atti);
	   
     }	  
   }  
     $this->C_atti=$C_atti;  
     $this->S_atti=$S_atti;
     $arr_tipologia=array("disegno di legge","mozione","interpellanza","interrogazione a risposta orale","interrogazione a risposta scritta","interrogazione in commissione","risoluzione in assemblea","risoluzione in commissione","risoluzione conclusiva","ordine del giorno in assemblea         ","ordine del giorno in commissione","decreto legge","comunicato del governo","audizione","decreto legislativo attuativo di legge delega","decreto legislativo attuativo di direttive comunitarie","decreto legislativo attuativo di statuti speciali");
     $this->arr_tipologia=$arr_tipologia;
  }
  
  public function executeDeputatisioccupanodi()
  {
    $options = array('limit' => 10, 'sort_by_relevance' => true);

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

}

?>	