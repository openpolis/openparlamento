<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardAuthActions.class.php 8371 2008-04-09 10:18:22Z gordon $
 */
class BasesfGuardAuthActions extends sfActions
{
  public function executeSignin()
  {
    $user = $this->getUser();
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $redirect_url = $user->getAttribute('redirect_url', $this->getRequest()->getReferer());
      $user->getAttributeHolder()->remove('redirect_url');

      $signin_url = sfConfig::get('app_sf_guard_plugin_success_signin_url', $redirect_url);

      $this->redirect('' != $signin_url ? $signin_url : '@homepage');
    }
    elseif ($user->isAuthenticated())
    {
      $this->redirect('@homepage');
    }
    else
    {
      if ($this->getRequest()->isXmlHttpRequest())
      {
        $this->getResponse()->setHeaderOnly(true);
        $this->getResponse()->setStatusCode(401);

        return sfView::NONE;
      }


      if (!$user->hasAttribute('redirect_url') || trim($user->getAttribute('redirect_url')) == '')
      {
        $user->setAttribute('redirect_url', $this->getRequest()->getReferer());
      }

      if ($this->getModuleName() != ($module = sfConfig::get('sf_login_module')))
      {
        return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
      }

      $this->getResponse()->setStatusCode(401);
    }
  }

  public function executeSignout()
  {
    $this->getUser()->signOut();
    $signout_url = sfConfig::get('app_sf_guard_plugin_success_signout_url', $this->getRequest()->getReferer());

    $this->redirect('' != $signout_url ? $signout_url : '@homepage');
  }

  public function executeSecure()
  {
    $this->getResponse()->setStatusCode(403);
  }

  public function executePassword()
  {
    throw new sfException('This method is not yet implemented.');
  }

  public function handleErrorSignin()
  {
    $user = $this->getUser();
    if (!$user->hasAttribute('referer'))
    {
      $user->setAttribute('referer', $this->getRequest()->getReferer());
    }

    $module = sfConfig::get('sf_login_module');
    if ($this->getModuleName() != $module)
    {
      $this->forward(sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));
    }

    return sfView::SUCCESS;
  }
}
