<?php

/**
 * Subclass for representing a row from the 'sf_simple_wiki_page' table.
 *
 * 
 *
 * @package plugins.nahoWikiPlugin.lib.model
 */ 
class PluginnahoWikiPage extends BasenahoWikiPage
{
  
  public function getName()
  {
    return strtolower(parent::getName());
  }
  
  public function setName($name)
  {
    parent::setName(strtolower($name));
  }
  
  public function getNamespace()
  {
    return nahoWikiPagePeer::getNamespace($this->getName());
  }
  
  public function getBasename($page_name = null)
  {
    return nahoWikiPagePeer::getBasename($this->getName());
  }
  
  public function resolveAbsoluteName($page_name = null)
  {
    if (!$page_name) {
      $page_name = $this->getName();
    }
    $ns_separator = sfConfig::get('app_nahoWikiPlugin_ns_separator', ':');
    
    // If path don't begin with a '.', and describes a path (contains ':'), it means we start from root
    if (substr($page_name, 0, 1) != '.' && false !== strpos($page_name, $ns_separator)) {
      $base = '';
    } else {
      $base = $this->getNamespace();
    }
    
    // Resolve implicit shortcuts ('.something' means '.:something')
    $page_name = preg_replace('/\.([^' . preg_quote($ns_separator, '/') . '\.])/', '.' . $ns_separator . '$1', $page_name);
    
    // Join with base, and explode as parts (separated with colons)
    $parts = explode($ns_separator, $base . $ns_separator . $page_name);
    
    // Build the real parts array, only valid parts are used : valid single page name, '.' or '..'
    $real_parts = array();
    foreach ($parts as $part) {
      if ($part == '.') {
        continue;
      } elseif ($part == '..') {
        array_pop($real_parts);
      } elseif (preg_match('/^[a-zA-Z0-9_\-]+$/', $part)) {
        $real_parts[] = $part;
      }
    }
    
    return implode($ns_separator, $real_parts);
  }
  
  public function getRevision($revision = null)
  {
    $latest_revision = null;
    foreach ($this->getRevisions() as $rev) {
      if (is_null($latest_revision) || $latest_revision->getRevision() < $rev->getRevision()) {
        $latest_revision = $rev;
      }
      if ($rev->getRevision() == $revision) {
        return $rev;
      }
    }
    
    return $latest_revision;
  }
  
  public function getRevisions($criteria= null)
  {
    if ($criteria === null) {
      $criteria = new Criteria();
    } elseif ($criteria instanceof Criteria) {
      $criteria = clone $criteria;
    }
    $criteria->addDescendingOrderByColumn(nahoWikiRevisionPeer::CREATED_AT);
    return $this->getnahoWikiRevisions($criteria);
  }
  
  /**
   * Should be called for maintenance only
   */
  public function optimizeRevisions()
  {
    foreach ($this->getRevisions() as $revision) {
      if ($revision->isLatest()) {
        $revision->unarchiveContent();
      } else {
        $revision->archiveContent();
      }
    }
  }
  
  // @todo implement real rights management here
  public function canView($user)
  {
    return true;
  }
  
  // @todo implement real rights management here
  public function canEdit($user)
  {
    $anonymousEditing = sfConfig::get('app_nahoWikiPlugin_allow_anonymous_edit', false);
    $credentialsEdit = sfConfig::get('app_nahoWikiPlugin_credentials_edit', array());
    return $this->canView($user) && ($anonymousEditing || ($user->isAuthenticated() && $user->hasCredential($credentialsEdit)));
  }

}
