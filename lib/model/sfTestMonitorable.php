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
        array('count_monitoring_users_field'  => 'NMonitoringUsers',  // refers to ArticlePeer::N_MONITORING_USERS
              'monitorer_model'               => 'OppUser',           // user profile model (to set the cache)
              'count_monitored_objects_field' => 'NMonitoredTests',
       )));

