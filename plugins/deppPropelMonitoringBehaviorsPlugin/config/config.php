<?php
/*
 * This file is part of the deppPropelMonitoringBehavior package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * hooks and methods for the actAsMonitorable behavior
 *
 **/
sfPropelBehavior::registerHooks('deppPropelActAsMonitorableBehavior', array (
  ':delete:pre' => array ('deppPropelActAsMonitorableBehavior', 'preDelete'),
));

sfPropelBehavior::registerMethods('deppPropelActAsMonitorableBehavior', array (
  array('deppPropelActAsMonitorableBehavior', 'addMonitoring'),
  array('deppPropelActAsMonitorableBehavior', 'removeMonitoring'),  
  array('deppPropelActAsMonitorableBehavior', 'isMonitoredByUser'),
  array('deppPropelActAsMonitorableBehavior', 'getMonitoringUsers'),  
  array('deppPropelActAsMonitorableBehavior', 'countMonitoringUsers'),  
  array('deppPropelActAsMonitorableBehavior', 'getReferenceKey'),  
));                 


/**
 * hooks and methods for the actAsMonitorer behavior
 *
 **/
sfPropelBehavior::registerHooks('deppPropelActAsMonitorerBehavior', array (
  ':delete:pre' => array ('deppPropelActAsMonitorerBehavior', 'preDelete'),
));

sfPropelBehavior::registerMethods('deppPropelActAsMonitorerBehavior', array (
  array('deppPropelActAsMonitorerBehavior', 'getMonitoredObjects'),  
  array('deppPropelActAsMonitorerBehavior', 'countMonitoredObjects'),  
  array('deppPropelActAsMonitorerBehavior', 'isMonitoring'),
));                 
