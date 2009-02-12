<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Base class for all indexing engines.
 * @package sfLucenePlugin
 * @subpackage Indexer
 * @author Carl Vondrick
 */
abstract class sfLuceneIndexer
{
  private $search = null;

  protected $encoding = 'UTF-8';

  public function __construct($search)
  {
    if (!($search instanceof sfLucene))
    {
      throw new sfLuceneIndexerException('Search must be an instance of sfLucene');
    }

    $this->search = $search;
    $this->encoding = $this->getSearch()->getEncoding();

    $this->getSearch()->configure();
  }

  abstract public function insert();
  abstract public function delete();
  abstract protected function shouldIndex();

  public function save()
  {
    $this->delete();
    $this->insert();

    return $this;
  }

  /**
  * Gets an instance of the lucene engine.
  */
  protected function getLucene()
  {
    return $this->getSearch()->getLucene();
  }

  /**
  * Gets the search engine.
  */
  protected function getSearch()
  {
    return $this->search;
  }

  protected function getCulture()
  {
    return $this->getSearch()->getCulture();
  }

  /**
  * Action to retrieve the GUID for the input
  */
  protected function getGuid($input)
  {
    return $this->getCulture() . '-' . md5($input) . sha1($input);
  }

  /**
  * Factory to obtain the search fields.
  * @param string $field The type of field
  * @param string $name To name to use
  * @param string $contents The contents for the field to have.
  * @return mixed The requested type.
  */
  protected function getLuceneField($field, $name, $contents)
  {
    switch (strtolower($field))
    {
      case 'keyword':
        return Zend_Search_Lucene_Field::Keyword($name, $contents, $this->encoding);
      case 'unindexed':
        return Zend_Search_Lucene_Field::UnIndexed($name, $contents, $this->encoding);
      case 'binary':
        return Zend_Search_Lucene_Field::Binary($name, $contents);
      case 'text':
        return Zend_Search_Lucene_Field::Text($name, $contents, $this->encoding);
      case 'unstored':
        return Zend_Search_Lucene_Field::UnStored($name, $contents, $this->encoding);
      case 'index term':
        return new Zend_Search_Lucene_Index_Term($contents, $name);
      default:
        throw new sfLuceneIndexerException(sprintf('Unknown field "%s" in factory', $field));
    }
  }

  /**
  * Searches the index for anything with that guid and will delete it.
  * @param string $guid The guid to search for
  */
  protected function deleteGuid($guid)
  {
    if ($this->getSearch()->isNew())
    {
      return 0;
    }

    $term = $this->getLuceneField('index term', 'sfl_guid', $guid );

    $query = new Zend_Search_Lucene_Search_Query_Term($term);

    $hits = $this->find($query);

    foreach ($hits as $hit)
    {
      $timer = sfTimerManager::getTimer('Zend Search Lucene');
      $this->getLucene()->delete($hit->id);
      $timer->addTime();
    }

    $this->commit();

    return count($hits);
  }

  /**
  * Adds a document
  */
  protected function addDocument($document, $guid)
  {
    $document->addField($this->getLuceneField('keyword', 'sfl_guid', $guid));

    $timer = sfTimerManager::getTimer('Zend Search Lucene');
    $this->getLucene()->addDocument($document);
    $timer->addTime();
  }

  /**
   * Adds a category to the cache
   * @param string $category The category name
   * @param int $c How many references (defaults to 1)
   */
  protected function addCategory($category, $c = 1)
  {
    sfLuceneCategory::newInstance($category, $this->getSearch())->addReference($c)->save();
  }

  /**
   * Removes a category from the cache
   * @param string $category The category name
   * @param int $c How many references (defaults to 1)
   */
  protected function removeCategory($category, $c = 1)
  {
    sfLuceneCategory::newInstance($category, $this->getSearch())->removeReference($c)->save();
  }

  /**
  * Returns a document based off an HTML string.
  */
  protected function getHtmlDocString($string)
  {
    return Zend_Search_Lucene_Document_Html::loadHtml($string);
  }

  /**
  * Returns a document based off an HTML file.
  */
  protected function getHtmlDocFile($file)
  {
    return Zend_Search_Lucene_Document_Html::loadHtmlFile($file);
  }

  protected function getNewDocument()
  {
    return new Zend_Search_Lucene_Document();
  }

  /**
  * Searches the lucene index for $query
  */
  protected function find($query)
  {
    return $this->getSearch()->find($query);
  }

  /**
  * Commits the changes.
  */
  protected function commit()
  {
    return $this->getSearch()->commit();
  }

  /**
  * Determines if the indexer should spit something out.
  */
  protected function shouldLog()
  {
    static $answer;

    if (!$answer)
    {
      $answer = function_exists('pake_echo_action');
    }

    return $answer;
  }

  /**
  * Echos a log using pake
  */
  protected function echoLog($message, $namespace = 'indexer')
  {
    if ($this->shouldLog())
    {
      pake_echo_action($namespace, $message);
    }
  }
}
