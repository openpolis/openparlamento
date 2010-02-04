<?php

/**
 * Subclass for representing a row from the 'opp_atto_has_iter' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAttoHasIter extends BaseOppAttoHasIter
{
  public $priority_override = 0;
  public $skip_news_generation = false;
  
  public function save($con = null)
  {
    // override della priorità, nel caso di cambiamento di stato conclusivo, ma non CONCLUSO
    if ($this->getOppIter()->getConcluso() == 1 && $this->getOppIter()->getFase() != 'CONCLUSO')
      $this->priority_override = 1;
      
    // skip generazione news per passaggio di stato di audizioni
    if ($this->getOppAtto()->getTipoAttoId() == 14)
      $this->skip_news_generation = true;
      
    // cache in opp_atto, solo però se non è già APprovato o REspinto
    $atto = $this->getOppAtto();
    $stato_cod = $atto->getStatoCod();
    $iter = $this->getOppIter();
    if ($stato_cod != 'AP' && $stato_cod != 'RE')
    {
      $atto->setStatoCod($iter->getCacheCod());
      $atto->setStatoFase($iter->getFase());
      $atto->setStatoLastDate($this->getData());
      $atto->save();
    }
    return parent::save();
  }
}

sfPropelBehavior::add(
  'OppAttoHasIter',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'date_method'        => 'Data',
              'priority'           => '2',
        )));