<?php
/*
 * This file is part of the deppPropelActAsMonitorableBehavior package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * This Propel behavior aims at allowing the user to monitor any Propel object
 *
 * @package    plugins
 * @subpackage monitoring
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com>
 */
class deppPropelActAsMonitorableBehavior
{
  
  /**
   * Add monitoring of the propel object by the user
   *
   * @return void
   * @param  BaseObject  $object
   * @param  int         $user_id  User primary key
   **/
  public function addMonitoringUser(BaseObject $object, $user_id)
  {
    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new deppPropelActAsMonitorableException('Impossible to allow a user monitoring with no user primary key provided');
    }
    
    // add the record
    $monitoring_object = new Monitoring();
    $monitoring_object->setMonitorableModel(get_class($object));
    $monitoring_object->setMonitorableId($this->getReferenceKey($object));
    $monitoring_object->setUserId($user_id);
    $ret = $monitoring_object->save();
    
    // update the caches
    $user = call_user_func_array(array($this->getMonitorerModel($object) . "Peer", 'retrieveByPK'), $user_id);
    $user->countMonitoredObjects(get_class($object), null, true);    
    $this->countMonitoringUsers($object, true);
  }

  /**
   * Remove monitoring of the propel object by the user
   *
   * @return BaseObject
   * @param  BaseObject  $object
   * @param  int         $user_id  User primary key
   **/
  public function removeMonitoringUser(BaseObject $object, $user_id)
  {
    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new deppPropelActAsMonitorableException('Impossible to remove a user monitoring with no user primary key provided');
    }
    
    // remove the record
    $c = new Criteria();
    $c->add(MonitoringPeer::MONITORABLE_ID, $this->getReferenceKey($object));
    $c->add(MonitoringPeer::MONITORABLE_MODEL, get_class($object));
    $c->add(MonitoringPeer::USER_ID, $user_id);
    $ret = MonitoringPeer::doDelete($c);
    
    // update the caches
    $user = call_user_func_array(array($this->getMonitorerModel($object) . "Peer", 'retrieveByPK'), $user_id);
    $user->countMonitoredObjects(get_class($object), null, true);    
    $this->countMonitoringUsers($object, true);

    // return the removed object
    return $ret;
  }  

  /**
   * Check if the user is monitoring the propel object
   *
   * @return boolean
   * @param  BaseObject  $object
   * @param  int         $user_id  User primary key
   **/
  public function isMonitoredByUser(BaseObject $object, $user_id)
  {
    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new deppPropelActAsMonitorableException('Impossible to check if a user is monitoring an object with no user primary key provided');
    }

    $c = new Criteria();
    $c->add(MonitoringPeer::MONITORABLE_ID, $this->getReferenceKey($object));
    $c->add(MonitoringPeer::MONITORABLE_MODEL, get_class($object));
    $c->add(MonitoringPeer::USER_ID, $user_id);
    $n_monitoring = MonitoringPeer::doCount($c);
    
    if ($n_monitoring == 1) return true;
    if ($n_monitoring > 1) throw new deppPropelActAsMonitorableException('Two records found where one was expected');
    if ($n_monitoring == 0) return false;
  }

  /**
   * Retrieve a list of users monitoring the propel object
   *
   * @return array of Objects
   * @param  BaseObject  $object
   **/
  public function getMonitoringUsers(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(MonitoringPeer::MONITORABLE_ID, $this->getReferenceKey($object));
    $c->add(MonitoringPeer::MONITORABLE_MODEL, get_class($object));
    
    $monitoring_recs = MonitoringPeer::doSelect($c);
    $monitoring = array();
    foreach ($monitoring_recs as $rec)
    {
      $monitoring []= call_user_func_array(array($this->getMonitorerModel($object) . "Peer", 'retrieveByPK'), 
                                           $rec->getUserId());
    }
    return $monitoring;
    
    return MonitoringPeer::doSelect($c);
  }

  /**
   * Retrieve the number of users monitoring the propel object
   * the number of users is taken from the cache, if possible
   * and read from the DB if specifically asked or if the cache does not exist
   *
   * @return int
   * @param  BaseObject  $object
   * @param  boolean     $override_cache - wether to override the cache or not
   **/
  public function countMonitoringUsers(BaseObject $object, $override_cache = false)
  {
    if ($override_cache == false)
    {
      try {
        $res =  self::getCachedCountMonitoringUsers($object);        
      } catch (deppPropelActAsMonitorableException $e) {
        sfLogger::getInstance()->warning($e);
        $override_cache = true;              
      }
    }
    
    if ($override_cache == true)
    {
      $c = new Criteria();
      $c->add(MonitoringPeer::MONITORABLE_ID, $this->getReferenceKey($object));
      $c->add(MonitoringPeer::MONITORABLE_MODEL, get_class($object));
      $res = MonitoringPeer::doCount($c);      
      try {        
        self::setCachedCountMonitoringUsers($object, $res);
      } catch (deppPropelActAsMonitorableException $e) {
        sfLogger::getInstance()->warning($e); 
      } 
    }

    return $res;           

  }



  protected function getMonitorerModel(BaseObject $object)
  {
    return sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsMonitorableBehavior_%s_monitorer_model', 
              get_class($object)));
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
      sprintf('propel_behavior_deppPropelActAsMonitorableBehavior_%s_reference_field', 
              get_class($object)));
  }
  
  /**
   * Retrieves reference key for current monitorable object (default returns 
   * primary key)
   * 
   * @param  BaseObject $object
   * @return int
   */
  protected function getReferenceKey(BaseObject $object)
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
        throw new deppPropelActAsMonitorableException(
          'A reference field must be typed as integer');
      }
      return $ret;
    }
  }
  

  
  
  
  /**
   * Sets cached number of users monitoring an object into the object table
   * 
   * @param  BaseObject  $object
   * @param  float       $value
   */
  public static function setCachedCountMonitoringUsers(BaseObject $object, $value)
  {
    $field = self::getCountMonitoringUsersField($object);
    if (!is_null($field)) 
    {
      $setter = 'set'.$field;
      if (method_exists($object, $setter))
      {
        $ret = $object->$setter($value);
        return $object->save();
      }
    }
    
    throw new deppPropelActAsMonitorableException(
        'Could not set the cached count monitoring users');
    
  } 


  /**
   * Gets cached number of users monitoring an object into the object table
   * 
   * @param  BaseObject  $object
   */
  public static function getCachedCountMonitoringUsers(BaseObject $object)
  {
    
    
    $field = self::getCountMonitoringUsersField($object);
    if (!is_null($field)) 
    {
      $getter = 'get'.$field;
      if (method_exists($object, $getter))
      {
        return $object->$getter();
      }
    }
    
    throw new deppPropelActAsMonitorableException(
      'Could not get the cached count monitoring users');
  } 
  
  /**
   * Retrieves count_monitoring_users_field phpName from configuration
   * 
   * @param  BaseObject  $object
   * @return mixed
   */
  protected static function getCountMonitoringUsersField(BaseObject $object)
  {
    return sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsMonitorableBehavior_%s_count_monitoring_users_field', 
              get_class($object)));
  }
  
  
  /**
   * Retrieves count_monitored_objects_field phpName from configuration
   * 
   * @param  String  $object_model
   * @return String
   */
  public static function getCountMonitoredObjectsField($object_model)
  {
    // an object must be instantiated, in order for the config. to read the proper values
    $a = new $object_model();
    $res = sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsMonitorableBehavior_%s_count_monitored_objects_field', 
              $object_model));
    unset($a);
    return $res;
  }
    
  /**
   * Deletes all monitoring for a monitorable object (delete cascade emulation)
   * 
   * @param  BaseObject  $object
   */
  public function preDelete(BaseObject $object)
  {
    try
    {
      $monitoring_users = $this->getMonitoringUsers($object);

      $c = new Criteria();
      $c->add(MonitoringPeer::MONITORABLE_ID, $this->getReferenceKey($object));
      $c->add(MonitoringPeer::MONITORABLE_MODEL, get_class($object));
      MonitoringPeer::doDelete($c);

      // updates the cache
      foreach ($monitoring_users as $user)
      {
        $nobjects = $user->countMonitoredObjects(get_class($object), null, true);
      }
          
    }
    catch (Exception $e)
    {
      throw new deppPropelActAsMonitorableException(
        'Unable to delete monitorable object related records');
    }

  }
  

}