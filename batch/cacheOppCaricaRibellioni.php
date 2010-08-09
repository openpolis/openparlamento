<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$leg=16;

print("Fetching data... \n");

// DEPUTATI E SENATORI
$c = new Criteria();
$crit0 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $leg);
$crit1 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 1);
$crit2 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 4);
$crit3 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 5);

$crit1->addOr($crit2);
$crit1->addOr($crit3);

$crit0->addAnd($crit1);

$c->add($crit0);
$cariche = OppCaricaPeer::doSelect($c);

foreach ($cariche as $carica) {

  $c=new Criteria();
  $c->add(OppCaricaHasGruppoPeer::CARICA_ID,$carica->getId());
  $gruppi=OppCaricaHasGruppoPeer::doSelect($c);
  $n_ribellioni=0;
  foreach($gruppi as $gruppo)
  {
    if ($gruppo->getRibelle()!=NULL)
    $n_ribellioni=$n_ribellioni+$gruppo->getRibelle();
  }
  //$carica->setRibelle($n_ribellioni);
  //$carica->save();
  echo $carica->getOppPolitico()->getCognome().": ".$n_ribellioni."\n";

}

?>