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

  /**
   * returns the array of all the News that regards grouped events
   *
   * @return array of News
   * @author Guglielmo Celata
   **/
  public static function getAllGroupNews()
  {
    $c = new Criteria();
    $c->add(NewsPeer::GENERATOR_PRIMARY_KEYS, null);
    return NewsPeer::doSelect($c);
  }

  /**
   * return true, if the sf_news_cache table has a record, regarding 
   * an intervention on given date, place and act, eventually by an indentified politician
   * the act is an optional parameter, and, when not passed, the search assumes a 
   * different meaning alltogether, that is, a record with priority set to 1
   * is searched, where the value of the RELATED_MONITORABLE_MODEL field is uninfluent
   * the politician is also an optional parameter, passed as third parameter, in place
   * of the atto; the meaning, in this case is to look for an intervention of the politician
   * on any acts
   *
   * @param  date     $data    - the date of the seduta when the votation happened
   * @param  integer  $sede_id - the identifier for the OppSede object where the intervention was held
   * @param  char     $type    - specifies the type of search (Any, Atto, Politico)
   * @param  char     $tipo_atto_id - the type of act the news is related to (use along with $id if $type == 'Atto')
   * @param  integer  $id      - the identifier of the OppAtto or OppPolitico object the intervention is related to
   *
   * @return boolean
   * @author Guglielmo Celata
   **/
  public static function hasGroupIntervention($data, $sede_id, $type='Any', $tipo_atto_id = null, $id = null)
  {
    $c = self::buildGroupInterventionsCriteria($data, $sede_id, $type, $tipo_atto_id, $id);
    $n_res = NewsPeer::doCount($c);
    return $n_res>0?true:false;
  }

  /**
   * returns the array of News object that verify the criteria specified by the parameters
   * see parameters meaning in self::hasGroupIntervention()
   *
   * @return array of News
   * @author Guglielmo Celata
   **/
  public static function getGroupInterventions($data, $sede_id, $type='Any', $tipo_atto_id = null, $id = null)
  {
    $c = self::buildGroupInterventionsCriteria($data, $sede_id, $type, $tipo_atto_id, $id);
    return NewsPeer::doSelect($c);
  }
  
  /**
   * returns the array of all the News that regards grouped events for interventions 
   *
   * @return array of News
   * @author Guglielmo Celata
   **/
  public static function getAllGroupInterventions()
  {
    $c = new Criteria();
    $c->add(NewsPeer::GENERATOR_MODEL, 'OppIntervento');
    $c->add(NewsPeer::GENERATOR_PRIMARY_KEYS, null);
    return NewsPeer::doSelect($c);
  }
  
  /**
   * insert a record in the sf_news_cache table, regarding an intervention on a given
   * date, place and, optionally, act or politician; 
   * see description of hasGroupVotation, for the meaning of parameters
   *
   * @param  date     $data    - the date of the seduta when the votation happened
   * @param  integer  $sede_id - the identifier for the OppSede object where the intervention was held
   * @param  char     $type    - specifies the type of search (Any, Atto, Politico)
   * @param  integer  $id      - the identifier of the OppAtto or OppPolitico object the intervention is related to
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public static function addGroupIntervention($data, $sede_id, $type='Any', $tipo_atto_id = null, $id = null)
  {
    if (!isset($data) || !isset($sede_id)) 
      throw new deppPropelActAsNewsGeneratorException('both $data and $sede_id are required');
      
    $news = new News();
    $news->setGeneratorModel('OppIntervento');
    $news->setDate($data);
    $news->setSedeInterventoId($sede_id);
    if ($type != 'Any')
    {
      if ($type == 'Atto') 
      {
        if (!isset($tipo_atto_id)) throw new deppPropelActAsNewsGeneratorException('Va specificato il tipo di atto (ID) quando si aggiungono notizie di interventi legati a un atto ');       
        if (!isset($id)) 
          $news->setPriority(2);          
        else 
        {
          $news->setPriority(3);
          $news->setRelatedMonitorableId($id);
        }
        $news->setTipoAttoId($tipo_atto_id);
        $news->setRelatedMonitorableModel('OppAtto');        
      }
      else if ($type == 'Politico')
      {
        if (!isset($id)) throw new deppPropelActAsNewsGeneratorException('Va specificato un ID quando si aggiungono notizie di interventi legati a un politico');
        $news->setPriority(3);
        $news->setRelatedMonitorableId($id);
        $news->setRelatedMonitorableModel('OppPolitico');        
      }
      else
        throw new deppPropelActAsNewsGeneratorException('Il tipo di ricerca deve essere: Any, Atto o Politico');
    } else {
      $news->setPriority(1);
    }
    
    $news->save();
  }

  /**
   * builds the Propel Criterion to extract the group news generated by interventions
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public static function buildGroupInterventionsCriteria($data, $sede_id, $type='Any', $tipo_atto_id = null, $id = null)
  {
    if (!isset($data) || !isset($sede_id)) 
      throw new deppPropelActAsNewsGeneratorException('both $data and $sede_id are required');

    
    $c = new Criteria();
    $c->add(NewsPeer::GENERATOR_MODEL, 'OppIntervento');
    $c->add(NewsPeer::DATE, $data);
    $c->add(NewsPeer::SEDE_INTERVENTO_ID, $sede_id);
    if ($type != 'Any')
    {
      if ($type == 'Atto') 
      {
        if (!isset($tipo_atto_id)) throw new deppPropelActAsNewsGeneratorException('Va specificato il tipo di atto (ID) quando si cercano notizie di interventi legati a un atto ');       
        if (!isset($id))
          $c->add(NewsPeer::PRIORITY, 2);
        else
        {
          $c->add(NewsPeer::PRIORITY, 3);
          $c->add(NewsPeer::RELATED_MONITORABLE_ID, $id);          
        }
        $c->add(NewsPeer::TIPO_ATTO_id, $tipo_atto_id);
        $c->add(NewsPeer::RELATED_MONITORABLE_MODEL, 'OppAtto');
      }
      else if ($type == 'Politico')
      {
        if (!isset($id)) throw new deppPropelActAsNewsGeneratorException('Va specificato un ID quando si cercano notizie di interventi legati a un politico');
        $c->add(NewsPeer::PRIORITY, 3);
        $c->add(NewsPeer::RELATED_MONITORABLE_ID, $id);          
        $c->add(NewsPeer::RELATED_MONITORABLE_MODEL, 'OppPolitico');        
      }
      else
        throw new deppPropelActAsNewsGeneratorException('Il tipo di ricerca deve essere: Any, Atto o Politico');
    } else {
      $c->add(NewsPeer::PRIORITY, 1);
    }
    return $c;
  }
  

  /**
   * return true, if the sf_news_cache table has a record, regarding 
   * a votation, on given date, place and act
   * the act is an optional parameter, and, when not passed, the search assumes a 
   * different meaning alltogether, that is, a record with priority set to 1
   * is searched, where the value of the RELATED_MONITORABLE_MODEL field is uninfluent
   *
   * @param  date     $data - the date of the seduta when the votation happened
   * @param  char     $ramo - the place where the votation happened (C|S)
   * @param  char     $tipo_atto_id - the type of act the news is related to
   * @param  integer  $atto_id - the identifier for the OppAtto object the votation is related to
   *
   * @return boolean
   * @author Guglielmo Celata
   **/
  public static function hasGroupVotation($data, $ramo, $tipo_atto_id = null, $atto_id = null)
  {
    $c = self::buildGroupVotationsCriteria($data, $ramo, $tipo_atto_id, $atto_id);
    $n_res = NewsPeer::doCount($c);
    
    return $n_res>0?true:false;
  }

  /**
   * returns the array of News object that verify the criteria specified by the parameters
   * see parameters meaning in self::hasGroupVotation()
   *
   * @return array of News
   * @author Guglielmo Celata
   **/
  public static function getGroupVotations($data, $ramo, $tipo_atto_id = null, $atto_id = null)
  {
    $c = self::buildGroupVotationsCriteria($data, $ramo, $tipo_atto_id, $atto_id);
    return NewsPeer::doSelect($c);
  }
  
  /**
   * returns the array of all the News that regards grouped events for votations 
   *
   * @return array of News
   * @author Guglielmo Celata
   **/
  public static function getAllGroupVotations()
  {
    $c = new Criteria();
    $c->add(NewsPeer::GENERATOR_MODEL, 'OppVotazioneHasAtto');
    $c->add(NewsPeer::GENERATOR_PRIMARY_KEYS, null);
    return NewsPeer::doSelect($c);
  }
  
  
  /**
   * insert a record in the sf_news_cache table, regarding votation on given
   * date, place and act; see description of hasGroupVotation, for the meaning of
   * parameters
   *
   * @param  date     $data - the date of the seduta when the votation happened
   * @param  char     $ramo - the place where the votation happened (C|S)
   * @param  char     $tipo_atto_id - the type of act the news is related to
   * @param  integer  $atto_id - the identifier for the OppAtto object the votation is related to
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function addGroupVotation($data, $ramo, $tipo_atto_id = null, $atto_id = null)
  {
    if (!isset($data) || !isset($ramo)) 
      throw new deppPropelActAsNewsGeneratorException('both $data and $ramo are required');
      
    $news = new News();
    $news->setGeneratorModel('OppVotazioneHasAtto');
    $news->setDate($data);
    $news->setRamoVotazione($ramo);
    if (isset($atto_id))
    {
      if (isset($tipo_atto_id))
        $news->setTipoAttoId($tipo_atto_id);
      $news->setPriority(3);
      $news->setRelatedMonitorableId($atto_id);
      $news->setRelatedMonitorableModel('OppAtto');
    } else {
      if (isset($tipo_atto_id))
      {
        $news->setPriority(2);
        $news->setTipoAttoId($tipo_atto_id);
        $news->setRelatedMonitorableModel('OppAtto');
      } else
        $news->setPriority(1);
    }
    
    $news->save();
  }

  /**
   * builds a Propel Criteria to count or extract all the group votations
   *
   * @return Criteria object
   * @author Guglielmo Celata
   **/
  public static function buildGroupVotationsCriteria($data, $ramo, $tipo_atto_id = null, $atto_id = null)
  {
    if (!isset($data) || !isset($ramo)) 
      throw new deppPropelActAsNewsGeneratorException('both $data and $ramo are required');
      
    $c = new Criteria();
    $c->add(NewsPeer::DATE, $data);
    $c->add(NewsPeer::RAMO_VOTAZIONE, $ramo);
    if (isset($atto_id))
    {
      if (isset($tipo_atto_id))
        $c->add(NewsPeer::TIPO_ATTO_ID, $tipo_atto_id);        
      $c->add(NewsPeer::PRIORITY, 3);
      $c->add(NewsPeer::RELATED_MONITORABLE_MODEL, 'OppAtto');
      $c->add(NewsPeer::RELATED_MONITORABLE_ID, $atto_id);
    } else {
      if (isset($tipo_atto_id))
      {
        $c->add(NewsPeer::PRIORITY, 2);
        $c->add(NewsPeer::RELATED_MONITORABLE_MODEL, 'OppAtto');
        $c->add(NewsPeer::TIPO_ATTO_ID, $tipo_atto_id);
      } else
        $c->add(NewsPeer::PRIORITY, 1);        
    }
    
    return $c;
  }
  
  public static function countHomeNews()
  {
    $c = self::getHomeNewsCriteria();
    return self::doCount($c);
  }

  public static function getHomeNewsGroupedByDayRS()
  {
    $c = self::getHomeNewsCriteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(self::DATE);
    $c->addAsColumn('numNews', 'count('.self::DATE.')');
    $c->addGroupByColumn(self::DATE);
    $c->addDescendingOrderByColumn(self::DATE);
    
    return self::doSelectRS($c);
  }

  public static function getHomeNewsCriteria()
  {
    $c = new Criteria();
    $c->add(self::PRIORITY, 1);

    return $c;
  }
  
  public static function countNewsForItem($item_type, $item_id)
  {
    $c = new Criteria();
    $c->add(self::RELATED_MONITORABLE_MODEL, $item_type);
    $c->add(self::RELATED_MONITORABLE_ID, $item_id);
      
    return self::doCount($c);
  }

  public static function getNewsForItem($item_type, $item_id, $limit = 0)
  {
    
    $c = new Criteria();
    $c->add(self::RELATED_MONITORABLE_MODEL, $item_type);
    $c->add(self::RELATED_MONITORABLE_ID, $item_id);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    if ($limit > 0)
      $c->setLimit(10);
      
    return self::doSelect($c);
  }

  public static function getMyMonitoredItemsNewsCriteria($monitored_objects)
  {
    $opp_user = OppUserPeer::retrieveByPK(sfContext::getInstance()->getUser()->getId());
    return self::getUserMonitoredItemsNewsCriteria($opp_user, $monitored_objects);
  }

  public static function getUserMonitoredItemsNewsCriteria($user, $monitored_objects)
  {    
    // costruzione dell'array associativo tipo_oggetto => array_di_id
    $monitored_hash = array('OppAtto' => array(), 'OppPolitico' => array());
    foreach ($monitored_objects as $obj)
    {
      if (in_array(get_class($obj), array('OppAtto', 'OppPolitico')))
        array_push($monitored_hash[get_class($obj)], $obj->getId());
      if (get_class($obj) == 'Tag')
      {
        $tagged_with = $obj->getTaggedWith();
        foreach ($tagged_with as $tagged_obj) {
          array_push($monitored_hash[get_class($tagged_obj)], $tagged_obj->getId());
        }
      }
    }
    
    // costruzione della query paginata
    $c = new Criteria();
  	$c->addDescendingOrderByColumn(NewsPeer::DATE);

    // criterio per gli atti
    $crit0 = $c->getNewCriterion(NewsPeer::RELATED_MONITORABLE_MODEL, 'OppAtto');
    $crit1 = $c->getNewCriterion(NewsPeer::RELATED_MONITORABLE_ID, $monitored_hash['OppAtto'], Criteria::IN);
    $crit0->addAnd($crit1);

    // criterio per i politici
    $crit2 = $c->getNewCriterion(NewsPeer::RELATED_MONITORABLE_MODEL, 'OppPolitico');
    $crit3 = $c->getNewCriterion(NewsPeer::RELATED_MONITORABLE_ID, $monitored_hash['OppPolitico'], Criteria::IN);
    $crit2->addAnd($crit3);

    // politici e atti in OR
    $crit0->addOr($crit2);

    $c->add($crit0);
    
    return $c;
    
  }


  /**
   * return all news generated by generator object
   *
   * @param  BaseObject generator
   * @return array of News
   * @author Guglielmo Celata
   **/
  public static function getNewsGeneratedByGenerator($generator)
  {
    return self::getNewsGeneratedByGeneratorModelAndPrimaryKeys(get_class($generator), serialize($generator->getPrimaryKeysArray()));
  }
  
  /**
   * return all news generated by generator model and keys
   *
   * @param  String generator_model - the PhpName of the model
   * @param  String generator_keys  - the primary keys (serialized, of the generator)
   * @return array of News
   * @author Guglielmo Celata
   **/
  public static function getNewsGeneratedByGeneratorModelAndPrimaryKeys($generator_model, $generator_keys)
  {
    $c = new Criteria();
    $c->add(NewsPeer::GENERATOR_MODEL, $generator_model);
    $c->add(NewsPeer::GENERATOR_PRIMARY_KEYS, $generator_keys);
    return NewsPeer::doSelect($c);
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
