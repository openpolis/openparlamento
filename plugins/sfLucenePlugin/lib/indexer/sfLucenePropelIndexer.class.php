<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Propel indexing engine.
 *
 * @package sfLucenePlugin
 * @subpackage Indexer
 * @author Carl Vondrick
 */
class sfLucenePropelIndexer extends sfLuceneModelIndexer
{
  /**
  * Inserts the provided model into the index based off parameters in search.yml.
  * @param BaseObject $this->getModel() The model to insert
  */
  public function insert()
  {
    if (!$this->shouldIndex())
    {
      return $this;
    }

    $old_culture = null;

    // automatic symfony i18n detection
    if (method_exists($this->getModel(), 'getCulture') && method_exists($this->getModel(), 'setCulture'))
    {
      $old_culture = $this->getModel()->getCulture();
      $this->getModel()->setCulture($this->getCulture());
    }

    $properties = $this->getModelProperties();

    // get our base document from callback?
    if (!empty($properties['callback']))
    {
      $cb = $properties['callback'];

      if (!is_callable(array($this->getModel(), $cb)))
      {
        throw new sfLuceneIndexerException(sprintf('Callback "%s::%s()" does not exist', $this->getModelName(), $cb));
      }

      $doc = $this->getModel()->$cb();

      if (!($doc instanceof Zend_Search_Lucene_Document))
      {
        throw new sfLuceneIndexerException(sprintf('"%s::%s()" did not return a valid document (must be an instance of Zend_Search_Lucene_Document)', $this->getModelName(), $cb));
      }
    }
    else
    {
      $doc = new Zend_Search_Lucene_Document();
    }

    // add the fields
    if (isset($properties['fields']))
    {
      foreach ($properties['fields'] as $field => $field_properties)
      {
        $getter = 'get' . $field;

        if (!is_callable(array($this->getModel(), $getter)))
        {
          throw new sfLuceneIndexerException(sprintf('%s::%s() cannot be called', $this->getModel(), $getter));
        }

        $type = $field_properties['type'];
        $boost = $field_properties['boost'];

        $value = $this->getModel()->$getter();

        // validate value and transform if possible
        if (is_object($value) && method_exists($value, '__toString'))
        {
          $value = $value->__toString();
        }
        elseif (is_null($value))
        {
          $value = '';
        }
        elseif (!is_scalar($value))
        {
          if (is_object($value))
          {
            throw new sfLuceneIndexerException('Field value returned is an object, but could not be casted to a string (add a __toString() method).');
          }
          else
          {
            throw new sfLuceneIndexerException('Field value returned is not a string (got a ' . gettype($value) . ' ).');
          }
        }

        // handle a possible transformation function
        if ($field_properties['transform'])
        {
          if (!is_callable($field_properties['transform']))
          {
            throw new sfLuceneIndexerException('Transformation function cannot be called in field "' . $field . '" on model "' . $this->getModelName() . '"');
          }

          $value = call_user_func($field_properties['transform'], $value);
        }

        $zsl_field = $this->getLuceneField($type, strtolower($field), $value);
        $zsl_field->boost = $boost;

        $doc->addField($zsl_field);
      }
    }

    // category support
    $categories = $this->getModelCategories();

    if (count($categories))
    {
      foreach ($categories as $category)
      {
        $this->addCategory($category);
      }

      $doc->addField( $this->getLuceneField('text', 'sfl_category', implode(', ', $categories)) );
    }

    $doc->addField($this->getLuceneField('keyword', 'sfl_model', $this->getModelName()));
    $doc->addField($this->getLuceneField('unindexed', 'sfl_type', 'model'));

    // add document
    $this->addDocument($doc, $this->getModelGuid());

    if ($this->shouldLog())
    {
      $this->echoLog(sprintf('Inserted model "%s" with PK = %s', $this->getModelName(), $this->getModel()->getPrimaryKey()));
    }

    // restore culture in symfony i18n detection
    if ($old_culture)
    {
      $this->getModel()->setCulture($old_culture);
    }

    return $this;
  }

  /**
  * Deletes the old model
  * @param BaseObject $this->getModel() The model to delete
  */
  public function delete()
  {
    if ($this->deleteGuid( $this->getModelGuid() ))
    {
      if ($this->shouldLog())
      {
        $this->echoLog(sprintf('Deleted model "%s" with PK = %s', $this->getModelName(), $this->getModel()->getPrimaryKey() ));
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
   * Determines if the provided model should be indexed.
   */
  protected function shouldIndex()
  {
    $properties = $this->getModelProperties();
    $method = $properties['validator'];

    if (method_exists($this->getModel(), $method))
    {
      return (bool) $this->getModel()->$method();
    }

    return true;
  }

  protected function getModelCategories()
  {
    $retval = array();

    $error = error_reporting(0);
    $i18n = sfContext::getInstance()->getI18N();
    error_reporting($error);

    if ($i18n)
    {
      $i18n->setMessageSourceDir(null, $this->getCulture());
    }

    // see: http://www.nabble.com/Lucene-and-n:m-t4449653s16154.html#a12695579
    foreach (parent::getModelCategories() as $category)
    {
      if (preg_match('/^%(.*)%$/', $category, $matches))
      {
        $category = $matches[1];

        $getter = 'get' . $category;

        if (!is_callable(array($this->getModel(), $getter)))
        {
          throw new sfLuceneIndexerException(sprintf('%s->%s() cannot be called', $this->getModelName(), $getter));
        }

        $getterValue = $this->getModel()->$getter();

        if (is_object($getterValue) && method_exists($getterValue, '__toString'))
        {
          $getterValue = $getterValue->__toString();
        }
        elseif (!is_scalar($getterValue))
        {
          if (is_object($getterValue))
          {
            throw new sfLuceneIndexerException('Category value returned is an object, but could not be casted to a string (add a __toString() method to fix this).');
          }
          else
          {
            throw new sfLuceneIndexerException('Category value returned is not a string (got a ' . gettype($value) . ' ) and could not be transformed into a string.');
          }
        }

        $retval[] = $getterValue;
      }
      else
      {
        $retval[] = $i18n ? $i18n->__($category) : $category;
      }
    }

    return $retval;
  }

  protected function getModelGuid()
  {
    return $this->getGuid( $this->getModelName() . '_' . $this->getModel()->hashCode() );
  }

  protected function validate()
  {
    if (!($this->getModel() instanceof BaseObject))
    {
      return 'Model is not a Propel object';
    }

    return null;
  }
}