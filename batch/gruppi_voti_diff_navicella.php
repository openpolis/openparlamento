<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Add created_at informations to the sf_tagging table
 * the field takes a value equal to a random timestamp between 3 and 9 hours after
 * the creation of the tagged object's creation date
 *
 */
?>
<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();


$c = new Criteria();
$c->addJoin(OppVotazionePeer::ID, OppVotazioneHasAttoPeer::VOTAZIONE_ID);
$c->addJoin(OppVotazionePeer::ID, OppVotazioneHasGruppoPeer::VOTAZIONE_ID);
$c->addJoin(OppAttoPeer::ID, OppAttoHasIterPeer::ATTO_ID);
$c->add(OppAttoHasIterPeer::ITER_ID, 16);
$c->add(OppVotazionePeer::FINALE, 1);
$c->add(OppAttoPeer::TIPO_ATTO_ID, 1);
$results= OppVotazioneHasGruppoPeer::doSelect($c);
foreach ($results as $r)
{
	echo $r->getGruppoId()."-".$r->getVoto()."\n";
	//.$r->getOppVotazione()->$r->getOppVotazioneHasAtto()->getOppAtto()->getId();
}
