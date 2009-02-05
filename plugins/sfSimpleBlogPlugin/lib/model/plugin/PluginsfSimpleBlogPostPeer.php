<?php

/**
 * Subclass for performing query and update operations on the 'sf_blog_post' table.
 *
 * 
 *
 * @package plugins.sfSimpleBlogPlugin.lib.model
 */ 
class PluginsfSimpleBlogPostPeer extends BasesfSimpleBlogPostPeer
{
  public static function getRecentPager($max, $page)
  {
    $pager = new sfPropelPager('sfSimpleBlogPost', $max);
    $c = new Criteria();
    $c->add(self::IS_PUBLISHED, true);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinAll');
    $pager->init();

    return $pager;
  }

  public static function getRecent($max = 10)
  {
    $c = new Criteria();
    $c->add(self::IS_PUBLISHED, true);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c->setLimit($max);

    return self::doSelectJoinAll($c);
  }

  public static function getTaggedPager($tag, $max, $page)
  {
    $pager = new sfPropelPager('sfSimpleBlogPost', $max);
    $c = new Criteria();
    $c->addJoin(sfSimpleBlogTagPeer::SF_BLOG_POST_ID, self::ID);
    $c->add(sfSimpleBlogTagPeer::TAG, $tag);
    $c->add(self::IS_PUBLISHED, true);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinAll');
    $pager->init();

    return $pager;
  }

  public static function getTagged($tag, $max)
  {
    $c = new Criteria();
    $c->addJoin(sfSimpleBlogTagPeer::SF_BLOG_POST_ID, self::ID);
    $c->add(sfSimpleBlogTagPeer::TAG, $tag);
    $c->add(self::IS_PUBLISHED, true);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c->setLimit($max);

    return sfSimpleBlogPostPeer::doSelectJoinAll($c);
  }

  public static function retrieveByStrippedTitleAndDate($text, $date, $con = null)
  {
    if ($con === null) 
    {
      $con = Propel::getConnection(self::DATABASE_NAME);
    }

    $criteria = new Criteria(sfSimpleBlogPostPeer::DATABASE_NAME);
    $criteria->add(sfSimpleBlogPostPeer::STRIPPED_TITLE, $text);
    if (sfConfig::get('app_sfSimpleBlog_use_date_in_url', false))
    {
      $criteria->add(sfSimpleBlogPostPeer::PUBLISHED_AT, $date);
    }

    $v = sfSimpleBlogPostPeer::doSelect($criteria, $con);

    return !empty($v) > 0 ? $v[0] : null;
  }
}
