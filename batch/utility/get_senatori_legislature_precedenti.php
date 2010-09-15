<?php

/*
vale per le legislatura senato 13, 14, 15
in input:
- numero della legislatura

*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

include ("../parser/simple_html_dom.php");

function datainizio($leg)
{
  switch ($leg) {
      case 16:
          $data="2008-04-29";
          break;
      case 15:
          $data="2006-04-28";
          break;
      case 14:
          $data="2001-05-30";
          break;
      case 13:
          $data="1996-05-09";
          break;
  }
  return $data;
}

function datafine($leg)
{
  switch ($leg) {
      case 16:
          $data="";
          break;
      case 15:
          $data="2008-04-28";
          break;
      case 14:
          $data="2006-04-27";
          break;
      case 13:
          $data="2001-05-29";
          break;
  }
  return $data;
}


function data_format($data_string)
{
  $data_array=explode(" ",$data_string);
  $giorno=$data_array[0];
  $mese=$data_array[1];
  $anno=$data_array[2];
  
  switch ($mese) {
      case "gennaio" : 
        $mese="01";
        break;
      case "febbraio" : 
        $mese="02";
        break;
      case "marzo" : 
        $mese="03";
        break;
      case "aprile" : 
        $mese="04";
        break;
      case "maggio" : 
        $mese="05";
        break;
      case "giugno" : 
        $mese="06";
        break;
      case "luglio" : 
        $mese="07";
        break;
      case "agosto" : 
        $mese="08";
        break;
      case "settembre" : 
        $mese="09";
        break;
      case "ottobre" : 
        $mese="10";
        break;
      case "novembre" : 
        $mese="11";
        break;
      case "dicembre" : 
        $mese="12";
        break;
  }
  if (strlen($giorno)!=2) $giorno = "0".$giorno;
  return $anno."-".$mese."-".$giorno;
}

$alfabeto = array("A", "B", "C", "D", "E", "F" ,"G" ,"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T" ,"U", "V", "W","Y","X","Z");

//$alfabeto=array("S");

foreach($alfabeto as $lettera)
{
  $uri="http://www.senato.it/leg/".$argv[1]."/BGT/Schede/Attsen/Sen".strtolower($lettera).".html";
  $html=file_get_html($uri);
  if ($html)
  {
    
  }
  $sens=$html->find('ul.composizione li a');
  foreach($sens as $sen)
  {
    echo $sen->plaintext;
    echo "\t";
    
    $c = new Criteria;
    $c->clearSelectColumns();
    $c->addSelectColumn(OppPoliticoPeer::ID);
    $c->addAsColumn('FULLNAME', 'CONCAT_WS(" ", '.OppPoliticoPeer::COGNOME.', '.OppPoliticoPeer::NOME.')');
    $rs = OppPoliticoPeer::doSelectRS($c);

    $pol_id=0;
    $k=0;

    while($rs->next())
    {
      if ($rs->getString(2)==trim($sen->plaintext))
      {
        $pol_id= $rs->getInt(1)."\t";
        $k++; 
      }
    }  

    if ($pol_id==0)
    {
      $cognome=explode(" ",trim($sen->plaintext));
      $c= new Criteria();
      $c->add(OppPoliticoPeer::COGNOME,$cognome[0]."%",Criteria::LIKE);
      $results=OppPoliticoPeer::doSelect($c);
      if (count($results)>0)
      {
        echo "Potrebbe essere:";
        foreach($results as $result)
        {
          echo " ".$result->getCognome()." ".$result->getNome()." [".$result->getId()."]\t";
        }
      }
      else
        echo "POLITICO ID NON TROVATO \t";
    }
      
    elseif ($k==1)
      echo $pol_id."\t";
    else
      echo "TROVATO PIU' DI UN POLITICO \t";
    
    
    if ($sen->next_sibling())
    {
      if ($sen->next_sibling()->tag=="span")
        $data_inizio=explode('(dal',$sen->next_sibling()->plaintext);
        
        if (count($data_inizio)==2)
        {
          $data_inizio=explode(')',$data_inizio[1]);
          $data_inizio=str_replace("l'","",$data_inizio[0]);
          $data_fine=explode(" al ",trim($data_inizio));
          if (count($data_fine)==2)
          {
            echo data_format(trim($data_fine[0]))."\t".data_format(trim($data_fine[1]));
          }
          else
            echo data_format(trim($data_inizio))."\t".datafine($argv[1]);
        }
        else
        {
          $data_fine=explode('(fino al',$sen->next_sibling()->plaintext);
          if (count($data_fine)==2)
          {
            $data_fine=explode(')',$data_fine[1]);
            $data_fine=str_replace("l'","",$data_fine[0]);
            echo datainizio($argv[1])."\t".data_format(trim($data_fine));
          }
        }
    }
    else
    {
      echo datainizio($argv[1])."\t".datafine($argv[1]);
    }
    
    echo "\n";
  }
}




?>