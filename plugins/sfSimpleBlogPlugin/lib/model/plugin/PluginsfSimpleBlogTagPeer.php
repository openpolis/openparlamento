<?php

/**
 * Subclass for performing query and update operations on the 'sf_blog_tag' table.
 *
 * 
 *
 * @package plugins.sfSimpleBlogPlugin.lib.model
 */ 
class PluginsfSimpleBlogTagPeer extends BasesfSimpleBlogTagPeer
{
  public static function getTagsWithCount()
  {
    $c = new Criteria();
    $c->clearSelectColumns()->clearOrderByColumns();
    $c->addSelectColumn(self::TAG);
    $c->addSelectColumn('count('.self::SF_BLOG_POST_ID.') as count');
    $c->addGroupByColumn(self::TAG);
    $rs = self::doSelectRS($c);
    $tags = array();
    while ($rs->next())
    {
      $tags[] = array($rs->getString(1), $rs->getInt(2));
    }

    return $tags;
  }
}
