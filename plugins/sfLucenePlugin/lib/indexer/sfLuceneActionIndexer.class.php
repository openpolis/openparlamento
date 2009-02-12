<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Module/action indexing engine.
 * @package sfLucenePlugin
 * @subpackage Indexer
 * @author Carl Vondrick
 */
class sfLuceneActionIndexer extends sfLuceneIndexer
{
  private $module, $action, $properties;

  public function __construct($search, $module, $action)
  {
    parent::__construct($search);

    $this->module = $module;
    $this->action = $action;


    $config = sfConfig::get('sf_app_dir') . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR  . $module . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'search.yml';

    include(sfConfigCache::getInstance()->checkConfig($config));

    if (!isset($actions[$this->getSearch()->getName()][$action]))
    {
      throw new sfLuceneIndexerException('Specified action is not registered for indexing');
    }

    $this->properties = $actions[$this->getSearch()->getName()][$action];
  }

  protected function shouldIndex()
  {
    return true;
  }

  /**
  * Deletes the provided action
  */
  public function delete()
  {
    extract($this->getActionProperties());

    if ( $this->deleteGuid( $this->getGuid($params) ) && $this->shouldLog())
    {
      if ($this->shouldLog())
      {
        $this->echoLog(sprintf('Deleted action "%s" of module "%s"', $action, $module));
      }

      $categories = $this->getModelCategories();

      foreach ($categories as $category)
      {
        $this->removeCategory($category);
      }
    }

    return $this;
  }

  /**
  * Inserts the provided action
  */
  public function insert()
  {
    if (!$this->shouldIndex())
    {
      return;
    }

    extract($this->getActionProperties());

    $output = $this->executeAction($params);

    $content = $output->getContent();

    $doc = $this->getHtmlDocString($content);

    $title_field = $this->getLuceneField('text', 'sfl_title', $output->getLastTitle());
    $title_field->boost = 2;

    $doc->addField($title_field);
    $doc->addField($this->getLuceneField('unindexed', 'sfl_uri', $this->getUri($params) ));
    $doc->addField($this->getLuceneField('unindexed', 'sfl_description', $content));
    $doc->addField($this->getLuceneField('unindexed', 'sfl_type', 'action'));

    $categories = $this->getActionCategories();

    if (count($categories))
    {
      foreach ($categories as $category)
      {
        $this->addCategory($category);
      }

      $doc->addField( $this->getLuceneField('text', 'sfl_category', implode(', ', $categories)) );
    }

    $guid = $this->getGuid($params);

    $this->addDocument($doc, $guid, 'action');

    if ($this->shouldLog())
    {
      $this->echoLog(sprintf('Inserted action "%s" of module "%s"', $this->getAction(), $this->getModule()));
    }

    return $this;
  }

  protected function getModule()
  {
    return $this->module;
  }

  protected function getAction()
  {
    return $this->action;
  }

  protected function getActionProperties()
  {
    $properties = $this->properties;
    $retval = array();

    $retval['authenticated']    = isset($properties['security']['authenticated'])   ? $properties['security']['authenticated']    : false;
    $retval['credentials']      = isset($properties['security']['credentials'])     ? $properties['security']['credentials']      : array();
    $retval['params']           = isset($properties['params'])                      ? $properties['params']                       : array();
    $retval['layout']           = isset($properties['layout'])                      ? $properties['layout']                       : false;

    return $retval;
  }

  protected function getActionCategories()
  {
    $properties = $this->getActionProperties();

    if (!isset($properties['categories']))
    {
      return array();
    }

    $categories = $properties['categories'];

    if (!is_array($categories))
    {
      $categories = array($categories);
    }

    return $categories;
  }

  /**
  * Returns the URI to the action
  */
  protected function getUri($params)
  {
    $uri = $this->getModule() . '/' . $this->getAction();

    if (count($params))
    {
      $url .= '?' . http_build_query($params);
    }

    return $uri;
  }

  /**
  * Retrives the guid for an action
  */
  protected function getGuid($params)
  {
    return parent::getGuid($this->getUri($params));
  }

  /**
  * Executes an action and returns the response content, given the parameters.
  * @param string $module The module
  * @param string $action The action
  * @param array $request The request parameters
  * @param bool $authenticated If true, the user is authenticated.  If false, the user is not.
  * @param array $credentials The credentials the user has
  * @param bool $layout If true, the response is decorated by the layout.  If false, the response is not.
  */
  protected function executeAction($request = array())
  {
    extract($this->getActionProperties());

    try
    {
      $browser = new sfLuceneBrowser($this->getModule(), $this->getAction());
      $browser->setParameters($request);
      $browser->setAuthentication($authenticated);
      $browser->setCredentials($credentials);
      $browser->setLayout($layout);
      $browser->setMethod('GET');
      $browser->setCulture($this->getCulture());

      return $browser;
    }
    catch (Exception $e)
    {
      throw new sfLuceneIndexerException(sprintf('Error during action "%s/%s" execution: [%s]', $module, $action, $e->getMessage()));
    }
  }
}
