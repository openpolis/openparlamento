<?php
/*
 * This file is part of the deppPropelActAsTaggableBehavior package.
 *
 * (c) 2007 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

sfPropelBehavior::registerHooks('deppPropelActAsTaggableBehavior', array (
  ':save:post' => array ('deppPropelActAsTaggableBehavior', 'postSave'),
  ':delete:pre' => array ('deppPropelActAsTaggableBehavior', 'preDelete'),
));


sfPropelBehavior::registerMethods('deppPropelActAsTaggableBehavior', array (
  array ('deppPropelActAsTaggableBehavior', 'addTag'),
  array ('deppPropelActAsTaggableBehavior', 'getTags'),
  array ('deppPropelActAsTaggableBehavior', 'getUserTags'),
  array ('deppPropelActAsTaggableBehavior', 'hasTag'),
  array ('deppPropelActAsTaggableBehavior', 'removeAllTags'),
  array ('deppPropelActAsTaggableBehavior', 'removeTag'),
  array ('deppPropelActAsTaggableBehavior', 'replaceTag'),
  array ('deppPropelActAsTaggableBehavior', 'setTags'),
  array ('deppPropelActAsTaggableBehavior', 'getTagsAsObjects'),
));