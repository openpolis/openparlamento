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
        return 'approvata';
        break;
      case 'annu.':
        return 'annullata';
        break;
      case 'resp.':
        return 'respinta';
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
	      $ribelli1[$rs->getInt(1)] = array('id' =>$rs->getInt(1), 'gruppo' => $rs->getString(2), 'circoscrizione' => $rs->getString(3), 'voto' => $rs->getString(4));
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
  
    
}
?>