<?php

/*
vale per le legislatura camera 13, 14, 15
in input:
- numero della legislatura


Devi mettere le url giuste per le legislature <13
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

include ("../parser/simple_html_dom.php");

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


$alfabeto = array("A", "B", "C", "D", "E", "F" ,"G" ,"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T" ,"U", "V", "W","Y","X","Z");

//$alfabeto=array("F");

$leg=$argv[1];

$leg_url="http://leg".$leg.".camera.it";

foreach($alfabeto as $lettera)
{
  if ($leg>=13)
  {
      $uri=$leg_url."/deputatism/240/documentoxml.asp?sezione=&Let=".$lettera;


    $html=file_get_html($uri);
    if ($leg==15 || $leg==14)
      $deps=$html->find('tr td a[href*=.asp%3Fdeputato=]');
    else
      $deps=$html->find('tr td a[href*=scheda_deputato]');


    foreach ($deps as $dep)
    {
      echo $dep->plaintext."\t";
      $url=$leg_url.str_replace("&amp;","&",$dep->href);

      $c = new Criteria;
      $c->clearSelectColumns();
      $c->addSelectColumn(OppPoliticoPeer::ID);
      $c->addAsColumn('FULLNAME', 'CONCAT_WS(" ", '.OppPoliticoPeer::COGNOME.', '.OppPoliticoPeer::NOME.')');
      $rs = OppPoliticoPeer::doSelectRS($c);

      $pol_id=0;
      $k=0;

      while($rs->next())
      {
        if ($rs->getString(2)==trim($dep->plaintext))
        {
          $pol_id= $rs->getInt(1)."\t";
          $k++; 
        }
      }  

      if ($pol_id==0)
      {
        $cognome=explode(" ",trim($dep->plaintext));
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




      $url=str_replace(" ","%20",$url);
      $html1=file_get_html($url);
      $strongs=$html1->find('strong');
      foreach ($strongs as $strong)
      {
        if (preg_match('#^Proclamat#',trim($strong->plaintext)))
        {
          $data_inizio=explode('Elezione convalidata',$strong->parent->plaintext);
          $data_inizio=explode('Proclamat',trim($data_inizio[0]));
          $data_inizio=str_replace(array("il ","l'"),"",trim($data_inizio[1]));
          echo "*";
          echo data_format(trim(ltrim(trim(str_replace("&nbsp;","",$data_inizio)),'o a')));
          echo "*";
          echo "\t";
        }
        if (substr_count(trim($strong->plaintext),'Cessat')>0 && substr_count(trim($strong->parent->plaintext),'dal mandato parlamentare')>0)
        {

          $data_fine=explode('dal mandato parlamentare ',trim($strong->parent->plaintext));
          $data_fine=str_replace(array("il ","l'"),"",trim($data_fine[1]));
          $data_fine=explode('(',$data_fine);
          echo  "*".data_format(trim($data_fine[0]))."*";
        }   

      }
      echo "\n";
    }
  }
  else
  {
    $uri="http://legislature.camera.it/altre_sezionism/10247/10262/10264/documentoxml.asp?menu=&Let=".$lettera;
    $html=file_get_html($uri);
    $deps=$html->find('a[href*=framedeputato]');
    foreach ($deps as $dep)
    {
      echo $dep->plaintext."\t";
      
       $c = new Criteria;
        $c->clearSelectColumns();
        $c->addSelectColumn(OppPoliticoPeer::ID);
        $c->addAsColumn('FULLNAME', 'CONCAT_WS(" ", '.OppPoliticoPeer::COGNOME.', '.OppPoliticoPeer::NOME.')');
        $rs = OppPoliticoPeer::doSelectRS($c);

        $pol_id=0;
        $k=0;

        while($rs->next())
        {
          if ($rs->getString(2)==trim($dep->plaintext))
          {
            $pol_id= $rs->getInt(1)."\t";
            $k++; 
          }
        }  

        if ($pol_id==0)
          echo "POLITICO ID NON TROVATO \t";
        elseif ($k==1)
          echo $pol_id."\t";
        else
          echo "TROVATO PIU' DI UN POLITICO \t";
      
      $codice=explode('asp?Deputato=',str_replace("&amp;","&",$dep->href));
      $url="http://legislature.camera.it/deputati/legislatureprecedenti/Leg".$leg."/datpersonali.asp?vis=0&deputato=".ltrim($codice[1],"0 1")."&gove=";
      $html1=file_get_contents($url);
      $data_inizio=explode('>Proclamat',$html1);
      $data_inizio=explode('<br>',trim($data_inizio[1]));
      
      $data_inizio=str_replace(array("il ","l'","</span>","?"),"",trim($data_inizio[0]));
      echo "*";
      echo data_format(ltrim(trim($data_inizio),'o a'));
      echo "*";
      echo "\t";
      
      $data_fine=explode('dal mandato parlamentare',$html1);
      if (count($data_fine)==2)
      {
        $data_fine=explode('<br>',trim($data_fine[1]));
        $data_fine=strip_tags($data_fine[0]);
        $data_fine=str_replace(array("il ","l'"),"",trim($data_fine));
        echo "*";
        echo data_format(trim($data_fine));
        echo "*";
        echo "\t";
      }
      else
        echo datafine($leg)."\t";
      
      
      echo "\n";
    }
  }
    
}






?>