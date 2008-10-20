<?php

/**
 * Subclass for performing query and update operations on the 'opp_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAttoPeer extends BaseOppAttoPeer
{
  public static function doSelectPrimiFirmatari($pred)
  {
    $primi_firmatari = array();
	
    $rs = OppAttoPeer::getRecordsetFirmatari($pred, 'P');
	
	while ($rs->next())
    {
	  $primi_firmatari[$rs->getInt(1)]=$rs->getDate(5, 'Y-m-d').' * '.$rs->getString(2).' '.$rs->getString(3).' ('.$rs->getString(4).')'; 
	}
	return $primi_firmatari;
	

  }
  
  
  public static function doSelectCoFirmatari($pred)
  {
    $co_firmatari = array();
	
	$rs = OppAttoPeer::getRecordsetFirmatari($pred, 'C');
	
	while ($rs->next())
    {
	  $co_firmatari[$rs->getInt(1)]=$rs->getDate(5, 'Y-m-d').' * '.$rs->getString(2).' '.$rs->getString(3).' ('.$rs->getString(4).')';  
	}
    
	return $co_firmatari;
  }
  
   public static function doSelectRelatori($pred)
  {
    $relatori = array();
	
	$rs = OppAttoPeer::getRecordsetFirmatari($pred, 'R');
	
	while ($rs->next())
    {
	  $relatori[$rs->getInt(1)]=$rs->getString(2).' '.$rs->getString(3).' ('.$rs->getString(4).')'; 
	}
    
	return $relatori;
  }
  
  public static function doSelectTeseo($pred)
  {
    $argomenti = array(); 
	
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppTeseoPeer::ID);
	$c->addSelectColumn(OppTeseoPeer::DENOMINAZIONE);
	$c->add(OppAttoHasTeseoPeer::ATTO_ID, $pred, Criteria::EQUAL);
	$c->addJoin(OppAttoHasTeseoPeer::TESEO_ID, OppTeseoPeer::ID, Criteria::LEFT_JOIN);
	$c->addAscendingOrderByColumn(OppTeseoPeer::DENOMINAZIONE);
	$rs = OppAttoHasTeseoPeer::doSelectRS($c);
	
	while ($rs->next())
    {
	  $argomenti[$rs->getInt(1)]=$rs->getString(2);  
	}
    
	return $argomenti;
  }
  
  protected static function getRecordsetFirmatari($pred, $tipo)
  {
    $c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppPoliticoPeer::ID);
	$c->addSelectColumn(OppPoliticoPeer::NOME);
	$c->addSelectColumn(OppPoliticoPeer::COGNOME);
	$c->addSelectColumn(OppGruppoPeer::NOME);
	$c->addSelectColumn(OppCaricaHasAttoPeer::DATA);
	$c->add(OppCaricaHasAttoPeer::ATTO_ID, $pred, Criteria::EQUAL);
	$c->addJoin(OppCaricaHasAttoPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::LEFT_JOIN);
	$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::LEFT_JOIN);
	$c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::LEFT_JOIN);
	$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::LEFT_JOIN);
	$c->add(OppCaricaHasAttoPeer::TIPO, $tipo, Criteria::EQUAL);
	$c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
	$rs = OppCaricaHasAttoPeer::doSelectRS($c);
	
	return $rs;
  }
  
  public static function doSelectNews()
  {
    $news = array();
	
	// nuovi ddl
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppAttoPeer::DATA_PRES);
	$c->addSelectColumn(OppAttoPeer::RAMO);
	$c->addSelectColumn(OppAttoPeer::NUMFASE);
	$c->addSelectColumn(OppAttoPeer::TITOLO);
	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
	$c->add(OppAttoPeer::TIPO_ATTO_ID, 1, Criteria::EQUAL);
	$c->setLimit(5);
	$rs = OppAttoPeer::doSelectRS($c);
	
	// cambi di status
	$c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppAttoHasIterPeer::DATA);
	$c->addSelectColumn(OppAttoPeer::RAMO);
	$c->addSelectColumn(OppAttoPeer::NUMFASE);
	$c->addSelectColumn(OppAttoPeer::TITOLO);
	$c->addSelectColumn(OppIterPeer::FASE);
	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
	$c->add(OppAttoPeer::TIPO_ATTO_ID, 1, Criteria::EQUAL);
	$c->addJoin(OppAttoHasIterPeer::ATTO_ID, OppAttoPeer::ID, Criteria::LEFT_JOIN);
	$c->addJoin(OppAttoHasIterPeer::ITER_ID, OppIterPeer::ID, Criteria::LEFT_JOIN);
	$c->setLimit(5);
	$rs = OppAttoPeer::doSelectRS($c);
	
	while ($rs->next())
    {
	  
	}  
  }
  
  
}
?>