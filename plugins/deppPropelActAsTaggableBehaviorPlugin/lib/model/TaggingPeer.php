<?php

/**
 * Subclass for performing query and update operations on the 'tagging' table.
 *
 * 
 *
 * @package plugins.sfPropelActAsTaggableBehaviorPlugin.lib.model
 */ 
class TaggingPeer extends BaseTaggingPeer
{

  public static function retrieveByTagAndTaggable($tag_id, $taggable_id, $taggable_model)
  {
    $c = new Criteria();
    $c->add(self::TAG_ID, $tag_id);
    $c->add(self::TAGGABLE_MODEL, $taggable_model);
    $c->add(self::TAGGABLE_ID, $taggable_id);
    return self::doSelectOne($c);    
  }
  
  public static function retrieveOrCreateByTagAndTaggable($tag_id, $taggable_id, $taggable_model)
  {
    $tagging = self::retrieveByTagAndTaggable($tag_id, $taggable_id, $taggable_model);
    if (!$tagging)
    {
      $tagging = new Tagging();
      $tagging->setTagId($tag_id);
      $tagging->setTaggableId($taggable_id);
      $tagging->setTaggableModel($taggable_model);      
    }
    return $tagging;
  }

  public static function getTaggableIDsByTagAndTaggableModel($tag_id, $taggable_model)
  {
    $c = new Criteria();
    $c->add(self::TAG_ID, $tag_id);
    $c->add(self::TAGGABLE_MODEL, $taggable_model);
    $c->clearSelectColumns();
    $c->addSelectColumn(self::TAGGABLE_ID);
    return self::doSelectRS($c);
  }
    
}
