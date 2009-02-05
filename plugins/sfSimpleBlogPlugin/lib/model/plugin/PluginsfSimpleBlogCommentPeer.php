<?php

/**
 * Subclass for performing query and update operations on the 'sf_blog_comment' table.
 *
 * 
 *
 * @package plugins.sfSimpleBlogPlugin.lib.model
 */ 
class PluginsfSimpleBlogCommentPeer extends BasesfSimpleBlogCommentPeer
{
  public static function getRecent($max = 10)
  {
    $c = new Criteria();
    $c->add(self::IS_MODERATED, false);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c->setLimit($max);

    return self::doSelectJoinAll($c);
  }

  public static function getForPost($post, $max = 10)
  {
    $c = new Criteria();
    $c->add(self::IS_MODERATED, false);
    $c->add(self::SF_BLOG_POST_ID, $post->getId());
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c->setLimit($max);

    return self::doSelectJoinAll($c);
  }
  
  public static function isAuthorApproved($author_name, $author_email)
  {
    $c = new Criteria();
    $c->add(self::AUTHOR_NAME, $author_name); 
    $c->add(self::AUTHOR_EMAIL, $author_email); 
    $c->add(self::IS_MODERATED, false); 
    $comment = self::doSelectOne($c);
    
    return ($comment instanceof sfSimpleBlogComment);
  }
}
