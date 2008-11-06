<?php

/**
 *
 * @package    symfony
 * @subpackage plugin      
 * @version    SVN: $Id$
 */

require_once(sfConfig::get('sf_plugins_dir'). '/nahoWikiPlugin/modules/nahoWiki/lib/BasenahoWikiComponents.class.php');

class nahoWikiComponents extends BasenahoWikiComponents
{
  public function executeShowContent()
  {
    // store the referer in the user's session
    $referer = $this->getRequest()->getUri();
    $this->getUser()->setAttribute('referer', $referer);
    
    // Retrieve page and revision
    $this->page = nahoWikiPagePeer::retrieveByName($this->page_name);
    if ($this->page)
      $this->revision = $this->page->getRevision();
    
  }
}
