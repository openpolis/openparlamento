<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n\n");

$leg=16;

$c = new Criteria();
$crit0 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 1);
$crit1 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 4);

$crit0->addOr($crit1);
<<<<<<< .mine
$crit2 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, 16);

$crit0->addAnd($crit2);
$crit3 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 5);

$crit0->addOr($crit3);

=======
$crit2 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $leg);

$crit0->addAnd($crit2);
$crit3 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 5);

$crit0->addOr($crit3);

>>>>>>> .r576
$c->add($crit0);
$cariche = OppCaricaPeer::doSelect($c);
$cariche = OppCaricaPeer::doSelect($c);

foreach($cariche as $carica)
  {  
    if ($carica->getTipoCaricaId()==1) $ramo='C';
    if ($carica->getTipoCaricaId()==4 || $carica->getTipoCaricaId()==5) $ramo='S';
    
    
    $c = new Criteria();
    $c->add(OppCaricaHasGruppoPeer::CARICA_ID, $carica->getId(), Criteria::EQUAL);
    $c->add(OppCaricaHasGruppoPeer::GRUPPO_ID, 13, Criteria::NOT_EQUAL);
    $gruppi = OppCaricaHasGruppoPeer::doSelect($c);
    foreach($gruppi as $gruppo) 
      {
         
        $cont=0;
        $cont_votazioni=0;
        $c = new Criteria();
        $c->addJoin(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, OppVotazionePeer::ID);
        $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);
        $c->add(OppSedutaPeer::RAMO, $ramo, Criteria::EQUAL);
        $c->add(OppSedutaPeer::LEGISLATURA, $leg, Criteria::EQUAL);
        $c->add(OppSedutaPeer::DATA, $gruppo->getDataInizio(), Criteria::GREATER_EQUAL);
        if ($gruppo->getDataFine()!='')
            $c->add(OppSedutaPeer::DATA, $gruppo->getDataFine(), Criteria::LESS_EQUAL);
        $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $gruppo->getGruppoId(), Criteria::EQUAL);
          
        $voti_gruppo = OppVotazioneHasGruppoPeer::doSelect($c);
        foreach($voti_gruppo as $voto_gruppo)
       
          {
          	
            $c = new Criteria();
            $c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $voto_gruppo->getVotazioneId(), Criteria::EQUAL);
            $c->add(OppVotazioneHasCaricaPeer::CARICA_ID, $carica->getId(), Criteria::EQUAL);
            $voti_carica = OppVotazioneHasCaricaPeer::doSelect($c);
            foreach($voti_carica as $voto_carica)
            {
<<<<<<< .mine
              if ($voto_carica->getVoto()=='Favorevole' || $voto_carica->getVoto()=='Astenuto' || $voto_carica->getVoto()=='Contrario' || $voto_carica->getVoto()=='Voto segreto')
=======
              if($voto_carica->getVoto()=='Favorevole' || $voto_carica->getVoto()=='Astenuto' || $voto_carica->getVoto()=='Contrario' || $voto_carica->getVoto()=='Voto segreto')
>>>>>>> .r576
                {
                
                  if ($voto_carica->getVoto()!==$voto_gruppo->getVoto() && $voto_gruppo->getVoto()!='nv' && $voto_carica->getVoto()!='Voto segreto')
                    {
                      $cont=$cont+1;
                      echo $voto_carica->getVotazioneId()."\n";
                    }
                  $cont_votazioni=$cont_votazioni+1;
               }
             }
           }  
         $gruppo->setRibelle($cont);
         $gruppo->setPresenze($cont_votazioni);
         $gruppo->save();
         echo $cont." ".$cont_votazioni."\n";
       }  
       
    $c = new Criteria();
    $c->add(OppCaricaHasGruppoPeer::CARICA_ID, $carica->getId());
    $gruppi = OppCaricaHasGruppoPeer::doSelect($c);
    $ribelle=0;
    foreach ($gruppi as $gruppo) 
    {
	    $ribelle=$ribelle+$gruppo->getRibelle();	
    }
     $carica->setRibelle($ribelle);
     $carica->save();  
  }             
                
    
    

mail("e.dicesare@depp.it", "OK - Update Ribellioni", "aggiornamento a buon fine", "From: BatchOpp");	

?>
