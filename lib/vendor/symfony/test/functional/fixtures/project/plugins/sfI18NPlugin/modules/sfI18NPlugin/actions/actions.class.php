<?php

/**
 * sfI18NPlugin actions.
 *
 * @package    project
 * @subpackage i18n
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 2750 2006-11-17 20:03:44Z fabien $
 */
class sfI18NPluginActions extends sfActions
{
  public function executeIndex()
  {
    $this->test = $this->getContext()->getI18N()->__('an english sentence');

    $this->localTest = $this->getContext()->getI18N()->__('a local english sentence');
  }
}
