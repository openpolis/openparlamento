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
  public $priority_override = 0;
  
  public function getRamoNumfase()
  {
    return $this->getRamo().".".$this->getNumfase();
  }
  
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
   * returns an array with all pred and succ
   * order criterion, by date
   *
   * @return OppAtto object
   * @author Ettore Di Cesare
   **/
   public function getAllPred()
   {
     $allPred=array();
     $atto=$this;
     $pred=$atto->getPred();
     
     while ($pred!='' && $pred!=NULL)
     {
       
        $c= new Criteria();
        $c->add(OppAttoPeer::ID,$atto->getId());
        $result=OppAttoPeer::doSelectOne($c);
        
        if ($result->getPred()!='' && $result->getPred()!=NULL)
        {
          $atto=OppAttoPeer::retrieveByPk($result->getPred());
          $pred=$atto->getId();
          $allPred[]=$atto;
        }
        else
          $pred='';
      }
     return array_reverse($allPred);
    }
    
    public function getAllSucc()
    { 
     
      $allSucc=array();
      $atto=$this;
      $succ=$atto->getSucc();

      while ($succ!='' && $succ!=NULL)
      {

        $c= new Criteria();
        $c->add(OppAttoPeer::ID,$atto->getId());
        $result=OppAttoPeer::doSelectOne($c);
        if ($result->getSucc()!='' && $result->getSucc()!=NULL)
        {
          $atto=OppAttoPeer::retrieveByPk($result->getSucc());
          $succ=$atto->getId();
          $allSucc[]=$atto;
        }
        else
          $succ='';
      }
      return $allSucc;
    }
   
  
  /**
   * torna il tipo di atto, per quello che concerne il calcolo dell'indice di attività
   *
   * @return string
   * @author Guglielmo Celata
   */
  public function getTipoPerIndice()
  {
    return OppTipoAttoPeer::getTipoPerIndice($this->getTipoAttoId());
  }
  
  
  /**
   * estrae tutte le firme fino a una certa data
   *
   * @param string $data 
   * @return array di OppCaricaHasAtto
   * @author Guglielmo Celata
   */
  public function getFirme($data)
  {
    return OppCaricaHasAttoPeer::getFirme($this->getId(), $data);
  }
  
  
  /**
   * estrae tutti gli iter di un atto fino a una certa data
   *
   * @param string $data 
   * @return array di OppIterHasAtto
   * @author Guglielmo Celata
   */
  public function getItinera($data)
  {
    return OppAttoHasIterPeer::getItinera($this->getId(), $data);
  }
  

  public function votatoDaOpposizione()
  {
    return OppAttoPeer::isAttoVotatoDaOpposizione($this->getId());
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
      return strtolower($iters[0]);
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
	//$c->addDescendingOrderByColumn(OppIterPeer::CONCLUSO);
	$c->addDescendingOrderByColumn(OppIterPeer::ID);
	//$c->setLimit(1);
	$rs = OppAttoHasIterPeer::doSelectRS($c);
	
	$count=0;
	while ($rs->next())
	{
	  if ($rs->getInt(2)==28 || $rs->getInt(2)==16 || $rs->getInt(2)==63 || $rs->getInt(2)==20 )
	  {
        
	    if($rs->get(1)!='0000-00-00')
	      $status[$rs->getDate(1, 'Y-m-d')] = $rs->getInt(2);
	    else
	      $status[1] = $rs->getInt(2);	
	      
	    break;
	   } 
	   else {
	     if ($count==0)
	     {
	       if($rs->get(1)!='0000-00-00')
	         $status[$rs->getDate(1, 'Y-m-d')] = $rs->getInt(2);
	       else
	         $status[1] = $rs->getInt(2);	
	         
	       $count=1;
	     }
	   }       
	      
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
    $c->addDescendingOrderByColumn(OppIterPeer::ID);
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
      $c->addSelectColumn(OppAttoPeer::TIPO_ATTO_ID);
      $c->add(OppAttoHasIterPeer::ATTO_ID, $quale_atto[$x], Criteria::EQUAL);
      $c->add(OppAttoPeer::ID, $quale_atto[$x], Criteria::EQUAL);
      $c->add(OppIterPeer::ID, array(11,12,13,14,15,16,17,18,19,20,21,22,25,65), Criteria::IN); 
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
  	    $rappresentazioni[$x][7] = $rs->getString(7);
      }

    }	
  
    return $rappresentazioni;
  }
  
  public function getIterLegge($quale_atto)
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
    $c->add(OppIterPeer::ID, array(16), Criteria::IN);
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

  /* --------- funzioni per indicizzazione sfLucene ---------- */

  public function getAttoId()
  {
    return $this->getId();
  }

  public function getTipoAtto()
  {
    $tipo_atto_id = $this->getTipoAttoId();
    if ($tipo_atto_id == 1) return 'disegni';
    if ($tipo_atto_id == 12) return 'decreti';
    if (in_array($tipo_atto_id, array(15, 16, 17))) return 'decrleg';
    if (in_array($tipo_atto_id, array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 14))) return 'nonleg';
    return 'errore';
  }
  
  public function getTitolo()
  {
    if ($this->getTitoloAggiuntivo() && $this->getTitoloAggiuntivo() != '')
     {
       if (parent::getTitolo()!=$this->getNumfase())
        return "[".$this->getTitoloAggiuntivo()."] ".parent::getTitolo();
       else   
        return "[".$this->getTitoloAggiuntivo()."]";
     }    
     else
      return parent::getTitolo();
      
  }
  
  public function getShortTitle()
  {
    return Text::denominazioneAttoShort($this);
  }
  
  public function getTitoloCompleto()
  {
    return Text::denominazioneAtto($this, 'list');
  }

  public function getDescrizioneWiki()
  {
    $prefix = sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_prefix', get_class($this)));
    $default_description = sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_default_description', 
                                         get_class($this)), 'Descrizione di default');
    $wiki_page = nahoWikiPagePeer::retrieveByName($prefix . "_" . $this->getId());
    if ($wiki_page)
    {
      $desc = $wiki_page->getRevision()->getContent();
      if ($desc != $default_description) return $desc;      
    }

    return null;
    
  }
  
  public function getHasDescrizioneWiki()
  {
    $prefix = sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_prefix', get_class($this)));
    $default_description = sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_default_description', 
                                         get_class($this)), 'Descrizione di default');
    
    $wiki_page = nahoWikiPagePeer::retrieveByName($prefix . "_" . $this->getId());
    if ($wiki_page)
    {
      $desc = $wiki_page->getRevision()->getContent();
      if ($desc != $default_description) return "true";      
    }

    return "false";
  }
  
  /**
   * get the available articoli for all the emendamenti of the atto
   *
   * @return array of String
   * @author Guglielmo Celata
   */
  public function getAvailableEmendamentiArticles()
  {
    return OppEmendamentoPeer::getAvailableArticles($this);
  }
  
  /**
   * get the available distinct sedi for all the emendamenti of the atto
   *
   * @return hash of type {id => site}
   * @author Guglielmo Celata
   */
  public function getAvailableEmendamentiSites()
  {
    return OppEmendamentoPeer::getAvailableSites($this);
  }


  /**
   * get the available distinct presentatori for all the emendamenti of the atto
   *
   * @return hash of type {id => presenter}
   * @author Guglielmo Celata
   */
  public function getAvailableEmendamentiPresenters()
  {
    return OppEmendamentoPeer::getAvailablePresenters($this);
  }
  
  /**
   * get the available distinct status for all the emendamenti of the atto
   *
   * @return hash of type {id => status}
   * @author Guglielmo Celata
   */
  public function getAvailableEmendamentiStatuses()
  {
    return OppEmendamentoPeer::getAvailableStatuses($this);
  }
  
  
  public function countPresentedEmendamentiAtDate($date = null)
  {
    if (is_null($date))
      $date = date('Y-m-d');
    return OppAttoHasEmendamentoPeer::countPresentedRelatedToAtDate($this->getId(), $date);
  }
  

  /**
   * delete all news related to this object before deleting the object
   *
   * @param string $con 
   * @return void
   * @author Guglielmo Celata
   */
  public function delete($con=null)
  {
    try
    {
      $c = new Criteria();
      $c->add(NewsPeer::RELATED_MONITORABLE_MODEL, 'OppAtto');
      $c->add(NewsPeer::RELATED_MONITORABLE_ID, $this->getPrimaryKey());
      NewsPeer::doDelete($c);          
    }
    catch (Exception $e)
    {
      throw new deppPropelActAsNewsGeneratorException(
        'Unable to delete related monitorable object records');
    }
    
    parent::delete($con);
  }

  /**
   * override per modificare la priorità dei comunicati di governo
   *
   * @param string $con 
   * @return void
   * @author Guglielmo Celata
   */
  public function save($con = null)
  {
    
    if ($this->getTipoAttoId() == 13)
    {
      $this->priority_override = 3;
    }
    
    $this->clearCacheOnUpdate();
    
    return parent::save();

  }

  /**
   * clear some cached stuff before the object is modified
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function clearCacheOnUpdate()
  {
    $cacheManager = sfContext::getInstance()->getViewCacheManager();
    if ($cacheManager)
    {
      switch ($this->getTipoAtto())
      {
        case 'disegni':
          $list = 'disegnoList';
          break;
        
        case 'decreti':
          $list = 'decretoList';
          break;
          
        case 'decrleg':
          $list = 'decretoLegislativoList';
          break;
          
        case 'nonleg':
          $list = 'attoNonLegislativoList';
          break;
      }
      
      $cacheManager->remove('atto/index?id='.$this->getId());
      $cacheManager->remove('atto/'.$list);
      $cacheManager->remove('community/index');
      $cacheManager->remove('default/index');
    }
    
  }
  
  
  /**
   * torna l'oggetto Apache_Solr_Document da indicizzare
   *
   * @return Apache_Solr_Document
   * @author Guglielmo Celata
   */
  public function intoSolrDocument()
  {
    $document = new Apache_Solr_Document();
    
    $id = $this->getId();
    $document->id = md5('OppAtto' . $id);
    $document->sfl_model = 'OppAtto';
    $document->sfl_type = 'model';

    $document->propel_id = $id;
    $document->tipo_atto_id = $this->getTipoAttoId();
    $document->tipo_atto_s = strtolower($this->getTipoAtto());
    $document->titolo = strtolower(strip_tags($this->getTitoloCompleto()));
    if ($this->getHasDescrizioneWiki() && $this->getDescrizioneWiki() != sfConfig::get('app_nahoWikiPlugin_default_description'))
    {
      $document->descrizioneWiki = strtolower(strip_tags($this->getDescrizioneWiki()));
      $document->hasDescrizioneWiki = true;      
    } else {
      $document->hasDescrizioneWiki = false;            
    }
    
    if ($this->getDataPres())
      $document->data_pres_dt = $this->getDataPres('%Y-%m-%dT%H:%M:%SZ');

    if ($this->getDataAgg())
      $document->data_agg_dt = $this->getDataAgg('%Y-%m-%dT%H:%M:%SZ');
    
    $document->created_at_dt = $this->getCreatedAt('%Y-%m-%dT%H:%M:%SZ');

    // ritorna il documento da aggiungere
    return $document;
  }

  // fast save excluding mixins
  public function fastSave($con = null)
  {
    $this->doSave($con);
  }
  
  
  
}



sfPropelBehavior::add('OppAtto', 
                      array('wikifiableBehavior' => 
                            array('prefix' => 'atto',
                                  'default_description' => "Inserire qui una descrizione dell'atto.",
                                  'default_user_comment' => 'Creazione iniziale')));

sfPropelBehavior::add(
  'OppAtto', 
  array('deppPropelActAsVotableBehavior' =>
        array('voting_range'    => 1,              
              'voting_field'    => 'VotoMedio',
              'voting_fields'   => array(1 => 'UtFav', -1 => 'UtContr'),
              'neutral_position'=> false,
              'anonymous_voting'=> false,
              'clear_cache_after_update' => true )));

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

sfPropelBehavior::add('OppAtto', array('deppPropelActAsLaunchableBehavior'));

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

sfSolrPropelBehavior::getInitializer()->setupModel('OppAtto');