<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    symfony
 * @subpackage plugin
 * @author     Nicolas Chambrier <naholyr@yahoo.fr>
 * @version    SVN: $Id: $
 */
class BasenahoWikiActions extends sfActions
{
  
  public function preExecute()
  {
    $this->anonymousEditing = sfConfig::get('app_nahoWikiPlugin_allow_anonymous_edit', false);
    $this->startPage = sfConfig::get('app_nahoWikiPlugin_start_page', 'index');
    $this->credentialsEdit = sfConfig::get('app_nahoWikiPlugin_credentials_edit', array());
  }
  
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
      $this->initNewPage($page_name);
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
  }
  
  protected function initNewRevision()
  {
    $this->revision = new nahoWikiRevision;
    $this->revision->setnahoWikiPage($this->page);
    $this->revision->initUserName();
    if (!$this->page->isNew()) {
      $this->revision->setRevision($this->page->getLatestRevision()+1);
    }
  }
  
  protected function initNewPage($page_name)
  {
    $this->page = new nahoWikiPage;
    $this->page->setName($page_name);
  }

  protected function forward403Unless($condition)
  {
    if ($condition) {
      return;
    }

    if ($this->getUser()->isAuthenticated()) {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    } else {
      $this->forward(sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));
    }
  }
  
  
  protected function updateBreadcrumbs()
  {
    if (!$this->page->isNew()) {
      $breadcrumbs = $this->getUser()->getAttribute('breadcrumbs', array(), 'nahoWiki');
      if (!in_array($this->page->getName(), $breadcrumbs)) {
        $breadcrumbs[] = $this->page->getName();
      }
      if (count($breadcrumbs) > sfConfig::get('app_nahoWikiPlugin_max_breadcrumbs', 5)) {
        array_shift($breadcrumbs);
      }
      $this->getUser()->setAttribute('breadcrumbs', $breadcrumbs, 'nahoWiki');
    }
  }
  
  
  public function executeIndex()
  {
    $this->forward('nahoWiki', 'view');
  }
  
  public function executeView()
  {
    $this->setPage();
    $this->forward403Unless($this->canView);
    
    $this->updateBreadcrumbs();
    
    return sfView::SUCCESS;
  }
  
  public function handleErrorEdit()
  {
    return $this->executeEdit();
  }
  public function executeEdit()
  {
    $this->setPage();
    // Do not reject here if not canEdit, cause it then fallbacks on "view source" feature
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
        $this->redirect('nahoWiki/view?page=' . $this->page->getName());
      }
    }
    
    return sfView::SUCCESS;
  }

  public function executeHistory()
  {
    $this->setPage();
    $this->forward403Unless($this->canView);

    return sfView::SUCCESS;
  }

  public function executeDiff()
  {
    $this->setPage(); // $this->revision is revision2
    $this->forward403Unless($this->canView);

    $this->forward404If($this->page->isNew());
    $this->forward404If($this->revision->isNew());

    // Source revision
    $c = new Criteria;
    $c->add(nahoWikiRevisionPeer::PAGE_ID, $this->page->getId());
    $c->add(nahoWikiRevisionPeer::REVISION, $this->getRequestParameter('oldRevision'));
    $this->revision1 = nahoWikiRevisionPeer::doSelectOne($c);
    $this->forward404Unless($this->revision1);
    
    // Dest revision
    $this->revision2 = $this->revision;

    // Make diff
    $lines1 = explode("\n", $this->revision1->getContent());
    $lines2 = explode("\n", $this->revision2->getContent());
    $diff = new Text_Diff('auto', array($lines1, $lines2));
    switch ($this->getRequestParameter('mode', 'inline')) {
      case 'unified':
        $renderer = new Text_Diff_Renderer_unified;
        break;
      case 'context':
        $renderer = new Text_Diff_Renderer_context;
        break;
      case 'inline':
      default:
        $renderer = new Text_Diff_Renderer_inline;
        break;
    }
    $this->diff = $renderer->render($diff);
    
    // Direct download
    if ($this->getRequestParameter('raw')) {
      $this->getResponse()->setContentType('text/plain');
      $this->renderText($this->diff);
      return sfView::NONE;
    }

    return sfView::SUCCESS;
  }
  
  public function executeUser()
  {
    $this->setPage('User:' . $this->getRequestParameter('name'));
    $this->forward403Unless($this->canView);
    
    return sfView::SUCCESS;
  }
  
  protected function buildIndexTree(&$tree, $path, $fullpath, $expanded)
  {
    if (count($path) == 1) {
      $tree[$path[0]] = $fullpath;
    } else {
      $category = array_shift($path) . ':';
      if (!isset($tree[$category])) {
        $tree[$category] = array();
      }
      if (count($expanded) && $category == $expanded[0] . ':') {
        array_shift($expanded);
        $this->buildIndexTree($tree[$category], $path, $fullpath, $expanded);
      }
    }
  }
  
  public function executeBrowse()
  {
    $this->setPage();
    
    $path = $this->getRequestParameter('path');
    $tree = array();
    
    $c = new Criteria;
    $c->addAscendingOrderByColumn(nahoWikiPagePeer::NAME);
    $pages = nahoWikiPagePeer::doSelect($c);
    
    foreach ($pages as $page) {
      $this->buildIndexTree($tree, explode(':', $page->getName()), $page->getName(), explode(':', $path));
    }
    
    $this->tree = $tree;
    $this->uriParams = 'page=' . urlencode($this->getRequestParameter('page'));
    
    return sfView::SUCCESS;
  }
  
}
