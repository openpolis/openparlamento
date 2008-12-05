<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Sets the values of the cache fields (stato_cod, stato_fase, stato_last_date)
 * for the opp_atto table, starting from the already inserted opp_atto_has_iter files
 *
 * This can also be used to re-create the cache
 */
?>
<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();


$attos = OppAttoPeer::doSelect(new Criteria());

$cnt = 0;
foreach ($attos as $atto)
{
  $cnt++;
  $iter_steps = $atto->getOppAttoHasIters();
  echo "$cnt) " . $atto->getId() . "(" . count($iter_steps) . ")\n";
  foreach ($iter_steps as $step)
  {
    $step->save();
  }
}
echo "$cnt total\n";

