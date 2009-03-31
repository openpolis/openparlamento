<?php

/**
 * Subclass for representing a row from the 'sf_blog_post' table.
 *
 * 
 *
 * @package plugins.sfSimpleBlogPlugin.lib.model
 */ 
class PluginsfSimpleBlogPost extends BasesfSimpleBlogPost
{
  protected $nbComments = null;
  
  public function setTitle($text)
  {
    parent::setTitle($text);

    $this->setStrippedTitle(sfSimpleBlogTools::stripText($text)); 
  }

  public function getAuthor()
  {
    $getUserMethod = 'get'.sfConfig::get('app_sfSimpleBlog_user_class', 'sfGuardUser');
    if (!method_exists($this, $getUserMethod))
    {
      throw new sfException(sprintf('Method sfSimpleBlogPost::%s does not exist - check the sfSimpleBlog_user_class parameter of the app.yml file', $getUserMethod)); 
    }

    return call_user_func(array($this, $getUserMethod));
  }

  public function getComments()
  {
    $c = new Criteria();
    $c->addJoin(sfSimpleBlogPostPeer::ID, sfSimpleBlogCommentPeer::SF_BLOG_POST_ID);
    $c->add(sfSimpleBlogCommentPeer::IS_MODERATED, false);
    $c->addAscendingOrderByColumn(sfSimpleBlogCommentPeer::CREATED_AT);

    return parent::getsfSimpleBlogComments($c);
  }

  public function getNbComments()
  {
    if ($this->nbComments === null) 
    {
      $c = new Criteria();
      $c->addJoin(sfSimpleBlogPostPeer::ID, sfSimpleBlogCommentPeer::SF_BLOG_POST_ID);
      $c->add(sfSimpleBlogCommentPeer::IS_MODERATED, false);

      $this->nbComments = parent::countsfSimpleBlogComments($c);
    }
    
    return $this->nbComments;
  }

  public function getTagsAsString()
  {
    $c = new Criteria();
    $c->clearSelectColumns()->clearOrderByColumns();
    $c->addSelectColumn(sfSimpleBlogTagPeer::TAG);
    $c->add(sfSimpleBlogTagPeer::SF_BLOG_POST_ID, $this->getId());
    $rs = sfSimpleBlogPostPeer::doSelectRS($c);
    $tags = array();
    while ($rs->next())
    {
      $tags[] = $rs->getString(1);
    }

    return implode($tags, ',');
  }

  public function setTagsAsString($tagString)
  {
    $c = new Criteria();
    $c->add(sfSimpleBlogTagPeer::SF_BLOG_POST_ID, $this->getId());
    sfSimpleBlogTagPeer::doDelete($c);

    $tags = explode(',', $tagString);

    foreach ($tags as $tag)
    {
      if (!$tag)
      {
        continue;
      }

      $tagObject = new sfSimpleBlogTag();
      $tagObject->setTag($tag);
      $tagObject->setSfBlogPostId($this->getId());
      $tagObject->setSfSimpleBlogPost($this);
      $tagObject->save();
    }
  }

  public function getFeedLink()
  {
    return sfSimpleBlogTools::generatePostUri($this);
  }

  public function allowComments()
  {
    if ($this->getAllowComments())
    {
      $validity = sfConfig::get('app_sfSimpleBlog_comment_disable_after', 0);
      if ($validity == 0 || $this->getPublishedSinceDays() < $validity)
      {
        return true;
      }
    }

    return false;
  }

  public function getPublishedSinceDays()
  {
    return round((time() - $this->getPublishedAt('U')) / (24 * 60 * 60));
  }

  public function setIsPublished($flag)
  {
    if ($flag == true && !$this->getPublishedAt())
    {
      $this->setPublishedAt(date("Y-m-d"));
    }
    
    parent::setIsPublished($flag);
  }

}
