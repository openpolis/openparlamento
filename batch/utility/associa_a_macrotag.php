<?php

/*
lo script associa gli oggetti taggati con tags con macrotags
in input
- 0 Tuuti gli oggetti, 1 solo gli atti (non gli emendamenti)
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
  $number_tagging_ok=0;
  $number_tagging_no=0;
  $number=0;
  //Tagga OGGETTI TAGGATI con $tag anche con $macrotag
  foreach ($tags as $k=>$tag)
  {
    $c= new Criteria();
    $c->add(TaggingPeer::TAG_ID,$tag);
    if ($argv[1]==1)
      $c->add(TaggingPeer::TAGGABLE_MODEL,'OppAtto');
    $results=TaggingPeer::doSelect($c);
    $number=$number+count($results);
    foreach($results as $rs)
    {
      for ($x=0;$x<=1;$x++)
      {
        if ($macrotags[$k][$x]!=0)
        {
          $c= new Criteria();
          $c->add(TaggingPeer::TAG_ID,$macrotags[$k][$x]);
          $c->add(TaggingPeer::TAGGABLE_ID,$rs->getTaggableId());
          $c->add(TaggingPeer::TAGGABLE_MODEL,$rs->getTaggableModel());
          $r=TaggingPeer::doSelectOne($c);
          if (!$r)
          {
            $t=TagPeer::retrieveByPk($macrotags[$k][$x]);
            if ($t)
            {
              $insert=new Tagging();
              $insert->setTagId($macrotags[$k][$x]);
              $insert->setTaggableId($rs->getTaggableId());
              $insert->setTaggableModel($rs->getTaggableModel());
              //$insert->save();
              echo "++++++++++++++++++++++++++++++++++++++++++ aggiunto ".$macrotags[$k][$x]." - ".$t->getTripleValue()." in ".$rs->getTaggableId()."\n";
              $number_tagging_ok=$number_tagging_ok+1;
            }
            else
              echo "!!!! non esiste Macrotags con id=".$macrotags[$k][$x]."\n";
            
          }
          else
          {
            echo "NON aggiungo, già esiste! \n";
            $number_tagging_no=$number_tagging_no+1;
          } 
        }
      } 
    }
  }
}
else
  echo "!!!!! Gli array hanno un numero di elementi diversi!";

echo "\n============\n".$number_tagging_ok." - ".$number_tagging_no." - ".$number;

?>