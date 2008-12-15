<?php

/**
 * Subclass for representing a row from the 'sf_test_votable' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfTestVotable extends BasesfTestVotable
{
}

sfPropelBehavior::add(
  'sfTestVotable', 
  array('deppPropelActAsVotableBehavior' =>
        array('voting_range'    => 1,              
              'voting_field'    => 'VotoMedio',
              'voting_fields'   => array(1 => 'UtFav', -1 => 'UtContr'),
              'neutral_position'=> true,
              'anonymous_voting'=> false )));


