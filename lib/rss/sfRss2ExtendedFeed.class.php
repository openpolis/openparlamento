<?php

/*
 * (c) 2009 Guglielmo Celata
 * 
 */

/**
 *
 * @package    op_openparlamento
 * @author     Guglielmo Celata <g.celata@depp.it>
 *
 */
class sfRss2ExtendedFeed extends sfRssFeed
{
  protected
    $siteUrl,
    $copyright,
    $atom_link,
    $managingEditor,
    $lastBuildDate,
    $ttl,
    $image,
    $sy_updatePeriod,
    $sy_updateFrequency,
    $sy_updateBase;
    
  
  public function initialize($feed_array)
  {
    parent::initialize($feed_array);

    $this->setSiteUrl(isset($feed_array['siteUrl']) ? $feed_array['siteUrl'] : '');
    $this->setCopyright(isset($feed_array['copyright']) ? $feed_array['copyright'] : '');
    $this->setAtomLink(isset($feed_array['atom_link']) ? $feed_array['atom_link'] : '');
    $this->setLastBuildDate(isset($feed_array['lastBuildDate']) ? $feed_array['lastBuildDate'] : '');
    $this->setTTL(isset($feed_array['ttl']) ? $feed_array['ttl'] : '');
    $this->setImage(isset($feed_array['image']) ? $feed_array['image'] : '');
    $this->setSyUpdatePeriod(isset($feed_array['sy_updatePeriod']) ? $feed_array['sy_updatePeriod'] : '');
    $this->setSyUpdateFrequency(isset($feed_array['sy_updateFrequency']) ? $feed_array['sy_updateFrequency'] : '');
    $this->setSyUpdateBase(isset($feed_array['sy_updateBase']) ? $feed_array['sy_updateBase'] : '');

  }



  /**
   * Returns the the current object as a valid RSS 2.0 XML feed, with extensions
   *
   * @return string an extended RSS 2.0 XML string.
   */
  public function toXml()
  {
    $this->initContext();
    $xml = array();
    $xml[] = '<?xml version="1.0" encoding="'.$this->getEncoding().'" ?>';
    $xml[] = '<rss ';
    $xml[] = '     xmlns:dc="http://purl.org/dc/elements/1.1/"';
    $xml[] = '     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"';
    $xml[] = '     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"';
    $xml[] = '     xmlns:dcterms="http://purl.org/dc/terms/"';
    $xml[] = '     xmlns:atom="http://www.w3.org/2005/Atom"';
    $xml[] = '     version="2.0">';
    $xml[] = '  <channel>';
    $xml[] = '    <title><![CDATA['.$this->getTitle().']]></title>';
    $xml[] = '    <link>'.$this->getSiteUrl().'</link>';
    $xml[] = '    <description><![CDATA['.$this->getDescription().']]></description>';
    if ($this->getLanguage())
      $xml[] = '    <language>'.$this->getLanguage().'</language>';
    if ($this->getCopyright())
      $xml[] = '    <copyright><![CDATA['.$this->getCopyright().']]></copyright>';
    $xml[] = '    <atom:link href="'.$this->context->getController()->genUrl($this->getFeedUrl(), true).'" rel="self" type="application/rss+xml" />';

    if ($this->getAuthorEmail())
      $xml[] = '    <managingEditor>'.$this->getAuthorEmail().($this->getAuthorName() ? ' ('.$this->getAuthorName().')' : '').'</managingEditor>';
    if (!$this->getAuthorEmail() && $this->getAuthorName())
      $xml[] = '    <managingEditor>'.$this->getAuthorName().'</managingEditor>';

    $xml[] = '    <pubDate>'.strftime('%a, %d %b %Y %H:%M:%S %z', $this->getLatestPostDate()).'</pubDate>';
    $xml[] = '    <lastBuildDate>'. strftime('%a, %d %b %Y %H:%M:%S %z', $this->getLatestPostDate()) .'</lastBuildDate>';

    $xml[] = '    <ttl>'.$this->getTTL().'</ttl>';
    
    $xml[] = '    <image>';
    $xml[] = '      <title>'.$this->getTitle().'</title>';
    $xml[] = '      <url>'.$this->getImage().'</url>';
    $xml[] = '      <link>'.$this->getSiteUrl().'</link>';
    $xml[] = '    </image>';

    if(is_array($this->getCategories()))
    {
      foreach ($this->getCategories() as $category)
      {
        $xml[] = '    <category><![CDATA['.$category.']]></category>';
      }
    }

    $xml[] = '    <sy:updatePeriod>'.$this->getSyUpdatePeriod().'</sy:updatePeriod>';
    $xml[] = '    <sy:updateFrequency>'.$this->getSyUpdateFrequency().'</sy:updateFrequency>';
    $xml[] = '    <sy:updateBase>'.$this->getSyUpdateBase().'</sy:updateBase>';
		
    $xml[] = implode("\n", $this->getFeedItems());

    $xml[] = '  </channel>';
    $xml[] = '</rss>';

    return implode("\n", $xml);
  }

  /**
   * Returns an array of <item> tags corresponding to the feed's items.
   *
   * @return string An list of <item> elements.
   */
  protected function getFeedItems()
  {
    $xml = array();
    foreach ($this->getItems() as $item)
    {
      $xml[] = '    <item>';
      $xml[] = '      <title><![CDATA['.htmlspecialchars(html_entity_decode($item->getTitle(), ENT_COMPAT, 'UTF-8')).']]></title>';
      $xml[] = '      <link>'.$this->context->getController()->genUrl($item->getLink(), true).'</link>';
      if ($item->getDctermsAbstract())
      {
        $xml[] = '      <dcterms:abstract><![CDATA['.htmlspecialchars(html_entity_decode($item->getDctermsAbstract(), ENT_COMPAT, 'UTF-8')).']]></dcterms:abstract>';        
      }
      if ($item->getDescription())
      {
        $xml[] = '      <description><![CDATA['. $item->getDescription() . ']]></description>';
      }
      if ($item->getContent())
      {
        $xml[] = '      <content:encoded><![CDATA['.$item->getContent().']]></content:encoded>';
      }

      if ($item->getPermalink())
      {
        $xml[] = '      <guid>'.$item->getPermalink().'</guid>';
      }

      // author information
      if ($item->getAuthorEmail())
      {
        $xml[] = sprintf('      <author>%s%s</author>', 
                         $item->getAuthorEmail(), 
                         ($item->getAuthorName() ? ' ('.$item->getAuthorName().')' : ''));
      }
      if ($item->getPubdate())
      {
        $xml[] = '      <pubDate>'.strftime('%a, %d %b %Y %H:%M:%S %z', $item->getPubdate()).'</pubDate>';
      }
      if ($item->getComments())
      {
        $xml[] = '      <comments>'.$item->getComments().'</comments>';
      }

      if ($item->getDcIdentifier())
      {
        $xml[] = '      <dc:identifier>'.$item->getDcIdentifier().'</dc:identifier>';
      }
      if ($item->getDcPublisher())
      {
        $xml[] = '      <dc:publisher>'.$item->getDcPublisher().'</dc:publisher>';
      }

      if ($item->getLocations())
        foreach ($item->getLocations() as $location)
          $xml[] = '      <dcterms:spatial>'.$location.'</dcterms:spatial>';

      // enclosure
      if ($enclosure = $item->getEnclosure())
      {
        $enclosure_attributes = sprintf('url="%s" length="%s" type="%s"', $enclosure->getUrl(), $enclosure->getLength(), $enclosure->getMimeType());
        $xml[] = '      <enclosure '.$enclosure_attributes.'></enclosure>';
      }

      // categories
      if(is_array($item->getCategories()))
      {
        foreach ($item->getCategories() as $category)
        {
          $xml[] = '      <category><![CDATA['.htmlspecialchars(html_entity_decode($category, ENT_COMPAT, 'UTF-8')).']]></category>';
        }
      }

      $xml[] = '    </item>';
    }

    return $xml;
  }


  public function setSiteUrl($siteUrl)
  {
    if($siteUrl)
    {
      $this->siteUrl = $siteUrl;
    }
  }

  public function getSiteUrl()
  {
    return $this->siteUrl;
  }
  


  public function setCopyright($copyright)
  {
    if($copyright)
    {
      $this->copyright = $copyright;
    }
  }

  public function getCopyright()
  {
    return $this->copyright;
  }
  
  
  public function setAtomLink($atom_link)
  {
    if($atom_link)
    {
      $this->atom_link = $atom_link;
    }
  }

  public function getAtomLink()
  {
    return $this->atom_link;
  }



  public function setLastBuildDate($lastBuildDate)
  {
    if($lastBuildDate)
    {
      $this->lastBuildDate = $lastBuildDate;
    }
  }

  public function getLastBuildDate()
  {
    return $this->lastBuildDate;
  }


  public function setTTL($ttl)
  {
    if($ttl)
    {
      $this->ttl = $ttl;
    }
  }

  public function getTTL()
  {
    return $this->ttl;
  }


  public function setImage($image)
  {
    if($image)
    {
      $this->image = $image;
    }
  }

  public function getImage()
  {
    return $this->image;
  }
  

  public function setSyUpdatePeriod($sy_updatePeriod)
  {
    if($sy_updatePeriod)
    {
      $this->sy_updatePeriod = $sy_updatePeriod;
    }
  }

  public function getSyUpdatePeriod()
  {
    return $this->sy_updatePeriod;
  }


  public function setSyUpdateFrequency($sy_updateFrequency)
  {
    if($sy_updateFrequency)
    {
      $this->sy_updateFrequency = $sy_updateFrequency;
    }
  }

  public function getSyUpdateFrequency()
  {
    return $this->sy_updateFrequency;
  }
  

  public function setSyUpdateBase($sy_updateBase)
  {
    if($sy_updateBase)
    {
      $this->sy_updateBase = $sy_updateBase;
    }
  }

  public function getSyUpdateBase()
  {
    return $this->sy_updateBase;
  }

}

?>
