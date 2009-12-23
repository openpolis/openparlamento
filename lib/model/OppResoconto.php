<?php

/**
 * Subclass for representing a row from the 'opp_resoconto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppResoconto extends BaseOppResoconto
{
  /**
   * torna l'oggetto Apache_Solr_Document da indicizzare
   *
   * @return Apache_Solr_Document
   * @author Guglielmo Celata
   */
  public function intoSolrDocument()
  {
    $document = new Apache_Solr_Document();
    
    $id = $this->getId();
    $document->id = md5('OppResoconto' . $id);
    $document->sfl_model = 'OppResoconto';
    $document->sfl_type = 'model';

    $document->propel_id = $id;
    if (trim($this->getStenografico()) != '')
    {
      $document->testo = strip_tags(str_replace("'", "\'", $this->getStenografico()));
    } else {
      $document->testo = strip_tags(str_replace("'", "\'", $this->getSommario()));      
    }

    if ($this->getNumSeduta())
      $document->num_seduta_i = $this->getNumSeduta();

    if ($this->getData())
      $document->data_dt = $this->getData('%Y-%m-%dT%H:%M:%SZ');

    $document->created_at_dt = $this->getCreatedAt('%Y-%m-%dT%H:%M:%SZ');

    // ritorna il documento da aggiungere
    return $document;
  }
  
  
  public function getURL()
  {
    if ($this->getStenografico())
    {
      $url = $this->getUrlStenografico();
    } else {
      $url = $this->getUrlSommario();
    }
    if (!strpos($url, "http://")) {
      $url = sfConfig::get('url_sito_camera', 'http://nuovo.camera.it/') . $url;
    }
    return $url;
  }
  
}
