<?php

/*
Controlla le votazioni, e mette 1 al campo ìs_maggioranza_sotto nel caso nella votazione la maggioranza sia stata battuta.
in input:
- numero della legislatuta
- 1 manda sotto, 2 salva
- 0 tutte le votazioni, votazione_id per singola votazione
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c = new Criteria();
$c->add(OppCaricaPeer::LEGISLATURA, $argv[1]);
$c->add(OppCaricaPeer::TIPO_CARICA_ID, array(1,4), Criteria::IN);
$cariche=OppCaricaPeer::doSelect($c);
foreach($cariche as $carica)
{
  echo $carica->getId();
  for ($x=1; $x<=2;$x++)
  {
    $c = new Criteria();
    $c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$carica->getId());
    $c->add(OppVotazioneHasCaricaPeer::MAGGIORANZA_SOTTO_SALVA,$argv[2]);
    if ($x==2)
      $c->add(OppVotazioneHasCaricaPeer::VOTO,'Assente');
    if ($argv[3]!=0)
    {
      $c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID,$argv[3]);
    }  
    $cn = OppVotazioneHasCaricaPeer::doCount($c);
    if ($cn>0)
    {
      if ($argv[2]==1)
      {
        if ($x==1)
        {
          if ($argv[3]!=0)
            $carica->setMaggioranzaSotto($carica->getMaggioranzaSotto()+$cn);
          else
            $carica->setMaggioranzaSotto($cn);
        }
        else
        {
          if ($argv[3]!=0)
            $carica->setMaggioranzaSottoAssente($carica->getMaggioranzaSottoAssente()+$cn);
          else
            $carica->setMaggioranzaSottoAssente($cn);
        }
      }
        
      elseif ($argv[2]==2)
      {
        if ($x==1)
        {
          if ($argv[3]!=0)
            $carica->setMaggioranzaSalva($carica->getMaggioranzaSalva()+$cn);
          else
            $carica->setMaggioranzaSalva($cn);
        }
        else
        {
          if ($argv[3]!=0)
            $carica->setMaggioranzaSalvaAssente($carica->getMaggioranzaSottoAssente()+$cn);
          else
            $carica->setMaggioranzaSalvaAssente($cn);
        }
      }
      $carica->save();
    }
  }
}


?>