<?php

/**
 * static actions.
 *
 * @package    op_openparlamento
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class staticActions extends sfActions
{
  public function executeProgetto()
  {
  $this->getResponse()->setTitle('il progetto | '.sfConfig::get('app_main_title'));
  }
  public function executeFaq()
  {
  $this->getResponse()->setTitle('faq | '.sfConfig::get('app_main_title'));
  }
  
}
