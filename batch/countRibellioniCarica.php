<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n\n");

$c = new Criteria();
$c->add(OppCaricaPeer::ID, $argv[1], Criteria::EQUAL);
$carica = OppCaricaPeer::doSelectOne($c);

if($carica)
  {  
    $parlamentare = OppPoliticoPeer::RetrieveByPk($carica->getPoliticoId());
  
    $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($carica->getId());
  
    foreach($gruppi as $nome => $gruppo)
    {
  	  $data_inizio=split("/", $gruppo['data_inizio']);
	  $di = "20".$data_inizio[2]."-".$data_inizio[0]."-".$data_inizio[1];
	
	  if($gruppo['data_fine']!='')
	  {
	    $data_fine=split("/", $gruppo['data_fine']);
	    $df = "20".$data_fine[2]."-".$data_fine[0]."-".$data_fine[1];
	  }
	  else
	    $df='';
	
	  //$ribelle_count = $parlamentare->getRibelleReport($carica->getId(), ($report['carica']=='Deputato' ? 'C' : 'S'), $nome, $di, $df);
      
	  //CALCOLO VOTO GRUPPO
	  $c = new Criteria();
	  $c->clearSelectColumns();
	  $c->addSelectColumn(OppVotazioneHasGruppoPeer::VOTAZIONE_ID);
	  $c->addSelectColumn(OppVotazioneHasGruppoPeer::VOTO);
	  $c->addJoin(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, OppVotazionePeer::ID, Criteria::LEFT_JOIN);
	  $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID, Criteria::LEFT_JOIN);
	  $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $gruppo['gruppo_id'], Criteria::EQUAL);
      
	  if($df!='') 
	  {  
		$cton1 = $c->getNewCriterion(OppSedutaPeer::DATA, $di, Criteria::GREATER_EQUAL);
	    $cton2 = $c->getNewCriterion(OppSedutaPeer::DATA, $df, Criteria::LESS_EQUAL);
        $cton1->addAnd($cton2);
        $c->add($cton1);
	  }
	  else
	    $c->add(OppSedutaPeer::DATA, $di, Criteria::GREATER_EQUAL);
     	  
	  $rs = OppVotazioneHasGruppoPeer::doSelectRS($c);
	  
	  $voto_gruppo = array();
	  
	  while ($rs->next())
      {
	    $voto_gruppo[$rs->getInt(1)] = $rs->getString(2);  
	  }
	  
	  //CALCOLO VOTO CARICA
	  $c = new Criteria();
	  $c->clearSelectColumns();
	  $c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTAZIONE_ID);
	  $c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
	  $c->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, OppVotazionePeer::ID, Criteria::LEFT_JOIN);
	  $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID, Criteria::LEFT_JOIN);
	  $c->add(OppVotazioneHasCaricaPeer::CARICA_ID, $argv[1], Criteria::EQUAL);
      if($df!='') 
	  {  
		$cton1 = $c->getNewCriterion(OppSedutaPeer::DATA, $di, Criteria::GREATER_EQUAL);
	    $cton2 = $c->getNewCriterion(OppSedutaPeer::DATA, $df, Criteria::LESS_EQUAL);
        $cton1->addAnd($cton2);
        $c->add($cton1);
	  }
	  else
	    $c->add(OppSedutaPeer::DATA, $di, Criteria::GREATER_EQUAL);
	  
	  $rs = OppVotazioneHasCaricaPeer::doSelectRS($c);
	  
	  $voto_carica = array();
	  
	  while ($rs->next())
      {
	    $voto_carica[$rs->getInt(1)] = $rs->getString(2);  
	  }
	  
	  $cont = 0;
	  
	  foreach ($voto_gruppo as $indice => $voto)
	  {
	    if(isset($voto_carica[$indice]) 
		   && ($voto=='Favorevole' || $voto=='Astenuto' || $voto=='Contrario' ) 
		   && $voto!=$voto_carica[$indice])
		{  
		  if($voto_carica[$indice]=='Favorevole' || $voto_carica[$indice]=='Astenuto' || $voto_carica[$indice]=='Contrario')
		  {
		    $cont = $cont+1;
		    echo "votazione: ".$indice." voto gruppo: ".$voto." voto carica: ".$voto_carica[$indice]."\n";
		  }
		}  
	  }
	  /*
	  $c = new Criteria();
	  $c->add(OppCaricaHasGruppoPeer::CARICA_ID, $argv[1], Criteria::EQUAL);
	  $c->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $gruppo['gruppo_id'], Criteria::EQUAL);
	  $carica = OppCaricaHasGruppoPeer::doSelectOne($c);
	  
	  $carica->setRibelle($cont);
	  $carica->save();
	  */
	  print $di.' / '.$df.' => '.$nome." (id: ".$gruppo['gruppo_id'].") ribellioni:".$cont."\n";
	}	
     
  }	
  else
  print "identificativo carica non inserito";
  
print("done.\n");

?>