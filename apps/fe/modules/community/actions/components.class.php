<?php
/**
 * user components.
 *
 * @package    openpolis
 * @subpackage user
 * @author     Gianluca Canale 
 * @version    SVN: $Id: components.class.php 1415 2006-06-11 08:33:51Z fabien $
 */
class communityComponents extends sfComponents
{

 public function executeBoxparlamentari()
  {
  
  $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(OppCaricaPeer::ID);
    $c->addSelectColumn(OppPoliticoPeer::ID);
    $c->addSelectColumn(OppPoliticoPeer::COGNOME);
    $c->addSelectColumn(OppPoliticoPeer::NOME);
    $c->addSelectColumn(OppPoliticoPeer::N_MONITORING_USERS);
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);
    $c->add(OppCaricaPeer::DATA_FINE,NULL,Criteria::ISNULL);
    
    // deputati + monitorati
    if ($this->type == 'deputati')
    	$c->add(OppCaricaPeer::TIPO_CARICA_ID,1);
    else
     // senatori + monitorati
    	$c->add(OppCaricaPeer::TIPO_CARICA_ID,4);
    
    $c->addDescendingOrderByColumn(OppPoliticoPeer::N_MONITORING_USERS);
    $c->setLimit(3);
    $this->parlamentari = OppCaricaPeer::doSelectRS($c);
    
  }
  
  public function executeAttiutenti()
  {
  
  $c = new Criteria();
  $c->add(OppAttoPeer::LEGISLATURA,16);
    
    // deputati + monitorati
    if ($this->type == 'commenti')
    	$c->addDescendingOrderByColumn(OppAttoPeer::NB_COMMENTI);
    if ($this->type == 'monitor')
    	$c->addDescendingOrderByColumn(OppAttoPeer::N_MONITORING_USERS);	
    if ($this->type == 'voti') {
    	$c->addDescendingOrderByColumn(OppAttoPeer::UT_FAV);	
    	$c->addDescendingOrderByColumn(OppAttoPeer::UT_CONTR);
    }	
 
    $c->setLimit(5);
    $this->atti = OppAttoPeer::doSelect($c);
    
  }

}

?>