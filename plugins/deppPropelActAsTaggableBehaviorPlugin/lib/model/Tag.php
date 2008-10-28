<?php

/**
 * Subclass for representing a row from the 'tag' table.
 *
 *
 *
 * @package plugins.sfPropelActAsTaggableBehaviorPlugin.lib.model
 */
class Tag extends BaseTag
{
  public function __toString()
  {
    return $this->getName();
  }

  public function getModelsTaggedWith()
  {
    return TagPeer::getModelsTaggedWith($this->getName());
  }

  public function getRelated($options = array())
  {
    return TagPeer::getRelatedTags($this->getName());
  }

  public function getTaggedWith($options = array())
  {
    return TagPeer::getTaggedWith($this->getName());
  }
}


sfPropelBehavior::add(
  'Tag', 
  array('deppPropelActAsMonitorableBehavior' =>
        array('count_monitored_objects_field' => 'NMonitoredObjects', // refers to UserPeer::N_MONITORED_OBJECTS
              'count_monitoring_users_field'  => 'NMonitoringUsers',  // refers to ArticlePeer::N_MONITORING_USERS
              'user_profile_model'            => 'OppUser',           // user profile model (to set the cache)
       )));

