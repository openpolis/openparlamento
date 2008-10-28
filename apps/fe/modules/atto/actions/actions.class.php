<?php

/**
 * atto actions.
 *
 * @package    openparlamento
 * @subpackage atto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class attoActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    
  }
  
  /**
  * Executes Ddl list action
  *
  */
  public function executeDdlList()
  {
    $this->pager = new sfPropelPager('OppAtto', sfConfig::get('app_pagination_limit'));
    $c = new Criteria();
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$c->add(OppAttoPeer::TIPO_ATTO_ID, 1, Criteria::EQUAL);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelect');
    $this->pager->init();

    $this->news = OppAttoPeer::doSelectNews();
  }
  
}
