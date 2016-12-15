<?php

/*
 * function used to add quotes to letters
 */
function quotize($tipo){
    return sprintf("'%s'", $tipo);
}


/**
 * Subclass for performing query and update operations on the 'opp_carica_has_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaHasAttoPeer extends BaseOppCaricaHasAttoPeer
{
  
  
  public static function get_fattore_firma_posizione($tipo_firma, $tipo_atto_id)
  {
    if ($tipo_atto_id == 1)
    {
      if ($tipo_firma == "P") return "6";
      if ($tipo_firma == "C") return "2";
      if ($tipo_firma == "R") return "0";
    }
    if ($tipo_atto_id == 2)
    {
      if ($tipo_firma == "P") return "3";
      if ($tipo_firma == "C") return "0.5";
    }
    if ($tipo_atto_id >= 3 || $tipo_atto_id <= 6)
    {
      if ($tipo_firma == "P") return "1";
      if ($tipo_firma == "C") return "0.5";
    }
    if ($tipo_atto_id >= 7 || $tipo_atto_id <= 9)
    {
      if ($tipo_firma == "P") return "2";
      if ($tipo_firma == "C") return "0.5";
    }
    if ($tipo_atto_id >= 10 || $tipo_atto_id <= 11)
    {
      if ($tipo_firma == "P") return "2";
      if ($tipo_firma == "C") return "0.5";
    }
  }

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
        $val = 1.0;
        break; 
        
      case 'C':
        $val = 0.1;
        break;
      
      case 'I':
        $val = 0.01;
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
    $sql = sprintf("select ca.carica_id, ca.data, ca.tipo from opp_carica_has_atto ca where ca.atto_id=%d and ca.data <= '%s';",
                   $atto_id, $data);
    
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
    $firme = array();
    while ($rs->next()) {
      $row = $rs->getRow();
      $firme []= array('carica_id' => $row['carica_id'], 'data' => $row['data'], 'tipo' => $row['tipo']);
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
     * @param string $atto_id the ID of the act to check
     * @param string $date    the date when to check group and schier belonging
     * @return array          an array of array with schiers and grups
     * @author Guglielmo Celata
     */
    public static function getSchierGrupAtto($atto_id, $date, $tipo)
    {

        if (!in_array($tipo, array("P", "C", "R"))){
            return null;
        }

        $firme_rs = self::getFirmeAttoDataTipoRS($atto_id, $date, $tipo);
        $schier = array();
        $grup = array();
        while ($firme_rs->next()) {
            $row = $firme_rs->getRow();
            if (!in_array($row['maggioranza'], $schier)) $schier []= $row['maggioranza'];
            if (!in_array($row['gruppo_id'], $grup)) $grup []= $row['gruppo_id'];
        }

        return array($schier, $grup);
    }

    /**
     * Return schieramenti and gruppi of firmatati,
     * for given atto, at the given date
     *
     * @param $atto_id
     * @param $date
     * @return array
     */
  public static function getSchierGrupPresAtto($atto_id, $date)
  {
      /*
        $firme_rs = self::getFirmeAttoDataTipoRS($atto_id, $data, "'P'");
        $schier_pres = array();
        $grup_pres = array();
        while ($firme_rs->next()) {
        $row = $firme_rs->getRow();
        if (!in_array($row['maggioranza'], $schier_pres)) $schier_pres []= $row['maggioranza'];
        if (!in_array($row['gruppo_id'], $grup_pres)) $grup_pres []= $row['gruppo_id'];
        }
    
        return array($schier_pres, $grup_pres);
      */
      return self::getSchierGrupAtto($atto_id, $date, "P");
  }

    /**
     * Return schieramenti and gruppi of relatori,
     * for given atto, at the given date
     *
     * @param $atto_id
     * @param $date
     * @return array
     */
    public static function getSchierGrupRelAtto($atto_id, $date)
    {
        return self::getSchierGrupAtto($atto_id, $date, "R");
    }


  /**
   * estrae un RecordSet con le firme di un atto entro una data, 
   * con una query ottimizzata, che estrae informazioni su gruppi e maggioranza
   * aggiornate alla data fornita
   *
   * @param string $atto_id 
   * @param string $data - la data
   * @param string $tipo - il tipo di firma (P, C, R)
   * @return void
   * @author Guglielmo Celata
   */
  public static function getFirmeAttoDataTipoRS($atto_id, $data, $tipo = '')
  {
    
    if ($tipo == '') $tipi_firma = array("P", "C", "R");
    else 
      if (is_array($tipo))
      {
        $tipi_firma = $tipo; 
      } else 
        $tipi_firma = array($tipo);

    $tipi_firma_s = implode(",", array_map('quotize', $tipi_firma));
    
    $con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf(
        "select cg.gruppo_id, gm.maggioranza, count(cg.gruppo_id) nf " .
        "from opp_carica_has_atto ca, opp_carica c, opp_carica_has_gruppo cg, opp_gruppo_is_maggioranza gm " .
        "where ca.carica_id=c.id and c.id=cg.carica_id and gm.gruppo_id=cg.gruppo_id and " .
        "ca.tipo in (%s) and ca.atto_id=%d and " .
        "ca.data <= '%s' and " .
        "cg.data_inizio <= '%s' and (cg.data_fine >= '%s' or cg.data_fine is null) and " .
        "gm.data_inizio <= '%s' and (gm.data_fine >= '%s' or gm.data_fine is null)" .
        "group by cg.gruppo_id;",
        $tipi_firma_s, $atto_id, $data, $data, $data, $data, $data
    );
    # printf($sql);
    $stm = $con->createStatement();
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }
  
  
  
  
}
