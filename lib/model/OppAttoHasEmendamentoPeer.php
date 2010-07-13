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

  public static function countEmendamentiAttoDaCaricaData($carica_id, $atto_id, $date, $con = null)
  {
    if (is_null($con))
      $con = Propel::getConnection(self::DATABASE_NAME);
    
    $sql = sprintf("SELECT COUNT(*) cnt FROM opp_atto_has_emendamento ae, opp_emendamento e, opp_carica_has_emendamento ce WHERE ae.emendamento_id=e.id and e.id=ce.emendamento_id and ce.carica_id=%d and ae.atto_id=%d and ce.data < '%s' and ae.portante=1",
                        $carica_id, $atto_id, $date);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    $rs->next();
    $row = $rs->getRow();
    return  $row['cnt'];
  }
  
  

  
}
