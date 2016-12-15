<?php
class attoComponents extends sfComponents
{
  public function executeMonitor_n_vote()
  {
    
  }
  
  
  public function executeEvidenza()
  {
    $this->atti = OppAttoPeer::getKeyActs($this->limit);
  }
  
  public function executeEditTagsForIndice()
	{

    // embed javascripts for edit-in-place and auto-completer
	  $response = sfContext::getInstance()->getResponse();
    $response->addJavascript('prototype.js');
    $response->addJavascript('effects.js');
    $response->addJavascript('controls.js');
    $response->addStylesheet('/deppPropelActAsTaggableBehaviorPlugin/css/depp_tagging.css');

    // fetch dei tag legati al content
    $this->tags = $this->content->getTagsForIndice();

    $user_id = sfContext::getInstance()->getUser()->getId();
	}	
  
  public function executeItemshortinline()
  {
    switch(get_class($this->item)){
      case 'OppPolitico':
        $str = $this->item->__toString();
        $url = '@parlamentare?'.$this->item->getUrlParams();
        $this->title = '';
        break;
      case 'OppAtto':
        $str = $this->item->getRamo() .".". $this->item->getNumfase();
        $url = '@singolo_atto?id='.$this->item->getId();
        $this->title = Text::denominazioneAtto($this->item, 'index');
        break;
      case 'Tag':
        $str = $this->item->getTripleValue();
        $url = '@argomento?triple_value='.$this->item->getTripleValue();
        $this->title = '';
        break;
    }
    $this->str = $str . " (".$this->item->getNMonitoringUsers().")"; 
    $this->url = $url;
  }

  public function executeProusersdo()
  {
    $pro_users_pks = $this->item->getVotingUsersPKs(1);

    $voted_items = sfVotingPeer::getItemsFavouredByUsers($pro_users_pks, 'OppAtto');
    uasort($voted_items, 'sfVotingPeer::compareItemsByProUsers');
    $this->pro_acts = array_slice($voted_items, 0, 10);

    $voted_items = sfVotingPeer::getItemsOpposedByUsers($pro_users_pks, 'OppAtto');
    uasort($voted_items, 'sfVotingPeer::compareItemsByAntiUsers');
    $this->anti_acts = array_slice($voted_items, 0, 10);
  }

  public function executeAntiusersdo()
  {
    $anti_users_pks = $this->item->getVotingUsersPKs(-1);

    $voted_items = sfVotingPeer::getItemsFavouredByUsers($anti_users_pks, 'OppAtto');
    uasort($voted_items, 'sfVotingPeer::compareItemsByProUsers');
    $this->pro_acts = array_slice($voted_items, 0, 10);

    $voted_items = sfVotingPeer::getItemsOpposedByUsers($anti_users_pks, 'OppAtto');
    uasort($voted_items, 'sfVotingPeer::compareItemsByAntiUsers');
    $this->anti_acts = array_slice($voted_items, 0, 10);
  }
  
  public function executeMonitoringusersdo()
  {
    $this->monitorers_pks = $this->item->getAllMonitoringUsersPKs();
    $this->monitored_models_pks = MonitoringPeer::getModelsPKsMonitoredByUsers($this->monitorers_pks);
  }
  
  
  public function executeDdlConversione()
  {
    $c = new Criteria();
    $c->add(OppAttoPeer::ID, $this->ddl->getSucc(), Criteria::EQUAL);
    $this->ddl_di_conversione = OppAttoPeer::doSelectOne($c);  
  }
  
  public function executeStatoAttoNonLegislativo()
  {
    $c = new Criteria();
    $c->add(OppAttoPeer::ID, $this->ddl->getPred(), Criteria::EQUAL);
    $this->ultimo_atto = OppAttoPeer::doSelectOne($c);
  }
  
  public function executeDocumenti()
  {
    $c = new Criteria();
    $c -> add(OppDocumentoPeer::DOSSIER,0);
    $this->documenti = $this->atto->getOppDocumentos($c);
	$this->documenti_count = $this->atto->countOppDocumentos($c);
	
	$this->limit = 5;
	$this->limit_count = 0;
	
	$this->tipo_atto = $this->atto->getOppTipoAtto()->getDescrizione();
  }
  
  public function executeFirmatari()
  {
    $this->primi_array_index = array();
    foreach($this->primi_firmatari as $id => $primo_firmatario)
      array_push($this->primi_array_index, $id);
	
	$this->rel_array_index = array();
    foreach($this->relatori as $id => $relatore)
      array_push($this->rel_array_index, $id);
         
       
  }
  
  public function executeVotazioni()
  {
    $this->limit = 2;
	$this->limit_count = 0;
	
	$this->votazioni_count = count($this->votazioni);
  }
  
  public function executeInterventi()
  {
    $this->limit = 2;
	  $this->limit_count = 0;
	
	  $i_fields = array('data', 'denominazione', 'ramo', 'nome', 'cognome', 'politico_id');
	
	  $this->interventi_count = count($this->interventi);

    # estende gli interventi, splittando le url quando necessario
	  $interventi_singoli = array();
	  foreach ($this->interventi as $key => $intervento) {
	    $i_obj = OppInterventoPeer::retrieveByPK($intervento['id']);
	      
	    $links = explode('@', $intervento['link']);
	    foreach ($links as $link) {
  	    $i_singolo = array();
  	    $i_singolo['obj'] = $i_obj;
  	    foreach ($i_fields as $field)
  	      $i_singolo[$field] = $intervento[$field];
	      if ($i_singolo['ramo'] == 'C')
	      {
	        if (!preg_match("#^http:#", $link))
	          $i_singolo['url'] = sfConfig::get('app_url_sito_camera', 'http://www.camera.it/') . $link;
	        else
	          $i_singolo['url'] = $link;	        
	      }
	      else
	      {
	        if (!preg_match("#^http:#", $link))
	          $i_singolo['url'] = sfConfig::get('app_url_sito_senato', 'http://www.senato.it/') . $link;
	        else
	          $i_singolo['url'] = $link;	        	        
	      }
	      array_push($interventi_singoli, $i_singolo);
	    }
	  }
	  $this->interventi = $interventi_singoli;
  }
  
  public function executeCommissioni()
  {
    $this->consultive_count = 0;
  }
  public function executeRelazioni()
  {
    $this->relazioni =  OppAttoPeer::getRelazioni($this->atto->getId());
  }
  
  public function executeDdl2legge()
  {
    
    $arrs=array();
    $arr_alls=array();
    foreach(array(1,2,3,4) as $i)
    {
        $c=new Criteria();
        $c->add(OppAttoPeer::TIPO_ATTO_ID,1);
        $c->add(OppAttoPeer::LEGISLATURA,$this->leg);
        $c->add(OppAttoPeer::INIZIATIVA,$i);
        $c->setDistinct(OppAttoPeer::ID);
        $atti=OppAttoPeer::doSelect($c); 
		
	  $c= new Criteria();
      $c->addJoin(OppAttoPeer::ID,OppAttoHasIterPeer::ATTO_ID);
      $c->add(OppAttoPeer::TIPO_ATTO_ID,1);
      $c->add(OppAttoPeer::LEGISLATURA,$this->leg);
      $c->add(OppAttoPeer::INIZIATIVA,$i);
      $c->add(OppAttoHasIterPeer::ITER_ID,array(16), Criteria::IN);
	  $c->addAscendingOrderByColumn(OppAttoHasIterPeer::DATA);
      $c->setDistinct(OppAttoPeer::ID);
      $leggi=OppAttoHasIterPeer::doSelect($c);
      $tempo_medio=0;
      foreach ($leggi as $legge)
      {
        $ddl=$legge->getOppAtto();
        while ($ddl->getPred()!=NULL)
        {
          $ddl=OppAttoPeer::retrieveByPk($ddl->getPred());
        }
        //$this->data_pres=$ddl->getDataPres();
        //$this->data_appr=$legge->getData();
        $data_pres=strtotime($ddl->getDataPres());
		$k = new Criteria();
		$k->add(OppAttoHasIterPeer::ATTO_ID,$legge->getOppAtto()->getId());
		$k->add(OppAttoHasIterPeer::ITER_ID,15);
		$data_no_leg=OppAttoHasIterPeer::doSelectOne($k);
		if ($data_no_leg)
			$data_appr=strtotime($data_no_leg->getData());
		else
        	$data_appr=strtotime($legge->getData());


        $tempo_medio=$tempo_medio + ($data_appr-$data_pres)/86400;
        $arr_alls[]=array($legge->getOppAtto(),($data_appr-$data_pres)/86400);
        
      }
      if (count($leggi)>0)
        $tempo_medio=intval($tempo_medio/count($leggi));
      else
        $tempo_medio=$tempo_medio;
        
      $arrs[]=array(count($atti),count($leggi),$tempo_medio);  
    }
    $this->arrs=$arrs;
    function cmp($a, $b)
    {
      if ($a[1] == $b[1]) {
        return 0;
      }
      return ($a[1] < $b[1]) ? -1 : 1;
    }
    usort($arr_alls, "cmp");
    
    $this->arr_alls=$arr_alls;
  }
  
  public function executeDdl2argomenti()
  { 
    
    $this->tags=array();
    $c=new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(TaggingPeer::TAG_ID);
    $c->addAsColumn("numtag", "COUNT(".TaggingPeer::TAG_ID.")");
    $c->addJoin(TaggingPeer::TAGGABLE_ID,OppAttoPeer::ID);
    $c->add(TaggingPeer::TAGGABLE_MODEL,'OppAtto');
    $c->add(OppAttoPeer::TIPO_ATTO_ID,1);
    $c->add(OppAttoPeer::LEGISLATURA,$this->leg);
    
    if ($this->approvato==true)
    {
      $c->addJoin(OppAttoPeer::ID,OppAttoHasIterPeer::ATTO_ID);
      $c->add(OppAttoHasIterPeer::ITER_ID,16);  
    }
    
    
    $c->addGroupByColumn("TAG_ID");
    $c->addDescendingOrderByColumn("numtag");
    $rs=TaggingPeer::doSelectRS($c);
    while($rs->next())
    {
      $this->tags[]=array($rs->getInt(1),$rs->getInt(2));
    }
    
  }  
    
    
}

?>