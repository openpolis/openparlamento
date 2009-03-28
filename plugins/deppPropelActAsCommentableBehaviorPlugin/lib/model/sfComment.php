<?php

/**
 * Subclass for representing a row from the 'sf_comment' table.
 *
 * 
 *
 * @package plugins.deppPropelActAsCommentableBehaviorPlugin.lib.model
 */ 
class sfComment extends BasesfComment
{
}

# nel progetto Openparlamento, questa classe è anche
# generatore di notizie di community
sfPropelBehavior::add(
  'sfComment',
  array('deppPropelActAsCommunityNewsGeneratorBehavior' =>
        array('rel_model_getter' => 'getCommentableModel',
              'rel_id_getter'    => 'getCommentableId',
        )));
