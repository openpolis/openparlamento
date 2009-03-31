<?php
/*
 * This file is part of the deppPropelActAsLaunchableBehavior package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

sfPropelBehavior::registerHooks('deppPropelActAsLaunchableBehavior', array (
  ':delete:pre' => array ('deppPropelActAsLaunchableBehavior', 'preDelete'),
));

sfPropelBehavior::registerMethods('deppPropelActAsLaunchableBehavior', array (
  array('deppPropelActAsLaunchableBehavior', 'hasBeenLaunched'),
  array('deppPropelActAsLaunchableBehavior', 'setLaunching'),
  array('deppPropelActAsLaunchableBehavior', 'removeLaunching'),
  array('deppPropelActAsLaunchableBehavior', 'increasePriority'),
  array('deppPropelActAsLaunchableBehavior', 'decreasePriority'),
));                 
