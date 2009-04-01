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
  public function getTaggedAtto()
  {
    $item_model = $this->getTaggableModel();
    if ($item_model != 'OppAtto') return null;
    $item_id = $this->getTaggableId();
    
    $item = call_user_func($item_model.'Peer::retrieveByPK', $item_id);
    return $item;
  }
  
  public function getCreatedAt()
  {
    return null;
  }
  public function getNewsDate()
  {
    return date('Y-m-d');
  }
  
}

sfPropelBehavior::add(
  'Tagging',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getTaggedAtto'),
              'priority'           => '1',
        )));