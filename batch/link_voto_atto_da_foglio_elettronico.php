<?php

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();
$messaggio="link tra voti e atti da foglio google\n";
$rows=file("https://docs.google.com/spreadsheet/pub?key=0AiZ65N5BuOCtdE5xaDg3THR2WlpMdjNkelRQM241WFE&single=true&gid=0&output=csv");

foreach ($rows as $k=>$row)
{
  if ($k>0)
  {
    $valore=explode(",",$row);
    $votazione=OppVotazionePeer::retrieveByPk(trim($valore[3]));
    $atto=OppAttoPeer::retrieveByPk(trim($valore[4]));
    if ($atto && $votazione)
    {
      $c=new Criteria();
      $c->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, trim($valore[3]));
      $c->add(OppVotazioneHasAttoPeer::ATTO_ID, trim($valore[4]));
      $voto_atto=OppVotazioneHasAttoPeer::doSelectOne($c);
      if (!$voto_atto)
      {
        $ins=new OppVotazioneHasAtto();
        $ins->setVotazioneId(trim($valore[3]));
        $ins->setAttoId(trim($valore[4]));
        $ins->save();
        $messaggio=$messaggio. "INSERITO link votazione_id=".trim($valore[3])." e atto_id=".trim($valore[4])."\n";
      }
      else
        $messaggio=$messaggio. "link già presente tra votazione_id=".trim($valore[3])." e atto_id=".trim($valore[4])."\n";
    }
    else
      $messaggio=$messaggio. "!!!! NON TROVO o votazione_id=".trim($valore[3])." o atto_id=".trim($valore[4])."\n";
  }
}

echo $messaggio;

if (substr_count($messaggio, '!!')>0) 
  mail("e.dicesare@depp.it", "ERRORE - Votazioni/atto", $messaggio, "From: ScriptVotazioniCamera");
else
   mail("e.dicesare@depp.it", "OK - Votazioni/atto", $messaggio, "From: ScriptVotazioniCamera");
?>