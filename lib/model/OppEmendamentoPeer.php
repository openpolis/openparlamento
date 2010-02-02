<?php

/**
 * Subclass for performing query and update operations on the 'opp_emendamento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppEmendamentoPeer extends BaseOppEmendamentoPeer
{
  
  public static function doSelectPrimiFirmatari($pred)
  {
    $primi_firmatari = array();
	
    $rs = self::getRecordsetFirmatari($pred, 'P');
	
	  while ($rs->next())
    {
	    if($rs->getString(4) != '')
	      $primi_firmatari[$rs->getInt(1)] = $rs->getDate(5, 'Y-m-d') . ' * ' . 
	                                         $rs->getString(2) . ' ' . 
	                                         $rs->getString(3). ' ('.$rs->getString(4).')'; 
	    else
	      $primi_firmatari[$rs->getInt(1)] = $rs->getDate(5, 'Y-m-d') . ' * ' . 
	                                         $rs->getString(2) . ' ' . 
	                                         $rs->getString(3); 
	  }
	  return $primi_firmatari;
	
  }
  
  
  public static function doSelectCoFirmatari($pred)
  {
    $co_firmatari = array();
	
  	$rs = self::getRecordsetFirmatari($pred, 'C');
	
  	while ($rs->next())
    {
	  if($rs->getString(4) != '')
	    $co_firmatari[$rs->getInt(1)] = $rs->getDate(5, 'Y-m-d') . ' * ' . 
	                                    $rs->getString(2) . ' ' . 
	                                    $rs->getString(3) . ' ('.$rs->getString(4).')';  
	  else
	    $co_firmatari[$rs->getInt(1)] = $rs->getDate(5, 'Y-m-d') . ' * ' . 
	                                    $rs->getString(2) . ' ' . 
	                                    $rs->getString(3);    
  	}
    
	  return $co_firmatari;
  }
  
  public static function doSelectRelatori($pred)
  {
    $relatori = array();

	  $rs = self::getRecordsetFirmatari($pred, 'R');

	  while ($rs->next())
    {
	    $relatori[$rs->getInt(1)] = $rs->getString(2) . ' ' . 
	                                $rs->getString(3) . ' ('.$rs->getString(4).')'; 
	  }
  
	  return $relatori;
  }
  
  protected static function getRecordsetFirmatari($pred, $tipo)
  {
    $c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppPoliticoPeer::ID);
  	$c->addSelectColumn(OppPoliticoPeer::NOME);
  	$c->addSelectColumn(OppPoliticoPeer::COGNOME);
  	$c->addSelectColumn(OppGruppoPeer::NOME);
  	$c->addSelectColumn(OppCaricaHasEmendamentoPeer::DATA);
  	$c->add(OppCaricaHasEmendamentoPeer::EMENDAMENTO_ID, $pred, Criteria::EQUAL);
  	$c->addJoin(OppCaricaHasEmendamentoPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::LEFT_JOIN);
  	$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::LEFT_JOIN);
  	$c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::LEFT_JOIN);
  	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::LEFT_JOIN);
  	$c->add(OppCaricaHasEmendamentoPeer::TIPO, $tipo, Criteria::EQUAL);
  	$c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
  	$rs = OppCaricaHasEmendamentoPeer::doSelectRS($c);
	
	  return $rs;
  }
  
  /**
   * get all distinct available articoli for emendamenti of a given atto
   *
   * @param OppAtto $atto 
   * @return array of string
   * @author Guglielmo Celata
   */
  public static function getAvailableArticles(OppAtto $atto)
  {
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(OppEmendamentoPeer::ARTICOLO);
    $c->addJoin(OppAttoHasEmendamentoPeer::EMENDAMENTO_ID, OppEmendamentoPeer::ID);
    $c->add(OppAttoHasEmendamentoPeer::ATTO_ID, $atto->getId());
    $c->addAscendingOrderByColumn(OppEmendamentoPeer::ARTICOLO);
    $c->setDistinct();
    $rs = OppEmendamentoPeer::doSelectRS($c);
    $articles = array();
    while ($rs->next())
    {
      if (trim($rs->getString(1)) != '')
        $articles []= $rs->getString(1);
    }
    return $articles;
  }
  
  /**
   * get all distinct available sedi for emendamenti of a given atto
   *
   * @param OppAtto $atto 
   * @return hash of type {id => site}
   * @author Guglielmo Celata
   */
  public static function getAvailableSites(OppAtto $atto)
  {
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addJoin(OppAttoHasEmendamentoPeer::EMENDAMENTO_ID, OppEmendamentoPeer::ID);
    $c->add(OppAttoHasEmendamentoPeer::ATTO_ID, $atto->getId());
    $c->addJoin(OppSedePeer::ID, OppEmendamentoPeer::SEDE_ID);
    $c->addSelectColumn(OppEmendamentoPeer::SEDE_ID);
    $c->addSelectColumn(OppSedePeer::DENOMINAZIONE);
    $c->setDistinct();
    $rs = OppEmendamentoPeer::doSelectRS($c);
    $items = array();
    while ($rs->next())
    {
      $items [$rs->getInt(1)] = $rs->getString(2);
    }
    return $items;
  }

  /**
   * get all distinct available presenters for emendamenti of a given atto
   *
   * @param OppAtto $atto 
   * @return hash of type {id => presenter}
   * @author Guglielmo Celata
   */
  public static function getAvailablePresenters(OppAtto $atto)
  {
    $atto_id = $atto->getId();
    $sql =
     "select distinct ce.carica_id " .
     "from opp_emendamento e left join opp_carica_has_emendamento ce on ce.emendamento_id = e.id " .
     "join opp_carica c on (c.id=ce.carica_id || ce.carica_id is null) " .
     "join opp_atto_has_emendamento ae on ae.emendamento_id=e.id " .
     "where (ce.tipo = 'P' or ce.tipo is null) and ae.atto_id=$atto_id;";
    
    $con = Propel::getConnection(BaseOppEmendamentoPeer::DATABASE_NAME);
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_NUM);
    
    $items = array();
    while ($rs->next())
    {
      if (is_null($rs->getInt(1)))
        $items['999999999'] = "Governo, Comm. ...";
      else
      {
        $c = OppCaricaPeer::retrieveByPK($rs->getInt(1));
        $p = $c->getOppPolitico();
        $items [$rs->getInt(1)] = $p->getNome() . " " . strtoupper($p->getCognome());        
      }
    }
    return $items;
  }


  /**
   * get all distinct available statuses for emendamenti of a given atto
   *
   * @param OppAtto $atto 
   * @return hash of type {id => status}
   * @author Guglielmo Celata
   */
  public static function getAvailableStatuses(OppAtto $atto)
  {
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addJoin(OppAttoHasEmendamentoPeer::EMENDAMENTO_ID, OppEmendamentoPeer::ID);
    $c->addJoin(OppEmendamentoHasIterPeer::EMENDAMENTO_ID, OppEmendamentoPeer::ID);
    $c->addJoin(OppEmendamentoHasIterPeer::EM_ITER_ID, OppEmIterPeer::ID);    
    $c->add(OppAttoHasEmendamentoPeer::ATTO_ID, $atto->getId());
    $c->addSelectColumn(OppEmIterPeer::ID);
    $c->addSelectColumn(OppEmIterPeer::FASE);
    $c->addSelectColumn(OppEmIterPeer::CONCLUSO);
    $c->setDistinct();
    $rs = OppEmendamentoPeer::doSelectRS($c);
    $items = array();
    while ($rs->next())
    {
      if (trim(strtolower($rs->getString(2) != 'altro')))
        $items [$rs->getInt(1)] = $rs->getString(2);
    }
    return $items;
  }
  
}
