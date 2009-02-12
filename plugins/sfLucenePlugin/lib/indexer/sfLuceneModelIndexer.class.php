<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Model indexing engine.
 * @package sfLucenePlugin
 * @subpackage Indexer
 * @author Carl Vondrick
 */

abstract class sfLuceneModelIndexer extends sfLuceneIndexer
{
  private $instance;

  public function __construct($search, $instance)
  {
    parent::__construct($search);

    if (!$search->dumpModel(get_class($instance)))
    {
      throw new sfLuceneIndexerException(sprintf('Model "%s" is not registered.', get_class($instance)));
    }

    $this->instance = $instance;

    $msg = $this->validate();

    if ($msg)
    {
      throw new sfLuceneIndexerException('Model failed validation: ' . $msg);
    }
  }

  abstract protected function getModelGuid();

  /**
   * Optional validation method.  If it returns a message, an exception is thrown.
   */
  protected function validate()
  {
    return null;
  }

  protected function getModel()
  {
    return $this->instance;
  }

  protected function getModelName()
  {
    return get_class($this->getModel());
  }

  /**
  * Returns the properties of the given model.
  */
  protected function getModelProperties()
  {
    return $this->getSearch()->dumpModel($this->getModelName());
  }

  protected function getModelCategories()
  {
    $properties = $this->getModelProperties();

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
}
