<?php
/*
 * This file is part of the deppPropelActAsMonitorerBehavior package.
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
 * this MUST be used together with the deppPropelActAsMonitorableBehavior
 *
 * @package    plugins
 * @subpackage monitoring
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com>
 */
class deppPropelActAsMonitorerBehavior
{  

  /**
   * Retrieve a list of objects monitored by the user
   *
   * @return array of Objects
   * @param  BaseObject  $user
   * @param  Criteria    $criteria an additional criteria
   **/
  public function getMonitoredObjects(BaseObject $user, $criteria = null)
  {
    // handle criteria
    if (!is_null($criteria))
      $c = clone $criteria;
    else
      $c = new Criteria();
      
    $c->add(MonitoringPeer::USER_ID, $this->getReferenceKey($user));
    
    $monitoring_recs = MonitoringPeer::doSelect($c);
    $monitored = array();
    foreach ($monitoring_recs as $rec)
    {
      $monitored []= call_user_func_array(array($rec->getMonitorableModel() . "Peer", 'retrieveByPK'), $rec->getMonitorableId());
    }
    return $monitored;
  }

  /**
   * Retrieve the numberof objects monitored by th user
   * a Criteria can be specified;
   * If the override_cache is set to true
   * the number of objects is taken from the cache, if possible
   * and read from the DB if specifically asked or if the cache does not exist
   *
   * @return int
   * @param  BaseObject  $user
   * @param  Criteria    $criteria an additional criteria
   * @param  boolean     $override_cache - wether to override cache or not
   **/
  public function countMonitoredObjects(BaseObject $user, $criteria = null, $override_cache = false)
  {
    if ($override_cache == false)
    {  
      try {
        $res = self::getCachedCountMonitoredObjects($user);        
      } catch (deppPropelActAsMonitorerException $e) {
        sfLogger::getInstance()->warning($e);
        $override_cache = true;              
      }
    }
    
    if ($override_cache == true)
    {
      if (!is_null($criteria))
        $c = clone $criteria;
      else
        $c = new Criteria();

      $c->add(MonitoringPeer::USER_ID, $this->getReferenceKey($user));

      $res =  MonitoringPeer::doCount($c);      
      try {        
        self::setCachedCountMonitoredObjects($user, $res);
      } catch (deppPropelActAsMonitorerException $e) {
        sfLogger::getInstance()->warning($e); 
      }      
    }
        
    return $res;
    
  }


  /**
   * Check if the user is monitoring an object
   *
   * @return boolean
   * @param  BaseObject  $user
   * @param  String      $object_model 
   * @param  int         $object_id
   **/
  public function isMonitoring(BaseObject $user, $object_model, $object_id)
  {
    $c = new Criteria();
    $c->add(MonitoringPeer::MONITORABLE_ID, $object_id);
    $c->add(MonitoringPeer::MONITORABLE_MODEL, $object_model);
    $c->add(MonitoringPeer::USER_ID, $this->getReferenceKey($user));
    $n_monitoring = MonitoringPeer::doCount($c);
    
    if ($n_monitoring == 1) return true;
    if ($n_monitoring > 1) throw new deppPropelActAsMonitorerException('Two records found where one was expected');
    if ($n_monitoring == 0) return false;
  }




  /**
   * Sets cached counting of objects monitored by the user into the user table
   * 
   * @param  BaseObject  $user
   * @param  float       $value
   */
  public static function setCachedCountMonitoredObjects(BaseObject $user, $value)
  {
    $field = self::getCountMonitoredObjectsField($user);
    if (!is_null($field)) 
    {
      $setter = 'set'.$field;
      $getter = 'get'.$field;
      if (method_exists($user, $setter))
      {
        $ret = $user->$setter($value);
        $user->save();
        return $user->$getter();
      }
    }
    throw new deppPropelActAsMonitorerException(
      'Could not set the cached count monitored objects');
    
  } 


  /**
   * Gets cached counting of objects monitored by the user from the user table
   * 
   * @param  BaseObject  $user
   */
  public static function getCachedCountMonitoredObjects(BaseObject $user)
  {
    $field = self::getCountMonitoredObjectsField($user);
    
    if (!is_null($field)) 
    {
      $getter = 'get'.$field;
      if (method_exists($user, $getter))
      {
        return $user->$getter();
      }
    }
    
    throw new deppPropelActAsMonitorerException(
      'Could not get the cached count monitored objects');
  } 
  
  /**
   * Retrieves count_monitored_objects_field phpName from configuration
   * 
   * @param  BaseObject  $user
   * @return mixed
   */
  protected static function getCountMonitoredObjectsField(BaseObject $user)
  {
    return sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsMonitorerBehavior_%s_count_monitored_objects_field', 
              get_class($user)));
  }
  



  /**
   * Retrieves reference_field phpName from configuration
   * 
   * @param  BaseObject  $user
   * @return mixed
   */
  protected static function getObjectReferenceField(BaseObject $user)
  {
    return sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsMonitorerBehavior_%s_reference_field', 
              get_class($user)));
  }
  
  /**
   * Retrieves reference key for current Monitorer object (default returns 
   * primary key)
   * 
   * @param  BaseObject $user
   * @return int
   */
  public function getReferenceKey(BaseObject $user)
  {
    $reference_field = self::getObjectReferenceField($user);
    if (is_null($reference_field))
    {
      return $user->getPrimaryKey();
    }
    
    $getter = 'get'.$reference_field;
    if (method_exists($user, $getter))
    {
      $ret = $user->$getter();
      if (!is_int($ret))
      {
        throw new deppPropelActAsMonitorerException(
          'A reference field must be typed as integer');
      }
      return $ret;
    }
  }
  
  

    
  /**
   * Deletes all monitoring record for a Monitorer user (delete cascade emulation)
   * 
   * @param  BaseObject  $user
   */
  public function preDelete(BaseObject $user)
  {
    try
    {
      // get the objects affected by this user's removal
      $monitored_objects = $this->getMonitoredObjects($user);
      
      $user_id = $this->getReferenceKey($object);

      $c = new Criteria();
      $c->add(MonitoringPeer::USER_ID, $user_id);
      MonitoringPeer::doDelete($c);

      // updates the cache for the affected objects
      foreach ($monitored_objects as $object)
      {
        deppPropelActAsMonitorableBehavior::setCachedCountMonitoringUsers($user, $object->countMonitoringUsers($user_id, true));
      }
          
    }
    catch (Exception $e)
    {
      throw new deppPropelActAsMonitorerException(
        'Unable to delete Monitorer object related records');
    }
  }
  

}