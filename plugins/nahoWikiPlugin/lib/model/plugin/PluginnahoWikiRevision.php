<?php

/**
 * Subclass for representing a row from the 'sf_simple_wiki_revision' table.
 *
 * 
 *
 * @package plugins.nahoWikiPlugin.lib.model
 */ 
class PluginnahoWikiRevision extends BasenahoWikiRevision
{
  
  /**
  * Taken from sfIp2Country
  *
  * Determines the remote IP address.
  * If called via a CLI script (batch) the local
  * loopback address will be returned.
  *
  * @return string
  * @author     Sacha Telgenhof Oude Koehorst <s.telgenhof@xs4all.nl>
  */
  private function getRemoteIP()
  {
    $ip = false;

    // User is behind a proxy and check that we discard RFC1918 IP addresses.
    // If these address are behind a proxy then only figure out which IP belongs to the user.
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      // put the IP's octets into an array
      $ips = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
      $no = count($ips);

      for ($i = 0 ; $i < $no ; $i++) {
        // Skip RFC 1918 IP's 10.0.0.0/8, 172.16.0.0/12 and
        // 192.168.0.0/16
        if (!eregi('^(10|172\.16|192\.168)\.', $ips[$i])) {
          $ip = $ips[$i];
          break;
        }
      }
    }

    return ($ip ? $ip : isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1'); // Return with the found IP, the remote address or the local loopback address
  }
  
  public function initUserName()
  {
    $user = sfContext::getInstance()->getUser();
    if ($user->isAuthenticated()) {
      $this->setUserName($user->__toString());
    } else {
      $this->setUserName($this->getRemoteIP());
    }
  }
  
  public function isLatest()
  {
    return $this->getRevision() == $this->getPage()->getLatestRevision();
  }
  
  public function getPage()
  {
    return $this->getnahoWikiPage();
  }
  
  public function getContent()
  {
    $content_storage = $this->getnahoWikiContent();
    
    if (!$content_storage) {
      return null;
    }
    
    $uncompressed_content = $content_storage->getContent();
    $compressed_content = $content_storage->getGzContent();
    
    /* Check archive state : shouldn't have to be done
    if (!$this->isLatest() && $uncompressed_content) { // Old revision has uncompressed content : do archive !
      $this->archiveContent();
    } elseif ($this->isLatest() && $compressed_content) { // Latest revision has compressed content : unarchive !
      $this->unarchiveContent();
    }
    */
    
    return $uncompressed_content ? $uncompressed_content : gzinflate($compressed_content);
  }
  
  public function getXHTMLContent()
  {
    $content = $this->getContent();
    $content = nahoWikiContentPeer::preConvert($this->getPage(), $content);
    $content = nahoWikiContentPeer::doConvert($content);
    $content = nahoWikiContentPeer::postConvert($this->getPage(), $content);
    
    return $content;
  }
  
  public function setContent($content)
  {
    $content_storage = $this->getnahoWikiContent();
    if (!$content_storage) {
      $content_storage = new nahoWikiContent;
      $this->setnahoWikiContent($content_storage);
    }
    $content_storage->setContent($content);
    
    return $content_storage->save();
  }
  
  public function archiveContent()
  {
    $content_storage = $this->getnahoWikiContent();
    
    if (!$content_storage) {
      return false;
    }
    
    $uncompressed_content = $content_storage->getContent();
    if ($uncompressed_content) {
      $compressed_content = gzdeflate($uncompressed_content, 9);
      $content_storage->setGzContent($compressed_content);
      $content_storage->setContent(null);
      $content_storage->save();
    }
    
    return true;
  }
  
  public function unarchiveContent()
  {
    $content_storage = $this->getnahoWikiContent();
    
    if (!$content_storage) {
      return false;
    }
    
    $compressed_content = $content_storage->getGzContent();
    if ($compressed_content) {
      $uncompressed_content = gzinflate($compressed_content, 9);
      $content_storage->setGzContent(null);
      $content_storage->setContent($uncompressed_content);
      $content_storage->save();
    }
    
    return true;
  }
  
}
