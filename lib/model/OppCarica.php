<?php

/**
 * Subclass for representing a row from the 'opp_carica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCarica extends BaseOppCarica
{
  /**
   * estrae i politici più vicini per voti o firma
   *
   *
   * @param string $group_acro - acronimo del gruppo del politico
   * @param string $similarity_type - voting | signing
   * @return array di politici; per ogni politico:
   *          id, nome e cognome, gruppo, similarita'
   * @author Guglielmo Celata
   */
  public function getNearestVoters($similarity_type, $group_acro)
  {
    if ($similarity_type == 'voting') $similarity_field = OppSimilaritaPeer::VOTING_SIMILARITY;
    elseif ($similarity_type == 'signing') $similarity_field = OppSimilaritaPeer::SIGNING_SIMILARITY;
    else throw new Exception("Il parametro type può valere 'voting' o 'signing'.");
    
    $c = new Criteria();
    $c->add(OppSimilaritaPeer::CARICA_FROM_ID, $this->getId());
    $c->addJoin(OppSimilaritaPeer::CARICA_TO_ID, OppCaricaPeer::ID);
    $c->addJoin(OppPoliticoPeer::ID, OppCaricaPeer::POLITICO_ID);
    $c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID);
    $c->addJoin(OppGruppoPeer::ID, OppCaricaHasGruppoPeer::GRUPPO_ID);
    $c->add(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);

    $c->clearSelectColumns();
    $c->addSelectColumn(OppPoliticoPeer::ID);
    $c->addSelectColumn(OppPoliticoPeer::NOME);
    $c->addSelectColumn(OppPoliticoPeer::COGNOME);
    $c->addSelectColumn(OppGruppoPeer::ACRONIMO);
    $c->addSelectColumn($similarity_field);
    $c->addDescendingOrderByColumn($similarity_field);
    
    $politici = array();
    $rs = OppCaricaPeer::doSelectRS($c);
    $i = 0;
    $samegroup = 0;
    $othergroup = 0;
    while($rs->next())
    { 
      $i++;
      $politico = array();
      $politico['id'] = $rs->getInt(1);
      $politico['nomecognome'] = $rs->getString(2) . " " . strtoupper($rs->getString(3));
      $politico['gruppo'] = $rs->getString(4);
      $politico['similarita'] = $rs->getFloat(5);
      $politico['samegroup'] = ($group_acro == $politico['gruppo']);
      
      if ($politico['samegroup'])
        $samegroup++;
      else
        $othergroup++;
      
      if ($i > 10 && $politico['samegroup'] && $samegroup > 5 ) continue;
      if ($i > 10 && !$politico['samegroup'] && $othergroup > 5 ) continue;
      $politici[$i] = $politico;
      
    }
    return $politici;
  }
  
  
  public function getReport()
  {
    $risultato = array('Assente' => 0, 'Astenuto' => 0, 'Contrario' => 0, 'Favorevole' => 0, 'In missione' => 0, 
					   'Partecipante votazione non valida' => 0, 'Presidente di turno' => 0, 'Richiedente la votazione e non votante' => 0, 
					   'Voto segreto' => 0);
	
  	$c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppCaricaPeer::ID);
  	$c->addSelectColumn(OppCaricaPeer::DATA_INIZIO);
  	$c->addSelectColumn(OppCaricaPeer::DATA_FINE);
  	$c->addSelectColumn(OppCaricaPeer::CARICA);
  	$c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
  	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->addAsColumn('CONT', 'COUNT(*)');
  	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::LEFT_JOIN);
  	$c->addGroupByColumn(OppCaricaPeer::ID);
  	$c->addGroupByColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->add(OppCaricaPeer::ID, $this->getId(), Criteria::EQUAL);
  	$c->addDescendingOrderByColumn(OppCaricaPeer::DATA_INIZIO);
  	$c->addDescendingOrderByColumn(OppCaricaPeer::DATA_FINE);
  	$rs = OppCaricaPeer::doSelectRS($c);  
	
  	while ($rs->next())
      {
  	  if(!isset($risultato['carica']))
  	  {
  	    $risultato['carica'] = $rs->getString(4);  
  	  } 
  	  $risultato[$rs->getString(6)] = $rs->getInt(7);
  	}
	
  	return $risultato;
    
  }

  /**
   * torna gli atti firmati dal politico, come array di id
   *
   * @param string $criteria 
   * @param string $con 
   * @return void
   * @author Guglielmo Celata
   */
	public function getOppCaricaHasAttosPKs($criteria = null, $con = null)
	{
	  $oppCaricaHasAttosPKs = array();
	  if (!$this->isNew())
    {
  		if ($criteria === null) {
  			$criteria = new Criteria();
  		}
  		elseif ($criteria instanceof Criteria)
  		{
  			$criteria = clone $criteria;
  		}

  		$criteria->add(OppCaricaHasAttoPeer::CARICA_ID, $this->getId());
  		$criteria->clearSelectColumns();
  		$criteria->addSelectColumn(OppCaricaHasAttoPeer::ATTO_ID);
  	  $rs = OppCaricaHasAttoPeer::doSelectRS($criteria, $con);      
  	  while ($rs->next())
  	  {
  	    $oppCaricaHasAttosPKs []= $rs->getInt(1);
  	  }
    }
    
    return $oppCaricaHasAttosPKs;
	}

}

sfPropelBehavior::add(
  'OppCarica',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppPolitico' => 'getOppPolitico'),
              'date_method'        => 'DataInizio',
              'priority'           => '1',
        )));
