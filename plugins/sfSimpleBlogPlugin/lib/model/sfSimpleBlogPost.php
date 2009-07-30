<?php

/**
 * Subclass for representing a row from the 'sf_blog_post' table.
 *
 * 
 *
 * @package plugins.sfSimpleBlogPlugin.lib.model
 */ 
class sfSimpleBlogPost extends PluginsfSimpleBlogPost
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

    if (sfConfig::get('sf_app') == 'be')
    {
      # the fe application's viewCacheMNanager should be reached, but
      # this requires a context switch, only available in sf 1.1 (!)
      # a possible solution is to set up an api
      # http://$site_url/clearcache?cache_unique_id
      # cache_unique_id should be url_encoded, and decoded on the server
      # response should be ok or ko
    } else {      
      $cacheManager = sfContext::getInstance()->getViewCacheManager();
    }

    if ($cacheManager)
    {
      $internalUri = sfRouting::getInstance()->getCurrentInternalUri();
      sfLogger::getInstance()->info(sprintf("{gDebug} inside sfSimpleBlogPost::clearCacheOnUpdate - internalUri:%s.", $internalUri));
      $cacheManager->remove('sfSimpleBlog/show?id='.$this->getId());
      $cacheManager->remove('sfSimpleBlog/index');
      $cacheManager->remove('default/index');
    }      



    
  }
  
}
