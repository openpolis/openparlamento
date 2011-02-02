<?php

/**
 * sfSimpleGoogleSitemap actions.
 *
 * @package    onlinesid
 * @subpackage sfSimpleGoogleSitemap
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class sfSimpleGoogleSitemapActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request=null)
  {
    if (!$request) $request = $this->getRequest();
    
    // initialise google sitemap generator
    $simple_sitemap = new sfSimpleGoogleSitemap();
    $simple_sitemap->processConfig();
    $this->simple_sitemap = $simple_sitemap;
  }
  
  public function executeTest($request=null)
  {
    $path = sfConfig::get('sf_plugins_dir').'/DbFinderPlugin';
    if (file_exists($path))
    {
      echo "Yeah";
    }
    else
    {
      echo "Nooe";
    }
    
    return sfView::NONE;
  }
}
