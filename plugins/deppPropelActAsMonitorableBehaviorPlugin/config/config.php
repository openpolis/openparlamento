<?php
/*
 * This file is part of the deppPropelActAsMonitorableBehavior package.
 *
 * (c) 2007 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

sfPropelBehavior::registerHooks('deppPropelActAsMonitorableBehavior', array (
  ':delete:pre' => array ('deppPropelActAsMonitorableBehavior', 'preDelete'),
));

sfPropelBehavior::registerMethods('deppPropelActAsMonitorableBehavior', array (
  array('deppPropelActAsMonitorableBehavior', 'addMonitoring'),
  array('deppPropelActAsMonitorableBehavior', 'removeMonitoring'),  
  array('deppPropelActAsMonitorableBehavior', 'isMonitoredByUser'),
  array('deppPropelActAsMonitorableBehavior', 'getMonitoringUsers'),  
  array('deppPropelActAsMonitorableBehavior', 'countMonitoringUsers'),  
  array('deppPropelActAsMonitorableBehavior', 'getMonitoredObjects'),  
  array('deppPropelActAsMonitorableBehavior', 'countMonitoredObjects'),  
));                 
