<?php

/*
lo script sostituisci gli oggetti taggati con tag_old con tag_new
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();


$tag_old=array(8340,
354,
4866,
16103,
6254,
16184,
2381,
16185,
7425,
7924,
6672,
8209,
8056,
8134,
474,
6649,
5272,
8067,
7404,
4702,
16104,
6401,
8350,
7788,
1296,
16179,
5943,
4686,
7834,
626,
1357,
8351,
16077,
16017,
8329,
16002,
4491,
16110,
16123,
8011,
5709,
4641,
5467,
5490,
7017,
1445,
16097,
1430,
1428,
1658,
4865,
16181,
16112,
188,
4487,
8343,
4789,
4919,
16107,
116,
16118,
5731,
6410,
16186,
7660,
16173,
2350,
4721,
8023,
7346,
16117,
5159,
92,
424,
469,
16113,
45);

$tag_new=array(14091,
8334,
8184,
8000,
7902,
7890,
7791,
7486,
7425,
7403,
7065,
2275,
6729,
6559,
6058,
6019,
5829,
5541,
5351,
5073,
4969,
4900,
4900,
4858,
4823,
4732,
4730,
4686,
4542,
4357,
4354,
4280,
2287,
2285,
2217,
2211,
1882,
1786,
1711,
1707,
1686,
1629,
1622,
1617,
1535,
1444,
1441,
1429,
1426,
1423,
1360,
1334,
1334,
1284,
1281,
1278,
1266,
1266,
1181,
1181,
1170,
1073,
1002,
904,
720,
674,
567,
563,
547,
393,
329,
296,
296,
130,
130,
53,
53);

foreach ($tag_old as $k=>$old)
{
  $c= new Criteria();
  $c->add(TaggingPeer::TAG_ID,$old);
  $results=TaggingPeer::doSelect($c);
  foreach($results as $rs)
  {
    $c= new Criteria();
    $c->add(TaggingPeer::TAG_ID,$tag_new[$k]);
    $c->add(TaggingPeer::TAGGABLE_ID,$rs->getTaggableId());
    $c->add(TaggingPeer::TAGGABLE_MODEL,$rs->getTaggableModel());
    $r=TaggingPeer::doSelectOne($c);
    if (!$r)
    {
      $rs->setTagId($tag_new[$k]);
      $rs->save();
      echo "sostituito ".$old." con ".$tag_new[$k]." in ".$rs->getTaggableId()."\n";
    }
  }
}


?>