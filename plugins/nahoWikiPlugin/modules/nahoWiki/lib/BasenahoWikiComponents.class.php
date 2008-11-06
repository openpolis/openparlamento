<?php

/**
 *
 * @package    symfony
 * @subpackage plugin             
 * @version    SVN: $Id$
 */

class BasenahoWikiComponents extends sfComponents
{
  
  public function executeContent()
  {
    if (!isset($this->hide_toc)) {
      $this->hide_toc = !sfConfig::get('app_nahoWikiPlugin_include_toc', true);
    }
    
    $start = sfConfig::get('app_nahoWikiPlugin_start_page', 'index');
    if (!($page_name = $this->pagename)) {
      $page_name = $start;
    }
     
    // Support default page if not specified in namespace
    if (substr($page_name, -1) == ':') {
      $page_name .= $start;
    }
    
    // Retrieve the page, or start a new one if cannot be found
    $this->page = nahoWikiPagePeer::retrieveByName($page_name);
    
    // Build page object
    if (!$this->page) {
      $this->page = new nahoWikiPage;
      $this->revision = null;
    } else {
      // Retrieve the revision
      if (!($revision = $this->revision)) {
        $revision = $this->page->getLatestRevision();
      }
      $this->revision = $this->page->getRevision($revision);
    }
    
    // Buil revision object
    if (!$this->revision) {
      $this->revision = new nahoWikiRevision;
      $this->revision->setnahoWikiPage($this->page);
    }
    
    // Generate the URI parameters to keep trace of the requested page
    $this->uriParams = 'page=' . urlencode($this->page->getName());
    if ($this->revision->getRevision() != $this->page->getLatestRevision()) {
      $this->uriParams .= '&revision=' . urlencode($this->revision->getRevision());
    }
    
    // Permissions
    $this->canView = $this->page->canView($this->getUser());
    $this->canEdit = $this->page->canEdit($this->getUser());
  }
  
}
