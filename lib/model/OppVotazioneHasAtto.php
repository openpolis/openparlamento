<?php

/**
 * Subclass for representing a row from the 'opp_votazione_has_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppVotazioneHasAtto extends BaseOppVotazioneHasAtto
{
  public $priority_override = 0;
  
  public function save($con = null)
  {
    if ($this->getOppVotazione()->getFinale() == 1)
      $this->priority_override = 1;
    parent::save();
  }
  
}

sfPropelBehavior::add(
  'OppVotazioneHasAtto',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'priority'           => '2',
        )));