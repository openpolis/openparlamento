<?php

/**
 * Subclass for representing a row from the 'sf_test_generator' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfTestGenerator extends BasesfTestGenerator
{
  public $priority_override = 0;
  
  public function save($con = null)
  {
    $this->priority_override = 1;
    parent::save();
  }
  
}


sfPropelBehavior::add(
  'sfTestGenerator',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'sfTestMonitorable' => 'getsfTestMonitorable'),
              'date_method'        => 'TestDate',
              'priority'           => '3',
        )));
