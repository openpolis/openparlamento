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
class sfRss2ExtendedItem extends sfFeedItem
{
  private
   $dcterms_abstract,
   $permalink,
   $dc_identifier,
   $dc_publisher,
   $locations;


  /**
   * Sets the feed item parameters, based on an associative array
   *
   * @param array an associative array
   *
   * @return sfFeedItem the current sfFeedItem object
   */
  public function initialize($item_array)
  {
    parent::initialize($item_array);

    $this->setDctermsAbstract(isset($item_array['dcterms_abstract']) ? $item_array['dcterms_abstract'] : '');
    $this->setPermalink(isset($item_array['permalink']) ? $item_array['permalink'] : '');
    $this->setDcIdentifier(isset($item_array['dc_identifier']) ? $item_array['dc_identifier'] : '');
    $this->setDcPublisher(isset($item_array['dc_publisher']) ? $item_array['dc_publisher'] : '');
    $this->setLocations(isset($item_array['locations']) ? $item_array['locations'] : '');  
  }
  
  public function setDctermsAbstract ($dcterms_abstract)
  {
    $this->dcterms_abstract = $dcterms_abstract;
  }

  public function getDctermsAbstract ()
  {
    return $this->dcterms_abstract;
  }


  public function setPermalink($permalink)
  {
    $this->permalink = $permalink;
  }

  public function getPermalink ()
  {
    return $this->permalink;
  }

  
  public function setDcIdentifier ($dc_identifier)
  {
    $this->dc_identifier = $dc_identifier;
  }

  public function getDcIdentifier ()
  {
    return $this->dc_identifier;
  }


  public function setDcPublisher ($dc_publisher)
  {
    $this->dc_publisher = $dc_publisher;
  }

  public function getDcPublisher ()
  {
    return $this->dc_publisher;
  }


  public function setLocations ($locations)
  {
    $this->locations = $locations;
  }

  public function getLocations ()
  {
    return $this->locations;
  }

}

?>
