<?php

/**
 * Subclass for representing a row from the 'opp_intervento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppIntervento extends BaseOppIntervento
{
}

sfPropelBehavior::add(
  'OppIntervento',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto', 
                                             'OppPolitico' => array('getOppCarica', 'getOppPolitico')),
              'date_method'        => 'Data',
              'priority'           => '2',
        )));