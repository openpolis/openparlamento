<?php

/**
 * Subclass for representing a row from the 'opp_atto_has_emendamento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAttoHasEmendamento extends BaseOppAttoHasEmendamento
{
}


sfPropelBehavior::add(
  'OppAttoHasEmendamento',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'date_method'        => array( 'getOppEmendamento', 'getDataPres'),
              'priority'           => '3' )));
