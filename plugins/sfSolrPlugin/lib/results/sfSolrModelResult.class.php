<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Result from the model indexing engine.
 * @package    sfSolrPlugin
 * @subpackage Results
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfSolrModelResult extends sfSolrResult
{
  /**
  * Deduces the title to be displayed in search results.
  */
  public function getInternalTitle()
  {
    $model = $this->retrieveModel();

    if (isset($model['title']) && is_string($model['title']))
    {
      $getter = 'get' . $model['title'];
      return $this->$getter();
    }
    else
    {
      foreach (array('title', 'subject') as $check)
      {
        if (isset($model['fields'][$check]) && is_string($model['fields'][$check]) )
        {
          $getter = 'get' . $check;

          return $this->$getter();
        }
      }
    }

    return $this->getInternalModel();
  }

  /**
  * Gets the URI that this model links to
  */
  public function getInternalUri()
  {
    $model = $this->retrieveModel();

    if (!isset($model['route']))
    {
      throw new sfSolrException(sprintf('A route for model "%s" was not defined in the search.yml file.  Did you define one for this application?', $this->getInternalModel()));
    }

    return preg_replace_callback('/%(\w+)%/', array($this, 'internalUriCallback'), $model['route']);
  }

  /**
  * Callback for self::getInternalUri()
  */
  protected function internalUriCallback($matches)
  {
    $getter = 'get' . $matches[1];

    return $this->$getter();
  }

  /**
  * Gets the partial specified for this result.
  */
  public function getInternalPartial()
  {
    $model = $this->retrieveModel();
    
    if (isset($model['partial']))
    {
      return $model['partial'];
    }

    return parent::getInternalPartial();
  }

  public function getInternalDescription()
  {
    $model = $this->retrieveModel();

    if (isset($model['description']) && is_string($model['description']))
    {
      $getter = 'get' . $model['description'];
      return strip_tags($this->$getter());
    }

    foreach (array('description','summary','about') as $check)
    {
      if (isset($model['fields'][$check]) && is_string($model['fields'][$check]))
      {
        $getter = 'get' . $check;
        return strip_tags($this->$getter());
      }
    }

    return parent::getInternalDescription();
  }

  /**
  * Retrieves properties for this model.
  */
  protected function retrieveModel()
  {
    $model =  $this->search->dumpModel($this->getInternalModel());
    return $model;
    
  }
}