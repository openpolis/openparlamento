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


  public static function getParlamentariGruppoData($gruppo_id, $data, $con = null)
  {
    if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		
		$sql = sprintf("select carica_id from opp_carica_has_gruppo where gruppo_id=%d and data_inizio <= '%s' and (data_fine > '%s' or data_fine is null);",
                    $gruppo_id, $data, $data);

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    if ($rs->next()) {
      $row = $rs->getRow();
      return $row; 		
    }
    return null;
    
  }

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
  
  public static function doSelectGruppiPerCarica($carica_id,$order = 0)
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
    if ($order==0)
      $c->addAscendingOrderByColumn(OppCaricaHasGruppoPeer::DATA_FINE);
    else
      $c->addAscendingOrderByColumn(OppCaricaHasGruppoPeer::DATA_INIZIO);
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
  
  /**
   * si differenzia dalla doSelectGruppiPerCarica in quanto prende TUTTI i gruppi anche quelli
   * in cui un parlamentare è uscito e poi rientrato.
   *
   * @param string $section 
   * @param string $field - the field to sum
   * @return void
   * @author Guglielmo Celata
   */
  
  public static function doSelectTuttiGruppiPerCarica($carica_id,$order = 0)
  {
    $gruppi = array();
  	$c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppCaricaHasGruppoPeer::DATA_INIZIO);
  	$c->addSelectColumn(OppCaricaHasGruppoPeer::DATA_FINE);
  	$c->addSelectColumn(OppCaricaHasGruppoPeer::GRUPPO_ID);
  	$c->add(OppCaricaHasGruppoPeer::CARICA_ID, $carica_id , Criteria::EQUAL);
    if ($order==0)
      $c->addAscendingOrderByColumn(OppCaricaHasGruppoPeer::DATA_FINE);
    else
      $c->addAscendingOrderByColumn(OppCaricaHasGruppoPeer::DATA_INIZIO);
    $rs = OppCaricaHasGruppoPeer::doSelectRS($c);
	
	  while ($rs->next())
    {
	    $gruppi[] = array('data_inizio' => $rs->getDate(1, 'Y-m-d'), 
	                                       'data_fine'   => $rs->getDate(2, 'Y-m-d'), 
	                                       'gruppo_id'   => $rs->getInt(3));
	  }	
    
	  return $gruppi;
  }
  
  /**
    * restituisce il gruppo_id corrente per la carica
    *
    * @param integer $carica_id 
    * @return void
    * @author Ettore Di Cesare
    */

   public static function getGruppoCorrentePerCarica($carica_id)
   {
   	$c = new Criteria();
   	$c->add(OppCaricaHasGruppoPeer::CARICA_ID, $carica_id , Criteria::EQUAL);
   	$c->add(OppCaricaHasGruppoPeer::DATA_FINE, NULL , Criteria::ISNULL);
    $rs = OppCaricaHasGruppoPeer::doSelectOne($c);
    if ($rs)
      return $rs->getGruppoId();
    else
      return NULL;
   }
  	
}

?>