<?php

/**
 * Subclass for representing a row from the 'opp_emendamento_has_iter' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppEmendamentoHasIter extends BaseOppEmendamentoHasIter
{
  public $priority_override = 0;
  
  public function save($con = null)
  {
    // override della priorità, nel caso di cambiamento di stato conclusivo, ma non CONCLUSO
    if ($this->getOppEmIter()->getConcluso() == 1)
      $this->priority_override = 1;
      
    return parent::save();
  }
}

/**
 * a change in iter status, generates news related to the OppAtto the emendamento relates to and 
 * to all the Tags the emendamento is tagged with
 **/
 
/* 
removed (#382)
sfPropelBehavior::add(
  'OppEmendamentoHasIter',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => array('getOppEmendamento', 'getAttoPortante')),
              'date_method'        => 'Data',
              'priority'           => '3',
        )));
*/