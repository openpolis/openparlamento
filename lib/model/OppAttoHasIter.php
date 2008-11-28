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
  
  public function save($con = null)
  {
    if ($this->getOppIter()->getConcluso() == 1 && $this->getOppIter()->getFase() != 'CONCLUSO')
      $this->priority_override = 1;
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