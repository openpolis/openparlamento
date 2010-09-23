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
   * torna array di OppGruppo a partire da un array di ID
   *
   * @param array $ids 
   * @return array of OppGruppo
   * @author Guglielmo Celata
   */
  public function getRSFromIDArray($ids, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

    $sql = sprintf("select g.id, g.nome, g.acronimo from opp_gruppo g where g.id in (%s)",
                   implode(",", $ids));
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }


  public static function getGruppiRamoDataRS($ramo, $data)
  {
    // estrazione dei  gruppi appartenenti a un ramo, in una certa data
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select g.id, g.nome, g.acronimo from opp_gruppo g, opp_gruppo_ramo gr where gr.gruppo_id=g.id and gr.ramo='%s' and gr.data_inizio < '%s' and (gr.data_fine >= '%s' or gr.data_fine is null)",
                   $ramo, $data, $data);
                   
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    return $rs;
  }

  
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
