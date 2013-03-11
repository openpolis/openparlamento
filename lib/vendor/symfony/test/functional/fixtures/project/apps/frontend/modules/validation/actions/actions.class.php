<?php

/**
 * validation actions.
 *
 * @package    project
 * @subpackage validation
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 8922 2008-05-13 08:20:09Z fabien $
 */
class validationActions extends sfActions
{
  public function executeIndex()
  {
    if (sfWebRequest::POST == $this->getRequest()->getMethod())
    {
      $this->getResponse()->setHttpHeader('X-Validated', 'ok');
    }
  }

  public function handleErrorIndex()
  {
    $this->getResponse()->setHttpHeader('X-Validated', 'ko');

    return sfView::SUCCESS;
  }

  public function executeIndex2()
  {
    if (sfWebRequest::POST == $this->getRequest()->getMethod())
    {
      $this->getResponse()->setHttpHeader('X-Validated', 'ok');
    }
  }

  public function handleErrorIndex2()
  {
    $this->getResponse()->setHttpHeader('X-Validated', 'ko');

    return sfView::SUCCESS;
  }

  public function executeGroup()
  {
  }

  public function handleErrorGroup()
  {
    return sfView::SUCCESS;
  }
}
