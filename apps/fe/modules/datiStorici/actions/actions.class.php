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
    /*
    deppFiltersAndSortVariablesManager::resetVars($this->session, 'action', 'storici_action', 
                                                  array('sf_admin/opp_storici/filter', 'sf_admin/opp_storici/sort'));
    */


    // estrae tutte le date per cui esistono dati di tipo N (indice)
    $this->all_dates = array_merge(array('0' => 'seleziona una data'), OppPoliticianHistoryCachePeer::extractDates('N'));

    // reset dei filtri, se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_data', '0');
    }

    $this->processFilters(array('ramo', 'data'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_ramo') == '0' &&
        $this->getRequestParameter('filter_data') == '0')
    {
      $this->redirect('datiStorici/indice');
    }

    $this->processListSort();

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
    /*
    deppFiltersAndSortVariablesManager::resetVars($this->session, 'action', 'storici_action', 
                                                  array('sf_admin/opp_storici/filter', 'sf_admin/opp_storici/sort'));
    */
    // estrae tutte le date per cui esistono dati di tipo P (presenze)
    $this->all_dates = array_merge(array('0' => 'seleziona una data'), OppPoliticianHistoryCachePeer::extractDates('P'));

    // reset dei filtri, se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_data', '0');
    }

    $this->processFilters(array('ramo', 'data'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_ramo') == '0' &&
        $this->getRequestParameter('filter_data') == '0')
    {
      $this->redirect('datiStorici/presenze');
    }

    $this->processListSort();

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
    /*
    deppFiltersAndSortVariablesManager::resetVars($this->session, 'action', 'storici_action', 
                                                  array('sf_admin/opp_storici/filter', 'sf_admin/opp_storici/sort'));
    */
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
    $filters = array();

    // legge i filtri dalla request e li scrive nella sessione utente
    if ($this->hasRequestParameter('filter_ramo'))
      $this->session->setAttribute('ramo', $this->getRequestParameter('filter_ramo'), 'sf_admin/opp_storici/filter');

    if ($this->hasRequestParameter('filter_data'))
      $this->session->setAttribute('data', $this->getRequestParameter('filter_data'), 'sf_admin/opp_storici/filter');

    // legge sempre i filtri dalla sessione utente (quelli attivi)
    if (in_array('ramo', $active_filters))
      $filters['ramo'] = $this->session->getAttribute('ramo', '0', 'sf_admin/opp_storici/filter');

    if (in_array('data', $active_filters))
      $filters['data'] = $this->session->getAttribute('data', '0', 'sf_admin/opp_storici/filter');

    $this->filters = $filters;
  }

  protected function processListSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->session->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/opp_storici/sort');
      $this->session->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/opp_storici/sort');
    }

    // valore di default
    if (!$this->session->getAttribute('sort', null, 'sf_admin/opp_storici/sort'))
    {
      $this->session->setAttribute('sort', 'chi_id', 'sf_admin/opp_storici/sort');
      $this->session->setAttribute('type', 'desc', 'sf_admin/opp_storici/sort');
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
  
  
}
