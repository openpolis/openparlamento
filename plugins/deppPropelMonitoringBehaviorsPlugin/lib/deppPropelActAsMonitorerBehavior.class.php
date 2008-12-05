<?php
/*
 * This file is part of the deppPropelMonitoringBehaviors package.
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
   * Add monitoring of the propel object by the user
   *
   * this function is just a wrapper to the actAsMonitorable::addMonitoringUser
   * it can be invoket in place of that function, cache operations are performed there
   *
   * @param  BaseObject $user
   * @param  String     $object_model
   * @param  int        $object_id
   * @return void
   * @author Guglielmo Celata
   **/
  public function addMonitoredObject(BaseObject $user, $object_model, $object_id)
  {
    $monitored = call_user_func_array(array($object_model . "Peer", 'retrieveByPK'), $object_id);
    $monitored->addMonitoringUser($this->getReferenceKey($user));
  }

  /**
   * Remove monitoring of the propel object by the user
   *
   * this function is just a wrapper to the actAsMonitorable::removeMonitoringUser
   * it can be invoket in place of that function, cache operations are performed there
   *
   * @param  BaseObject $user
   * @param  String     $object_model
   * @param  int        $object_id
   * @return Object
   * @author Guglielmo Celata
   **/
  public function removeMonitoredObject(BaseObject $user, $object_model, $object_id)
  {
    $monitored = call_user_func_array(array($object_model . "Peer", 'retrieveByPK'), $object_id);
    return $monitored->removeMonitoringUser($this->getReferenceKey($user));
  }


  /**
   * Retrieve a list of pk's of object of a given type, monitored by the user
   * This is used to lighten and speed up the extraction of monitored objects
   *
   * @return array of Objects
   * @param  BaseObject  $user
   * @param  String      $object_model   - define the type of objects
   * @param  Criteria    $criteria an additional criteria
   **/
  public function getMonitoredPks(BaseObject $user, $object_model, $criteria = null)
  {
    // handle criteria
    if (!is_null($criteria))
      $c = clone $criteria;
    else
      $c = new Criteria();


    $c->add(MonitoringPeer::USER_ID, $this->getReferenceKey($user));
    // get the name of the ID field for this object's model
    $obj_id_field = call_user_func_array(array("Base" . $object_model . "Peer", 'translateFieldName'), 
                                         array('id', BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME));
                                         
    // build the join criteria using the parametric object_model's id name
    // and extracting only the id
    $c->clearSelectColumns();
    $c->addSelectColumn($obj_id_field);
    $c->addJoin(MonitoringPeer::MONITORABLE_ID, $obj_id_field);
    $c->add(MonitoringPeer::MONITORABLE_MODEL, $object_model);

    $monitored_pks = array();
    $monitored_rs = call_user_func_array(array($object_model . "Peer", 'doSelectRS'), array($c));
    while ($monitored_rs->next())
      $monitored_pks []= $monitored_rs->getInt(1);
    
    return $monitored_pks;
    
  }

  /**
   * Retrieve a list of objects monitored by the user
   *
   * @return array of Objects
   * @param  BaseObject  $user
   * @param  String      $object_model   - define the type of objects
   * @param  Criteria    $criteria an additional criteria
   **/
  public function getMonitoredObjects(BaseObject $user, $object_model = null, $criteria = null)
  {


    // handle criteria
    if (!is_null($criteria))
      $c = clone $criteria;
    else
      $c = new Criteria();


    $c->add(MonitoringPeer::USER_ID, $this->getReferenceKey($user));

    if (!is_null($object_model))
    {

      // get the name of the ID field for this object's model
        $obj_id_field = call_user_func_array(array('Base' . $object_model . "Peer", 'translateFieldName'), 
                                             array('id', BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME));        

      // build the join, using the parametric object_model's id name
      $c->addJoin(MonitoringPeer::MONITORABLE_ID, $obj_id_field);
      $c->add(MonitoringPeer::MONITORABLE_MODEL, $object_model);

      $monitored = call_user_func_array(array($object_model . "Peer", 'doSelect'), 
                                        array($c));
    } else {
      $monitoring_recs = MonitoringPeer::doSelect($c);
      $monitored = array();
      foreach ($monitoring_recs as $rec)
      {
        $monitored []= call_user_func_array(array($rec->getMonitorableModel() . "Peer", 'retrieveByPK'), 
                                            array($rec->getMonitorableId()));
      }      
    }
      
    return $monitored;
    
  }

  /**
   * Retrieve the numberof objects monitored by the user.
   * An object_model can be specified to filter on the objects type.
   * A Criteria can also be specified.
   *
   * The number of objects is taken from the cache, if possible
   * and read from the DB if specifically asked, 
   * through the override_cache parameter or if the cache does not exist
   *
   * @return int
   * @param  BaseObject  $user
   * @param  String      $object_model   - define the type of objects
   * @param  Criteria    $criteria       - an additional criteria
   * @param  boolean     $override_cache - wether to override cache or not
   **/
  public function countMonitoredObjects(BaseObject $user, 
                                        $object_model = null, 
                                        $criteria = null, $override_cache = false)
  {
    
    if ($override_cache == false)
    {  
      try {
        $res = self::getCachedCountMonitoredObjects($user, $object_model);        
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

      if (!is_null($object_model))
      {
        $c->add(MonitoringPeer::MONITORABLE_MODEL, $object_model);
      }
      
      $c->add(MonitoringPeer::USER_ID, $this->getReferenceKey($user));

      $res =  MonitoringPeer::doCount($c);      
      try {        
        self::setCachedCountMonitoredObjects($user, $object_model, $res);
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
   * @param  String      $object_model   - define the type of object
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
   * Gets cached counting of objects monitored by the user from the user table
   * 
   * @param  BaseObject  $user
   * @param  String      $object_model   - define the type of objects
   */
  public static function getCachedCountMonitoredObjects(BaseObject $user, $object_model = null)
  {
    $field = self::getCountMonitoredObjectsField($user, $object_model);
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
   * Sets cached counting of objects monitored by the user into the user table
   * 
   * @param  BaseObject  $user
   * @param  float       $value          - the value to set
   * @param  String      $object_model   - define the type of objects
   */
  public static function setCachedCountMonitoredObjects(BaseObject $user, $object_model = null, $value)
  {
    $field = self::getCountMonitoredObjectsField($user, $object_model);
    
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
   * Retrieve count_monitored_objects_field phpName from configuration 
   * if $object_model is specified, then the field name is taken from 
   * the monitorable model configuration
   * If the field is not specified in the $object_model configuration parameters
   * or the specified one does not exist, then the one specified in the Monitorer model 
   * is tried
   *
   * @param  BaseObject  $user
   * @param  String      $object_model   - define the type of objects
   * @return mixed
   */
  protected static function getCountMonitoredObjectsField(BaseObject $user, $object_model = null)
  {    
    // if an object_model is specified and the configuration parameters in that model
    // specify an existing field in the Monitorer (User) model, then use it
    if (!is_null($object_model))
    {
      $field =  deppPropelActAsMonitorableBehavior::getCountMonitoredObjectsField($object_model);
      if (!is_null($field))
      {
        $getter = 'get' . $field;
        if(method_exists($user, $getter))
          return $field;        
      }
    }
    
    // else
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