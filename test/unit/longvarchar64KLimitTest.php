<?php

define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'test');
define('SF_DEBUG',       true);

include(dirname(__FILE__).'/../bootstrap/unit.php'); 

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$t = new lime_test(2, new lime_output_color());

$t->diag('unit test to verify the 64k limit on longvarchar propel field');


$t->diag('Tests beginning');

// clean the database
$t->diag('Cleaning previously created test records');
$c = new Criteria();
$c->add(OppAttoPeer::PARLAMENTO_ID, 999999);
$existing_records = OppAttoPeer::doSelect($c);
foreach ($existing_records as $rec) 
{
  $t->diag('Cleaning record ' . $rec->getId());
  $rec->delete();
}


$t->diag('Preparing a longvarchar variable');
$longvarchar = '';
for ($i=0; $i<15000; $i++)
  $longvarchar .= 'pippo ';
  
$var_length = strlen($longvarchar);
$t->diag('Long variable created: length=' . $var_length);

$t->diag('Create the test OppAtto object');
$obj = new OppAtto();
$obj->setTipoAttoId(1);
$obj->setParlamentoId(999999);
$obj->setDescrizione($longvarchar);
$obj->save();

$c = new Criteria();
$c->add(OppAttoPeer::PARLAMENTO_ID, 999999);
$read_obj = OppAttoPeer::doSelectOne($c);

$read_var = $read_obj->getDescrizione();
$read_length = strlen($read_var);
$t->diag('Long variable read from DB: length=' . $read_length);

$t->ok($read_var == $longvarchar, 'the variable was set correctly');
$t->ok($read_length == $var_length, 'the length is ok');
