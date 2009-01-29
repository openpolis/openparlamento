<?php

/**
 * Subclass for representing a row from the 'opp_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAtto extends BaseOppAtto
{
  protected $collIMTags;
  protected $lastIMTagsCriteria = null;
  
  
  public function countDirectlyMonitoringUsers()
  {
    return $this->countMonitoringUsers(true);
  }
  
  public function getDirectlyMonitoringUsersPKs()
  {
    return $this->getMonitoringUsersPKs();
  }

  public function countIndirectlyMonitoringUsers()
  {
    return 0;
  }
  
  public function getIndirectlyMonitoringUsersPKs()
  {
    return array();
  }
  
  public function countAllMonitoringUsers()
  {
    // return $this->countDirectlyMonitoringUsers() + $this->countIndirectlyMonitoringUsers();
    return count($this->getAllMonitoringUsersPKs()); // alternative and more precise
  }
  
  public function getAllMonitoringUsersPKs()
  {
    return array_merge($this->getDirectlyMonitoringUsersPKs(), $this->getIndirectlyMonitoringUsersPKs());
  }
  
  
  /**
   * returns an OppIter object, that is the last iter assigned to the object
   * order criterion, by date
   *
   * @return OppIter object
   * @author Guglielmo Celata
   **/
  public function getLastIter()
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(OppAttoHasIterPeer::DATA);
    $iters = $this->getOppAttoHasItersJoinOppIter($c);
    if (count($iters))
      return $iters[0];
    else
      return null;
  }
  
  /**
   * returns the Tags (TaggingsJoinTag) that makes the object indirectly monitored
   *
   * @return Tagging objects (with Tag infoz)
   * @author Guglielmo Celata
   **/
  public function getIndirectlyMonitoringTags($user_id, $criteria = null, $con = null)
	{
		include_once 'plugins/deppPropelActAsTaggableBehaviorPlugin/lib/model/om/BaseTaggingPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collIMTags === null) {
			if ($this->isNew()) {
				$this->collIMTags = array();
			} else {
				$criteria->addJoin(TaggingPeer::TAG_ID, TagPeer::ID);
				$criteria->addJoin(MonitoringPeer::MONITORABLE_ID, TagPeer::ID);
  			$criteria->add(TaggingPeer::TAGGABLE_ID, $this->getId());
				$criteria->add(MonitoringPeer::USER_ID, $user_id);
				$this->collIMTags = TagPeer::doSelect($criteria, $con);
			}
		} else {
			$criteria->addJoin(TaggingPeer::TAG_ID, TagPeer::ID);
			$criteria->addJoin(MonitoringPeer::MONITORABLE_ID, TagPeer::ID);
			$criteria->add(TaggingPeer::TAGGABLE_ID, $this->getId());
			$criteria->add(MonitoringPeer::USER_ID, $user_id);

			if (!isset($this->lastIMTagsCriteria) || !$this->lastIMTagsCriteria->equals($criteria)) {
				$this->collIMTags = TagPeer::doSelect($criteria, $con);
			}
		}
		$this->lastIMTagsCriteria = $criteria;

		return $this->collIMTags;
	}
	
  
  public function getStatus()
  {
    $status = array();
	
    $c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppAttoHasIterPeer::DATA);
	$c->addSelectColumn(OppIterPeer::ID);
	$c->add(OppAttoHasIterPeer::ATTO_ID, $this->getId(), Criteria::EQUAL);
	$c->addJoin(OppAttoHasIterPeer::ITER_ID, OppIterPeer::ID, Criteria::LEFT_JOIN);
	$c->addDescendingOrderByColumn(OppAttoHasIterPeer::DATA);
	$c->addDescendingOrderByColumn(OppIterPeer::CONCLUSO);
	$c->setLimit(1);
	$rs = OppAttoHasIterPeer::doSelectRS($c);
	
	while ($rs->next())
    {
	  if($rs->get(1)!='0000-00-00')
	    $status[$rs->getDate(1, 'Y-m-d')] = $rs->getInt(2);
	  else
	    $status[1] = $rs->getInt(2);	
	}  
  
    return $status;
  }
  
  public function getIterCompleto()
  {
    $iter = array();

    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(OppAttoHasIterPeer::DATA);
    $c->addSelectColumn(OppIterPeer::FASE);
    $c->add(OppAttoHasIterPeer::ATTO_ID, $this->getId(), Criteria::EQUAL);
    $c->addJoin(OppAttoHasIterPeer::ITER_ID, OppIterPeer::ID, Criteria::LEFT_JOIN);
    $c->addDescendingOrderByColumn(OppAttoHasIterPeer::DATA);
    $c->addDescendingOrderByColumn(OppIterPeer::CONCLUSO);
	$c->setOffset(1);
    $rs = OppAttoHasIterPeer::doSelectRS($c);
	
	while ($rs->next())
    {
	  if($rs->get(1)!='0000-00-00')
	    $iter[$rs->getString(2)] = $rs->getDate(1, 'Y-m-d');
      else
	    $iter[1] = $rs->getString(2);			
	}  
  
    return $iter;
  }
  
   public function getIterRappresentazioni($quale_atto)
  {
    $rappresentazioni = array();
    for ($x=0;$x<count($quale_atto);$x++) {
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(OppAttoHasIterPeer::DATA);
    $c->addSelectColumn(OppIterPeer::FASE);
    $c->addSelectColumn(OppAttoPeer::RAMO);
    $c->addSelectColumn(OppAttoPeer::NUMFASE);
    $c->addSelectColumn(OppAttoPeer::ID);
    $c->addSelectColumn(OppAttoPeer::DATA_PRES);
    $c->add(OppAttoHasIterPeer::ATTO_ID, $quale_atto[$x], Criteria::EQUAL);
    $c->add(OppAttoPeer::ID, $quale_atto[$x], Criteria::EQUAL);
    $c->add(OppIterPeer::ID, array(11,12,13,14,16,17,18,19,20,21,22,25), Criteria::IN);
    $c->addJoin(OppAttoHasIterPeer::ITER_ID, OppIterPeer::ID, Criteria::LEFT_JOIN);
    $c->addDescendingOrderByColumn(OppAttoHasIterPeer::DATA);
    $c->setLimit(1);
    $rs = OppAttoHasIterPeer::doSelectRS($c);
	
	while ($rs->next())
    {
	 
	    $rappresentazioni[$x][1] = $rs->getDate(1, 'Y-m-d');
	    $rappresentazioni[$x][2] = $rs->getString(2);
	    $rappresentazioni[$x][3] = $rs->getString(3);
	    $rappresentazioni[$x][4] = $rs->getString(4);
	    $rappresentazioni[$x][5] = $rs->getString(5);
	    $rappresentazioni[$x][6] = $rs->getString(6);
  
    }
    
    }	
  
    return $rappresentazioni;
  }
  
  
  public function getIdVotazioni()
  {
    $ids = array();
	
	$c = new Criteria();
	$c->clearSelectColumns();
        $c->addSelectColumn(OppVotazioneHasAttoPeer::VOTAZIONE_ID);
	$c->add(OppVotazioneHasAttoPeer::ATTO_ID, $this->getId(), Criteria::EQUAL);
	$rs = OppVotazioneHasAttoPeer::doSelectRS($c);
    
	while ($rs->next())
    {
	  array_push($ids, $rs->getInt(1));
	}
	
	return $ids;
  }
  
  public function getInterventi()
  {
    $interventi = array();
	
	$c = new Criteria();
    $c->clearSelectColumns();
    //$c->addAsColumn('ID_INTERVENTO', OppInterventoPeer::ID);
	$c->addSelectColumn(OppInterventoPeer::ID);
	$c->addSelectColumn(OppPoliticoPeer::ID);
	$c->addSelectColumn(OppPoliticoPeer::NOME);
	$c->addSelectColumn(OppPoliticoPeer::COGNOME);
	$c->addSelectColumn(OppInterventoPeer::DATA);
    $c->addSelectColumn(OppInterventoPeer::TIPOLOGIA);
	$c->addSelectColumn(OppInterventoPeer::URL);
	$c->addSelectColumn(OppSedePeer::RAMO);
	$c->addSelectColumn(OppsedePeer::DENOMINAZIONE);
	$c->addJoin(OppInterventoPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::LEFT_JOIN);
	$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::LEFT_JOIN);
	$c->addJoin(OppInterventoPeer::SEDE_ID, OppSedePeer::ID, Criteria::LEFT_JOIN);	
    $c->add(OppInterventoPeer::ATTO_ID, $this->getId(), Criteria::EQUAL);
    $c->addDescendingOrderByColumn(OppInterventoPeer::DATA);
	$c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);   
	$rs = OppInterventoPeer::doSelectRS($c);
	
	while ($rs->next())
    {
      $interventi[$rs->getInt(1)] = array('politico_id' => $rs->getInt(2), 'nome' => $rs->getString(3), 'cognome' => $rs->getString(4), 'data' => $rs->getDate(5, 'Y-m-d'), 'tipo' => $rs->getString(6), 'link' => $rs->getString(7), 'ramo' => $rs->getString(8), 'denominazione' => $rs->getString(9) );  	
	}
	
	return $interventi;
  
  }
  
  public function getInterventiCount()
  {
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(OppInterventoPeer::ID);
    $c->addJoin(OppInterventoPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::LEFT_JOIN);
	  $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::LEFT_JOIN);
	  $c->addJoin(OppInterventoPeer::SEDE_ID, OppSedePeer::ID, Criteria::LEFT_JOIN);	
    $c->add(OppInterventoPeer::ATTO_ID, $this->getId(), Criteria::EQUAL);
    $c->addDescendingOrderByColumn(OppInterventoPeer::DATA);
	  $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);   
	  $count = OppInterventoPeer::doCount($c);
			
	  return $count;
  }
  
  public function getCommissioni()
  {
    $sedi = array();
	
	$c = new Criteria();
	$c->add(OppAttoPeer::ID, $this->getId(), Criteria::EQUAL);
	$c->addJoin(OppAttoPeer::ID, OppAttoHasSedePeer::ATTO_ID);
	$c->addDescendingOrderByColumn('tipo');
	return OppAttoHasSedePeer::doSelectJoinOppSede($c);
  }

}



sfPropelBehavior::add('OppAtto', 
                      array('wikifiableBehavior' => 
                            array('prefix' => 'atto')));

sfPropelBehavior::add(
  'OppAtto', 
  array('deppPropelActAsVotableBehavior' =>
        array('voting_range'    => 1,              
              'voting_field'    => 'VotoMedio',
              'voting_fields'   => array(1 => 'UtFav', -1 => 'UtContr'),
              'neutral_position'=> false,
              'anonymous_voting'=> false )));

sfPropelBehavior::add(
  'OppAtto', 
  array('deppPropelActAsTaggableBehavior' => array()));

sfPropelBehavior::add(
  'OppAtto', 
  array('deppPropelActAsCommentableBehavior' =>
        array('count_cache_enabled'   => true,
              'count_cache_method'    => 'setNbCommenti')));


sfPropelBehavior::add(
  'OppAtto', 
  array('deppPropelActAsBookmarkableBehavior' => array()));

// add the ActAsMonitorable behavior
// the field OppUserPeer::N_MONITORED_ATTOS of objects of this type monitored
sfPropelBehavior::add(
  'OppAtto', 
  array('deppPropelActAsMonitorableBehavior' =>
        array('count_monitoring_users_field'  => 'NMonitoringUsers',  // refers to ArticlePeer::N_MONITORING_USERS
              'monitorer_model'               => 'OppUser',           // user profile model (to set the cache)
              'count_monitored_objects_field' => 'NMonitoredAttos',   // refers to OppUserPeer::N_MONITORED_ATTOS
       )));

sfPropelBehavior::add(
  'OppAtto',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'self'),
              'date_method'        => 'DataPres',
              'priority'           => '1',
        )));
