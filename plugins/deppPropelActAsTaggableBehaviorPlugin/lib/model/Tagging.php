<?php

/**
 * Subclass for representing a row from the 'tagging' table.
 *
 * 
 *
 * @package plugins.sfPropelActAsTaggableBehaviorPlugin.lib.model
 */ 
class Tagging extends BaseTagging
{
  public $priority_override = 0;
  
  public function getNewsDate()
  {
    return $this->getCreatedAt('Y-m-d');
  }
  
}

/**
 * tagging an object, generates news related to the tag (that is monitored)
 **/
 
/* 
sfPropelBehavior::add(
  'Tagging',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'Tag' => 'getTag'),
              'priority'           => '1')));
*/              