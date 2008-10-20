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
  
    $report = $carica->getReport();
  
    $presenze = $report['Astenuto'] + $report['Contrario'] + $report['Favorevole'] + $report['Partecipante votazione non valida'] + $report['Presidente di turno'] + $report['Richiedente la votazione e non votante'] + $report['Voto segreto'];
  
    $numero_votazioni = $report['Astenuto'] + $report['Contrario'] + $report['Favorevole'] + $report['Partecipante votazione non valida'] + 
	                  $report['Presidente di turno'] + $report['Richiedente la votazione e non votante'] + $report['Voto segreto'] +
					  $report['Assente'] + $report['In missione'];
							
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
	
	  $ribelle_count = $parlamentare->getRibelleReport($carica->getId(), ($report['carica']=='Deputato' ? 'C' : 'S'), $nome, $di, $df);
      
	  print $di.' / '.$df.' => '.$nome." ribellioni:".$ribelle_count."\n";
	}	
  
    //print "id carica:".$carica->getId()." presenze:".$presenze." assenze:".$report['Assente']." missioni:".$report['In missione']."\n";	   
    
	/*
    $carica->setPresenze($presenze);
    $carica->setAssenze($report['Assente']);
    $carica->setMissioni($report['In missione']);
    $carica->save();
    
    if($presenze!=0)
      printf("ribelle %d volte su %d voti\n", $ribelle_count, $presenze);
    else
      print("ribelle 0 volte su 0 voti (0%)\n");
    /* 
    $c = new Criteria();
    $c->add(OppCaricaHasGruppoPeer::CARICA_ID, $carica->getId(), Criteria::EQUAL);
    $c->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $gruppo['gruppo_id'], Criteria::EQUAL);
    $carica_gruppo = OppCaricaHasGruppoPeer::doSelectOne($c);
  
    $carica_gruppo->setRibelle($ribelle_count);
    $carica_gruppo->save();
	*/
  }	
  else
  print "identificativo carica non inserito";
  
print("done.\n");

?>