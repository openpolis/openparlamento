<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This class an extension of the sfPropelData class, that allows 
 * to insert a record with fk relations to existing records in the db
 * To do this, the related table must not be among the tables specified in any yml fixtures
 * and the id must be an integer
 *
 * Example:
 *  OppAttoHasEmendamento:
 *    first:
 *      emendamento_id: first
 *      atto_id:        20209
 *    second:
 *      emendamento_id: second
 *      atto_id:        20209
 *
 * @package    symfony
 * @subpackage addon
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 * @version    SVN: $Id: $
 */
class myPropelData extends sfPropelData
{
  /**
   * Implements the abstract loadDataFromArray method and loads the data using the generated data model.
   *
   * @param array The data to be loaded into the data source
   *
   * @throws Exception   If data is unnamed.
   * @throws sfException If the id for an external db table is not an integer
   * @throws sfException If an object defined in the model does not exist in the data
   * @throws sfException If a column that does not exist is referenced
   */
  public function loadDataFromArray($data)
  {
    if ($data === null)
    {
      // no data
      return;
    }

    foreach ($data as $class => $datas)
    {
      $class = trim($class);

      $peer_class = $class.'Peer';

      // load map class
      $this->loadMapBuilder($class);

      $tableMap = $this->maps[$class]->getDatabaseMap()->getTable(constant($peer_class.'::TABLE_NAME'));

      $column_names = call_user_func_array(array($peer_class, 'getFieldNames'), array(BasePeer::TYPE_FIELDNAME));

      // iterate through datas for this class
      // might have been empty just for force a table to be emptied on import
      if (!is_array($datas))
      {
        continue;
      }

      foreach ($datas as $key => $data)
      {
        // create a new entry in the database
        $obj = new $class();

        if (!$obj instanceof BaseObject)
        {
          throw new Exception(sprintf('The class "%s" is not a Propel class. This probably means there is already a class named "%s" somewhere in symfony or in your project.', $class, $class));
        }

        if (!is_array($data))
        {
          throw new Exception(sprintf('You must give a name for each fixture data entry (class %s)', $class));
        }

        foreach ($data as $name => $value)
        {
          $isARealColumn = true;
          try
          {
            $column = $tableMap->getColumn($name);
          }
          catch (PropelException $e)
          {
            $isARealColumn = false;
          }

          // foreign key?
          if ($isARealColumn)
          {
            if ($column->isForeignKey() && !is_null($value))
            {
              if (!is_int($value))
              {
                try {
                  $relatedTable = $this->maps[$class]->getDatabaseMap()->getTable($column->getRelatedTableName());   
                  if (!isset($this->object_references[$relatedTable->getPhpName().'_'.$value]))
                  {
                    throw new sfException(sprintf('The object "%s" from class "%s" is not defined in your data file.', $value, $relatedTable->getPhpName()));
                  }

                  $value = $this->object_references[$relatedTable->getPhpName().'_'.$value];
                } catch (PropelException $e) {
                  throw new sfException(sprintf('The value %s for column %s is not an integer', $value, $name));
                }
              }

            }
          }

          if (false !== $pos = array_search($name, $column_names))
          {
            $obj->setByPosition($pos, $value);
          }
          else if (is_callable(array($obj, $method = 'set'.sfInflector::camelize($name))))
          {
            $obj->$method($value);
          }
          else
          {
            $error = 'Column "%s" does not exist for class "%s"';
            $error = sprintf($error, $name, $class);
            throw new sfException($error);
          }
        }
        $obj->save($this->con);

        // save the id for future reference
        if (method_exists($obj, 'getPrimaryKey'))
        {
          $this->object_references[$class.'_'.$key] = $obj->getPrimaryKey();
        }
      }
    }
  }

}
