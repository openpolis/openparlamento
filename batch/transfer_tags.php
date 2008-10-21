<?php
/**
 * Created on 21 oct 2008
 *
 *
 * transferisce i tag da opp_teseo a sf_tag
 *
 *
 * sintassi: 
 *  php batch/transfer_tags.php
 * 
 * Author Guglielmo Celata
 */
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c = new Criteria();
$teseo_tags = OppTeseoPeer::doSelect($c);
foreach ($teseo_tags as $teseo_tag)
{
  $teseo_tag_id = $teseo_tag->getId();
  $teseo_tag_value = trim($teseo_tag->getDenominazione());
  $teseo_tag_tipo_id = $teseo_tag->getTipoTeseoId();
  
  if ($teseo_tag_tipo_id == 0) continue;
  
  $teseo_tag_tipo = OppTipoTeseoPeer::retrieveByPK($teseo_tag_tipo_id);
  $teseo_tag_tipo_name = $teseo_tag_tipo->getTipo();
  
  echo $teseo_tag_id . ": " . $teseo_tag_value . "\n";
  $sfTag = TagPeer::retrieveOrCreateByTagname("$teseo_tag_tipo_name:$teseo_tag_id=$teseo_tag_value");    
  $sfTag->save();
  foreach ($teseo_tag->getOppTeseoHasTeseotts() as $teseo_tt)
  {
    $tt_id = $teseo_tt->getOppTeseott()->getId();
    $tt_denominazione = $teseo_tt->getOppTeseott()->getDenominazione();
    echo "  TT" . $tt_id . ": " . $tt_denominazione . "\n";
    $tt = OppTagHasTtPeer::retrieveByPK($sfTag->getId(), $tt_id);
    if (!$tt instanceof OppTagHasTt) 
    {
      $tt = new OppTagHasTt();
    }
    $tt->setTagId($sfTag->getId());
    $tt->setTeseoTtId($tt_id);
    $tt->save();
  }
  foreach ($teseo_tag->getOppAttoHasTeseos() as $atto_tag)
  {
    if (!$atto_tag->getOppAtto() instanceof OppAtto) continue;
    $atto_id = $atto_tag->getOppAtto()->getId();
    $taggable_model = 'OppAtto';
    echo "   A" . $atto_id . ": " . substr($atto_tag->getOppAtto()->getTitolo(), 0, 80) . "\n";
    $atto_has_tag = TaggingPeer::retrieveByTagAndTaggable($sfTag->getId(), $atto_id, $taggable_model);
    if (!$atto_has_tag instanceof Tagging)
    {
      $atto_has_tag = new Tagging();
    }
    $atto_has_tag->setTagId($sfTag->getId());
    $atto_has_tag->setTaggableId($atto_id);
    $atto_has_tag->setTaggableModel($taggable_model);
    $atto_has_tag->save();
  }
}

?>