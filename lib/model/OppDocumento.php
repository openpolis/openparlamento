<?php

/**
 * Subclass for representing a row from the 'opp_documento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppDocumento extends BaseOppDocumento
{
  public $skip_news_generation = true;

  public function getDocId()
  {
    return $this->getId();
  }

  public function getTitoloCompleto()
  {
    return $this->getTitolo() . ' - ' . Text::denominazioneAtto($this->getOppAtto(), 'list');
  }
  
  public function getTestoLimitato()
  {
    return substr($this->getTesto(), 0, 10000);
  }
  
  public function isIndexable()
  {
    if ($this->getId() < 1248) return true;
    else return false;
  }

  public function save($con = null)
  {
    
    // attiva generazione news per documenti relativi a DDL
    if ($this->getOppAtto()->getTipoAttoId() == 1)
      $this->skip_news_generation = false;
      
    return parent::save();
  }

  
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
    $document->id = md5('OppDocumento' . $id);
    $document->sfl_model = 'OppDocumento';
    $document->sfl_type = 'model';

    $document->tipo_atto_s = strtolower($this->getOppAtto()->getTipoAtto());

    $document->propel_id = $id;
    $document->titolo = strip_tags(str_replace("'", "\'", $this->getTitoloCompleto()));
    $document->testo = strip_tags(str_replace("'", "\'", $this->getTesto()));

    if ($this->getData())
      $document->data_pres_dt = $this->getData('%Y-%m-%dT%H:%M:%SZ');
    $document->created_at_dt = $this->getCreatedAt('%Y-%m-%dT%H:%M:%SZ');

    // ritorna il documento da aggiungere
    return $document;
  }
  
}



sfPropelBehavior::add(
  'OppDocumento',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'date_method'        => 'Data',
              'priority'           => '2',
        )));

sfSolrPropelBehavior::getInitializer()->setupModel('OppDocumento');