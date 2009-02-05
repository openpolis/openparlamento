<?php

define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'test');
define('SF_DEBUG',       true);

include(dirname(__FILE__).'/../bootstrap/unit.php'); 

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$t = new lime_test(2, new lime_output_color());

$t->diag('unit test to verify the mechanisms to upgrade the opp_atto.n_interventi field');

$t->diag('Tests beginning');

$atto_id=12066;
$carica_id=801;
$atto = OppAttoPeer::retrieveByPK($atto_id);
$n_interventi = $atto->getNInterventi();
$t->diag("L'atto $atto_id ha $n_interventi interventi");


$t->diag("Creato nuovo un intervento per la carica $carica_id");
$int_new = new OppIntervento();
$int_new->setAttoId($atto_id);
$int_new->setCaricaId($carica_id);
$int_new->setTipologia('Assemblea');
$int_new->setSedeId('36');
$int_new->setData('2009-02-06');
$int_new->setUrl('http://pippo.it');
$int_new->setNumero(2);
$int_new->save();		    					

$atto = OppAttoPeer::retrieveByPK($atto_id);
$t->ok($atto->getNInterventi() == $n_interventi + 1, 
       "L'atto ha ora un intervento in più (".$atto->getNInterventi().")");


$t->diag("Rimosso l'intervento");
$int_new->delete();

$atto = OppAttoPeer::retrieveByPK($atto_id);
$t->ok($atto->getNInterventi() == $n_interventi, 
       "L'atto ha ora di nuovo lo stesso n. di interventi (".$atto->getNInterventi().")");
?>
