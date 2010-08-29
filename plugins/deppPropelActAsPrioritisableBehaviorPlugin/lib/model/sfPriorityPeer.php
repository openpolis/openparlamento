<?php

/**
 * Subclass for performing query and update operations on the 'sf_priority' table.
 *
 * 
 *
 * @package plugins.deppPropelActAsPrioritisableBehaviorPlugin.lib.model
 */ 
class sfPriorityPeer extends BasesfPriorityPeer
{
  public static function getPriorityObject($object)
  {
    $c = new Criteria();
    $c->add(sfPriorityPeer::PRIORITISABLE_ID, $object->getPrioritisableReferenceKey());
    $c->add(sfPriorityPeer::PRIORITISABLE_MODEL, get_class($object));
    return sfPriorityPeer::doSelectOne($c);
  }
  
}
