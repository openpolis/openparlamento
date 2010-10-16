<?php

/**
 * Subclass for performing query and update operations on the 'opp_tipo_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppTipoAttoPeer extends BaseOppTipoAttoPeer
{

  // mappa i tipo_atto_id in tipologie per il calcolo dell'indice di attività
  public static $tipi_per_indice = array(
    1 => 'ddl',
    2 => 'mozione',
    3 => 'interpellanza',
    4 => 'interrogazione', 5 => 'interrogazione', 6 => 'interrogazione',
    7 => 'risoluzione', 8 => 'risoluzione', 9 => 'risoluzione',
    10 => 'odg', 11 => 'odg' ,
    14 => 'audizione'  
  );
  
  /**
   * trasforma i tipo_atto_id in tipologie per il calcolo dell'indice di attività
   *
   * @param string $tipo_atto_id 
   * @return integer (se non c'è mapping è 0)
   * @author Guglielmo Celata
   */
  public static function getTipoPerIndice($tipo_atto_id)
  {
    if (array_key_exists($tipo_atto_id, self::$tipi_per_indice))
      return self::$tipi_per_indice[$tipo_atto_id];
    else
      return null;
  }
  
  public static function doSelectIndirectlyMonitoredByUser($user, $criteria=null)
  {    
   
    if (!($user instanceof OppUser)) throw new Exception('A user must be specified');
    
    // build the array of monitored tags_ids
    $my_monitored_tags_pks = Util::transformIntoPKs($user->getMonitoredObjects('Tag', $criteria));
    
    // fetch all acts types tagged with the monitored tags (indirect monitoring)
    $c = new Criteria();
    $c->addJoin(OppTipoAttoPeer::ID, OppAttoPeer::TIPO_ATTO_ID);
    $c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
    $c->add(TaggingPeer::TAG_ID, $my_monitored_tags_pks, Criteria::IN);
    $c->addGroupByColumn(OppAttoPeer::TIPO_ATTO_ID);
    $indirectly_monitored_acts_types = OppTipoAttoPeer::doSelect($c);
    unset($c);

    return $indirectly_monitored_acts_types;
    
  }
  
  public static function doSelectDirectlyMonitoredByUser($user, $criteria=null)
  {
    
    if (!($user instanceof OppUser)) throw new Exception('A user must be specified');

    // fetch directly monitored acts
    $directly_monitored_acts_pks = Util::transformIntoPKs($user->getMonitoredObjects('OppAtto', $criteria));
    
    // fetch types of acts directly monitored
    $c = new Criteria();
    $c->addJoin(OppTipoAttoPeer::ID, OppAttoPeer::TIPO_ATTO_ID);    
    $c->addGroupByColumn(OppAttoPeer::TIPO_ATTO_ID);
    $c->add(OppAttoPeer::ID, $directly_monitored_acts_pks, Criteria::IN);
    $directly_monitored_acts_types = OppTipoAttoPeer::doSelect($c);
    unset($c);
    
    return $directly_monitored_acts_types;
    
  }

  public static function merge($items1, $items2)
  {
    // merge directly and indirectly monitored acts types
    $items_pks = array_merge(Util::transformIntoPKs($items1), Util::transformIntoPKs($items2));
    return self::retrieveByPKs($items_pks);
  }
  
}
