<?php

/**
 * Subclass for performing query and update operations on the 'sf_tagging_for_index' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TaggingForIndexPeer extends BaseTaggingForIndexPeer
{

  public static function retrieveByTagAndAtto($tag_id, $atto_id)
  {
    $c = new Criteria();
    $c->add(self::TAG_ID, $tag_id);
    $c->add(self::ATTO_ID, $atto_id);
    return self::doSelectOne($c);    
  }
  
  public static function retrieveOrCreateByTagAndAtto($tag_id, $atto_id)
  {
    $tagging = self::retrieveByTagAndAtto($tag_id, $atto_id);
    if (!$tagging)
    {
      $tagging = new TaggingForIndex();
      $tagging->setTagId($tag_id);
      $tagging->setAttoId($atto_id);
    }
    return $tagging;
  }

  public static function getAttoIdsByTag($tag_id)
  {
    $c = new Criteria();
    $c->add(self::TAG_ID, $tag_id);
    $c->clearSelectColumns();
    $c->addSelectColumn(self::ATTO_ID);
    return self::doSelectRS($c);
  }

}
