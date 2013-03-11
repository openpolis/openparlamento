<?php

/**
 * view actions.
 *
 * @package    project
 * @subpackage view
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 8496 2008-04-17 03:44:41Z fabien $
 */
class viewActions extends sfActions
{
  public function executeIndex()
  {
    $this->setTemplate('foo');
  }
  
  public function executePlain()
  {
  }
  
  public function executeImage()
  {
  }
}
