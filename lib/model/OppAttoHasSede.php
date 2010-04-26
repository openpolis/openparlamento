<?php

/**
 * Subclass for representing a row from the 'opp_atto_has_sede' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAttoHasSede extends BaseOppAttoHasSede
{

  
}

sfPropelBehavior::add(
  'OppAttoHasSede',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'priority'           => '2',
        )));
