<?php
/*
 * This file is part of the deppPropelActAsPrioritisableBehavior package.
 *
 * (c) 2010 Guglielmo Celata <guglielmo@openpolis.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

sfPropelBehavior::registerHooks('deppPropelActAsPrioritisableBehavior', array (
  ':delete:pre' => array ('deppPropelActAsPrioritisableBehavior', 'preDelete'),
));

sfPropelBehavior::registerMethods('deppPropelActAsPrioritisableBehavior', array (
  array('deppPropelActAsPrioritisableBehavior', 'setPriorityValue'),
  array('deppPropelActAsPrioritisableBehavior', 'getPriorityValue'),
  array('deppPropelActAsPrioritisableBehavior', 'getPriorityLastUser'),
  array('deppPropelActAsPrioritisableBehavior', 'getPriorityLastUpdate'),  
  array('deppPropelActAsPrioritisableBehavior', 'hasBeenPrioritised'),
  array('deppPropelActAsPrioritisableBehavior', 'clearPriority'),
  array('deppPropelActAsPrioritisableBehavior', 'getMaxPriority'),
  array('deppPropelActAsPrioritisableBehavior', 'allowsNullPriority'),
  array('deppPropelActAsPrioritisableBehavior', 'getPrioritisableReferenceKey'),
));                 
