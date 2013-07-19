<?php

/**
 * Subclass for performing query and update operations on the 'opp_chg_incarico' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppChgIncaricoPeer extends BaseOppChgIncaricoPeer
{

  public static function getIncaricoGruppoCorrente($carica_id, $gruppo_id)
  {
    $c=new Criteria();
    $c->add(OppCaricaHasGruppoPeer::CARICA_ID,$carica_id);
    $c->add(OppCaricaHasGruppoPeer::GRUPPO_ID,$gruppo_id);
    $c->add(OppCaricaHasGruppoPeer::DATA_FINE, NULL, Criteria::ISNULL);
    $g=OppCaricaHasGruppoPeer::doSelectOne($c);
    if ($g)
    {
      $c1=new Criteria();
      $c1->add(self::CHG_ID, $g->getId());
      $c1->add(self::DATA_FINE, NULL, Criteria::ISNULL);
      $incarico=self::doSelectOne($c1);
      if ($incarico)
        return $incarico->getIncarico();
      else
        return NULL;
    }
  }
}
