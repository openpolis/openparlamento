<?php

/*
Controlla le votazioni, e mette 2 al campo maggioranza_sotto in opp_votazione_has_carica nel caso nella votazione il parlamentare abbia salvato la maggioranza.
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
  $votazioni=OppVotazionePeer::doSelect(OppVotazionePeer::getVotazioniMaggioranzaSalva($argv[1]));
else
{
  $c = new Criteria();
  $c->add(OppVotazionePeer::ID, $argv[2]);
  $c->add(OppVotazionePeer::IS_MAGGIORANZA_SOTTO_SALVA, 2, Criteria::EQUAL);
  $votazioni=OppVotazionePeer::doSelect($c);
}

echo count($votazioni)."\n\n";




if (count($votazioni)>0)
{
  foreach($votazioni as $votazione)
  {
    if ($votazione->getOppSeduta()->getRamo()=='C')
      $ramo='camera';
    else
      $ramo='senato';
      
    $arr_opposizione=array();
    $c= new Criteria();
    $c->addJoin(OppGruppoPeer::ID,OppGruppoRamoPeer::GRUPPO_ID);
    $c->add(OppGruppoRamoPeer::DATA_INIZIO, $votazione->getOppSeduta()->getData(), Criteria:: LESS_EQUAL);
    $crit0 = $c->getNewCriterion(OppGruppoRamoPeer::DATA_FINE, NULL, Criteria::ISNULL);
    $crit1 = $c->getNewCriterion(OppGruppoRamoPeer::DATA_FINE, $votazione->getOppSeduta()->getData(), Criteria::GREATER_EQUAL);
    $crit0->addOr($crit1);
    $c->add($crit0);
    $c->add(OppGruppoRamoPeer::RAMO, $votazione->getOppSeduta()->getRamo());
    $gruppi = OppGruppoPeer::doSelect($c);
    foreach ($gruppi as $g)
    {
      if (!OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($g->getId(), $votazione->getOppSeduta()->getData()) and $g->getNome()!='Gruppo Misto')
      {
        $voto_gruppo=OppVotazioneHasGruppoPeer::getVotoGruppoVotazione($g->getId(), $votazione->getId());
        if (($votazione->getEsito()=='APPROVATA' && $voto_gruppo=='Contrario' && $ramo=='camera') ||
        ($votazione->getEsito()=='RESPINTA' && $voto_gruppo=='Favorevole' && $ramo=='camera') ||
        ($votazione->getEsito()=='APPROVATA' && ($voto_gruppo=='Contrario' || $voto_gruppo=='Astenuto') && $ramo=='senato') ||
        ($votazione->getEsito()=='RESPINTA' && $voto_gruppo=='Favorevole' && $ramo=='senato'))
        {
          
          $c = new Criteria();
          $c->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $g->getId());
          $c->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $votazione->getOppSeduta()->getData(), Criteria:: LESS_EQUAL);
          $crit0 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, NULL, Criteria::ISNULL);
          $crit1 = $c->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, $votazione->getOppSeduta()->getData(), Criteria::GREATER_EQUAL);
          $crit0->addOr($crit1);
          $c->add($crit0);
          $parlamentari = OppCaricaHasGruppoPeer::doSelect($c);
          //$parlamentari = OppCaricaHasGruppoPeer::getParlamentariGruppoData($g->getId(),$votazione->getOppSeduta()->getData());
          foreach ($parlamentari as $p)
          {
            $arr_opposizione[]=$p->getCaricaId();
          }
        }
      }
    }
    
    $c= new Criteria();
    $c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID,$votazione->getId());
    $c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$arr_opposizione, Criteria::IN);

    
    if ($votazione->getEsito()=='APPROVATA' && $votazione->getOppSeduta()->getRamo()=='C')
    {
      $crit0 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Assente');
      $crit1 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Favorevole');
      $crit2 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Astenuto');
      $crit0->addOr($crit1);
      $crit0->addOr($crit2);
      $c->add($crit0);
    }
    elseif ($votazione->getEsito()=='RESPINTA')
    {
      $crit0 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Assente');
      $crit1 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Contrario');
      $crit2 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Astenuto');
      $crit0->addOr($crit1);
      $crit0->addOr($crit2);
      $c->add($crit0);
    }
     elseif ($votazione->getEsito()=='APPROVATA' && $votazione->getOppSeduta()->getRamo()=='S')
    {
        $crit0 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Assente');
        $crit1 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, 'Favorevole');
        $crit0->addOr($crit1);
        $c->add($crit0);
    }
    $parlamentare=OppVotazioneHasCaricaPeer::doSelect($c);
    foreach ($parlamentare as $p)
    {
      $p->setMaggioranzaSottoSalva(2);
      $p->save();
    }
  }
}

?>