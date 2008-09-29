<?php

/**
 * teseo actions.
 *
 * @package    openparlamento
 * @subpackage teseo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class teseoActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $c = new Criteria();
    $c->add(OppTeseoPeer::ID, $this->getRequestParameter('id'), Criteria::EQUAL );
    $this->teseo = OppTeseoPeer::doSelectOne($c);
    $this->forward404Unless($this->teseo);
  }
}
