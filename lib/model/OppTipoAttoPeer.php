<?php

/**
 * Subclass for performing query and update operations on the 'opp_tipo_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppTipoAttoPeer extends BaseOppTipoAttoPeer
{
  /**
   * transform an array of objects into an array of Primary Keys
   *
   * @return void
   * @author Guglielmo Celata
   **/
  private static function transformIntoPKs($objects)
  {
    // creates a callback function able to invoke the object's getPrimaryKey method
    $getPK_callback = create_function('$e', 'return call_user_func(array($e, "getPrimaryKey"));');
    return array_map($getPK_callback, $objects);
  }

  public static function doSelectIndirectlyMonitoredByUser($user, $criteria=null)
  {    
   
    if (!($user instanceof OppUser)) throw new Exception('A user must be specified');
    
    // build the array of monitored tags_ids
    $my_monitored_tags_pks = self::transformIntoPKs($user->getMonitoredObjects('Tag', $criteria));

    
    
    // fetch all acts types tagged with the monitored tags (indirect monitoring)
    $c = new Criteria();
    $c->addJoin(OppTipoAttoPeer::ID, OppAttoPeer::TIPO_ATTO_ID);
    $c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
    $c->add(TaggingPeer::TAG_ID, $my_monitored_tags_pks, Criteria::IN);
    $c->addGroupByColumn(OppAttoPeer::TIPO_ATTO_ID);
    $indirectly_monitored_acts_types = OppTipoAttoPeer::doSelect($c);
    unset($c);

    return $indirectly_monitored_acts_types;
    
  }
  
  public static function doSelectDirectlyMonitoredByUser($user, $criteria=null)
  {
    
    if (!($user instanceof OppUser)) throw new Exception('A user must be specified');

    // fetch directly monitored acts
    $directly_monitored_acts_pks = self::transformIntoPKs($user->getMonitoredObjects('OppAtto', $criteria));
    
    // fetch types of acts directly monitored
    $c = new Criteria();
    $c->addJoin(OppTipoAttoPeer::ID, OppAttoPeer::TIPO_ATTO_ID);    
    $c->addGroupByColumn(OppAttoPeer::TIPO_ATTO_ID);
    $c->add(OppAttoPeer::ID, $directly_monitored_acts_pks, Criteria::IN);
    $directly_monitored_acts_types = OppTipoAttoPeer::doSelect($c);
    unset($c);
    
    return $directly_monitored_acts_types;
    
  }

  public static function merge($items1, $items2)
  {
    // merge directly and indirectly monitored acts types
    $items_pks = array_merge(self::transformIntoPKs($items1), self::transformIntoPKs($items2));
    return self::retrieveByPKs($items_pks);
  }
  
}
