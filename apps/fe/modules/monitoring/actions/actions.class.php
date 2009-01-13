<?php

/**
 * monitoring actions.
 *
 * @package    openparlamento
 * @subpackage monitoring
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class monitoringActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->redirect('@monitoring_news?user_token=' . $this->getUser()->getToken());
  }
    
  public function executeNews()
  {
    $this->user_id = $this->getUser()->getId();
    $this->user = OppUserPeer::retrieveByPK($this->user_id);
    $this->session = $this->getUser();

    $filters = array();
    if ($this->getRequest()->getMethod() == sfRequest::POST) 
    {
      // legge i filtri dalla request e li scrive nella sessione utente
      if ($this->hasRequestParameter('filter_tag_id'))
        $this->session->setAttribute('tag_id', $this->getRequestParameter('filter_tag_id'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_act_type_id'))
        $this->session->setAttribute('act_type_id', $this->getRequestParameter('filter_act_type_id'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_act_ramo'))
        $this->session->setAttribute('act_ramo', $this->getRequestParameter('filter_act_ramo'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_date'))
        $this->session->setAttribute('date', $this->getRequestParameter('filter_date'), 'monitoring_filter');
        
      if ($this->getRequestParameter('filter_tag_id') == '0' &&
          $this->getRequestParameter('filter_act_type_id') == '0' &&
          $this->getRequestParameter('filter_act_ramo') == '0' &&
          $this->getRequestParameter('filter_date') == '0')
      {
        $this->redirect('@monitoring_news?user_token=' . $this->getUser()->getToken());
      }
    }

    // legge sempre i filtri dalla sessione utente
    $filters['tag_id'] = $this->session->getAttribute('tag_id', '0', 'monitoring_filter');
    $filters['act_type_id'] = $this->session->getAttribute('act_type_id', '0', 'monitoring_filter');
    $filters['act_ramo'] = $this->session->getAttribute('act_ramo', '0', 'monitoring_filter');
    $filters['date'] = $this->session->getAttribute('date', '0', 'monitoring_filter');

    // fetch degli oggetti monitorati (se c'è il filtro sui tag, fetch solo di quelli associati a questo tag)
    if ($filters['tag_id'] != '0')
    {
      $filter_criteria = new Criteria();
      $filter_criteria->add(TagPeer::ID, $filters['tag_id']);
      $monitored_objects = $this->user->getMonitoredObjects('Tag', $filter_criteria);
    } else
      $monitored_objects = $this->user->getMonitoredObjects();

    // criterio di selezione delle news dagli oggetti monitorati    
    $c = NewsPeer::getMyMonitoredItemsNewsCriteria($monitored_objects);
    
    // eliminazione delle notizie relative agli oggetti bookmarkati negativamente (bloccati)
    $blocked_items_ids = sfBookmarkingPeer::getAllNegativelyBookmarkedIds($this->user_id);
    if (array_key_exists('OppAtto', $blocked_items_ids) && count($blocked_items_ids['OppAtto']))
    {
      $blocked_news_ids = array();
      $bc = new Criteria();
      $bc->add(NewsPeer::RELATED_MONITORABLE_MODEL, 'OppAtto');
      $bc->add(NewsPeer::RELATED_MONITORABLE_ID, $blocked_items_ids['OppAtto'], Criteria::IN);
      $bc->clearSelectColumns(); 
      $bc->addSelectColumn(NewsPeer::ID);
      $rs = NewsPeer::doSelectRS($bc);
      while ($rs->next()) {
        array_push($blocked_news_ids, $rs->getInt(1));
      }
      $c->add(NewsPeer::ID, $blocked_news_ids, Criteria::NOT_IN);
    }
    

    // aggiunta filtri su tipi di atto, ramo e data
    if ($filters['act_type_id'] != '0')
      $c->add(NewsPeer::TIPO_ATTO_ID, $filters['act_type_id']);

    if ($filters['act_ramo'] != '0')
      $c->add(NewsPeer::RAMO_VOTAZIONE, $filters['act_ramo']);

    if ($filters['date'] != '0')
      if ($filters['date'] == 'W')
      {
        $c->add(NewsPeer::CREATED_AT, date('Y-m-d H:i', strtotime('-1 week')), Criteria::GREATER_THAN);
      }
      elseif ($filters['date'] == 'M') 
      {
        $c->add(NewsPeer::CREATED_AT, date('Y-m-d H:i', strtotime('-1 month')), Criteria::GREATER_THAN);
      }

    // passa la variabile filters
    $this->filters = $filters;

    // estrae tutti gli atti monitorati dall'utente, per costruire la select
    $this->all_monitored_tags = $this->user->getMonitoredObjects('Tag');

    // estrae tutti i tipi di atti monitorati dall'utente (senza filtri), per la select
    $indirectly_monitored_acts_types = OppTipoAttoPeer::doSelectIndirectlyMonitoredByUser($this->user, $this->type);
    $directly_monitored_acts_types = OppTipoAttoPeer::doSelectDirectlyMonitoredByUser($this->user, $this->type);
    $this->all_monitored_acts_types = OppTipoAttoPeer::merge($indirectly_monitored_acts_types,
                                                             $directly_monitored_acts_types);      
    
    $this->pager = new sfPropelPager('News', sfConfig::get('app_pagination_limit'));
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
  	$this->pager->init();
  }
  
  public function executeFavouriteActs()
  {
    // embed javascripts for advanced javascripts
    $response = sfContext::getInstance()->getResponse();
    $response->addJavascript('jquery.js');
    
    // calcola l'utente e l'id
    $this->user_id = $this->getUser()->getId();
    $this->user = OppUserPeer::retrieveByPK($this->user_id);
    
    // estrae gli atti favoriti
    $this->favourite_acts = sfBookmarkingPeer::getAllPositivelyBookmarked($this->user_id);
  }

  public function executeBlockedActs()
  {
    // embed javascripts for advanced javascripts
    $response = sfContext::getInstance()->getResponse();
    $response->addJavascript('jquery.js');
    
    // calcola l'utente e l'id
    $this->user_id = $this->getUser()->getId();
    $this->user = OppUserPeer::retrieveByPK($this->user_id);
    
    // estrae gli atti favoriti
    $this->blocked_acts = sfBookmarkingPeer::getAllNegativelyBookmarked($this->user_id);    
  }
  
  public function executeActs()
  {
    $this->user_id = $this->getUser()->getId();
    $this->user = OppUserPeer::retrieveByPK($this->user_id);
    $this->session = $this->getUser();

    // legge i filtri dalla request
    $filters = array();
    if ($this->getRequest()->getMethod() == sfRequest::POST) 
    {
      // legge i filtri dalla request e li scrive nella sessione utente
      if ($this->hasRequestParameter('filter_tag_id'))
      {
        $this->session->setAttribute('tag_id', $this->getRequestParameter('filter_tag_id'), 'monitoring_filter');
        $this->filter_tag = TagPeer::retrieveByPK($filters['tag_id']);        
      }

      if ($this->hasRequestParameter('filter_act_type_id'))
        $this->session->setAttribute('act_type_id', $this->getRequestParameter('filter_act_type_id'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_act_ramo'))
        $this->session->setAttribute('act_ramo', $this->getRequestParameter('filter_act_ramo'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_act_stato'))
        $this->session->setAttribute('act_stato', $this->getRequestParameter('filter_act_stato'), 'monitoring_filter');

      if ($this->getRequestParameter('filter_tag_id') == '0' &&
          $this->getRequestParameter('filter_act_type_id') == '0' &&
          $this->getRequestParameter('filter_act_ramo') == '0')
      {
        $this->redirect('monitoring/acts');
      }

    }

    // legge sempre i filtri dalla sessione utente
    $filters['tag_id'] = $this->session->getAttribute('tag_id', '0', 'monitoring_filter');
    $filters['act_type_id'] = $this->session->getAttribute('act_type_id', '0', 'monitoring_filter');
    $filters['act_ramo'] = $this->session->getAttribute('act_ramo', '0', 'monitoring_filter');
    $filters['act_stato'] = $this->session->getAttribute('act_stato', '0', 'monitoring_filter');


    // definisce il criterio di filtri sui tag
    if ($filters['tag_id'] != '0')
    {
      $tag_filtering_criteria = new Criteria();
      $tag_filtering_criteria->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
      $tag_filtering_criteria->add(TagPeer::ID, $filters['tag_id']);
    } else
      $tag_filtering_criteria = null;

    // estrae tutti gli atti monitorati dall'utente, per costruire la select
    $this->all_monitored_tags = $this->user->getMonitoredObjects('Tag');
    
    // estrae gli atti monitorati, con l'eventuale filtro
    $this->my_monitored_tags_pks = $this->user->getMonitoredPks('Tag', $tag_filtering_criteria);


    // estrae tutti i tipi di atti monitorati dall'utente (senza filtri), per la select
    $indirectly_monitored_acts_types = OppTipoAttoPeer::doSelectIndirectlyMonitoredByUser($this->user, $this->type);
    $directly_monitored_acts_types = OppTipoAttoPeer::doSelectDirectlyMonitoredByUser($this->user, $this->type);

    $this->all_monitored_acts_types = OppTipoAttoPeer::merge($indirectly_monitored_acts_types,
                                                             $directly_monitored_acts_types);      

    // filtro sui tipi di atti
    if ($filters['act_type_id'] != 0)
    {
      $this->monitored_acts_types = array(OppTipoAttoPeer::retrieveByPK($filters['act_type_id']));
    } else {
      $indirectly_monitored_acts_types = OppTipoAttoPeer::doSelectIndirectlyMonitoredByUser($this->user,
         $this->type, $tag_filtering_criteria);

      if (is_null($tag_filtering_criteria))
        $directly_monitored_acts_types = OppTipoAttoPeer::doSelectDirectlyMonitoredByUser($this->user,
           $this->type);
      else
        $directly_monitored_acts_types = array();

      $this->monitored_acts_types = OppTipoAttoPeer::merge($indirectly_monitored_acts_types,
         $directly_monitored_acts_types);      
    }

    $this->filters = $filters;
    
    $this->tag_filtering_criteria = $tag_filtering_criteria;
  }

  public function executePoliticians()
  {
    // embed javascripts for advanced javascripts
    $response = sfContext::getInstance()->getResponse();
    $response->addJavascript('jquery.js');

    // fetch current user profile
    $this->user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    $this->my_last_login = $this->getUser()->getAttribute('last_login', null, 'subscriber');
    $this->monitored_politicians = $this->user->getMonitoredObjects('OppPolitico');
  }

  public function executeTags()
  { 
    // embed javascripts for advanced javascripts
    $response = sfContext::getInstance()->getResponse();
    $response->addJavascript('prototype.js');
    $response->addJavascript('effects.js');
    $response->addJavascript('controls.js');
    
    // fetch current user profile
    $this->opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
 
    // fetch teseo top_terms
    $this->teseo_tts = OppTeseottPeer::doSelect(new Criteria());
    
    // fetch tags I am monitoring
    $this->my_tags = self:: _getMyTags();
  }

  public function executeAjaxTagsForTopTerm()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    $this->my_tags = self::_getMyTags();
    
    $top_term_id = $this->getRequestParameter('tt_id');
    $this->tags = OppTeseottPeer::retrieveTagsFromTTPK($top_term_id);
  }

  public function executeAjaxNewsForAct()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    $this->act_id = $this->getRequestParameter('act_id');
    $this->_fetchNewsForItem('OppAtto', $this->act_id);
  }

  public function executeAjaxNewsForPolitician()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    $this->politician_id = $this->getRequestParameter('politician_id');
    $this->_fetchNewsForItem('OppPolitico', $this->politician_id);
  }

  private function _fetchNewsForItem($type, $item_id)
  {
    $n_news = NewsPeer::countNewsForItem($type, $item_id);
    
    $c = NewsPeer::getNewsForItemCriteria($type, $item_id);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);
    $c->setLimit(sfConfig::get('app_news_dropdown_limit', 10));
    $this->news = NewsPeer::doSelect($c);

    $this->has_more = 0;
    if ($n_news > count($this->news))
      $this->has_more = $n_news;    
  }

  public function executeAjaxAddTagIdToMyMonitoredTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    // fetch current user profile
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    

    // fetch the tag to add
    $tag_id = $this->getRequestParameter('tag_id');
    $tag = TagPeer::retrieveByPK($tag_id);
    
    $this->_addTagToMyMonitoredTags($tag, $opp_user);
  }

  public function executeAjaxAddTagValueToMyMonitoredTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    // if (!$isAjax) return sfView::noAjax;

    // fetch current user profile
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());

    // fetch the tag to add
    $tag_value = $this->getRequestParameter('tag_value');
    $tag = TagPeer::retrieveFirstByTripleValue($tag_value);

    $this->_addTagToMyMonitoredTags($tag, $opp_user);
  }

  protected function _addTagToMyMonitoredTags($tag, $opp_user)
  {
    // check if the user can add a new tag to the monitored pool
    $this->remaining_tags = $opp_user->getNMaxMonitoredTags() - $opp_user->countMonitoredObjects('Tag');
    if ($this->remaining_tags == 0){
      $this->renderText('Hai terminato i tag monitorabili, acquistane di più!');
      return sfView::NONE;
    }

    // add the tag to the monitorable pool
    $tag->addMonitoringUser($this->getUser()->getId());

    // decrease the number of tags the user can add
    $this->remaining_tags --;
    
    // fetch the monitored pool
    $this->my_tags = self::_getMyTags();
    $this->setTemplate('ajaxMyTags');
    
    // a tag was added, clear the cache for the news, acts and tags page
    $cacheManager = $this->getContext()->getViewCacheManager(); 
    if (!is_null($cache_manager))
    {
      $cacheManager->remove('monitoring/news?user_token='.$this->getUser()->getToken()); 
      $cacheManager->remove('monitoring/acts?user_token='.$this->getUser()->getToken()); 
      $cacheManager->remove('monitoring/tags?user_token='.$this->getUser()->getToken());       
    }
  }
  

  public function executeAjaxRemoveTagFromMyMonitoredTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    // if (!$isAjax) return sfView::noAjax;

    // remove the tag from the monitored pool
    $tag_id = $this->getRequestParameter('tag_id');
    $tag = TagPeer::retrieveByPK($tag_id);
    $tag->removeMonitoringUser($this->getUser()->getId());

    // fetch current user profile and the number of tags the user can still add to the pool
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    $this->remaining_tags = $opp_user->getNMaxMonitoredTags() - $opp_user->countMonitoredObjects('Tag');

    // fetch the monitored pool
    $this->my_tags = self::_getMyTags();
    $this->setTemplate('ajaxMyTags');
    
    // a tag was removed, clear the cache for the news, acts and tags page
    $cacheManager = $this->getContext()->getViewCacheManager();
    if (!is_null($cacheManager))
    {
      $cacheManager->remove('monitoring/news?user_token='.$this->getUser()->getToken()); 
      $cacheManager->remove('monitoring/acts?user_token='.$this->getUser()->getToken()); 
      $cacheManager->remove('monitoring/tags?user_token='.$this->getUser()->getToken());      
    }
    
    // remove the negative bookmarking from objects indirectly monitored thanks to this tag
    $indirectly_monitored_acts = OppAttoPeer::doSelectIndirectlyMonitoredByUser($opp_user, null, null, array($tag_id));
    foreach ($indirectly_monitored_acts as $act)
    {
      $act->removeNegativeBookmarking($this->getUser()->getId());
    }
    
  }

  public function executeAjaxAddItemToMyMonitoredItems()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    // if (!$isAjax) return sfView::noAjax;
    $this->item_model = $this->getRequestParameter('item_model');
    $this->item_pk = $this->getRequestParameter('item_pk');

    $this->item = call_user_func($this->item_model . "Peer::retrieveByPK", $this->item_pk);
    
    $user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    
    
    // check limitations (unless unlimited (0))
    if ($user->getNMaxMonitoredItems() != 0)
    {
      $this->remaining_items = $user->getNMaxMonitoredItems() - 
                               $user->countMonitoredObjects('OppAtto') -
                               $user->countMonitoredObjects('OppPolitico');

      if ($this->remaining_items == 0){
        $this->renderText('Hai raggiunto il numero massimo di oggetti monitorabili, acquistane di più!');
        return sfView::NONE;
      }      
    }


    $is_monitoring = $user->isMonitoring($this->item_model, $this->item_pk);
    if (!$is_monitoring) 
    {
      $user->addMonitoredObject($this->item_model, $this->item_pk);
    }  
    $this->setTemplate('ajaxManageItem');
    
    // an item was added, clear the cache consequently
    $cacheManager = $this->getContext()->getViewCacheManager();
    if (!is_null($cacheManager))
    {
      $user_token = $this->getUser()->getToken();    
      $cacheManager->remove('monitoring/news?user_token='.$user_token); 
      if ($this->item_model == 'OppAtto')
      {
        $cacheManager->remove('monitoring/acts?user_token='.$user_token);       
      } else {
        $cacheManager->remove('monitoring/politicians?user_token='.$user_token); 
      }      
    }

    
  }
    
  public function executeAjaxRemoveItemFromMyMonitoredItems()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;
    
    $this->_removeItemFromMyMonitoredItems();
    
    $this->setTemplate('ajaxManageItem');
    
  }

  public function executeRemoveItemFromMyMonitoredItems()
  {
    $this->_removeItemFromMyMonitoredItems();
    
    // redirect back to referer
    $this->redirect($this->getRequest()->getReferer());    
  }

  private function _removeItemFromMyMonitoredItems()
  {
    $this->item_model = $this->getRequestParameter('item_model');
    $this->item_pk = $this->getRequestParameter('item_pk');
    $this->item = call_user_func($this->item_model . "Peer::retrieveByPK", $this->item_pk);

    $user = OppUserPeer::retrieveByPK($this->getUser()->getId());

    $is_monitoring = $user->isMonitoring($this->item_model, $this->item_pk);
    if ($is_monitoring) 
    {
      $user->removeMonitoredObject($this->item_model, $this->item_pk);
    } 
    
    // an item was removed, clear the cache consequently
    $cacheManager = $this->getContext()->getViewCacheManager();
    if (!is_null($cacheManager))
    {
      $user_token = $this->getUser()->getToken();
      $cacheManager->remove('monitoring/news?user_token='.$user_token); 
      if ($this->item_model == 'OppAtto')
      {
        $cacheManager->remove('monitoring/acts?user_token='.$user_token);       
      } else {
        $cacheManager->remove('monitoring/politicians?user_token='.$user_token); 
      }      
    }
         
  }
  
  // fetch tags I am monitoring
  protected static function _getMyTags()
  {
    // fetch tags I am monitoring
    $opp_user = OppUserPeer::retrieveByPK(sfContext::getInstance()->getUser()->getId());
    return $opp_user->getMonitoredObjects('Tag');    
  }
  
}
