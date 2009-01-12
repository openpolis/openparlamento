<?php

/**
 * Subclass for representing a row from the 'sf_test_object' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfTestObject extends BasesfTestObject
{
}
/*
sfPropelBehavior::add(
  'sfTestObject', 
  array('deppPropelActAsCommentableBehavior' =>
        array('count_cache_enabled'   => true,
              'count_cache_method'    => 'setSfCommentCount')));
*/

sfPropelBehavior::add(
  'sfTestObject', 
  array('deppPropelActAsEmendableBehavior' =>
        array('count_cache_enabled'   => true,
              'count_cache_method'    => 'setSfCommentCount')));

