<?php

/**
 * Subclass for representing a row from the 'sf_test_bookmarkable' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfTestBookmarkable extends BasesfTestBookmarkable
{
}

sfPropelBehavior::add(
  'sfTestBookmarkable', 
  array('deppPropelActAsBookmarkableBehavior' => array()));
