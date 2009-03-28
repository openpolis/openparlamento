<?php

/**
 * Subclass for representing a row from the 'sf_votings' table.
 *
 * 
 *
 * @package plugins.deppPropelActAsVotableBehaviorPlugin.lib.model
 */ 
class sfVoting extends BasesfVoting
{
}

# nel progetto Openparlamento, questa classe è anche
# generatore di notizie di community
sfPropelBehavior::add(
  'sfVoting',
  array('deppPropelActAsCommunityNewsGeneratorBehavior' =>
        array('rel_model_getter' => 'getVotableModel',
              'rel_id_getter'    => 'getVotableId',
        )));
