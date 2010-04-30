<?php

/**
 * Subclass for performing query and update operations on the 'opp_gruppo_is_maggioranza' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppGruppoIsMaggioranzaPeer extends BaseOppGruppoIsMaggioranzaPeer
{
  /**
   * controlla se il gruppo è di maggioranza o no, alla data
   *
   * @param integer $gruppo_id 
   * @param string $data 
   * @return boolean
   * @author Guglielmo Celata
   */
  public static function isGruppoMaggioranza($gruppo_id, $data)
  {
 		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select * from opp_gruppo_is_maggioranza gm where gm.gruppo_id=%d and data_inizio < '%s' and (data_fine >= '%s' or data_fine is null);",
                    $gruppo_id, $data, $data);

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return $row['maggioranza'];
  }
}
