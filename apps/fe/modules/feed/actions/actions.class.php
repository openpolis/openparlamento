<?php

/**
 * feed actions.
 *
 * @package    op_openparlamento
 * @subpackage feed
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class feedActions extends sfActions
{


  public function executeUserNews()
  {
    
    $this->session = $this->getUser();
    
    // legge sempre i filtri dalla sessione utente
    $filters['tag_id'] = $this->session->getAttribute('tag_id', '0', 'monitoring_filter');
    $filters['act_type_id'] = $this->session->getAttribute('act_type_id', '0', 'monitoring_filter');
    $filters['act_ramo'] = $this->session->getAttribute('act_ramo', '0', 'monitoring_filter');
    $filters['date'] = $this->session->getAttribute('date', '0', 'monitoring_filter');
    $filters['main_all'] = $this->session->getAttribute('main_all', 'main', 'news_filter');

    $token = $this->getRequestParameter('token');

    // se utente non loggato, cerca l'id con il token
    if (!$this->session->isAuthenticated())
    {
      $remote_guard_host = sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it' ); 
      $key = sfConfig::get('sf_internal_api_key', 'XXX');
      $api_uri = "http://$remote_guard_host/index.php/getUserIdFromToken/$token/$key";
      $xml = simplexml_load_file($api_uri);
      if ($xml->user instanceof SimpleXMLElement && $xml->user->asXML() != '')
      {
    	  $user_id = $xml->user->id;
      } else {
        $this->forward404("Utente non loggato e token non riconosciuto: $api_uri");
      }      
    } else 
      $user_id = $this->session->getId();
    
    $user = OppUserPeer::retrieveByPK($user_id);
    
    // costruisce criterio di fetch delle news relative agli oggetti monitorati, con filtro
    $c = oppNewsPeer::getMyMonitoredItemsNewsWithFiltersCriteria($user, $filters);
    $c->setLimit(50);

    $this->pager = new deppNewsPager('News', 50);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->init();      

    $feed = $this->_make_feed_from_pager(
      'Ultime notizie per te', 
      '@monitoring_news?user_token=' . $this->getUser()->getToken(), 
      $this->pager
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }

  public function executeLastAtto()
  {
    $id = $this->getRequestParameter('id');
    $atto = OppAttoPeer::retrieveByPk($id);
    $this->forward404Unless($atto instanceof OppAtto);
    
    $c = oppNewsPeer::getNewsForItemCriteria('OppAtto', $id);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);

    $feed = $this->_make_feed_from_pager(
      'Ultime per ' . Text::denominazioneAttoShort($atto), 
      '@singolo_atto?id='.$id, 
      $this->_get_newspager_from_criteria($c)
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }
  
  public function executeLastPolitico()
  {
    $id = $this->getRequestParameter('id');
    $politico = OppPoliticoPeer::retrieveByPk($id);
    $this->forward404Unless($politico instanceof OppPolitico);
    
    $c =  oppNewsPeer::getNewsForItemCriteria('OppPolitico', $id);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);

    $feed = $this->_make_feed_from_pager(
      'Ultime per ' . $politico, 
      '@parlamentare?id='.$id, 
      $this->_get_newspager_from_criteria($c),
      2 // CONTEXT_POLITICO
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }

  public function executeLastPoliticoRadicali()
  {
    $id = $this->getRequestParameter('id');
    $politico = OppPoliticoPeer::retrieveByPk($id);
    $this->forward404Unless($politico instanceof OppPolitico);
    
    $c =  oppNewsPeer::getNewsForItemCriteria('OppPolitico', $id);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);
    $c->add(NewsPeer::GENERATOR_PRIMARY_KEYS, null, Criteria::ISNOTNULL);
    $c->setLimit(30);
    $news = oppNewsPeer::doSelect($c);

    $feed = $this->_make_feed_from_news(
      'Ultime per ' . $politico, 
      '@parlamentare?id='.$id, 
      $news, 
      2 // CONTEXT_POLITICO
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }
  
  public function executeLastGeneric()
  {
    $c = oppNewsPeer::getHomeNewsCriteria();
    $c->addDescendingOrderByColumn(NewsPeer::DATE);
    
    $feed = $this->_make_feed_from_pager(
      'Ultime dal Parlamento', 
      '@news_home', 
      $this->_get_newspager_from_criteria($c)
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }

  public function executeLastDisegni()
  {
    $c = oppNewsPeer::getAttiListNewsCriteria(oppNewsPeer::ATTI_DDL_TIPO_IDS);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);
    
    $feed = $this->_make_feed_from_pager(
      'Ultime dal Parlamento, relative ai Disegni di Legge',
      '@news_attiDisegni',
      $this->_get_newspager_from_criteria($c)
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }

  public function executeLastDecreti()
  {
    $c = oppNewsPeer::getAttiListNewsCriteria(oppNewsPeer::ATTI_DECRETI_TIPO_IDS);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);
     
    $feed = $this->_make_feed_from_pager(
      'Ultime dal Parlamento, relative ai Decreti Legge', 
      '@news_attiDecreti',
      $this->_get_newspager_from_criteria($c)
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }

  public function executeLastDecretiLegislativi()
  {
    $c = oppNewsPeer::getAttiListNewsCriteria(oppNewsPeer::ATTI_DECRETI_LEGISLATIVI_TIPO_IDS);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);
    
    $feed = $this->_make_feed_from_pager(
      'Ultime dal Parlamento, relative ai Decreti Legislativi', 
      '@news_attiDecretiLegislativi',
      $this->_get_newspager_from_criteria($c)
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }
  
  public function executeLastAttiNonLegislativi()
  {
    $c = oppNewsPeer::getAttiListNewsCriteria(oppNewsPeer::ATTI_NON_LEGISLATIVI_TIPO_IDS);
    $c->addDescendingOrderByColumn(NewsPeer::DATE);
    
    $feed = $this->_make_feed_from_pager(
      'Ultime dal Parlamento, relative agli atti non legislativi', 
      '@news_attiNonLegislativi',
      $this->_get_newspager_from_criteria($c)
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }
  

  public function executeAttiInEvidenza()
  {
    $namespace = $this->getRequestParameter('namespace');
    
    setlocale(LC_TIME, 'it_IT');
    sfLoader::loadHelpers(array('Tag', 'Url', 'DeppNews'));
    
    $feed = new sfRss2ExtendedFeed();
    $feed->initialize(array(
      'title'       => 'Atti in evidenza',
      'link'        => url_for('@homepage', true),
      'feedUrl'     => $this->getRequest()->getURI(),
      'siteUrl'     => 'http://' . sfConfig::get('sf_site_url'),
      'image'       => 'http://' . sfConfig::get('sf_site_url') . '/images/logo-openparlamento.png',
      'language'    => 'it',
      'authorEmail' => 'info@openparlamento.it',
      'authorName'  => 'Openparlamento',
      'description' => "Openparlamento.it - il progetto Openpolis per la trasparenza del Parlamento",
      'sy_updatePeriod' => 'daily',
      'sy_updateFrequency' => '1',
      'sy_updateBase' => '2000-01-01T12:00+00:00'	    
    ));

    $atti = OppAttoPeer::getAttiInEvidenza($namespace);
    foreach ($atti as $atto)
    {
      $description =  $atto->getOppTipoAtto()->getDescrizione() . ($atto->getRamo()=='C' ? ' alla Camera' : ' al Senato');
    	
    	$f_signers = OppAttoPeer::doSelectPrimiFirmatari($atto->getId());
    	if (count($f_signers) > 0)
    	{
    		$c = new Criteria();
    		$c->add(OppPoliticoPeer::ID, key($f_signers));
    		$f_signer = OppPoliticoPeer::doSelectOne($c);
    		$description .= ' di ' . $f_signer->getCognome() . (count($f_signers)>1 ? ' e altri' : '');    	
    	}
      $description .= ", presentato il " . $atto->getDataPres('d/M/Y');
    	
      $item = new sfRss2ExtendedItem();
      $aggiuntivo_only = true;
      $item->initialize( array(
        'title' => Text::denominazioneAtto($atto, 'list', $aggiuntivo_only),
        'link'  => url_for('@singolo_atto?id='.$atto->getId(), true),
        'permalink' => url_for('@singolo_atto?id='.$atto->getId(), true),
        'pubDate' => $atto->getStatoLastDate('U') ? $atto->getStatoLastDate('U') : $atto->getDataPres('U'),
        'uniqueId' => $atto->getId(),
        'description' => $description,
        'authorEmail' => 'info@openparlamento.it',
        'authorName'  => 'Openparlamento',        
      ));
      $feed->addItem($item);
    }

    $this->_send_output($feed);
    return sfView::NONE;    
  }
  
  public function executeVotiInEvidenza()
  {
    $namespace = 'key';
    if ($this->hasRequestParameter('namespace'))
      $namespace = $this->getRequestParameter('namespace');
      
    
    setlocale(LC_TIME, 'it_IT');
    sfLoader::loadHelpers(array('Tag', 'Url', 'DeppNews'));
    
    $feed = new sfRss2ExtendedFeed();
    $feed->initialize(array(
      'title'       => 'Voti in evidenza',
      'link'        => url_for('@homepage', true),
      'feedUrl'     => $this->getRequest()->getURI(),
      'siteUrl'     => 'http://' . sfConfig::get('sf_site_url'),
      'image'       => 'http://' . sfConfig::get('sf_site_url') . '/images/logo-openparlamento.png',
      'language'    => 'it',
      'authorEmail' => 'info@openparlamento.it',
      'authorName'  => 'Openparlamento',
      'description' => "Openparlamento.it - il progetto Openpolis per la trasparenza del Parlamento",
      'sy_updatePeriod' => 'daily',
      'sy_updateFrequency' => '1',
      'sy_updateBase' => '2000-01-01T12:00+00:00'	    
    ));

    $voti = OppVotazionePeer::getKeyVotes(20, $namespace);
    foreach ($voti as $voto)
    {
      $description =  sprintf("%s, seduta n. %s. Esito: %s. Scarto: %d. Ribelli: %d", 
                              $voto->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato',
                              $voto->getOppSeduta()->getNumero(),
                              $voto->getEsito(),
                              $voto->getMargine(),
                              $voto->getRibelli());
    	
      $item = new sfRss2ExtendedItem();
      $aggiuntivo_only = true;
      $item->initialize( array(
        'title' => $voto->getTitoloAggiuntivo() ? $voto->getTitoloAggiuntivo() : $voto->getTitolo(),
        'link'  => sprintf("/votazioni/%s.xml", $voto->getId()),
        'permalink' => url_for('@votazione?id='.$voto->getId(), true),
        'pubDate' => $voto->getOppSeduta()->getData('U'),
        'uniqueId' => $voto->getId(),
        'description' => $description,
        'authorEmail' => 'info@openparlamento.it',
        'authorName'  => 'Openparlamento',        
      ));
      $feed->addItem($item);
    }

    $this->_send_output($feed);
    return sfView::NONE;    
  }
  
  
  
  protected function _send_output($feed)
  {
    $this->setLayout(false);    
    $this->response->setContentType('text/xml');
    $this->response->setContent($feed->asXml());
  }


  protected function _get_newspager_from_criteria( $c )
  {
    if (! $c instanceof Criteria)
      return null;
    $pager = new deppNewsPager('News', sfConfig::get('app_pagination_limit'));
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page',1));
    $pager->init();    
    return $pager;
  }

  protected function _make_feed_from_pager($title, $link, $pager, $context = null)
  {
    // setlocale(LC_TIME, 'it_IT');
    sfLoader::loadHelpers(array('Tag', 'Url', 'DeppNews'));
    
    $feed = new sfRss2ExtendedFeed();
    $feed->initialize(array(
      'title'       => $title,
      'link'        => url_for($link, true),
      'feedUrl'     => $this->getRequest()->getURI(),
      'siteUrl'     => 'http://' . sfConfig::get('sf_site_url'),
      'image'       => 'http://' . sfConfig::get('sf_site_url') . '/images/logo-openparlamento.png',
      'language'    => 'it',
      'authorEmail' => 'info@openparlamento.it',
      'authorName'  => 'Openparlamento',
      'description' => "Openparlamento.it - il progetto Openpolis per la trasparenza del Parlamento",
      'sy_updatePeriod' => 'daily',
      'sy_updateFrequency' => '1',
      'sy_updateBase' => '2000-01-01T12:00+00:00'	    
    ));

    foreach ($pager->getGroupedResults() as $date_ts => $news)
    {
      $item = new sfRss2ExtendedItem();
      $item->initialize( array(
        'title' => 'Notizie del ' . strftime("%d/%m/%Y", $date_ts),
        'link'  => url_for($link, true) . '#' . strftime('%Y%m%d%H', $date_ts),
        'permalink' => url_for($link, true) . '#' . strftime('%Y%m%d%H', $date_ts),
        'pubDate' => date("U", $date_ts),
        'uniqueId' => $date_ts,
        'description' => news_list($news, null, $context),
        'authorEmail' => 'info@openparlamento.it',
        'authorName'  => 'Openparlamento',        
      ));
      $feed->addItem($item);
    }

    return $feed;
  }


  protected function _make_feed_from_news($title, $link, $news, $context = null)
  {
    // setlocale(LC_TIME, 'it_IT');
    sfLoader::loadHelpers(array('Tag', 'Url', 'DeppNews'));
    
    $feed = new sfRss2ExtendedFeed();
    $feed->initialize(array(
      'title'       => $title,
      'link'        => url_for($link, true),
      'feedUrl'     => $this->getRequest()->getURI(),
      'siteUrl'     => 'http://' . sfConfig::get('sf_site_url'),
      'image'       => 'http://' . sfConfig::get('sf_site_url') . '/images/logo-openparlamento.png',
      'language'    => 'it',
      'authorEmail' => 'info@openparlamento.it',
      'authorName'  => 'Openparlamento',
      'description' => "Openparlamento.it - il progetto Openpolis per la trasparenza del Parlamento",
      'sy_updatePeriod' => 'daily',
      'sy_updateFrequency' => '1',
      'sy_updateBase' => '2000-01-01T12:00+00:00'	    
    ));

    foreach ($news as $n)
    {
      list ($title, $description) = news_title_descr($n, null, $context);
      $date_ts = $n->getDate(null);
      if ($title == '' && $description == '') continue;
      $item = new sfRss2ExtendedItem();
      $item->initialize( array(
        'title' => $title,
        'link'  => url_for($link, true),
        'permalink' => url_for($link, true) . '#' . strftime('%Y%m%d%H', $date_ts),
        'pubDate' => date("U", $date_ts),
        'uniqueId' => $date_ts,
        'description' => $description,
        'authorEmail' => 'info@openparlamento.it',
        'authorName'  => 'Openparlamento',        
      ));
      $feed->addItem($item);
    }

    return $feed;
  }

  
  /**
   * torna l'elenco testuale delle news passate in argomento (per feed in formato atom)
   *
   * @param string $news array di oggetti News
   * @return string html
   * @author Guglielmo Celata
   */
  protected function _news_list($news)
  {
    $news_list = '';

    foreach ($news as $n)
    {
      $news_list .= strip_tags(html_entity_decode(news_text($n,1), ENT_COMPAT, 'UTF-8')) . "\n";
    }

    return $news_list . "\n\n"; 
  }

}
