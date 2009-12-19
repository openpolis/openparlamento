<?php

/*
verifica tutti i voti dei gruppi nelle votazioni
Prende in input 
- il numero della legislatura
- il ramo (1 camera, 2 senato) - facoltativo
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c= new Criteria();
$c-> addJoin(OppSedutaPeer::ID,OppVotazionePeer::SEDUTA_ID);
$c-> add(OppSedutaPeer::LEGISLATURA,$argv[1]);
if ($argv[2]==1)
  $c-> add(OppSedutaPeer::RAMO,'C');
if ($argv[2]==2)
  $c-> add(OppSedutaPeer::RAMO,'S');
//$c->setLimit(1000);  
$votazioni = OppVotazionePeer::doSelect($c);

foreach($votazioni as $votazione)
{
  print "elaborazione votazione: " . $votazione->getId() . "...\n";
	
  $c = new Criteria();
  $c->add(OppLegislaturaHasGruppoPeer::LEGISLATURA, $argv[1], Criteria::EQUAL);
  $c->add(OppLegislaturaHasGruppoPeer::RAMO, $votazione->getOppSeduta()->getRamo(), Criteria::EQUAL);
  $gruppi_votazione = OppLegislaturaHasGruppoPeer::doSelect($c);
    
	foreach ($gruppi_votazione as $gruppo)
	{
	  $gr = OppGruppoPeer::retrieveByPk($gruppo->getGruppoId());	  
	  $voto_gruppo = OppVotazionePeer::doSelectVotoGruppo($votazione->getId(), $gr->getNome());	
	  
	  $c= new Criteria();
	  $c->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID,$votazione->getId());
	  $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID,$gr->getId());
	  $result=OppVotazioneHasGruppoPeer::doSelectOne($c);
	  if ($result)
	  {
	    $result->setVoto($voto_gruppo);
	    $result->save();
	    print $gr->getNome().": ".$voto_gruppo."\n";	  
	  } 
	  else 
	  {
	    $insert = new OppVotazioneHasGruppo;
	    $insert->setVotazioneId($votazione->getId());
	    $insert->setGruppoId($gr->getId());
	    $insert->setVoto($voto_gruppo);
	    $insert->save();
	    print "++++++++++++++++ ".$gr->getNome().": ".$voto_gruppo."\n";
	    
	  }
	}	
  
}


print("done.\n");

?>