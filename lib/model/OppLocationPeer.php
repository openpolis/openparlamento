<?php

/**
 * Modello in grado di leggere alcune informazioni dalla OpLocation nel DB openpolis
 */ 
class OppLocationPeer
{
  
  public static function retrieveMacroRegions()
  {
    $con = Propel::getConnection('openpolis');
		
		$sql = sprintf("select l.id, l.name from op_openpolis.op_location as l, op_openpolis.op_location_type as lt where l.location_type_id=lt.id and lt.name='Macroregione'");

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $macroregions = array();
    while ($rs->next())
    {
      $macroregions []= $rs->getRow();
    }        
    
    return $macroregions;
    
  }
  
  
  public static function getLocationsIdsByMacroregion($macroregional_id)
  {
    $con = Propel::getConnection('openpolis');
		
		$sql = sprintf("select l.id from op_location l where l.macroregional_id=%s", $macroregional_id);

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $ids = array();
    while ($rs->next())
    {
      $row = $rs->getRow();
      $ids []= $row['id'];
    }
    
    return $ids;
  }
}
