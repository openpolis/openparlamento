<?php

/**
 * Subclass for performing query and update operations on the 'opp_carica_has_gruppo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaHasGruppoPeer extends BaseOppCaricaHasGruppoPeer
{

  /**
   * returns the sum of the given field for all the MPs
   * in the given parliament section
   *
   * @param string $section 
   * @param string $field - the field to sum
   * @return void
   * @author Guglielmo Celata
   */
  public static function getSomma($field, $section)
  {
    $con=Propel::getConnection(self::DATABASE_NAME); 
    
    $sql = "SELECT sum(cg.$field) from opp_carica_has_gruppo cg, opp_carica c where cg.carica_id = c.id and c.data_fine is null and ";
    if ($section == 'C') $sql .= "c.tipo_carica_id = 1;";
    else $sql .= "c.tipo_carica_id in (4,5);";
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_NUM);
    if ($rs->next()) 
      return $rs->getInt(1);
    else
      return 0;
  }
  
  public static function doSelectGruppiPerCarica($carica_id)
  {
    $gruppi = array();
	
  	$c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppGruppoPeer::ACRONIMO);
  	$c->addSelectColumn(OppCaricaHasGruppoPeer::DATA_INIZIO);
  	$c->addSelectColumn(OppCaricaHasGruppoPeer::DATA_FINE);
  	$c->addSelectColumn(OppCaricaHasGruppoPeer::GRUPPO_ID);
  	$c->addSelectColumn(OppCaricaHasGruppoPeer::RIBELLE);
  	$c->addSelectColumn(OppCaricaHasGruppoPeer::PRESENZE);
  	$c->add(OppCaricaHasGruppoPeer::CARICA_ID, $carica_id , Criteria::EQUAL);
    $c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::LEFT_JOIN);
    $c->addAscendingOrderByColumn(OppCaricaHasGruppoPeer::DATA_FINE);
    $rs = OppCaricaHasGruppoPeer::doSelectRS($c);
	
	  while ($rs->next())
    {
	    $gruppi[$rs->getString(1)] = array('data_inizio' => $rs->getDate(2, 'Y-m-d'), 
	                                       'data_fine'   => $rs->getDate(3, 'Y-m-d'), 
	                                       'gruppo_id'   => $rs->getInt(4), 
	                                       'ribelle'     => $rs->getInt(5),
	                                       'presenze'    => $rs->getInt(6)>0?$rs->getInt(6):0);
	  }	
    
	  return $gruppi;
  }
  	
}

?>