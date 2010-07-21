<?php

/**
 * datiStorici actions.
 *
 * @package    op_openparlamento
 * @subpackage datiStorici
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class datiStoriciActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->redirect('datiStorici/indice');
  }

  public function executeIndice()
  {
    $this->session = $this->getUser();
    $last_date = OppPoliticianHistoryCachePeer::fetchLastData();
    
    /*
    deppFiltersAndSortVariablesManager::resetVars($this->session, 'action', 'storici_action', 
                                                  array('sf_admin/opp_storici/filter', 'sf_admin/opp_storici/sort'));
    */


    // estrae tutte le date per cui esistono dati di tipo N (indice)
    $this->all_dates = OppPoliticianHistoryCachePeer::extractDates('N');

    // reset dei filtri, se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_data', $last_date);
    }

    // se si arriva dalla rule parlamentari_nuovo_indice, è specificato il ramo
    if ($this->hasRequestParameter('ramo'))
    {
      $ramo = $this->getRequestParameter('ramo');
      if ($ramo == 'camera') $ramo = 'c';
      elseif ($ramo == 'senato') $ramo = 's';
      $this->session->setAttribute('ramo', $ramo, 'sf_admin/opp_storici/filter');
    }

    $this->processFilters(array('ramo', 'data'), $last_date);

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_ramo') == '0' &&
        $this->getRequestParameter('filter_data') == $last_date)
    {
      $this->redirect('datiStorici/indice');
    }

    $this->processListSort('indice');

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $this->pager = new sfPropelPager('OppPoliticianHistoryCache', $itemsperpage);

    $c = new Criteria();
    $this->addFiltersCriteria($c);  
    $this->addListSortCriteria($c);      
    $c->addDescendingOrderByColumn(OppPoliticianHistoryCachePeer::CHI_ID);
    $c->add(OppPoliticianHistoryCachePeer::CHI_TIPO, 'N');
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelect');
    $this->pager->init();
    
  }

  public function executePresenze()
  {
    $this->session = $this->getUser();
    $last_date = OppPoliticianHistoryCachePeer::fetchLastData();
    
    /*
    deppFiltersAndSortVariablesManager::resetVars($this->session, 'action', 'storici_action', 
                                                  array('sf_admin/opp_storici/filter', 'sf_admin/opp_storici/sort'));
    */
    // estrae tutte le date per cui esistono dati di tipo P (presenze)
    $this->all_dates = OppPoliticianHistoryCachePeer::extractDates('P');

    // reset dei filtri, se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_data', $last_date);
    }

    $this->processFilters(array('ramo', 'data'), $last_date);

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_ramo') == '0' &&
        $this->getRequestParameter('filter_data') == $last_date)
    {
      $this->redirect('datiStorici/presenze');
    }

    $this->processListSort('presenze');

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $this->pager = new sfPropelPager('OppPoliticianHistoryCache', $itemsperpage);

    $c = new Criteria();
    $this->addFiltersCriteria($c);  
    $this->addListSortCriteria($c);      
    $c->addDescendingOrderByColumn(OppPoliticianHistoryCachePeer::CHI_ID);
    $c->add(OppPoliticianHistoryCachePeer::CHI_TIPO, 'P');
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelect');
    $this->pager->init();
  }

  public function executeRilevanza()
  {
    $this->session = $this->getUser();
    $last_date = OppActHistoryCachePeer::fetchLastData();

    /*
    deppFiltersAndSortVariablesManager::resetVars($this->session, 'action', 'storici_action', 
                                                  array('sf_admin/opp_storici/filter', 'sf_admin/opp_storici/sort'));
    */
    // estrae tutte le date per cui esistono dati di tipo P (presenze)
    $this->all_dates = OppActHistoryCachePeer::extractDates();
    $this->all_tags_categories = OppTeseottPeer::doSelect(new Criteria());        

    // reset dei filtri, se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_tags_category', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_type', '0');
      $this->getRequest()->getParameterHolder()->set('filter_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_stato', '0');      
      $this->getRequest()->getParameterHolder()->set('filter_data', $last_date);
    }

    $this->processFilters(array('tags_category', 'act_type', 'ramo', 'act_stato', 'data'), $last_date);

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_tags_category') == '0' &&
        $this->getRequestParameter('filter_act_type') == '0' &&
        $this->getRequestParameter('filter_ramo') == '0' &&
        $this->getRequestParameter('filter_act_stato') == '0' &&
        $this->getRequestParameter('filter_data') == $last_date)
    {
      $this->redirect('datiStorici/rilevanza');
    }

    $this->processListSort('indice');

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $this->pager = new sfPropelPager('OppActHistoryCache', $itemsperpage);

    $c = new Criteria();
    $c->addJoin(OppAttoPeer::ID, OppActHistoryCachePeer::CHI_ID);
    $this->addFiltersCriteriaAtti($c);  
    $this->addListSortCriteriaAtti($c);      
    $c->addDescendingOrderByColumn(OppActHistoryCachePeer::CHI_ID);
    $c->add(OppActHistoryCachePeer::CHI_TIPO, 'A');
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelect');
    $this->pager->init();
  }
  

  public function executeInteressi()
  {
    $this->session = $this->getUser();
    
    $this->ramo = $this->getRequestParameter('ramo', 'C');
    
    if ($this->hasRequestParameter('triple_value'))
    {
      $triple_value = $this->getRequestParameter('triple_value');      
      $this->argomento = TagPeer::retrieveFirstByTripleValue($triple_value);
    }
    else
    {
      $this->tag_name = $this->getRequestParameter('tag_name', '');
      $this->argomento = TagPeer::retrieveByTagName($this->tag_name);      
    }
      

    if ($this->hasRequestParameter('limit'))
      $limit = $this->getRequestParameter('limit');

    // la data è passata come parametro o viene estratta l'ultima nella cache (per dati di tipo 'A', singoli atti)
    if ($this->hasRequestParameter('data'))
      $data = $this->getRequestParameter('data');
    else
      $data = OppActHistoryCachePeer::fetchLastData();
    
    if ($this->argomento) {
      $this->politici = OppCaricaPeer::getClassificaPoliticiSiOccupanoDiArgomenti(array($this->argomento->getId()), $this->ramo, $data); 
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
  protected function processFilters($active_filters, $date = '0')
  {
    $filters = array();


    // legge sempre i filtri dalla sessione utente (quelli attivi)
    if ($this->hasRequestParameter('filter_tags_category'))
      $this->session->setAttribute('tags_category', $this->getRequestParameter('filter_tags_category'), 'sf_admin/opp_storici/filter');

    if ($this->hasRequestParameter('filter_act_stato'))
      $this->session->setAttribute('act_stato', $this->getRequestParameter('filter_act_stato'), 'sf_admin/opp_storici/filter');

    if ($this->hasRequestParameter('filter_act_type'))
      $this->session->setAttribute('act_type', $this->getRequestParameter('filter_act_type'), 'sf_admin/opp_storici/filter');

    if ($this->hasRequestParameter('filter_ramo'))
      $this->session->setAttribute('ramo', $this->getRequestParameter('filter_ramo'), 'sf_admin/opp_storici/filter');

    if ($this->hasRequestParameter('filter_data'))
      $this->session->setAttribute('data', $this->getRequestParameter('filter_data'), 'sf_admin/opp_storici/filter');


    // legge sempre i filtri dalla sessione utente (quelli attivi)
    if (in_array('tags_category', $active_filters))
      $filters['tags_category'] = $this->session->getAttribute('tags_category', '0', 'sf_admin/opp_storici/filter');

    if (in_array('act_stato', $active_filters))
      $filters['act_stato'] = $this->session->getAttribute('act_stato', '0', 'sf_admin/opp_storici/filter');    

    if (in_array('act_type', $active_filters))
      $filters['act_type'] = $this->session->getAttribute('act_type', '0', 'sf_admin/opp_storici/filter');    

    if (in_array('ramo', $active_filters))
      $filters['ramo'] = $this->session->getAttribute('ramo', '0', 'sf_admin/opp_storici/filter');

    if (in_array('data', $active_filters))
      $filters['data'] = $this->session->getAttribute('data', $date, 'sf_admin/opp_storici/filter');

    $this->filters = $filters;
  }

  protected function processListSort($default_sort_field = 'chi_id')
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->session->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/opp_storici/sort');
      $this->session->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/opp_storici/sort');
    }

    // valore di default
    if (!$this->session->getAttribute('sort', null, 'sf_admin/opp_storici/sort'))
    {
      $this->session->setAttribute('sort', $default_sort_field, 'sf_admin/opp_storici/sort');
      $this->session->setAttribute('type', 'desc', 'sf_admin/opp_storici/sort');
    }
    
    // ristabilisce indici di default se si passa attraverso le presenze
    $action_name = $this->getActionName();
    if (($action_name == 'indice' || $action_name == 'rilevanza') && $this->session->getAttribute('sort', null, 'sf_admin/opp_storici/sort') != 'indice')
    {
      $this->session->setAttribute('sort', $default_sort_field, 'sf_admin/opp_storici/sort');      
    }

    if ($action_name == 'presenze' && $this->session->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'indice')
    {
      $this->session->setAttribute('sort', $default_sort_field, 'sf_admin/opp_storici/sort');      
    }
    
  }

  protected function addFiltersCriteria($c)
  {
    // filtro per ramo
    if (array_key_exists('ramo', $this->filters) && $this->filters['ramo'] != '0')
      $c->add(OppPoliticianHistoryCachePeer::RAMO, $this->filters['ramo']);

    // filtro per data
    if (array_key_exists('data', $this->filters) && $this->filters['data'] != '0')
      $c->add(OppPoliticianHistoryCachePeer::DATA, $this->filters['data']);

  }

  
  protected function addListSortCriteria($c)
  {
    if ($sort_column = $this->session->getAttribute('sort', null, 'sf_admin/opp_storici/sort'))
    {
      $sort_column = OppPoliticianHistoryCachePeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      if ($this->session->getAttribute('type', null, 'sf_admin/opp_storici/sort') == 'asc')
      {
        $c->addAscendingOrderByColumn($sort_column);
      }
      else
      {
        $c->addDescendingOrderByColumn($sort_column);
      }
    }
  }

  protected function addListSortCriteriaAtti($c)
  {
    if ($sort_column = $this->session->getAttribute('sort', 'indice', 'sf_admin/opp_storici/sort'))
    {
      if (!in_array($sort_column, array('presenze', 'assenze', 'missioni'))) {
        $sort_column = OppActHistoryCachePeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
        if ($this->session->getAttribute('type', null, 'sf_admin/opp_storici/sort') == 'asc')
        {
          $c->addAscendingOrderByColumn($sort_column);
        }
        else
        {
          $c->addDescendingOrderByColumn($sort_column);
        }
      }
    }
  }

  protected function addFiltersCriteriaAtti($c)
  {
    // filtro per data
    if (array_key_exists('data', $this->filters) && $this->filters['data'] != '0')
      $c->add(OppActHistoryCachePeer::DATA, $this->filters['data']);

    // filtro per ramo
    if (array_key_exists('ramo', $this->filters) && $this->filters['ramo'] != '0')
      $c->add(OppAttoPeer::RAMO, $this->filters['ramo']);
      
    // filtro per stato di avanzamento
    if (array_key_exists('act_stato', $this->filters) && $this->filters['act_stato'] != '0')
      $c->add(OppAttoPeer::STATO_COD, $this->filters['act_stato']);      

    // filtro per tipo di decreto legislativo
    if (array_key_exists('act_type', $this->filters) && $this->filters['act_type'] != '0')
      $c->add(OppAttoPeer::TIPO_ATTO_ID, $this->filters['act_type']);

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

  
}
