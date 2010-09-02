<?php

/*
lo script associa gli oggetti taggati con tags con macrotags
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();


include ("../parser/lista_tags_macrotags.php");

if (count($tags)==count($macrotags))
{

  //Tagga OGGETTI TAGGATI con $tag anche con $macrotag
  foreach ($tags as $k=>$tag)
  {
    $c= new Criteria();
    $c->add(TagPeer::ID,$tag);
    $result=TagPeer::doSelectOne($c);
    if ($result)
    {
      for ($x=0;$x<=1;$x++)
      {
        $c= new Criteria();
        $c->add(TagPeer::ID,$macrotags[$k][$x]);
        $mt=TagPeer::doSelectOne($c);
        if ($mt)
          echo $result->getId()."\t".$result->getTripleValue()."\t".$mt->getId()."\t".$mt->getTripleValue()."\n";
        elseif ($macrotags[$k][$x]!=0)
          echo "!!!! ".$result->getId()."\t".$result->getTripleValue()." \t errore non esiste macrotag=\t".$macrotags[$k][$x]."\n";
      }
    }  
    else
      echo "!!!! \terrore non esiste TAG=\t".$tag."\t\n";
  }           
}
else
  echo "!!!!! Gli array hanno un numero di elementi diversi!";

?>