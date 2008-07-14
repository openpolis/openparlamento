<?php

/**
 * default actions.
 *
 * @package    openparlamento
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class defaultActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->processFilters();

    $this->filters = $this->getUser()->getAttributeHolder()->getAll('opp_votazione/filters');
	
	$this->pager = new sfPropelPager('OppVotazione', sfConfig::get('app_pagination_limit'));
    $c = new Criteria();
	$c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
	$this->addFiltersCriteria($c);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppSeduta');
    $this->pager->setPeerCountMethod('doCountJoinOppSeduta');
	$this->pager->init();
		
  }
  
  public function executeError404()
  {
    //return $this->redirect('@homepage');
  }

  protected function processFilters()
  {
    if ($this->getRequestParameter('legislatura'))
	  $this->getUser()->setAttribute('legislatura', $this->getRequestParameter('legislatura'));
	
	
	if (!($this->getUser()->hasAttribute('legislatura')))
	  $this->getUser()->setAttribute('legislatura', 16);
    
	if ($this->getRequestParameter('ramo'))
	  $this->getUser()->setAttribute('ramo', $this->getRequestParameter('ramo'));
	
	
	if (!($this->getUser()->hasAttribute('ramo')))
	  $this->getUser()->setAttribute('ramo', 'entrambi');
	    
  }

  protected function addFiltersCriteria($c)
  {
      if ($this->getUser()->getAttribute('legislatura') != 'tutte')
        $c->add(OppSedutaPeer::LEGISLATURA, $this->getUser()->getAttribute('legislatura'));
	  else
	    $c->add(OppSedutaPeer::LEGISLATURA, NULL, Criteria::NOT_EQUAL);
	  
	  if ($this->getUser()->getAttribute('ramo') != 'entrambi')
        $c->add(OppSedutaPeer::RAMO, $this->getUser()->getAttribute('ramo'));
  }

}

?>