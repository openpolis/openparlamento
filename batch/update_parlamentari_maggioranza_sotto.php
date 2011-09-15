<?php

/*
Controlla le votazioni, e mette 1 al campo maggioranza_sotto in opp_votazione_has_carica nel caso nella votazione il parlamentare abbia mandato giù la maggioranza.
in input:
- numero della legislatuta
- 0 ctrl tutte le votazioni, id_votazione ctrl solo una votazione 
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

if ($argv[2]==0)
  $votazioni=OppVotazionePeer::doSelect(OppVotazionePeer::getVotazioniMaggioranzaSotto($argv[1]));
else
{
  $c = new Criteria();
  $c->add(OppVotazionePeer::ID, $argv[2]);
  $c->add(OppVotazionePeer::IS_MAGGIORANZA_SOTTO_SALVA,1);
  $votazioni=OppVotazionePeer::doSelect($c);
}

echo count($votazioni)."\n\n";




if (count($votazioni)>0)
{
  foreach($votazioni as $v)
  {
    echo $v->getOppSeduta()->getRamo().$v->getOppSeduta()->getData()."\n\n";
    
    //controlla come ha votato la PDL (gruppo id=19)
    $c= new Criteria();
    $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, 19);
    $c->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $v->getId());
    $voto_magg=OppVotazioneHasGruppoPeer::doSelectOne($c);
    
    //prendi i gruppi attivi alla data della votazione nel ramo della votazione
    $gruppi_ramo=OppGruppoRamoPeer::getGruppiRamo($v->getOppSeduta()->getRamo(), $v->getOppSeduta()->getData());
    foreach ($gruppi_ramo as $gruppo)
    {
      echo $gruppo->getGruppoId()."\n";
      // controlla se il gruppo alla data faceva parte della maggioranza
      if (OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($gruppo->getGruppoId(), $v->getOppSeduta()->getData()))
      {
        //ctrl i voti dei componenti i gruppi di maggioranza
        $c= new Criteria();
        $c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID);
        $c->addJoin(OppCaricaPeer::ID, OppVotazioneHasCaricaPeer::CARICA_ID);
        $c->addJoin(OppVotazionePeer::ID, OppVotazioneHasCaricaPeer::VOTAZIONE_ID);
        $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);
        //ctrl se fa parte del gruppo alla data della votazione
        $crit0 = $c->getNewCriterion(OppCaricaHasGruppoPeer::GRUPPO_ID, $gruppo->getGruppoId());
        $crit1 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_INIZIO, $v->getOppSeduta()->getData(), Criteria::LESS_EQUAL);
        $crit2 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, $v->getOppSeduta()->getData(), Criteria::GREATER_EQUAL);
        $crit3 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);

        $crit2->addOr($crit3);

        $crit0->addAnd($crit1);
        $crit0->addAnd($crit2);

        $c->add($crit0);
        
        $c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $v->getId());
  
        //ctrl voti alla camera
        $crit0 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Favorevole');
        $crit1 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Contrario');
        $crit2 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Astenuto');
        $crit3 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Assente');

        $crit0->addOr($crit1);
        $crit0->addOr($crit2);
        $crit0->addOr($crit3);
        $crit4 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Assente');
        $crit5 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, $voto_magg->getVoto(), Criteria::ALT_NOT_EQUAL);

        $crit4->addOr($crit5);
        $crit6 = $c->getNewCriterion(OppSedutaPeer::RAMO, 'C');

        $crit0->addAnd($crit4);
        $crit0->addAnd($crit6);

        $c->add($crit0);
        
        //ctrl voti al senato
        $crit1->addAnd($crit2);
        $crit3 = $c->getNewCriterion(OppSedutaPeer::RAMO, 'S');
        $crit4 = $c->getNewCriterion(OppVotazionePeer::ESITO, 'Appr.');
        $crit5 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Favorevole');

        $crit3->addAnd($crit4);
        $crit3->addAnd($crit5);
        $crit6 = $c->getNewCriterion(OppSedutaPeer::RAMO, 'S');
        $crit7 = $c->getNewCriterion(OppVotazionePeer::ESITO, 'Resp.');
        $crit8 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Contrario');
        $crit9 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Astenuto');

        $crit8->addOr($crit9);

        $crit6->addAnd($crit7);
        $crit6->addAnd($crit8);

        $crit0->addOr($crit1);
        $crit0->addOr($crit3);
        $crit0->addOr($crit6);

        $c->add($crit0);
        $parlamentari=OppVotazioneHasCaricaPeer::doSelect($c);
        foreach ($parlamentari as $p)
        {
          $p->setMaggioranzaSottoSalva(1);
          $p->save();
          //echo $v->getId()." - ".$v->getEsito()." - ".$p->getOppCarica()->getOppPolitico()->getCognome()." - ".$p->getVoto()."\n";
        }
      }
    }
  }
}

?>