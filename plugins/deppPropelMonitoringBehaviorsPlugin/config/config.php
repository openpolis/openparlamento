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
  array('deppPropelActAsMonitorableBehavior', 'addMonitoringUser'),
  array('deppPropelActAsMonitorableBehavior', 'removeMonitoringUser'),  
  array('deppPropelActAsMonitorableBehavior', 'isMonitoredByUser'),
  array('deppPropelActAsMonitorableBehavior', 'getMonitoringUsersPKs'),  
  array('deppPropelActAsMonitorableBehavior', 'getMonitoringUsers'),  
  array('deppPropelActAsMonitorableBehavior', 'countMonitoringUsers'),  
  array('deppPropelActAsMonitorableBehavior', 'getNNewNews'),
  array('deppPropelActAsMonitorableBehavior', 'getLastNews'),
));                 


/**
 * hooks and methods for the actAsMonitorer behavior
 *
 **/
sfPropelBehavior::registerHooks('deppPropelActAsMonitorerBehavior', array (
  ':delete:pre' => array ('deppPropelActAsMonitorerBehavior', 'preDelete'),
));

sfPropelBehavior::registerMethods('deppPropelActAsMonitorerBehavior', array (
  array('deppPropelActAsMonitorerBehavior', 'addMonitoredObject'),  
  array('deppPropelActAsMonitorerBehavior', 'removeMonitoredObject'),  
  array('deppPropelActAsMonitorerBehavior', 'removeAllMonitoredObjects'),  
  array('deppPropelActAsMonitorerBehavior', 'getMonitoredPks'),  
  array('deppPropelActAsMonitorerBehavior', 'getMonitoredObjects'),  
  array('deppPropelActAsMonitorerBehavior', 'countMonitoredObjects'),  
  array('deppPropelActAsMonitorerBehavior', 'isMonitoring'),
));                 


/**
 * hooks and methods for the actAsNewsGenerator behavior
 *
 **/
sfPropelBehavior::registerHooks('deppPropelActAsNewsGeneratorBehavior', array (
  ':delete:pre' => array ('deppPropelActAsNewsGeneratorBehavior', 'preDelete'),
  ':save:pre' => array ('deppPropelActAsNewsGeneratorBehavior', 'preSave'),
  ':save:post' => array ('deppPropelActAsNewsGeneratorBehavior', 'postSave'),
));

sfPropelBehavior::registerMethods('deppPropelActAsNewsGeneratorBehavior', array (
  array('deppPropelActAsNewsGeneratorBehavior', 'generateNews'),    
  array('deppPropelActAsNewsGeneratorBehavior', 'getGeneratedNews'),
  array('deppPropelActAsNewsGeneratorBehavior', 'getPrimaryKeysArray'),
  array('deppPropelActAsNewsGeneratorBehavior', 'getNewsDate'),    
  array('deppPropelActAsNewsGeneratorBehavior', 'getNewsPriority'),      
  array('deppPropelActAsNewsGeneratorBehavior', 'getRelatedMonitorableObjects'),  
  array('deppPropelActAsNewsGeneratorBehavior', 'getRelatedMonitorableObject'),  
));                 


/**
 * hooks and methods for the actAsCommunityNewsGenerator behavior
 *
 **/
sfPropelBehavior::registerHooks('deppPropelActAsCommunityNewsGeneratorBehavior', array (
  ':delete:pre' => array ('deppPropelActAsCommunityNewsGeneratorBehavior', 'preDelete'),
  ':save:pre'   => array ('deppPropelActAsCommunityNewsGeneratorBehavior', 'preSave'),
  ':save:post'  => array ('deppPropelActAsCommunityNewsGeneratorBehavior', 'postSave'),
));

sfPropelBehavior::registerMethods('deppPropelActAsCommunityNewsGeneratorBehavior', array (
  array('deppPropelActAsCommunityNewsGeneratorBehavior', 'generateCreationCommunityNews'),    
  array('deppPropelActAsCommunityNewsGeneratorBehavior', 'generateRemovalCommunityNews'),    
  array('deppPropelActAsCommunityNewsGeneratorBehavior', 'getGeneratedNews'),    
  array('deppPropelActAsCommunityNewsGeneratorBehavior', 'getPrimaryKeysArray'),
  array('deppPropelActAsCommunityNewsGeneratorBehavior', 'getRelatedObject'),  
));                 
