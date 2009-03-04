<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Initializes the Propel behaviors.
 * @package    sfSolrPlugin
 * @subpackage Behavior
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfSolrPropelInitializer
{
  protected $model_setup = false;

  /**
  * Singleton.  Gets the instance
  */
  static public function getInstance()
  {
    static $instance;

    if (!isset($instance))
    {
      $instance = new self;
    }

    return $instance;
  }

  /**
  * Singleton constructor.
  */
  protected function __construct()
  {
  }

  /**
  * Initializes the model and Propel behaviors by adding all the appropriate hooks only once.
  */
  protected function setupModelOneTime()
  {
    if (!$this->model_setup)
    {
      sfPropelBehavior::registerHooks('search', array(
        ':save:pre' => array('sfSolrPropelBehavior', 'preSave'),
        ':save:post' => array('sfSolrPropelBehavior', 'postSave'),
        ':delete:pre' => array('sfSolrPropelBehavior', 'preDelete'),
        ':delete:post' => array('sfSolrPropelBehavior', 'postDelete'),
      ));

      sfPropelBehavior::registerMethods('search', array(
        array('sfSolrPropelBehavior', 'saveIndex'),
        array('sfSolrPropelBehavior', 'deleteIndex'),
        array('sfSolrPropelBehavior', 'insertIndex')
      ));

      $this->model_setup = true;
    }
  }

  /**
  * Sets up the provided model by adding propel behaviors.  It pulls the data to use for this
  * in the search.yml file.
  * @param string $model The model name to setup.
  */
  public function setupModel($model)
  {
    $this->setupModelOneTime();

    sfPropelBehavior::add($model, array(
      'search' => array()
    ));

    return $this;
  }
}