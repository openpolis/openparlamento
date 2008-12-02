<?php
/*
 * This file is part of the deppPropelActAsBookmarkableBehavior package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

sfPropelBehavior::registerHooks('deppPropelActAsBookmarkableBehavior', array (
  ':delete:pre' => array ('deppPropelActAsBookmarkableBehavior', 'preDelete'),
));

sfPropelBehavior::registerMethods('deppPropelActAsBookmarkableBehavior', array (
  array('deppPropelActAsBookmarkableBehavior', 'getBookmarkableReferenceKey'),  
  array('deppPropelActAsBookmarkableBehavior', 'countPositiveBookmarkings'),
  array('deppPropelActAsBookmarkableBehavior', 'countNegativeBookmarkings'),
  array('deppPropelActAsBookmarkableBehavior', 'removeAllBookmarkings'),
  array('deppPropelActAsBookmarkableBehavior', 'removePositiveBookmarking'),
  array('deppPropelActAsBookmarkableBehavior', 'removeNegativeBookmarking'),
  array('deppPropelActAsBookmarkableBehavior', 'hasBeenPositivelyBookmarked'),
  array('deppPropelActAsBookmarkableBehavior', 'hasBeenNegativelyBookmarked'),
  array('deppPropelActAsBookmarkableBehavior', 'setPositiveBookmarking'),
  array('deppPropelActAsBookmarkableBehavior', 'setNegativeBookmarking'),
));                 
