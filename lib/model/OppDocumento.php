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
}



sfPropelBehavior::add(
  'OppDocumento',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'date_method'        => 'Data',
              'priority'           => '2',
        )));

sfLucenePropelBehavior::getInitializer()->setupModel('OppDocumento');