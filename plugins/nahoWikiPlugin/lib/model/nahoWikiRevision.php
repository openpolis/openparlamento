<?php

/**
 * Subclass for representing a row from the 'sf_simple_wiki_revision' table.
 *
 * 
 *
 * @package plugins.nahoWikiPlugin.lib.model
 */

require_once sfConfig::get('sf_plugins_dir') . '/nahoWikiPlugin/lib/model/plugin/PluginnahoWikiRevision.php';

class nahoWikiRevision extends PluginnahoWikiRevision
{
  public function getRelatedModel()
  {
    $name = $this->getnahoWikiPage()->getName();
    list($prefix, $id) = split("_", $name);
    switch ($prefix) 
    {
      case 'atto':
        return 'OppAtto';
        break;
      case 'votazione':
        return 'OppVotazione';
        break;
    }
  }
  
  public function getRelatedId()
  {
    $name = $this->getnahoWikiPage()->getName();
    list($prefix, $id) = split("_", $name);
    return $id;
  }
  
}

# nel progetto Openparlamento, questa classe è anche
# generatore di notizie di community
sfPropelBehavior::add(
  'nahoWikiRevision',
  array('deppPropelActAsCommunityNewsGeneratorBehavior' =>
        array('rel_model_getter' => 'getRelatedModel',
              'rel_id_getter'    => 'getRelatedId',
        )));
