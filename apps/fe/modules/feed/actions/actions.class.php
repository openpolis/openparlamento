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


  public function executeLastAtto()
  {
    $id = $this->getRequestParameter('id');
    $atto = OppAttoPeer::retrieveByPk($id);
    $this->forward404Unless($atto instanceof OppAtto);

    $feed = $this->_make_feed_from_pager(
      'Ultime per ' . Text::denominazioneAttoShort($atto), 
      '@singolo_atto?id='.$id, 
      $this->_get_newspager_from_criteria(
        NewsPeer::getNewsForItemCriteria('OppAtto', $id)
      )
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }
  
  public function executeLastPolitico()
  {
    $id = $this->getRequestParameter('id');
    $politico = OppPoliticoPeer::retrieveByPk($id);
    $this->forward404Unless($politico instanceof OppPolitico);

    $feed = $this->_make_feed_from_pager(
      'Ultime per ' . $politico, 
      '@parlamentare?id='.$id, 
      $this->_get_newspager_from_criteria(
        NewsPeer::getNewsForItemCriteria('OppPolitico', $id)
      )
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }
  
  public function executeLastGeneric()
  {
    $feed = $this->_make_feed_from_pager(
      'Ultime dal Parlamento', 
      '@news_home', 
      $this->_get_newspager_from_criteria(
        NewsPeer::getHomeNewsCriteria()
      )
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }

  public function executeLastDisegni()
  {
    $feed = $this->_make_feed_from_pager(
      'Ultime dal Parlamento, relative ai Disegni di Legge',
      '@news_attiDisegni',
      $this->_get_newspager_from_criteria(
        NewsPeer::getAttiListNewsCriteria(NewsPeer::ATTI_DDL_TIPO_IDS)
      )
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }

  public function executeLastDecreti()
  {
    $feed = $this->_make_feed_from_pager(
      'Ultime dal Parlamento, relative ai Decreti Legge', 
      '@news_attiDecreti',
      $this->_get_newspager_from_criteria(
        NewsPeer::getAttiListNewsCriteria(NewsPeer::ATTI_DECRETI_TIPO_IDS)
      )
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }

  public function executeLastDecretiLegislativi()
  {
    $feed = $this->_make_feed_from_pager(
      'Ultime dal Parlamento, relative ai Decreti Legislativi', 
      '@news_attiDecretiLegislativi',
      $this->_get_newspager_from_criteria(
        NewsPeer::getAttiListNewsCriteria(NewsPeer::ATTI_DECRETI_LEGISLATIVI_TIPO_IDS)
      )
    );
    $this->_send_output($feed);
    return sfView::NONE;    
  }
  
  public function executeLastAttiNonLegislativi()
  {
    $feed = $this->_make_feed_from_pager(
      'Ultime dal Parlamento, relative agli atti non legislativi', 
      '@news_attiNonLegislativi',
      $this->_get_newspager_from_criteria(
        NewsPeer::getAttiListNewsCriteria(NewsPeer::ATTI_NON_LEGISLATIVI_TIPO_IDS)
      )
    );
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
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();    
    return $pager;
  }

  protected function _make_feed_from_pager($title, $link, $pager)
  {
    setlocale(LC_TIME, 'it_IT');
    sfLoader::loadHelpers(array('Tag', 'Url', 'DeppNews'));
    
    $feed = sfFeedPeer::newInstance('rss201');
    $feed->initialize(array(
      'title'       => $title,
      'link'        => $link,
      'authorEmail' => 'info@openparlamento.it',
      'authorName'  => 'Openparlamento'
    ));

    foreach ($pager->getGroupedResults() as $date_ts => $news)
    {
      $item = new sfFeedItem( array(
        'title' => 'Notizie del ' . strftime("%d %B", $date_ts),
        'link'  => $link,
        'pubDate' => date("U", $date_ts),
        'uniqueId' => $date_ts,
        'description' => news_list($news),
        
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
      $news_list .= strip_tags(html_entity_decode(news_text($n), ENT_COMPAT, 'UTF-8')) . "\n";
    }

    return $news_list . "\n\n"; 
  }


}
