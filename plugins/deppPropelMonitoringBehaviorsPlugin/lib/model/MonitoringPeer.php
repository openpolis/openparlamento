<?php

/**
 * Subclass for performing query and update operations on the 'sf_monitoring' table.
 *
 * 
 *
 * @package plugins.deppPropelMonitoringBehaviorsPlugin.lib.model
 */ 
class MonitoringPeer extends BaseMonitoringPeer
{
  
  public static function getModelsPKsMonitoredByUsers($monitorers_pks)
  {
    $c = new Criteria();
    $c->setDistinct();
    $c->clearSelectColumns();
    $c->addSelectColumn(self::MONITORABLE_MODEL);
    $c->add(self::USER_ID, $monitorers_pks, Criteria::IN);

    $rs = self::doSelectRS($c);
    $models = array();
    while($rs->next())
      $models[] = $rs->getString(1);
    
    return $models;
  }
  
  public static function getItemsPKsMonitoredByUsers($monitorers_pks, $model = null)
  {
    $c = new Criteria();
    $c->setDistinct();
    $c->clearSelectColumns();
    $c->addSelectColumn(self::MONITORABLE_ID);
    $c->add(self::USER_ID, $monitorers_pks, Criteria::IN);
    if (!is_null($model))
      $c->add(self::MONITORABLE_MODEL, $model);

    $rs = self::doSelectRS($c);
    $pks = array();
    while($rs->next())
      $pks[] = $rs->getInt(1);
    
    return $pks;    
  }

  public static function getItemsMonitoredByUsers($monitorers_pks, $model = null)
  {
    $items_pks = self::getItemsPKsMonitoredByUsers($monitorers_pks, $model);
    $items = call_user_func_array(array($model."Peer", 'retrieveByPKs'), array($items_pks));
    return $items;
  }
  
  public static function compareItemsByMonitoringUsers($a, $b)
  {
    if ($a->getNMonitoringUsers() < $b->getNMonitoringUsers()) return 1;
    if ($a->getNMonitoringUsers() == $b->getNMonitoringUsers()) return 0;
    if ($a->getNMonitoringUsers() > $b->getNMonitoringUsers()) return -1;    
  }
}
