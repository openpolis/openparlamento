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
     $this->processFilters();

     $this->filters = $this->getUser()->getAttributeHolder()->getAll('opp_parlamentare/filters');
	 
	 
	 $c = new Criteria();
	 $this->addFiltersCriteria($c);
	 
	 $c->clearSelectColumns();
	 $c->addSelectColumn(OppCaricaPeer::ID);
	 $c->addSelectColumn(OppPoliticoPeer::ID);
	 $c->addSelectColumn(OppPoliticoPeer::COGNOME);
	 $c->addSelectColumn(OppPoliticoPeer::NOME);
	 $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
	 $c->addSelectColumn(OppCaricaPeer::PRESENZE);
	 $c->addSelectColumn(OppCaricaPeer::INDICE);
	 $c->addSelectColumn(OppCaricaPeer::POSIZIONE);
	 $c->addSelectColumn(OppCaricaPeer::MEDIA);
	 $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);
	 $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
	 $c->addAscendingOrderByColumn(OppPoliticoPeer::NOME);
	 
	 $c->setLimit(50);
	 
     $this->parlamentari = OppCaricaPeer::doSelectRS($c);
	 
	 $c = new Criteria();
	 $c->addJoin(OppSedutaPeer::ID, OppVotazionePeer::SEDUTA_ID, Criteria::LEFT_JOIN);
	 $c->add(OppSedutaPeer::LEGISLATURA, $this->getUser()->getAttribute('legislatura'), Criteria::EQUAL );
	 $c->add(OppSedutaPeer::RAMO, $this->getUser()->getAttribute('ramo'), Criteria::EQUAL );
	 $this->numero_votazioni = OppVotazionePeer::doCount($c);
	 
	 $c = new Criteria();
	 $c->add(OppCaricaPeer::LEGISLATURA, $this->getUser()->getAttribute('legislatura'), Criteria::EQUAL);
	 $c->add(OppCaricaPeer::CARICA, $this->getUser()->getAttribute('carica'), Criteria::EQUAL);
	 $this->numero_parlamentari = OppCaricaPeer::doCount($c);
     
  }
  
  protected function processFilters()
  {
    if ($this->getRequestParameter('legislatura'))
	  $this->getUser()->setAttribute('legislatura', $this->getRequestParameter('legislatura'));
		
	if (!($this->getUser()->hasAttribute('legislatura')))
	  $this->getUser()->setAttribute('legislatura', 16);
    
	if ($this->getRequestParameter('carica'))
	  $this->getUser()->setAttribute('carica', $this->getRequestParameter('carica'));
			
	if (!($this->getUser()->hasAttribute('carica')))
	  $this->getUser()->setAttribute('carica', 'Deputato');
		    
    if($this->getUser()->getAttribute('carica')=='Deputato')
      $this->getUser()->setAttribute('ramo', 'C');
	else
	  $this->getUser()->setAttribute('ramo', 'S');    
  }

  protected function addFiltersCriteria($c)
  {
      if ($this->getUser()->getAttribute('legislatura') != '16')
        $c->add(OppCaricaPeer::LEGISLATURA, $this->getUser()->getAttribute('legislatura'));
	  else
	    $c->add(OppCaricaPeer::LEGISLATURA, '16', Criteria::EQUAL);
	
	  if ($this->getUser()->getAttribute('carica') == 'Deputato')
        $c->add(OppCaricaPeer::CARICA, $this->getUser()->getAttribute('carica'));
	  else
	    $c->add(OppCaricaPeer::CARICA, 'Senatore', Criteria::EQUAL);
			
  }
}

?>
