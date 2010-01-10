<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * find all opp_atto records with a null created_at field and set it to
 * a value equal to a random timestamp between 6 hours and 5 days after
 * the presentation's date (data_pres field)
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

/*
  duplica le notizie generate dal Tagging, relative a un OppAtto
  per ogni notizia, genera una notizia relativa a Tag, con data equivalente
  in questo modo, l'estrazione di notizie relative a un tag è semplificata
*/

echo "Fetching news to duplicate\n";
$c = new Criteria();
$c->add(NewsPeer::GENERATOR_MODEL, 'Tagging');
$c->add(NewsPeer::RELATED_MONITORABLE_MODEL, 'OppAtto');
$news = NewsPeer::doSelect($c);

echo "Found " . count($news) . " news\n";
foreach ($news as $i => $n) {
  $nn = new News();
  $nn->setGeneratorModel($n->getGeneratorModel());
  $nn->setGeneratorPrimaryKeys($n->getGeneratorPrimaryKeys());
  $nn->setRelatedMonitorableModel('Tag');
  $nn->setRelatedMonitorableId($n->getTagId());
  $nn->setCreatedAt($n->getCreatedAt());
  $nn->setDate($n->getDate());
  $nn->setPriority(1);
  $nn->setTagId($n->getTagId());
  $nn->save();
  
  if ($i % 100 == 0) echo $i . " ";
}
  
echo "\n$i news processed and fixed\n";
