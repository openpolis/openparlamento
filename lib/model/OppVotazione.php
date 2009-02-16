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
  
  public function getTitolo()
  {
    return str_replace( ';NULL', '', preg_replace("<a([^\'\n]+)\/a>",'${2}',$this->titolo) );
  
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
	    unset($risultato['Assente']);
	    unset($risultato['In missione']);
	    arsort($risultato);
	    array_shift($risultato);
	    $n+=array_sum($risultato);
	  }
    }
    return $n;
  }
  
  public function getRibelliList()
  {

    $risultati = OppVotazioneHasCaricaPeer::doSelectGroupByGruppo($this->getId());
    
  	$ribelli_id = array(); 
  	$ribelli = array();
	
    foreach ($risultati as $gruppo => $risultato)
    {
      if($gruppo!='Gruppo Misto')
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
                                          'voto' => $rs->getString(4));
  	      array_push($ribelli_id, $rs->getInt(1));
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
    
}

sfPropelBehavior::add('OppVotazione', 
                      array('wikifiableBehavior' => 
                            array('prefix' => 'votazione',
                                  'default_description' => "Inserire qui una descrizione della votazione.",
                                  'default_user_comment' => 'Creazione iniziale')));

sfPropelBehavior::add('OppVotazione', array('deppPropelActAsTaggableBehavior'));
sfPropelBehavior::add('OppVotazione', array('deppPropelActAsCommentableBehavior'));

sfLucenePropelBehavior::getInitializer()->setupModel('OppVotazione');