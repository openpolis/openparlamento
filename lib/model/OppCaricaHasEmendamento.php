<?php

/**
 * Subclass for representing a row from the 'opp_carica_has_emendamento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaHasEmendamento extends BaseOppCaricaHasEmendamento
{
}

/**
 * a new record in opp_carica_has_emendamento (new signature), 
 * generates news related to the OppAtto the emendamento relates to,
 * to the OppPolitico that has signed the emendamento, and 
 * to all the Tags the emendamento is tagged with
 **/
sfPropelBehavior::add(
  'OppCaricaHasEmendamento',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => array('getOppEmendamento', 'getAttoPortante'),
                                             'OppPolitico' => array('getOppCarica', 'getOppPolitico')),
              'date_method'        => 'Data',
              'priority'           => '3')));
