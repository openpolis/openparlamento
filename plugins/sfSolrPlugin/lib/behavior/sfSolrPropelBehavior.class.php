<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Responsible for handling Propel's behaviors.
 * @package    sfSolrPlugin
 * @subpackage Behavior
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfSolrPropelBehavior
{
  /**
   * Stores the objects in the queue that are flagged to be saved.
   */
  protected $saveQueue = array();

  /**
   * Stores the objects in the queue that are flagged to be removed.
   */
  protected $deleteQueue = array();

  /**
   * Lock status of the indexation behavior
   */
  protected static $lock = false;

  /**
   * Set the lock status of the behavior
   * @param  boolean  $to
   */
  public static function setLock($to)
  {
    self::$lock = (boolean) $to;
  }

  /**
   * Adds the node to the queue if is modified or is new.
   */
  public function preSave($node)
  {
    if (self::$lock)
    {
      return;
    }

    if ($node->isModified() || $node->isNew())
    {
      foreach ($this->saveQueue as $item)
      {
        if ($node->equals($item))
        {
          // already in queue, abort
          return;
        }
      }

      $this->saveQueue[] = $node;
    }
  }

  /**
   * Executes save routine if it can find it in the queue.
   */
  public function postSave($node)
  {
    foreach ($this->saveQueue as $key => $item)
    {
      if ($node->equals($item))
      {
        $this->saveIndex($node);

        unset($this->saveQueue[$key]);

        break;
      }
    }
    
    // commit changes
    $indexManager = sfSolr::getInstance();
    $indexManager->commit();
    
  }

  /**
   * Adds the node to the queue if is not new.
   */
  public function preDelete($node)
  {
    if (self::$lock)
    {
      return;
    }

    if (!$node->isNew())
    {
      foreach ($this->deleteQueue as $item)
      {
        if ($node->equals($item))
        {
          // already in queue, abort
          return;
        }
      }

      $this->deleteQueue[] = $node;
    }
  }

  /**
   * Deletes the object if it can find it in the queue.
   */
  public function postDelete($node)
  {
    foreach ($this->deleteQueue as $key => $item)
    {
      if ($node->equals($item))
      {
        $this->deleteIndex($node);

        unset($this->deleteQueue[$key]);

        break;
      }
    }
    
    // commit changes
    $indexManager = sfSolr::getInstance();
    $indexManager->commit();
    
  }

  /**
   * Saves index by deleting, inserting and committing
   */
  public function saveIndex($node)
  {
    $this->deleteIndex($node);
    $this->insertIndex($node);
  }

  /**
  * Deletes the old model
  */
  public function deleteIndex($node)
  {
    if (sfConfig::get('sf_logging_enabled'))
    {
      sfLogger::getInstance()->info(sprintf('{sfSolr} deleting model "%s" with PK = "%s"', 
                                    get_class($node), $node->getPrimaryKey()));
    }

    // - retrieve istanza indexManager e rimozione documento
    $indexManager = sfSolr::getInstance();
    $indexManager->removeDocument($node);
  }

  /**
  * Adds the new model
  */
  public function insertIndex($node)
  {
    if (sfConfig::get('sf_logging_enabled'))
    {
      sfLogger::getInstance()->info(sprintf('{sfSolr} saving model "%s" with PK = "%s"', 
                                    get_class($node), $node->getPrimaryKey()));
    }

    // - retrieve istanza indexManager e inserimento documento relativo
    $indexManager = sfSolr::getInstance();
    $indexManager->addDocument($node);
  }

  /**
  * Returns the behavior initializer
  */
  static public function getInitializer()
  {
    return sfSolrPropelInitializer::getInstance();
  }
}
