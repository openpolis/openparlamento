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
    //$this->forward('default', 'module');
  }
  
  public function executeList()
  {
    $c = new Criteria();
	$c->addAscendingOrderByColumn(OppTeseottPeer::DENOMINAZIONE);
    $this->argomenti = OppTeseottPeer::doSelect($c);
  }
}
