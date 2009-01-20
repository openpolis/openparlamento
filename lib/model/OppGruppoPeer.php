<?php

/**
 * Subclass for performing query and update operations on the 'opp_gruppo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppGruppoPeer extends BaseOppGruppoPeer
{
  /**
   * returns the groups in the given ramo (and for the given legislatura) and include the zero value, if given
   *
   * @param string $ramo 
   * @param int    $legislatura
   * @param string $include_zero 
   * @return an associative array, with id and name as key => value
   * @author Guglielmo Celata
   */
  public static function getAllGroups($ramo, $legislatura, $include_zero = false)
  { 
    $c = new Criteria();
    if ($ramo == 'camera')
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
    else
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(4, 5), Criteria::IN);
    
    $c->addJoin(OppGruppoPeer::ID, OppCaricaHasGruppoPeer::GRUPPO_ID);
    $c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID);
    $c_or_leg = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $legislatura);
    $c_or_leg->addOr($c->getNewCriterion(OppCaricaPeer::LEGISLATURA, null, Criteria::ISNULL));
    $c->add($c_or_leg);
    
    $c->clearSelectColumns();
    $c->addSelectColumn(OppGruppoPeer::ID);
    $c->addSelectColumn(OppGruppoPeer::NOME);
    $c->setDistinct();
    
    $rs = OppGruppoPeer::doSelectRS($c);
    if ($include_zero)
      $all_groups = array('0' => $include_zero);
    else
      $all_groups = array();
      
    while ($rs->next())
    {
      $all_groups[$rs->getInt(1)]= $rs->getString(2);
    }

    return $all_groups;
  }
}
