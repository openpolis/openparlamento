<?php

/*
verifica l'esattezza del numero delle firme nei ddl di ogni singolo parlamentare
Prende in input 
- il numero della legislatura
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

include ("../parser/simple_html_dom.php");

//Controllo per i senatori
$c= new Criteria();
$c->add(OppCaricaPeer::TIPO_CARICA_ID,array(1,4),Criteria::IN);
$c->add(OppCaricaPeer::LEGISLATURA,$argv[1]);
$results=OppCaricaPeer::doSelect($c);
foreach ($results as $result)
{
  if ($result->getTipoCaricaId()==1)
  {
    $c= new Criteria();
    $c->add(OppAppoggioPeer::CARICA_ID,$result->getId());
    $c->add(OppAppoggioPeer::TIPOLOGIA,2);
    $c->add(OppAppoggioPeer::LEGISLATURA,$argv[1]);
    $aka=OppAppoggioPeer::doSelectOne($c);
    if ($aka)
      $url="http://www.senato.it/ricerche/sDDLa/risultati.ricerca?searchID=null&parms.output=&parms.statoDiv=0%2C0%2C0%2C1%2C0%2C0%2C0&parms.statoIcone=0%2C0%2C0%2C1%2C0%2C0%2C0&parms.sel=&parms.des=&parms.selmode=&parms.legislatura=".$argv[1]."&parms.ramo=+&parms.numeroFase=&parms.specification=&parms.testoScheda=&parms.natura=+&parms.lettura=+&parms.presentatoDal=&parms.presentatoAl=&parms.numeroDecretoLegge=&parms.decretoLeggeDel=&parms.numeroGazzettaDecreto=&parms.gazzettaDecretoDel=&parms.numeroLegge=&parms.leggeDel=&parms.numeroGazzettaLegge=&parms.gazzettaLeggeDel=&parms.statoDal=&parms.statoAl=&parms.tuttiTermini=T&parms.teseo=&parms.livelloTeseo=+&parms.naturaParlamentare=on&parms.deputatoIniziativa=".$aka->getAka()."&parms.iniziativa=&parms.tipoFirmatari=+&parms.assegnazione=&parms.ultimaAssegnazione=on&parms.assegnatoDal=&parms.assegnatoAl=&parms.pareri=&parms.criterioPareriAssegnazione=OR&parms.trattazione=&parms.trattatoDal=&parms.trattatoAl=&parms.fattoProprio=&parms.relatori=&parms.options.resultsPerPage=10&parms.ordinamento=DESC&parms.ordinaPerData=true&button-cerca=Cerca";
    else 
    {
      echo "??? non trovo AKA per ".$result->getId()."\n";
      $url="";
    }  
  }
  else
  {
    $parl_id=$result->getParliamentId();
    $url="http://www.senato.it/ricerche/sDDLa/risultati.ricerca?searchID=null&parms.output=&parms.statoDiv=0%2C0%2C0%2C1%2C0%2C0%2C0&parms.statoIcone=0%2C0%2C0%2C1%2C0%2C0%2C0&parms.sel=&parms.des=&parms.selmode=&parms.legislatura=".$argv[1]."&parms.ramo=+&parms.numeroFase=&parms.specification=&parms.testoScheda=&parms.natura=+&parms.lettura=+&parms.presentatoDal=&parms.presentatoAl=&parms.numeroDecretoLegge=&parms.decretoLeggeDel=&parms.numeroGazzettaDecreto=&parms.gazzettaDecretoDel=&parms.numeroLegge=&parms.leggeDel=&parms.numeroGazzettaLegge=&parms.gazzettaLeggeDel=&parms.statoDal=&parms.statoAl=&parms.tuttiTermini=T&parms.teseo=&parms.livelloTeseo=+&parms.naturaParlamentare=on&parms.senatoreIniziativaElencoTotale=".$parl_id."&parms.iniziativa=&parms.tipoFirmatari=+&parms.assegnazione=&parms.assegnatoDal=&parms.assegnatoAl=&parms.pareri=&parms.criterioPareriAssegnazione=OR&parms.trattazione=&parms.trattatoDal=&parms.trattatoAl=&parms.fattoProprio=&parms.relatori=&parms.options.resultsPerPage=10&parms.ordinamento=DESC&parms.ordinaPerData=true&button-cerca=Cerca";
  }
  
  if ($url!="")
  {
    for ($i = 1; $i <= 10; $i++)
    {
      try 
      {
    	  $html = file_get_html($url);
    	  if (!@file_get_html($url))
    		  throw new Exception('$a è negativo');
    	  break;
      }
    	catch (Exception $e) 
    	{
    	  //echo 'Caught exception: ',  $e->getMessage(), "\n";
      }
    } 

    $errore=$html->find('p.messaggioErrore');
    $numero=-1;

    foreach ($errore as $er)
    {
      $numero=0;
    }

    if ($numero==-1)
    {
      $numero=$html->find('div.rigaTabRic div.sottoTit');
      $numero=$numero[0]->find('strong');
      $numero=$numero[2]->plaintext;
    }
    $c= new Criteria();
    $c->addJoin(OppCaricaHasAttoPeer::ATTO_ID,OppAttoPeer::ID);
    $c->add(OppAttoPeer::TIPO_ATTO_ID,1);
    $c->add(OppCaricaHasAttoPeer::CARICA_ID,$result->getId());
    $c->add(OppCaricaHasAttoPeer::TIPO,'R',Criteria::NOT_EQUAL);
    $count=OppCaricaHasAttoPeer::doCount($c);
    if ($numero<$count) echo "!!!! ERRORE in ".$result->getId()." nel DB n.".$count." nel sito ".$numero."\n";
    if ($numero>$count) echo "!!!! ERRORE MANCANO FIRME in ".$result->getId()." nel DB n.".$count." nel sito ".$numero."\n";
  }
}





?>