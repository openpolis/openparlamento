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
}