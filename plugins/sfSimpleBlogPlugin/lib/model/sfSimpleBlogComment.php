<?php

/**
 * Subclass for representing a row from the 'sf_blog_comment' table.
 *
 * 
 *
 * @package plugins.sfSimpleBlogPlugin.lib.model
 */ 
class sfSimpleBlogComment extends PluginsfSimpleBlogComment
{
  /**
   * override per rimuovere la cache prima del salvataggio
   *
   * @param string $con 
   * @return void
   * @author Guglielmo Celata
   */
  public function save($con = null)
  {
    
    $this->clearCacheOnUpdate();
    
    return parent::save();

  }

  /**
   * clear some cached stuff before the object is modified
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function clearCacheOnUpdate()
  {
    $cacheManager = sfContext::getInstance()->getViewCacheManager();
    if ($cacheManager)
    {
      $cacheManager->remove('sfSimpleBlog/show?id='.$this->getSfBlogPostId());
      $cacheManager->remove('sfSimpleBlog/index');
    }
    
  }
  
}
