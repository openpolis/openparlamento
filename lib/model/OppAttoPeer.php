<?php

/**
 * Subclass for performing query and update operations on the 'opp_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAttoPeer extends BaseOppAttoPeer
{

  /**
   * transform an array of objects into an array of Primary Keys
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public static function transformIntoPKs($objects)
  {
    // creates a callback function able to invoke the object's getPrimaryKey method
    $getPK_callback = create_function('$e', 'return call_user_func(array($e, "getPrimaryKey"));');
    return array_map($getPK_callback, $objects);
  }
    
  /**
   * returns the Atto objects that are indirectly monitored by a user, 
   * that monitors at least one tag with which the object has been tagged
   *
   * @param  OppUser
   * @param  OppTipoAtto - if give, acts as a filter
   * @return array of objects
   * @author Guglielmo Celata
   **/
  public static function doSelectIndirectlyMonitoredByUser($user, $type = null, $criteria = null)
  {
    if (!($user instanceof OppUser)) throw new Exception('A user must be specified');
    
    // build the array of monitored tags_ids
    $my_monitored_tags_pks = self::transformIntoPKs($user->getMonitoredObjects('Tag', $criteria));
      
    // fetch all acts tagged with the monitored tags (indirect monitoring)
    $c = new Criteria();
    if ($type instanceof OppTipoAtto)
    {
      $c->addJoin(OppTipoAttoPeer::ID, OppAttoPeer::TIPO_ATTO_ID);
      $c->add(OppTipoAttoPeer::ID, $type->getPrimaryKey());
    }
    $c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
    $c->add(TaggingPeer::TAG_ID, $my_monitored_tags_pks, Criteria::IN);
    $indirectly_monitored_acts = OppAttoPeer::doSelect($c);
    unset($c);
    
    return $indirectly_monitored_acts;
    
  }
  
  /**
   * returns the Atto objects that are indirectly monitored by a user, 
   * joined with the Tags Objects themselves
   *
   * @param  OppUser
   * @param  OppTipoAtto - if give, acts as a filter
   * @return array of objects
   * @author Guglielmo Celata
   **/
  public static function doSelectIndirectlyMonitoredByUserJoinTags($user, $type = null, $criteria = null)
  {
    if (!($user instanceof OppUser)) throw new Exception('A user must be specified');
    
    // build the array of monitored tags_ids
    $my_monitored_tags_pks = self::transformIntoPKs($user->getMonitoredObjects('Tag', $criteria));
    
    // fetch all acts tagged with the monitored tags (indirect monitoring)
    $c = new Criteria();
    if ($type instanceof OppTipoAtto)
    {
      $c->addJoin(OppTipoAttoPeer::ID, OppAttoPeer::TIPO_ATTO_ID);
      $c->add(OppTipoAttoPeer::ID, $type->getPrimaryKey());
    }
    $c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
    $c->add(TaggingPeer::TAG_ID, $my_monitored_tags_pks, Criteria::IN);
    $indirectly_monitored_acts = OppAttoPeer::doSelect($c);
    unset($c);
    
    return $indirectly_monitored_acts;
    
  }
  
  
  /**
   * returns the Atto objects that are directly monitored by a user, 
   *
   * @param  OppUser
   * @param  OppTipoAtto - if give, acts as a filter
   * @return array of objects
   * @author Guglielmo Celata
   **/
  public static function doSelectDirectlyMonitoredByUser($user, $type = null)
  {
    
    if (!($user instanceof OppUser)) throw new Exception('A user must be specified');
    $c = new Criteria();

    if ($type instanceof OppTipoAtto)
    {
      $c->addJoin(OppTipoAttoPeer::ID, OppAttoPeer::TIPO_ATTO_ID);
      $c->add(OppTipoAttoPeer::ID, $type->getPrimaryKey());      
    }

    // fetch directly monitored acts PKs
    $directly_monitored_acts_pks = self::transformIntoPKs($user->getMonitoredObjects('OppAtto', $c));
    
    // return objects
    return self::retrieveByPKs($directly_monitored_acts_pks);
    
  }

  public static function merge($items1, $items2)
  {
    // merge directly and indirectly monitored acts types
    $items_pks = array_merge(self::transformIntoPKs($items1), self::transformIntoPKs($items2));
    return self::retrieveByPKs($items_pks);
  }
  
  
  public static function doSelectPrimiFirmatari($pred)
  {
    $primi_firmatari = array();
	
    $rs = OppAttoPeer::getRecordsetFirmatari($pred, 'P');
	
	  while ($rs->next())
    {
	  $primi_firmatari[$rs->getInt(1)]=$rs->getDate(5, 'Y-m-d').' * '.$rs->getString(2).' '.$rs->getString(3).' ('.$rs->getString(4).')'; 
	  }
	  return $primi_firmatari;
	
  }
  
  
  public static function doSelectCoFirmatari($pred)
  {
    $co_firmatari = array();
	
	  $rs = OppAttoPeer::getRecordsetFirmatari($pred, 'C');
	
	  while ($rs->next())
    {
	    $co_firmatari[$rs->getInt(1)]=$rs->getDate(5, 'Y-m-d').' * '.$rs->getString(2).' '.$rs->getString(3).' ('.$rs->getString(4).')';  
	  }
    
	  return $co_firmatari;
  }
  
   public static function doSelectRelatori($pred)
  {
    $relatori = array();
	
	$rs = OppAttoPeer::getRecordsetFirmatari($pred, 'R');
	
	while ($rs->next())
    {
	  $relatori[$rs->getInt(1)]=$rs->getString(2).' '.$rs->getString(3).' ('.$rs->getString(4).')'; 
	}
    
	return $relatori;
  }
  
  public static function doSelectTeseo($pred)
  {
    $argomenti = array(); 
	
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppTeseoPeer::ID);
	$c->addSelectColumn(OppTeseoPeer::DENOMINAZIONE);
	$c->add(OppAttoHasTeseoPeer::ATTO_ID, $pred, Criteria::EQUAL);
	$c->addJoin(OppAttoHasTeseoPeer::TESEO_ID, OppTeseoPeer::ID, Criteria::LEFT_JOIN);
	$c->addAscendingOrderByColumn(OppTeseoPeer::DENOMINAZIONE);
	$rs = OppAttoHasTeseoPeer::doSelectRS($c);
	
	while ($rs->next())
    {
	  $argomenti[$rs->getInt(1)]=$rs->getString(2);  
	}
    
	return $argomenti;
  }
  
  protected static function getRecordsetFirmatari($pred, $tipo)
  {
    $c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppPoliticoPeer::ID);
	$c->addSelectColumn(OppPoliticoPeer::NOME);
	$c->addSelectColumn(OppPoliticoPeer::COGNOME);
	$c->addSelectColumn(OppGruppoPeer::NOME);
	$c->addSelectColumn(OppCaricaHasAttoPeer::DATA);
	$c->add(OppCaricaHasAttoPeer::ATTO_ID, $pred, Criteria::EQUAL);
	$c->addJoin(OppCaricaHasAttoPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::LEFT_JOIN);
	$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::LEFT_JOIN);
	$c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::LEFT_JOIN);
	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::LEFT_JOIN);
	$c->add(OppCaricaHasAttoPeer::TIPO, $tipo, Criteria::EQUAL);
	$c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
	$rs = OppCaricaHasAttoPeer::doSelectRS($c);
	
	return $rs;
  }
  
  public static function doSelectNews()
  {
    $news = array();
	
	// nuovi ddl
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppAttoPeer::DATA_PRES);
	$c->addSelectColumn(OppAttoPeer::RAMO);
	$c->addSelectColumn(OppAttoPeer::NUMFASE);
	$c->addSelectColumn(OppAttoPeer::TITOLO);
	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
	$c->add(OppAttoPeer::TIPO_ATTO_ID, 1, Criteria::EQUAL);
	$c->setLimit(5);
	$rs = OppAttoPeer::doSelectRS($c);
	
	// cambi di status
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppAttoHasIterPeer::DATA);
	$c->addSelectColumn(OppAttoPeer::RAMO);
	$c->addSelectColumn(OppAttoPeer::NUMFASE);
	$c->addSelectColumn(OppAttoPeer::TITOLO);
	$c->addSelectColumn(OppIterPeer::FASE);
	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
	$c->add(OppAttoPeer::TIPO_ATTO_ID, 1, Criteria::EQUAL);
	$c->addJoin(OppAttoHasIterPeer::ATTO_ID, OppAttoPeer::ID, Criteria::LEFT_JOIN);
	$c->addJoin(OppAttoHasIterPeer::ITER_ID, OppIterPeer::ID, Criteria::LEFT_JOIN);
	$c->setLimit(5);
	$rs = OppAttoPeer::doSelectRS($c);
	
	while ($rs->next())
    {
	  
	}  
  }
  
  
}
?>