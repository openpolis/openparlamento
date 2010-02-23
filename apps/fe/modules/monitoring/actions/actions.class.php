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
  
  public function preExecute()
  {
    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'module', 'module', 
                                                  array('acts_filter', 'sf_admin/opp_atto/sort',
                                                        'votes_filter', 'sf_admin/opp_votazione/sort',
                                                        'pol_camera_filter', 'pol_senato_filter', 'sf_admin/opp_carica/sort',
                                                        'argomento/atti_filter', 'argomento_leggi/sort', 'argomento_nonleg/sort'));
  }
  
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
    $this->redirectUnless($this->user instanceof OppUser, '/');
 
    $this->session = $this->getUser();
    
    $this->getResponse()->setTitle('le mie notizie - ' . sfConfig::get('app_main_title'));

    $filters = array();
    if ($this->getRequest()->getMethod() == sfRequest::POST ||
        $this->getRequest()->getMethod() == sfRequest::GET) 
    {

      // reset dei filtri se richiesto esplicitamente
      if ($this->getRequestParameter('reset_filters', 'false') == 'true')
      {
        $this->getRequest()->getParameterHolder()->set('filter_tag_id', '0');
        $this->getRequest()->getParameterHolder()->set('filter_act_type_id', '0');
        $this->getRequest()->getParameterHolder()->set('filter_act_ramo', '0');
        $this->getRequest()->getParameterHolder()->set('filter_date', '0');      
        $this->getRequest()->getParameterHolder()->set('filter_main_all', 'main');      
      }


      // legge i filtri dalla request e li scrive nella sessione utente
      if ($this->hasRequestParameter('filter_tag_id'))
        $this->session->setAttribute('tag_id', $this->getRequestParameter('filter_tag_id'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_act_type_id'))
        $this->session->setAttribute('act_type_id', $this->getRequestParameter('filter_act_type_id'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_act_ramo'))
        $this->session->setAttribute('act_ramo', $this->getRequestParameter('filter_act_ramo'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_date'))
        $this->session->setAttribute('date', $this->getRequestParameter('filter_date'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_main_all'))
        $this->session->setAttribute('main_all', $this->getRequestParameter('filter_main_all'), 'news_filter');
        
      if ($this->getRequestParameter('filter_tag_id') == '0' &&
          $this->getRequestParameter('filter_act_type_id') == '0' &&
          $this->getRequestParameter('filter_act_ramo') == '0' &&
          $this->getRequestParameter('filter_date') == '0' &&
          $this->getRequestParameter('filter_main_all') == 'main')
      {
        $this->redirect('@monitoring_news?user_token=' . $this->getUser()->getToken());
      }


    }

    // legge sempre i filtri dalla sessione utente
    $filters['tag_id'] = $this->session->getAttribute('tag_id', '0', 'monitoring_filter');
    $filters['act_type_id'] = $this->session->getAttribute('act_type_id', '0', 'monitoring_filter');
    $filters['act_ramo'] = $this->session->getAttribute('act_ramo', '0', 'monitoring_filter');
    $filters['date'] = $this->session->getAttribute('date', '0', 'monitoring_filter');
    $filters['main_all'] = $this->session->getAttribute('main_all', 'main', 'news_filter');

    // fetch degli oggetti monitorati (se c'è il filtro sui tag, fetch solo di quelli associati a questo tag)
    if ($filters['tag_id'] != '0')
    {
      $filter_criteria = new Criteria();
      $filter_criteria->add(TagPeer::ID, $filters['tag_id']);
      $monitored_objects = $this->user->getMonitoredObjects('Tag', $filter_criteria);
    } else
      $monitored_objects = $this->user->getMonitoredObjects();

    // criterio di selezione delle news dagli oggetti monitorati    
    $c = oppNewsPeer::getMyMonitoredItemsNewsCriteria($monitored_objects);
    
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
      $c0 = $c->getNewCriterion(NewsPeer::ID, $blocked_news_ids, Criteria::NOT_IN);
      $c->addAnd($c0);
    }
    
    // le news di gruppo non sono considerate, perché ridondanti (#247)
    $c->add(NewsPeer::GENERATOR_PRIMARY_KEYS, null, Criteria::ISNOTNULL);

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

    if ($filters['main_all'] == 'main')
      $c->add(NewsPeer::PRIORITY, 1);

    // passa la variabile filters
    $this->filters = $filters;

    // estrae tutti gli atti monitorati dall'utente, per costruire la select
    $this->all_monitored_tags = $this->user->getMonitoredObjects('Tag');

    // estrae tutti i tipi di atti monitorati dall'utente (senza filtri), per la select
    $indirectly_monitored_acts_types = OppTipoAttoPeer::doSelectIndirectlyMonitoredByUser($this->user, $this->type);
    $directly_monitored_acts_types = OppTipoAttoPeer::doSelectDirectlyMonitoredByUser($this->user, $this->type);
    $this->all_monitored_acts_types = OppTipoAttoPeer::merge($indirectly_monitored_acts_types,
                                                             $directly_monitored_acts_types);      
    
    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));
    
    $this->pager = new deppNewsPager('News', $itemsperpage);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
  	$this->pager->init();
  }
  
  public function executeSendNewsletter()
  {
    $user_id = $this->getRequestParameter('user_id');    
    $user = OppUserPeer::retrieveByPK($user_id);
    $news = oppNewsPeer::fetchTodayNewsForUser($user);
    
    // do not send email if no news
    if (count($news) == 0) return sfView::NONE;
    

    // class initialization
    $mail = new sfMail();
    $mail->setCharset('utf-8');      
    $mail->setContentType('text/html');

    // definition of the required parameters
    $mail->setSender(sfConfig::get('app_newsletter_sender_address', 'info@openpolis.it'), 
                     sfConfig::get('app_newsletter_from_tag', 'openparlamento bot'));
    $mail->setFrom(sfConfig::get('app_newsletter_from_address', 'no-reply@openpolis.it'), 
                   sfConfig::get('app_newsletter_from_tag', 'openparlamento bot'));

    $mail->addAddress($user->getEmail());

    $mail->setSubject('newsletter del ' . date('d/m/Y') );
                            
    // raggruppa le news per data
    $grouped_news = array();
    foreach ($news as $n)
    {
      $date = strtotime($n->getDate());
      if (!is_string($date) && !is_int($date))
        $date = 0;

      if (!array_key_exists($date, $grouped_news))
      {
        $grouped_news[$date] = array();        
      }
      $grouped_news[$date] []= $n;
    }
    krsort($grouped_news);



    $this->date = date('d/m/Y');
    $this->user = $user;
    $this->grouped_news = $grouped_news;
    $this->mail = $mail;    
    
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
  
  /**
   * acts list grouped by types
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function executeActs()
  {
    $this->user_id = $this->getUser()->getId();
    $this->user = OppUserPeer::retrieveByPK($this->user_id);
    $this->redirectUnless($this->user instanceof OppUser, '/');

    $this->session = $this->getUser();
    
    $this->getResponse()->setTitle(sfConfig::get('app_main_title') . ' - i miei atti');


    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_tag_id', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_type_id', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_stato', '0');
    }


    // legge i filtri dalla request
    $filters = array();
    if ($this->getRequest()->getMethod() == sfRequest::POST ||
        $this->getRequest()->getMethod() == sfRequest::GET) 
    {
      // legge i filtri dalla request e li scrive nella sessione utente
      if ($this->hasRequestParameter('filter_tag_id'))
      {
        $this->session->setAttribute('tag_id', $this->getRequestParameter('filter_tag_id'), 'monitoring_filter');
        // $this->filter_tag = TagPeer::retrieveByPK($filters['tag_id']);        
      }

      if ($this->hasRequestParameter('filter_act_type_id'))
        $this->session->setAttribute('act_type_id', $this->getRequestParameter('filter_act_type_id'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_act_ramo'))
        $this->session->setAttribute('act_ramo', $this->getRequestParameter('filter_act_ramo'), 'monitoring_filter');

      if ($this->hasRequestParameter('filter_act_stato'))
        $this->session->setAttribute('act_stato', $this->getRequestParameter('filter_act_stato'), 'monitoring_filter');

      if ($this->getRequestParameter('filter_tag_id') == '0' &&
          $this->getRequestParameter('filter_act_type_id') == '0' &&
          $this->getRequestParameter('filter_act_ramo') == '0' &&
          $this->getRequestParameter('filter_act_stato') == '0')          
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
  	
    $this->getResponse()->setTitle(sfConfig::get('app_main_title') . ' - i miei parlamentari');
    	
    // embed javascripts for advanced javascripts
    $response = sfContext::getInstance()->getResponse();
    $response->addJavascript('jquery.js');

    // fetch current user profile
    $this->user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    $this->redirectUnless($this->user instanceof OppUser, '/');

    $this->my_last_login = $this->getUser()->getAttribute('last_login', null, 'subscriber');
    $this->monitored_politicians = $this->user->getMonitoredObjects('OppPolitico');
  }

  public function executeTags()
  { 
    
    $this->getResponse()->setTitle(sfConfig::get('app_main_title') . ' - i miei argomenti');
    
    // embed javascripts for advanced javascripts
    $response = sfContext::getInstance()->getResponse();

    // fetch current user profile
    $this->opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    $this->redirectUnless($this->opp_user instanceof OppUser, '/');
 
    // fetch teseo top_terms and add monitoring info
    $teseo_tts_with_counts = OppTeseottPeer::getAllWithCount();
    foreach ($teseo_tts_with_counts as $term_id => $term_data)
    {
      $teseo_tts_with_counts[$term_id]['n_monitored'] = OppTeseottPeer::countTagsUnderTermMonitoredByUser($term_id, $this->opp_user->getId());
    }
    $this->teseo_tts_with_counts = $teseo_tts_with_counts;
    
    // get user's monitored tags as a cloud
    $c = new Criteria();
    $c->add(TagPeer::ID, $this->opp_user->getMonitoredPks('Tag'), Criteria::IN);
    $this->my_tags = TagPeer::getPopulars($c);
    $this->remaining_tags = $this->opp_user->getNMaxMonitoredTags() -
                            $this->opp_user->countMonitoredObjects('Tag');
    
  }
  
  public function executeAddAlert()
  {
    // fetch current user profile
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    $this->forward404Unless($opp_user instanceof OppUser);

    // read term from request parameters
    $term = $this->getRequestParameter('term');
    $this->forward404Unless($term);


    // check limitations (for non-adhoc subscribers)
    if (!$this->getUser()->hasCredential('adhoc'))
    {
      $monitored = $opp_user->getNAlerts();
      $this->remaining_items = $opp_user->getNMaxMonitoredAlerts() - $monitored;          

      if ($this->remaining_items <= 0){
        $this->getUser()->setAttribute('page_before_buy', $this->getRequest()->getReferer());

        // costruzione del messaggio flash
        $this->_build_flash_message('OppAlertUser');
        
        // redirect
        $this->redirect('@sottoscrizioni_pro');
      }      
    }

    $res = OppAlertUserPeer::addAlert($term, $opp_user);
    if ($res == false)
      $this->setFlash('warning', "stai gi&agrave; monitorando l'espressione <i>$term</i>");
    else
      $this->setFlash('notice', "da questo momento, stai monitorando l'espressione <i>$term</i>");
    
    // redirect to the referrer page
    $this->redirect($this->getRequest()->getReferer());      
  }

  public function executeDelAlert()
  {
    // fetch current user profile
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    $this->forward404Unless($opp_user instanceof OppUser);

    // read term from request parameters
    $term = $this->getRequestParameter('term');
    $this->forward404Unless($term);

    $res = OppAlertUserPeer::delAlert($term, $opp_user);
    $this->forward404Unless($res);
      
    $this->redirect('@monitoring_alerts?user_token='.$this->getUser()->getToken());
    
  }
   
  public function executeAlerts()
  {
    // fetch my alerts
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    $this->redirectUnless($opp_user instanceof OppUser, '/');
    $this->alerts = OppAlertUserPeer::fetchUserAlerts($opp_user);
  }

  public function executeSendAlerts()
  {
    $user_id = $this->getRequestParameter('user_id');    
    $this->user = OppUserPeer::retrieveByPK($user_id);
    $this->sf_site_url = sfConfig::get('sf_site_url', 'openparlamento');
    $this->user_token = $this->user->getToken();
    $this->user_alerts = oppAlertingTools::getUserAlerts($this->user, sfConfig::get('app_alert_max_results', 50));
    $this->n_alerts = OppAlertUserPeer::countUserAlerts($this->user);
    $this->n_total_notifications = oppAlertingTools::countTotalAlertsNotifications($this->user_alerts);
    
    // do not send email if no news
    if ($this->n_alerts == 0) return sfView::NONE;
    
    // mail class initialization
    $mail = new sfMail();
    $mail->setCharset('utf-8');      
    $mail->setContentType('text/html');

    // definition of the required parameters for the mail
    $mail->setSender(sfConfig::get('app_newsletter_sender_address', 'info@openpolis.it'), 
                     sfConfig::get('app_newsletter_from_tag', 'openparlamento bot'));
    $mail->setFrom(sfConfig::get('app_newsletter_from_address', 'no-reply@openpolis.it'), 
                   sfConfig::get('app_newsletter_from_tag', 'openparlamento bot'));
    $mail->addAddress($this->user->getEmail());

    // alert utente espansi per il subject della mail
    $user_alerts_expanded = join(", ", array_map('extractTerm', array_slice($this->user_alerts, 0, 3))) . 
                            ($this->n_alerts > 3?',...':'') ;
    
    $subj = sprintf("%d %s per %s che stai monitorando (%s) ", 
                    $this->n_total_notifications, $this->n_total_notifications==1?'avviso':'avvisi',
                    $this->n_alerts==1?'il termine':'i ' .$this->n_alerts.' termini',
                    $user_alerts_expanded);

    $mail->setSubject($subj);

    $this->mail = $mail;
    
    // set the last_alerted_at field to now in the opp_user table
    $this->user->setLastAlertedAt(date('Y-m-d H:i'));
    $this->user->save();
  }
  

  public function extractTerm($value='')
  {
    return $value['term'];
  }

  public function executeAjaxTagsForTopTerm()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    
    $c = new Criteria();
    $c->add(TagPeer::ID, $opp_user->getMonitoredPks('Tag'), Criteria::IN);
    $this->my_tags = TagPeer::getPopulars($c);
    
    $top_term_id = $this->getRequestParameter('tt_id');

    $c = new Criteria();
    $c->add(OppTagHasTtPeer::TESEOTT_ID, $top_term_id);
    $c->addJoin(OppTagHasTtPeer::TAG_ID, TagPeer::ID);
    $this->tags = TagPeer::getPopulars($c);
    
  }

  public function executeAjaxNewsForItem()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    $this->item_id = $this->getRequestParameter('item_id');
    $this->item_model = $this->getRequestParameter('item_model');
    $this->all_news_route = $this->getRequestParameter('all_news_route');
    $this->_fetchNewsForItem($this->item_model, $this->item_id);
  }

  private function _fetchNewsForItem($item_model, $item_id)
  {
    $n_news = NewsPeer::countNewsForItem($item_model, $item_id);
    
    $c = NewsPeer::getNewsForItemCriteria($item_model, $item_id);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);
    $c->setLimit(sfConfig::get('app_news_dropdown_limit', 10));
    $news = NewsPeer::doSelect($c);

    $grouped_news = array();
    foreach ($news as $n)
    {
      $date = strtotime($n->getDate());
      if ((is_string($date) || is_integer($date)) && !array_key_exists($date, $grouped_news))
      {
        $grouped_news[$date] = array();
      } else {
        $grouped_news['nessuna data'] = array();        
      }
      $grouped_news[$date] []= $n;
    }
    krsort($grouped_news);
    $this->grouped_news = $grouped_news;

    $this->has_more = 0;
    if ($n_news > count($news))
      $this->has_more = $n_news;    
  }

  public function executeAddTagToMyMonitoredTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();

    // fetch current user profile
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());

    // fetch the tag to add
    $tag_name = $this->getRequestParameter('name');
    $tag = TagPeer::retrieveByTagname($tag_name);

    // try to add tag to my monitored tags or redirect to buypage if limit reached
    if ($this->_addTagToMyMonitoredTags($tag, $opp_user) == -1)
    {
        $this->getUser()->setAttribute('page_before_buy', $this->getRequest()->getReferer());
        
        // costruisce il messaggio flash
        $this->_build_flash_message('Tag');
        
        $this->redirect('@sottoscrizioni_pro');
    }

    // a tag was added, clear the cache for the news, acts and tags page
    $cacheManager = $this->getContext()->getViewCacheManager(); 
    if (!is_null($cacheManager))
    {
      $cacheManager->remove('monitoring/news?user_token='.$this->getUser()->getToken()); 
      $cacheManager->remove('monitoring/acts?user_token='.$this->getUser()->getToken()); 
      $cacheManager->remove('monitoring/tags?user_token='.$this->getUser()->getToken());       
    }

    if ($isAjax)
      $this->setTemplate('ajaxMyTags');
    else
      $this->redirect('monitoring/tags?usr_token='.$this->getUser()->getToken());
  }

  public function executeAddTagValueToMyMonitoredTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();

    // fetch current user profile
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());

    // fetch the tag to add
    $tag_value = $this->getRequestParameter('tag_value');
    $tag = TagPeer::retrieveFirstByTripleValue($tag_value);

    // try to add tag to my monitored tags or redirect to buypage if limit reached
    if ($this->_addTagToMyMonitoredTags($tag, $opp_user) == -1)
    {
        $this->getUser()->setAttribute('page_before_buy', $this->getRequest()->getReferer());
        $this->redirect('@sottoscrizioni_pro');
    }
    
    // a tag was added, clear the cache for the news, acts and tags page
    $cacheManager = $this->getContext()->getViewCacheManager(); 
    if (!is_null($cacheManager))
    {
      $cacheManager->remove('monitoring/news?user_token='.$this->getUser()->getToken()); 
      $cacheManager->remove('monitoring/acts?user_token='.$this->getUser()->getToken()); 
      $cacheManager->remove('monitoring/tags?user_token='.$this->getUser()->getToken());       
    }

    if ($isAjax)
      $this->setTemplate('ajaxMyTags');
    else
      $this->redirect('monitoring/tags?usr_token='.$this->getUser()->getToken());
  }

  /**
   * add the specified tag to my monitored tags
   *
   * @param string $tag 
   * @param string $opp_user 
   * @return integer the number of remaining tags or -1 if the limit was already passed
   * @author Guglielmo Celata
   */
  protected function _addTagToMyMonitoredTags($tag, $opp_user)
  {
    // check if the user can add a new tag to the monitored pool
    if (!$this->getUser()->hasCredential('adhoc'))
    {
      $remaining_tags = $opp_user->getNMaxMonitoredTags() - $opp_user->countMonitoredObjects('Tag');
      if ($remaining_tags <= 0)
        return -1;      
    }

    // add the tag to the monitorable pool
    if ($tag instanceof Tag)
      $tag->addMonitoringUser($this->getUser()->getId());
    else
      return 0;

    if ($this->getUser()->hasCredential('adhoc'))
      return 0;
    else
      $remaining_tags -1;
  }
  

  public function executeRemoveTagFromMyMonitoredTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();

    // remove the tag from the monitored pool
    $tag_name = $this->getRequestParameter('name');
    $tag = TagPeer::retrieveByTagname($tag_name);
    $tag->removeMonitoringUser($this->getUser()->getId());

    // fetch current user profile and the number of tags the user can still add to the pool
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    $this->remaining_tags = $opp_user->getNMaxMonitoredTags() - $opp_user->countMonitoredObjects('Tag');

    // fetch the monitored pool
    $c = new Criteria();
    $c->add(TagPeer::ID, $opp_user->getMonitoredPks('Tag'), Criteria::IN);
    $this->my_tags = TagPeer::getPopulars($c, array('limit' => 10 ));
    
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

    if ($isAjax)
      $this->setTemplate('ajaxMyTags');
    else
      $this->redirect('monitoring/tags?usr_token='.$this->getUser()->getToken());

    
  }

  public function executeAddItemToMyMonitoredItems()
  {
    $this->item_model = $this->getRequestParameter('item_model');
    $this->item_pk = $this->getRequestParameter('item_pk');

    $this->item = call_user_func($this->item_model . "Peer::retrieveByPK", $this->item_pk);
    
    $user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    
    // check limitations (for non-adhoc subscribers)
    if (!$this->getUser()->hasCredential('adhoc'))
    {
      if ($this->item_model == 'OppAtto' || $this->item_model == 'OppPolitico')
      {
        $monitored = $user->countMonitoredObjects('OppAtto') + $user->countMonitoredObjects('OppPolitico');
        $this->remaining_items = $user->getNMaxMonitoredItems() - $monitored;          
      } else {
        $monitored = $user->countMonitoredObjects('Tag');
        $this->remaining_items = $user->getNMaxMonitoredTags() - $monitored;         
      }

      if ($this->remaining_items <= 0){
        $this->getUser()->setAttribute('page_before_buy', $this->getRequest()->getReferer());

        // costruzione del messaggio flash
        $this->_build_flash_message($this->item_model);
        
        // redirect
        $this->redirect('@sottoscrizioni_pro');
      }      
    }


    $is_monitoring = $user->isMonitoring($this->item_model, $this->item_pk);
    if (!$is_monitoring) 
    {
      $user->addMonitoredObject($this->item_model, $this->item_pk);
    }  
    
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

    // redirect to the referrer page
    $this->redirect($this->getRequest()->getReferer());
    
  }


  protected function _build_flash_message($item_model)
  {
    if ($this->getUser()->hasCredential('premium'))
      $user_type = 'premium';
    else
      $user_type = 'civicus';
    
    switch ($item_model)
    {
      case 'Tag':
        $objs_type = 'tags';
        break;
      case 'OppAtto':
        $objs_type = 'attos';
        break;
      case 'OppPolitico':
        $objs_type = 'politicos';
        break;
      case 'OppAlertUser':
        $objs_type = 'alerts';
        break;
      
    }

    $this->setFlash('subscription_limit_reached', 
                    sfConfig::get('app_subscription_'.$user_type.'_limit_reached_'.$objs_type));  
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

  public function executeSearch()
  {
    # code...
  }

  
}
