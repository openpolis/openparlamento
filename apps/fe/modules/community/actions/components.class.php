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
    // costruzione del criterio di ordinamento
    switch ($this->type) {
      case 'commenti':
        $order_clause = ' order by nb_commenti desc ';
        break;

      case 'monitor':
        $order_clause = ' order by n_monitoring_users desc ';
        break;
      
      case 'voti':
        $order_clause = ' order by (ut_fav+ut_contr) desc ';
        break;

      default:
        $order_clause = '';
        break;
    }
    
    $limit = 5;
    
		$con = Propel::getConnection(OppAttoPeer::DATABASE_NAME);
		
    // estrazione degli atti (sia positivi che negativi)
    $sql = sprintf("select id from opp_atto where legislatura=17 %s limit %d;",
                   $order_clause, $limit);

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    // estrazione atti che verificano
    $atti = array();
    while ($rs->next())
    {
      $row = $rs->getRow();
      $atti []= OppAttoPeer::retrieveByPK($row['id']);
    }
  
    $this->atti = $atti;
        
  }

}

?>
