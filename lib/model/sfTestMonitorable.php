<?php

/**
 * Subclass for representing a row from the 'sf_test_monitorable' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfTestMonitorable extends BasesfTestMonitorable
{
}

sfPropelBehavior::add(
  'sfTestMonitorable', 
  array('deppPropelActAsMonitorableBehavior' =>
        array('count_monitored_objects_field' => 'NMonitoredObjects', // refers to UserPeer::N_MONITORED_OBJECTS
              'count_monitoring_users_field'  => 'NMonitoringUsers',  // refers to ArticlePeer::N_MONITORING_USERS
              'user_profile_model'            => 'OppUser',           // user profile model (to set the cache)
       )));

