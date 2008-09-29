<?php

/**
 * argomento actions.
 *
 * @package    openparlamento
 * @subpackage argomento
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class argomentoActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $c = new Criteria();
    $c->add(OppTeseottPeer::ID, $this->getRequestParameter('id'), Criteria::EQUAL );
    $this->argomento = OppTeseottPeer::doSelectOne($c);
    $this->forward404Unless($this->argomento);

    $this->tesei = $this->argomento->getTeseos();
	
	$this->teseo_id = array();
	foreach ($this->tesei as $teseo)
	  array_push($this->teseo_id, $teseo->getId());
	
	$this->atti = OppTeseoPeer::doSelectAtto($this->teseo_id);
	
  }
  
  public function executeList()
  {
    $c = new Criteria();
	$c->addAscendingOrderByColumn(OppTeseottPeer::DENOMINAZIONE);
    $this->argomenti = OppTeseottPeer::doSelect($c);
  }
  
  public function executeElencoDdl()
  {
    $this->teseo_id = $this->getRequestParameter('teseo_id');
	$this->argomento_id = $this->getRequestParameter('argomento_id');
	
	$c = new Criteria();
    $c->add(OppTeseottPeer::ID, $this->argomento_id, Criteria::EQUAL );
    $this->argomento = OppTeseottPeer::doSelectOne($c);
    
    $this->tesei = $this->argomento->getTeseos();
    	
  }
}
