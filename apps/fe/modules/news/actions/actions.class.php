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
    
    $this->n_news = oppNewsPeer::countHomeNews();
    
    $this->getResponse()->setTitle('Le ultime le notizie dal Parlamento - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','La lista delle notizie dal Parlamento aggiornate quotidianamente ',true);

    $c = oppNewsPeer::getHomeNewsCriteria();
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
    $this->_getAttiList(oppNewsPeer::ATTI_DDL_TIPO_IDS);
    $this->getResponse()->setTitle('tutte le notizie sui disegni di legge - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','La lista delle notizie sui disegni di legge parlamentari aggiornate quotidianamente ',true);
  }

  public function executeDecretiList()
  {
    $this->_getAttiList(oppNewsPeer::ATTI_DECRETI_TIPO_IDS);
    $this->getResponse()->setTitle('tutte le notizie sui decreti legge - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','La lista delle notizie sui decreti legge aggiornate quotidianamente ',true);
  }

  public function executeDecretiLegislativiList()
  {
    $this->_getAttiList(oppNewsPeer::ATTI_DECRETI_LEGISLATIVI_TIPO_IDS);
    $this->getResponse()->setTitle('tutte le notizie sui decreti legislativi - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','La lista delle notizie sui decreti legislativi aggiornate quotidianamente ',true);
  }

  public function executeAttiNonLegislativiList()
  {
    $this->_getAttiList(oppNewsPeer::ATTI_NON_LEGISLATIVI_TIPO_IDS);
    $this->getResponse()->setTitle('tutte le notizie sugli atti non legislativi - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','La lista delle notizie su mozioni, interpellanze, ordini del giorno e interrogazioni parlamentari aggiornate quotidianamente',true);
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

    $c = oppNewsPeer::getAttiListNewsCriteria($tipo_atto_ids, null, $max_priority);


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
    $this->n_news = oppNewsPeer::countNewsForItem('OppPolitico', $this->politician_id);
    
    $this->getResponse()->setTitle('tutte le notizie sul parlamentare '.$this->politician->getNome().' '.$this->politician->getCognome().' - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','Tutte le notizie aggiornate quotidianamente su cosa fa in Parlamento '.$this->politician->getNome().' '.$this->politician->getCognome(),true);
    
    $c = new Criteria();
    $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(1, 4, 5), Criteria::IN);
    $c->add(OppCaricaPeer::DATA_FINE, null, Criteria::ISNULL);
    $c->add(OppCaricaPeer::POLITICO_ID, $this->politician_id);
    $this->carica= OppCaricaPeer::doSelectOne($c);

    $c = oppNewsPeer::getNewsForItemCriteria('OppPolitico', $this->politician_id);
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
    $this->n_news = oppNewsPeer::countNewsForItem('OppAtto', $this->act_id);
    
    $this->getResponse()->setTitle('tutte le notizie su '.$this->act->getOppTipoAtto()->getDescrizione().' '.Text::denominazioneAttoShort($this->act).' - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','Tutte le notizie aggiornate quotidianamente su presentazione e iter  '.$this->act->getOppTipoAtto()->getDescrizione().' '.Text::denominazioneAttoShort($this->act),true);
    
    $c = oppNewsPeer::getNewsForItemCriteria('OppAtto', $this->act_id);
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

    // due righe modificate per la chiamata con id
    $this->tag_id = $this->getRequestParameter('id');
    $this->tag = TagPeer::retrieveByPK($this->tag_id);
    
    $this->getResponse()->setTitle('tutte le notizie sull\'argomento '.$this->tag->getTripleValue().' - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','Tutte le notizie aggiornate quotidianamente sugli atti parlamentari che parlano di  '.$this->tag->getTripleValue(),true);
    $c = oppNewsPeer::getNewsForTagCriteria($this->tag_id);
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
  
  public function executeComunita() 
  {
   $this->getResponse()->setTitle("le ultime 100 attivita' della comunita' - ".sfConfig::get('app_main_title'));
   $this->response->addMeta('description','Tutte le notizie aggiornate quotidianamente sulle azioni degli utenti di openparlamento',true);
   $this->latest_activities = CommunityNewsPeer::getLatestActivities(100);
    
    
  }
  
  
  

}
