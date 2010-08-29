<?php

/**
 * Subclass for representing a row from the 'sf_test_prioritisable' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfTestPrioritisable extends BasesfTestPrioritisable
{

}
sfPropelBehavior::add(
  'sfTestPrioritisable', 
  array('deppPropelActAsPrioritisableBehavior' =>
        array('max_priority'    => 1,              
              'priority_field'    => 'Priority',
              'null_priority'=> true)));

