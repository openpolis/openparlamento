<?php

/**
 * Subclass for representing a row from the 'opp_votazione' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppVotazione extends BaseOppVotazione
{
  public function countAssentiRibelliOpposizioneVotazioneMaggioranzaSalvata($assente)
  {
    return OppVotazioneHasCaricaPeer::countAssentiRibelliOpposizioneVotazioneMaggioranzaSalvata($this->getId(), $assente);
  }
  
  public function countAssentiMaggioranza($data = null)
  {
    if (is_null($data)) {
      $data = $this->getOppSeduta()->getData('Y-m-d');
    }
    
    return OppVotazioneHasCaricaPeer::countAssentiMaggioranzaVotazione($this->getId(), $data);
  }

  public function countRibelliMaggioranza($data = null)
  {
    if (is_null($data)) {
      $data = $this >getOppSeduta()->getData('Y-m-d');
    }

    return OppVotazioneHasCaricaPeer::countRibelliMaggioranzaVotazione($this->getId(), $data);
  }

  
  public function getTitolo()
  {
    
    if ($this->getTitoloAggiuntivo() && $this->getTitoloAggiuntivo() != '')
    {
        return "[".$this->getTitoloAggiuntivo()."] " . parent::getTitolo();
    }    
    else
    {
      $c= new Criteria();
      $c->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID,$this->getId());
      $r=OppVotazioneHasAttoPeer::doSelectOne($c);
      if ($r)
      {
        if ($r->getOppAtto()->getTitoloAggiuntivo() && $r->getOppAtto()->getTitoloAggiuntivo() != '')
          return  $r->getOppAtto()->getTitoloAggiuntivo()." - <strong>".parent::getTitolo()."</strong>";
        else
          return  $r->getOppAtto()->getTitolo()." - <strong>".parent::getTitolo()."</strong>";
      }
      else
        return parent::getTitolo(); 
    }    
  }
  
  
  public function getShortTitle()
  {
    return $this->getTitolo();
  }
  
  public function getEsito()
  {
    switch(strtolower($this->esito))
    {
      case 'appr.':
        return 'APPROVATA';
        break;
      case 'annu.':
        return 'ANNULLATA';
        break;
      case 'resp.':
        return 'RESPINTA';
        break;
      default:
        return $this->esito;
    }  
  }
  
  public function getRibelliCount()
  {

    $risultati = OppVotazioneHasCaricaPeer::doSelectGroupByGruppo($this->getId());
    
	$n = 0;
	
    foreach ($risultati as $gruppo=>$risultato)
    {
      if($gruppo!='Gruppo Misto')
	  {
	    $c = new Criteria();
  	    $c->add(OppGruppoPeer::NOME, $gruppo);
  	    $gruppo_id = OppGruppoPeer::doSelectOne($c);
  	     
  	    $c = new Criteria();
  	    $c->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $this->getId());
  	    $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $gruppo_id->getId());
            $voto_gruppo = OppVotazioneHasGruppoPeer::doSelectOne($c);
            
            if ($voto_gruppo) { 
              if ($voto_gruppo->getVoto()!='nv')
                {
	        unset($risultato['Assente']);
	        unset($risultato['In missione']);
	        arsort($risultato);
	        array_shift($risultato);
	        $n+=array_sum($risultato);
	       }
	     }  
	   
	  }   
    }
    return $n;
  }
  
  public function getRibelliList($voto_gruppi = null)
  {

    if (is_null($voto_gruppi)) {
      $voto_gruppi = OppVotazioneHasCaricaPeer::doSelectGroupByGruppo($this->getId());
    }
    
  	$ribelli_id = array(); 
  	$ribelli = array();
	
    foreach ($voto_gruppi as $gruppo => $risultato)
    {
       
      if ($gruppo != 'Gruppo Misto')
  	  {
  	    $c = new Criteria();
  	    $c->add(OppGruppoPeer::NOME, $gruppo);
  	    $gruppo_id = $risultato['id'];
  	      
  	    $c = new Criteria();
  	    $c->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $this->getId());
  	    $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $gruppo_id);
        $voto_gruppo = OppVotazioneHasGruppoPeer::doSelectOne($c); 
        if ($voto_gruppo)
        {
          if ($voto_gruppo->getVoto()!='nv')
          {
    
    	      unset($risultato['Assente']);
    	      unset($risultato['In missione']);
    	      arsort($risultato);
    	      array_shift($risultato);
	  	  
    	      $c = new Criteria();
    	      $c->clearSelectColumns();
    	      $c->addSelectColumn(OppCaricaPeer::POLITICO_ID);
    	      $c->addSelectColumn(OppGruppoPeer::NOME);
    	      $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
    	      $c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
    	      $c->addJoin(OppCaricaPeer::ID, OppVotazioneHasCaricaPeer::CARICA_ID, Criteria::LEFT_JOIN);
    		    $c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::LEFT_JOIN);
    	      $c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::LEFT_JOIN);
    		    $c->add(OppGruppoPeer::NOME, $gruppo, Criteria::EQUAL);
    	      $c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $this->getId(), Criteria::EQUAL);
    	      $c->add(OppVotazioneHasCaricaPeer::VOTO, array_keys($risultato), Criteria::IN);
  	    
		
            $c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $this->getOppSeduta()->getData(), Criteria::LESS_EQUAL);
    	      $cton1 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, $this->getOppSeduta()->getData(), Criteria::GREATER_EQUAL);
    	      $cton2 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);
            $cton1->addOr($cton2);
            $c->add($cton1);
	
  	        $rs = OppCaricaPeer::doSelectRS($c);
	  
  	        while ($rs->next())
            {
         
              $ribelli1[$rs->getInt(1)] = array('id' =>$rs->getInt(1), 
                                      'gruppo' => $rs->getString(2), 
                                      'circoscrizione' => $rs->getString(3), 
                                      'voto_gruppo' => $voto_gruppo->getVoto(),
                                      'voto' => $rs->getString(4));
  	          array_push($ribelli_id, $rs->getInt(1));
  	      
            }
          }
        }    
  	  }	   
	  
    }
	
  	$c = new Criteria();
  	$c->add(OppPoliticoPeer::ID, $ribelli_id, Criteria::IN);
  	$c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
  	$rs1 = OppPoliticoPeer::doSelectRS($c);
	
  	while ($rs1->next())
    {
  	  $ribelli[$rs1->getString(3).' '.$rs1->getString(2)] = $ribelli1[$rs1->getInt(1)];   
  	}
	
    return $ribelli;
  }

  /**
   * torna array contenente il dettaglio del comportamento dei gruppi
   * - Gruppo Misto
   *   - Favorevole  => N
   *   - Contrario   => N
   *   - Astenuto    => N
   *   - Assente     => N
   *   - In missione => N
   *
   * @return complex hash
   * @author Guglielmo Celata
   */
  public function getVotoGruppi($data)
  {
    if (is_null($data)) {
      $data = $this >getOppSeduta()->getData('Y-m-d');
    }
    
    return OppVotazioneHasCaricaPeer::doSelectGroupByGruppo($this->getId(), $data);
  }

  public function getVotoRibelli($data = null)
  {
    if (is_null($data)) {
      $data = $this >getOppSeduta()->getData('Y-m-d');
    }
    
    return OppVotazioneHasCaricaPeer::getVotoRibelli($this->getId(), $data);
  }
  
  public function getVotoParlamentari($data = null)
  {
    if (is_null($data)) {
      $data = $this >getOppSeduta()->getData('Y-m-d');
    }
    return OppVotazioneHasCaricaPeer::getVotoParlamentari($this->getId(), $data);
  }


  /**
   * ritorna il voto (stringa) del gruppo passato come parametro
   * 
   *
   * @param string $gruppo_id 
   * @return string - voto del gruppo o null se 0 voti o più di un voto
   * @author Guglielmo Celata
   */
  public function getVotoGruppo($gruppo_id)
  {
    $c = new Criteria();
    $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $gruppo_id);
    $voti_gruppo = $this->getOppVotazioneHasGruppos($c);
    if (count($voti_gruppo) == 1) return $voti_gruppo[0]->getVoto();
    else return null;
  }
  

  /* --------- funzioni per indicizzazione sfLucene ---------- */
  
  public function getVotoId()
  {
    return $this->getId();
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

  public function isIndexable()
  {
    return true;
  }


  /**
   * override per svuotare la cache
   *
   * @param string $con 
   * @return void
   * @author Guglielmo Celata
   */
  public function save($con = null)
  {
    
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
      $cacheManager->remove('votazione/index?id='.$this->getId());
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
    $document->id = md5('OppVotazione' . $id);
    $document->sfl_model = 'OppVotazione';
    $document->sfl_type = 'model';

    $document->propel_id = $id;
    $document->titolo = strtolower(strip_tags($this->getTitolo()));
    $document->hasDescrizioneWiki = $this->getHasDescrizioneWiki();
    if ($this->getHasDescrizioneWiki() && $this->getDescrizioneWiki() != sfConfig::get('app_nahoWikiPlugin_default_description'))
    {
      $document->descrizioneWiki = strtolower(strip_tags($this->getDescrizioneWiki()));
      $document->hasDescrizioneWiki = true;      
    } else {
      $document->hasDescrizioneWiki = false;            
    }

    if ($this->getOppSeduta()->getData())
      $document->data_pres_dt = $this->getOppSeduta()->getData('%Y-%m-%dT%H:%M:%SZ');

    // ritorna il documento da aggiungere
    return $document;
  }


  public function getSlug()
  {
      return Util::slugify($this->getTitolo());
  }

	/**
	 *
	 * @author Daniele Faraglia
	 * @return string parametri per completare l'url della route
	 */
	public function getUrlParams()
	{
		$str = 'id='. $this->getId();
		$str .= '&slug='.$this->getSlug();
		$str .= '&ramo='. ( $this->getOppSeduta()->getRamo() == 'C' ? 'camera' : 'senato');
		return $str;
	}
 
    
}


sfPropelBehavior::add(
  'OppVotazione', 
  array('deppPropelActAsVotableBehavior' =>
        array('voting_range'    => 1,              
              'voting_fields'   => array(1 => 'UtFav', -1 => 'UtContr'),
              'neutral_position'=> false,
              'anonymous_voting'=> false,
              'clear_cache_after_update' => true )));

sfPropelBehavior::add('OppVotazione', 
                      array('wikifiableBehavior' => 
                            array('prefix' => 'votazione',
                                  'default_description' => "Inserire qui una descrizione della votazione.",
                                  'default_user_comment' => 'Creazione iniziale')));

sfPropelBehavior::add('OppVotazione', array('deppPropelActAsTaggableBehavior'));
sfPropelBehavior::add('OppVotazione', array('deppPropelActAsCommentableBehavior'));
sfPropelBehavior::add('OppVotazione', array('deppPropelActAsLaunchableBehavior'));

sfSolrPropelBehavior::getInitializer()->setupModel('OppVotazione');
