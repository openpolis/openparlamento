<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Initializes the Propel behaviors.
 * @package    sfLucenePlugin
 * @subpackage Behavior
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfLucenePropelInitializer
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
        ':save:pre' => array('sfLucenePropelBehavior', 'preSave'),
        ':save:post' => array('sfLucenePropelBehavior', 'postSave'),
        ':delete:pre' => array('sfLucenePropelBehavior', 'preDelete'),
        ':delete:post' => array('sfLucenePropelBehavior', 'postDelete'),
      ));

      sfPropelBehavior::registerMethods('search', array(
        array('sfLucenePropelBehavior', 'saveIndex'),
        array('sfLucenePropelBehavior', 'deleteIndex'),
        array('sfLucenePropelBehavior', 'insertIndex')
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