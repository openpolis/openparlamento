<?php

/**
 * Subclass for representing a row from the 'opp_carica_has_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaHasAtto extends BaseOppCaricaHasAtto
{
  public $skip_news_generation = false;

  public function save($con = null)
  {
    $this->skip_news_generation = false;
    if ($this->getTipo() != 'R' && $this->getData() <= $this->getOppAtto()->getDataPres())
    {
      $this->skip_news_generation = true;
      $this->generateNewsForPolitico();
    }
    
    $res = parent::save();
    
    return $res;
  }
  
  public function generateNewsForPolitico()
  {
    // force generation of another news related to politico in case skip is activated
    // we need the news related to the politician for the politician page
    $n = new News();
    $n->setGeneratorModel(get_class($this));
    $n->setGeneratorPrimaryKeys(serialize($this->getPrimaryKeysArray()));
    $n->setRelatedMonitorableModel('OppPolitico');
    $n->setRelatedMonitorableId($this->getOppCarica()->getPoliticoId());

    if ($this->getCreatedAt() != null)
      $n->setCreatedAt($this->getCreatedAt());

    $n->setDate($this->getNewsDate());

    $n->setPriority(2);

    $n->save();

  }
  
}

sfPropelBehavior::add(
  'OppCaricaHasAtto',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto',
                                             'OppPolitico' => array('getOppCarica', 'getOppPolitico')),
              'date_method'        => 'Data',
              'priority'           => '3',
        )));