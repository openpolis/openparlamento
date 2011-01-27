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
 * estrae la lista dei tag con il numero di atti  associati per ogni tag
 *
 * @param string $value indica il tipo di oggetto taggato (OppAtto o OppEmendamento)
 * @param @param array $tipo indica il tipo di tag (user,teseo, geoteseo,op)
 * @return void
 * @author Ettore Di Cesare
 */
public function CountTagForAtti($value, $tipo="('teseo','geoteseo','user','op')")
{
  $con = Propel::getConnection(self::DATABASE_NAME);

  $sql = sprintf("select count(*) as cn, t.id as id, t.triple_value as value from sf_tagging tg,sf_tag t where t.id=tg.tag_id and taggable_model='".$value."' and t.triple_namespace in ". $tipo ." group by t.id");
  $stm = $con->createStatement(); 
  $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

  $ids = array();
  while ($rs->next()) {
    $row = $rs->getRow();
    $ids [$row['id']]= array($row['value'], $row['cn']);
  }
  
  return $ids;
}


  /**
   * estrae tutti gli id dei tag associati ad almeno un atto
   *
   * @param string $taggable_model
   * @return array di id
   * @author Guglielmo Celata
   */
  public function getActiveTagsIds($taggable_model)
  {
		$con = Propel::getConnection(self::DATABASE_NAME);

    $sql = sprintf("select distinct tag_id from sf_tagging where taggable_model='%s'",
                   $taggable_model);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $ids = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $ids []= $row['tag_id'];
    }
    
    return $ids;
  }

  public function getTaggableIds($tag_id, $taggable_model)
  {
		$con = Propel::getConnection(self::DATABASE_NAME);

    $sql = sprintf("select taggable_id from sf_tagging where taggable_model='%s' and tag_id=%d",
                   $taggable_model, $tag_id);
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


  public static function getTagIDsByTaggableIDAndTaggableModel($taggable_id, $taggable_model)
  {
    $c = new Criteria();
    $c->add(self::TAGGABLE_ID, $taggable_id);
    $c->add(self::TAGGABLE_MODEL, $taggable_model);
    $c->clearSelectColumns();
    $c->addSelectColumn(self::TAG_ID);
    $rs = self::doSelectRS($c);
    
    $ids = array();
    while ($rs->next()) {
      $ids []= $rs->getInt(1);
    }
    
    return $ids;
  }
    
}
