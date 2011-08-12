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

  public function executeOldSignin()
  {
    $host = $this->getRequest()->getHost();
    $script = $this->getRequest()->getScriptName();

    // in production sites, the request URI do not have the script name
    // this depends on configuration parameter no_script_name
    if (sfConfig::get('sf_no_script_name') && $script == '/index.php') 
      $script = '';
      
    $login_url = sprintf("http://%s%s/login", $host, $script);
    $user = $this->getUser();
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $redirect_url = $user->getAttribute('redirect_url', $this->getRequest()->getReferer());
      sfContext::getInstance()->getLogger()->info(sprintf("xxx: redirect_url: %s", $redirect_url));
      $user->getAttributeHolder()->remove('redirect_url');

      $signin_url = sfConfig::get('app_sf_guard_plugin_success_signin_url', $redirect_url);
      sfContext::getInstance()->getLogger()->info(sprintf("xxx: will redirect to signin_url: %s", $signin_url));

      $this->redirect('' != $signin_url ? $signin_url : '@homepage');
    }
    elseif ($user->isAuthenticated())
    {
      if ($this->getRequest()->getUri() != $login_url)
        $this->redirect($this->getRequest()->getURI());
      else
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


      if ($this->getRequest()->getUri() != $login_url)
      {
        $user->setAttribute('redirect_url', $this->getRequest()->getUri());
        sfContext::getInstance()->getLogger()->info(sprintf("xxx: user->redirect_url was set to %s", $user->getAttribute('redirect_url')));        
        sfContext::getInstance()->getLogger()->info(sprintf("xxx: login_url: %s", $login_url));        
      } else {
        $user->setAttribute('redirect_url', '@homepage');
        sfContext::getInstance()->getLogger()->info(sprintf("xxx: user->redirect_url was set to @homepage"));        
      }

      if ($this->getModuleName() != ($module = sfConfig::get('sf_login_module')))
      {
        return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
      }

      $this->getResponse()->setStatusCode(401);
    }
  }


  /**
   * Executes loginSocial action
   * to login using Facebook (or other social sign-ins in the future)
   *
   */
  public function executeSignin()
  {
    $host = $this->getRequest()->getHost();
    $script = $this->getRequest()->getScriptName();

    // in production sites, the request URI do not have the script name
    // this depends on configuration parameter no_script_name
    if (sfConfig::get('sf_no_script_name') && $script == '/index.php') 
      $script = '';

    $login_url = sprintf("http://%s%s/login", $host, $script);
    $user = $this->getUser();

    // some variables used in connecting to access APIs
    $remote_guard_host = sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it' ); 
    $apikey = sfConfig::get('sf_internal_api_key', 'xxx');
    $remote_script = str_replace('fe', 'be', sfContext::getInstance()->getRequest()->getScriptName());
    if ($remote_script == '/be.php') $remote_script = '/index.php';
    $api_host = sfConfig::get('sf_api_host', 'localhost:8000' ); 


    if ($this->getRequest()->getMethod() == sfRequest::POST) // username and password have been posted
    {
      $redirect_url = $user->getAttribute('redirect_url', $this->getRequest()->getReferer());
      sfContext::getInstance()->getLogger()->info(sprintf("xxx: redirect_url: %s", $redirect_url));
      $user->getAttributeHolder()->remove('redirect_url');

      $signin_url = sfConfig::get('app_sf_guard_plugin_success_signin_url', $redirect_url);
      sfContext::getInstance()->getLogger()->info(sprintf("xxx: will redirect to signin_url: %s", $signin_url));

      $this->redirect('' != $signin_url ? $signin_url : '@homepage');
    }
    else if ($user->isAuthenticated()) // user was immediately authenticated by filters
    {
      if ($this->getRequest()->getUri() != $login_url)
        $this->redirect($this->getRequest()->getURI());
      else
        $this->redirect('@homepage');
    }
    else // first time form is displayed, or returned after FB authentication
    {
      if ($this->getRequest()->isXmlHttpRequest()) // ajax request always return 401
      {
        $this->getResponse()->setHeaderOnly(true);
        $this->getResponse()->setStatusCode(401);

        return sfView::NONE;
      }

      // first time display, sets redirect_url to requested uri
      if (strpos($this->getRequest()->getUri(), $login_url) === false) // set redirect_url to destination url if not in login
      {
        $user->setAttribute('redirect_url', $this->getRequest()->getUri());
        sfContext::getInstance()->getLogger()->info(sprintf("xxx: user->redirect_url was set to %s", $user->getAttribute('redirect_url')));        
        sfContext::getInstance()->getLogger()->info(sprintf("xxx: login_url: %s", $login_url));        
      } else { // set redirect_url to @homepage, to avoid loop (in login page)
        $user->setAttribute('redirect_url', '@homepage');
        sfContext::getInstance()->getLogger()->info(sprintf("xxx: user->redirect_url was set to @homepage"));        
      }


      // check if returning from FB auth
      if (sfConfig::get('app_sf_guard_plugin_is_social', false)) {
		  
        // Create our Facebook instance
        $this->facebook = new Facebook(array(
          'appId'  => sfConfig::get('sf_fb_appId'),
          'secret' => sfConfig::get('sf_fb_secret'),
        ));

        $this->fb_user = $this->facebook->getUser();

        try {
          // Proceed knowing you have a logged in user who's authenticated.
          $fb = $this->facebook->api('/me');
        } catch (FacebookApiException $e) {
          $this->fb_user = null;
        }
      
        // logged into FB, implement the 'click FB_login btn flow'
        if (!is_null($this->fb_user)) 
        {
          // check if op and fb accounts have already been linked
          $xml = simplexml_load_file(sprintf("http://%s%s/getUserByFBUserId/%s/%s", 
                                            $remote_guard_host, $remote_script, $apikey, $fb['id']));
          if (count($xml->error))
          {
            $error = $xml->error;
            if ($error == 'Utente inesistente') 
            {
              // check if fb account's main email is being used from a user in op
              $xml = simplexml_load_file(sprintf("http://%s%s/getUserByEmail/%s/%s", 
                                                 $remote_guard_host, $remote_script, $apikey, $fb['email']));
                                              
              if (count($xml->error))
              {
                $error = $xml->error;
                if ($error == 'Utente inesistente' ||
                    strpos($error, 'Indirizzo email insesistente') !== false)
                {
                  // fb account is not linked to an op user and does not correspond to an op email
                  // a new user will be created
                
                  // first, a location id must be extracted from  fb['hometown']['name]
                  // send a request to the op api, to get the location from the name
                  $loc_lookup_xml = simplexml_load_file(sprintf("http://%s/op/v1/locations?name=%s&format=xml", 
                                                        $api_host, $fb['hometown']['name']));
                  $fb_location_id = 'None';
                  if ($loc_lookup_xml != 'None')
                  {
                    $fb_location_id = $loc_lookup_xml->id;
                  }
                
                  // add a user to the op_access db, (activated and verified)
                  // an email notification is sent to the new user and to the administrators
                  $xml = simplexml_load_file(sprintf("http://%s%s/addUser/%s/%s/%s/%s/%s/%s", 
                                                      $remote_guard_host, $remote_script, $apikey, 
                                                      $fb['first_name'], $fb['last_name'], $fb['email'],
                                                      $fb['id'], $fb_location_id));
                } 
              } else {
                $link_xml = simplexml_load_file(sprintf("http://%s%s/linkUserToFBAccount/%s/%s/%s", 
                                                   $remote_guard_host, $remote_script, $apikey, $fb['email'], $fb['id']));
                if (count($link_xml->error))
                {
                  $this->setFlash('error', $link_xml->error);
                  return sfView::SUCCESS; // reload login page, displaying flash error messages
                } else {
                  $this->setFlash('notice', sprintf("L'account %s è stato collegato all'utenza facebook %d", $fb['email'], $fb['id']));                
                }
              
              }             
            }
          }

          if (count($xml->user))
          {
            // logs user in OP
            $this->getContext()->getUser()->signIn($xml->user);
          
            // redirect to the right place (same logic after login form's POST)
            $redirect_url = $user->getAttribute('redirect_url', $this->getRequest()->getReferer());
            sfContext::getInstance()->getLogger()->info(sprintf("xxx: post fb: redirect_url: %s", $redirect_url));
            $user->getAttributeHolder()->remove('redirect_url');

            $signin_url = sfConfig::get('app_sf_guard_plugin_success_signin_url', $redirect_url);
            sfContext::getInstance()->getLogger()->info(sprintf("xxx: post fb: will redirect to signin_url: %s", $signin_url));

            $this->setFlash('notice', 'connessione attraverso fb riuscita');

            $this->redirect('' != $signin_url ? $signin_url : '@homepage');
          } else {
            $this->setFlash('error', $xml->error);
      			return sfView::SUCCESS; // reload login page, displaying flash error message
          }
        }
      
      } 
      
      // double check in case action is called by a different module
      if ($this->getModuleName() != ($module = sfConfig::get('sf_login_module')))
      {
        return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
      }

      // retruen 401, ask for authentication
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
    // sets fb variables, to avoid errors in 
    // form redisplayed after error
    if (sfConfig::get('app_sf_guard_plugin_is_social', false)) {
	  
      // Create our Facebook instance
      $this->facebook = new Facebook(array(
        'appId'  => sfConfig::get('sf_fb_appId'),
        'secret' => sfConfig::get('sf_fb_secret'),
      ));

      $this->fb_user = null;
    }
    
    return sfView::SUCCESS;
  }

}
