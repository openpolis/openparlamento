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


  /**
   * estrae tutti gli id dei tag associati ad almeno un atto, prima di una data
   *
   * @param string $taggable_model
   * @param string $data 
   * @return array di id
   * @author Guglielmo Celata
   */
  public function getActiveTagsIdsData($taggable_model, $data)
  {
		$con = Propel::getConnection(self::DATABASE_NAME);

    $sql = sprintf("select distinct tag_id from sf_tagging where taggable_model='%s' and created_at < '%s'",
                   $taggable_model, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $ids = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $ids []= $row['tag_id'];
    }
    
    return $ids;
  }

  public function getTaggableIdsData($tag_id, $taggable_model, $data)
  {
		$con = Propel::getConnection(self::DATABASE_NAME);

    $sql = sprintf("select taggable_id from sf_tagging where taggable_model='%s' and tag_id=%d and created_at < '%s'",
                   $taggable_model, $tag_id, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $ids = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $ids []= $row['taggable_id'];
    }
    
    return $ids;
  }

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
