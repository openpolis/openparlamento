<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2009 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false); 

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

echo "starting\n";

$con = Propel::getConnection(TagPeer::DATABASE_NAME);
$c = new Criteria(TagPeer::DATABASE_NAME);
$argomenti = TagPeer::doSelect($c, $con);

$ninterventi_tot = 0;
$ninterventi_max = 0;
foreach ($argomenti as $a)
{
  echo $a->getTripleValue() . ": " ;
  $c = new Criteria(TagPeer::DATABASE_NAME);
  $c->addJoin(OppInterventoPeer::ATTO_ID, OppAttoPeer::ID);
  $c->addJoin(TaggingPeer::TAGGABLE_ID, OppAttoPeer::ID);
  $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
  $c->add(TaggingPeer::TAG_ID, $a->getId());
  $ninterventi = OppInterventoPeer::doCount($c, $con);
  $ninterventi_tot += $ninterventi;
  if ($ninterventi > $ninterventi_max) $ninterventi_max = $ninterventi;
  echo " $ninterventi ($ninterventi_max)\n";
}

$ninterventi_avg = $ninterventi_tot / count($argomenti);

echo "found:\n";
printf("n_interventi_max: $ninterventi_max, n_interventi_tot: $ninterventi_tot, n_interventi_avg: $ninterventi_avg\n");

echo "storing in the supra storage\n";
sfSupra::setVariable('numero_interventi_max', $ninterventi_max);
sfSupra::setVariable('numero_interventi_tot', $ninterventi_tot);
sfSupra::setVariable('numero_interventi_avg', $ninterventi_avg);
echo "done\n";



