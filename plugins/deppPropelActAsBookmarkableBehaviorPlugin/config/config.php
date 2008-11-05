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
  array('deppPropelActAsBookmarkableBehavior', 'allowsAnonymousBookmarking'),  
  array('deppPropelActAsBookmarkableBehavior', 'setBookmarking'),
  array('deppPropelActAsBookmarkableBehavior', 'getBookmarking'),
  array('deppPropelActAsBookmarkableBehavior', 'getBookmarkingDetails'),
  array('deppPropelActAsBookmarkableBehavior', 'getReferenceKey'),
  array('deppPropelActAsBookmarkableBehavior', 'getUserBookmarking'),
  array('deppPropelActAsBookmarkableBehavior', 'hasBeenBokmarked'),
  array('deppPropelActAsBookmarkableBehavior', 'hasBeenBokmarkedByUser'),
  array('deppPropelActAsBookmarkableBehavior', 'clearBookmarkings'),
  array('deppPropelActAsBookmarkableBehavior', 'clearUserBookmarking'),
));                 
