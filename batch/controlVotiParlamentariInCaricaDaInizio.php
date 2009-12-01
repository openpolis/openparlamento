<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c=new Criteria();
$c->add(OppCaricaPeer::LEGISLATURA,16);
$c->add(OppCaricaPeer::TIPO_CARICA_ID,1);
$c->add(OppCaricaPeer::DATA_INIZIO,'2008-04-29');
$c->add(OppCaricaPeer::DATA_FINE,NULL,Criteria::EQUAL);
$deps=OppCaricaPeer::doSelect($c);

foreach ($deps as $dep)
{
  $c=new Criteria();
    $c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$dep->getId());
      //$c->add(OppVotazioneHasCaricaPeer::VOTO,'Votazione annullata',Criteria::NOT_EQUAL);
        $count=OppVotazioneHasCaricaPeer::doCount($c);
	  if ($count!=4825) echo $dep->getId()." ".$count."\n";
	  }
?>
