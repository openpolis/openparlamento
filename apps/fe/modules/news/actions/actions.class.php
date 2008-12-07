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
    $this->n_news = NewsPeer::countHomeNews();

    $c = NewsPeer::getHomeNewsCriteria();
    $c->addDescendingOrderByColumn(NewsPeer::DATE);

    $pager = new sfPropelPager('News', 30);
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

    $pager = new sfPropelPager('News', 50);
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

    $pager = new sfPropelPager('News', 50);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->pager = $pager;

  }
  

}
