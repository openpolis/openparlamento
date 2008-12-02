<?php
/*
 * This file is part of the deppPropelActAsBookmarkableBehavior package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * This Propel behavior aims at allowing the user to bookmark any Propel
 * object in a positive or negative weay
 * 
 *
 * @package    plugins
 * @subpackage bookmarking 
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com>
 * @author     Nicolar Perriault
 * @author     Fabian Lange
 * @author     Vojtech Rysanek
 */
class deppPropelActAsBookmarkableBehavior
{
  
  public function countPositiveBookmarkings(BaseObject $object)
  {
    return self::_countBookmarkings($object, '+');
  }

  public function countNegativeBookmarkings(BaseObject $object)
  {
    return self::_countBookmarkings($object, '-');
  }
  
  /**
   * Counts how many bookmarkings have been made on the given bookmarkable object.
   * 
   * @param  BaseObject  $object
   * @param  char(1)     +|- type of bookmarking
   * @return int
   */
  private static function _countBookmarkings(BaseObject $object, $type)
  {
    if ($type != '+' && $type != '-')
      throw new deppPropelActAsBookmarkableException('Type can only be + or -');

    $c = new Criteria();
    $c->add(sfBookmarkingPeer::BOOKMARKABLE_ID, $object->getBookmarkableReferenceKey());
    $c->add(sfBookmarkingPeer::BOOKMARKABLE_MODEL, get_class($object));
    $c->add(sfBookmarkingPeer::BOOKMARKING, ($type == '+'?1:-1));
    return sfBookmarkingPeer::doCount($c);
  }


  /**
   * Clear all bookmarkings for an object
   *
   * @param  BaseObject  $object
   **/
  public function removeAllBookmarkings(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfBookmarkingPeer::BOOKMARKABLE_ID, $object->getBookmarkableReferenceKey());
    $c->add(sfBookmarkingPeer::BOOKMARKABLE_MODEL, get_class($object));
    $ret = sfBookmarkingPeer::doDelete($c);
    return $ret;
  }

  public function removePositiveBookmarking(BaseObject $object, $user_id)
  {
    return self::_removeUserBookmarking($object, '+', $user_id);
  }
  
  public function removeNegativeBookmarking(BaseObject $object, $user_id)
  {
    return self::_removeUserBookmarking($object, '-', $user_id);
  }

  /**
   * Clear user bookmarking for an object
   *
   * @param  BaseObject  $object
   * @param  char(1)     +|- type of bookmarking
   * @param  mixed       $user_id  User primary key
   **/
  private static function _removeUserBookmarking(BaseObject $object, $type, $user_id)
  {
    if ($type != '+' && $type != '-')
      throw new deppPropelActAsBookmarkableException('Type can only be + or -');

    if (is_null($user_id) or trim((string)$user_id) === '')
      throw new deppPropelActAsBookmarkableException('Impossible to clear a user bookmarking with no user primary key provided');
    
    $c = new Criteria();
    $c->add(sfBookmarkingPeer::BOOKMARKABLE_ID, $object->getBookmarkableReferenceKey());
    $c->add(sfBookmarkingPeer::BOOKMARKABLE_MODEL, get_class($object));
    $c->add(sfBookmarkingPeer::USER_ID, $user_id);
    $c->add(sfBookmarkingPeer::BOOKMARKING, ($type == '+'?1:-1));
    $ret = sfBookmarkingPeer::doDelete($c);
    return $ret;
  }



  public function hasBeenPositivelyBookmarked(BaseObject $object, $user_id)
  {
    return self::_hasBeenBookmarkedByUser($object, '+', $user_id);
  }

  public function hasBeenNegativelyBookmarked(BaseObject $object, $user_id)
  {
    return self::_hasBeenBookmarkedByUser($object, '-', $user_id);
  }

  /**
   * Checks if an Object has been bookmarked by a user
   *
   * @param  BaseObject  $object
   * @param  char(1)     +|- type of bookmarking
   * @param  mixed       $user_id  Unique reference to a user
   * @throws deppPropelActAsBookmarkableException
   * @return Boolean
   **/
  private static function _hasBeenBookmarkedByUser(BaseObject $object, $type, $user_id)
  {
    if ($type != '+' && $type != '-')
      throw new deppPropelActAsBookmarkableException('Type can only be + or -');

    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new deppPropelActAsBookmarkableException(
        'Impossible to check a user bookmarking with no user primary key provided');
    }

    
    $c = new Criteria();
    $c->add(sfBookmarkingPeer::BOOKMARKABLE_ID, $object->getBookmarkableReferenceKey());
    $c->add(sfBookmarkingPeer::BOOKMARKABLE_MODEL, get_class($object));
    $c->add(sfBookmarkingPeer::USER_ID, $user_id);
    $c->add(sfBookmarkingPeer::BOOKMARKING, ($type == '+'?1:-1));
    $count = sfBookmarkingPeer::doCount($c);
    if ($count) return true;
    else return false;
  }
  
  
  
  public function setPositiveBookmarking(BaseObject $object, $user_id)
  {
    return self::_setBookmarking($object, '+', $user_id);
  }

  public function setNegativeBookmarking(BaseObject $object, $user_id)
  {
    return self::_setBookmarking($object, '-', $user_id);
  }

  /**
   * bookmarks the Object
   *
   * @param  BaseObject  $object
   * @param  char(1)     +|- type of bookmarking
   * @param  mixed       $user_id  unique reference to user
   * @throws deppPropelActAsBookmarkableException
   **/
  private function _setBookmarking(BaseObject $object, $type, $user_id)
  {
    if ($type != '+' && $type != '-')
      throw new deppPropelActAsBookmarkableException('Type can only be + or -');

    if (is_null($user_id) or trim((string)$user_id) === '')
    {
      throw new deppPropelActAsBookmarkableException(
        'Impossible to check a user bookmarking with no user primary key provided');
    }
    
    $bookmarking_object = self::getOrCreate($object, $user_id);
    $bookmarking_object->setBookmarkableModel(get_class($object));
    $bookmarking_object->setBookmarkableId($object->getBookmarkableReferenceKey());
    $bookmarking_object->setUserId($user_id);
    $bookmarking_object->setBookmarking( ($type == '+'?1:-1) );
    $ret = $bookmarking_object->save();

    return $ret;
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
      sprintf('propel_behavior_deppPropelActAsBookmarkableBehavior_%s_reference_field', 
              get_class($object)));
  }
  
  /**
   * Retrieves reference key for current bookmarkable object 
   * (as a default returns primary key)
   * 
   * @param  BaseObject $object
   * @return int
   */
  public function getBookmarkableReferenceKey(BaseObject $object)
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
        throw new deppPropelActAsBookmarkableException(
          'A reference field must be typed as integer');
      }
      return $ret;
    }
  }

  
  /**
   * Retrieves an existing bookmarking object, or return a new empty one
   *
   * @param  BaseObject  $object
   * @param  mixed       $user_id  Unique user primary key
   * @return sfBookmarking
   * @throws deppPropelActAsBookmarkableException
   **/
  protected static function getOrCreate(BaseObject $object, $user_id)
  {
    if ($object->isNew())
    {
      throw new deppPropelActAsBookmarkableException('Unsaved objects are not bookmarkable');
    }
    
    if (is_null($user_id))
    {
      throw new deppPropelActAsBookmarkableException('Anonymous bookmarking not allowed');
    }
    
    $c = new Criteria();
    $c->add(sfBookmarkingPeer::BOOKMARKABLE_ID, $object->getBookmarkableReferenceKey());
    $c->add(sfBookmarkingPeer::BOOKMARKABLE_MODEL, get_class($object));
    $c->add(sfBookmarkingPeer::USER_ID, $user_id);
    $user_bookmarking = sfBookmarkingPeer::doSelectOne($c);
    return is_null($user_bookmarking) ? new sfBookmarking() : $user_bookmarking;
  }

   
  /**
   * Deletes all bookmarking for a bookmarkable object (delete cascade emulation)
   * 
   * @param  BaseObject  $object
   */
  public function preDelete(BaseObject $object)
  {
    try
    {
      $c = new Criteria();
      $c->add(sfBookmarkingPeer::BOOKMARKABLE_ID, $object->getBookmarkableReferenceKey());
      sfBookmarkingPeer::doDelete($c);
    }
    catch (Exception $e)
    {
      throw new deppPropelActAsBookmarkableException(
        'Unable to delete bookmarkable object related bookmarkings records');
    }
  }
  

}