<?php

/**
 * Subclass for representing a row from the 'opp_opinable' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppOpinable extends BaseOppOpinable
{
}

sfPropelBehavior::add('OppOpinable', array('sfPropelActAsTaggableBehavior'));
