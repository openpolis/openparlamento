<?php
class conditionalCacheForAuthUsersFilter extends sfFilter
{
  public function execute($filterChain)
  {
    $context = $this->getContext();
    if (!$context->getUser()->isAuthenticated())
    {
      foreach ($this->getParameter('pages') as $page)
      {
        if ($context->getViewCacheManager())
        {
          $context->getViewCacheManager()->addCache($page['module'], $page['action'], 
                                                    array('lifeTime' => array_key_exists('lifetime', $page)?$page['lifetime']:86400));          
        }
      }
    }
 
    // Execute next filter
    $filterChain->execute();
  }
}