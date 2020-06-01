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
  
  public function preExecute()
  {
    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'module', 'module', 
                                                  array('acts_filter', 'sf_admin/opp_atto/sort',
                                                        'votes_filter', 'sf_admin/opp_votazione/sort',
                                                        'argomento/atti_filter', 'argomento_leggi/sort', 'argomento_nonleg/sort',
                                                        'monitoring_filter'));
  }


  public function executeTabellaDelta()
  {
    $this->data = $this->getRequestParameter('data');
    $this->mesi = $this->getRequestParameter('mesi');
    $this->ramo = $this->getRequestParameter('ramo');
    $this->dato = $this->getRequestParameter('dato');

    // calcolo date fine mese scorso e n_mesi prima
    list($this->data_2, $this->data_1) = Util::getLastNMonthsDates($this->data, $this->mesi);

    $this->parlamentari_rs = OppPoliticianHistoryCachePeer::getDeltaPoliticiRSByDataRamo($this->data_1, $this->data_2, $this->ramo, $this->dato);
    
    if ($this->data_2 == 0) {
      $leg = OppLegislaturaPeer::getActive();
      $this->data_2 = OppLegislaturaPeer::$legislature[$leg]['data_inizio'];
    }
  }


  /**
   * verifica il parametro id e carica gli oggetti OppPolitico e OppCarica (quella attuale)
   *
   * @return void
   * @author Guglielmo Celata
   */
  protected function _getAndCheckParlamentare()
  {
    $this->parlamentare = OppPoliticoPeer::RetrieveByPk($this->getRequestParameter('id'));
	  $this->forward404Unless($this->parlamentare); 
	  $this->carica = $this->parlamentare->getCaricaDepSenCorrente();
  }
  
  public function executeCosa()
  {
    $this->_getAndCheckParlamentare(); 
   
    if ($this->carica)
    {
  	  $this->id_gruppo_corrente = $this->parlamentare->getGruppoCorrente()->getId();
  	  $this->acronimo_gruppo_corrente = $this->parlamentare->getGruppoCorrente()->getAcronimo();
  	  //$this->gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($this->carica->getId());
	  $this->gruppi = OppCaricaHasGruppoPeer::doSelectTuttiGruppiPerCarica($this->carica->getId());
  
  	  $this->circoscrizione = $this->carica->getCircoscrizione();	  
      // $this->cariche = $this->parlamentare->getAltreCariche();
    

      // reset sessioni utente filtri e ordinamento
      $this->session = $this->getUser();
      $this->session->getAttributeHolder()->removeNamespace('acts_filter');
      $this->session->getAttributeHolder()->removeNamespace('opp_parlamentare_atti/sort');
      $this->session->getAttributeHolder()->removeNamespace('votes_filter');
      $this->session->getAttributeHolder()->removeNamespace('opp_parlamentare_voti/sort');
	  
      $c= new Criteria();
      $c->addJoin(OppSedutaPeer::ID,OppVotazionePeer::SEDUTA_ID);
      
      if ($this->carica->getTipoCaricaId() == 1) $ramo = 'C';
      if ($this->carica->getTipoCaricaId() == 4 || $this->carica->getTipoCaricaId() == 5) $ramo = 'S';
      $this->ramo = $ramo=='C' ? 'camera' : 'senato';
      if ($this->ramo=='camera')
      {
         $this->getResponse()->setTitle('On. '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - cosa fa in parlamento - '.sfConfig::get('app_main_title'));
         $c->add(OppSedutaPeer::RAMO,'C');
      }   
      else
      {
         $this->getResponse()->setTitle('Sen. '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - cosa fa in parlamento - '.sfConfig::get('app_main_title'));
         $c->add(OppSedutaPeer::RAMO,'S');
      }
      
      $this->response->addMeta('description','Come vota, quali atti presenta, a chi &egrave; pi&ugrave; vicino, quanto &egrave; presente, l\'indice di produttivit&agrave; di '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome(),true);
      
      $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
      $result=OppSedutaPeer::doSelectOne($c);
      $this->ultima_votazione=$result->getData();
      $nparl = OppCaricaPeer::getNParlamentari($ramo);
	  
      $this->presenze = $this->carica->getPresenze();
      $this->assenze = $this->carica->getAssenze();
      $this->missioni = $this->carica->getMissioni();
      $this->nvotazioni = $this->presenze + $this->assenze + $this->missioni;
      $this->presenze_perc = $this->presenze * 100 / $this->nvotazioni;
      $this->assenze_perc = $this->assenze * 100 / $this->nvotazioni;
      $this->missioni_perc = $this->missioni * 100 / $this->nvotazioni;

      $this->presenze_media = OppCaricaPeer::getSomma('presenze', $ramo) / $nparl;
      $this->assenze_media = OppCaricaPeer::getSomma('assenze', $ramo) / $nparl;    
      $this->missioni_media = OppCaricaPeer::getSomma('missioni', $ramo) / $nparl;
      $this->nvotazioni_media = $this->presenze_media + $this->assenze_media + $this->missioni_media;

      $this->presenze_media_perc = $this->presenze_media * 100 / $this->nvotazioni_media;
      $this->assenze_media_perc = $this->assenze_media * 100 / $this->nvotazioni_media;
      $this->missioni_media_perc = $this->missioni_media * 100 / $this->nvotazioni_media;

      // calcolo totale ribellioni e presenze ai fini del calcolo delle perc. a partire dai gruppi
      $pres_ribelli = 0;
      $ribellioni = 0;
      foreach ($this->gruppi as $acronimo => $gruppo) {
        $pres_ribelli += $gruppo['presenze'];
        $ribellioni += $gruppo['ribelle'];
      }
      $this->nvoti_validi = $pres_ribelli;
      $pres_ribelli_media = OppCaricaHasGruppoPeer::getSomma('presenze', $ramo) / $nparl;

      $this->ribelli = $ribellioni;
      if ($ribellioni == 0)
        $this->ribelli_perc = 0;
      else
        $this->ribelli_perc = $ribellioni * 100 / $this->nvoti_validi;

      $this->ribelli_media = OppCaricaHasGruppoPeer::getSomma('ribelle', $ramo) / $nparl;
      $this->ribelli_media_perc = $this->ribelli_media * 100 / $pres_ribelli_media;
      
      // altre cariche da openpolis
      $xml= simplexml_load_file("http://politici.openpolis.it/api/chargeFindByPolitician/3114a2d106054d26c364c4cfff85910f97f7e29a/".$this->parlamentare->getId());
      $this->descrizione_cariche=array();
      if ($xml)
      {
          $this->descrizione_cariche = $xml->xpath("//description"); 
      }
      
      // da quanti giorni è parlamentare da openpolis
      
      $xml= simplexml_load_file("http://politici.openpolis.it/api/parlamentareHowDays?id=".$this->parlamentare->getId());
      $this->giorni=array();
      if ($xml)
      {
          $giorni = $xml->xpath("//days"); 
      }
      if ($giorni[0]/365>=2)
        $durata=intval($giorni[0]/365).' anni e ';
      elseif ($giorni[0]/365>=1)  
        $durata='un anno e ';
      else
        $durata="";
      
      if (($giorni[0]%365)>0)
        $durata=($durata.$giorni[0]%365)." giorni";
      
      $this->durata=$durata;
      
      // Incarico nel gruppo corrente
	  $c= new Criteria();
	  $c->addJoin(OppChgIncaricoPeer::CHG_ID,OppCaricaHasGruppoPeer::ID);
	  $c->add(OppCaricaHasGruppoPeer::DATA_FINE,NULL,Criteria::ISNULL);
	  $c->add(OppChgIncaricoPeer::DATA_FINE,NULL,Criteria::ISNULL);
	  $c->add(OppCaricaHasGruppoPeer::CARICA_ID,$this->carica->getId());
	  $c->add(OppCaricaHasGruppoPeer::GRUPPO_ID,$this->id_gruppo_corrente);
	  $incarico=OppChgIncaricoPeer::doSelectOne($c);
	  $this->incarico=$incarico->getIncarico();
	  
    }   
    
    
  }
  
  public function executeGiorniDiCarica()
  {
    function getAnniGiorni($giorni)
    {
      if ($giorni/365>=2)
        $durata=intval($giorni/365).' anni e ';
      elseif ($giorni/365>=1)  
        $durata='un anno e ';
      else
        $durata="";

      if (($giorni%365)>0)
        $durata=($durata.$giorni%365)." giorni";
      return $durata;  
    }
    if($this->getRequestParameter('ramo')=='camera')
    {
      $xml= simplexml_load_file("http://politici.openpolis.it/api/parlamentareHowDays?id=0&ramo=C");
      $this->ramo='C';
      $this->getResponse()->setTitle('Da quanto tempo sono in parlamento i deputati - '.sfConfig::get('app_main_title'));
    }
    else
    {
      $xml= simplexml_load_file("http://politici.openpolis.it/api/parlamentareHowDays?id=0&ramo=S");
      $this->ramo='S';
      $this->getResponse()->setTitle('Da quanto tempo sono in parlamento i senatori - '.sfConfig::get('app_main_title'));
    }
    
    $this->response->addMeta('description','La classifica dei parlamentari che da un numero maggiore di anni ricoprono incarichi alla Camera e al Senato ',true);
     
    $classifica=array();
    $stat=array(0,0,0,0,0);
    $stat_gruppi=array();
    $max_gruppi=array();
    if ($xml)
    {
      foreach ($xml->xpath("//politician") as $p)
      {   
        $polid= trim($p->opid[0]);
        $giorni = trim($p->days[0]);
        $durata=getAnniGiorni($giorni);
        $classifica[$polid]=array($durata,$p->contentid[0]); 
        //stat generali
        if ($giorni<1825)
          $stat[0]=$stat[0]+1;
        elseif ($giorni>=1825 && $giorni<3650)  
          $stat[1]=$stat[1]+1;
        elseif ($giorni>=3650 && $giorni<5475)  
          $stat[2]=$stat[2]+1;
        elseif ($giorni>=5475 && $giorni<7300)  
          $stat[3]=$stat[3]+1;
        elseif ($giorni>=7300)  
          $stat[4]=$stat[4]+1; 
        //stat per gruppo
        $content_id=$p->contentid[0];
        if (OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($content_id))
        {
          $gruppo=OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($content_id)->getId();
          if (!array_key_exists($gruppo,$stat_gruppi))
          {
            $stat_gruppi[$gruppo]=array(0,0,0,0,0);
          }
          if (!array_key_exists($gruppo,$max_gruppi))
          {
            $max_gruppi[$gruppo]=array(0,0);
          }
          if ($giorni>$max_gruppi[$gruppo][1])
            $max_gruppi[$gruppo]=array($polid,$giorni);
            
          if ($giorni<1825)
            $stat_gruppi[$gruppo][0]=$stat_gruppi[$gruppo][0] + 1;
          elseif ($giorni>=1825 && $giorni<3650)  
            $stat_gruppi[$gruppo][1]=$stat_gruppi[$gruppo][1] + 1;
          elseif ($giorni>=3650 && $giorni<5475)  
            $stat_gruppi[$gruppo][2]=$stat_gruppi[$gruppo][2] + 1;
          elseif ($giorni>=5475 && $giorni<7300)  
            $stat_gruppi[$gruppo][3]=$stat_gruppi[$gruppo][3] + 1;
          elseif ($giorni>=7300)  
            $stat_gruppi[$gruppo][4]=$stat_gruppi[$gruppo][4] + 1;
        }
      }   
    }   
    foreach($max_gruppi as $k=>$mx)
    {
      $max_gruppi[$k][1]= getAnniGiorni($mx[1]);
    }
    $this->classifica=$classifica;
    $this->stat=$stat;
    $this->stat_gruppi=$stat_gruppi;
    $this->max_gruppi=$max_gruppi;
  }
  
  public function executeAtti()
  {
    $this->_getAndCheckParlamentare(); 
  
    $title = 'Atti presentati in Parlamento da ';
  
    if ($this->carica) {
      if ($this->carica->getTipoCaricaId() == 1) $ramo = 'C';
      if ($this->carica->getTipoCaricaId() == 4 || $this->carica->getTipoCaricaId() == 5) $ramo = 'S';
      $this->ramo = $ramo=='C' ? 'camera' : 'senato';
      $title .=  ($this->ramo=='camera') ? ' On. ' : ' Sen. ';
//      if ($this->ramo=='camera')
//        $this->getResponse()->setTitle('On. '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - gli atti su cui lavora - '.sfConfig::get('app_main_title'));
//     else
//        $this->getResponse()->setTitle('Sen. '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - gli atti su cui lavora - '.sfConfig::get('app_main_title'));
    }
//    else $this->getResponse()->setTitle($this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - gli atti su cui lavora - '.sfConfig::get('app_main_title'));
    $this->getResponse()->setTitle($title . $this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - '.sfConfig::get('app_main_title'));
    
    $this->response->addMeta('description','Gli atti parlamentari e il loro iter, quotidianamente aggiornato, firmati da '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome(),true);    
  
    $this->session = $this->getUser();
 
    // estrae tutte le macrocategorie, per costruire la select
    $this->all_tags_categories = OppTeseottPeer::doSelect(new Criteria());        

    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_tags_category', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_type', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_ramo', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_stato', '0');      
    }

    $this->processAttiFilters(array('tags_category', 'act_type', 'act_firma', 'act_stato'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_tags_category') == '0' &&
      $this->getRequestParameter('filter_act_type') == '0' &&
      $this->getRequestParameter('filter_act_firma') == '0' && 
      $this->getRequestParameter('filter_act_stato') == '0')
    {
      $this->redirect('@parlamentare_atti?id='.$this->getRequestParameter('id').'&slug='.$this->parlamentare->getSlug());
    }
  
    $this->processAttiSort();

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $this->pager = new sfPropelPager('OppCaricaHasAtto', $itemsperpage);

    // estrazione cariche parlamentare
    $cariche_ids = $this->parlamentare->getCaricheCorrentiIds();
    
    $c = new Criteria();
    $c->addJoin(OppAttoPeer::ID, OppCaricaHasAttoPeer::ATTO_ID);
    $c->add(OppCaricaHasAttoPeer::CARICA_ID, $cariche_ids, Criteria::IN);
	  $this->addAttiFiltersCriteria($c);    
	  $this->addAttiSortCriteria($c);
  
  	$c->addDescendingOrderByColumn(OppAttoPeer::DATA_PRES);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppAtto');
    $this->pager->init();
  }

  protected function processAttiSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->session->setAttribute('sort', $this->getRequestParameter('sort'), 'opp_parlamentare_atti/sort');
      $this->session->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'opp_parlamentare_atti/sort');
    }

    if (!$this->session->getAttribute('sort', null, 'opp_parlamentare_atti/sort'))
    {
	    $this->session->setAttribute('sort', 'ultimo_aggiornamento', 'opp_parlamentare_atti/sort');
      $this->session->setAttribute('type', 'desc', 'opp_parlamentare_atti/sort');
    }
  }

  protected function processAttiFilters($active_filters)
  {

    $this->filters = array();

    // legge i filtri dalla request e li scrive nella sessione utente
    // sia in POST che in GET (per i link a liste filtrate)
    if ($this->getRequest()->getMethod() == sfRequest::POST ||
        $this->getRequest()->getMethod() == sfRequest::GET) 
    {
      if ($this->hasRequestParameter('filter_tags_category'))
        $this->session->setAttribute('tags_category', $this->getRequestParameter('filter_tags_category'), 'acts_filter');

      if ($this->hasRequestParameter('filter_act_firma'))
        $this->session->setAttribute('act_firma', $this->getRequestParameter('filter_act_firma'), 'acts_filter');

      if ($this->hasRequestParameter('filter_act_stato'))
        $this->session->setAttribute('act_stato', $this->getRequestParameter('filter_act_stato'), 'acts_filter');

      if ($this->hasRequestParameter('filter_act_type'))
        $this->session->setAttribute('act_type', $this->getRequestParameter('filter_act_type'), 'acts_filter');
    }
    
    // legge sempre i filtri dalla sessione utente (quelli attivi)
    if (in_array('tags_category', $active_filters))
      $this->filters['tags_category'] = $this->session->getAttribute('tags_category', '0', 'acts_filter');

    if (in_array('act_firma', $active_filters))
      $this->filters['act_firma'] = $this->session->getAttribute('act_firma', '0', 'acts_filter');

    if (in_array('act_stato', $active_filters))
      $this->filters['act_stato'] = $this->session->getAttribute('act_stato', '0', 'acts_filter');    

    if (in_array('act_type', $active_filters))
      $this->filters['act_type'] = $this->session->getAttribute('act_type', '0', 'acts_filter');    
    
  }
  
  protected function addAttiSortCriteria($c)
  {
    if ($sort_column = $this->session->getAttribute('sort', null, 'opp_parlamentare_atti/sort'))
    {
      $sort_column = OppAttoPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      if ($this->session->getAttribute('type', null, 'opp_parlamentare_atti/sort') == 'asc')
      {
        $c->addAscendingOrderByColumn($sort_column);
      }
      else
      {
        $c->addDescendingOrderByColumn($sort_column);
      }
    }
  }

  protected function addAttiFiltersCriteria($c)
  {
    // filtro per firma
    if (array_key_exists('act_firma', $this->filters) && $this->filters['act_firma'] != '0')
      $c->add(OppCaricaHasAttoPeer::TIPO, $this->filters['act_firma']);
    
    // filtro per stato di avanzamento
    if (array_key_exists('act_stato', $this->filters) && $this->filters['act_stato'] != '0')
      $c->add(OppAttoPeer::STATO_COD, $this->filters['act_stato']);      

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


  
  public function executeVoti()
  {
    $this->_getAndCheckParlamentare();

    $this->response->addMeta('description','I voti espressi in tutte le votazioni elettroniche di aula da '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome(),true);
     
    if ( $this->carica == null ) {
        $this->getResponse()->setTitle('Voti in Parlamento '. $this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - '.sfConfig::get('app_main_title'));
        return;
    }
        
    $this->id_gruppo_corrente = $this->parlamentare->getGruppoCorrente()->getId();
    $this->session = $this->getUser();
    
    if ($this->carica->getTipoCaricaId() == 1) $ramo = 'C';
    if ($this->carica->getTipoCaricaId() == 4 || $this->carica->getTipoCaricaId() == 5) $ramo = 'S';
    $this->ramo = $ramo=='C' ? 'camera' : 'senato';
    $this->getResponse()->setTitle('Voti in Parlamento '. ($this->ramo=='camera' ? ' On. ' : ' Sen. ') . $this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - '.sfConfig::get('app_main_title'));    
//    if ($this->ramo=='camera')
//       $this->getResponse()->setTitle('On. '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - come ha votato - '.sfConfig::get('app_main_title'));
//    else
//       $this->getResponse()->setTitle('Sen. '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - come ha votato - '.sfConfig::get('app_main_title'));
     
     // reset dei filtri se richiesto esplicitamente
     if ($this->getRequestParameter('reset_filters', 'false') == 'true')
     {
       $this->getRequest()->getParameterHolder()->set('filter_vote_type', '0');
       $this->getRequest()->getParameterHolder()->set('filter_vote_vote', '0');
       $this->getRequest()->getParameterHolder()->set('filter_vote_result', '0');
       $this->getRequest()->getParameterHolder()->set('filter_vote_rebel', '0');      
     }

    $this->processVotiFilters(array('vote_type', 'vote_vote', 'vote_result', 'vote_rebel'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_vote_type') == '0' &&
        $this->getRequestParameter('filter_vote_vote') == '0' && 
        $this->getRequestParameter('filter_vote_result') == '0' &&
        $this->getRequestParameter('filter_vote_rebel') == '0')
    {
      $this->redirect('@parlamentare_voti?id='.$this->getRequestParameter('id').'&slug='.$this->parlamentare->getSlug());
    }

    $this->processVotiSort();

	  if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));
  
    $this->pager = new deppPropelPager('OppVotazioneHasCarica', $itemsperpage);
    
    $c = new Criteria();
    $c->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, OppVotazionePeer::ID);
    $c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);
    $c->add(OppVotazioneHasCaricaPeer::CARICA_ID, $this->carica->getId());
	  $this->addVotiFiltersCriteria($c);    
	  $this->addVotiSortCriteria($c);
  	$c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppVotazione');
    
    $cForCount = new Criteria();
    $cForCount->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, OppVotazionePeer::ID);
    $cForCount->add(OppVotazioneHasCaricaPeer::CARICA_ID, $this->carica->getId());
	  $this->addVotiFiltersCriteria($cForCount);    
    $this->pager->init($cForCount);

  }

  protected function processVotiFilters($active_filters)
  {

    $this->filters = array();

    // legge i filtri dalla request e li scrive nella sessione utente
    if ($this->hasRequestParameter('filter_vote_type'))
      $this->session->setAttribute('vote_type', $this->getRequestParameter('filter_vote_type'), 'votes_filter');

    if ($this->hasRequestParameter('filter_vote_vote'))
      $this->session->setAttribute('vote_vote', $this->getRequestParameter('filter_vote_vote'), 'votes_filter');

    if ($this->hasRequestParameter('filter_vote_result'))
      $this->session->setAttribute('vote_result', $this->getRequestParameter('filter_vote_result'), 'votes_filter');

    if ($this->hasRequestParameter('filter_vote_rebel'))
      $this->session->setAttribute('vote_rebel', $this->getRequestParameter('filter_vote_rebel'), 'votes_filter');
    
    // legge sempre i filtri dalla sessione utente (quelli attivi)
    if (in_array('vote_type', $active_filters))
      $this->filters['vote_type'] = $this->session->getAttribute('vote_type', '0', 'votes_filter');

    if (in_array('vote_vote', $active_filters))
      $this->filters['vote_vote'] = $this->session->getAttribute('vote_vote', '0', 'votes_filter');

    if (in_array('vote_result', $active_filters))
      $this->filters['vote_result'] = $this->session->getAttribute('vote_result', '0', 'votes_filter');

    if (in_array('vote_rebel', $active_filters))
      $this->filters['vote_rebel'] = $this->session->getAttribute('vote_rebel', '0', 'votes_filter');
    
  }

  protected function processVotiSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->session->setAttribute('sort', $this->getRequestParameter('sort'), 'opp_parlamentare_voti/sort');
      $this->session->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'opp_parlamentare_voti/sort');
    }

    if (!$this->session->getAttribute('sort', null, 'opp_parlamentare_voti/sort'))
    {
	    $this->session->setAttribute('sort', 'data', 'opp_parlamentare_voti/sort');
      $this->session->setAttribute('type', 'desc', 'opp_parlamentare_voti/sort');
    }
  }
    
  protected function addVotiFiltersCriteria($c)
  {
    // filtro per tipo di voto (finale o no)
    if (array_key_exists('vote_type', $this->filters) && $this->filters['vote_type'] != '0')
      $c->add(OppVotazionePeer::FINALE, $this->filters['vote_type']);

    // filtro per voto (favorevole, contrario o astenuto)
    if (array_key_exists('vote_vote', $this->filters) && $this->filters['vote_vote'] != '0' && $this->filters['vote_vote'] != 'Presente')
      $c->add(OppVotazioneHasCaricaPeer::VOTO, $this->filters['vote_vote']);
    elseif (array_key_exists('vote_vote', $this->filters) && $this->filters['vote_vote'] != '0' && $this->filters['vote_vote'] == 'Presente')
     $c->add(OppVotazioneHasCaricaPeer::VOTO, array('favorevole','contrario','astenuto','presente non votante','presidente di turno','richiedente la votazione e non votante'), Criteria::IN);  
    
    // filtro per esito
    if (array_key_exists('vote_result', $this->filters) && $this->filters['vote_result'] != '0')
      $c->add(OppVotazionePeer::ESITO, $this->filters['vote_result']);

    // filtro per soli voti ribelli
    if (array_key_exists('vote_rebel', $this->filters) && $this->filters['vote_rebel'] != '0' && $this->filters['vote_rebel'] == '1')
      $c->add(OppVotazioneHasCaricaPeer::RIBELLE, $this->filters['vote_rebel']);
    elseif (array_key_exists('vote_rebel', $this->filters) && $this->filters['vote_rebel'] != '0' && $this->filters['vote_rebel'] == '2')
      $c->add(OppVotazioneHasCaricaPeer::MAGGIORANZA_SOTTO_SALVA, 1);
    elseif (array_key_exists('vote_rebel', $this->filters) && $this->filters['vote_rebel'] != '0' && $this->filters['vote_rebel'] == '3')
      $c->add(OppVotazioneHasCaricaPeer::MAGGIORANZA_SOTTO_SALVA, 2);  
  }

  protected function addVotiSortCriteria($c)
  {
    if ($sort_column = $this->session->getAttribute('sort', 'data', 'opp_parlamentare_voti/sort'))
    {
      if ($sort_column == 'data')
        $sort_column = OppSedutaPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      else
        $sort_column = OppVotazionePeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      if ($this->session->getAttribute('type', null, 'opp_parlamentare_voti/sort') == 'asc')
      {
        $c->addAscendingOrderByColumn($sort_column);
      }
      else
      {
        $c->addDescendingOrderByColumn($sort_column);
      }
    }
  }


  public function executeInterventi()
  {
    $response = sfContext::getInstance()->getResponse();
    if ($this->getUser()->isAuthenticated() && 
        ($this->getUser()->hasCredential('amministratore') || $this->getUser()->hasCredential('adhoc')))
    {
      $response->addStylesheet('votazione_interventi', 'last');
      $response->addJavascript('votazione_interventi', 'last');      
    }
	  
    $this->_getAndCheckParlamentare(); 
    if ( $this->carica == NULL )
    {
        return;
    }
    $this->session = $this->getUser();  
    
    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_ddls_collegati', '0');
    }

    $this->processInterventiFilters(array('ddls_collegati'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_ddls_collegati') == '0')
    {
      $this->redirect('@parlamentare_interventi?id='.$this->getRequestParameter('id').'&slug='.$this->parlamentare->getSlug() );
    }

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));
  
    $this->pager = new sfPropelPager('OppIntervento', $itemsperpage);
    
    $c = new Criteria();
    $c->add(OppInterventoPeer::CARICA_ID, $this->carica->getId());	  
  	$c->addDescendingOrderByColumn(OppInterventoPeer::CREATED_AT);
  	$this->addInterventiFiltersCriteria($c);    
	  
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinAll');
    $this->pager->init();
    
    $cariche_ids = $this->parlamentare->getCaricheCorrentiIds();
    $this->ddls_collegati = OppInterventoPeer::getDDLCollegatiCariche($cariche_ids);
    
    if ($this->carica->getTipoCaricaId() == 1) $ramo = 'C';
    if ($this->carica->getTipoCaricaId() == 4 || $this->carica->getTipoCaricaId() == 5) $ramo = 'S';
    $this->ramo = $ramo=='C' ? 'camera' : 'senato';
    $this->getResponse()->setTitle('Interventi in Parlamento '. ($this->ramo=='camera' ? 'On. ' : 'Sen. '). $this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - '.sfConfig::get('app_main_title'));
//    if ($this->ramo=='camera')
//       $this->getResponse()->setTitle('On. '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - interventi parlamentari - '.sfConfig::get('app_main_title'));
//    else
//       $this->getResponse()->setTitle('Sen. '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - interventi parlamentari - '.sfConfig::get('app_main_title'));
	$this->response->addMeta('description','La lista aggiornata quotidianamente di tutti gli interventi in Parlamento, in aula e nelle commissioni, di '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome(),true);
  }
  
  public function executeEmendamenti()
  {
    $this->_getAndCheckParlamentare(); 
    
    $title = 'Emendamenti presentati in Parlamento da ';
    if ($this->carica) {
      if ($this->carica->getTipoCaricaId() == 1) $ramo = 'C';
      if ($this->carica->getTipoCaricaId() == 4 || $this->carica->getTipoCaricaId() == 5) $ramo = 'S';
      $this->ramo = $ramo=='C' ? 'camera' : 'senato';
      $title .=  ($this->ramo=='camera') ? ' On. ' : ' Sen. ';
    }
      $this->getResponse()->setTitle($title . $this->parlamentare->getNome().' '.$this->parlamentare->getCognome().' - '.sfConfig::get('app_main_title'));
      $this->response->addMeta('description','La lista aggiornata quotidianamente di tutti gli emendamenti presentati da '.$this->parlamentare->getNome().' '.$this->parlamentare->getCognome(),true);    
  
    $this->session = $this->getUser();
    
    
    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_ddls_collegati', '0');
      $this->getRequest()->getParameterHolder()->set('filter_act_firma', '0');
     // $this->getRequest()->getParameterHolder()->set('filter_act_ramo', '0');
      // $this->getRequest()->getParameterHolder()->set('filter_act_stato', '0');      
    }

    $this->processEmendamentiFilters(array('ddls_collegati','act_firma'));

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_ddls_collegati') == '0' &&
        $this->getRequestParameter('filter_act_firma') == '0')
    {
      $this->redirect('@parlamentare_emendamenti?id='.$this->getRequestParameter('id') .'&slug='. $this->parlamentare->getSlug() );
    }
  
    //$this->processEmendamentiSort();
    

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    $this->pager = new sfPropelPager('OppCaricaHasEmendamento', $itemsperpage);

    // estrazione cariche parlamentare
    $cariche_ids = $this->parlamentare->getCaricheCorrentiIds();
    
    /*
    // estrae tutti i ddl collegati
    $c=new Criteria();
    $c->addJoin(OppEmendamentoPeer::ID, OppCaricaHasEmendamentoPeer::EMENDAMENTO_ID);
    $c->add(OppCaricaHasEmendamentoPeer::CARICA_ID, $cariche_ids, Criteria::IN);
    $emens=OppEmendamentoPeer::doSelect($c);
    $this->ddls_collegati=array();
    foreach($emens as $em)
    {
      $ddls=$em->getOppAttoHasEmendamentos();
      $ddl=$ddls[0]->getOppAtto();
      if (!in_array( $ddl,$this->ddls_collegati))
         $this->ddls_collegati[]=$ddl;
    }
    */
    $this->ddls_collegati = empty($cariche_ids) ? $cariche_ids : OppCaricaHasEmendamentoPeer::getDDLCollegatiCariche($cariche_ids);
   
    
    $c = new Criteria();
    $c->addJoin(OppEmendamentoPeer::ID, OppCaricaHasEmendamentoPeer::EMENDAMENTO_ID);
    $c->add(OppCaricaHasEmendamentoPeer::CARICA_ID, $cariche_ids, Criteria::IN);
	  $this->addEmendamentiFiltersCriteria($c);    
	  //$this->addAttiSortCriteria($c);
  
  	$c->addDescendingOrderByColumn(OppEmendamentoPeer::DATA_PRES);
  	$this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('doSelectJoinOppEmendamento');
    $this->pager->init();
  }
  
  protected function processEmendamentiFilters($active_filters)
  {

    $this->filters = array();

    // legge i filtri dalla request e li scrive nella sessione utente
    // sia in POST che in GET (per i link a liste filtrate)
    if ($this->getRequest()->getMethod() == sfRequest::POST ||
        $this->getRequest()->getMethod() == sfRequest::GET) 
    {
      
      if ($this->hasRequestParameter('filter_ddls_collegati'))
        $this->session->setAttribute('ddls_collegati', $this->getRequestParameter('filter_ddls_collegati'), 'acts_filter');
      
      if ($this->hasRequestParameter('filter_act_firma'))
        $this->session->setAttribute('act_firma', $this->getRequestParameter('filter_act_firma'), 'acts_filter');

    }
    
    // legge sempre i filtri dalla sessione utente (quelli attivi)
    
    if (in_array('ddls_collegati', $active_filters))
      $this->filters['ddls_collegati'] = $this->session->getAttribute('ddls_collegati', '0', 'acts_filter');
   
    if (in_array('act_firma', $active_filters))
      $this->filters['act_firma'] = $this->session->getAttribute('act_firma', '0', 'acts_filter');
  }
  
  protected function addEmendamentiFiltersCriteria($c)
  {
    // filtro per firma
    if (array_key_exists('act_firma', $this->filters) && $this->filters['act_firma'] != '0')
      $c->add(OppCaricaHasEmendamentoPeer::TIPO, $this->filters['act_firma']);
    
    // filtro per ddl
    
    if (array_key_exists('ddls_collegati', $this->filters) && $this->filters['ddls_collegati'] != '0')
    {
      $c->addJoin(OppEmendamentoPeer::ID, OppAttoHasEmendamentoPeer::EMENDAMENTO_ID);
      //$c->addJoin(OppAttoPeer::ID, OppAttoHasEmendamentoPeer::ATTO_ID);
      $c->add(OppAttoHasEmendamentoPeer::ATTO_ID, $this->filters['ddls_collegati']);
      $c->setDistinct();
    }  
      
    /*
    // filtro per stato di avanzamento
    if (array_key_exists('act_stato', $this->filters) && $this->filters['act_stato'] != '0')
      $c->add(OppAttoPeer::STATO_COD, $this->filters['act_stato']);      

    // filtro per tipo di decreto legislativo
    if (array_key_exists('act_type', $this->filters) && $this->filters['act_type'] != '0')
      $c->add(OppAttoPeer::TIPO_ATTO_ID, $this->filters['act_type']);
      
     */   
    
  }


  protected function processInterventiFilters($active_filters)
  {

    $this->filters = array();

    // legge i filtri dalla request e li scrive nella sessione utente
    // sia in POST che in GET (per i link a liste filtrate)
    if ($this->getRequest()->getMethod() == sfRequest::POST ||
        $this->getRequest()->getMethod() == sfRequest::GET) 
    {
      
      if ($this->hasRequestParameter('filter_ddls_collegati'))
        $this->session->setAttribute('ddls_collegati', $this->getRequestParameter('filter_ddls_collegati'), 'acts_filter');
      
    }
    
    // legge sempre i filtri dalla sessione utente (quelli attivi)
    if (in_array('ddls_collegati', $active_filters))
      $this->filters['ddls_collegati'] = $this->session->getAttribute('ddls_collegati', '0', 'acts_filter');
  }
  
  protected function addInterventiFiltersCriteria($c)
  {
    // filtro per ddl
    if (array_key_exists('ddls_collegati', $this->filters) && $this->filters['ddls_collegati'] != '0')
    {
      $c->add(OppInterventoPeer::ATTO_ID, $this->filters['ddls_collegati']);
      $c->setDistinct();
    }  
    
  }

  public function executeList()
  {

    $this->session = $this->getUser();
    $ramo = $this->getRequestParameter('ramo', 'camera');

    // estrae i gruppi del ramo
    $this->all_groups = OppGruppoPeer::getAllGroups($ramo, 18, 'tutti');
    
    // estrae le circoscrizioni, compreso il valore 0
    $this->all_constituencies = OppCaricaPeer::getAllConstituencies($ramo, 'tutte');
    
    // reset dei filtri se richiesto esplicitamente
    if ($this->getRequestParameter('reset_filters', 'false') == 'true')
    {
      $this->getRequest()->getParameterHolder()->set('filter_group', '0');
      $this->getRequest()->getParameterHolder()->set('filter_const', '0');
    }
    
    //estrazione parlamentari
    $this->processFilters(array('group', 'const'), $ramo);

    // if all filters were reset, then restart
    if ($this->getRequestParameter('filter_group') == '0' &&
        $this->getRequestParameter('filter_const') == '0') 
    {
      $this->redirect('@parlamentari?ramo='.$ramo);
    }

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
    $c->addSelectColumn(OppPoliticoPeer::N_MONITORING_USERS);
    $c->addSelectColumn(OppCaricaPeer::DATA_INIZIO);
	$c->addSelectColumn(OppCaricaPeer::DATA_FINE);
   
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);

    if ($ramo == 'camera')
    {
      $this->getResponse()->setTitle('elenco dei deputati - '.sfConfig::get('app_main_title'));
      $this->response->addMeta('description','Elenco dei deputati della legislatura con assenze, indice di produttivit&agrave; e voti ribelli',true);
      
      $c->add(OppCaricaPeer::LEGISLATURA, '18', Criteria::EQUAL);
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, '1', Criteria::EQUAL);
 
      //conteggio numero deputati  
      $c1 = new Criteria();
      $c1->add(OppCaricaPeer::LEGISLATURA, '18', Criteria::EQUAL);
      $c1->add(OppCaricaPeer::TIPO_CARICA_ID, '1' , Criteria::EQUAL);
      $c1->add(OppCaricaPeer::DATA_FINE, null, Criteria::EQUAL);
      $this->numero_parlamentari = OppCaricaPeer::doCount($c1);
    }
    else
    {
      $this->getResponse()->setTitle('elenco dei senatori - '.sfConfig::get('app_main_title'));
      $this->response->addMeta('description','Elenco dei senatori della legislatura con assenze, indice di produttivit&agrave; e voti ribelli',true);
      
      $cton = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, '18', Criteria::EQUAL);
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
      $c1->add(OppCaricaPeer::LEGISLATURA, '18', Criteria::EQUAL);
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
    
    $this->parlamentari = OppCaricaPeer::doSelectRS($c);
    $this->n_parlamentari = OppCaricaPeer::doCount($c);

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
     $c->addSelectColumn(OppPoliticoPeer::N_MONITORING_USERS);
     
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);

    if ($ramo == 'camera')
     $c->add(OppCaricaPeer::TIPO_CARICA_ID, '1', Criteria::EQUAL);
     
    else
     $c->add(OppCaricaPeer::TIPO_CARICA_ID, '4', Criteria::EQUAL);

    $c->add(OppCaricaPeer::LEGISLATURA, '18', Criteria::EQUAL);    
    $c->add(OppCaricaPeer::DATA_FINE, 'NULL', Criteria::NOT_EQUAL); 
	 
    $this->parlamentari_decaduti = OppCaricaPeer::doSelectRS($c);
	      
  }


  public function executeListNuovoIndice()
  {
    $this->ramo = $this->getRequestParameter('ramo');

    $this->parlamentari_rs = OppPoliticianHistoryCachePeer::getClassificaParlamentariNuovoRS($this->ramo);
    
  }
  
	public function executePicture()
	{
	  $pol = OppPoliticoPeer::retrieveByPk($this->getRequestParameter('id'));
	  if (!$pol instanceof OppPolitico)
	    $picture = '';
	  else
  	  $picture = $pol->getPicture();
    $this->response->setContentType('image/jpeg');
    $this->response->setContent($picture);
    return sfView::NONE;
  }

	public function executeThumb()
	{
	  $pol = OppPoliticoPeer::retrieveByPk($this->getRequestParameter('id'));
	  if (!$pol instanceof OppPolitico)
	    $picture = '';
	  else
  	  $picture = $pol->getThumb();
    $this->response->setContentType('image/jpeg');
    $this->response->setContent($picture);
    return sfView::NONE;
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
    if ($this->hasRequestParameter('filter_group'))
      $this->session->setAttribute('group', $this->getRequestParameter('filter_group'), "pol_{$ramo}_filter");

    if ($this->hasRequestParameter('filter_const'))
      $this->session->setAttribute('const', $this->getRequestParameter('filter_const'), "pol_{$ramo}_filter");


    // legge i filtri attivi dalla sessione utente o dalle variabili passate in GET
    if (in_array('group', $active_filters))
    {
      $this->filters['group'] = $this->session->getAttribute('group', '0', "pol_{$ramo}_filter");      
    }

    if (in_array('const', $active_filters))
    {
      $this->filters['const'] = $this->session->getAttribute('const', '0', "pol_{$ramo}_filter");
    }

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
      $c->add(OppCaricaHasGruppoPeer::DATA_FINE, NULL,Criteria::ISNULL);
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
      {
        $sort_column = OppCaricaPeer::translateFieldName($sort_column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
      }
	    if ($this->getUser()->getAttribute('type', null, 'sf_admin/opp_carica/sort') == 'asc')
      {
        if($sort_column=='nome')
		    {
		      $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
	        $c->addAscendingOrderByColumn(OppPoliticoPeer::NOME);  
		    }
		    else
		    {
		      $c->addAscendingOrderByColumn($sort_column);
		      $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
		    }
      }
      else
      {
        if($sort_column=='nome')
		    {
		      $c->addDescendingOrderByColumn(OppPoliticoPeer::COGNOME);
	        $c->addDescendingOrderByColumn(OppPoliticoPeer::NOME);  
		    }
		    else
		    {
		      $c->addDescendingOrderByColumn($sort_column);
		      $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
		    }
		      
      }
    }
  }
  
  public function executeComparaDeputati()
  {
      	  
      if ($this->hasRequestParameter('id1') && $this->hasRequestParameter('id2') && $this->hasRequestParameter('ramo'))
       {
        $this->ramo=$this->getRequestParameter('ramo');
        if ($this->getRequestParameter('id1')!=0 && $this->getRequestParameter('id2')!=0)
         {
           
	  $this->session = $this->getUser();
          $this->query = $this->getRequestParameter('query', '');
          
	  if ($this->hasRequestParameter('itemsperpage'))
          $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
          $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

         
          $this->pager = new sfPropelPager('OppVotazione', $itemsperpage); 
          
          // estrae le cariche dei due parlamentari 
          $politico=OppPoliticoPeer::retrieveByPk($this->getRequestParameter('id1'));
          $carica1=$politico->getCaricaDepSenCorrente();
         
          $politico=OppPoliticoPeer::retrieveByPk($this->getRequestParameter('id2')); 
          $carica2=$politico->getCaricaDepSenCorrente();
         
          
    $c1= new Criteria();
	  $c1->add(OppVotazioneHasCaricaPeer::VOTO,array('Favorevole','Contrario','Astenuto'),Criteria::IN);
	  $c1->add(OppVotazioneHasCaricaPeer::CARICA_ID,array($carica1->getId(),$carica2->getId()),Criteria::IN);
	  $results=OppVotazioneHasCaricaPeer::doSelect($c1);
	  
	  $arr1=array();
	  $arr2=array();
	  foreach ($results as $result) {
		if ($result->getCaricaId()==$carica1->getId())
		    $arr1[$result->getVotazioneId()]=$result->getVoto();
		else 
		    $arr2[$result->getVotazioneId()]=$result->getVoto();    
	  }
	
 	  $this->compare = count(array_intersect_assoc($arr1, $arr2));
 	  $this->compare_voti=array_keys(array_intersect_key($arr1,$arr2));
 	  $this->numero_voti=count($this->compare_voti); 
 	  
 	  $c= new Criteria();
 	  $c->add(OppVotazionePeer::ID,$this->compare_voti,Criteria::IN);
  	  $this->pager->setCriteria($c);
          $this->pager->setPage($this->getRequestParameter('page', 1));
          $this->pager->setPeerMethod('doSelect'); 
          $this->pager->init($c);
          	
 	  $this->arr1=$arr1;
 	  $this->arr2=$arr2;
 	  

 	  $this->parlamentare1=$carica1;
 	  $this->assenze1=round($carica1->getAssenze()*100/($carica1->getPresenze()+$carica1->getAssenze()+$carica1->getMissioni()),1);
 	  
 	  $this->parlamentare2=$carica2;
 	  $this->assenze2=round($carica2->getAssenze()*100/($carica2->getPresenze()+$carica2->getAssenze()+$carica2->getMissioni()),1);
 	  
	  
 	  $this->compara_ok='1';
 	   // da quanti giorni è parlamentare da openpolis
      
      $xml= simplexml_load_file("http://politici.openpolis.it/api/parlamentareHowDays?id=".$carica1->getOppPolitico()->getId());
      $this->giorni=array();
      if ($xml)
      {
          $giorni = $xml->xpath("//days"); 
      }
      if ($giorni[0]/365>=2)
        $durata=intval($giorni[0]/365).' anni e ';
      elseif ($giorni[0]/365>=1)  
        $durata='un anno e ';
      else
        $durata="";
      
      if (($giorni[0]%365)>0)
        $durata=($durata.$giorni[0]%365)." giorni";
      
      $this->durata1=$durata;
      $xml= simplexml_load_file("http://politici.openpolis.it/api/parlamentareHowDays?id=".$carica2->getOppPolitico()->getId());
      $this->giorni=array();
      if ($xml)
      {
          $giorni = $xml->xpath("//days"); 
      }
      if ($giorni[0]/365>=2)
        $durata=intval($giorni[0]/365).' anni e ';
      elseif ($giorni[0]/365>=1)  
        $durata='un anno e ';
      else
        $durata="";
      
      if (($giorni[0]%365)>0)
        $durata=($durata.$giorni[0]%365)." giorni";
      
      $this->durata2=$durata;
 	  
$this->getResponse()->setTitle(($this->ramo==1 ? 'Deputati ' : 'Senatori ').'a confronto:'.$carica1->getOppPolitico()->getCognome().' vs '.$carica2->getOppPolitico()->getCognome().' - '.sfConfig::get('app_main_title'));
$this->response->addMeta('description','Confronto tra le attivit&agrave; parlamentari di '.$carica1->getOppPolitico()->getCognome().' e '.$carica2->getOppPolitico()->getCognome(),true); 	  
 	  
 	}
 	else 
 	{
 	  $this->compara_ok='0';
 	  $this->parlamentare1=null;
 	  $this->getResponse()->setTitle(($this->ramo==1 ? 'Deputati ' : 'Senatori ').'a confronto - '.sfConfig::get('app_main_title')); 	 
 	}  
 	
      } 

  if ($this->getRequest()->getMethod() != sfRequest::POST)
  {
    // Display the form
    return sfView::SUCCESS;
  }
  else
  {
    // Handle the form submission
    $parlamentare1=$this->getRequestParameter('parlamentare1');
    $parlamentare2=$this->getRequestParameter('parlamentare2');
    $ramo=$this->getRequestParameter('ramo');
    if ($ramo==1)
      $this->redirect('/parlamentare/comparaDeputati/?id1='.$parlamentare1.'&id2='.$parlamentare2.'&ramo=1'); 
    else
      $this->redirect('/parlamentare/comparaDeputati/?id1='.$parlamentare1.'&id2='.$parlamentare2.'&ramo=2');    
  }
 }

 public function executeGruppiCamera()
 {
   $this->getResponse()->setTitle('Componenti e statistiche sui gruppi parlamentari della Camera dei Deputati - '.sfConfig::get('app_main_title'));
   $this->response->addMeta('description','La composizione dei gruppi alla Camera, che perde deputati e chi li guadagna',true); 	  
 }   
 public function executeGruppiSenato()
 {
  $this->getResponse()->setTitle('Componenti e statistiche sui gruppi parlamentari della del Senato della Repubblica - '.sfConfig::get('app_main_title')); 
  $this->response->addMeta('description','La composizione dei gruppi al Senato, che perde deputati e chi li guadagna',true);
 }
 
 public function executeCommissioniCamera()
 {
    $this->getResponse()->setTitle('Commissioni parlamentari della Camera - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','La composizione delle commissioni alla Camera, qual\'&egrave; il potere dei gruppi parlamentari',true);
    //estrae le commissioni parmanenti camera
    $c=new Criteria();
    $c->add(OppSedePeer::RAMO,'C');
    $c->add(OppSedePeer::TIPOLOGIA,'Commissione permanente');
    $this->comms=OppSedePeer::doSelect($c);
  }
  public function executeCommissioniSenato()
  {
    $this->getResponse()->setTitle('Commissioni parlamentari del Senato - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','La composizione delle commissioni al Senato, qual\'&egrave; il potere dei gruppi parlamentari',true);
    
    $compara_comm=array();
    //estrae le commissioni parmanenti senato
    $c=new Criteria();
    $c->add(OppSedePeer::RAMO,'S');
    $c->add(OppSedePeer::TIPOLOGIA,'Commissione permanente');
    $this->comms=OppSedePeer::doSelect($c);
  }   
  
  public function executeCommissioniBicamerali()
  {
    $this->getResponse()->setTitle('Commissioni bicamerali e speciali in Parlamento - '.sfConfig::get('app_main_title'));
    $this->response->addMeta('description','La composizione delle commissioni bicamerali e speciali, qual\'&egrave; il potere dei gruppi parlamentari',true);
	if ($this->getRequestParameter('ramo')=='camera')
		$ramo_organo='C';
	else
		$ramo_organo='S';
	
     $c=new Criteria();
	 $criterion = $c->getNewCriterion(OppSedePeer::TIPOLOGIA,'Commissione speciale');
	 $criterion->addAnd($c->getNewCriterion(OppSedePeer::RAMO,$ramo_organo));
	 $criterion->addOr($c->getNewCriterion(OppSedePeer::TIPOLOGIA,'Commissione bicamerale'));
	 
	 $c->add($criterion);
     
	 //$c->add(OppSedePeer::RAMO,'CS');
     //$c->add(OppSedePeer::TIPOLOGIA,'Commissione bicamerale');
     $this->comms=OppSedePeer::doSelect($c);
     $this->ramo=$this->getRequestParameter('ramo');
    
  }
  
  public function executeCommissioniMembri()
  {
     $this->setLayout(false);  
     $this->getResponse()->setTitle('I componenti della Commissione - '.sfConfig::get('app_main_title'));
     $sede_id=$this->getRequestParameter('sede');
     $this->sort=$this->getRequestParameter('sort');
     
     //estrae le commissioni parmanenti senato
     $c=new Criteria();
     $c->clearSelectColumns();
     $c->addSelectColumn(OppCaricaPeer::ID);
     $c->addSelectColumn(OppTipoCaricaPeer::NOME);
     $c->addSelectColumn(OppCaricaHasGruppoPeer::GRUPPO_ID);
     
     $c->addJoin(OppCaricaInternaPeer::TIPO_CARICA_ID,OppTipoCaricaPeer::ID);
     $c->addJoin(OppCaricaInternaPeer::CARICA_ID,OppCaricaPeer::ID);
     $c->addJoin(OppPoliticoPeer::ID,OppCaricaPeer::POLITICO_ID);
     $c->addJoin(OppCaricaHasGruppoPeer::CARICA_ID,OppCaricaPeer::ID);
     $c->add(OppCaricaInternaPeer::SEDE_ID,$sede_id);
     $c->add(OppCaricaInternaPeer::DATA_FINE,NULL,Criteria::ISNULL);
     $c->add(OppCaricaHasGruppoPeer::DATA_FINE,NULL,Criteria::ISNULL);
     $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
     $rs=OppCaricaPeer::doSelectRS($c);
     $g_membri=array();
     while($rs->next())
     {
       $c_membri[$rs->getInt(1)] = strtolower($rs->getString(2));
       if (array_key_exists($rs->getInt(3),$g_membri))
         $g_membri[$rs->getInt(3)] =$g_membri[$rs->getInt(3)] .",".$rs->getInt(1)."-".strtolower($rs->getString(2));
       else
        $g_membri[$rs->getInt(3)] =$rs->getInt(1)."-".strtolower($rs->getString(2));
         
     }
     $this->c_membri=$c_membri;
     $this->g_membri=$g_membri;
     $this->sede_id=$sede_id;
   }
   
   public function executeGiunte()
   {
     $c=new Criteria();
     if ($this->getRequestParameter('ramo')=='camera')
     {
       $this->getResponse()->setTitle('Giunte parlamentari della Camera - '.sfConfig::get('app_main_title'));
       $this->response->addMeta('description','La composizione delle giunte alla Camera, qual\'&egrave; il potere dei gruppi parlamentari',true);
       $c->add(OppSedePeer::RAMO,'C'); 
     }
     else
     {
       $this->getResponse()->setTitle('Giunte parlamentari del Senato - '.sfConfig::get('app_main_title'));
       $this->response->addMeta('description','La composizione delle giunte al Senato, qual\'&egrave; il potere dei gruppi parlamentari',true);
       $c->add(OppSedePeer::RAMO,'S');
     }
     $c->add(OppSedePeer::TIPOLOGIA,'Giunta');
     $this->comms=OppSedePeer::doSelect($c);
     $this->ramo=$this->getRequestParameter('ramo');
   }
   
   public function executeOrgani()
    {
      $c=new Criteria();
      if ($this->getRequestParameter('ramo')=='camera')
      {
        $this->getResponse()->setTitle('Componenti e statistiche di commissioni e giunte della Camera - '.sfConfig::get('app_main_title'));
        $this->response->addMeta('description','Il potere dei gruppi parlamentari in tutti gli organi della Camera dei Deputati',true);
        $c->add(OppSedePeer::RAMO,'C');
      }
      else
      {
        $this->getResponse()->setTitle('Componenti e statistiche di commissioni e giunte del Senato - '.sfConfig::get('app_main_title'));
        $this->response->addMeta('description','Il potere dei gruppi parlamentari in tutti gli organi del Senato',true);
        $c->add(OppSedePeer::RAMO,'S');
      }
      $c->add(OppSedePeer::TIPOLOGIA,'Presidenza');
      $this->comm=OppSedePeer::doSelectOne($c);
      $this->ramo=$this->getRequestParameter('ramo');
      
      $gruppi_all=array();
      $gruppi_p=array();
      $gruppi_q=array();
      $gruppi_vp=array();
      $gruppi_s=array();
      $gruppi_c=array();
      $membri_regione=array(21 => 0,23 => 0,25 => 0,32 => 0,34 => 0,36 => 0,42 => 0,45 => 0,52 => 0,55 => 0,57 => 0,62 => 0,65 => 0,67 => 0,72 => 0,75 => 0,77 => 0,78 => 0,82 => 0,88 => 0);

      $c=new Criteria();
      $c->addJoin(OppCaricaInternaPeer::CARICA_ID,OppCaricaPeer::ID);
      $c->addJoin(OppCaricaInternaPeer::SEDE_ID,OppSedePeer::ID);
      if ($this->getRequestParameter('ramo')=='camera')
      {
        $c->add(OppSedePeer::RAMO,array('C','CS'),Criteria::IN);
        $c->add(OppCaricaPeer::TIPO_CARICA_ID,1);
      } 
      else
      {
        $c->add(OppSedePeer::RAMO,array('S','CS'),Criteria::IN);
        $c->add(OppCaricaPeer::TIPO_CARICA_ID,4);
      }
      $c->add(OppCaricaInternaPeer::DATA_FINE,NULL, Criteria::ISNULL);
      $membri=OppCaricaInternaPeer::doSelect($c);
      foreach ($membri as $membro)
      {
        $regione=strtolower(str_replace(array(" ","'","-"),"_",$membro->getOppCarica()->getCircoscrizione()));
        $codice_regione=sfConfig::get('app_circoscrizioni_'.$regione);
        if (array_key_exists($codice_regione,$membri_regione))
          $membri_regione[$codice_regione]=$membri_regione[$codice_regione]+1;

        $gruppo_id=OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($membro->getCaricaId())->getId();
        $tipo_carica=OppTipoCaricaPeer::retrieveByPk($membro->getTipoCaricaId())->getNome();

        if (array_key_exists($gruppo_id,$gruppi_all))
          $gruppi_all[$gruppo_id]=$gruppi_all[$gruppo_id]+1;
        else
          $gruppi_all[$gruppo_id]=1;

        if ($tipo_carica=='Presidente')
        {
          if (array_key_exists($gruppo_id,$gruppi_p))
            $gruppi_p[$gruppo_id]=$gruppi_p[$gruppo_id]+1;
          else
            $gruppi_p[$gruppo_id]=1;
        }
        if ($tipo_carica=='Questore')
        {
          if (array_key_exists($gruppo_id,$gruppi_q))
            $gruppi_q[$gruppo_id]=$gruppi_q[$gruppo_id]+1;
          else
            $gruppi_q[$gruppo_id]=1;
        }
        if ($tipo_carica=='Vicepresidente')
        {
          if (array_key_exists($gruppo_id,$gruppi_vp))
            $gruppi_vp[$gruppo_id]=$gruppi_vp[$gruppo_id]+1;
          else
            $gruppi_vp[$gruppo_id]=1;
        }
        if ($tipo_carica=='Segretario')
        {
          if (array_key_exists($gruppo_id,$gruppi_s))
            $gruppi_s[$gruppo_id]=$gruppi_s[$gruppo_id]+1;
          else
            $gruppi_s[$gruppo_id]=1;
        }
        if ($tipo_carica=='Componente')
        {
          if (array_key_exists($gruppo_id,$gruppi_c))
            $gruppi_c[$gruppo_id]=$gruppi_c[$gruppo_id]+1;
          else
            $gruppi_c[$gruppo_id]=1;
        }
      }
      $this->gruppi_all=$gruppi_all;
      $this->gruppi_p=$gruppi_p;
      $this->gruppi_q=$gruppi_q;
      $this->gruppi_vp=$gruppi_vp;
      $this->gruppi_s=$gruppi_s;
      $this->gruppi_c=$gruppi_c;
      $this->membri_regione=$membri_regione;
      
    }
    
}

?>
