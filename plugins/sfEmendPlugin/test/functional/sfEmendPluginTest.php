<?php
// initializes testing framework (change app name)
$app = 'fe';
include(dirname(__FILE__).'/../../../../test/bootstrap/functional.php');
include($sf_symfony_lib_dir.'/vendor/lime/lime.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();
$con = Propel::getConnection();

$resource = 'test1';

// clean all the comments related to the test resource
$comments = sfEmendCommentPeer::getAllCommentsForResource($resource);
foreach ($comments as $comment)
  $comment->delete($con);

$user_options = sfConfig::get('app_sfEmendPlugin_user');

$browser = new sfTestBrowser();
$browser->initialize();

// get empty comments list for the first resource
$browser->test()->comment('Get an empty comments list');
$browser->
  get("/emend.getComments/" . $resource)->
  isStatusCode(200)->
  isRequestParameter('module', 'sfEmendAPI')->
  isRequestParameter('action', 'getComments')->
  responseContains('"n_comments": 0')
;

// try to add a comment through an emulated POST, as an anonymous user with no author name
$browser->test()->comment('Try to add a comment as anonymous user');
$browser->
  post("/emend.addComment/" . $resource, 
       array('title' => 'Prova',
             'body'  => 'Un commento di prova',
             'selection' => '"s": []'))->
  isStatusCode(200);
if ($user_options['allow_anonymous'] == 1)
  $browser->responseContains('Anonymous posting requires an author_name parameter');
else
  $browser->responseContains('Anonymous posting not allowed');


// add a comment through an emulated POST, 
// as an anonymous user with author name
$browser->test()->comment('Try to add a comment as anonymous user with author name');
$browser->
  post("/emend.addComment/" . $resource, 
       array('title' => 'Prova',
             'body'  => 'Un commento di prova',
             'selection' => '"s": []',
             'author_name' => 'Guglielmo Celata'))->
  isStatusCode(200);
if ($user_options['allow_anonymous'] == 1)
  $browser->responseContains('"s":');
else
  $browser->responseContains('Anonymous posting not allowed');


$browser->test()->comment('Login through the browser');
$browser->
  get("/login")->
  isStatusCode(401)->
  isRequestParameter('module', 'sfGuardAuth')->
  isRequestParameter('action', 'signin')->
  post('/login', array('username'      => 'guglielmo.celata@gmail.com',
                       'password'      => 'Vakka94',
                       'commit'        => 'sign in') )->
                       
  // test redirect alla home page (impossibile verificare con un referrer)
  isRedirected()->
  followRedirect()->
  isStatusCode(200)->
  isRequestParameter('module', 'default')->
  isRequestParameter('action', 'index')->
  
  // test presenza del nome utente nel menu di servizio (utente è loggato)
  checkResponseElement('div[id="login"] div[class="inner"] span', "/Guglielmo/")
;

// try to add a comment through an emulated POST, as an authenticated user
$browser->test()->comment('Try to add a comment as authenticated user');
$browser->
  post("/emend.addComment/" . $resource, 
       array('title' => 'Prova',
             'body'  => 'Un commento di prova',
             'selection' => '"s": []'))->
  isStatusCode(200)->
  responseContains('"s":');

$browser->test()->comment('Add another comment and test the strip_tag');
$browser->
  post("/emend.addComment/" . $resource, 
       array('title' => 'Seconda <em>prova</em>',
             'body'  => 'Secondo <em>commento</em> di <li>prova</li>',
             'selection' => '"s": []'))->
  isStatusCode(200)->
  responseContains('<em>commento</em> di prova');
  

// get comments list
$browser->test()->comment('Get the comments list');
$browser->
  get("/emend.getComments/" . $resource)->
  isStatusCode(200)->
  isRequestParameter('module', 'sfEmendAPI')->
  isRequestParameter('action', 'getComments');

if ($user_options['allow_anonymous'] == 1)
  $browser->responseContains('"n_comments": 3');
else
  $browser->responseContains('"n_comments": 2');

