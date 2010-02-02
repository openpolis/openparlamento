<?php

/**
 * emendamento actions.
 *
 * @package    op_openparlamento
 * @subpackage emendamento
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class emendamentoActions extends sfActions
{
  
  private static $filter_names = array('article', 'site', 'presenter');
  private static $filter_ns = 'emendaments_filter';
  
  public function preExecute()
  {
    // must reset all filters , except emendaments_filters
    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'module', 'module', 
                                                  array('acts_filter', 'votes_filter', 'sf_admin/opp_votazione/sort',
                                                        'pol_camera_filter', 'pol_senato_filter', 'sf_admin/opp_carica/sort',
                                                        'argomento/atti_filter', 'argomento_leggi/sort', 'argomento_nonleg/sort',
                                                        'monitoring_filter'));

  }

  /**
   * reset filters and sort session variables when
   * the action changes
   *
   * @return void
   * @author Guglielmo Celata
   */
  protected function _reset_session_vars()
  {    
    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'action', 'emendaments_action', 
                                                  array('emendaments_filter'));
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

    foreach (self::$filter_names as  $filter_name) {
      // read filters from request and write them into user session
      if ($this->hasRequestParameter('filter_'.$filter_name))
        $this->session->setAttribute($filter_name, $this->getRequestParameter('filter_'.$filter_name), self::$filter_ns);
      // read active filters from user sessions and store them into filters array
      if (in_array($filter_name, $active_filters)) {
        $filters[$filter_name] = $this->session->getAttribute($filter_name, '0', self::$filter_ns);
      }
    }
    
    // make filter a view variable
    $this->filters = $filters;
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
    // article filter
    if (array_key_exists('article', $this->filters) && $this->filters['article'] != '0')
      $c->add(OppEmendamentoPeer::ARTICOLO, $this->filters['article']);
    
    // site filter
    if (array_key_exists('site', $this->filters) && $this->filters['site'] != '0')
      $c->add(OppEmendamentoPeer::SEDE_ID, $this->filters['site']);      

    // presenter filter
    if (array_key_exists('presenter', $this->filters) && $this->filters['presenter'] != '0')
    {
      if ($this->filters['presenter'] == '999999999')
      {
        $c->addJoin(OppEmendamentoPeer::ID, OppCaricaHasEmendamentoPeer::EMENDAMENTO_ID, Criteria::LEFT_JOIN);
        $c->add(OppCaricaHasEmendamentoPeer::CARICA_ID, null, Criteria::ISNULL);
        
      } else {
        $c->addJoin(OppEmendamentoPeer::ID, OppCaricaHasEmendamentoPeer::EMENDAMENTO_ID);
        $c->add(OppCaricaHasEmendamentoPeer::CARICA_ID, $this->filters['presenter']);
        $c->add(OppCaricaHasEmendamentoPeer::TIPO, 'P');        
      }
      
    }    

    // status
    if (array_key_exists('status', $this->filters) && $this->filters['status'] != '0')
    {
      $c->addJoin(OppEmendamentoPeer::ID, OppEmendamentoHasIterPeer::EMENDAMENTO_ID);
      $c->add(OppEmendamentoHasIterPeer::EM_ITER_ID, $this->filters['status']);
    }    
    
  }
  
  
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->session = $this->getUser();
    $this->atto = OppAttoPeer::retrieveByPK($this->getRequestParameter('id'));
    
    $this->getResponse()->setTitle('Lista degli emendamenti al ddl '.$this->atto->getRamo().'.'.$this->atto->getNumfase().' '.Text::denominazioneAtto($this->atto, 'index').' - '.sfConfig::get('app_main_title'));
    
    
    // extracts distinct articoli for listed emendamenti
    $articles = $this->atto->getAvailableEmendamentiArticles();
    $ar = array('0' => 'tutti');
    foreach ($articles as $article)
    {
      $ar[$article] = $article;
    }
    $this->available_articles = $ar;

    
    // extracts distinct sedi for listed emendamenti
    $sites = $this->atto->getAvailableEmendamentiSites();
    $ar = array('0' => 'tutte');
    foreach ($sites as $id => $site)
    {
      $ar[$id] = $site;
    }
    $this->available_sites = $ar;
    
    // extracts distinct presentatori for listed emendamenti
    $presenters = $this->atto->getAvailableEmendamentiPresenters();
    $ar = array('0' => 'tutti');
    foreach ($presenters as $id => $presenter)
    {
      $ar[$id] = $presenter;
    }
    $this->available_presenters = $ar;

    // extracts distinct statuses for listed emendamenti
    $statuses = $this->atto->getAvailableEmendamentiStatuses();
    $ar = array('0' => 'tutti');
    foreach ($statuses as $id => $status)
    {
      $ar[$id] = $status;
    }
    $this->available_statuses = $ar;
    
    
    
    // set number of items per page to be displayed (as specified in the pager)
    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    // reset filters and sort session variables when changing action
    $this->_reset_session_vars();
    
    // reset filter request variables if explicitly asked
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      foreach (self::$filter_names as $filter_name)
        $this->getRequest()->getParameterHolder()->set('filter_'.$filter_name, '0');        
    }

    // set filter request variables
    $this->processFilters(array('article', 'site', 'presenter'));

    // if all filters were reset, then restart from scratch
    $all_filters_are_null = true;
    foreach (self::$filter_names as $filter_name)
      $all_filters_are_null &= ($this->getRequestParameter('filter_'.$filter_name) == '0');
    if ($all_filters_are_null)
    {
      $this->redirect('@emendamenti_atto?id='.$this->atto->getId());
    }


    // build pager with all emendamenti for this atto, sorted by pres_date
    $this->pager = new sfPropelPager('OppAttoHasEmendamento', $itemsperpage);
    $c = new Criteria();
    $c->add(OppAttoHasEmendamentoPeer::ATTO_ID, $this->atto->getId());
    $c->addDescendingOrderByColumn(OppEmendamentoPeer::DATA_PRES);
    
    // add filters to pager query criteria
    $this->addFiltersCriteria($c);    
    
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppEmendamento');
    $this->pager->setPeerCountMethod('doCountJoinOppEmendamento');
    $this->pager->init();
    
  }
  
  /**
   * Executes show action
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function executeShow()
  {
    $this->emendamento = OppEmendamentoPeer::retrieveByPK($this->getRequestParameter('id'));
    $this->attoPortante = $this->emendamento->getAttoPortante();
    $this->relatedAttos = $this->emendamento->getOppAttoHasEmendamentosJoinOppAtto();
    
    $this->getResponse()->setTitle('Emendamento '.$this->emendamento->getTitolo().' al ddl '.$this->attoPortante->getRamo().'.'.$this->attoPortante->getNumfase().' '.Text::denominazioneAtto($this->attoPortante, 'index').' - '.sfConfig::get('app_main_title'));
  }
  
  /**
   * Executes commenti action
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function executeCommenti()
  {
    $this->emendamento = OppEmendamentoPeer::retrieveByPK($this->getRequestParameter('id'));
    $this->attoPortante = $this->emendamento->getAttoPortante();
  }
  
}
