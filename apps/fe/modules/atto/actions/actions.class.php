<?php

/**
 * atto actions.
 *
 * @package    openparlamento
 * @subpackage atto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class attoActions extends sfActions
{
  /**
  * Executes Disegno di legge list action
  *
  */
  public function executeDisegnoList()
  {
    $this->processDisegnoListSort();
	
    $this->pager = new sfPropelPager('OppAtto', sfConfig::get('app_atto_pagination_limit'));
    $c = new Criteria();
	  $this->addDisegnoListSortCriteria($c);
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$c->add(OppAttoPeer::TIPO_ATTO_ID, 1, Criteria::EQUAL);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelect');
    $this->pager->init();
      
  }
  
  protected function processDisegnoListSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/opp_atto/sort');
      $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/opp_atto/sort');
    }

    if (!$this->getUser()->getAttribute('sort', null, 'sf_admin/opp_atto/sort'))
    {
	  $this->getUser()->setAttribute('sort', 'data_pres', 'sf_admin/opp_atto/sort');
      $this->getUser()->setAttribute('type', 'desc', 'sf_admin/opp_atto/sort');
    }
  }
  
  protected function addDisegnoListSortCriteria($c)
  {
    if ($sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/opp_atto/sort'))
    {
      $sort_column = OppAttoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      if ($this->getUser()->getAttribute('type', null, 'sf_admin/opp_atto/sort') == 'asc')
      {
        $c->addAscendingOrderByColumn($sort_column);
      }
      else
      {
        $c->addDescendingOrderByColumn($sort_column);
      }
    }
  }
  
  /**
  * Executes Decreto di legge list action
  *
  */
  public function executeDecretoList()
  {
    $this->pager = new sfPropelPager('OppAtto', sfConfig::get('app_atto_pagination_limit'));
    $c = new Criteria();
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$c->add(OppAttoPeer::TIPO_ATTO_ID, 12, Criteria::EQUAL);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelect');
    $this->pager->init();
    
    
  }
  
  /**
  * Executes Decreto legislativo list action
  *
  */
  public function executeDecretoLegislativoList()
  {
    $decreti_legislativi_ids = array('15','16','17');
    
    $this->pager = new sfPropelPager('OppAtto', sfConfig::get('app_atto_pagination_limit'));
    $c = new Criteria();
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$c->add(OppAttoPeer::TIPO_ATTO_ID, $decreti_legislativi_ids, Criteria::IN);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppTipoAtto');
    $this->pager->init();
  }
  
  /**
  * Executes Atto non legislativo list action
  *
  */
  public function executeAttoNonLegislativoList()
  {
    $atti_non_legislativi_ids = array('2','3','4','5','6','7','8','9','10','11','14');
    
	$this->processAttoNonLegislativoListSort();
	
    $this->pager = new sfPropelPager('OppAtto', sfConfig::get('app_atto_pagination_limit'));
    $c = new Criteria();
	$this->addAttoNonLegislativoListSortCriteria($c);
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$c->add(OppAttoPeer::TIPO_ATTO_ID, $atti_non_legislativi_ids, Criteria::IN);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppTipoAtto');
    $this->pager->init();
  }
  
  protected function processAttoNonLegislativoListSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/opp_atto/sort');
      $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/opp_atto/sort');
    }

    if (!$this->getUser()->getAttribute('sort', null, 'sf_admin/opp_atto/sort'))
    {
	  $this->getUser()->setAttribute('sort', 'data_pres', 'sf_admin/opp_atto/sort');
      $this->getUser()->setAttribute('type', 'asc', 'sf_admin/opp_atto/sort');
    }
  }
  
  protected function addAttoNonLegislativoListSortCriteria($c)
  {
    if ($sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/opp_atto/sort'))
    {
      $sort_column = OppAttoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      if ($this->getUser()->getAttribute('type', null, 'sf_admin/opp_atto/sort') == 'asc')
      {
        $c->addAscendingOrderByColumn($sort_column);
      }
      else
      {
        $c->addDescendingOrderByColumn($sort_column);
      }
    }
  }

  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $c = new Criteria();
    $c->add(OppAttoPeer::ID, $this->getRequestParameter('id'), Criteria::EQUAL );
    $c->setLimit(1);
    $this->atti = OppAttoPeer::doSelectJoinOppTipoAtto($c);
    $this->atto = $this->atti[0];
    $this->forward404Unless($this->atto);

    //individuazione link fonte
    if($this->atto->getTipoAttoId() == '1')
      $this->link = 'http://www.senato.it/leg/'.$this->atto->getLegislatura().'/BGT/Schede/Ddliter/'.$this->atto->getParlamentoId().'.htm';
    elseif($this->atto->getTipoAttoId() > '1' && $this->atto->getTipoAttoId() < '12' )
      $this->link = 'http://banchedati.camera.it/sindacatoispettivo_'.$this->atto->getLegislatura().'/showXhtml.Asp?idAtto='.$this->atto->getParlamentoId().'&stile=6&highLight=1';
    elseif($this->atto->getTipoAttoId() == '12' )
      $link = '#';
    elseif($this->atto->getTipoAttoId() == '14' )
    {
	  if($this->atto->getRamo()=='C')
        $this->link = 'http://www.camera.it/_dati/leg'.$this->atto->getLegislatura().'/lavori/stencomm/'.$this->atto->getNumfase().'/s010.htm';
      else
        $this->link = 'http://www.senato.it/leg/'.$this->atto->getLegislatura().'/BGT/Schede/ProcANL/ProcANLscheda'.$this->atto->getParlamentoId().'.htm';
    }  
    elseif($this->atto->getTipoAttoId() > '14' && $this->atto->getTipoAttoId() < '18' )
    {
      $str = $this->atto->getParlamentoId();
      $len = 5 - strlen($str);
      for($i=0; $i<$len; $i++)
        $str = '0'.$str;
      
	  $this->link = 'http://www.parlamento.it/leggi/deleghe/'.$str.'dl.htm';
    }
    
	//tipo di iniziativa
	$this->tipo_iniziativa = '';
	if($this->atto->getIniziativa())
	{
	  switch($this->atto->getIniziativa())
	  {
	    case '1':
		  $this->tipo_iniziativa = 'Parlamentare';
		  break;
		case '2':
          $this->tipo_iniziativa = 'di Governo';
		  break;
	    default:
		  $this->tipo_iniziativa = 'Popolare'; 	  		  
	  }
	}
	
    $pred = '';
    $pred_1 = '';
    if($this->atto->getPred())
    {
      $pred = $this->getPrimoPred($this->atto->getPred());
      $pred_1=$this->atto->getId();
    }  
    else
    {
  	  $pred = $this->atto->getId();
  	  $pred_1=$this->atto->getId();
    }	  
		
    $this->primi_firmatari = OppAttoPeer::doSelectPrimiFirmatari($pred);
	$this->co_firmatari = OppAttoPeer::doSelectCoFirmatari($pred);
	$this->relatori = OppAttoPeer::doSelectRelatori($pred_1);
	$this->commissioni = $this->atto->getCommissioni();
	
  	$this->status = $this->atto->getStatus();
	
  	$this->iter_completo = $this->atto->getIterCompleto();
	
  	$this->tesei = OppAttoPeer::doSelectTeseo($pred);
	
  	$this->lettura_parlamentare_precedente = null;
	
  	$leggi=$this->atto->getOppLegges();
  	if (count($leggi)>0) $this->legge=$leggi[0];
  	else $this->legge="";	
  	/*
  	$quale_atto=$this->getTuttiSucc($this->atto->getId());
  	if (count($quale_atto)==0) $leggi=$this->atto->getOppLegges();
  	else $leggi=$quale_atto[count($quale_atto)-1]->getOppLegges();
	
  	if (count($leggi)>0) $this->legge=$leggi[0];
  	else $this->legge="";
  	*/
	 
  	if($this->atto->getPred())
  	{
  	  $c = new Criteria();
            $c->add(OppAttoPeer::ID, $this->atto->getPred(), Criteria::EQUAL );
  	  $this->lettura_parlamentare_precedente = OppAttoPeer::doSelectOne($c);
  	}
	
  	$this->lettura_parlamentare_successiva = null;
	
  	if($this->atto->getSucc())
  	{
  	  $c = new Criteria();
      $c->add(OppAttoPeer::ID, $this->atto->getSucc(), Criteria::EQUAL );
  	  $this->lettura_parlamentare_successiva = OppAttoPeer::doSelectOne($c);
  	}
	
    $c = new Criteria();
    $c->add(OppVotazionePeer::ID, $this->atto->getIdVotazioni(), Criteria::IN);
    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
    $c->addDescendingOrderByColumn(OppVotazionePeer::FINALE);
    $this->votazioni = OppVotazionePeer::doSelectJoinOppSeduta($c);
	
  	$this->interventi = $this->atto->getInterventi();
	
     //PER RAPPRESENTAZIONE ITER
     // Tutti i PRED
     $quale_atto=$this->getTuttiPred($this->atto->getId());
     if (count($quale_atto)>0) {
        $this->rappresentazioni_pred = $this->atto->getIterRappresentazioni($quale_atto);
        $this->rappresentazioni_pred=array_reverse($this->rappresentazioni_pred);
     }   
     else
        $this->rappresentazioni_pred='';
     
     //TUTTI I SUCC
     $quale_atto=$this->getTuttiSucc($this->atto->getId());
     if (count($quale_atto)>0)
        $this->rappresentazioni_succ = $this->atto->getIterRappresentazioni($quale_atto);
     else
        $this->rappresentazioni_succ = '';
        
     $this->rappresentazioni_this=$this->atto->getIterRappresentazioni(array($this->atto->getId()));  
  }

  /**
   * Executes Ddl index action
   *
   */
  public function executeDdlIndex()
  {
    $c = new Criteria();
    $c->add(OppAttoPeer::ID, $this->getRequestParameter('id'), Criteria::EQUAL );
    $this->ddl = OppAttoPeer::doSelectOne($c);
    $this->forward404Unless($this->ddl); 

    $pred = '';
    $pred_1 = '';
    if($this->ddl->getPred())
    {
      $pred = $this->getPrimoPred($this->ddl->getPred());
      $pred_1=$this->ddl->getId();
    }  
    else
    {
  	  $pred = $this->ddl->getId();
  	  $pred_1=$this->ddl->getId();
    }	  
		
    $this->primi_firmatari = OppAttoPeer::doSelectPrimiFirmatari($pred);
	$this->co_firmatari = OppAttoPeer::doSelectCoFirmatari($pred);
	$this->relatori = OppAttoPeer::doSelectRelatori($pred_1);
	$this->commissioni = $this->ddl->getCommissioni();
	
  	$this->status = $this->ddl->getStatus();
	
  	$this->iter_completo = $this->ddl->getIterCompleto();
	
  	$this->tesei = OppAttoPeer::doSelectTeseo($pred);
	
  	$this->lettura_parlamentare_precedente = null;
	
  	$leggi=$this->ddl->getOppLegges();
  	if (count($leggi)>0) $this->legge=$leggi[0];
  	else $this->legge="";	
  	/*
  	$quale_atto=$this->getTuttiSucc($this->ddl->getId());
  	if (count($quale_atto)==0) $leggi=$this->ddl->getOppLegges();
  	else $leggi=$quale_atto[count($quale_atto)-1]->getOppLegges();
	
  	if (count($leggi)>0) $this->legge=$leggi[0];
  	else $this->legge="";
  	*/
	 
  	if($this->ddl->getPred())
  	{
  	  $c = new Criteria();
            $c->add(OppAttoPeer::ID, $this->ddl->getPred(), Criteria::EQUAL );
  	  $this->lettura_parlamentare_precedente = OppAttoPeer::doSelectOne($c);
  	}
	
  	$this->lettura_parlamentare_successiva = null;
	
  	if($this->ddl->getSucc())
  	{
  	  $c = new Criteria();
            $c->add(OppAttoPeer::ID, $this->ddl->getSucc(), Criteria::EQUAL );
  	  $this->lettura_parlamentare_successiva = OppAttoPeer::doSelectOne($c);
  	}
	
    $c = new Criteria();
    $c->add(OppVotazionePeer::ID, $this->ddl->getIdVotazioni(), Criteria::IN);
    $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
    $c->addDescendingOrderByColumn(OppVotazionePeer::FINALE);
    $this->votazioni = OppVotazionePeer::doSelectJoinOppSeduta($c);
	
  	$this->interventi = $this->ddl->getInterventi();
	
     //PER RAPPRESENTAZIONE ITER
     // Tutti i PRED
     $quale_atto=$this->getTuttiPred($this->ddl->getId());
     if (count($quale_atto)>0) {
        $this->rappresentazioni_pred = $this->ddl->getIterRappresentazioni($quale_atto);
        $this->rappresentazioni_pred=array_reverse($this->rappresentazioni_pred);
     }   
     else
        $this->rappresentazioni_pred='';
     
     //TUTTI I SUCC
     $quale_atto=$this->getTuttiSucc($this->ddl->getId());
     if (count($quale_atto)>0)
        $this->rappresentazioni_succ = $this->ddl->getIterRappresentazioni($quale_atto);
     else
        $this->rappresentazioni_succ = '';
        
     $this->rappresentazioni_this=$this->ddl->getIterRappresentazioni(array($this->ddl->getId()));   
     
  }


  /**
   * Executes protected method
   * for first pred
   * (only for ddl) 
   */   
  protected function getPrimoPred($pred)
  {
    while($pred!='')
    {
      $c = new Criteria();
      $c->add(OppAttoPeer::ID, $pred, Criteria::EQUAL );
      $ddl_pred = OppAttoPeer::doSelectOne($c);

      if($ddl_pred->getPred())
        $pred = $ddl_pred->getPred();
      else
        return $pred;
    }
  }
  
  /**
   * Executes protected method
   * for ALL pred
   * (only for ddl) 
   */
  protected function getTuttiPred($pred)
  {
    $all_pred= array();	
    
    while($pred!='')
    {
      $c = new Criteria();
      $c->add(OppAttoPeer::ID, $pred, Criteria::EQUAL );
      $ddl_pred = OppAttoPeer::doSelectOne($c);

      if($ddl_pred->getPred()) {
        array_push($all_pred, $ddl_pred->getPred());
        $pred = $ddl_pred->getPred();
        }
      else
        return $all_pred;
    }
    return $all_pred;
  }
  
  /**
   * Executes protected method
   * for ALL succ
   * (only for ddl) 
   */
  protected function getTuttiSucc($succ)
  {
    $all_succ= array();	
    while($succ!='')
    {
      $c = new Criteria();
      $c->add(OppAttoPeer::ID, $succ, Criteria::EQUAL );
      $ddl_succ = OppAttoPeer::doSelectOne($c);

      if($ddl_succ->getSucc()) {
        array_push($all_succ, $ddl_succ->getSucc());
        $succ = $ddl_succ->getSucc();
        }
      else
        return $all_succ;
    }
    return $all_succ;
  }
  
  public function executeDocumento()
  {
     $this->documento = OppDocumentoPeer::retrieveByPk($this->getRequestParameter('id'));
     $this->forward404Unless($this->documento);
     
     $c = new Criteria();
     $cton1 = $c->getNewCriterion(OppDocumentoPeer::ATTO_ID, $this->documento->getAttoId(), Criteria::EQUAL);
     $cton2 = $c->getNewCriterion(OppDocumentoPeer::ID, $this->getRequestParameter('id'), Criteria::NOT_IN);
     $cton1->addAnd($cton2);
     $c->add($cton1);
     $this->documenti_correlati = OppDocumentoPeer::doSelect($c);
  
  }
  
}