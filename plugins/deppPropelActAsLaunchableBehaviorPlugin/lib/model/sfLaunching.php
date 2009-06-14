<?php

/**
 * Subclass for representing a row from the 'sf_launching' table.
 *
 * 
 *
 * @package plugins.deppPropelActAsLaunchableBehaviorPlugin.lib.model
 */ 
class sfLaunching extends BasesfLaunching
{

  /**
   * override per modificare la priorità dei comunicati di governo
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
      switch ($this->getObjectModel())
      {
        case 'OppAtto':
          $cacheManager->remove('atto/index?id='.$this->getObjectId());
          break;
        case 'OppVotazione':
          $cacheManager->remove('votazione/index?id='.$this->getObjectId());
          break;        
      }
      $cacheManager->remove('default/index');
    }
    
  }
  
}
