<?php

/*
Controlla le votazioni, e mette 2 al campo ìs_maggioranza_sotto nel caso nella votazione la maggioranza sia stata battuta.
in input:
- numero della legislatuta
- 0 ctrl tutte le votazioni, id_votazione ctrl solo una votazione 
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$votazioni=OppVotazionePeer::maggioranzaSalva($argv[1],$argv[2]);

if (count($votazioni)>0)
{
  foreach($votazioni as $v)
  {
    //if (OppVotazionePeer::isMaggioranzaUnitaSuVotazione($v->getId()))
    //{
      $v->setIsMaggioranzaSottoSalva(2);
      $v->save();
    //}
  }
}
mail("ettore@depp.it", "UP MAGG. SALVA", $avviso, "From: 1_lista_ddl_new");
?>