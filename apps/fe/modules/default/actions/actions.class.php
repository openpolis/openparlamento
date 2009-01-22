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
  }
  
  public function executeError404()
  {
    return $this->redirect('@homepage');
  }
  
}

?>
