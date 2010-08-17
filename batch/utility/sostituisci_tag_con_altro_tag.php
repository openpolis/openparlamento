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


$tag_old=array(16168,
  16105,
  16182,
  15962,
  15963,
  1442,
  7389,
  8331,
  6304,
  6417,
  8019,
  15923,
  15969,
  16198,
  15953,
  1077,
  15957,
  16180,
  2251,
  2252,
  7457,
  15973,
  2406,
  7902,
  8163,
  2253,
  2254,
  15987,
  16018,
  15983,
  2328,
  15996,
  15945,
  2256,
  6100,
  16190,
  16078,
  1182,
  16062,
  8332,
  1282,
  7736,
  1341,
  6109,
  1345,
  205,
  15914,
  7339,
  4563,
  5858,
  4977,
  8183,
  1234,
  1246,
  1237,
  5548,
  6059,
  6150,
  16070,
  8290,
  8089,
  16171,
  15968,
  2411,
  2250,
  4256,
  8291,
  2214,
  8091,
  15931,
  8090,
  1686,
  15990,
  15994,
  8076,
  6299,
  16167,
  16106,
  15981,
  15988,
  16169,
  6034,
  7375,
  88,
  5596,
  15982,
  6306,
  482,
  8337,
  6673,
  6734,
  16132,
  7360,
  8046,
  665,
  16131,
  4265,
  8132,
  4536,
  1627,
  1629,
  15937,
  1850,
  16174,
  16075,
  16133,
  1654,
  7287,
  1665,
  16225,
  2362,
  4498,
  5336,
  8012,
  1302);

$tag_new=array(17,
22,
63,
98,
98,
141,
313,
708,
832,
838,
838,
857,
946,
1072,
1073,
1090,
1092,
1137,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1181,
1266,
1281,
1294,
1338,
1338,
1338,
1338,
1422,
1423,
1423,
1433,
1562,
1618,
1618,
1618,
1618,
1618,
1641,
1655,
1655,
1655,
1655,
1655,
1655,
1657,
1657,
1657,
1662,
1662,
1663,
1663,
1663,
1685,
1704,
1803,
1812,
1812,
1812,
1812,
1829,
1877,
4255,
4484,
4497,
4849,
5073,
5073,
5073,
5351,
5718,
5726,
5728,
6633,
7169,
7398,
8184,
8184,
16206,
16210,
16210,
16211,
16215,
16216,
16216,
16217,
16218,
16221,
16221,
16222,
16222,
16225,
16225,
16226,
16226,
16229,
16230);

if (count($tag_old)==count($tag_new))
{
  $number_tagging_ok=0;
  $number_tagging_no=0;
  //SOSTITUISCI OGGETTI TAGGATI CON NUOVO TAG
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
        //$rs->save();
        echo "sostituito ".$old." con ".$tag_new[$k]." in ".$rs->getTaggableId()."\n";
        $number_tagging_ok=$number_tagging_ok+1;
      }
      else
        $number_tagging_no=$number_tagging_no+1;
    }
  }
  
  //SOSTITUISCI TAG MONITORATI CON NUOVO TAG
  
  foreach ($tag_old as $k=>$old)
  {
    $c= new Criteria();
    $c->add(MonitoringPeer::MONITORABLE_ID,$old);
    $c->add(MonitoringPeer::MONITORABLE_MODEL,'Tag');
    $results=MonitoringPeer::doSelect($c);
    foreach($results as $rs)
    {
      $c= new Criteria();
      $c->add(MonitoringPeer::MONITORABLE_ID,$tag_new[$k]);
      $c->add(MonitoringPeer::MONITORABLE_MODEL,'Tag');
      $c->add(MonitoringPeer::USER_ID,$rs->getUserId());
      $r=MonitoringPeer::doSelectOne($c);
      if (!$r)
      {
        $rs->setMonitorableId($tag_new[$k]);
        //$rs->save();
        echo "Monitoraggio cambiato: ".$old." con ".$tag_new[$k]." per utente ".$rs->getUserId()."\n";
      }
      else
        echo "!!!! DOPPIONE".$old." con ".$tag_new[$k]." per utente ".$rs->getUserId()."\n";
    }
  }
}
else
  echo "!!!!! Gli array hanno un numero di elementi diversi!";

echo "\n============\n".$number_tagging_ok." - ".$number_tagging_no;

?>