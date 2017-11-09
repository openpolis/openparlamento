<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$tu=array();
$atti_finali=array();
$leggi=array();

$leggi_totali="Data_approvazione_legge;Numfase;Titolo;openpolis_id;Primi fimatari (Cognome Nome, Gruppo)\n";
$leggi_no_voto_gruppo_pf="Data_approvazione_legge;Numfase;Titolo;openpolis_id;Primi fimatari (Cognome Nome, Gruppo)\n";

$c= new Criteria();
$c->add(OppRelazioneAttoPeer::TIPO_RELAZIONE_ID,1);
$results=OppRelazioneAttoPeer::doSelect($c);

foreach ($results as $r)
{
	$atto=OppAttoPeer::retrieveByPK($r->getAttoToId());
	if (!in_array($atto,$tu))
		$tu[]= $atto;
}
foreach ($tu as $t)
{
	$atto=$t;
	while ($atto->getSucc()!=NULL)
	{
		$atto = OppAttoPeer::retrieveByPK($atto->getSucc());
	}
	$atti_finali[]=$atto;
}

print count($atti_finali)."\n";

foreach ($atti_finali as $f)
{
	if ($f->getStatoFase()=="approvato definitivamente. Legge" or $f->getStatoFase()=="approvato definitivamente. Non ancora pubblicato")
	{
		if (!in_array($f,$leggi))
			$leggi[]=$f;
	}
}

print count($leggi)."\n";

foreach ($leggi as $l)
{
	$ctrl=0;
	$c = new Criteria();
	$c->addJoin(OppAttoPeer::ID, OppCaricaHasAttoPeer::ATTO_ID);
	$c->addJoin(OppCaricaPeer::ID, OppCaricaHasAttoPeer::CARICA_ID);
	$c->add(OppAttoPeer::ID, $l->getId());
	$c->add(OppCaricaHasAttoPeer::TIPO,'P');
	$carica=OppCaricaPeer::doSelect($c);
	$politici='';
	foreach ($carica as $p)
	{
		$gruppo=OppCaricaHasGruppoPeer::getGruppoPerParlamentareAllaData($p->getId(), $l->getStatoLastDate());
		if (count($gruppo)>0)
		{
			$politici=$politici."|".$p->getOppPolitico()->getCognome()." ".$p->getOppPolitico()->getNome().", ".OppGruppoPeer::retrieveByPk($gruppo['gruppo_id'])->getNome();
			$c = new Criteria();
			$c->addJoin(OppVotazioneHasAttoPeer::VOTAZIONE_ID, OppVotazionePeer::ID);
			$c->add(OppVotazioneHasAttoPeer::ATTO_ID, $l->getId());
			$c->add(OppVotazionePeer::FINALE, 1);
			$votazione=OppVotazionePeer::doSelectOne($c);
			if ($votazione)
			{
				$c = new Criteria();
				$c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $gruppo['gruppo_id']);
				$c->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $votazione->getId());
				$voto=OppVotazioneHasGruppoPeer::doSelectOne($c);
				if ($voto)
				{
					if ($voto->getVoto()!='Favorevole')
						$ctrl=1;
				}
				else
					print "!!! no voto gruppo per votazione id=".$votazione->getId()." e gruppo id=".$gruppo['gruppo_id']."\n";
			}
			else
				print "!!! no votazione finale per ddl id=".$l->getId()."\n";
		}
		else
			$politici=$politici."|".$p->getOppPolitico()->getCognome()." ".$p->getOppPolitico()->getNome();
	}
	$leggi_totali = $leggi_totali . $l->getStatoLastDate().";".$l->getRamo().".".$l->getNumfase().";".$l->getTitolo().";".$l->getId().";".trim($politici,"|")."\n";
	if ($ctrl==1)
		$leggi_no_voto_gruppo_pf= $leggi_no_voto_gruppo_pf . $l->getStatoLastDate().";".$l->getRamo().".".$l->getNumfase().";".$l->getTitolo().";".$l->getId().";".trim($politici,"|")."\n";
}

print $leggi_totali;
?>