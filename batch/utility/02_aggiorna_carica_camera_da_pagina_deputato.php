<?php

/*

Lo script controlla le cariche all'inteno della camera dei deputati
- Prende in input l'id della carica

*/

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false); 
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

include ("../parser/simple_html_dom.php");

function formatta_data($data)
{
  if (substr_count($data,"/")==2)
  {
    $data=explode("/",$data);
    return $data[2]."-".$data[1]."-".$data[0];
  }
  else
    return NULL;
}

function trova_carica($carica)
{
  switch (strtolower($carica)) 
  {
      case "membri" : 
        $carica="Componente";
        break;
      case "membro" : 
        $carica="Componente";
        break;  
      case "presidente" : 
        $carica="Presidente";
        break;
      case "segretari" : 
        $carica="Segretario";
        break;
      case "vicepresidenti" : 
        $carica="Vicepresidente";
        break;
      case "vicepresidente" : 
        $carica="Vicepresidente";
        break;
      case "segretario" : 
        $carica="Segretario";
        break;
      case "questori" : 
        $carica="Questore";
        break;
      case "questore" : 
        $carica="Questore";
        break;
      case "componente" : 
        $carica="Componente";
        break;  
      case "altri membri" : 
        $carica="Componente";
        break;
      case "deputati membri" : 
        $carica="Componente";
        break;   
      case "membri deputati" : 
        $carica="Componente";
        break; 
      case "membri senatori" : 
        $carica="Componente";
        break;              
  }
  $c=new Criteria();
  $c->add(OppTipoCaricaPeer::NOME,$carica);
  $rs=OppTipoCaricaPeer::doSelectOne($c);
  if ($rs)
    return $rs->getId();
  else
    return 0;
}

function trova_sede($parametro,$ramo,$tipo=0)
{
  $codice=0;
  if ($tipo==0)
  {
    if ($parametro>=1494 && $parametro<=1506)
      $codice="COM2X".($parametro-1494+1);
    elseif($parametro==1507)
       $codice="COM2X16";
    elseif($parametro==1491)
       $codice="COM2XG01";
    elseif($parametro==1493)
       $codice="COM2XG03";
    elseif($parametro==1530)
       $codice="COM2XG02";         
  }
  $c = new Criteria();
  $c->add(OppSedePeer::RAMO,$ramo);
  if ($tipo==0)
    $c->add(OppSedePeer::CODICE,$codice);
  else
    $c->add(OppSedePeer::DENOMINAZIONE,$parametro);  
  $rsede=OppSedePeer::doSelectOne($c);
  if ($rsede)
    return $rsede->getId();
  else
    return 0;
}

$r=OppCaricaPeer::retrieveByPk($argv[1]);

  //echo "+++++". $r->getOppPolitico()->getCognome()." +++++ \n";
  $uri="http://www.camera.it/29?shadow_deputato=".$r->getParliamentId();
  for ($i = 1; $i <= 10; $i++)
  {
    try 
    {
  	  $html = @file_get_html($uri);
  	  if (!@file_get_html($uri))
  		  throw new Exception('$a è negativo');
  	  break;
    }
  	catch (Exception $e) 
  	{
  	  echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }

  $cariche=$html->find('div.cnt_incarichi ul.cnt_incarichi_ul li[class^=cnt_incarichi_li_]');
  
  foreach($cariche as $k=>$carica)
  {
    $html1=str_get_html($carica->innertext);
    $dettagli=$html1->find('div');
    $data_inizio= "";
    $data_fine= "";
    $ctrl=0;
    $sede_id=0;
    $tipo_carica_id=0;
    foreach($dettagli as $d)
    {
      if ($d->class=="has_carica_nome")
        $tipo_carica_id= trova_carica(trim($d->plaintext));
      if ($d->class=="link_tag")
      {
        if (substr_count($d->first_child()->href,"99?shadow_organo_parlamentare=")==1)
        {
          $tmp=explode('99?shadow_organo_parlamentare=',$d->first_child()->href);
          $sede_id=trova_sede(trim($tmp[1]),'C',0);
          $ctrl=1;
        }
      }
      if ($d->class=="has_carica_dal")
        $data_inizio= str_replace(array("dal"," "),"",trim($d->plaintext)); 
        
      if ($d->class=="has_carica_al")
        $data_fine= str_replace(array("al"," "),"",trim($d->plaintext)); 
    }
    if ($data_inizio!="" && $ctrl==1 && $sede_id!=0 && $tipo_carica_id!=0)
    {
      $data_inizio=formatta_data($data_inizio);
      $data_fine=formatta_data($data_fine);
      $c= new Criteria();
      $c->add(OppCaricaInternaPeer::SEDE_ID,$sede_id);
      $c->add(OppCaricaInternaPeer::TIPO_CARICA_ID,$tipo_carica_id);
      $c->add(OppCaricaInternaPeer::CARICA_ID,$r->getId());
      $c->add(OppCaricaInternaPeer::DATA_INIZIO,$data_inizio,Criteria::LESS_EQUAL);
      $rs=OppCaricaInternaPeer::doSelectOne($c);
      if (!$rs)
      {
        $insert= new OppCaricaInterna();
        $insert->setSedeId($sede_id);
        $insert->setTipoCaricaId($tipo_carica_id);
        $insert->setCaricaId($r->getId());
        $insert->setDataInizio($data_inizio);
        if ($data_fine!="")
          $insert->setDataFine($data_fine);
        $i=$insert->save();
        if ($i==1)
          echo "+++++".$r->getOppPolitico()->getCognome()."\t".$r->getId()."\t".$tipo_carica_id."\t".$sede_id."\t".$data_inizio."\t".$data_fine."\n";
        else
          echo "!!!! Non posso inserire".$r->getOppPolitico()->getCognome()."\t".$r->getId()."\t".$tipo_carica_id."\t".$sede_id."\t".$data_inizio."\t".$data_fine."\n";
      }
      elseif ($data_fine!="" && $rs->getDataFine()==NULL)
      {
        $rs->setDataFine($data_fine);
        $u=$rs->save();
        echo "agg. data_fine in id=".$rs->getId()."\n";
      }
    }
     
  }
  
  $comps=$html->find('div[class!=cnt_incarichi] ul.list_ul li[class^=list_li_]');
  
  
  
  foreach($comps as $comp)
  {
    $html2=str_get_html($comp->innertext);
    $dettagli=$html2->find('div');
    $data_fine_1= "";
    $data_inizio_1="";
    $ctrl_1=0;
    $sede_id_1=0;
    $tipo_carica_id_1=trova_carica('componente');
    foreach($dettagli as $d)
    {
      if ($d->class=="link_tag")
      {
        if (substr_count($d->first_child()->href,"99?shadow_organo_parlamentare=")==1)
        {
          $tmp=explode('99?shadow_organo_parlamentare=',$d->first_child()->href);
          $sede_id_1=trova_sede(trim($tmp[1]),'C',0);
          $ctrl_1=1;
        }
      }
      if ($d->class=="has_carica_nome")
        $tipo_carica_id_1=trova_carica(trim($d->plaintext));
      if ($d->class=="has_componente_dal")
        $data_inizio_1= str_replace(array("dal"," "),"",trim($d->plaintext));
      if ($d->class=="has_carica_dal")
        $data_inizio_1= str_replace(array("dal"," "),"",trim($d->plaintext));   
      if ($d->class=="has_componente_al")
        $data_fine_1= str_replace(array("al"," "),"",trim($d->plaintext));
      if ($d->class=="has_carica_al")
        $data_fine_1= str_replace(array("al"," "),"",trim($d->plaintext));  
    }
    if ($data_inizio_1!="" && $ctrl_1==1 && $sede_id_1!=0 && $tipo_carica_id_1!=0)
    {
      $array
      $data_inizio_1=formatta_data($data_inizio_1);
      $data_fine_1=formatta_data($data_fine_1);
      $c= new Criteria();
      $c->add(OppCaricaInternaPeer::SEDE_ID,$sede_id_1);
      $c->add(OppCaricaInternaPeer::TIPO_CARICA_ID,$tipo_carica_id_1);
      $c->add(OppCaricaInternaPeer::CARICA_ID,$r->getId());
      $c->add(OppCaricaInternaPeer::DATA_INIZIO,$data_inizio_1,Criteria::LESS_EQUAL);
      $rs=OppCaricaInternaPeer::doSelectOne($c);
      if (!$rs)
      {
        $insert= new OppCaricaInterna();
        $insert->setSedeId($sede_id_1);
        $insert->setTipoCaricaId($tipo_carica_id_1);
        $insert->setCaricaId($r->getId());
        $insert->setDataInizio($data_inizio_1);
        if ($data_fine_1!="")
          $insert->setDataFine($data_fine_1);
        $i=$insert->save();
        if ($i==1)
          echo "+++++".$r->getOppPolitico()->getCognome()."\t".$r->getId()."\t".$tipo_carica_id_1."\t".$sede_id_1."\t".$data_inizio_1."\t".$data_fine_1."\n";
        else
          echo "!!!! Non posso inserire".$r->getOppPolitico()->getCognome()."\t".$r->getId()."\t".$tipo_carica_id_1."\t".$sede_id_1."\t".$data_inizio_1."\t".$data_fine_1."\n";
      }
      elseif ($data_fine_1!="" && $rs->getDataFine()==NULL)
      {
        $rs->setDataFine($data_fine_1);
        $u=$rs->save();
        echo "agg. data_fine in id=".$rs->getId()."\n";
      }
    }
  }
?>