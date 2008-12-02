<?php

/**
 * Subclass for performing query and update operations on the 'sf_bookmarkings' table.
 *
 * 
 *
 * @package plugins.deppPropelActAsBookmarkableBehaviorPlugin.lib.model
 */ 
class sfBookmarkingPeer extends BasesfBookmarkingPeer
{
  
  public static function getAllPositivelyBookmarkedIds($user_id)
  {
    return self::_getAllBookmarkedIds('+', $user_id);
  }

  public static function getAllNegativelyBookmarkedIds($user_id)
  {
    return self::_getAllBookmarkedIds('-', $user_id);
  }

  /**
   * Return a hash with a list of ids of objects bookmarked (+|-) by a user
   * bookmarked_ids = array('OppAtto' => array(1, 15, 143), ...);
   *
   * @param  char(1)     +|- type of bookmarking
   * @param  mixed       $user_id  User primary key
   * @return array (see description)
   **/
  private static function _getAllBookmarkedIds($type, $user_id)
  {
    if ($type != '+' && $type != '-')
      throw new deppPropelActAsBookmarkableException('Type can only be + or -');

    if (is_null($user_id) or trim((string)$user_id) === '')
      throw new deppPropelActAsBookmarkableException('Impossible to clear a user bookmarking with no user primary key provided');
    
    $bookmarked_ids = array();

    $c = new Criteria();
    $c->add(sfBookmarkingPeer::USER_ID, $user_id); 
    $c->add(sfBookmarkingPeer::BOOKMARKING, ($type == '+'?1:-1));
    $c->clearSelectColumns(); 
    $c->addSelectColumn(sfBookmarkingPeer::BOOKMARKABLE_MODEL);
    $c->addSelectColumn(sfBookmarkingPeer::BOOKMARKABLE_ID);
    $rs = sfBookmarkingPeer::doSelectRS($c);
    while ($rs->next()) {
      $key = $rs->getString(1);
      if (!array_key_exists($key, $bookmarked_ids))
        $bookmarked_ids[$key] = array();
      
      array_push($bookmarked_ids[$key], $rs->getInt(2));
    }
    
    return $bookmarked_ids;
  }
  
  
  
  public static function getAllPositivelyBookmarked($user_id)
  {
    return self::_getAllBookmarked('+', $user_id); 
  }
  
  public static function getAllNegativelyBookmarked($user_id)
  {    
    return self::_getAllBookmarked('-', $user_id); 
  }
  
  /**
   * Return an array of objects bookmarked (+|-) by a user
   *
   * @param  char(1)     +|- type of bookmarking
   * @param  mixed       $user_id  User primary key
   * @return array of Bookmarkable objects
   **/
  private static function _getAllBookmarked($bookmarking_type, $user_id)
  { 
    if ($bookmarking_type != '+' && $bookmarking_type != '-')
      throw new deppPropelActAsBookmarkableException('Type can only be + or -');

    if (is_null($user_id) or trim((string)$user_id) === '')
      throw new deppPropelActAsBookmarkableException('Impossible to clear a user bookmarking with no user primary key provided');
    
    $bookmarked_objects = array();
    
    $bookmarked_ids = self::_getAllBookmarkedIds($bookmarking_type, $user_id);
    foreach ($bookmarked_ids as $model => $ids) {
      foreach ($ids as $id) {
        $bookmarked_objects []= deppPropelActAsBookmarkableToolkit::retrieveBookmarkableObject($model, $id);
      }
    }
    
    return $bookmarked_objects;
  }
  
  
}
