<?php
/*
 * This file is part of the deppPropelActAsCommentableBehavior package.
 * 
 * (c) 2008 Guglielmo Celata <guglielmo@depp.it>
 * based on sfPropelActAsCommentable, by Xavier Lacot <xavier@lacot.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
sfPropelBehavior::registerHooks('deppPropelActAsCommentableBehavior', array (
 ':delete:pre' => array ('deppPropelActAsCommentableBehavior', 'preDelete'),
));
 
sfPropelBehavior::registerMethods('deppPropelActAsCommentableBehavior', array (
  array ('deppPropelActAsCommentableBehavior', 'addComment'),
  array ('deppPropelActAsCommentableBehavior', 'clearComments'),
  array ('deppPropelActAsCommentableBehavior', 'getComments'),
  array ('deppPropelActAsCommentableBehavior', 'getPublicComments'),
  array ('deppPropelActAsCommentableBehavior', 'getNbComments'),
  array ('deppPropelActAsCommentableBehavior', 'getNbPublicComments'),
  array ('deppPropelActAsCommentableBehavior', 'removeComment'),
  array ('deppPropelActAsCommentableBehavior', 'publishComment'),
  array ('deppPropelActAsCommentableBehavior', 'unpublishComment')  
));