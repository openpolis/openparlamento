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

  public function preExecute()
  {
    // must reset all filters , except acts_filters
    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'module', 'module', 
                                                  array('votes_filter', 'sf_admin/opp_votazione/sort',
                                                        'pol_camera_filter', 'pol_senato_filter', 'sf_admin/opp_carica/sort',
                                                        'argomento/atti_filter', 'argomento_leggi/sort', 'argomento_nonleg/sort',
                                                        'monitoring_filter'));

  }

  /**
   * reset filters and sort session variables when
   * the action changes
   *
   * @return void
   * @author Guglielmo Celata
   */
  protected function _reset_session_vars()
  {    
    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'action', 'acts_action', 
                                                  array('acts_filter', 'sf_admin/opp_atto/sort'));
  }

  /**
   * check request parameters and set session values for the filters
   * reads filters from session, so that a clean url builds up with user's values
   *
   * @param  array $active_filters an array of all the active filters
   * @return void
   * @author Guglielmo Celata
   */
  protected function processFilters($active_filters)
  {

    $filters = array();

    // legge i filtri dalla request e li scrive nella sessione utente
  
    if ($this->hasRequestParameter('filter_tags_category'))
      $this->session->setAttribute('tags_category', $this->getRequestParameter('filter_tags_category'), 'acts_filter');

    if ($this->hasRequestParameter('filter_initiative_type'))
      $this->session->setAttribute('initiative_type', $this->getRequestParameter('filter_initiative_type'), 'acts_filter');

    if ($this->hasRequestParameter('filter_act_ramo'))
      $this->session->setAttribute('act_ramo', $this->getRequestParameter('filter_act_ramo'), 'acts_filter');

    if ($this->hasRequestParameter('filter_act_stato'))
      $this->session->setAttribute('act_stato', $this->getRequestParameter('filter_act_stato'), 'acts_filter');

    if ($this->hasRequestParameter('filter_act_type'))
      $this->session->setAttribute('act_type', $this->getRequestParameter('filter_act_type'), 'acts_filter');



    // legge sempre i filtri dalla sessione utente (quelli attivi)
    if (in_array('tags_category', $active_filters))
      $filters['tags_category'] = $this->session->getAttribute('tags_category', '0', 'acts_filter');

    if (in_array('initiative_type', $active_filters))
      $filters['initiative_type'] = $this->session->getAttribute('initiative_type', '0', 'acts_filter');

    if (in_array('act_ramo', $active_filters))
      $filters['act_ramo'] = $this->session->getAttribute('act_ramo', '0', 'acts_filter');

    if (in_array('act_stato', $active_filters))
      $filters['act_stato'] = $this->session->getAttribute('act_stato', '0', 'acts_filter');    

    if (in_array('act_type', $active_filters))
      $filters['act_type'] = $this->session->getAttribute('act_type', '0', 'acts_filter');    

    $this->filters = $filters;

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
    // filtro per ramo
    if (array_key_exists('act_ramo', $this->filters) && $this->filters['act_ramo'] != '0')
      $c->add(OppAttoPeer::RAMO, $this->filters['act_ramo']);
    
    // filtro per stato di avanzamento
    if (array_key_exists('act_stato', $this->filters) && $this->filters['act_stato'] != '0')
      $c->add(OppAttoPeer::STATO_COD, $this->filters['act_stato']);      

    // filtro per tipo di iniziativa
    if (array_key_exists('initiative_type', $this->filters) && $this->filters['initiative_type'] != '0')
      $c->add(OppAttoPeer::INIZIATIVA, $this->filters['initiative_type']);      

    // filtro per tipo di decreto legislativo
    if (array_key_exists('act_type', $this->filters) && $this->filters['act_type'] != '0')
      $c->add(OppAttoPeer::TIPO_ATTO_ID, $this->filters['act_type']);
    
    // filtro per categoria
    if (array_key_exists('tags_category', $this->filters) && $this->filters['tags_category'] != '0')
    {
      $c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
      $c->addJoin(TagPeer::ID, OppTagHasTtPeer::TAG_ID);
      $c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
      $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
      $c->add(OppTagHasTtPeer::TESEOTT_ID, $this->filters['tags_category']);
      $c->setDistinct();
    }    

    
  }

  /**
  * Executes Disegno di legge list action
  *
  */
  public function executeDisegnoList()
  {
    
    $this->session = $this->getUser();
    
    $this->query = $this->getRequestParameter('query', '');
    
    $this->getResponse()->setTitle('disegni di legge - '.sfConfig::get('app_main_title'));
    
    // estrae tutte le macrocategorie, per costruire la select
    $this->all_tags_categories = OppTeseottPeer::doSelect(new Criteria());        

    // reset di filtri e ordinamento se cambio modulo
    $this->_reset_session_vars();
    
    $this->session = $this->getUser();

    // reset dei filtri
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_tags_category', '0');
      $this->getRequest()->getParameterHolder()->set('filter_initiative_type', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_stato', '0');      
    }

    $this->processFilters(array('tags_category', 'initiative_type', 'act_ramo', 'act_stato'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_tags_category') == '0' &&
        $this->getRequestParameter('filter_initiative_type') == '0' &&
        $this->getRequestParameter('filter_act_ramo') == '0' && 
        $this->getRequestParameter('filter_act_stato') == '0')
    {
      $this->redirect('@attiDisegni');
    }

    $this->processDisegnoListSort();

    if ($this->hasRequestParameter('itemsperpage'))
    $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $this->pager = new sfPropelPager('OppAtto', $itemsperpage);
    $c = new Criteria();

    $this->addFiltersCriteria($c);    
    $this->addDisegnoListSortCriteria($c);

    $c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
    $c->add(OppAttoPeer::TIPO_ATTO_ID, 1, Criteria::EQUAL);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelect');
    $this->pager->init();

    // estrazione data ultimo aggiornamento
    $c = new Criteria();
    $c->addDescendingOrderByColumn(OppAttoPeer::DATA_AGG);
    $c->add(OppAttoPeer::TIPO_ATTO_ID, 1, Criteria::EQUAL);
    $this->last_updated_item = OppAttoPeer::doSelectOne($c);      
   
  }


  protected function processDisegnoListSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->session->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/opp_atto/sort');
      $this->session->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/opp_atto/sort');
    }

    if (!$this->session->getAttribute('sort', null, 'sf_admin/opp_atto/sort'))
    {
      $this->session->setAttribute('sort', 'data_pres', 'sf_admin/opp_atto/sort');
      $this->session->setAttribute('type', 'desc', 'sf_admin/opp_atto/sort');
    }
  }
  
  protected function addDisegnoListSortCriteria($c)
  {
    if ($sort_column = $this->session->getAttribute('sort', null, 'sf_admin/opp_atto/sort'))
    {
      $sort_column = OppAttoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      if ($this->session->getAttribute('type', null, 'sf_admin/opp_atto/sort') == 'asc')
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
    
    $this->session = $this->getUser();
   
    $this->query = $this->getRequestParameter('query', '');
    
    $this->getResponse()->setTitle('decreti legge - '.sfConfig::get('app_main_title'));

    // estrae tutte le macrocategorie, per costruire la select
    $this->all_tags_categories = OppTeseottPeer::doSelect(new Criteria());        

    // reset di filtri e ordinamento se cambio modulo
    $this->_reset_session_vars();

    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_tags_category', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_stato', '0');      
    }


    $this->processFilters(array('tags_category', 'act_stato'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_tags_category') == '0' &&
        $this->getRequestParameter('filter_act_stato') == '0')
    {
      $this->redirect('@attiDecretiLegge');
    }


    $this->processDecretoListSort();
    

    
    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $this->pager = new sfPropelPager('OppAtto', $itemsperpage);
    $c = new Criteria();
    $this->addFiltersCriteria($c);    
    $this->addDecretoListSortCriteria($c);

    $c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
    $c->add(OppAttoPeer::TIPO_ATTO_ID, 12, Criteria::EQUAL);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelect');
    $this->pager->init();

    // estrazione data ultimo aggiornamento
    $c = new Criteria();
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_AGG);
  	$c->add(OppAttoPeer::TIPO_ATTO_ID, 12, Criteria::EQUAL);
  	$this->last_updated_item = OppAttoPeer::doSelectOne($c);    
    
  }

  protected function processDecretoListSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->session->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/opp_atto/sort');
      $this->session->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/opp_atto/sort');
    }

    if (!$this->session->getAttribute('sort', null, 'sf_admin/opp_atto/sort'))
    {
      $this->session->setAttribute('sort', 'data_pres', 'sf_admin/opp_atto/sort');
      $this->session->setAttribute('type', 'desc', 'sf_admin/opp_atto/sort');
    }
  }
  
  protected function addDecretoListSortCriteria($c)
  {
    if ($sort_column = $this->session->getAttribute('sort', null, 'sf_admin/opp_atto/sort'))
    {
      $sort_column = OppAttoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      if ($this->session->getAttribute('type', null, 'sf_admin/opp_atto/sort') == 'asc')
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
  * Executes Decreto legislativo list action
  *
  */
  public function executeDecretoLegislativoList()
  {
    $this->session = $this->getUser();

    $this->query = $this->getRequestParameter('query', '');
    
     $this->getResponse()->setTitle(sfConfig::get('app_main_title') . ' - decreti legislativi');

    $decreti_legislativi_ids = array('15','16','17');

    // estrae tutte le macrocategorie, per costruire la select
    $this->all_tags_categories = OppTeseottPeer::doSelect(new Criteria());        

    // reset di filtri e ordinamento se cambio modulo
    $this->_reset_session_vars();

    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_tags_category', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_type', '0');      
    }


    $this->processFilters(array('tags_category', 'act_type'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_tags_category') == '0' &&
        $this->getRequestParameter('filter_act_type') == '0')
    {
      $this->redirect('@attiDecretiLegislativi');
    }
    
    $this->processDecretoLegislativoListSort();

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));
    
    $this->pager = new sfPropelPager('OppAtto', $itemsperpage);
    $c = new Criteria();
    $this->addFiltersCriteria($c);    
    $this->addDecretoLegislativoListSortCriteria($c);
    $c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
    $c->add(OppAttoPeer::TIPO_ATTO_ID, $decreti_legislativi_ids, Criteria::IN);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppTipoAtto');
    $this->pager->init();
    
    // estrazione data ultimo aggiornamento
    $c = new Criteria();
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_AGG);
  	$c->add(OppAttoPeer::TIPO_ATTO_ID, $decreti_legislativi_ids, Criteria::IN);
  	$this->last_updated_item = OppAttoPeer::doSelectOne($c);
    
  }
  
  protected function processDecretoLegislativoListSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->session->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/opp_atto/sort');
      $this->session->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/opp_atto/sort');
    }

    if (!$this->session->getAttribute('sort', null, 'sf_admin/opp_atto/sort'))
    {
      $this->session->setAttribute('sort', 'data_pres', 'sf_admin/opp_atto/sort');
      $this->session->setAttribute('type', 'desc', 'sf_admin/opp_atto/sort');
    }
  }
  
  protected function addDecretoLegislativoListSortCriteria($c)
  {
    if ($sort_column = $this->session->getAttribute('sort', null, 'sf_admin/opp_atto/sort'))
    {
      $sort_column = OppAttoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      if ($this->session->getAttribute('type', null, 'sf_admin/opp_atto/sort') == 'asc')
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
  * Executes Atto non legislativo list action
  *
  */
  public function executeAttoNonLegislativoList()
  {
    $this->session = $this->getUser();

    $this->query = $this->getRequestParameter('query', '');
    
    $this->getResponse()->setTitle('atti non legislativi - '.sfConfig::get('app_main_title'));

    $atti_non_legislativi_ids = array('2','3','4','5','6','7','8','9','10','11','14');

    // estrae tutte le macrocategorie, per costruire la select
    $this->all_tags_categories = OppTeseottPeer::doSelect(new Criteria());        

    // reset di filtri e ordinamento se cambio modulo
    $this->_reset_session_vars();

    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_tags_category', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_type', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_stato', '0');      
    }

    $this->processFilters(array('tags_category', 'act_type', 'act_ramo', 'act_stato'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_tags_category') == '0' &&
        $this->getRequestParameter('filter_act_type') == '0' &&
        $this->getRequestParameter('filter_act_ramo') == '0' &&
        $this->getRequestParameter('filter_act_stato') == '0')
    {
      $this->redirect('@attiNonLegislativi');
    }

  	$this->processAttoNonLegislativoListSort();
	
    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $this->pager = new sfPropelPager('OppAtto', $itemsperpage);
    $c = new Criteria();
	  $this->addAttoNonLegislativoListSortCriteria($c);
    $c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
    $c->add(OppAttoPeer::TIPO_ATTO_ID, $atti_non_legislativi_ids, Criteria::IN);
    $this->addFiltersCriteria($c);    
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppTipoAtto');
    $this->pager->init();

    // estrazione data ultimo aggiornamento
    $c = new Criteria();
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_AGG);
    $c->add(OppAttoPeer::TIPO_ATTO_ID, $atti_non_legislativi_ids, Criteria::IN);
  	$this->last_updated_item = OppAttoPeer::doSelectOne($c);
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

  public function executeCommenti()
  {
    $this->atto = OppAttoPeer::retrieveByPK($this->getRequestParameter('id'));
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
    
    $this->getResponse()->setTitle($this->atto->getOppTipoAtto()->getDescrizione().' '.$this->atto->getRamo().'. '.$this->atto->getNumfase().' '.Text::denominazioneAtto($this->atto, 'index').' - '.sfConfig::get('app_main_title'));
    
    
    //individuazione link fonte
    if($this->atto->getTipoAttoId() == '1')
      $this->link = 'http://www.senato.it/leg/'.$this->atto->getLegislatura().'/BGT/Schede/Ddliter/'.$this->atto->getParlamentoId().'.htm';
    elseif($this->atto->getTipoAttoId() > '1' && $this->atto->getTipoAttoId() < '12' )
      $this->link = 'http://banchedati.camera.it/sindacatoispettivo_'.$this->atto->getLegislatura().'/showXhtml.Asp?idAtto='.$this->atto->getParlamentoId().'&stile=6&highLight=1';
    elseif($this->atto->getTipoAttoId() == '12' )
    {
      $anno=explode("-",$this->atto->getDataPres());
      $numero=explode("/",$this->atto->getNumfase());
      $this->link="http://www.normattiva.it/uri-res/N2Ls?urn:nir:stato:decreto.legge:".$anno[0].";".$numero[0];
    }
   
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
      
	  $this->link = 'http://www.camera.it/parlam/leggi/deleghe/'.$str.'dl.htm';
    }
    if($this->atto->getTipoAttoId() == '13') $this->link = 'http://www.governo.it/GovernoInforma/Comunicati/testo_int.asp?d='.$this->atto->getParlamentoId();   
    
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
		
    $this->primi_firmatari = OppAttoPeer::doSelectPrimiFirmatari($this->atto->getId());
    $this->co_firmatari = OppAttoPeer::doSelectCoFirmatari($this->atto->getId());
    $this->relatori = OppAttoPeer::doSelectRelatori($this->atto->getId());
    $this->commissioni = $this->atto->getCommissioni();
	
  	$this->status = $this->atto->getStatus();
	
  	$this->iter_completo = $this->atto->getIterCompleto();
	
  	$this->tesei = OppAttoPeer::doSelectTeseo($pred);
	
  	$this->lettura_parlamentare_precedente = null;
	
	$this->legge= null;
	
	$c = new Criteria();
        $c->add(OppLeggePeer::ATTO_ID, $this->atto->getId(), Criteria::EQUAL );
  	$this->legge = OppLeggePeer::doSelectOne($c);
  	if ($this->legge == null )
  	{
  	    $quale_atto=$this->getTuttiSucc($this->atto->getId());
  	    if (count($quale_atto)>0) 
  	    {
  	       $c = new Criteria();
               $c->add(OppLeggePeer::ATTO_ID, end($quale_atto), Criteria::EQUAL );
  	       $this->legge = OppLeggePeer::doSelectOne($c); 
  	    }   
  	}   
  	 

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
  	
  	$this->lettura_parlamentare_ultima = null;
	
	$quale_atto=$this->getTuttiSucc($this->atto->getId());
     
  	if (count($quale_atto)>0) 
  	{
  	  $c = new Criteria();
          $c->add(OppAttoPeer::ID, end($quale_atto), Criteria::EQUAL );
  	  $this->lettura_parlamentare_ultima = OppAttoPeer::doSelectOne($c);
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
    if (count($quale_atto)>0) {
           $this->rappresentazioni_succ = $this->atto->getIterRappresentazioni($quale_atto);   
    }       
    else
      $this->rappresentazioni_succ = '';
      
    $this->rappresentazioni_this=$this->atto->getIterRappresentazioni(array($this->atto->getId()));
    
    //Controlla se this e' diventato legge
    
    $this->leggi_this = $this->atto->getIterLegge(array($this->atto->getId()));          

    
    //Controlla se succ e' diventato legge
    if (count($quale_atto)>0) {
           $this->leggi_succ = $this->atto->getIterLegge($quale_atto);   
    }       
    else
      $this->leggi_succ = '';
    
	
	//titolo del wiki
	switch($this->atto->getTipoAttoId())
    {
      case '1':
	$this->titolo_wiki = "cosa sono i disegni di legge";  
        break;
      case '2':
	$this->titolo_wiki = "cosa sono le mozioni";  
        break;
      case '3':
	$this->titolo_wiki = "cosa sono le interpellanze";  
        break;      
      case '4':
	$this->titolo_wiki = "cosa sono le interrogazioni a risposta orale";  
        break;   
      case '5':
	$this->titolo_wiki = "cosa sono le interrogazioni a risposta scritta";  
        break;   
      case '6':
	$this->titolo_wiki = "cosa sono le interrogazioni in commissione";  
        break; 
      case '7':
	$this->titolo_wiki = "cosa sono le risoluzioni in assemblea";  
        break;
      case '8':
	$this->titolo_wiki = "cosa sono le risoluzioni in commissione";  
        break;
      case '9':
	$this->titolo_wiki = "cosa sono le risoluzioni conclusive";  
        break;
      case '10':
	$this->titolo_wiki = "cosa sono gli ordini del giorno in assemblea";  
        break;  
      case '11':
	$this->titolo_wiki = "cosa sono gli ordini del giorno in commissione";  
        break;                       
      case '12': 
        $this->titolo_wiki = "cosa sono i decreti legge";  
        break;
      case '13': 
        $this->titolo_wiki = "cosa sono i comunicati del governo";  
        break;
      case '14': 
        $this->titolo_wiki = "cosa sono le audizioni";  
        break;    
      case '15':
      case '16':
      case '17':
        $this->titolo_wiki = "cosa sono i decreti legislativi";  
        break;
      default:
        $this->titolo_wiki = "";  
        break;
    }      
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
     
     $this->getResponse()->setTitle($this->documento->getOppAtto()->getOppTipoAtto()->getDescrizione().' '.$this->documento->getOppAtto()->getRamo().'. '.$this->documento->getOppAtto()->getNumfase().' / '.$this->documento->getTitolo().' - '.sfConfig::get('app_main_title'));
     
     $c = new Criteria();
     $cton1 = $c->getNewCriterion(OppDocumentoPeer::ATTO_ID, $this->documento->getAttoId(), Criteria::EQUAL);
     $cton2 = $c->getNewCriterion(OppDocumentoPeer::ID, $this->getRequestParameter('id'), Criteria::NOT_IN);
     $cton1->addAnd($cton2);
     $c->add($cton1);
     $this->documenti_correlati = OppDocumentoPeer::doSelect($c);
  
  }
  
  
  public function executeWidget()
  {
    function tronca($testo, $caratteri) 
    { 

        if (strlen($testo) <= $caratteri) return $testo; 
        $nuovo = wordwrap($testo, $caratteri, "|"); 
        $nuovotesto=explode("|",$nuovo); 
        return $nuovotesto[0]."..."; 
    }
    
    $this->bg_color=$this->getRequestParameter('bg_color');
    $this->text_color=$this->getRequestParameter('textcolor');
    $this->pos=$this->getRequestParameter('pos');
   // $this->border_color=retrieveByPk($this->getRequestParameter('border_color'));
    $atto=OppAttoPeer::retrieveByPk($this->getRequestParameter('bill_id'));
    
    $this->id=$atto->getId();
    $this->tipo=$atto->getOppTipoAtto()->getDescrizione();
    if (substr_count($this->tipo,'interrogazione')>0) $this->tipo='interrrogazione';
    if (substr_count($this->tipo,'risoluzione')>0) $this->tipo='risoluzione';
    if (substr_count($this->tipo,'odg')>0) $this->tipo='ordine del giorno';
    if (substr_count($this->tipo,'dlgs')>0) $this->tipo='dlgs';
    $this->ramo=$atto->getRamo();
    $this->numfase=$atto->getNumfase();
    $this->datapres=$atto->getDataPres();
    $this->status=$atto->getStatoFase();
    $this->status_data=$atto->getStatoLastDate();
    $this->fav=$atto->getUtFav();
    $this->contr=$atto->getUtContr();
    $this->monitor=$atto->getNMonitoringUsers();
    $this->commenti=$atto->getNbPublicComments();
    
    $titolo="";
    $titolos=explode(" ",Text::denominazioneAtto($atto, 'list'));

    for ($x=1;$x<count($titolos); $x++)
    {
      $titolo=$titolo." ".$titolos[$x];
    }
    $this->titolo=tronca(trim($titolo),180);

    
    
    $f_signers= OppAttoPeer::doSelectPrimiFirmatari($atto->getId());
    if (count($f_signers)>0)
    {
      $this->firmatario=OppPoliticoPeer::retrieveByPk(key($f_signers));
    }
  }
  
  public function executeConfWidget()
  {
    $this->id=$this->getRequestParameter('id');
    $this->pos=$this->getRequestParameter('pos');
    $this->atto=OppAttoPeer::retrieveByPk($this->getRequestParameter('id'));
  }
  public function executeStatistiche()
  {
    
  }    
  
}