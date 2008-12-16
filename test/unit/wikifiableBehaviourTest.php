<?php

define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'test');
define('SF_DEBUG',       true);

include(dirname(__FILE__).'/../bootstrap/unit.php'); 

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$t = new lime_test(16, new lime_output_color());

$t->diag('unit test to verify the mechanisms of wiki descriptions automatic creation and removal');

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
$c->add(OppVotazionePeer::NUMERO_VOTAZIONE, 999999);
$existing_records = OppVotazionePeer::doSelect($c);
foreach ($existing_records as $rec) 
{
  $t->diag('Cleaning record ' . get_class($rec) . "(". $rec->getId() . ")");
  $rec->delete();
}


$t->diag('Create the act object');
$obj_atto = new OppAtto();
$obj_atto->setTipoAttoId(1);
$obj_atto->setParlamentoId(999999);
$obj_atto->setDataPres('2008-11-01');
$obj_atto->setDescrizione("Un'atto di test");
$obj_atto->save();
$prefix = sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_prefix', 
                                get_class($obj_atto)));
$t->ok($prefix == 'atto', 'The prefix was correctly read from the behavior configuration');
$wiki_page = nahoWikiPagePeer::retrieveByName($prefix . "_" . $obj_atto->getId());
$t->ok($wiki_page instanceof nahoWikiPage, 'a wiki page was just created for this object');
$c = new Criteria();
$c->add(nahoWikiRevisionPeer::REVISION, 1);
$wiki_revisions = $wiki_page->getRevisions($c);
$wiki_revision = $wiki_revisions[0];
$t->ok(count($wiki_revisions) == 1 && 
       $wiki_revision instanceof nahoWikiRevision, 'a wiki revision was added');
$wiki_content = $wiki_revision->getnahoWikiContent();
$t->ok($wiki_content instanceof nahoWikiContent, 'a wiki content was also added');

$t->ok($wiki_revision->getComment()=='Creazione Automatica' &&
      $wiki_revision->getContent()=='Descrizione wiki, a cura degli utenti.',
      'comment and content were correctly inserted');

$atto_page_id = $wiki_page->getId();
$atto_revision_num = $wiki_revision->getRevision();
$atto_content_id = $wiki_content->getId();



$t->diag('Create the votation object');
$obj_votazione = new OppVotazione();
$obj_votazione->setSedutaId(2950);
$obj_votazione->setNumeroVotazione(999999);
$obj_votazione->setTitolo('Una votazione di test');
$obj_votazione->save();
$prefix = sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_prefix', 
                               get_class($obj_votazione)));
$t->ok($prefix == 'votazione', 'The prefix was correctly read from the behavior configuration');
$wiki_page = nahoWikiPagePeer::retrieveByName($prefix . "_" . $obj_votazione->getId());
$t->ok($wiki_page instanceof nahoWikiPage, 'a wiki page was just created for this object');
$c = new Criteria();
$c->add(nahoWikiRevisionPeer::REVISION, 1);
$wiki_revisions = $wiki_page->getRevisions($c);
$wiki_revision = $wiki_revisions[0];
$t->ok(count($wiki_revisions) == 1 && 
       $wiki_revision instanceof nahoWikiRevision, 'a wiki revision was added');
$wiki_content = $wiki_revision->getnahoWikiContent();
$t->ok($wiki_content instanceof nahoWikiContent, 'a wiki content was also added');

$t->ok($wiki_revision->getComment()=='Creazione Automatica' &&
      $wiki_revision->getContent()=='Descrizione wiki, a cura degli utenti.',
      'comment and content were correctly inserted');

$votazione_page_id = $wiki_page->getId();
$votazione_revision_num = $wiki_revision->getRevision();
$votazione_content_id = $wiki_content->getId();
       

$t->diag('Remove the act object');
$obj_atto->delete();

$wiki_page = nahoWikiPagePeer::retrieveByPK($atto_page_id);
$t->ok(!$wiki_page instanceof nahoWikiPage, 'the wiki page was removed');
$wiki_revision = nahoWikiRevisionPeer::retrieveByPK($atto_page_id, $atto_revision_num, $atto_content_id);
$t->ok(!$wiki_revision instanceof nahoWikiRevision, 'the wiki revision was removed');
$wiki_content = nahoWikiContentPeer::retrieveByPK($atto_content_id);
$t->ok($wiki_content instanceof nahoWikiContent, 'the wiki content was NOT removed');



$t->diag('Remove the votation object');
$obj_votazione->delete();

$wiki_page = nahoWikiPagePeer::retrieveByPK($votazione_page_id);
$t->ok(!$wiki_page instanceof nahoWikiPage, 'the wiki page was removed');
$wiki_revision = nahoWikiRevisionPeer::retrieveByPK($votazione_page_id, $votazione_revision_num, $votazione_content_id);
$t->ok(!$wiki_revision instanceof nahoWikiRevision, 'the wiki revision was removed');
$wiki_content = nahoWikiContentPeer::retrieveByPK($votazione_content_id);
$t->ok($wiki_content instanceof nahoWikiContent, 'the wiki content was NOT removed');
