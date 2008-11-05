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
}

sfPropelBehavior::add(
  'OppDocumento',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'date_method'        => 'Data',
              'priority'           => '3',
        )));
