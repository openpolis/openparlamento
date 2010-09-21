<?php
/*
 * This file is part of the deppPropelActAsPrioritisableBehavior package.
 *
 * (c) 2010 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * This Propel behavior aims at allowing the user to express opinions on any Propel
 * object
 *
 * @package    plugins
 * @subpackage priority 
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com>
 */
class deppPropelActAsPrioritisableBehavior
{
  
  /**
   * Default priority range
   */
  const DEFAULT_MAX_PRIORITY = 1;

  /**
   * Maximum priority range
   */
  const MAX_PRIORITY_LIMIT = 10;


  /**
   * votes the Object
   *
   * @param  BaseObject  $object
   * @param  int         $priority
   * @param  mixed       $user_id  Optional unique reference to user
   * @throws deppPropelActAsPrioritisableException
   **/
  public function setPriorityValue(BaseObject $object, $priority, $user_id = null)
  {
    
    // check that priority is an integer (or a rounded float)
    if (is_float($priority) && floor($priority) != $priority)
    {
      throw new deppPropelActAsPrioritisableException(
        sprintf('You cannot vote an object with a float (you provided "%s")', 
                $priority));
    }
    $priority = (int)$priority;
    
    // check that it is betweeen the allowed limits
    if ($priority > $object->getMaxPriority() || 
        $priority < ($object->allowsNullPriority()?0:1))
    {
      throw new deppPropelActAsPrioritisableException(
        sprintf('You can set priority from %d to %d', 
                ($object->allowsNullPriority()?0:1), 
                $object->getMaxPriority()));
    }

    $priority_object = self::getOrCreate($object, $user_id);
    $priority_object->setPrioritisableModel(get_class($object));
    $priority_object->setPrioritisableId($object->getPrioritisableReferenceKey());
    $priority_object->setUserId($user_id);
    $priority_object->setPriority($priority);
    $ret = $priority_object->save();
    
    return $ret;
  }
  

  /**
   * Retrieves the object priority
   *
   * @param  BaseObject  $object
   * @return integer
   **/
  public function getPriorityValue(BaseObject $object)
  {
    $p = sfPriorityPeer::getPriorityObject($object);
    if ($p) {
      return $p->getPriority();
    } else {
      return null;
    }
  }

  /**
   * Retrieves the last user that updated the priority
   * by default, retrieves it by reading the value in the sf_priority table
   * to force a read from the cache, set the cached params to true
   *
   * @param  BaseObject  $object
   * @return integer
   **/
  public function getPriorityLastUser(BaseObject $object)
  {
    $p = sfPriorityPeer::getPriorityObject($object);
    if ($p) {
      return $p->getUserId();
    } else {
      return null;
    }
  }

  /**
   * Retrieves the last timestamp the priority was updated
   * by default, retrieves it by reading the value in the sf_priority table
   * to force a read from the cache, set the cached params to true
   *
   * @param  BaseObject  $object
   * @return integer
   **/
  public function getPriorityLastUpdate(BaseObject $object, $format = null)
  {
    $p = sfPriorityPeer::getPriorityObject($object);
    if ($p) {
      return $p->getUpdatedAt($format);
    } else {
      return null;
    }
  }


  /**
   * Checks if an Object has been prioritised
   *
   * @param  BaseObject  $object
   **/
  public function hasBeenPrioritised(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfPriorityPeer::PRIORITISABLE_ID, $object->getPrioritisableReferenceKey());
    $c->add(sfPriorityPeer::PRIORITISABLE_MODEL, get_class($object));
    return sfPriorityPeer::doCount($c) > 0;
  }


  /**
   * Clear priority for an object
   *
   * @param  BaseObject  $object
   **/
  public function clearPriority(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfPriorityPeer::PRIORITISABLE_ID, $object->getPrioritisableReferenceKey());
    $c->add(sfPriorityPeer::PRIORITISABLE_MODEL, get_class($object));
    $priority = sfPriorityPeer::doSelectOne($c);
    $priority->delete();
  }

  
  /**
   * Retrieves max priority for given object
   * 
   * @param  BaseObject  $object  Propel object instance
   * @return int
   * @throws deppPropelActAsPrioritisableException
   */
  public function getMaxPriority(BaseObject $object)
  {
    
    $max_priority = sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsPrioritisableBehavior_%s_max_priority', 
             get_class($object)));
 
    if (is_null($max_priority))
    {
      $max_priority = @constant(get_class($object).'::DEFAULT_MAX_PRIORITY');
    }
 
    if (!is_int($max_priority))
    {
      throw new deppPropelActAsPrioritisableException(
        'The max_priority parameter must be an integer');
    }
    
    if (is_float($max_priority) && floor($max_priority) != $max_priority) // yeah, php typing sucks...
    {
      throw new deppPropelActAsPrioritisableException(
        sprintf('You cannot type %s::PRIORITY_RANGE as float (you provided "%s")', 
                get_class($object),
                $max_priority));
    }
    
    $max_priority = (int)$max_priority;
    
    if ($max_priority > self::MAX_PRIORITY_LIMIT)
    {
      throw new deppPropelActAsPrioritisableException(
        'The max_priority parameter must be an integer smaller than ' . self::MAX_PRIORITY_LIMIT);
    }
    
    return $max_priority;
  }
  

  /**
   * Return if the null priority is allowed
   * i.e. priorities start from 0
   *
   * by default, priorities can start from 0
   * @param  BaseObject $object
   * @return boolean
   * @author Guglielmo Celata
   **/
  public function allowsNullPriority(BaseObject $object)
  {
    return sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsPrioritisableBehavior_%s_null_priority', get_class($object)), true);
  }
  
  
  /**
   * Retrieves reference key for current prioritisable object (default returns 
   * primary key)
   * 
   * @param  BaseObject $object
   * @return int
   */
  public function getPrioritisableReferenceKey(BaseObject $object)
  {
    $reference_field = self::getObjectReferenceField($object);
    if (is_null($reference_field))
    {
      return $object->getPrimaryKey();
    }
    
    $getter = 'get'.$reference_field;
    if (method_exists($object, $getter))
    {
      $ret = $object->$getter();
      if (!is_int($ret))
      {
        throw new deppPropelActAsPrioritisableException(
          'A reference field must be typed as integer');
      }
      return $ret;
    }
  }

  
  /**
   * Retrieves prioritisable object instance from class name and key
   * 
   * @param  string  $class_name
   * @param  int     $key
   * @return BaseObject
   */
  public static function retrieveByKey($object_name, $key)
  {
    if (!class_exists($object_name))
    {
      throw new deppPropelActAsPrioritisableException('Class %s does not exist', 
                                              $object_name);
    }
    $object = new $object_name;
    $peer = $object->getPeer();
    $field = self::getObjectReferenceField($object);
    if (is_null($field))
    {
      return call_user_func(array($peer, 'retrieveByPK'), $key);
    }
    else
    {
      $column = call_user_func(array($peer, 'translateFieldName'),
                               self::getObjectReferenceField($object), 
                               BasePeer::TYPE_PHPNAME, 
                               BasePeer::TYPE_COLNAME);
      $c = new Criteria();
      $c->add($column, $key);
      return call_user_func(array($peer, 'doSelectOne'), $c);
    }
  }

  /**
   * Retrieves reference_field phpName from configuration
   * 
   * @param  BaseObject  $object
   * @return mixed
   */
  protected static function getObjectReferenceField(BaseObject $object)
  {
    return sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsPrioritisableBehavior_%s_reference_field', 
              get_class($object)));
  }

 
 
 
  
  /**
   * Deletes all priority for a prioritisable object (delete cascade emulation)
   * 
   * @param  BaseObject  $object
   */
  public function preDelete(BaseObject $object)
  {
    try
    {
      $c = new Criteria();
      $c->add(sfPriorityPeer::PRIORITISABLE_ID, $object->getPrioritisableReferenceKey());
      sfPriorityPeer::doDelete($c);
    }
    catch (Exception $e)
    {
      throw new deppPropelActAsPrioritisableException(
        'Unable to delete prioritisable object related priorities records');
    }
  }



  /**
   * Retrieve an existing priority object, or return a new empty one
   *
   * @param  BaseObject  $object
   * @param  mixed       $user_id  Unique user primary key
   * @return sfPriority
   * @throws deppPropelActAsPrioritisableException
   **/
  protected static function getOrCreate(BaseObject $object, $user_id = null)
  {
    if ($object->isNew())
    {
      throw new deppPropelActAsPrioritisableException('Unsaved objects are not prioritisable');
    }
    
    if (is_null($user_id))
    {
      return new sfPriority();
    }
    
    $c = new Criteria();
    $c->add(sfPriorityPeer::PRIORITISABLE_ID, $object->getPrioritisableReferenceKey());
    $c->add(sfPriorityPeer::PRIORITISABLE_MODEL, get_class($object));
    $priority = sfPriorityPeer::doSelectOne($c);
    return is_null($priority) ? new sfPriority() : $priority;
  }

  
  

  

}