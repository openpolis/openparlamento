<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

$browser->
  get('/feed/index')->
  isStatusCode(200)->
  isRequestParameter('module', 'feed')->
  isRequestParameter('action', 'index')->
  checkResponseElement('body', '!/This is a temporary page/')
;
