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
  * Executes Atto list action
  *
  */
  public function executeList()
  {
    $altri_atti = array(2,3,4,5,6,7,8,9,10,11,14); 
    $this->pager = new sfPropelPager('OppAtto', sfConfig::get('app_pagination_limit'));
    $c = new Criteria();
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$c->add(OppAttoPeer::TIPO_ATTO_ID, $altri_atti, Criteria::IN);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppTipoAtto');
    $this->pager->init();
    
  }

  /**
  * Executes Disegno di legge list action
  *
  */
  public function executeDisegnoList()
  {
    $this->pager = new sfPropelPager('OppAtto', sfConfig::get('app_atto_pagination_limit'));
    $c = new Criteria();
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$c->add(OppAttoPeer::TIPO_ATTO_ID, 1, Criteria::EQUAL);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelect');
    $this->pager->init();
    
    //$this->news = OppAttoPeer::doSelectNews();
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
    
    $this->pager = new sfPropelPager('OppAtto', sfConfig::get('app_atto_pagination_limit'));
    $c = new Criteria();
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$c->add(OppAttoPeer::TIPO_ATTO_ID, $atti_non_legislativi_ids, Criteria::IN);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppTipoAtto');
    $this->pager->init();
    
    
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
  
}