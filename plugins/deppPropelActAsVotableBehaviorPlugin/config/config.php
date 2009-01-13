<?php
/*
 * This file is part of the deppPropelActAsVotableBehavior package.
 *
 * (c) 2007 Nicolas Perriault <nperriault@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

sfPropelBehavior::registerHooks('deppPropelActAsVotableBehavior', array (
  ':delete:pre' => array ('deppPropelActAsVotableBehavior', 'preDelete'),
));

sfPropelBehavior::registerMethods('deppPropelActAsVotableBehavior', array (
  array('deppPropelActAsVotableBehavior', 'countVotings'),
  array('deppPropelActAsVotableBehavior', 'getVotingRange'),  
  array('deppPropelActAsVotableBehavior', 'allowsNeutralPosition'),
  array('deppPropelActAsVotableBehavior', 'allowsAnonymousVoting'),  
  array('deppPropelActAsVotableBehavior', 'setVoting'),
  array('deppPropelActAsVotableBehavior', 'getVoting'),
  array('deppPropelActAsVotableBehavior', 'getVotingDetails'),
  array('deppPropelActAsVotableBehavior', 'getReferenceKey'),
  array('deppPropelActAsVotableBehavior', 'getUserVoting'),
  array('deppPropelActAsVotableBehavior', 'hasBeenVoted'),
  array('deppPropelActAsVotableBehavior', 'hasBeenVotedByUser'),
  array('deppPropelActAsVotableBehavior', 'clearVotings'),
  array('deppPropelActAsVotableBehavior', 'clearUserVoting'),
  array('deppPropelActAsVotableBehavior', 'getVotingUsersPKs'),
  array('deppPropelActAsVotableBehavior', 'getVotingUsers'),
  array('deppPropelActAsVotableBehavior', 'countVotingUsers'),
));                 
