<?php

/**
 * votazione actions.
 *
 * @package    openparlamento
 * @subpackage votazione
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class votazioneActions extends sfActions
{

  public function preExecute()
  {
    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'module', 'module', 
                                                  array('acts_filter', 'sf_admin/opp_atto/sort',
                                                        'pol_camera_filter', 'pol_senato_filter', 'sf_admin/opp_carica/sort',
                                                        'argomento/atti_filter', 'argomento_leggi/sort', 'argomento_nonleg/sort',
                                                        'monitoring_filter'));
  }
  
  public function executeCommenti()
  {
    $this->votazione = OppVotazionePeer::retrieveByPK($this->getRequestParameter('id'));
    $this->ramo = $this->votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato' ; 
  }

  
  
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $votazione_id = $this->getRequestParameter('id');

    $this->votazione = OppVotazionePeer::retrieveByPK($votazione_id);
    $this->forward404Unless($this->votazione);  

    $this->ramo = $this->votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato' ; 
    $data = $this->votazione->getOppSeduta()->getData('Y-m-d');

    $this->risultati = $this->votazione->getVotoGruppi($data);
    $this->ribelli = $this->votazione->getVotoRibelli($data);
    
    $this->getResponse()->setTitle('Votazione '.$this->ramo.' '. $this->votazione->getTitolo().' - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','Come hanno votato i gruppi, che voto hanno espresso i singoli parlamentari e quali sono stati ribelli al proprio gruppo parlamentare per la votazione '.$this->ramo.' '. $this->votazione->getTitolo(),true);
    $this->processSort();

  	$this->votanti = OppVotazioneHasCaricaPeer::getRSAllVotanti($votazione_id, $data);
  	$this->votantiComponent = OppVotazioneHasCaricaPeer::getRSAllVotanti($votazione_id, $data);
	
    $c = new Criteria();
    $c->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $votazione_id);
    $this->voto_gruppi = OppVotazioneHasGruppoPeer::doSelect($c);
     
    $c = new Criteria();
    $c->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $votazione_id);
    $this->voto_atti = OppVotazioneHasAttoPeer::doSelect($c);
     
    $c = new Criteria();
    $c->add(OppVotazioneHasEmendamentoPeer::VOTAZIONE_ID, $votazione_id);
    $this->voto_ems = OppVotazioneHasEmendamentoPeer::doSelect($c);
  }



  /**
   * check request parameters and set session values for the filters
   * reads filters from session, so that a clean url builds up with user's values
   *
   * @param  array $active_filters an array of all the active filters
   * @return void
   * @author Guglielmo Celata
   */
  protected function processFilters($active_filters)
  {

    $this->filters = array();

    // legge i filtri dalla request e li scrive nella sessione utente
    if ($this->hasRequestParameter('filter_tags_category'))
      $this->session->setAttribute('tags_category', $this->getRequestParameter('filter_tags_category'), 'votes_filter');

    if ($this->hasRequestParameter('filter_ramo'))
      $this->session->setAttribute('ramo', $this->getRequestParameter('filter_ramo'), 'votes_filter');

    if ($this->hasRequestParameter('filter_esito'))
      $this->session->setAttribute('esito', $this->getRequestParameter('filter_esito'), 'votes_filter');

    if ($this->hasRequestParameter('filter_type'))
      $this->session->setAttribute('type', $this->getRequestParameter('filter_type'), 'votes_filter');


    // legge sempre i filtri dalla sessione utente (quelli attivi)
    if (in_array('tags_category', $active_filters))
      $this->filters['tags_category'] = $this->session->getAttribute('tags_category', '0', 'votes_filter');

    if (in_array('ramo', $active_filters))
      $this->filters['ramo'] = $this->session->getAttribute('ramo', '0', 'votes_filter');

    if (in_array('esito', $active_filters))
      $this->filters['esito'] = $this->session->getAttribute('esito', '0', 'votes_filter');    

    if (in_array('type', $active_filters))
      $this->filters['type'] = $this->session->getAttribute('type', '0', 'votes_filter');    

  }

  /**
   * add filtering criteria to the criteria passed as an argument
   * being an object, the criteria is passed by reference and modifications
   * in the method modifies the referenced object
   *
   * @param Criteria $c 
   * @return void
   * @author Guglielmo Celata
   */
  protected function addFiltersCriteria($c)
  {
    // filtro per ramo
    if (array_key_exists('ramo', $this->filters) && $this->filters['ramo'] != '0')
    {      
      $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);
      $c->add(OppSedutaPeer::RAMO, $this->filters['ramo']);
    }
    
    // filtro per stato di avanzamento
    if (array_key_exists('esito', $this->filters) && $this->filters['esito'] != '0')
      $c->add(OppVotazionePeer::ESITO, $this->filters['esito']);      

    // filtro per tipo di decreto legislativo
    if (array_key_exists('type', $this->filters) && $this->filters['type'] != '0')
      $c->add(OppVotazionePeer::FINALE, $this->filters['type']);
    
    // filtro per categoria
    if (array_key_exists('tags_category', $this->filters) && $this->filters['tags_category'] != '0')
    {
      $c->addJoin(OppVotazionePeer::ID, OppVotazioneHasAttoPeer::VOTAZIONE_ID);
      $c->addJoin(OppVotazioneHasAttoPeer::ATTO_ID, OppAttoPeer::ID);
      $c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
      $c->addJoin(TagPeer::ID, OppTagHasTtPeer::TAG_ID);
      $c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
      $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
      $c->add(OppTagHasTtPeer::TESEOTT_ID, $this->filters['tags_category']);
      $c->setDistinct();
    }    

    
  }


  protected function processSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), 'opp_votazione/sort');
      $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'opp_votazione/sort');
    }
  }
  
  protected function addSortCriteria (&$c)
  {
    if ($sort_column = $this->getUser()->getAttribute('sort', NULL, 'opp_votazione/sort'))
    {
      switch($this->getUser()->getAttribute('sort', NULL, 'opp_votazione/sort'))
      {
        case 'parlamentare':
          $sort_column = OppPoliticoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
          break;
        case 'gruppo':
          $sort_column = 'nome';
          $sort_column = OppGruppoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
          break;
        case 'circoscrizione':
          $sort_column = OppCaricaPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
          break;
        case 'voto':
          $sort_column = OppVotazioneHasCaricaPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
          break;
      }

      if ($this->getUser()->getAttribute('type', NULL, 'opp_votazione/sort') == 'asc')
        $c->addAscendingOrderByColumn($sort_column);
      else
        $c->addDescendingOrderByColumn($sort_column);
      		  
    }
  }

  protected function processListSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/opp_votazione/sort');
      $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/opp_votazione/sort');
    }

    if (!$this->getUser()->getAttribute('sort', null, 'sf_admin/opp_votazione/sort'))
    {
	  $this->getUser()->setAttribute('sort', 'data', 'sf_admin/opp_votazione/sort');
      $this->getUser()->setAttribute('type', 'asc', 'sf_admin/opp_votazione/sort');
    }
  }
  
  protected function addListSortCriteria($c)
  {
    if ($sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/opp_votazione/sort'))
    {
      if($sort_column!='data' && $sort_column!='ramo')
	    $sort_column = OppVotazionePeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      
	  if ($this->getUser()->getAttribute('type', null, 'sf_admin/opp_votazione/sort') == 'asc')
      {
        if($sort_column=='data')
		  $c->addAscendingOrderByColumn(OppSedutaPeer::DATA);
        else    
		  $c->addAscendingOrderByColumn($sort_column);
      }
      else
      {
	    if($sort_column=='data')
		  $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
        else    
		  $c->addDescendingOrderByColumn($sort_column);
      }
    }
  }

 public function executeParlamentariSotto()
 {
   $ramo = $this->getRequestParameter('ramo');
   $this->ramo=$ramo;
   
   $this->getResponse()->setTitle('la classifica dei '.($ramo=='camera'?'deputati':'senatori').' che mandano sotto la maggioranza - '.sfConfig::get('app_main_title'));
   $this->response->addMeta('description','La lista e il dettaglio dei '.($ramo=='camera'?'deputati':'senatori').' che con i loro voti e con le assenze mandano sotto la maggioranza nelle votazione elettroniche',true);
   
   $c = new Criteria();
   $c->clearSelectColumns();
   $c->addSelectColumn(OppCaricaPeer::ID);
   $c->addSelectColumn(OppPoliticoPeer::ID);
   $c->addSelectColumn(OppPoliticoPeer::COGNOME);
   $c->addSelectColumn(OppPoliticoPeer::NOME);
   $c->addSelectColumn(OppCaricaPeer::MAGGIORANZA_SOTTO);
   $c->addSelectColumn(OppCaricaPeer::TIPO_CARICA_ID);
   $c->addSelectColumn(OppCaricaPeer::MAGGIORANZA_SOTTO_ASSENTE);
   $c->addAsColumn("CONT", "CONCAT(".OppCaricaPeer::MAGGIORANZA_SOTTO." - ".OppCaricaPeer::MAGGIORANZA_SOTTO_ASSENTE.")");
   $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
   $c->addSelectColumn(OppCaricaPeer::DATA_FINE);
   
   $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);
   $c->add(OppCaricaPeer::LEGISLATURA, '17', Criteria::EQUAL);
   //$c->add(OppCaricaPeer::DATA_FINE, NULL, Criteria::ISNULL);
   if ($this->getRequestParameter('ramo')=='camera')
     $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
   elseif ($this->getRequestParameter('ramo')=='senato')
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, 4);   
  // $c->addDescendingOrderByColumn('CAST(CONT AS UNSIGNED )');   
  
   $c->addDescendingOrderByColumn(OppCaricaPeer::MAGGIORANZA_SOTTO);
   $this->parlamentari = OppCaricaPeer::doSelectRS($c);
   
 }
 
 public function executeParlamentariSalva()
 {
   $ramo = $this->getRequestParameter('ramo');
   $this->ramo=$ramo;
   
   $this->getResponse()->setTitle('la classifica dei '.($ramo=='camera'?'deputati':'senatori').' di opposizione che hanno salvato la maggioranza nelle votazioni - '.sfConfig::get('app_main_title'));
   $this->response->addMeta('description','La lista e il dettaglio dei '.($ramo=='camera'?'deputati':'senatori').' di opposizione che con i loro voti e con le assenze hanno salvato la maggioranza nelle votazione elettroniche',true);
   
   $c = new Criteria();
   $c->clearSelectColumns();
   $c->addSelectColumn(OppCaricaPeer::ID);
   $c->addSelectColumn(OppPoliticoPeer::ID);
   $c->addSelectColumn(OppPoliticoPeer::COGNOME);
   $c->addSelectColumn(OppPoliticoPeer::NOME);
   $c->addSelectColumn(OppCaricaPeer::MAGGIORANZA_SALVA);
   $c->addSelectColumn(OppCaricaPeer::TIPO_CARICA_ID);
   $c->addSelectColumn(OppCaricaPeer::MAGGIORANZA_SALVA_ASSENTE);
   $c->addAsColumn("CONT", "CONCAT(".OppCaricaPeer::MAGGIORANZA_SALVA." - ".OppCaricaPeer::MAGGIORANZA_SALVA_ASSENTE.")");
   $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
   $c->addSelectColumn(OppCaricaPeer::DATA_FINE);
   
   $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);
   $c->add(OppCaricaPeer::LEGISLATURA, '17', Criteria::EQUAL);
   //$c->add(OppCaricaPeer::DATA_FINE, NULL, Criteria::ISNULL);
   if ($this->getRequestParameter('ramo')=='camera')
     $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
   elseif ($this->getRequestParameter('ramo')=='senato')
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, 4);   
   $c->addDescendingOrderByColumn(OppCaricaPeer::MAGGIORANZA_SALVA);
   //$c->addDescendingOrderByColumn('CAST(CONT AS UNSIGNED )');
   $this->parlamentari = OppCaricaPeer::doSelectRS($c);
 }

  /**
   * Executes list action
   *
   */
  public function executeList()
  {
    
    $this->session = $this->getUser();

    $this->query = $this->getRequestParameter('query', '');
    
    $this->getResponse()->setTitle('Tutte le votazioni elettroniche di Camera e Senato - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','La lista e il dettaglio, voto per voto, di tutte le votazioni elettroniche di aula di Camera e Senato',true);
    
    // estrae tutte le macrocategorie, per costruire la select
    $this->all_tags_categories = OppTeseottPeer::doSelect(new Criteria());        

    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_tags_category', '0');
      $this->getRequest()->getParameterHolder()->set('filter_type', '0');
      $this->getRequest()->getParameterHolder()->set('filter_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_esito', '0');      
    }

    $this->processFilters(array('tags_category', 'type', 'ramo', 'esito'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_tags_category') == '0' &&
        $this->getRequestParameter('filter_type') == '0' &&
        $this->getRequestParameter('filter_ramo') == '0' && 
        $this->getRequestParameter('filter_esito') == '0')
    {
      $this->redirect('@votazioni');
    }
    
    $this->processListSort();
 
    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $this->pager = new sfPropelPager('OppVotazione', $itemsperpage);
    $c = new Criteria();
	  $this->addListSortCriteria($c);
    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
	  $c->add(OppSedutaPeer::LEGISLATURA, '17', Criteria::EQUAL);
	  $this->addFiltersCriteria($c);    
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppSeduta');
    $this->pager->setPeerCountMethod('doCountJoinOppSeduta');
	  $this->pager->init();
		
  }
  
  public function executeKeyvotes()
  {
    $this->session = $this->getUser();

    $this->query = $this->getRequestParameter('query', '');
    
    $this->getResponse()->setTitle('I voti chiave di Camera e Senato - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','La lista e il dettaglio, voto per voto, delle votazioni di camera e Senato pi&ugrave; importanti per argomento trattato e significato politico ',true);
     
  
  }

  public function executeRelevantVotes()
  {
    $this->session = $this->getUser();

    $this->query = $this->getRequestParameter('query', '');
    
    $this->getResponse()->setTitle('I voti editorialmente rilevanti di Camera e Senato - '.sfConfig::get('app_main_title'));
  }
  
  public function executeMaggioranzaSotto()
  {
    $this->session = $this->getUser();

    $this->query = $this->getRequestParameter('query', '');
    
    $this->getResponse()->setTitle('I voti di Camera e Senato in cui la maggioranza di governo e\' stata sconfitta - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','Il dettaglio delle votazioni elettroniche di Camera e Senato in cui la maggioranza &egrave; stata sconfitta. I parlamentari di maggioranza assenti e i ribelli al proprio gruppo di appartenenza',true);
     // estrae tutte le macrocategorie, per costruire la select
      $this->all_tags_categories = OppTeseottPeer::doSelect(new Criteria());        

      // reset dei filtri se richiesto esplicitamente
      if ($this->getRequestParameter('reset_filters', 'false') == 'true')
      {
        $this->getRequest()->getParameterHolder()->set('filter_tags_category', '0');
        $this->getRequest()->getParameterHolder()->set('filter_type', '0');
        $this->getRequest()->getParameterHolder()->set('filter_ramo', '0');
        $this->getRequest()->getParameterHolder()->set('filter_esito', '0');      
      }

      $this->processFilters(array('tags_category', 'type', 'ramo', 'esito'));

      // if all filters were reset, then restart
      if ($this->getRequestParameter('filter_tags_category') == '0' &&
          $this->getRequestParameter('filter_type') == '0' &&
          $this->getRequestParameter('filter_ramo') == '0' && 
          $this->getRequestParameter('filter_esito') == '0')
      {
        $this->redirect('/votazioni/maggioranzaSotto');
      }

      $this->processListSort();

      if ($this->hasRequestParameter('itemsperpage'))
        $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
      $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

     
      $this->pager = new sfPropelPager('OppVotazione', $itemsperpage);
      //$c = OppVotazionePeer::maggioranzaSottoCriteria(17);
      $c= OppVotazionePeer::getVotazioniMaggioranzaSotto();
      $this->addListSortCriteria($c);
      $this->addFiltersCriteria($c);    
      $this->pager->setCriteria($c);
      $this->pager->setPage($this->getRequestParameter('page', 1));
      $this->pager->setPeerMethod('doSelectJoinOppSeduta');
      $this->pager->setPeerCountMethod('doCountJoinOppSeduta');
      $this->pager->init();
  
  }
  
  public function executeMaggioranzaSalva()
  {
    $this->session = $this->getUser();

    $this->query = $this->getRequestParameter('query', '');
    
    $this->getResponse()->setTitle('I voti di Camera e Senato in cui la maggioranza di governo e\' stata salvata dai voti dell\'opposizione - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','Il dettaglio delle votazioni elettroniche di Camera e Senato in cui la maggioranza &egrave; stata salvata dai voti e dalle assenze dei parlamentari di opposizione.',true);
     // estrae tutte le macrocategorie, per costruire la select
      $this->all_tags_categories = OppTeseottPeer::doSelect(new Criteria());        

      // reset dei filtri se richiesto esplicitamente
      if ($this->getRequestParameter('reset_filters', 'false') == 'true')
      {
        $this->getRequest()->getParameterHolder()->set('filter_tags_category', '0');
        $this->getRequest()->getParameterHolder()->set('filter_type', '0');
        $this->getRequest()->getParameterHolder()->set('filter_ramo', '0');
        $this->getRequest()->getParameterHolder()->set('filter_esito', '0');      
      }

      $this->processFilters(array('tags_category', 'type', 'ramo', 'esito'));

      // if all filters were reset, then restart
      if ($this->getRequestParameter('filter_tags_category') == '0' &&
          $this->getRequestParameter('filter_type') == '0' &&
          $this->getRequestParameter('filter_ramo') == '0' && 
          $this->getRequestParameter('filter_esito') == '0')
      {
        $this->redirect('/votazioni/maggioranzaSalva');
      }

      $this->processListSort();

      if ($this->hasRequestParameter('itemsperpage'))
        $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
      $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

     
      $this->pager = new sfPropelPager('OppVotazione', $itemsperpage);
      
      $c= OppVotazionePeer::getVotazioniMaggioranzaSalva();
      $this->addListSortCriteria($c);
      $this->addFiltersCriteria($c);    
      $this->pager->setCriteria($c);
      $this->pager->setPage($this->getRequestParameter('page', 1));
      $this->pager->setPeerMethod('doSelectJoinOppSeduta');
      $this->pager->setPeerCountMethod('doCountJoinOppSeduta');
      $this->pager->init();
  
  }
  
  
   
}

?>
