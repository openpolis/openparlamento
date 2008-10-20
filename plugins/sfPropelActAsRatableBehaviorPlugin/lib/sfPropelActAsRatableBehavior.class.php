<?php
/*
 * This file is part of the sfPropelActAsRatableBehavior package.
 *
 * (c) 2007 Nicolas Perriault <nperriault@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This Propel behavior aims at providing rating capabilities on any Propel
 * object
 *
 * @package    plugins
 * @subpackage rating 
 * @author     Nicolas Perriault <nperriault@gmail.com>
 * @author     Fabian Lange
 * @author     Vojtech Rysanek
 */
class sfPropelActAsRatableBehavior
{
  
  /**
   * Default default max rating
   */
  const DEFAULT_MAX_RATING = 5;
  
  /**
   * Default float precision
   */
  const DEFAULT_PRECISION = 2;
  
  /**
   * Counts ratings made on given ratable object.
   * 
   * @param  BaseObject  $object
   * @return int
   */
  public function countRatings(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfRatingPeer::RATABLE_ID, $object->getReferenceKey());
    $c->add(sfRatingPeer::RATABLE_MODEL, get_class($object));
    return sfRatingPeer::doCount($c);
  }

  /**
   * Retrieves configured float precision for ratings
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
    return sfConfig::get('app_rating_precision', $default_precision);
  }
  
  /**
   * Retrieves an existing rating object, or return a new empty one
   *
   * @param  BaseObject  $object
   * @param  mixed       $user_id  Unique user primary key
   * @return sfRating
   * @throws sfPropelActAsRatableException
   **/
  protected static function getOrCreate(BaseObject $object, $user_id = null)
  {
    if ($object->isNew())
    {
      throw new sfPropelActAsRatableException('Unsaved objects are not ratable');
    }
    
    if (is_null($user_id))
    {
      return new sfRating();
    }
    
    $c = new Criteria();
    $c->add(sfRatingPeer::RATABLE_ID, $object->getReferenceKey());
    $c->add(sfRatingPeer::RATABLE_MODEL, get_class($object));
    $c->add(sfRatingPeer::USER_ID, $user_id);
    $user_rating = sfRatingPeer::doSelectOne($c);
    return is_null($user_rating) ? new sfRating() : $user_rating;
  }

  /**
   * Clear all ratings for an object
   *
   * @param  BaseObject  $object
   **/
  public function clearRatings(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfRatingPeer::RATABLE_ID, $object->getReferenceKey());
    $c->add(sfRatingPeer::RATABLE_MODEL, get_class($object));
    $ret = sfRatingPeer::doDelete($c);
    self::setRatingToObject($object, 0);
    return $ret;
  }

  /**
   * Clear user rating for an object
   *
   * @param  BaseObject  $object
   * @param  mixed       $user_id  User primary key
   **/
  public function clearUserRating(BaseObject $object, $user_id)
  {
    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new sfPropelActAsRatableException('Impossible to clear a user rating with no user primary key provided');
    }
    
    $c = new Criteria();
    $c->add(sfRatingPeer::RATABLE_ID, $object->getReferenceKey());
    $c->add(sfRatingPeer::RATABLE_MODEL, get_class($object));
    $c->add(sfRatingPeer::USER_ID, $user_id);
    $ret = sfRatingPeer::doDelete($c);
    self::setRatingToObject($object, $this->getRating($object, self::getPrecision(), true));
    return $ret;
  }

  /**
   * Checks if an Object has been rated
   *
   * @param  BaseObject  $object
   **/
  public function hasBeenRated(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfRatingPeer::RATABLE_ID, $object->getReferenceKey());
    $c->add(sfRatingPeer::RATABLE_MODEL, get_class($object));
    return sfRatingPeer::doCount($c) > 0;
  }

  /**
   * Checks if an Object has been rated by a user
   *
   * @param  BaseObject  $object
   * @param  mixed       $user_id  Unique reference to a user
   **/
  public function hasBeenRatedByUser(BaseObject $object, $user_id)
  {
    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new sfPropelActAsRatableException(
        'Impossible to check a user rating with no user primary key provided');
    }
    $c = new Criteria();
    $c->add(sfRatingPeer::RATABLE_ID, $object->getReferenceKey());
    $c->add(sfRatingPeer::RATABLE_MODEL, get_class($object));
    $c->add(sfRatingPeer::USER_ID, $user_id);
    return (sfRatingPeer::doCount($c) > 0);
  }
  
  /**
   * Old method to set maximum rating in a class constant
   * This stays here for compability purpose
   * 
   * @param  BaseObject  $object
   * @return int
   */
  protected static function getDefaultMaxRating(BaseObject $object)
  {
    $max_rating = @constant(get_class($object).'::MAX_RATING');
    if (!is_int($max_rating))
    {
      $max_rating = self::DEFAULT_MAX_RATING;
    }
    return $max_rating;
  }

  /**
   * Retrieves maximum rating for given object
   * 
   * @param  BaseObject  $object  Propel object instance
   * @return int
   * @throws sfPropelActAsRatableException
   */
  public function getMaxRating(BaseObject $object)
  {
    $max_rating = sfConfig::get(
      sprintf('propel_behavior_sfPropelActAsRatableBehavior_%s_max_rating', 
              get_class($object)));
    
    if (is_null($max_rating))
    {
      $max_rating = self::getDefaultMaxRating($object);
    }
    
    if (!is_int($max_rating))
    {
      throw new sfPropelActAsRatableException(
        'The max_rating parameter must be an integer');
    }
    
    if (is_float($max_rating) && floor($max_rating) != $max_rating) // yeah, php typing sucks...
    {
      throw new sfPropelActAsRatableException(
        sprintf('You cannot type %s::MAX_RATING as float (you provided "%s")', 
                get_class($object),
                $max_rating));
    }
    
    if ($max_rating < 2)
    {
      throw new sfPropelActAsRatableException(
        'The max_rating parameter must be an integer greater than 1');
    }
    
    return $max_rating;
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
      sprintf('propel_behavior_sfPropelActAsRatableBehavior_%s_reference_field', 
              get_class($object)));
  }
  
  /**
   * Retrieves reference key for current ratable object (default returns 
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
        throw new sfPropelActAsRatableException(
          'A reference field must be typed as integer');
      }
      return $ret;
    }
  }

  /**
   * Retrieves the object rating
   *
   * @param  BaseObject  $object
   * @param  int         $precision   Result float precision
   * @return float
   **/
  public function getRating(BaseObject $object, $precision=2, $docount=false)
  {
    if ($docount === false && !is_null(self::getObjectRatingField($object)))
    {
      return round(self::getRatingToObject($object), self::getPrecision());
    }
    
    $c = new Criteria();
    $c->add(sfRatingPeer::RATABLE_ID, $object->getReferenceKey());
    $c->add(sfRatingPeer::RATABLE_MODEL, get_class($object));
    $c->clearSelectColumns();
    $c->addAsColumn('nb_ratings', 'COUNT('.sfRatingPeer::ID.')');
    $c->addAsColumn('total', 'SUM('.sfRatingPeer::RATING.')');
    $c->addGroupByColumn(sfRatingPeer::RATABLE_MODEL);
    $rs = sfRatingPeer::doSelectRS($c);
    $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);
    while ($rs->next())
    {
      $nb_ratings = $rs->getInt('nb_ratings');
      $total      = $rs->getInt('total');
      if (!$nb_ratings or $nb_ratings === 0)
      {
        return NULL; // Object has not been rated yet
      }
      return round($total / $nb_ratings, self::getPrecision($precision));
    }
  }
  
  /**
   * Gets the object rating details
   *
   * @author Fabian Lange
   * @author Nicolas Perriault
   * @param  BaseObject  $object
   * @param  boolean     $include_all  Shall we include all available ratings?
   * @return associative array containing (rating => count)
   **/
  public function getRatingDetails(BaseObject $object, $include_all = false)
  {
    $c = new Criteria();
    $c->add(sfRatingPeer::RATABLE_ID, $object->getReferenceKey());
    $c->add(sfRatingPeer::RATABLE_MODEL, get_class($object));
    $c->clearSelectColumns();
    $c->addAsColumn('nb_ratings', 'COUNT('.sfRatingPeer::ID.')');
    $c->addAsColumn('rating', sfRatingPeer::RATING);
    $c->addGroupByColumn(sfRatingPeer::RATING);
    $rs = sfRatingPeer::doSelectRS($c);
    $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);
    $details = array();
    while ($rs->next())
    {
      $details = $details + array ($rs->getInt('rating') => (int)$rs->getString('nb_ratings'));
    }
    if ($include_all === true)
    {
      for ($i=1; $i<=$object->getMaxRating(); $i++)
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
   * Gets the object rating for given user pk
   *
   * @param  BaseObject  $object
   * @param  mixed       $user_id  User primary key
   * @return int or false
   **/
  public function getUserRating(BaseObject $object, $user_id)
  {
    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new sfPropelActAsRatableException(
        'Impossible to get a user rating with no user primary key provided');
    }
    
    $c = new Criteria();
    $c->add(sfRatingPeer::RATABLE_ID, $object->getReferenceKey());
    $c->add(sfRatingPeer::RATABLE_MODEL, get_class($object));
    $c->add(sfRatingPeer::USER_ID, $user_id);
    $rating_object = sfRatingPeer::doSelectOne($c);
    if (!is_null($rating_object))
    {
      return $rating_object->getRating();
    }
  }
  
  /**
   * Retrieves ratable object instance from class name and key
   * 
   * @param  string  $class_name
   * @param  int     $key
   * @return BaseObject
   */
  public static function retrieveByKey($object_name, $key)
  {
    if (!class_exists($object_name))
    {
      throw new sfPropelActAsRatableException('Class %s does not exist', 
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
   * Rates the Object
   *
   * @param  BaseObject  $object
   * @param  int         $rating
   * @param  mixed       $user_id  Optionnal unique reference to user
   * @throws sfPropelActAsRatableException
   **/
  public function setRating(BaseObject $object, $rating, $user_id = null)
  {
    if (is_float($rating) && floor($rating) != $rating)
    {
      throw new sfPropelActAsRatableException(
        sprintf('You cannot rate an object with a float (you provided "%s")', 
                $rating));
    }
    
    $rating = (int)$rating;
    
    if ($rating > $object->getMaxRating())
    {
      throw new sfPropelActAsRatableException(
        sprintf('Maximum rating is %d', $object->getMaxRating()));
    }
    
    if ($rating < 1)
    {
      throw new sfPropelActAsRatableException('Minimum rating is 1');
    }
    
    $rating_object = self::getOrCreate($object, $user_id);
    $rating_object->setRatableModel(get_class($object));
    $rating_object->setRatableId($object->getReferenceKey());
    $rating_object->setUserId($user_id);
    $rating_object->setRating($rating);
    $ret = $rating_object->save();
    self::setRatingToObject($object, $this->getRating($object, self::getPrecision(), true));
    return $ret;
  }
  
  /**
   * Deletes all rating for a ratable object (delete cascade emulation)
   * 
   * @param  BaseObject  $object
   */
  public function preDelete(BaseObject $object)
  {
    try
    {
      $c = new Criteria();
      $c->add(sfRatingPeer::RATABLE_ID, $object->getReferenceKey());
      sfRatingPeer::doDelete($c);
    }
    catch (Exception $e)
    {
      throw new sfPropelActAsRatableException(
        'Unable to delete ratable object related ratings records');
    }
  }
  
  /*
   * Contributed by Vojtech Rysanek
   */
  
  /**
   * Retrieves rating_field phpName from configuration
   * 
   * @param  BaseObject  $object
   * @return mixed
   */
  protected static function getObjectRatingField(BaseObject $object)
  {
    return sfConfig::get(
      sprintf('propel_behavior_sfPropelActAsRatableBehavior_%s_rating_field', 
              get_class($object)));
  }
  
  /**
   * Sets cached rating
   * 
   * @param  BaseObject  $object
   * @param  float       $value
   */
  protected static function setRatingToObject(BaseObject $object, $value)
  {
    $field = self::getObjectRatingField($object);
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
   * Return cached rating from object
   * 
   * @param  BaseObject  $object
   * @return float
   */
  protected static function getRatingToObject(BaseObject $object)
  {
    $field = self::getObjectRatingField($object);
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