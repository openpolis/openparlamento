<?php

/**
 * Subclass for performing query and update operations on the 'sf_community_news_cache' table.
 *
 * 
 *
 * @package plugins.deppPropelMonitoringBehaviorsPlugin.lib.model
 */ 
class CommunityNewsPeer extends BaseCommunityNewsPeer
{
  public static function getLatestActivities( $limit = 0 )
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(CommunityNewsPeer::CREATED_AT); 
    if ($limit != 0)
      $c->setLimit($limit);
    return CommunityNewsPeer::doSelect($c);
  }
  
}
