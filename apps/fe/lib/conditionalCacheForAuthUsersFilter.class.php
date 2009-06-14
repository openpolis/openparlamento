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
        $context->getViewCacheManager()->addCache($page['module'], $page['action'], array('lifeTime' => 86400));
      }
    }
 
    // Execute next filter
    $filterChain->execute();
  }
}