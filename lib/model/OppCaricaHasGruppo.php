<?php

/**
 * Subclass for representing a row from the 'opp_carica_has_gruppo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaHasGruppo extends BaseOppCaricaHasGruppo
{
}

sfPropelBehavior::add(
  'OppCaricaHasGruppo',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppPolitico' => array('getOppCarica', 'getOppPolitico')),
              'date_method'        => 'DataInizio',
              'priority'           => '1',
        )));
