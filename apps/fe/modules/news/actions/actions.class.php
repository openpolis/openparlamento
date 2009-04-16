<?php

/**
 * news actions.
 *
 * @package    openparlamento
 * @subpackage news
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class newsActions extends sfActions
{
  
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
  }
  
  public function executeHomeAll()
  {
    $this->session = $this->getUser();
    
    $this->n_news = NewsPeer::countHomeNews();

    $c = NewsPeer::getHomeNewsCriteria();
    $c->addDescendingOrderByColumn(NewsPeer::DATE);

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $pager = new deppNewsPager('News', $itemsperpage);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->pager = $pager;    
  }



  public function executeDisegniList()
  {
    $this->_getAttiList(NewsPeer::ATTI_DDL_TIPO_IDS);
  }

  public function executeDecretiList()
  {
    $this->_getAttiList(NewsPeer::ATTI_DECRETI_TIPO_IDS);
  }

  public function executeDecretiLegislativiList()
  {
    $this->_getAttiList(NewsPeer::ATTI_DECRETI_LEGISLATIVI_TIPO_IDS);
  }

  public function executeAttiNonLegislativiList()
  {
    $this->_getAttiList(NewsPeer::ATTI_NON_LEGISLATIVI_TIPO_IDS);
  }
  
  
  protected function _getAttiList($tipo_atto_ids)
  {
    $this->session = $this->getUser();

    $filters = array();
    if ($this->getRequest()->getMethod() == sfRequest::POST) 
    {
      // legge i filtri dalla request e li scrive nella sessione utente
      if ($this->hasRequestParameter('filter_main_all'))
        $this->session->setAttribute('main_all', $this->getRequestParameter('filter_main_all'), 'news_filter');        
    }

    // legge sempre i filtri dalla sessione utente
    $filters['main_all'] = $this->session->getAttribute('main_all', 'main', 'news_filter');

    $this->filters = $filters;
    
    if ($filters['main_all'] == 'main')
      $max_priority = 1;
    else
      $max_priority = 2;

    $c = NewsPeer::getAttiListNewsCriteria($tipo_atto_ids, null, $max_priority);


    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $pager = new deppNewsPager('News', $itemsperpage);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->pager = $pager;    
  }

  
  public function executePolitician()
  {

    $this->politician_id = $this->getRequestParameter('id');
    $this->politician = OppPoliticoPeer::retrieveByPK($this->politician_id);
    $this->n_news = NewsPeer::countNewsForItem('OppPolitico', $this->politician_id);

    $c = NewsPeer::getNewsForItemCriteria('OppPolitico', $this->politician_id);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $pager = new deppNewsPager('News', $itemsperpage);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->pager = $pager;

  }

  public function executeAct()
  {

    $this->act_id = $this->getRequestParameter('id');
    $this->act = OppAttoPeer::retrieveByPK($this->act_id);
    $this->n_news = NewsPeer::countNewsForItem('OppAtto', $this->act_id);

    $c = NewsPeer::getNewsForItemCriteria('OppAtto', $this->act_id);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $pager = new deppNewsPager('News', $itemsperpage);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->pager = $pager;

  }

  public function executeTag()
  {

     // prima veniva chiamato per trple_value ma dare errore col paginatore	
    //$this->tag_name = $this->getRequestParameter('name');
    //$this->tag = TagPeer::retrieveByTagname($this->tag_name);
    //$this->tag_id = $this->tag->getId();
    
    // due righe modificate per la chiamata con id
    $this->tag_id = $this->getRequestParameter('id');
    $this->tag = TagPeer::retrieveByPK($this->tag_id);

    $this->n_news = NewsPeer::countNewsForTag($this->tag_id);
    $c = NewsPeer::getNewsForTagCriteria($this->tag_id);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $pager = new deppNewsPager('News', $itemsperpage);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->pager = $pager;

  }
  
  
  

}
