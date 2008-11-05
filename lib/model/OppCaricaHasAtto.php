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
}

sfPropelBehavior::add(
  'OppCaricaHasAtto',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto',
                                             'OppPolitico' => array('getOppCarica', 'getOppPolitico')),
              'date_method'        => 'Data',
              'priority'           => '2',
        )));