<?php
class parlamentareComponents extends sfComponents
{

public function executeTaxDeclaration()
{
	$this->tax=array();
	$xml=simplexml_load_file("http://politici.openpolis.it/api/taxDeclaration?id=".$this->parlamentare->getId());
	foreach($xml->taxs->tax->declaration as $declaration)
	{
		//$this->tax[intval($declaration->year)]=$this->parlamentare->getId();
		$this->tax[intval($declaration->year)]=$declaration->url;
	}
	$json=json_decode("http://patrimoni.openpolis.it/api/politici/".$this->parlamentare->getId());
	$this->patrimoni= count($json);
}
  
  public function executeWidgetVoti()
   {
     $this->sotto=$this->carica->getMaggioranzaSotto();
     $this->salva=$this->carica->getMaggioranzaSalva();
     $this->ribelle=$this->carica->getRibelle();
   }

  public function executeMonitoringalso()
  {
    $this->monitorers_pks = $this->item->getAllMonitoringUsersPKs();
    $this->monitored_models_pks = MonitoringPeer::getModelsPKsMonitoredByUsers($this->monitorers_pks);
  }
  
  public function executeCambioGruppo()
  {
    $c = new Criteria();
    $c->addSelectColumn(OppPoliticoPeer::ID);
    $c->addSelectColumn(OppPoliticoPeer::COGNOME);
    $c->addSelectColumn(OppPoliticoPeer::NOME);
    $c->addSelectColumn(OppGruppoPeer::NOME);
    $c->addSelectColumn(OppCaricaHasGruppoPeer::DATA_INIZIO);
    $c->addSelectColumn(OppCaricaPeer::TIPO_CARICA_ID);
    $c->addSelectColumn(OppCaricaPeer::DATA_INIZIO);
    $c->addSelectColumn(OppCaricaPeer::ID);
    $c->addJoin(OppCaricaPeer::ID,OppCaricaHasGruppoPeer::CARICA_ID);
    $c->addJoin(OppGruppoPeer::ID,OppCaricaHasGruppoPeer::GRUPPO_ID);
    $c->addJoin(OppCaricaPeer::POLITICO_ID,OppPoliticoPeer::ID);
    //$c->add(OppCaricaPeer::DATA_INIZIO,OppCaricaHasGruppoPeer::DATA_INIZIO, Criteria::NOT_EQUAL);
    $c->add(OppCaricaHasGruppoPeer::DATA_FINE,NULL, Criteria::ISNULL);
    $c->addDescendingOrderByColumn(OppCaricaHasGruppoPeer::DATA_INIZIO);
    $c->setLimit(20);
    $parlamentari=OppCaricaHasGruppoPeer::doSelectRS($c);  
    $this->parlamentari=$parlamentari;  
    
  }
    
  public function executeSioccupadi()
  {
    $options = array('limit' => 20, 'sort_by_relevance' => true);
    
    // estrazione tag, tipo firma, tipo atto
    // questo dovrebbe andare in TagPeer, ma romperebbe la neutralità del plugin
    $c = new Criteria();
    $c->addJoin(OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID);
    $c->addJoin(TaggingPeer::TAGGABLE_ID, OppAttoPeer::ID);
    $c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
    $c->add(OppCaricaHasAttoPeer::CARICA_ID, $this->carica->getId());
    $c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
    $c->clearSelectColumns();
    $c->addSelectColumn(TagPeer::TRIPLE_VALUE);
    $c->addSelectColumn(OppCaricaHasAttoPeer::TIPO);
    $c->addSelectColumn(OppAttoPeer::TIPO_ATTO_ID);

    // costruzione array associativo dei tag
    $tags = array();
    $rs = TagPeer::doSelectRS($c);
    while ($rs->next())
    {
      $value = $rs->getString(1);
      $tipo = $rs->getString(2);
      $tipo_atto_id = $rs->getInt(3);
      
      if (!array_key_exists($value, $tags))
        $tags[$value] = 0;
      
      $tags[$value] += OppCaricaHasAttoPeer::get_fattore_firma($tipo) * OppAttoPeer::get_fattore_tipo_atto($tipo_atto_id);
    }
    
    // ordinamento per rilevanza, prima dello slice
    arsort($tags);

    // slice dell'array, se specificata l'opzione limit
    if (isset($options['limit']) && count($tags) > $options['limit'])
    {
      $this->n_remaining_tags = count($tags) - $options['limit'];
      $tags = array_slice($tags, 0, $options['limit'], true);
    }
    
    // ordinamento per triple_value, in caso sort_by_relevance non sia specificato
    if (!isset($options['sort_by_relevance']) || (true !== $options['sort_by_relevance']))
    {
      krsort($tags);
    }
    
    $this->tags = $tags;
  }
  
  
  public function executeVotacome()
  {
    try
    {
      $this->nearest = $this->carica->getNearestVoters('voting', $this->acronimo);      
    } catch (Exception $e) {
      sfLogger::getInstance()->error($e->getMessage());
    }
  }
  
  public function executeFirmacon()
  {
    try
    {
      $this->nearest = $this->carica->getNearestVoters('signing', $this->acronimo);      
    } catch (Exception $e) {
      sfLogger::getInstance()->error($e->getMessage());
    }
  }
  
  /**
   * estrae tutti gli atti presentati dal parlamentare nel corso della legislatura
   * sono considerate tutte le cariche ricoperte
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function executeAttiPresentati()
  {
  
    $cariche_ids = $this->parlamentare->getCaricheCorrentiIds();
    if (count($cariche_ids) == 0)
    {
      $this->atti_presentati = array();
      return;
    }
    
    $cariche_ids_as_string = join($cariche_ids, ",");

    /* select raw 
    select ta.descrizione, ca.tipo, count(ta.id) 
     from opp_carica_has_atto ca, opp_atto a, opp_tipo_atto ta 
     where ca.atto_id=a.id and a.tipo_atto_id=ta.id and carica_id=$carica->getId() 
     group by ta.id, ca.tipo
     order by ta.id;
    */
    $connection = Propel::getConnection();
    $query = "SELECT %s AS tipo, %s AS tipo_id, %s AS firma, count(%s) AS cnt " .
             "FROM %s, %s, %s " . 
             "WHERE %s=%s and %s=%s and %s in ($cariche_ids_as_string)" . 
             "GROUP BY %s, %s " . 
             "ORDER BY %s";

    $query = sprintf($query, OppTipoAttoPeer::DESCRIZIONE, OppTipoAttoPeer::ID, 
                             OppCaricaHasAttoPeer::TIPO, OppTipoAttoPeer::ID,
                             OppCaricaHasAttoPeer::TABLE_NAME, OppAttoPeer::TABLE_NAME, OppTipoAttoPeer::TABLE_NAME,
                             OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID, 
                             OppAttoPeer::TIPO_ATTO_ID, OppTipoAttoPeer::ID,
                             OppCaricaHasAttoPeer::CARICA_ID,
                             OppTipoAttoPeer::ID, OppCaricaHasAttoPeer::TIPO, 
                             OppTipoAttoPeer::ID);
    
    
    
    $statement = $connection->prepareStatement($query);
    $rs = $statement->executeQuery();
    $atti = array();
    while ($rs->next())
    {
      $tipo = $rs->getString('tipo');
      $tipo_id = $rs->getString('tipo_id');
      if (!array_key_exists($tipo, $atti))
      {
        $atti[$tipo] = array('id' => $tipo_id, 'C' => 0, 'P' => 0,'R' => 0);
      }
      $firma = $rs->getString('firma');
      $cnt = $rs->getInt('cnt');
      $atti[$tipo][$firma] = $cnt;
    }
    
    $this->atti_presentati = $atti;
    
    for ($x=0;$x<2;$x++)
    {
       $c=new Criteria();
       $c->add(OppCaricaHasEmendamentoPeer::CARICA_ID,$cariche_ids,Criteria::IN);
       if ($x==0)
       {
         $c->add(OppCaricaHasEmendamentoPeer::TIPO,'P');
         $this->emen_primo=OppCaricaHasEmendamentoPeer::doCount($c);
       }
       else
       {
         $c->add(OppCaricaHasEmendamentoPeer::TIPO,'C');
         $this->emen_co=OppCaricaHasEmendamentoPeer::doCount($c);
       }
    }
   
    
    
  }
  
  
  public function executeKeyvote($limite=5)
  {
   // voti in evidenza
   
     $this->limit = $limite;
     $this->limit_count = 0;
     
     $this->lanci=array();
     $c = new Criteria();
     $c->addJoin(OppVotazionePeer::ID,sfLaunchingPeer::OBJECT_ID);
     $c->addJoin(OppVotazionePeer::SEDUTA_ID,OppSedutaPeer::ID);
     $c->add(OppSedutaPeer::RAMO,($this->ramo=='senato' ? 'S' : 'C'));
     $c->add(sfLaunchingPeer::OBJECT_MODEL,'OppVotazione'); 
     $c->add(sfLaunchingPeer::LAUNCH_NAMESPACE,'key_vote');
     //$c->addDescendingOrderByColumn(sfLaunchingPeer::PRIORITY);
     $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
     $evidences=sfLaunchingPeer::doSelect($c);
     foreach ($evidences as $evidence) {
        $c1= new Criteria();
        $c1->addJoin(OppCaricaPeer::ID,OppVotazioneHasCaricaPeer::CARICA_ID);
        $c1->add(OppVotazioneHasCaricaPeer::CARICA_ID,$this->carica->getId());
     	  $c1->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID,$evidence->getObjectId());
     	$result=OppVotazioneHasCaricaPeer::doSelectOne($c1);
     	if ($result)
     	  $this->lanci[]=array($result->getOppVotazione(),$evidence->getObjectModel(),$result->getVoto()); 
     }
     

  
  }
  
  public function executeKeyvoteComparati()
  {
     
     $lanci=array();
     $c = new Criteria();
     $c->add(sfLaunchingPeer::OBJECT_MODEL,'OppVotazione'); 
     $c->add(sfLaunchingPeer::LAUNCH_NAMESPACE,'key_vote');
     $c->addDescendingOrderByColumn(sfLaunchingPeer::PRIORITY);
     $evidences=sfLaunchingPeer::doSelect($c);
     foreach ($evidences as $evidence) {
        $c1= new Criteria();
        $c1->addJoin(OppCaricaPeer::ID,OppVotazioneHasCaricaPeer::CARICA_ID);
        $c1->add(OppVotazioneHasCaricaPeer::CARICA_ID,array($this->parlamentare1->getId(),$this->parlamentare2->getId()), Criteria::IN);
     	  $c1->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID,$evidence->getObjectId());
     	  $results=OppVotazioneHasCaricaPeer::doSelect($c1);
     	  if (count($results)==2)
     	  {
     	    if ($results[0]->getCaricaId()==$this->parlamentare1->getId())
     	    {
     	      $left=0;
     	      $right=1;
     	    }
     	    else
     	    {
     	       $left=1;
       	     $right=0;
     	    }
     	    $lanci[]=array($results[1]->getOppVotazione(),$evidence->getObjectModel(),$results[$left]->getVoto(),$results[$right]->getVoto());
     	  }
     	      
     }
     
     $this->lanci=$lanci;
  
  }
  
public function executeAllvoteComparati()
{
      
}
  
     public function executeVotiComparati()
  {
    
       $perc=$this->compare*100/$this->numero_voti;
       $this->perc=round($perc,1);
       $x=100/max($this->parlamentare1->getPresenze(),$this->parlamentare2->getPresenze());
       
       $this->gchartVoti="http://chart.apis.google.com/chart?cht=v&chd=t:100,100,0,".$perc."&chs=250x100&chdl=".$this->parlamentare1->getOppPolitico()->getCognome()."|".$this->parlamentare2->getOppPolitico()->getCognome();   
       
         
         
       
  }
  
  public function executeTendinaParlamentari()
    {  
        if ($this->ramo==1) $this->tipo_carica=1;
        else $this->tipo_carica=4;
        
        $c = new Criteria();
	$c->clearSelectColumns();
	$c->addSelectColumn(OppPoliticoPeer::ID);
	$c->addSelectColumn(OppPoliticoPeer::COGNOME);
	$c->addSelectColumn(OppPoliticoPeer::NOME);   
        $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);
        $c->add(OppCaricaPeer::LEGISLATURA, '18', Criteria::EQUAL);
        $c->add(OppCaricaPeer::TIPO_CARICA_ID, $this->tipo_carica, Criteria::EQUAL);
        $c->add(OppCaricaPeer::DATA_FINE, null, Criteria::EQUAL); 
        $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
        $this->parlamentari = OppCaricaPeer::doSelectRS($c);
        
    }
    
    public function executeComparaQuesto()
      {  
          if ($this->ramo==1) $this->tipo_carica=1;
          else $this->tipo_carica=4;

          $c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppPoliticoPeer::ID);
  	$c->addSelectColumn(OppPoliticoPeer::COGNOME);
  	$c->addSelectColumn(OppPoliticoPeer::NOME);   
          $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);
          $c->add(OppCaricaPeer::LEGISLATURA, '18', Criteria::EQUAL);
          $c->add(OppCaricaPeer::TIPO_CARICA_ID, $this->tipo_carica, Criteria::EQUAL);
          $c->add(OppCaricaPeer::DATA_FINE, null, Criteria::EQUAL); 
          $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
          $this->parlamentari = OppCaricaPeer::doSelectRS($c);

      }
      
 public function executeChooseParlamentari()
  {
    $parlamentare1 = $this->getRequestParameter('parlamentare1');
    $parlamentare2 = $this->getRequestParameter('parlamentare2');
    $this->redirect('@votazioni');
  }
  
  public function executeGruppiParlamentari()
  {
    if ($this->ramo==1) $this->tipo_carica=array(1);
    else $this->tipo_carica=array(4,5);
  
    $array_diff=array();
    $gruppo_in=array();
    $gruppo_out=array();
    $gruppo_now=array();
    $parlamentari_change=array();
    
    $c1=new Criteria();
    $gruppi=OppGruppoPeer::doSelect($c1);
    foreach ($gruppi as $gruppo)
    {
      if (!array_key_exists($gruppo->getId(),$gruppo_in))
        $gruppo_in[$gruppo->getId()]=0; 
      if (!array_key_exists($gruppo->getId(),$gruppo_out))  
        $gruppo_out[$gruppo->getId()]=0; 
      if (!array_key_exists($gruppo->getId(),$gruppo_now))  
        $gruppo_now[$gruppo->getId()]=0;
      $c= new Criteria();
      $c->add(OppCaricaPeer::TIPO_CARICA_ID,$this->tipo_carica, Criteria::IN);
      $c->addJoin(OppCaricaPeer::ID,OppCaricaHasGruppoPeer::CARICA_ID);
      if (!in_array(5, $this->tipo_carica))
      {
         $c->add(OppCaricaPeer::LEGISLATURA,$this->leg);
      }
      //$c->add(OppCaricaPeer::DATA_FINE,NULL, Criteria::ISNULL);
      $c->add(OppCaricaHasGruppoPeer::GRUPPO_ID,$gruppo->getId());
      $rs=OppCaricaHasGruppoPeer::doSelect($c);
      foreach($rs as $r)
      {
        if ($r->getDataFine()==NULL)
          $gruppo_now[$gruppo->getId()]=$gruppo_now[$gruppo->getId()]+1;
        else
        {
         
          if (!in_array($r->getCaricaId(),$parlamentari_change) AND $r->getDataFine()!=$r->getOppCarica()->getDataFine())
            $parlamentari_change[]=$r->getCaricaId();
          if ($r->getDataFine()!=$r->getOppCarica()->getDataFine())  
          	$gruppo_out[$gruppo->getId()]=$gruppo_out[$gruppo->getId()]+1;
          
		  $c2= new Criteria();
          $c2->add(OppCaricaHasGruppoPeer::CARICA_ID,$r->getCaricaId());
          $c2->add(OppCaricaHasGruppoPeer::DATA_INIZIO,$r->getDataFine());
          $diff=OppCaricaHasGruppoPeer::doSelectOne($c2);
          if ($diff)
          {
            
            if (array_key_exists($diff->getGruppoId(),$gruppo_in))
               $gruppo_in[$diff->getGruppoId()]=$gruppo_in[$diff->getGruppoId()]+1;
            else
              $gruppo_in[$diff->getGruppoId()]=1;
               
             if (isset($array_diff[$diff->getGruppoId()][$gruppo->getId()]))
             {
               $array_diff[$diff->getGruppoId()][$gruppo->getId()]=$array_diff[$diff->getGruppoId()][$gruppo->getId()]+1;
             }
             else
             {
               $array_diff[$diff->getGruppoId()][$gruppo->getId()]=1;
             }
            if (isset($array_diff[$gruppo->getId()][$diff->getGruppoId()]))
              $array_diff[$gruppo->getId()][$diff->getGruppoId()]=$array_diff[$gruppo->getId()][$diff->getGruppoId()]-1;
            else
              $array_diff[$gruppo->getId()][$diff->getGruppoId()]=-1;
          }
        }  
      }
    }
  
    $this->gruppo_in=$gruppo_in;
    $this->gruppo_out=$gruppo_out;
    $this->gruppo_now=$gruppo_now;
    $this->array_diff= $array_diff;
    $this->parlamentari_change=$parlamentari_change;
  
      
  }
  
  public function executeCommissioniPermanenti()
  {
    $gruppi_all=array();
    $gruppi_p=array();
    $gruppi_q=array();
    $gruppi_vp=array();
    $gruppi_s=array();
    $gruppi_c=array();
    $membri_regione=array(21 => 0,23 => 0,25 => 0,32 => 0,34 => 0,36 => 0,42 => 0,45 => 0,52 => 0,55 => 0,57 => 0,62 => 0,65 => 0,67 => 0,72 => 0,75 => 0,77 => 0,78 => 0,82 => 0,88 => 0);
    
    $c=new Criteria();
    $c->addJoin(OppCaricaInternaPeer::CARICA_ID,OppCaricaPeer::ID);
    $c->add(OppCaricaPeer::LEGISLATURA,$this->leg);
    $c->add(OppCaricaInternaPeer::SEDE_ID,$this->sede_id);
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
  
  public function executeLavoroCommissioni()
  {
    $c=new Criteria();
    $c->add(OppSedePeer::RAMO,$this->ramo);
    $c->add(OppSedePeer::TIPOLOGIA,'Commissione permanente');
    $comms=OppSedePeer::doSelect($c);
    
    foreach($comms as $comm)
    {
      $c= new Criteria();
      $c->addJoin(OppAttoPeer::ID, OppAttoHasSedePeer::ATTO_ID);
      $c->add(OppAttoPeer::LEGISLATURA,$this->leg);
      $c->add(OppAttoPeer::TIPO_ATTO_ID,1);
      $c->add(OppAttoHasSedePeer::SEDE_ID,$comm->getId());
      $c->add(OppAttoHasSedePeer::TIPO,'Referente');
      $ref=OppAttoHasSedePeer::doCount($c);

      $c= new Criteria();
      $c->addJoin(OppAttoPeer::ID, OppAttoHasSedePeer::ATTO_ID);
      $c->add(OppAttoPeer::LEGISLATURA,$this->leg);
      $c->add(OppAttoPeer::TIPO_ATTO_ID,1);
      $c->add(OppAttoHasSedePeer::SEDE_ID,$comm->getId());
      $c->add(OppAttoHasSedePeer::TIPO,'Consultiva');
      $con=OppAttoHasSedePeer::doCount($c);
      
      $c= new Criteria();
      $c->addJoin(OppAttoPeer::ID, OppAttoHasSedePeer::ATTO_ID);
      $c->add(OppAttoPeer::LEGISLATURA,$this->leg);
      $c->add(OppAttoPeer::TIPO_ATTO_ID,1, Criteria::NOT_EQUAL);
      $c->add(OppAttoHasSedePeer::SEDE_ID,$comm->getId());
      $atti_non_leg=OppAttoHasSedePeer::doCount($c);
      
      $c= new Criteria();
      $c->add(OppResocontoPeer::LEGISLATURA,$this->leg);
      $c->add(OppResocontoPeer::SEDE_ID,$comm->getId());
      $sedute=OppResocontoPeer::doCount($c);

      $c= new Criteria();
      $c->addJoin(OppAttoPeer::ID, OppInterventoPeer::ATTO_ID);
      $c->add(OppAttoPeer::LEGISLATURA,$this->leg);
      $c->add(OppInterventoPeer::SEDE_ID,$comm->getId());
      $interventi=OppInterventoPeer::doCount($c);

      $compara_comm[$comm->getId()]=array($ref,$con, $atti_non_leg, $sedute,$interventi);
    }
    $this->compara_comm=$compara_comm;
  }
  
  public function executeIncarichiParlamentare()
  {
    // cariche attuali
    $c= new Criteria();
    $c->add(OppCaricaInternaPeer::CARICA_ID, $this->carica_id);
    $c->add(OppCaricaInternaPeer::DATA_FINE, NULL, Criteria::ISNULL);
    $c->addAscendingOrderByColumn(OppCaricaInternaPeer::SEDE_ID);
    $cariche=OppCaricaInternaPeer::doSelect($c);
    $this->cariche=$cariche;
    
    //cariche passate
    $c= new Criteria();
    $c->add(OppCaricaInternaPeer::CARICA_ID, $this->carica_id);
    $c->add(OppCaricaInternaPeer::DATA_FINE, NULL, Criteria::ISNOTNULL);
    $c->addDescendingOrderByColumn(OppCaricaInternaPeer::DATA_FINE);
    $pasts=OppCaricaInternaPeer::doSelect($c);
    $this->pasts=$pasts;
  }
  
}
