<?php
/*
 * This file is part of the deppPropelActAsVotableBehavior package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
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
 * @subpackage voting 
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com>
 * @author     Nicolar Perriault
 * @author     Fabian Lange
 * @author     Vojtech Rysanek
 */
class deppPropelActAsVotableBehavior
{
  
  /**
   * Default voting range
   */
  const DEFAULT_VOTING_RANGE = 1;

  /**
   * Maximum voting range
   */
  const MAX_VOTING_RANGE = 10;
  
  /**
   * Default float precision (average)
   */
  const DEFAULT_PRECISION = 2;
  
  /**
   * Counts votings made on given votable object.
   * 
   * @param  BaseObject  $object
   * @return int
   */
  public function countVotings(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfVotingPeer::VOTABLE_ID, $object->getReferenceKey());
    $c->add(sfVotingPeer::VOTABLE_MODEL, get_class($object));
    return sfVotingPeer::doCount($c);
  }


  /**
   * Generates the criteria used to extract the list and number of users voting the probel object
   * with a given attitude
   *
   * @param BaseObject $object 
   * @param string $voting_attitude 
   * @return Criteria
   * @author Guglielmo Celata
   */
  protected function _votingUsersPKsCriteria(BaseObject $object, $voting_attitude = null)
  {
    $c = new Criteria();
    $c->add(sfVotingPeer::VOTABLE_ID, $this->getReferenceKey($object));
    $c->add(sfVotingPeer::VOTABLE_MODEL, get_class($object));
    $c->clearSelectColumns();
    $c->addSelectColumn(sfVotingPeer::USER_ID);

    // analyze voting attitude
    if (!is_null($voting_attitude))
    {
      if ($voting_attitude > 0)
        $c->add(sfVotingPeer::VOTING, 0, Criteria::GREATER_THAN);
      elseif ($voting_attitude < 0)
        $c->add(sfVotingPeer::VOTING, 0, Criteria::LESS_THAN);
      else
        $c->add(sfVotingPeer::VOTING, 0);
    }
    
    return $c;
  }

  /**
   * Retrieve an array of all pks for the users voting for this object
   *
   * @param BaseObject $object 
   * @param string $voting_attitude - if not null, filters on how the users voted (pro or aganist)
   * @return array of users pks
   * @author Guglielmo Celata
   */
  public function getVotingUsersPKs(BaseObject $object, $voting_attitude = null)
  {
    $c = self::_votingUsersPKsCriteria($object, $voting_attitude);

    $users_pks = array();
    $rs = sfVotingPeer::doSelectRS($c); 
    while($rs->next())
      $users_pks[] = $rs->getInt(1);

    return $users_pks;
  }

  /**
   * Retrieve a list of users voting the propel object with a give attitude
   *
   * @param  BaseObject  $object
   * @param string $voting_attitude - if not null, filters on how the users voted (pro or aganist)
   * @return array of Objects
   **/
  public function getVotingUsers(BaseObject $object, $voting_attitude = null)
  {
    $users_pks = self::getVotingUsersPKs($object, $voting_attitude);
    $users = call_user_func_array(array($this->getMonitorerModel($object) . "Peer", 'retrieveByPKs'), 
                                  array($users_pks));
    return $users;
  }

  /**
   * Retrieve the number of users monitoring the propel object with a given attitude
   *
   * @param  BaseObject  $object
   * @param  string $voting_attitude - if not null, filters on how the users voted (pro or aganist)
   * @return int
   **/
  public function countVotingUsers(BaseObject $object, $voting_attitude)
  {
    $c = self::_votingUsersPKsCriteria($object, $voting_attitude);

    $users_pks = array();
    return sfVotingPeer::doCount($c); 
  }



  /**
   * Retrieves configured float precision for votings
   * 
   * @param  int  $default_precision
   * @return int
   */
  protected static function getPrecision($default_precision = null)
  {
    if (is_null($default_precision))
    {
      $default_precision = self::DEFAULT_PRECISION;
    }
    return sfConfig::get('app_voting_precision', $default_precision);
  }
  
  /**
   * Retrieves an existing voting object, or return a new empty one
   *
   * @param  BaseObject  $object
   * @param  mixed       $user_id  Unique user primary key
   * @return sfVoting
   * @throws deppPropelActAsVotableException
   **/
  protected static function getOrCreate(BaseObject $object, $user_id = null)
  {
    if ($object->isNew())
    {
      throw new deppPropelActAsVotableException('Unsaved objects are not votable');
    }
    
    if (is_null($user_id))
    {
      return new sfVoting();
    }
    
    $c = new Criteria();
    $c->add(sfVotingPeer::VOTABLE_ID, $object->getReferenceKey());
    $c->add(sfVotingPeer::VOTABLE_MODEL, get_class($object));
    $c->add(sfVotingPeer::USER_ID, $user_id);
    $user_voting = sfVotingPeer::doSelectOne($c);
    return is_null($user_voting) ? new sfVoting() : $user_voting;
  }

  /**
   * Clear all votings for an object
   *
   * @param  BaseObject  $object
   **/
  public function clearVotings(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfVotingPeer::VOTABLE_ID, $object->getReferenceKey());
    $c->add(sfVotingPeer::VOTABLE_MODEL, get_class($object));
    $votes = sfVotingPeer::doSelect($c);
    foreach ($votes as $v)
      $v->delete();    
    self::setVotingToObject($object, 0);
    self::setVotingDetailsToObject($object, null);

    return $ret;
  }

  /**
   * Clear user voting for an object
   *
   * @param  BaseObject  $object
   * @param  mixed       $user_id  User primary key
   **/
  public function clearUserVoting(BaseObject $object, $user_id)
  {
    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new deppPropelActAsVotableException('Impossible to clear a user voting with no user primary key provided');
    }
    
    $c = new Criteria();
    $c->add(sfVotingPeer::VOTABLE_ID, $object->getReferenceKey());
    $c->add(sfVotingPeer::VOTABLE_MODEL, get_class($object));
    $c->add(sfVotingPeer::USER_ID, $user_id);
    $v = sfVotingPeer::doSelectOne($c);
    $v->delete();
    self::setVotingToObject($object, $this->getVoting($object, self::getPrecision(), true));
    self::setVotingDetailsToObject($object, $this->getVotingDetails($object, true, true));

    return $ret;
  }

  /**
   * Checks if an Object has been voted
   *
   * @param  BaseObject  $object
   **/
  public function hasBeenVoted(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfVotingPeer::VOTABLE_ID, $object->getReferenceKey());
    $c->add(sfVotingPeer::VOTABLE_MODEL, get_class($object));
    return sfVotingPeer::doCount($c) > 0;
  }

  /**
   * Checks if an Object has been voted by a user
   *
   * @param  BaseObject  $object
   * @param  mixed       $user_id  Unique reference to a user
   **/
  public function hasBeenVotedByUser(BaseObject $object, $user_id)
  {
    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new deppPropelActAsVotableException(
        'Impossible to check a user voting with no user primary key provided');
    }
    $c = new Criteria();
    $c->add(sfVotingPeer::VOTABLE_ID, $object->getReferenceKey());
    $c->add(sfVotingPeer::VOTABLE_MODEL, get_class($object));
    $c->add(sfVotingPeer::USER_ID, $user_id);
    return (sfVotingPeer::doCount($c) > 0);
  }
  
  /**
   * Retrieves voting range for given object
   * 
   * @param  BaseObject  $object  Propel object instance
   * @return int
   * @throws deppPropelActAsVotableException
   */
  public function getVotingRange(BaseObject $object)
  {
    
    $voting_range = sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_voting_range', 
             get_class($object)));
 
    if (is_null($voting_range))
    {
      $voting_range = @constant(get_class($object).'::DEFAULT_VOTING_RANGE');
    }
 
    if (!is_int($voting_range))
    {
      throw new deppPropelActAsVotableException(
        'The voting_range parameter must be an integer');
    }
    
    if (is_float($voting_range) && floor($voting_range) != $voting_range) // yeah, php typing sucks...
    {
      throw new deppPropelActAsVotableException(
        sprintf('You cannot type %s::VOTING_RANGE as float (you provided "%s")', 
                get_class($object),
                $voting_range));
    }
    
    if ($voting_range > self::MAX_VOTING_RANGE)
    {
      throw new deppPropelActAsVotableException(
        'The voting_range parameter must be an integer smaller than ' . self::MAX_VOTING_RANGE);
    }
    
    return $voting_range;
  }
  

  /**
   * Return if the neutral position is allowed
   *
   * by default, the neutral position is allowed
   * @param  BaseObject $object
   * @return boolean
   * @author Guglielmo Celata
   **/
  public function allowsNeutralPosition(BaseObject $object)
  {
    return sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_neutral_position', get_class($object)), true);
  }
  
  /**
   * Return if the anonymous user can vote
   *
   * by default, only registered user can vote
   * @param  BaseObject $object
   * @return boolean
   * @author Guglielmo Celata
   **/
  public function allowsAnonymousVoting(BaseObject $object)
  {
    return sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_anonymous_voting', get_class($object)), false);
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
      sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_reference_field', 
              get_class($object)));
  }
  
  /**
   * Retrieves reference key for current votable object (default returns 
   * primary key)
   * 
   * @param  BaseObject $object
   * @return int
   */
  public function getReferenceKey(BaseObject $object)
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
        throw new deppPropelActAsVotableException(
          'A reference field must be typed as integer');
      }
      return $ret;
    }
  }

  /**
   * Retrieves the object voting (average)
   *
   * @param  BaseObject  $object
   * @param  int         $precision   Result float precision
   * @return float
   **/
  public function getVoting(BaseObject $object, $precision=2, $docount=false)
  {
    if ($docount === false && !is_null(self::getObjectVotingField($object)))
    {
      return round(self::getVotingToObject($object), self::getPrecision());
    }
    
    $c = new Criteria();
    $c->add(sfVotingPeer::VOTABLE_ID, $object->getReferenceKey());
    $c->add(sfVotingPeer::VOTABLE_MODEL, get_class($object));
    $c->clearSelectColumns();
    $c->addAsColumn('nb_votings', 'COUNT('.sfVotingPeer::ID.')');
    $c->addAsColumn('total', 'SUM('.sfVotingPeer::VOTING.')');
    $c->addGroupByColumn(sfVotingPeer::VOTABLE_MODEL);
    $rs = sfVotingPeer::doSelectRS($c);
    $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);
    while ($rs->next())
    {
      $nb_votings = $rs->getInt('nb_votings');
      $total      = $rs->getInt('total');
      if (!$nb_votings or $nb_votings === 0)
      {
        return NULL; // Object has not been voted yet
      }
      return round($total / $nb_votings, self::getPrecision($precision));
    }
  }
  
  /**
   * Gets the object voting details (how many voted what, as an hash)
   *
   * @param  BaseObject  $object
   * @param  boolean     $include_all  Shall we include all available votings?
   * @return associative array containing (voting => count)
   **/
  public function getVotingDetails(BaseObject $object, $include_all = false, $docount=false)
  {
    if ($include_all === false && $docount === false && !is_null(self::getObjectVotingFields($object)))
    {
      return self::getVotingDetailsFromObject($object);
    }
    
    $c = new Criteria();
    $c->add(sfVotingPeer::VOTABLE_ID, $object->getReferenceKey());
    $c->add(sfVotingPeer::VOTABLE_MODEL, get_class($object));
    $c->clearSelectColumns();
    $c->addAsColumn('nb_votings', 'COUNT('.sfVotingPeer::ID.')');
    $c->addAsColumn('voting', sfVotingPeer::VOTING);
    $c->addGroupByColumn(sfVotingPeer::VOTING);
    $rs = sfVotingPeer::doSelectRS($c);
    $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);
    $details = array();
    while ($rs->next())
    {
      $details = $details + array ($rs->getInt('voting') => (int)$rs->getString('nb_votings'));
    }
    if ($include_all === true)
    {
      for ($i=-1*$object->getVotingRange(); $i<=$object->getVotingRange(); $i++)
      {
        if (!array_key_exists($i, $details))
        {
          $details[$i] = 0;
        }
      }
    }
    ksort($details);
    return $details;
  }
  
  /**
   * Gets the object voting for given user pk
   *
   * @param  BaseObject  $object
   * @param  mixed       $user_id  User primary key
   * @return int or false
   **/
  public function getUserVoting(BaseObject $object, $user_id)
  {
    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new deppPropelActAsVotableException(
        'Impossible to get a user voting with no user primary key provided');
    }
    
    $c = new Criteria();
    $c->add(sfVotingPeer::VOTABLE_ID, $object->getReferenceKey());
    $c->add(sfVotingPeer::VOTABLE_MODEL, get_class($object));
    $c->add(sfVotingPeer::USER_ID, $user_id);
    $voting_object = sfVotingPeer::doSelectOne($c);
    if (!is_null($voting_object))
    {
      return $voting_object->getVoting();
    }
  }

  
  /**
   * Retrieves votable object instance from class name and key
   * 
   * @param  string  $class_name
   * @param  int     $key
   * @return BaseObject
   */
  public static function retrieveByKey($object_name, $key)
  {
    if (!class_exists($object_name))
    {
      throw new deppPropelActAsVotableException('Class %s does not exist', 
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
   * votes the Object
   *
   * @param  BaseObject  $object
   * @param  int         $voting
   * @param  mixed       $user_id  Optional unique reference to user
   * @throws deppPropelActAsVotableException
   **/
  public function setVoting(BaseObject $object, $voting, $user_id = null)
  {

    if (is_float($voting) && floor($voting) != $voting)
    {
      throw new deppPropelActAsVotableException(
        sprintf('You cannot vote an object with a float (you provided "%s")', 
                $voting));
    }
    $voting = (int)$voting;
    
    if ($voting > $object->getVotingRange() || $voting < -1*$object->getVotingRange())
    {
      throw new deppPropelActAsVotableException(
        sprintf('Voting range is -%d to %d', $object->getVotingRange(), $object->getVotingRange()));
    }

    // test anonymous voting, rejecting if not allowed
    if (!$object->allowsAnonymousVoting() && $user_id === null)
    {
      throw new deppPropelActAsVotableException('Anonymous voting not allowed');
    }
    
    // test neutral position, rejecting if not allowed
    if (!$object->allowsNeutralPosition() && $voting == 0)
    {
      throw new deppPropelActAsVotableException('Neutral position not allowed');
    }
    
    $voting_object = self::getOrCreate($object, $user_id);
    $voting_object->setVotableModel(get_class($object));
    $voting_object->setVotableId($object->getReferenceKey());
    $voting_object->setUserId($user_id);
    $voting_object->setVoting($voting);
    $ret = $voting_object->save();
    self::setVotingToObject($object, $this->getVoting($object, self::getPrecision(), true));
    self::setVotingDetailsToObject($object, $this->getVotingDetails($object, true, true));
    return $ret;
  }
  
  /**
   * Deletes all voting for a votable object (delete cascade emulation)
   * 
   * @param  BaseObject  $object
   */
  public function preDelete(BaseObject $object)
  {
    try
    {
      $c = new Criteria();
      $c->add(sfVotingPeer::VOTABLE_ID, $object->getReferenceKey());
      sfVotingPeer::doDelete($c);
    }
    catch (Exception $e)
    {
      throw new deppPropelActAsVotableException(
        'Unable to delete votable object related votings records');
    }
  }


  /* Contributed by Guglielmo Celata */

  /**
   * Retrieves voting_fields phpName from configuration
   * 
   * @param  BaseObject  $object
   * @return hash (1 => 'NFavour', -1 => 'NAgainst')
   */
  protected static function getObjectVotingFields(BaseObject $object)
  {
    return sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_voting_fields', 
              get_class($object)));
  }

  
  /**
   * Sets cached voting details to the object
   * 
   * @param  BaseObject  $object
   * @param  hash        $values (1 => FAV, -1 => AG)
   */
  protected static function setVotingDetailsToObject(BaseObject $object, $values)
  {
    $fields = self::getObjectVotingFields($object);
    if (!is_null($fields) && count($fields) > 0) 
    {
      foreach ($fields as $value => $field)
      {
        $setter = 'set'.$field;
        if (method_exists($object, $setter))
        {
          if (is_null($values))
            $object->$setter(null);
          else
            $object->$setter($values[$value]);      
        }
      }
      return $object->save();
    }
  } 
  
  /**
   * Return cached voting details from object
   * 
   * @param  BaseObject  $object
   * @return hash       (1 => FAV, -1 => AG)
   */
  protected static function getVotingDetailsFromObject(BaseObject $object)
  {
    $fields = self::getObjectVotingFields($object);
    if (!is_null($fields) && count($fields)>0) 
    {
      $details = array();
      foreach ($fields as $value => $field)
      {
        $getter = 'get'.$field; 
        if (method_exists($object, $getter))
        {
          $v = $object->$getter();
          if (!is_null($v))
            $details[$value] = $v;
        }        
      }
      if (count($details) >0) return $details;
    }
    return null;
  }
  
  
  /*
   * Contributed by Vojtech Rysanek
   */
  
  /**
   * Retrieves voting_field phpName from configuration
   * 
   * @param  BaseObject  $object
   * @return mixed
   */
  protected static function getObjectVotingField(BaseObject $object)
  {
    return sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_voting_field', 
              get_class($object)));
  }
  
  /**
   * Sets cached voting
   * 
   * @param  BaseObject  $object
   * @param  float       $value
   */
  protected static function setVotingToObject(BaseObject $object, $value)
  {
    $field = self::getObjectVotingField($object);
    if (!is_null($field)) 
    {
      $setter = 'set'.$field;
      if (method_exists($object, $setter))
      {
        $ret = $object->$setter($value);
        return $object->save();
      }
    }
  } 
  
  /**
   * Return cached voting from object
   * 
   * @param  BaseObject  $object
   * @return float
   */
  protected static function getVotingToObject(BaseObject $object)
  {
    $field = self::getObjectVotingField($object);
    if (!is_null($field)) 
    {
      $getter = 'get'.$field; 
      if (method_exists($object, $getter))
      {
        return $object->$getter();
      }
    }
    return null;
  }

}