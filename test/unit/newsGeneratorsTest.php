<?php

define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'test');
define('SF_DEBUG',       true);

include(dirname(__FILE__).'/../bootstrap/unit.php'); 

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$t = new lime_test(31, new lime_output_color());

$t->diag('unit test to verify the mechanisms of news generation');


$t->diag('Tests beginning');

// clean the database
$t->diag('Cleaning previously created test records');
$c = new Criteria();
$c->add(OppAttoPeer::PARLAMENTO_ID, 999999);
$existing_records = OppAttoPeer::doSelect($c);
foreach ($existing_records as $rec) 
{
  $t->diag('Cleaning record ' . get_class($rec) . "(". $rec->getId() . ")");
  $rec->delete();
}
$c = new Criteria();
$c->add(OppPoliticoPeer::ID, 999999);
$existing_records = OppPoliticoPeer::doSelect($c);
foreach ($existing_records as $rec) 
{
  $t->diag('Cleaning record ' . get_class($rec) . "(". $rec->getId() . ")");
  $rec->delete();
}



$t->diag('Create the act object');
$obj = new OppAtto();
$obj->setTipoAttoId(1);
$obj->setParlamentoId(999999);
$obj->setRamo('S');
$obj->setNumFase(914);
$obj->setDataPres('2008-11-01');
$obj->setDescrizione("Una descrizione di prova");
$obj->save();

$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$first_news = $related_news[0]; 
$t->ok($n_related_news == 1, 'One news related to the act was generated');
dumpNews($t, "news related to the act", $related_news);

$t->diag('Testing the content of the news');
$t->ok($first_news->getRelatedMonitorableModel() == 'OppAtto' &&
       $first_news->getRelatedMonitorableId() == $obj->getId(), 'RelatedMonitorableModel');
$t->ok($first_news->getPriority() == 1, 'Priority');
$t->ok($first_news->getDate('Y-m-d') == $obj->getDataPres('Y-m-d'), 'Date');
$t->ok($first_news->getTipoAttoId() == 1, 'TipoAtto');
$t->ok($first_news->getDataPresentazioneAtto('Y-m-d') == $obj->getDataPres('Y-m-d'), 'DataPresentazioneAtto');
$t->ok($first_news->getCreatedAt() == $obj->getCreatedAt(), 'CreatedAt');

$t->diag('Create a non-final votation: two more news expected (group and detail)');
$vot = OppVotazionePeer::retrieveByPK(9900);

$vot_att = new OppVotazioneHasAtto();
$vot_att->setOppVotazione($vot);
$vot_att->setOppAtto($obj);
$vot_att->save();
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$t->ok($n_related_news == 3, 'Now there are two more news related to the act');
dumpNews($t, "news related to the act", $related_news);

$t->diag('Test if group news were created');
$seduta = $vot->getOppSeduta();
$data = $seduta->getData();
$ramo = $seduta->getRamo();

$t->ok(NewsPeer::hasGroupVotation($data, $ramo, $obj->getOppTipoAtto()->getId()) == true, 'Group news of Home rilevance');
$t->ok(NewsPeer::hasGroupVotation($data, $ramo, $obj->getOppTipoAtto()->getId()) == true, 'Group news of List relevance');
$t->ok(NewsPeer::hasGroupVotation($data, $ramo, $obj->getOppTipoAtto()->getId(), $obj->getId()) == true, 'Group news, of Single relevance, related to the act');

$t->diag('Create another non-final votation on the same act, the same day');
$vot = OppVotazionePeer::retrieveByPK(9901);
$vot_att = new OppVotazioneHasAtto();
$vot_att->setOppVotazione($vot);
$vot_att->setOppAtto($obj);
$vot_att->save();
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$t->ok($n_related_news == 4, 'Now there is a news more');
dumpNews($t, "news related to the act", $related_news);

$t->diag('Create a final votation, the same day');
$vot = OppVotazionePeer::retrieveByPK(9925);
$vot_att = new OppVotazioneHasAtto();
$vot_att->setOppVotazione($vot);
$vot_att->setOppAtto($obj);
$vot_att->save();
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$t->ok($n_related_news == 5, 'There are now 5 related news now');
dumpNews($t, "news related to the act", $related_news);

$t->diag('Create a document');
$doc = new OppDocumento();
$doc->setData('2008-11-20');
$doc->setTitolo('Titolo di prova');
$doc->setOppAtto($obj);
$doc->save();
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$t->ok($n_related_news == 6, 'Six related news');
dumpNews($t, "news related to the act", $related_news);

$t->diag('Add a non-conclusive iter step');
$iter = OppIterPeer::retrieveByPK(29);
$iter_att = new OppAttoHasIter();
$iter_att->setOppAtto($obj);
$iter_att->setOppIter($iter);
$iter_att->save();
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$generated_news = $iter_att->getGeneratedNews();
$first_generated = $generated_news[0];
$t->ok($n_related_news == 7, 'Seven related news');
$t->ok($first_generated->getPriority() == 2, 'Priority for non-conclusive iter step is ' . $first_generated->getPriority());
dumpNews($t, "news related to the act", $related_news);

$t->diag('Add a conclusive iter step');
$iter = OppIterPeer::retrieveByPK(45);
$iter_att = new OppAttoHasIter();
$iter_att->setOppAtto($obj);
$iter_att->setOppIter($iter);
$iter_att->save();
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$generated_news = $iter_att->getGeneratedNews();
$first_generated = $generated_news[0];
$t->ok($n_related_news == 8, 'Eight related news');
$t->ok($first_generated->getPriority() == 1, 'Priority for conclusive iter step is ' . $first_generated->getPriority());
dumpNews($t, "news related to the act", $related_news);

$t->diag('Add a new assignment to a commission');
$sede = OppSedePeer::retrieveByPK(24);
$sede_att = new OppAttoHasSede();
$sede_att->setOppAtto($obj);
$sede_att->setOppSede($sede);
$sede_att->save();
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$t->ok($n_related_news == 9, 'Nine related news');
dumpNews($t, "news related to the act", $related_news);

$t->diag('Add a new politician');
$pol = new OppPolitico();
$pol->setNome('Guglielmo');
$pol->setCognome('Celata');
$pol->setId(999999);
$pol->save();

$t->diag('Add a new charge');
$car = new OppCarica();
$car->setId(999999);
$car->setOppPolitico($pol);
$car->setTipoCaricaId(2);
$car->setCarica('Ministro dell\'abolizione dei beni Inutili');
$car->setDataInizio('2008-10-10');
$car->save();
$pol_related_news = getRelatedNews($pol);
$n_pol_related_news = count($pol_related_news);
$t->diag("related_news: ".$n_pol_related_news);
$t->ok($n_pol_related_news == 1, 'One news related to the politician');
dumpNews($t, "news related to the politician", $pol_related_news);

$t->diag('Add a group to the charge');
$gruppo = OppGruppoPeer::retrieveByPK(1);
$car_gruppo = new OppCaricaHasGruppo();
$car_gruppo->setOppCarica($car);
$car_gruppo->setOppGruppo($gruppo);
$car_gruppo->setDataInizio('2008-08-20');
$car_gruppo->save();
$pol_related_news = getRelatedNews($pol);
$n_pol_related_news = count($pol_related_news);
$t->ok($n_pol_related_news == 2, 'Two news related to the politician');
dumpNews($t, "news related to the politician", $pol_related_news);


$t->diag('Add a first-signer, at the presentation date');
$firma = new OppCaricaHasAtto();
$firma->setTipo('P');
$firma->setOppCarica($car);
$firma->setOppAtto($obj);
$firma->setData($obj->getDataPres());
$firma->save();
$pol_related_news = getRelatedNews($pol);
$n_pol_related_news = count($pol_related_news);
$t->ok($n_pol_related_news == 3, 'Three news related to the politician');
dumpNews($t, "news related to the politician", $pol_related_news);
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$t->ok($n_related_news == 9, 'Nine news related to the act (no new news)');
dumpNews($t, "news related to the act", $related_news);

$t->diag('Add a co-signer, at the presentation date + 1');
$firma = new OppCaricaHasAtto();
$firma->setTipo('C');
$firma->setOppCarica($car);
$firma->setOppAtto($obj);
$firma->setData('2008-11-02');
$firma->save();
$pol_related_news = getRelatedNews($pol);
$n_pol_related_news = count($pol_related_news);
$t->ok($n_pol_related_news == 4, 'Four news related to the politician');
dumpNews($t, "news related to the politician", $pol_related_news);
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$t->ok($n_related_news == 10, 'Ten news related to the act');
dumpNews($t, "news related to the act", $related_news);


$t->diag('Get a site');
$sede = OppSedePeer::retrieveByPK(11);

$t->diag('Add an intervention on the act by the politician');
$int = new OppIntervento();
$int->setData('2008-11-20');
$int->setOppCarica($car);
$int->setOppSede($sede);
$int->setOppAtto($obj);
$int->save();
$pol_related_news = getRelatedNews($pol);
$n_pol_related_news = count($pol_related_news);
$t->ok($n_pol_related_news == 5, 'Five news related to the politician');
dumpNews($t, "news related to the politician", $pol_related_news);
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$t->ok($n_related_news == 12, 'Twelve news related to the act (two more, detailed and group)');
dumpNews($t, "news related to the act", $related_news);

$t->diag('Add a change in succ field value for the act');
$obj->setSucc(33712);
$obj->save();
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$t->ok($n_related_news == 13, 'Thirteen news related to the act (a weird news)');
dumpNews($t, "news related to the act", $related_news);

$t->diag('Add three different tags to the object');
$tagging_ar = array();
foreach (array(3, 4, 5) as $tag_id) {
  $tagging = new Tagging();
  $tagging->setTaggableModel('OppAtto');
  $tagging->setTaggableId($obj->getId());
  $tagging->setTagId($tag_id);
  $tagging->save();
  $tagging_ar []= $tagging;
}
$related_news = getRelatedNews($obj);
$n_related_news = count($related_news);
$t->ok($n_related_news == 16, 'Sixteen news related to the act (three with tag_id not null)');
dumpNews($t, "news related to the act", $related_news);

$t->diag('Remove the act, taggings and pol object');
$pol->delete();

$pol_related_news = getRelatedNews($pol);
$n_pol_related_news = count($pol_related_news);
$t->ok($n_pol_related_news == 0, 'news related to the politician were zapped');

$obj->delete();
$related_news = getRelatedNews($obj);
$t->ok(count($related_news) == 0, 'news related to the test act were zapped');

foreach ($tagging_ar as $tagging) {
  $tagging->delete();
}

function dumpNews($t, $msg, $news_to_dump)
{
  $t->diag($msg);
  $t->diag(str_repeat("=", strlen($msg)));
  $t->diag(sprintf("%-6s %-10s %-20s %-54s %-8s %1s %-6s %-10s %-4s %6d %-16s", 
                   "Id", "RelModel", "GeneratorModel", "GeneratorPKs", "Date", "P", "Succ", "DataPres", "Ramo", "TagID", "CreatedAt"));
  foreach ($news_to_dump as $news)
  {
    $t->diag(sprintf("%-6d %-10s %-20s %-54s %-8s %1d %6d %-10s %-4s %6d %-16s", 
                     $news->getId(), 
                     $news->getRelatedMonitorableModel(),
                     $news->getGeneratorModel(), substr($news->getGeneratorPrimaryKeys(), 0, 100),
                     $news->getDate('Ymd'), $news->getPriority(),
                     $news->getSucc(), $news->getDataPresentazioneAtto('Ymd'), 
                     $news->getRamoVotazione(), $news->getTagId(), $news->getCreatedAt('Ymd h:i')));
  }
  $t->diag("");
  
}

/**
 * get all the news in sf_news_cache, related to a given object
 *
 * @return array of News objects
 * @author Guglielmo Celata
 **/
function getRelatedNews($obj)
{
  $c = new Criteria();
  $c->add(NewsPeer::RELATED_MONITORABLE_MODEL, get_class($obj));
  $c->add(NewsPeer::RELATED_MONITORABLE_ID, $obj->getPrimaryKey());
  $related_news = NewsPeer::doSelect($c);
  return $related_news;
}

