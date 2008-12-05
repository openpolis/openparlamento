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

  public static function doSelectIndirectlyMonitoredByUser($user, $criteria=null)
  {    
   
    if (!($user instanceof OppUser)) throw new Exception('A user must be specified');
    
    // build the array of monitored tags_ids
    $my_monitored_tags_pks = Util::transformIntoPKs($user->getMonitoredObjects('Tag', $criteria));
    
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
    $directly_monitored_acts_pks = Util::transformIntoPKs($user->getMonitoredObjects('OppAtto', $criteria));
    
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
    $items_pks = array_merge(Util::transformIntoPKs($items1), Util::transformIntoPKs($items2));
    return self::retrieveByPKs($items_pks);
  }
  
}
