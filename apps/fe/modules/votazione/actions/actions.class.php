<?php

/**
 * votazione actions.
 *
 * @package    openparlamento
 * @subpackage votazione
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class votazioneActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $c = new Criteria();
    $c->add(OppVotazionePeer::ID, $this->getRequestParameter('id'), Criteria::EQUAL );
    $this->votazione = OppVotazionePeer::doSelectJoinOppSeduta($c);
    $this->votazione = $this->votazione[0];
    $this->forward404Unless($this->votazione);  

    $this->ramo = $this->votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato' ; 

    $this->risultati = OppVotazioneHasCaricaPeer::doSelectGroupByGruppo($this->getRequestParameter('id'));

    $this->ribelli = $this->votazione->getRibelli();

    //$gruppi = sfYaml::load(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps/fe/config/gruppi.yml');
    //$this->gruppi_votazione = $gruppi['legislatura_'.$this->votazione->getOppSeduta()->getLegislatura()][$this->ramo];	

    $this->processSort();

    $c1 = new Criteria();
    $this->addSortCriteria($c1);

    $c1->clearSelectColumns();
    $c1->addSelectColumn(OppPoliticoPeer::ID);
    $c1->addSelectColumn(OppPoliticoPeer::COGNOME);
    $c1->addSelectColumn(OppPoliticoPeer::NOME);
    $c1->addSelectColumn(OppGruppoPeer::NOME);
    $c1->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
    $c1->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);

    $c1->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::INNER_JOIN);
    $c1->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);
	$c1->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID, Criteria::INNER_JOIN);
	$c1->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID, Criteria::INNER_JOIN);
	  
	$c1->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $this->votazione->getId(), Criteria::EQUAL);
	$c1->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $this->votazione->getOppSeduta()->getData(), Criteria::LESS_EQUAL);
	  
	$cton1 = $c1->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, $this->votazione->getOppSeduta()->getData(), Criteria::GREATER_EQUAL);
	$cton2 = $c1->getNewCriterion(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);
	$cton1->addOr($cton2);
    $c1->add($cton1);
	  
	$c1->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
	$this->votanti = OppVotazioneHasCaricaPeer::doSelectRS($c1);
  }

  protected function processSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), 'opp_votazione/sort');
      $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'opp_votazione/sort');
    }
  }
  
  protected function addSortCriteria (&$c)
  {
    if ($sort_column = $this->getUser()->getAttribute('sort', NULL, 'opp_votazione/sort'))
    {
      switch($this->getUser()->getAttribute('sort', NULL, 'opp_votazione/sort'))
      {
        case 'parlamentare':
          $sort_column = OppPoliticoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
          break;
        case 'gruppo':
          $sort_column = 'nome';
          $sort_column = OppGruppoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
          break;
        case 'circoscrizione':
          $sort_column = OppCaricaPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
          break;
        case 'voto':
          $sort_column = OppVotazioneHasCaricaPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
          break;
      }

      if ($this->getUser()->getAttribute('type', NULL, 'opp_votazione/sort') == 'asc')
        $c->addAscendingOrderByColumn($sort_column);
      else
        $c->addDescendingOrderByColumn($sort_column);
      		  
    }
  }
}

?>