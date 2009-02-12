<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A heavily modified sfBrowser that will launch requests into the symfony application.
 * @package    sfLucenePlugin
 * @subpackage Utilities
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfLuceneBrowser
{
  protected $module, $action;

  protected $requestVars = array(), $method = 'GET', $authentication = false, $credentials = array(), $layout = false, $culture = null;

  /**
  * Consturctor.
  * @param string $module The module to load
  * @param string $action The action load
  */
  public function __construct($module, $action)
  {
    $this->module = $module;
    $this->action = $action;
  }

  /**
  * Sets the request parameters.
  * @param array $parameters The parameters to set.
  */
  public function setParameters($parameters)
  {
    $this->requestVars = array_merge($this->requestVars, $parameters);
  }

  /**
  * Sets whether the user is authenticated or not.
  * @param bool $authentication If true, the user is authenticated.  Otherwise, not.
  */
  public function setAuthentication($authentication)
  {
    $this->authentication = $authentication;
  }

  /**
  * Sets the credentials the user has.
  * @param array $credentials The credentials to give to the user.
  */
  public function setCredentials($credentials = array())
  {
    $this->credentials = array_merge($this->credentials, $credentials);
  }

  /**
  * Sets whether to decorate the response with a layout.
  * @param bool $layout If true, layout is decorated.  If false, the layout is not.
  */
  public function setLayout($layout)
  {
    $this->layout = $layout  ? null : false;
  }

  /**
  * Sets the request method (not implemented yet)
  * @param string $method The method to use (POST, GET, etc)
  */
  public function setMethod($method)
  {
    $this->method = $method;
  }

  /**
  * Sets the culture
  * @param string $culture The culture to serve the page as
  */
  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  /**
  * Launches the request and gets the response.
  */
  public function getContent()
  {
    $this->initialize();

    ob_start();

    try
    {
      $this->getContext()->getController()->forward($this->module, $this->action);
    }
    catch (sfStopException $e)
    {
    }

    return ob_get_clean();
  }

  /**
  * Initializes the request
  */
  protected function initialize()
  {
    $this->getContext()->getRequest()->initialize($this->getContext());

    for ($x = 0, $stop = $this->getContext()->getActionStack()->getSize(); $x < $stop; $x++)
    {
      $this->getContext()->getActionStack()->popEntry();
    }

    sfConfig::set('sf_rendering_filter', array('sfLuceneRenderingFilter', null));
    sfConfig::set('sf_cache_filter', array('sfLuceneCacheFilter', null));
    sfConfig::set('sf_execution_filter', array('sfLuceneExecutionFilter', array('layout' => $this->layout)));

    $this->getContext()->getRequest()->getParameterHolder()->add($this->requestVars);

    $this->getContext()->getUser()->setAuthenticated($this->authentication);
    $this->getContext()->getUser()->clearCredentials();
    $this->getContext()->getUser()->addCredentials($this->credentials);

    $this->getContext()->getUser()->setCulture($this->culture);
  }

  /**
  * Returns an instance of sfContext
  */
  protected function getContext()
  {
    return sfContext::getInstance();
  }

  /**
  * Gets the last title for the response.
  */
  public function getLastTitle()
  {
    return sfContext::getInstance()->getResponse()->getTitle();
  }

  public function __toString()
  {
    return $this->getContent();
  }
}