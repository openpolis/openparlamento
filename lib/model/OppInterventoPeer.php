<?php

/**
 * Subclass for performing query and update operations on the 'opp_intervento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppInterventoPeer extends BaseOppInterventoPeer
{
  
  /**
   * calcola il numero di sedute (stessa sede_id, stessa data), 
   * in commissione o assemblea
   * con almeno un intervento su un atto
   * gli interventi devono essere prima di una determinata data
   *
   * @param string $atto_id 
   * @param string $where (C or A)
   * @param string $data 
   * @return void
   * @author Guglielmo Celata
   */
  public function getNSeduteConInterventiAttoData($atto_id, $where, $data)
  {
		$con = Propel::getConnection(self::DATABASE_NAME);
    if ($where == 'C') {
      $sql = sprintf("select count(*) as n_sedute from (select count(*) as n_interv from opp_sede s, opp_intervento i where i.sede_id=s.id and s.tipologia != 'Assemblea' and i.atto_id = %d and i.data < '%s' group by i.sede_id, data order by data desc) interv  where n_interv > 1;",
                     $atto_id, $data);
    } elseif ($where == 'A') {
      $sql = sprintf("select count(*) as n_sedute from (select count(*) as n_interv from opp_sede s, opp_intervento i where i.sede_id=s.id and s.tipologia = 'Assemblea' and i.atto_id = %d and i.data < '%s' group by i.sede_id, data order by data desc) interv  where n_interv > 1;",
                     $atto_id, $data);      
    } else 
      throw new Exception('Il parametro where deve valere C o A.');
      
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return $row['n_sedute'];
  }
  
  /**
   * torna il numero di sedute con almeno un intervento di un parlamentare
   *
   * @param string $carica 
   * @param string $data - data limite
   * @return integer
   * @author Guglielmo Celata
   */
  public static function getNSeduteConInterventiCaricaData($carica_id, $data)
  {
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select count(*) as n_sedute from (select count(*) as n_interv from opp_intervento i where i.carica_id = %d and i.data < '%s' group by i.sede_id, data) interv  where n_interv > 1;",
                     $carica_id, $data);      
      
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return $row['n_sedute'];
  }
}
