<?php

/**
 * Subclass for representing a row from the 'sf_emend_comment' table.
 *
 * 
 *
 * @package plugins.sfEmendPlugin.lib.model
 */ 
class sfEmendComment extends BasesfEmendComment
{
  public function getCommentedModel()
  {
    return 'OppDocumento';
  }
  
  public function getCommentedId()
  {
    $url = $this->getUrl();
    $token = strtok($url, '_');
    while ($token !== 'id')
      $token = strtok('_');
    
    $id = strtok('_');
    return $id;
  }

}

# nel progetto Openparlamento, questa classe è anche
# generatore di notizie di community
sfPropelBehavior::add(
  'sfEmendComment',
  array('deppPropelActAsCommunityNewsGeneratorBehavior' =>
        array('rel_model_getter' => 'getCommentedModel',
              'rel_id_getter'    => 'getCommentedId',
        )));
