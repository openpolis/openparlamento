<?php

/**
 * Subclass for performing query and update operations on the 'opp_atto_has_emendamento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAttoHasEmendamentoPeer extends BaseOppAttoHasEmendamentoPeer
{
  public static function countPresentedRelatedToAtDate($atto_id, $date)
  {
    $c = new Criteria();
    $c->add(self::ATTO_ID, $atto_id);
    $c->addJoin(self::EMENDAMENTO_ID, OppEmendamentoPeer::ID);
    $c->add(OppEmendamentoPeer::DATA_PRES, $date);
    return self::doCount($c);
  }

  /**
   * torna il numero di emendamenti presentati (P) da una carica, in relazione a un atto, entro una certa data
   *
   * @param string $carica_id 
   * @param string $atto_id 
   * @param string $date 
   * @param string $con 
   * @return void
   * @author Guglielmo Celata
   */
  public static function countEmendamentiAttoDaCaricaData($carica_id, $atto_id, $date, $con = null)
  {
    if (is_null($con))
      $con = Propel::getConnection(self::DATABASE_NAME);
    
    $sql = sprintf("SELECT COUNT(*) cnt FROM opp_atto_has_emendamento ae, opp_emendamento e, opp_carica_has_emendamento ce WHERE ae.emendamento_id=e.id and e.id=ce.emendamento_id and ce.carica_id=%d and ae.atto_id=%d and ce.tipo='P' and ce.data < '%s' and ae.portante=1",
                        $carica_id, $atto_id, $date);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return  $row['cnt'];
  }


  /**
   * torna il numero complessivo di emendamenti presentati (P) da una carica, entro una certa data
   *
   * @param string $carica_id 
   * @param string $date 
   * @param string $con 
   * @return void
   * @author Guglielmo Celata
   */
  public static function countEmendamentiDaCaricaData($carica_id, $date, $con = null)
  {
    if (is_null($con))
      $con = Propel::getConnection(self::DATABASE_NAME);
    
    $sql = sprintf("SELECT COUNT(*) cnt FROM opp_atto_has_emendamento ae, opp_emendamento e, opp_carica_has_emendamento ce WHERE ae.emendamento_id=e.id and e.id=ce.emendamento_id and ce.carica_id=%d and ce.tipo='P' and ce.data < '%s' and ae.portante=1",
                        $carica_id, $date);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return  $row['cnt'];
  }
  

  /**
   * torna l'array di id degli opp_atto cui si riferiscono gli emendamenti 
   * presentati da una carica entro una certa data
   *
   * @param string $carica_id 
   * @param string $data 
   * @param string $con 
   * @return array of ids
   * @author Guglielmo Celata
   */
  public static function getAttiIdsForEmendamentiCaricaData($carica_id, $date, $con = null)
  {
    if (is_null($con))
      $con = Propel::getConnection(self::DATABASE_NAME);
    
    $sql = sprintf("SELECT ae.atto_id FROM opp_atto_has_emendamento ae, opp_emendamento e, opp_carica_has_emendamento ce WHERE ae.emendamento_id=e.id and e.id=ce.emendamento_id and ce.carica_id=%d and ce.tipo='P' and ce.data < '%s' and ae.portante=1 group by ae.atto_id",
                        $carica_id, $date);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
    // costruzione array degli id
    $ids = array();
    while ($rs->next())
    {
      $row = $rs->getRow();
      $ids []= $row['atto_id'];
    }
    
    return $ids;
  }
  

  /**
   * torna il numero di emendamenti con stato = $fase, presentati (P) da una carica in relazione a un atto, 
   * il tutto entro una certa data (sia la presentazione che lo stato)
   *
   * @param array $fasi
   * @param integer $carica_id 
   * @param integer $atto_id 
   * @param string $date 
   * @param Connection $con 
   * @return void
   * @author Guglielmo Celata
   */
  public static function countEmendamentiFaseAttoCaricaData($iter_ids, $carica_id, $atto_id, $date, $con = null)
  {
    if (is_null($con))
      $con = Propel::getConnection(self::DATABASE_NAME);
    
    $sql = sprintf("SELECT COUNT(*) cnt FROM opp_atto_has_emendamento ae, opp_emendamento e, opp_carica_has_emendamento ce, opp_emendamento_has_iter ei, opp_em_iter i WHERE ae.emendamento_id=e.id and e.id=ce.emendamento_id and e.id=ei.emendamento_id and ei.em_iter_id=i.id and i.id in (%s) and ei.data < '%s' and ce.carica_id=%d and ae.atto_id=%d and ce.tipo='P' and ce.data < '%s' and ae.portante=1",
                        join(",", $iter_ids), $date, $carica_id, $atto_id, $date);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return  $row['cnt'];
  }
  
  

  
}
