<?php

/**
 * Subclass for performing query and update operations on the 'opp_teseott' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppTeseottPeer extends BaseOppTeseottPeer
{
  
  /**
   * retrieve all the top terms names with the number of tags it contains
   *
   * @return associative array 
   *         (ID => ('denominazione' => DENOM, 'counter' => COUNT))
   * @author Guglielmo Celata
   */
  public static function getAllWithCount()
  {
    $c = new Criteria();
    $c->addSelectColumn(self::ID);
    $c->addSelectColumn(self::DENOMINAZIONE);
    $c->addSelectColumn('COUNT('.self::ID.') as counter');
    $c->addJoin(OppTagHasTtPeer::TESEOTT_ID, self::ID);
    $c->addGroupByColumn(self::ID);
    $c->addAscendingOrderByColumn(self::DENOMINAZIONE);
    
    if (Propel::VERSION >= '1.3')
    {
      $rs = self::doSelectStmt($c);

      while ($row = $rs->fetch(PDO::FETCH_NUM))
      {
        $tts[$row[0]] = array('denominazione' => $row[1], 'counter' => $row[2]);
      }
    }
    else
    {
      $rs = self::doSelectRS($c);

      while ($rs->next())
      {
        $tts[$rs->getInt(1)] = array('denominazione' => $rs->getString(2), 'counter' => $rs->getInt(3));
      }
    }

    return $tts;    
  }
  

  /**
   * conta il numero di tag sotto il term, monitorati da un utente (o da tutti gli utenti)
   *
   * @param string $term_id 
   * @param string $user_id - se null, torna il num. di tag monitorati da tutti gli utenti
   * @return void
   * @author Guglielmo Celata
   */
  public static function countTagsUnderTermMonitoredByUser($term_id, $user_id = null)
  {
    // fetch degli id dei tag sotto il term
    $c = new Criteria();
    $c->add(OppTagHasTtPeer::TESEOTT_ID, $term_id);
    $c->addJoin(OppTagHasTtPeer::TAG_ID, TagPeer::ID);
    $c->clearSelectColumns();
    $c->addSelectColumn(TagPeer::ID);
    $tags = array();
    $rs = TagPeer::doSelectRS($c);
    while ($rs->next())
    {
      $tags[]=$rs->getInt(1);
    }
    
    // conteggio dei tag
    $c = new Criteria();
    if (!is_null($user_id))
      $c->add(MonitoringPeer::USER_ID, $user_id);
    $c->add(MonitoringPeer::MONITORABLE_MODEL, 'Tag');
    $c->add(MonitoringPeer::MONITORABLE_ID, $tags, Criteria::IN);
    return MonitoringPeer::doCount($c);
  }
  
  
  public static function retrieveTagsFromTTPK($id)
  {
    $c = new Criteria();
    $c->add(OppTagHasTtPeer::TESEOTT_ID, $id);
    $c->addJoin(OppTagHasTtPeer::TAG_ID, TagPeer::ID);
    $c->addAscendingOrderByColumn(TagPeer::TRIPLE_VALUE);
    return TagPeer::doSelect($c);
  }

  
}
