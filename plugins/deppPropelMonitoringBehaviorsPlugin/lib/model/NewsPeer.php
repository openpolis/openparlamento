<?php

/**
 * Subclass for performing query and update operations on the 'sf_news_cache' table.
 *
 * 
 *
 * @package plugins.deppPropelMonitoringBehaviorsPlugin.lib.model
 */ 
class NewsPeer extends BaseNewsPeer
{
  


  public static function getNewsForAct($act_id)
  {
    $c = new Criteria();
    $c->add(self::RELATED_MONITORABLE_MODEL, 'OppAtto');
    $c->add(self::RELATED_MONITORABLE_ID, $act_id);
    $c->addAscendingOrderByColumn(self::DATE);
    return self::doSelect($c);
  }

  public static function getNewsGeneratedByGenerator($generator)
  {
    return self::getNewsGeneratedByGeneratorModelAndId(get_class($generator), $generator->getPrimaryKey());
  }
  
  /**
   * return all news objects ahvinc given generator model and id
   *
   * @param  String generator_model - the PhpName of the model
   * @param  int    generator_id    - the primary key
   * @return array - Objects meeting the criteria
   * @author Guglielmo Celata
   **/
  public static function getNewsGeneratedByGeneratorModelAndId($generator_model, $generator_id)
  {
    $c = new Criteria();
    $c->add(self::GENERATOR_MODEL, $generator_model);
    $c->add(self::GENERATOR_ID, $generator_id);
    return self::doSelect($c);
  }

  /**
   * return all news objects ahvinc given monitorable model and id
   *
   * @param  String generator_model - the PhpName of the model
   * @param  int    generator_id    - the primary key
   * @return array - Objects meeting the criteria
   * @author Guglielmo Celata
   **/
  public static function getNewsRelatedToMonitorableModelAndId($monitorable_model, $monitorable_id)
  {
    $c = new Criteria();
    $c->add(self::RELATED_MONITORABLE_MODEL, $monitorable_model);
    $c->add(self::RELATED_MONITORABLE_ID, $monitorable_id);
    return self::doSelect($c);
  }
  
  
}
