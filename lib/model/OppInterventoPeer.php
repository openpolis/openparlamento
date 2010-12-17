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
  
  public static function get_fattore_intervento_posizione($tipo_intervento)
  {
    return 1;
  }
  
  /**
   * torna i ddl collegati agli interventi delle cariche
   *
   * @param string $cariche_ids 
   * @return array di OppAtto
   * @author Guglielmo Celata
   */
  public static function getDDLCollegatiCariche($cariche_ids)
  {
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select i.atto_id, count(i.atto_id) n_interventi from opp_intervento i where i.carica_id in (%s) group by i.atto_id order by n_interventi desc",
                   implode(",", $cariche_ids));
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
    $ddl = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $ddl [] = OppAttoPeer::retrieveByPK($row['atto_id']);
    }
    
    return $ddl;
    
  }


  /**
   * calcola il numero di interventi di una carica
   * prima di una determinata data
   *
   * @param integer $carica_id 
   * @param integer $legislatura 
   * @param string  $data 
   * @return integer
   * @author Guglielmo Celata
   */
  public function countInterventiByCaricaData($carica_id, $legislatura, $data)
  {
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select count(*) as n_interventi from opp_intervento i, opp_atto a where i.atto_id = a.id and i.carica_id=%d and a.legislatura = %d and a.data_pres < '%s'",
                   $carica_id, $legislatura, $data);
      
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return $row['n_interventi'];
  }
  
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
