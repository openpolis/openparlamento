<?php

/**
 * api actions.
 *
 * @package    op_openparlamento
 * @subpackage api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class apiActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('default', 'module');
  }
  
  public function executeGetClassifiche()
  {
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(OppCaricaPeer::ID);             // 1
    $c->addSelectColumn(OppPoliticoPeer::ID);           // 2
    $c->addSelectColumn(OppPoliticoPeer::COGNOME);      // 3
    $c->addSelectColumn(OppPoliticoPeer::NOME);         // 4
    $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE); // 5
    $c->addSelectColumn(OppCaricaPeer::PRESENZE);       // 6
    $c->addSelectColumn(OppCaricaPeer::ASSENZE);        // 7
    $c->addSelectColumn(OppCaricaPeer::MISSIONI);       // 8
    $c->addSelectColumn(OppCaricaPeer::INDICE);         // 9
    $c->addSelectColumn(OppCaricaPeer::POSIZIONE);      // 10
    $c->addSelectColumn(OppCaricaPeer::MEDIA);          // 11
    $c->addSelectColumn(OppCaricaPeer::RIBELLE);        // 12
    $c->addSelectColumn(OppPoliticoPeer::N_MONITORING_USERS); // 13
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);
    $c->add(OppCaricaPeer::DATA_FINE,NULL,Criteria::ISNULL);

    $deputati = array(); $senatori = array();
    $deputati['presenti'] = $this->_get_most_something($c, 1, OppCaricaPeer::PRESENZE);
    $senatori['presenti'] = $this->_get_most_something($c, 4, OppCaricaPeer::PRESENZE);
    $deputati['assenti'] = $this->_get_most_something($c, 1, OppCaricaPeer::ASSENZE);
    $senatori['assenti'] = $this->_get_most_something($c, 4, OppCaricaPeer::ASSENZE);
    $deputati['attivi'] = $this->_get_most_something($c, 1, OppCaricaPeer::INDICE);
    $senatori['attivi'] = $this->_get_most_something($c, 4, OppCaricaPeer::INDICE);
    $deputati['monitorati'] = $this->_get_most_something($c, 1, OppPoliticoPeer::N_MONITORING_USERS);
    $senatori['monitorati'] = $this->_get_most_something($c, 4, OppPoliticoPeer::N_MONITORING_USERS);
    $deputati['ribelli'] = $this->_get_most_something($c, 1, OppCaricaPeer::RIBELLE);
    $senatori['ribelli'] = $this->_get_most_something($c, 4, OppCaricaPeer::RIBELLE);
    
    $this->dep = $deputati; $this->sen = $senatori;
    sfConfig::set('sf_web_debug', false);
    $this->getResponse()->setContentType('text');
  }

  public function _get_most_something($crit, $tipo_carica, $field, $limit = null)
  {
    sfLoader::loadHelpers(array('Url', 'Tag'));
    
    // if limit was not passed, then get it from config file
    if (is_null($limit)) 
      $limit = sfConfig::get('app_api_classifiche_limit', 5);

    $c = clone $crit;
    $c->add(OppCaricaPeer::TIPO_CARICA_ID, $tipo_carica);
    $c->addDescendingOrderByColumn($field);
    $c->setLimit($limit); 
    $rs = OppCaricaPeer::doSelectRS($c);
    $results = array();
    while ($rs->next())
    {
      $record = array();
      $record['img_src'] = OppPoliticoPeer::getThumbUrl($rs->getInt(2));
      $record['nome'] = $rs->getString(3).' '.$rs->getString(4);
      $record['nome_link'] = url_for('@parlamentare?id='.$rs->getInt(2));
      
      $record['gruppi'] = '';
      $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($rs->getInt(1));
      foreach($gruppi as $nome => $gruppo)
        if(!$gruppo['data_fine']) 
          $record['gruppi'] = " ($nome)";

      switch ($field)
      {
        case OppCaricaPeer::PRESENZE:
          $num_votazioni = $rs->getInt(6) + $rs->getInt(7) + $rs->getInt(8);
          $record['descr'] = "%s% - %d su %d";
          $record['values'] = array(number_format($rs->getInt(6)*100/$num_votazioni,2), $rs->getInt(6), $num_votazioni);
          break;
        case OppCaricaPeer::ASSENZE:
          $num_votazioni = $rs->getInt(6) + $rs->getInt(7) + $rs->getInt(8);
          $record['descr'] = "%s% - %d su %d";
          $record['values'] = array(number_format($rs->getInt(7)*100/$num_votazioni,2), $rs->getInt(7), $num_votazioni);
          break;
        case OppCaricaPeer::INDICE:
          $record['descr'] = "indice di attivit&agrave;: %5.2f";
          $record['values'] = array($rs->getFloat(9)); 
          break;
        case OppPoliticoPeer::N_MONITORING_USERS:
          $record['descr'] = "&egrave; monitorato da %d utenti";
          $record['values'] = array($rs->getInt(13));
          break;
        case OppCaricaPeer::RIBELLE:
          $record['descr'] = "voti diversi dal suo gruppo: %d su %d";
          $record['values'] = array($rs->getInt(12), $rs->getInt(6));
          break;
      }

      $results []= $record;
    }
    
    return $results;
  }

}
