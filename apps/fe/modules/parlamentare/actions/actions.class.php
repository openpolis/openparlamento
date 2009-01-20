<?php

/**
 * parlamentare actions.
 *
 * @package    openparlamento
 * @subpackage parlamentare
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class parlamentareActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->parlamentare = OppPoliticoPeer::RetrieveByPk($this->getRequestParameter('id'));
	$this->forward404Unless($this->parlamentare); 
	
	$this->cariche = OppCaricaPeer::doSelectFullReport($this->getRequestParameter('id'));
	
	$this->voti = $this->parlamentare->getVoti($this->getRequestParameter('page',1));
	
    $this->pager = new customArrayPager(null, sfConfig::get('app_pagination_limit'), $this->parlamentare->getVotiCount());
    $this->pager->setResultArray($this->voti);
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();
  }
  
  public function executeList()
  {

    $this->session = $this->getUser();
    $ramo = $this->getRequestParameter('ramo', 'camera');

    // estrae i gruppi del ramo
    $this->all_groups = OppGruppoPeer::getAllGroups($ramo, 16, 'tutti');
    
    // estrae le circoscrizioni, compreso il valore 0
    $this->all_constituencies = OppCaricaPeer::getAllConstituencies($ramo, 'tutte');
    
    //estrazione parlamentari
    $this->processFilters(array('group', 'const'), $ramo);

    $this->processSort();
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(OppCaricaPeer::ID);
    $c->addSelectColumn(OppPoliticoPeer::ID);
    $c->addSelectColumn(OppPoliticoPeer::COGNOME);
    $c->addSelectColumn(OppPoliticoPeer::NOME);
    $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
    $c->addSelectColumn(OppCaricaPeer::PRESENZE);
    $c->addSelectColumn(OppCaricaPeer::ASSENZE);
    $c->addSelectColumn(OppCaricaPeer::MISSIONI);
    $c->addSelectColumn(OppCaricaPeer::INDICE);
    $c->addSelectColumn(OppCaricaPeer::POSIZIONE);
    $c->addSelectColumn(OppCaricaPeer::MEDIA);
    $c->addSelectColumn(OppCaricaPeer::RIBELLE);
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);

    if ($ramo == 'camera')
    {
      $c->add(OppCaricaPeer::LEGISLATURA, '16', Criteria::EQUAL);
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, '1', Criteria::EQUAL);
 
      //conteggio numero deputati  
      $c1 = new Criteria();
      $c1->add(OppCaricaPeer::LEGISLATURA, '16', Criteria::EQUAL);
      $c1->add(OppCaricaPeer::TIPO_CARICA_ID, '1' , Criteria::EQUAL);
      $c1->add(OppCaricaPeer::DATA_FINE, null, Criteria::EQUAL);
      $this->numero_parlamentari = OppCaricaPeer::doCount($c1);
    }
    else
    {
    
      $cton = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, '16', Criteria::EQUAL);
      //in questo modo considero i senatori a vita
      $cton1 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, null, Criteria::EQUAL);
      $cton->addOr($cton1);
      $c->add($cton);
 	   
      $cton = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, '4', Criteria::EQUAL);
      $cton1 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, '5', Criteria::EQUAL);
      $cton->addOr($cton1);
      $c->add($cton);
 
      //conteggio numero senatori
      $c1 = new Criteria();
      $c1->add(OppCaricaPeer::LEGISLATURA, '16', Criteria::EQUAL);
      $c1->add(OppCaricaPeer::TIPO_CARICA_ID, '4' , Criteria::EQUAL);
      $c1->add(OppCaricaPeer::DATA_FINE, null, Criteria::EQUAL);
      $numero_senatori = OppCaricaPeer::doCount($c1);
 
      //conteggio numero senatori a vita
      $c2 = new Criteria();
      $c2->add(OppCaricaPeer::TIPO_CARICA_ID, '5' , Criteria::EQUAL);
      $numero_senatori_a_vita = OppCaricaPeer::doCount($c2);
 
      $this->numero_parlamentari = $numero_senatori + $numero_senatori_a_vita;
    }
  
    $this->addSortCriteria($c);
    $this->addFiltersCriteria($c);
    $c->add(OppCaricaPeer::DATA_FINE, null, Criteria::EQUAL);
    // $c->setLimit(100);

    $this->parlamentari = OppCaricaPeer::doSelectRS($c);

    //estrazione parlamentari decaduti
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(OppCaricaPeer::ID);
    $c->addSelectColumn(OppPoliticoPeer::ID);
    $c->addSelectColumn(OppPoliticoPeer::COGNOME);
    $c->addSelectColumn(OppPoliticoPeer::NOME);
    $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
    $c->addSelectColumn(OppCaricaPeer::PRESENZE);
    $c->addSelectColumn(OppCaricaPeer::ASSENZE);
    $c->addSelectColumn(OppCaricaPeer::MISSIONI);
    $c->addSelectColumn(OppCaricaPeer::INDICE);
    $c->addSelectColumn(OppCaricaPeer::POSIZIONE);
    $c->addSelectColumn(OppCaricaPeer::MEDIA);
    $c->addSelectColumn(OppCaricaPeer::RIBELLE);
    $c->addSelectColumn(OppCaricaPeer::DATA_FINE);
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);

    if ($ramo == 'camera')
     $c->add(OppCaricaPeer::TIPO_CARICA_ID, '1', Criteria::EQUAL);
    else
     $c->add(OppCaricaPeer::TIPO_CARICA_ID, '4', Criteria::EQUAL);

    $c->add(OppCaricaPeer::LEGISLATURA, '16', Criteria::EQUAL);    
    $c->add(OppCaricaPeer::DATA_FINE, 'NULL', Criteria::NOT_EQUAL); 
	 
    $this->parlamentari_decaduti = OppCaricaPeer::doSelectRS($c);
	      
  }

  /**
   * check request parameters and set session values for the filters
   * reads filters from session, so that a clean url builds up with user's values
   *
   * @param  array $active_filters an array of all the active filters
   * @return void
   * @author Guglielmo Celata
   */
  protected function processFilters($active_filters, $ramo)
  {

    $this->filters = array();

    // legge i filtri dalla request e li scrive nella sessione utente
    if ($this->getRequest()->getMethod() == sfRequest::POST) 
    {
      if ($this->hasRequestParameter('filter_group'))
        $this->session->setAttribute('group', $this->getRequestParameter('filter_group'), "pol_{$ramo}_filter");

      if ($this->hasRequestParameter('filter_const'))
        $this->session->setAttribute('const', $this->getRequestParameter('filter_const'), "pol_{$ramo}_filter");

    }

    // legge sempre i filtri dalla sessione utente (quelli attivi)
    if (in_array('group', $active_filters))
      $this->filters['group'] = $this->session->getAttribute('group', '0', "pol_{$ramo}_filter");

    if (in_array('const', $active_filters))
      $this->filters['const'] = $this->session->getAttribute('const', '0', "pol_{$ramo}_filter");

  }

  /**
   * add filtering criteria to the criteria passed as an argument
   * being an object, the criteria is passed by reference and modifications
   * in the method modifies the referenced object
   *
   * @param Criteria $c 
   * @return void
   * @author Guglielmo Celata
   */
  protected function addFiltersCriteria($c)
  {
    // filtro per gruppo
    if (array_key_exists('group', $this->filters) && $this->filters['group'] != '0')
    {
      $c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID);
      $c->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $this->filters['group']);
    }

    // filtro per circoscrizione
    if (array_key_exists('const', $this->filters) && $this->filters['const'] != '0')
    {
      $c->addJoin(OppPoliticoPeer::ID, OppCaricaPeer::POLITICO_ID);
      $c->add(OppCaricaPeer::CIRCOSCRIZIONE, $this->filters['const']);
    }
     
  }




  
  protected function processSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/opp_carica/sort');
      $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/opp_carica/sort');
    }

    if (!$this->getUser()->getAttribute('sort', null, 'sf_admin/opp_carica/sort'))
    {
      $this->getUser()->setAttribute('sort', 'nome', 'sf_admin/opp_carica/sort');
    }
  }
  
  protected function addSortCriteria($c)
  {
    if ($sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/opp_carica/sort'))
    {
      if($sort_column!='nome')
	    $sort_column = OppCaricaPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      
	  if ($this->getUser()->getAttribute('type', null, 'sf_admin/opp_carica/sort') == 'asc')
      {
        if($sort_column=='nome')
		{
		  $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
	      $c->addAscendingOrderByColumn(OppPoliticoPeer::NOME);  
		}
		else
		  $c->addAscendingOrderByColumn($sort_column);
      }
      else
      {
        if($sort_column=='nome')
		{
		  $c->addDescendingOrderByColumn(OppPoliticoPeer::COGNOME);
	      $c->addDescendingOrderByColumn(OppPoliticoPeer::NOME);  
		}
		else
		$c->addDescendingOrderByColumn($sort_column);
      }
    }
  }
}

?>
