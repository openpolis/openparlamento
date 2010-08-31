<?php

/*
controlla le news che fanno riferimento a tag che non esistono e le cancella
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();


$c= new Criteria();
$c->add(NewsPeer::RELATED_MONITORABLE_MODEL,'Tag');
$news=NewsPeer::doSelect($c);
foreach ($news as $n)
{
  $tag=TagPeer::retrieveByPk($n->getRelatedMonitorableId());
  if (!$tag)
    echo "tag id=".$n->getRelatedMonitorableId().", trovato nelle news id=".$n->getId()." non esiste\n";
    
}

?>