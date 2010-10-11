<?php

/**
 * Subclass for performing query and update operations on the 'opp_carica_has_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaHasAttoPeer extends BaseOppCaricaHasAttoPeer
{
  public static function get_fattore_firma($tipo)
  {
    switch ($tipo)
    {
      case 'P':
        $val = 10;
        break;
      
      case 'R':
        $val = 6;
        break; 
        
      case 'C':
        $val = 3;
        break;
        
      default:
        $val = 0;
        break;
    }
    
    return $val;
  }
  

  public static function get_nuovo_fattore_firma($tipo)
  {
    switch ($tipo)
    {
      case 'P':
        $val = 1.0;
        break;
      
      case 'R':
        $val = 2.0;
        break; 
        
      case 'C':
        $val = 0.1;
        break;
      
      case 'I':
        $val = 0.2;
        break;
        
      default:
        $val = 0.;
        break;
    }
    
    return $val;
  }
  
  
  /**
   * estrae tutte le firme per un determinato atto, prima di una determinata data
   *
   * @param string $atto_id 
   * @param string $data 
   * @return array di hash ('carica_id' => ID, 'data' => DATA)
   * @author Guglielmo Celata
   */
  public static function getFirme($atto_id, $data)
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select ca.carica_id, ca.data from opp_carica_has_atto ca where ca.atto_id=%d and ca.data <= '%s';",
                   $atto_id, $data);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
    $firme = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $firme []= array('carica_id' => $row['carica_id'], 'data' => $row['data']);
    }
		return $firme;		
  }

  /**
   * torna gli atti in cui la carica ha fatto da relatore
   *
   * @param string $carica_id 
   * @param integer $legislatura
   * @param string $data 
   * @return integer
   * @author Guglielmo Celata
   */
  public static function getRelazioni($carica_id, $legislatura, $data)
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select a.id, a.tipo_atto_id, a.data_pres, a.is_main_unified from opp_carica_has_atto ca, opp_carica c, opp_atto a where c.id=ca.carica_id and a.id=ca.atto_id and ca.carica_id=%d and a.data_pres <= '%s' and c.legislatura = %d and ca.tipo='R';",
                   $carica_id, $data, $legislatura);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
    $atti = array();
    while ($rs->next()) {
      $atti []= $rs->getRow();
    }

    return $atti;
  }


  /**
   * controlla se un atto_id è stato presentato (P) da una carica_id
   *
   * @param string $carica_id 
   * @param string $atto_id 
   * @return void
   * @author Guglielmo Celata
   */
  public static function isPresentedBy($carica_id, $atto_id)
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select * from opp_carica_has_atto ca where ca.atto_id=%d and ca.carica_id=%d and ca.tipo='P';",
                   $carica_id, $atto_id);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
    if ($rs->next())
      return true;
    else
      return false;
  }

  /**
   * estrae i due array di schieramenti e gruppi che hanno presentato l'atto
   * i due array sono ritornati come array di 2 array (da leggere con list())
   *
   * @param string $atto_id 
   * @param string $data 
   * @return void
   * @author Guglielmo Celata
   */
  public static function getSchierGrupPresAtto($atto_id, $data)
  {
    $firme_rs = self::getFirmeAttoDataTipoRS($atto_id, $data, "'P'");
    $schier_pres = array();
    $grup_pres = array();
    while ($firme_rs->next()) {
      $row = $firme_rs->getRow();
      if (!in_array($row['maggioranza'], $schier_pres)) $schier_pres []= $row['maggioranza'];
      if (!in_array($row['gruppo_id'], $grup_pres)) $grup_pres []= $row['gruppo_id'];
    }
    
    return array($schier_pres, $grup_pres);
  }
  
  /**
   * estrae un RecordSet con le firme di un atto entro una data, 
   * con una query ottimizzata, che estrae informazioni su gruppi e maggioranza
   *
   * @param string $atto_id 
   * @param string $data 
   * @param string $tipo - il tipo di firma (P, C, R)
   * @return void
   * @author Guglielmo Celata
   */
  public static function getFirmeAttoDataTipoRS($atto_id, $data, $tipo = '')
  {
    
    if ($tipo == '') $tipi_firma = array("'P'", "'C'", "'R'");
    else 
      if (is_array($tipo))
      {
        $tipi_firma = $tipo; 
      } else 
        $tipi_firma = array($tipo);
    
    $tipi_firma_s = implode(",", $tipi_firma);
    
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select cg.gruppo_id, gm.maggioranza, count(cg.gruppo_id) nf from opp_carica_has_atto ca, opp_carica c, opp_carica_has_gruppo cg, opp_gruppo_is_maggioranza gm where ca.carica_id=c.id and c.id=cg.carica_id and ca.tipo in ($tipi_firma_s) and gm.gruppo_id=cg.gruppo_id and ca.atto_id=%d and ca.data < '%s' and cg.data_inizio < '%s' and (cg.data_fine > '%s' or cg.data_fine is null) group by cg.gruppo_id;",
                   $atto_id, $data, $data, $data);
                   
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }
  
  
  
  
}
