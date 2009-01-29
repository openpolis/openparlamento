<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n\n");

$leg=16;

$c = new Criteria();
$crit0 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 1);
$crit1 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 4);
$crit2 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 5);

$crit0->addOr($crit1);
$crit0->addOr($crit2);
$c->add($crit0);
$c->add(OppCaricaPeer::LEGISLATURA, $leg, Criteria::EQUAL);
$c->add(OppCaricaPeer::ID, 332634, Criteria::EQUAL);
$cariche = OppCaricaPeer::doSelect($c);

foreach($cariche as $carica)
  {  
    
    $parlamentare = OppPoliticoPeer::RetrieveByPk($carica->getPoliticoId());
  
    $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($carica->getId());
    
    $id_gruppo = array();
    
    foreach($gruppi as $nome => $gruppo)
    {
  	  array_push($id_gruppo, $gruppo['gruppo_id']);
  	   	  
  	  $data_inizio=split("/", $gruppo['data_inizio']);
	  $di = "20".$data_inizio[2]."-".$data_inizio[0]."-".$data_inizio[1];
	  
	  if($gruppo['data_fine']!='')
	  {
	    $data_fine=split("/", $gruppo['data_fine']);
	    $df = "20".$data_fine[2]."-".$data_fine[0]."-".$data_fine[1];
	  }
	  else
	    $df='';
	
	  //CALCOLO VOTO GRUPPO
	  $c = new Criteria();
	  $c->clearSelectColumns();
	  $c->addSelectColumn(OppVotazioneHasGruppoPeer::VOTAZIONE_ID);
	  $c->addSelectColumn(OppVotazioneHasGruppoPeer::VOTO);
	  $c->addJoin(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, OppVotazionePeer::ID, Criteria::LEFT_JOIN);
	  $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID, Criteria::LEFT_JOIN);
	  $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $gruppo['gruppo_id'], Criteria::EQUAL);
      
	  if($df!='') 
	  {  
		$cton1 = $c->getNewCriterion(OppSedutaPeer::DATA, $gruppo['data_inizio'], Criteria::GREATER_EQUAL);
	    $cton2 = $c->getNewCriterion(OppSedutaPeer::DATA, $gruppo['data_fine'], Criteria::LESS_EQUAL);
        $cton1->addAnd($cton2);
        $c->add($cton1);
	  }
	  else
	    $c->add(OppSedutaPeer::DATA, $di, Criteria::GREATER_EQUAL);
     	  
	  $rs = OppVotazioneHasGruppoPeer::doSelectRS($c);
	  
	  $voto_gruppo = array();
	  
	  while ($rs->next())
      {
	    $voto_gruppo[$rs->getInt(1)] = $rs->getString(2);  
	  }
	  
	  //CALCOLO VOTO CARICA
	  $c = new Criteria();
	  $c->clearSelectColumns();
	  $c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTAZIONE_ID);
	  $c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
	  $c->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, OppVotazionePeer::ID, Criteria::LEFT_JOIN);
	  $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID, Criteria::LEFT_JOIN);
	  $c->add(OppVotazioneHasCaricaPeer::CARICA_ID, $carica->getId(), Criteria::EQUAL);
      if($df!='') 
	  {  
		$cton1 = $c->getNewCriterion(OppSedutaPeer::DATA, $gruppo['data_inizio'], Criteria::GREATER_EQUAL);
	    $cton2 = $c->getNewCriterion(OppSedutaPeer::DATA, $gruppo['data_fine'], Criteria::LESS_EQUAL);
        $cton1->addAnd($cton2);
        $c->add($cton1);
	  }
	  else
	    $c->add(OppSedutaPeer::DATA, $di, Criteria::GREATER_EQUAL);
	  
	  $rs = OppVotazioneHasCaricaPeer::doSelectRS($c);
	  
	  $voto_carica = array();
	  
	  while ($rs->next())
      {
	    $voto_carica[$rs->getInt(1)] = $rs->getString(2);  
	  }
	  
	  $cont = 0;
	  $cont_pres=0;
	  $zio=0;
	  
	  foreach ($voto_gruppo as $indice => $voto)
	  {
	  
	    //nel caso di gruppo misto il calcolo non viene fatto
	    if( !(in_array( '13', $id_gruppo )) )
	    {
	      // calcolo le presenze
              if($voto_carica[$indice]=='Favorevole' || $voto_carica[$indice]=='Astenuto' || $voto_carica[$indice]=='Contrario')
              {
              	$cont_pres=$cont_pres+1;
              }	 
	      if(isset($voto_carica[$indice]) 
		    && ($voto=='Favorevole' || $voto=='Astenuto' || $voto=='Contrario' ) 
		    && $voto!=$voto_carica[$indice])
		  {  
		    if($voto_carica[$indice]=='Favorevole' || $voto_carica[$indice]=='Astenuto' || $voto_carica[$indice]=='Contrario')
		    {
		      $cont = $cont+1;
		      //echo "votazione: ".$indice." voto gruppo: ".$voto." voto carica: ".$voto_carica[$indice]."<br />";
		    }
		  }
               }

	     }
	  
	  $c = new Criteria();
	  $c->add(OppCaricaHasGruppoPeer::CARICA_ID, $carica->getId(), Criteria::EQUAL);
	  $c->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $gruppo['gruppo_id'], Criteria::EQUAL);
	  $carica_gruppo = OppCaricaHasGruppoPeer::doSelectOne($c);
	  
	  $carica_gruppo->setRibelle($cont);
	  $carica_gruppo->setPresenze($cont_pres);
	  $carica_gruppo->save();
	  
	  print $di.' / '.$df.' => '.$nome." (id: ".$gruppo['gruppo_id'].") ribellioni:".$cont." voti nel gruppo: ".$cont_pres."\n";
	}	
     
  }	

print("scrivo nel campo ribelle in opp_carica \n");

$c = new Criteria();
$crit0 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $leg);
$crit1 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 1);
$crit2 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 4);
$crit1->addOr($crit2);
$crit0->addAnd($crit1);
$c->add($crit0);
$deputati = OppCaricaPeer::doSelect($c);

foreach ($deputati as $deputato) {

	$c = new Criteria();
	$c->add(OppCaricaHasGruppoPeer::CARICA_ID, $deputato->getId());
	$gruppi = OppCaricaHasGruppoPeer::doSelect($c);
	$ribelle=0;
	foreach ($gruppi as $gruppo) {
		$ribelle=$ribelle+$gruppo->getRibelle(); 
		
	}
	$deputato->setRibelle($ribelle);
	$deputato->save();
	//echo $deputato->getOppPolitico()->getCognome()." - ".$ribelle."\n";
}
  
print("done.\n");

mail("e.dicesare@depp.it", "OK - Update Ribellioni", "aggiornamento a buon fine", "From: BatchOpp");	

?>