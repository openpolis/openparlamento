<?php

/**
 * Subclass for representing a row from the 'opp_esito_seduta' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppEsitoSeduta extends BaseOppEsitoSeduta
{
}

sfPropelBehavior::add(
  'OppEsitoSeduta',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'date_method'        => 'Data',
              'priority'           => '3',
        )));
