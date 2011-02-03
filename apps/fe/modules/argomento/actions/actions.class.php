<?php

/**
 * argomento actions.
 *
 * @package    openparlamento
 * @subpackage argomento
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class argomentoActions extends sfActions
{

  public function preExecute()
  {
    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'module', 'module', 
                                                  array('acts_filter', 'sf_admin/opp_atto/sort',
                                                        'votes_filter', 'sf_admin/opp_votazione/sort',
                                                        'pol_camera_filter', 'pol_senato_filter', 'sf_admin/opp_carica/sort',
                                                        'monitoring_filter'));
  }


  public function executeList()
  {
    // fetch teseo top_terms and add monitoring info
    $teseo_tts_with_counts = OppTeseottPeer::getAllWithCount();
    /*
    foreach ($teseo_tts_with_counts as $term_id => $term_data)
    {
      $teseo_tts_with_counts[$term_id]['n_monitored'] = OppTeseottPeer::countTagsUnderTermMonitoredByUser($term_id);
    }
    */
    $this->teseo_tts_with_counts = $teseo_tts_with_counts;
    
    $tag_count=TagPeer::getAllWithCount();
    $this->tag_count=$tag_count; 
  }


  public function executeShowAggiornamenti()
  {
    $this->triple_value = $this->getRequestParameter('triple_value');
    $this->getResponse()->setTitle('Tutto quello che succede in Parlamento su '.strtolower($this->triple_value).' - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','Le ultime notizie e atti parlamentari su '.strtolower($this->triple_value),true);
    $this->argomento = TagPeer::retrieveFirstByTripleValue($this->triple_value);
    $this->forward404Unless(isset($this->argomento));

    $this->user = OppUserPeer::retrieveByPK($this->user_id);
    $this->session = $this->getUser();

    // fetch di tutte le notizie legate ad atti taggati con il tag corrente
    $c = oppNewsPeer::getNewsForTagCriteria($this->argomento->getId());
    $c->addDescendingOrderByColumn(NewsPeer::DATE);
    
    $filters = array();
    if ($this->getRequest()->getMethod() == sfRequest::POST) 
    {
      // legge i filtri dalla request e li scrive nella sessione utente
      if ($this->hasRequestParameter('filter_main_all'))
        $this->session->setAttribute('main_all', $this->getRequestParameter('filter_main_all'), 'news_filter');
        
      if ($this->getRequestParameter('filter_main_all') == 'main')
      {
        $this->redirect('@argomento?triple_value=' . $this->triple_value);
      }

    }

    $filters['main_all'] = $this->session->getAttribute('main_all', 'main', 'news_filter');

    if ($filters['main_all'] == 'main')
      $c->add(NewsPeer::PRIORITY, 1);

    // passa la variabile filters
    $this->filters = $filters;

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $this->pager = new deppNewsPager('News', $itemsperpage);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
  	$this->pager->init();
    
  }


  /**
   * questa azione è deprecata
   * il routing reindirizza a datiStorici/interessi
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function executeListSiOccupanoDi()
  {
    
    $this->argomento_tv = $this->getRequestParameter('triple_value');
    $this->argomento = TagPeer::retrieveFirstByTripleValue($this->argomento_tv);
    $this->ramo = $this->getRequestParameter('ramo');
    
    $this->forward404Unless(in_array($this->ramo, array('C', 'S')));
    
    if ($this->ramo == 'C') {
      $this->tipo_politici = 'dep';
    } else {
      $this->tipo_politici = 'sen';
    }

    if ($this->hasRequestParameter('limit'))
      $limit = $this->getRequestParameter('limit');

    // la data è passata come parametro o viene estratta l'ultima nella cache (per dati di tipo 'A', singoli atti)
    if ($this->hasRequestParameter('data'))
      $data = $this->getRequestParameter('data');
    else
      $data = OppActHistoryCachePeer::fetchLastData();
      
    $this->politici = OppCaricaPeer::getClassificaPoliticiSiOccupanoDiArgomenti(array($this->argomento->getId()), $this->ramo, $data); 
  }
  
  public function executeListClassificaEnel()
  {
    
    $this->ramo = $this->getRequestParameter('ramo');
    $this->argomentis = array(
    'ENERGIA ELETTRICA'                             => 826,
    'ENERGIA EOLICA'                             => 843, 
    'energia geotermica'                          => 8335, 
    'energia idroelettrica'                             => 6697, 
    'ENERGIA NUCLEARE'                     => 845, 
    'ENERGIA SOLARE'              => 847, 
    'energie rinnovabili'   => 4732, 
    "mobilita' sostenibile"                           => 6431, 
    "veicoli elettrici"            => 16122, 
    'ente nazionale energia elettrica (enel)'    => 6213, 
#      'spesa militare'                          => 644
      );
    
    $this->forward404Unless(in_array($this->ramo, array('C', 'S')));
    
    if ($this->ramo == 'C') {
      $this->tipo_politici = 'dep';
    } else {
      $this->tipo_politici = 'sen';
    }

    if ($this->hasRequestParameter('limit'))
      $limit = $this->getRequestParameter('limit');

    // la data è passata come parametro o viene estratta l'ultima nella cache (per dati di tipo 'A', singoli atti)
    if ($this->hasRequestParameter('data'))
      $data = $this->getRequestParameter('data');
    else
      $data = OppActHistoryCachePeer::fetchLastData();
      
    $this->politici = OppCaricaPeer::getClassificaPoliticiSiOccupanoDiArgomenti(array_values($this->argomentis), $this->ramo, $data); 
  }
  
  public function executeListClassificaActionAid()
  {
    
    $this->ramo = $this->getRequestParameter('ramo');
    $this->argomentis = array(
#      '5 per mille'                             => 7698,
#      '8 per mille'                             => 7996, 
#      'aiuti sanitari'                          => 5715, 
      'aiuti umanitari'                         => 6729, 
#      'banca mondiale (bm)'                     => 5837, 
      'cooperazione allo sviluppo'              => 4653, 
#      'cooperazione economica internazionale'   => 1560, 
#      'diritti umani'                           => 4585, 
#      "missioni militari all'estero"            => 317, 
#      'organizzazioni non governative (ong)'    => 7313, 
#      'spesa militare'                          => 644
      );
    
    $this->forward404Unless(in_array($this->ramo, array('C', 'S')));
    
    if ($this->ramo == 'C') {
      $this->tipo_politici = 'dep';
    } else {
      $this->tipo_politici = 'sen';
    }

    if ($this->hasRequestParameter('limit'))
      $limit = $this->getRequestParameter('limit');

    // la data è passata come parametro o viene estratta l'ultima nella cache (per dati di tipo 'A', singoli atti)
    if ($this->hasRequestParameter('data'))
      $data = $this->getRequestParameter('data');
    else
      $data = OppActHistoryCachePeer::fetchLastData();
      
    $this->politici = OppCaricaPeer::getClassificaPoliticiSiOccupanoDiArgomenti(array_values($this->argomentis), $this->ramo, $data); 
  }


  public function executeShowLeggi()
  {
    $this->triple_value = $this->getRequestParameter('triple_value');
    $this->getResponse()->setTitle('I disegni di legge su '.strtolower($this->triple_value).' - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','Tutti gli aggiornamenti sui disegni di legge presentati su '.strtolower($this->triple_value),true);
    $this->argomento = TagPeer::retrieveFirstByTripleValue($this->triple_value);
    $this->forward404Unless(isset($this->argomento));
    $this->user = OppUserPeer::retrieveByPK($this->user_id);
    $this->session = $this->getUser();

    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_act_leggi_type', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_stato', '0');
    }

    $this->processFilters(array('act_leggi_type', 'act_ramo', 'act_stato'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_act_leggi_type') == '0' &&
        $this->getRequestParameter('filter_act_ramo') == '0' && 
        $this->getRequestParameter('filter_act_stato') == '0')
    {
      $this->redirect('@argomento_leggi?triple_value='.$this->triple_value);
    }
    
    $this->processListSort('argomento_leggi/sort');

	  if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));
  
    $this->pager = new sfPropelPager('OppAtto', $itemsperpage);
    $c = new Criteria();

    $c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
    $c->add(TaggingPeer::TAG_ID, $this->argomento->getId());
    $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');

	  $this->addFiltersCriteria($c);    
	  $this->addListSortCriteria($c, 'argomento_leggi/sort');
	  
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppTipoAtto');
    $this->pager->init();
  }

  public function executeShowNonleg()
  {
    $this->triple_value = $this->getRequestParameter('triple_value');
    $this->getResponse()->setTitle('Mozioni, interrogazioni, odg su '.strtolower($this->triple_value).' - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','Tutti gli aggiornamenti sulle mozioni, interrogazioni, odg presentati in parlamento su '.strtolower($this->triple_value),true);
    $this->argomento = TagPeer::retrieveFirstByTripleValue($this->triple_value);
    $this->forward404Unless(isset($this->argomento));
    $this->user = OppUserPeer::retrieveByPK($this->user_id);
    $this->session = $this->getUser();

    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_nonleg_act_type', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_stato', '0');
    }

    $this->processFilters(array('act_nonleg_type', 'act_ramo', 'act_stato'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_nonleg_act_type') == '0' &&
        $this->getRequestParameter('filter_act_ramo') == '0' && 
        $this->getRequestParameter('filter_act_stato') == '0')
    {
      $this->redirect('@argomento_nonleg?triple_value='.$this->triple_value);
    }
    
    $this->processListSort('argomento_nonleg/sort');

	  if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));
  
    $this->pager = new sfPropelPager('OppAtto', $itemsperpage);
    $c = new Criteria();

    $c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
    $c->add(TaggingPeer::TAG_ID, $this->argomento->getId());
    $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');

	  $this->addFiltersCriteria($c);    
	  $this->addListSortCriteria($c, 'argomento_nonleg/sort');
	  
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppTipoAtto');
    $this->pager->init();

  }


  protected function processListSort($session_namespace)
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->session->setAttribute('sort', $this->getRequestParameter('sort'), $session_namespace);
      $this->session->setAttribute('type', $this->getRequestParameter('type', 'asc'), $session_namespace);
    }

    if (!$this->session->getAttribute('sort', null, $session_namespace))
    {
	    $this->session->setAttribute('sort', 'data_pres', $session_namespace);
      $this->session->setAttribute('type', 'desc', $session_namespace);
    }
  }
  
  protected function addListSortCriteria($c, $session_namespace)
  {
    if ($sort_column = $this->session->getAttribute('sort', null, $session_namespace))
    {
      $sort_column = OppAttoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      if ($this->session->getAttribute('type', null, $session_namespace) == 'asc')
      {
        $c->addAscendingOrderByColumn($sort_column);
      }
      else
      {
        $c->addDescendingOrderByColumn($sort_column);
      }
    }
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
    if ($this->getRequest()->getMethod() == sfRequest::POST ||
        $this->getRequest()->getMethod() == sfRequest::GET ) 
    {
      if ($this->hasRequestParameter('filter_tags_category'))
        $this->session->setAttribute('tags_category', $this->getRequestParameter('filter_tags_category'), 'argomento/atti_filter');

      if ($this->hasRequestParameter('filter_act_ramo'))
        $this->session->setAttribute('act_ramo', $this->getRequestParameter('filter_act_ramo'), 'argomento/atti_filter');

      if ($this->hasRequestParameter('filter_act_stato'))
        $this->session->setAttribute('act_stato', $this->getRequestParameter('filter_act_stato'), 'argomento/atti_filter');

      if ($this->hasRequestParameter('filter_act_leggi_type'))
        $this->session->setAttribute('act_leggi_type', $this->getRequestParameter('filter_act_leggi_type'), 'argomento/atti_filter');

      if ($this->hasRequestParameter('filter_act_nonleg_type'))
        $this->session->setAttribute('act_nonleg_type', $this->getRequestParameter('filter_act_nonleg_type'), 'argomento/atti_filter');

    }


    // legge sempre i filtri dalla sessione utente (quelli attivi)
    if (in_array('tags_category', $active_filters))
      $this->filters['tags_category'] = $this->session->getAttribute('tags_category', '0', 'argomento/atti_filter');

    if (in_array('act_ramo', $active_filters))
      $this->filters['act_ramo'] = $this->session->getAttribute('act_ramo', '0', 'argomento/atti_filter');

    if (in_array('act_stato', $active_filters))
      $this->filters['act_stato'] = $this->session->getAttribute('act_stato', '0', 'argomento/atti_filter');    

    if (in_array('act_leggi_type', $active_filters))
      $this->filters['act_leggi_type'] = $this->session->getAttribute('act_leggi_type', '0', 'argomento/atti_filter');    

    if (in_array('act_nonleg_type', $active_filters))
      $this->filters['act_nonleg_type'] = $this->session->getAttribute('act_nonleg_type', '0', 'argomento/atti_filter');    


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
    if (array_key_exists('act_ramo', $this->filters) && $this->filters['act_ramo'] != '0')
      $c->add(OppAttoPeer::RAMO, $this->filters['act_ramo']);
    
    // filtro per stato di avanzamento
    if (array_key_exists('act_stato', $this->filters) && $this->filters['act_stato'] != '0')
      $c->add(OppAttoPeer::STATO_COD, $this->filters['act_stato']);      

    // filtro per tipo di legge
    if (array_key_exists('act_leggi_type', $this->filters))
    {
      switch ($this->filters['act_leggi_type'])
      {
        case '0':
          $c->add(OppAttoPeer::TIPO_ATTO_ID, array(1, 12, 15, 16, 17), Criteria::IN);
          break;
        
        case 'DDL':
          $c->add(OppAttoPeer::TIPO_ATTO_ID, 1);
          break;
          
        case 'DL':
          $c->add(OppAttoPeer::TIPO_ATTO_ID, 12);
          break;

        case 'DLEG':
          $c->add(OppAttoPeer::TIPO_ATTO_ID, array(15, 16, 17), Criteria::IN);
          break;
      }
    }

    // filtro per tipo di atto non legislativo
    if (array_key_exists('act_nonleg_type', $this->filters))
      if ($this->filters['act_nonleg_type'] == '0')
        $c->add(OppAttoPeer::TIPO_ATTO_ID, array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 14), Criteria::IN);      
      else
        $c->add(OppAttoPeer::TIPO_ATTO_ID, $this->filters['act_nonleg_type']);

    // filtro per categoria
    if (array_key_exists('tags_category', $this->filters) && $this->filters['tags_category'] != '0')
    {
      $c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
      $c->addJoin(TagPeer::ID, OppTagHasTtPeer::TAG_ID);
      $c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
      $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
      $c->add(OppTagHasTtPeer::TESEOTT_ID, $this->filters['tags_category']);
      $c->setDistinct();
    }    

    
  }

  
  public function executeShowFromSearch()
  {
    if ($this->hasRequestParameter('tag_name')) {
      $argomento = TagPeer::retrieveByTagname($this->getRequestParameter('tag_name'));
    }
    
    $triple_value = $argomento->getTripleValue();
    $this->redirect('@argomento?triple_value='.$triple_value);
  }
  

  /**
   * estrae i tag relativi al top tem
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function executeAjaxTagsForTopTerm()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    
    $top_term_id = $this->getRequestParameter('tt_id');

    $c = new Criteria();
    $c->add(OppTagHasTtPeer::TESEOTT_ID, $top_term_id);
    $c->addJoin(OppTagHasTtPeer::TAG_ID, TagPeer::ID);
    $c->addAscendingOrderByColumn(TagPeer::TRIPLE_VALUE);
    $this->tags = TagPeer::getPopulars($c);
   
  }

  
  public function executeElencoDdl()
  {
    $this->teseo_id = $this->getRequestParameter('teseo_id');
	  $this->argomento_id = $this->getRequestParameter('argomento_id');
	
	  $c = new Criteria();
    $c->add(OppTeseottPeer::ID, $this->argomento_id, Criteria::EQUAL );
    $this->argomento = OppTeseottPeer::doSelectOne($c);
    
    $this->tesei = $this->argomento->getTeseos();
    	
  }
}
