<?php

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Nicolas Chambrier <naholyr@yahoo.fr>
 * @version    SVN: $Id$
 */

// autoloading for plugin lib actions is broken as at symfony-1.0.2
require_once(sfConfig::get('sf_plugins_dir'). '/nahoWikiPlugin/modules/nahoWiki/lib/BasenahoWikiActions.class.php');

class nahoWikiActions extends BasenahoWikiActions
{
  protected function setPage($page_name = null)
  {
    // Get page from request if not given as parameter (default behaviour)
    if (is_null($page_name)) {
      $page_name = $this->getRequestParameter('page', $this->startPage);
    }
    
    // Handle case insensitivity
    $page_name = strtolower($page_name);
    
    // Support default page if not specified in namespace
    if (substr($page_name, -1) == ':') {
      $page_name .= $this->startPage;
    }
    
    // Retrieve the page, or start a new one if cannot be found
    $this->page = nahoWikiPagePeer::retrieveByName($page_name);
    if (!$this->page) {
      return;
    }
    
    // Retrieve the revision
    $revision = $this->getRequestParameter('revision', $this->page->getLatestRevision());
    $this->revision = $this->page->getRevision($revision);
    if (!$this->revision) {
      $this->initNewRevision();
    }
    
    // Generate the URI parameters to keep trace of the requested page
    $this->uriParams = 'page=' . $this->page->getName();
    if ($this->revision->getRevision() != $this->page->getLatestRevision()) {
      $this->uriParams .= '&revision=' . $this->revision->getRevision();
    }
    
    // Permissions management
    $this->canView = $this->page->canView($this->getUser());
    $this->canEdit = $this->page->canEdit($this->getUser());
    
    // Retriev item name and type of item (tab and breadcrumbs)
    list($tipo, $id) = split("_", $this->page->getName());
    switch ($tipo)
    {
      case 'atto':
        $this->item_name = Text::denominazioneAttoShort(OppAttoPeer::retrieveByPK($id));
        break;
        
      case 'votazione':
        $this->item_name = OppVotazionePeer::retrieveByPK($id)->getTitolo();
        break;
    }
    $this->item_type = $tipo;
    
  }


  public function executeView()
  {
    $this->setPage();
    $this->forward404Unless($this->page);
    $this->forward403Unless($this->canView);
    
    $this->updateBreadcrumbs();
    
    return sfView::SUCCESS;
  }

  public function executeEdit()
  {
    $this->setPage();
    $this->forward404Unless($this->page);
    $this->forward403Unless($this->canView); 
    
   
    // Generate the username (this is done by the Revision model)
    $tmp_revision = new nahoWikiRevision;
    $tmp_revision->initUserName();
    $this->userName = $tmp_revision->getUserName();
    
    // Save changes
    if ($this->getRequest()->getMethod() == sfRequest::POST) {
      // Here we must be able to edit
      $this->forward403Unless($this->canEdit);
      if (!$this->page->isNew()) {
        $this->revision->archiveContent();
        $this->initNewRevision();
      }
      $this->revision->setContent($this->getRequestParameter('content'));
      $this->revision->setComment($this->getRequestParameter('comment'));
      if (!$this->getRequestParameter('request-preview')) {
        $this->revision->save();
      }
      $this->page->setLatestRevision($this->revision->getRevision());
      if (!$this->getRequestParameter('request-preview')) {
        $this->page->save();
        
        // $this->redirect('nahoWiki/view?page=' . $this->page->getName());
        $referer = $this->getUser()->getAttribute('referer', 'nahoWiki/view?page=' . $this->page->getName());
        $this->getUser()->getAttributeHolder()->remove('referer');
        $this->redirect($referer);
      }
    }
    
    return sfView::SUCCESS;
  }
  
  public function executeHistory()
  {
    $this->setPage();
    $this->forward404Unless($this->page);
    $this->forward403Unless($this->canView);

    return sfView::SUCCESS;
  }

  
}
