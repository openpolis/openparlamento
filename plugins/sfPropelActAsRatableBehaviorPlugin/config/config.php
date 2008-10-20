<?php
/*
 * This file is part of the sfPropelActAsRatableBehavior package.
 *
 * (c) 2007 Nicolas Perriault <nperriault@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

sfPropelBehavior::registerHooks('sfPropelActAsRatableBehavior', array (
  ':delete:pre' => array ('sfPropelActAsRatableBehavior', 'preDelete'),
));

sfPropelBehavior::registerMethods('sfPropelActAsRatableBehavior', array (
  array('sfPropelActAsRatableBehavior', 'countRatings'),
  array('sfPropelActAsRatableBehavior', 'setRating'),
  array('sfPropelActAsRatableBehavior', 'getMaxRating'),
  array('sfPropelActAsRatableBehavior', 'getRating'),
  array('sfPropelActAsRatableBehavior', 'getRatingDetails'),
  array('sfPropelActAsRatableBehavior', 'getReferenceKey'),
  array('sfPropelActAsRatableBehavior', 'getUserRating'),
  array('sfPropelActAsRatableBehavior', 'hasBeenRated'),
  array('sfPropelActAsRatableBehavior', 'hasBeenRatedByUser'),
  array('sfPropelActAsRatableBehavior', 'clearRatings'),
  array('sfPropelActAsRatableBehavior', 'clearUserRating'),
));                 
