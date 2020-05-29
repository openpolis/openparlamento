<?php

/**
 * Subclass for performing query and update operations on the 'opp_carica' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaPeer extends BaseOppCaricaPeer
{

public static function getIndexChartsPoliticiansInConstituencyRealTime($ramo, $data, $circoscrizione, $con = null)
 {
	 $items=array();
          $circoscrizione = self::getCircoscrizioneNameFromSlug($circoscrizione);
	 
	 $c=new Criteria();
	 $c->addJoin(OppPoliticoPeer::ID, OppCaricaPeer::POLITICO_ID);
	 //esclude i presidenti di camera e senato
	 $c->add(OppPoliticoPeer::ID, array(1449, 494864), Criteria::NOT_IN);
	 // prende solo i parlamentari in carica
	 $c->add(OppCaricaPeer::DATA_FINE, NULL, Criteria::ISNULL);
	 
	 $c->addJoin(OppCaricaHasGruppoPeer::CARICA_ID, OppCaricaPeer::ID);
	 $c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);
	 // prende il gruppo corrente
	 $c->add(OppCaricaHasGruppoPeer::DATA_FINE, NULL, Criteria::ISNULL);

	 if ($constituency!='')
		 $c->add(OppCaricaPeer::CIRCOSCRIZIONE, $constituency);
	 
	 if ($ramo=='C')
		 $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
	 elseif($ramo=='S')
		  $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(4,5), Criteria::IN);
	 
	 $c->setLimit($limit);
	 $results=OppCaricaPeer::doSelect($c);
	 foreach($results as $k => $r)
	 {
                 $gruppi=$r->getOppCaricaHasGruppos();
	 	 $items[$k]['id']=$r->getId();
		 $items[$k]['politico_id']=$r->getPoliticoId();
		 $items[$k]['nome']=$r->getOppPolitico()->getNome();
		 $items[$k]['cognome']=$r->getOppPolitico()->getCognome();
		 $items[$k]['sesso']=$r->getOppPolitico()->getSesso();
		 $items[$k]['acronimo']=$gruppi[0]->getOppGruppo()->getAcronimo();
		 $items[$k]['nome_gruppo']=$gruppi[0]->getOppGruppo()->getNome();
		 $items[$k]['circoscrizione']=$r->getCircoscrizione();
		 $items[$k]['perc_assenze']=($r->getAssenze()*100)/($r->getAssenze()+$r->getPresenze()+$r->getMissioni());
		 $items[$k]['assenze']=$r->getAssenze();
		 $items[$k]['perc_presenze']=($r->getPresenze()*100)/($r->getAssenze()+$r->getPresenze()+$r->getMissioni());
		 $items[$k]['presenze']=$r->getPresenze();
		 $items[$k]['perc_missioni']=($r->getMissioni()*100)/($r->getAssenze()+$r->getPresenze()+$r->getMissioni());
		 $items[$k]['missioni']=$r->getMissioni();
		 $items[$k]['votazioni']=$r->getAssenze()+$r->getPresenze()+$r->getMissioni();
		 $items[$k]['indice']=$r->getIndice();
	 }	 	 
	 return $items;
	 	
 }





public static function getIndexChartsTopPoliticiansRealTime($ramo, $data, $limit, $group_id = null, $constituency = null, $con = null)
 {
	 $items=array();
	 
	 $c=new Criteria();
	 $c->addJoin(OppPoliticoPeer::ID, OppCaricaPeer::POLITICO_ID);
	 //esclude i presidenti di camera e senato
	 $c->add(OppPoliticoPeer::ID, array(1449, 494864), Criteria::NOT_IN);
	 // prende solo i parlamentari in carica
	 $c->add(OppCaricaPeer::DATA_FINE, NULL, Criteria::ISNULL);
	 
	 $c->addJoin(OppCaricaHasGruppoPeer::CARICA_ID, OppCaricaPeer::ID);
	 $c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);
	 // prende il gruppo corrente
	 $c->add(OppCaricaHasGruppoPeer::DATA_FINE, NULL, Criteria::ISNULL);
	 if (!is_null($group_id))
		 $c->add(OppGruppoPeer::ID,$group_id);

	 if ($constituency!='')
		 $c->add(OppCaricaPeer::CIRCOSCRIZIONE, $constituency);
	 
	 if ($ramo=='C')
		 $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
	 elseif($ramo=='S')
		  $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(4,5), Criteria::IN);
	 
	 $c->setLimit($limit);
	 $results=OppCaricaPeer::doSelect($c);
	 foreach($results as $k => $r)
	 {
                 //$gruppi=$r->getOppCaricaHasGruppos();
                 $gruppo=OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($r->getId());
	 	 $items[$k]['id']=$r->getId();
		 $items[$k]['politico_id']=$r->getPoliticoId();
		 $items[$k]['nome']=$r->getOppPolitico()->getNome();
		 $items[$k]['cognome']=$r->getOppPolitico()->getCognome();
		 $items[$k]['sesso']=$r->getOppPolitico()->getSesso();
                 $items[$k]['acronimo'] =$gruppo->getAcronimo();  
		 $items[$k]['nome_gruppo']=$gruppo->getNome();
		 $items[$k]['circoscrizione']=$r->getCircoscrizione();
		 $items[$k]['perc_assenze']=($r->getAssenze()*100)/($r->getAssenze()+$r->getPresenze()+$r->getMissioni());
		 $items[$k]['assenze']=$r->getAssenze();
		 $items[$k]['perc_presenze']=($r->getPresenze()*100)/($r->getAssenze()+$r->getPresenze()+$r->getMissioni());
		 $items[$k]['presenze']=$r->getPresenze();
		 $items[$k]['perc_missioni']=($r->getMissioni()*100)/($r->getAssenze()+$r->getPresenze()+$r->getMissioni());
		 $items[$k]['missioni']=$r->getMissioni();
		 $items[$k]['votazioni']=$r->getAssenze()+$r->getPresenze()+$r->getMissioni();
		 $items[$k]['indice']=$r->getIndice();
                 $items[$k]['ribelle']=$r->getRibelle();
                 $items[$k]['perc_ribelle']=($r->getRibelle()*100)/$r->getPresenze();
	 }	 
	 
	 return $items;
	 	
 }


    public static $foreignConstituencies = array('Europa', 'America meridionale', 'America settentrionale e centrale', 'Asia-Africa-Oceania-Antartide' ,'Europa');


  public static function getRelazioneCon($mia_carica_id, $sua_carica_id, $data)
  {
    $mio_gruppo = self::getGruppo($mia_carica_id, $data);
    $suo_gruppo = self::getGruppo($sua_carica_id, $data);
    
    // caso mia firma
    if ($sua_carica_id == $mia_carica_id) return 'mia';

    // membri del governo
    if (is_null($mio_gruppo))
    {
      // cofirme di altri membri del governo non danno punti
      // se cofirma con maggioranza, stesso gruppo, se con minoranza, è opposizione
      if (is_null($suo_gruppo)) return 'gov';
      else
      {
        if (OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($suo_gruppo['id'], $data)) return 'gruppo';
        else return 'opp';
      }
    } 

    // eccezione gruppo misto
    // torna altri in ogni caso in cui è differente dal mio
    if ($mio_gruppo['acronimo'] == 'Misto')
    {
      if ($mio_gruppo['id'] == $suo_gruppo['id']) return 'gruppo';      
      else return 'altri';
    }
    
    // calcolo le maggioranze, passando i gruppi già calcolati (meno query)
    $mia_maggioranza = OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($mio_gruppo['id'], $data);
    $sua_maggioranza = OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($suo_gruppo['id'], $data);
    
    if ($mio_gruppo['id'] == $suo_gruppo['id']) return 'gruppo';
    if ($mia_maggioranza == $sua_maggioranza) return 'altri';
    return 'opp';
    
  }

  /**
   * fornisce il gruppo cui la carica appartiene a una certa data
   * se la data non è passata, fornisce il gruppo corrente
   *
   * @param integer $carica_id
   * @param string  $data
   * @return array ('id' => ID, 'nome' => Partito Democratico, 'acronimo' => PD)
   * @author Guglielmo Celata
   */
  public static function getGruppo($carica_id, $data)
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select g.id, g.nome, g.acronimo from opp_carica_has_gruppo cg, opp_gruppo g where g.id=cg.gruppo_id and cg.carica_id=%d and cg.data_inizio <= '%s' and (data_fine > '%s' or data_fine is null);",
                    $carica_id, $data, $data);
    $stm = $con->createStatement();
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    if ($rs->next()) {
      $row = $rs->getRow();
      return $row; 		
    }
    return null;
  }


  /**
   * controlla se la carica è di maggioranza o no
   *
   * @param integer $carica_id
   * @param string  $data 
   * @param integer $gruppo_id
   * @return boolean
   * @author Guglielmo Celata
   */
  public static function inMaggioranza($carica_id, $data, $gruppo_id = null)
  {
    
    $carica = self::retrieveByPK($carica_id);
    
    // ministri, viceministri e sottosegretari, sono sempre in maggioranza
    if ($carica->getOppTipoCarica()->getNome() == 'Ministro' ||
        $carica->getOppTipoCarica()->getNome() == 'Sottosegretario' ||
        $carica->getOppTipoCarica()->getNome() == 'Viceministro')
        return true;
        
    if (is_null($gruppo_id))
    {
      $gruppo_ar = self::getGruppo($carica_id, $data);
      $gruppo_id = $gruppo_ar['id'];
    }


    if ($gruppo_id) {
      return OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($gruppo_id, $data);
    } else {
      return null; // impossibile
    }
  }
  


  /**
   * estrae e torna tutti gli id degli atti presentati come primo firmatario
   * da carica_id, entro la data
   *
   * @param string $carica_id 
   * @param integer $legislatura 
   * @param string $data 
   * @return array di hash [id => ID, tipo_id => tipo_id]
   * @author Guglielmo Celata
   */
  public static function getSignedAttosIdsAndTiposByCaricaData($carica_id, $legislatura, $data)
  {
    
    // estrazione di tutte le firme relative ad atti firmati da carica_id
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select a.id, ca.tipo, a.tipo_atto_id from opp_carica_has_atto ca, opp_atto a where ca.atto_id=a.id and ca.carica_id=%d and a.legislatura = %d and ca.data < '%s'",
                   $carica_id, $legislatura, $data);

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    // costruzione array degli id
    $ids = array();
    while ($rs->next())
    {
      $row = $rs->getRow();
      $ids []= array('id' => $row['id'], 'tipo_atto_id' => $row['tipo_atto_id'], 'tipo_firma' => $row['tipo']);
    }
    
    return $ids;
    
  }

  /**
   * estrae e torna tutti gli id degli atti presentati come primo firmatario
   * da carica_id, entro la data
   *
   * @param string $carica_id 
   * @param integer $legislatura
   * @param string $data 
   * @return array di hash [id => ID, tipo_id => tipo_id]
   * @author Guglielmo Celata
   */
  public static function getPresentedAttosIdsAndTiposByCaricaData($carica_id, $legislatura, $data)
  {
    // estrazione di tutte le firme relative ad atti firmati come P da carica_id
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select a.id, a.tipo_atto_id from opp_carica_has_atto ca, opp_atto a where ca.atto_id=a.id and ca.tipo='P' and ca.carica_id=%d and a.legislatura = %d and ca.data < '%s' and (a.pred is null or a.pred in (select id from opp_atto where tipo_atto_id = 12))",
                   $carica_id, $legislatura, $data);

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    // costruzione array degli id
    $ids = array();
    while ($rs->next())
    {
      $row = $rs->getRow();
      $ids []= array('id' => $row['id'], 'tipo_atto_id' => $row['tipo_atto_id']);
    }
    
    return $ids;
    
  }

  /**
   * estrae e torna tutti gli id degli emendamenti presentati come primo firmatario
   * da carica_id, entro la data
   *
   * @param string $carica_id 
   * @param string $legislatura
   * @param string $data 
   * @return array di id
   * @author Guglielmo Celata
   */
  public static function getPresentedEmendamentosIdsByCaricaData($carica_id, $legislatura, $data)
  {
    
    // estrazione di tutte le firme relative a emendamenti presentati da P
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select e.id from opp_carica_has_emendamento ce, opp_emendamento e, opp_carica c, opp_atto_has_emendamento ae where ae.emendamento_id=e.id and c.id=ce.carica_id and ce.emendamento_id=e.id and ce.tipo='P' and ce.carica_id=%d and ce.data < '%s' and c.legislatura=%d and ae.portante = 1",
                   $carica_id, $data, $legislatura);

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    // costruzione array degli id
    $ids = array();
    while ($rs->next())
    {
      $row = $rs->getRow();
      $ids []= $row['id'];
    }
    
    return $ids;
    
  }


  /**
   * estrae il dettaglio degli interessi di un politico per gli argomenti, a una certa data
   *
   * @param string $carica_id 
   * @param string $argomenti_ids 
   * @param string $data 
   * @param string $fetch_interventi 
   * @return hash
   *         'firme_r' => [{'atto' => 1, 'punti_atto' => 232.23}, {'atto' => ID, 'punti_atto' => 12.34}, ...],
   *         'totale_firme_r' => 344.12,
   *         'firme_p' => [{'atto' => 2, 'punti_atto' => 123.45}, {'atto' => ID, 'punti_atto' => 23.34}, ...],
   *         'totale_firme_p' => 244.12,
   *         'firme_c' => [{'atto' => 3, 'punti_atto' => 234.56}, {'atto' => ID, 'punti_atto' => 34.56}, ...],
   *         'totale_firme_c' => 354.12,
   *         'interventi' => [{'atto' => 4, 'punti_atto' => 345.67, {'atto' => ID, 'punti_atto' => 56.67}, ...],
   *         'totale_interventi' => 456.12,
   *
   * @author Guglielmo Celata
   */
  public static function getDettaglioInteresseArgomenti($carica_id, $argomenti_ids, $data, $fetch_interventi = true)
  {
    $con = Propel::getConnection(self::DATABASE_NAME);

    $dettaglio = array();
    
    // estrazione di tutte le firme della carica relative ad atti taggati con argomento e del peso degli atti
    foreach (array('P', 'R', 'C') as $tipo_firma) {
      $dettaglio["firme_".strtolower($tipo_firma)] = array();
      $dettaglio['totale_firme_'.strtolower($tipo_firma)]  = 0;
      foreach (array(0, 1) as $is_omnibus) {
        if ($is_omnibus) {
          $tagging_table = 'sf_tagging_for_index';
          $tagging_conditions = "t.atto_id=ca.atto_id";
        } else {
          $tagging_table = 'sf_tagging';
          $tagging_conditions = "t.taggable_id=ca.atto_id and t.taggable_model='OppAtto'";          
        }
      
        $sql = sprintf("select ca.atto_id, ah.indice, ah.priorita from opp_atto a, opp_carica_has_atto ca, $tagging_table t, opp_act_history_cache ah where a.id=ca.atto_id and (ca.tipo != 'P' or ca.tipo = 'P' and a.pred is null) and a.is_omnibus=$is_omnibus and ca.tipo='%s' and ca.carica_id=%d and $tagging_conditions and ah.chi_tipo='A' and ah.data='%s' and ah.chi_id=ca.atto_id and t.tag_id in (%s) group by ca.atto_id", $tipo_firma, $carica_id, $data, implode(", ", $argomenti_ids));

        $stm = $con->createStatement(); 
        $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

        // costruzione array del dettaglio firme
        $totale = 0;
        while ($rs->next())
        {
          $row = $rs->getRow();
          $atto_id = $row['atto_id'];
          $priorita = $row['priorita'];
          $punti_atto = $row['indice']/(float)$priorita;
          $dettaglio["firme_".strtolower($tipo_firma)][] = array('atto' => OppAttoPeer::retrieveByPK($atto_id), 'punti_atto' => $punti_atto);
          $totale += OppCaricaHasAttoPeer::get_nuovo_fattore_firma($tipo_firma) * $punti_atto;
        }
        $dettaglio['totale_firme_'.strtolower($tipo_firma)] += $totale;
      }
    }

    if ($fetch_interventi) {
      $dettaglio["interventi"] = array();
      $dettaglio['totale_interventi'] = 0;
      foreach (array(0, 1) as $is_omnibus) {
        if ($is_omnibus) {
          $tagging_table = 'sf_tagging_for_index';
          $tagging_conditions = "t.atto_id=i.atto_id";
        } else {
          $tagging_table = 'sf_tagging';
          $tagging_conditions = "t.taggable_id=i.atto_id and t.taggable_model='OppAtto'";          
        }
        // estrazione di tutti gli interventi della carica relativo ad atti taggati con argomento 
        $sql = sprintf("select count(*) as ni, i.atto_id, ah.indice, ah.priorita from opp_atto a, opp_intervento i, $tagging_table t, opp_act_history_cache ah where a.id=i.atto_id and a.is_omnibus=$is_omnibus and ah.chi_id=i.atto_id and i.carica_id = %d and ah.data='%s' and $tagging_conditions and t.tag_id in (%s)  group by i.atto_id order by i.atto_id;", $carica_id, $data, implode(", ", $argomenti_ids));

        $stm = $con->createStatement(); 
        $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

        // costruzione array del dettaglio interventi
        $totale = 0;
        while ($rs->next())
        {
          $row = $rs->getRow();
          $n_interventi = $row['ni'];
          $atto_id = $row['atto_id'];
          $priorita = $row['priorita'];
          $punti_atto = $row['indice']/(float)$priorita;

          $dettaglio["interventi"][] = array('atto' => OppAttoPeer::retrieveByPK($atto_id), 'atto_id' => $atto_id, 
                                             'punti_atto' => $punti_atto,
                                             'n_interventi' => $n_interventi);
          $totale += OppCaricaHasAttoPeer::get_nuovo_fattore_firma('I') * $n_interventi * $punti_atto;
        }
        $dettaglio['totale_interventi'] += $totale;
      }
    }

    return $dettaglio;
  }


  public static function getAttiPresentatiPerTag($carica_id, $argomenti_ids, $tipo_firma, $con = null)
  {
    if (is_null($con)) {
  		$con = Propel::getConnection(self::DATABASE_NAME);
    }
    
    $atti_ids = array();
    foreach (array(0, 1) as $is_omnibus) {    
      if ($is_omnibus) {
        $tagging_table = 'sf_tagging_for_index';
        $tagging_conditions = "t.atto_id=ca.atto_id";
      } else {
        $tagging_table = 'sf_tagging';
        $tagging_conditions = "t.taggable_id=ca.atto_id and t.taggable_model='OppAtto'";          
      }
      $sql = sprintf("select ca.atto_id from opp_atto a, opp_carica_has_atto ca, $tagging_table t where ca.atto_id=a.id and (ca.tipo != 'P' or ca.tipo = 'P' and a.pred is null) and a.is_omnibus=$is_omnibus and ca.tipo='%s' and ca.carica_id=%d and $tagging_conditions and t.tag_id in (%s)", $tipo_firma, $carica_id, implode(", ", $argomenti_ids));

      $stm = $con->createStatement(); 
      $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
      while ($rs->next())
      {
        $row = $rs->getRow();
      
        $atti_ids []= $row['atto_id'];
      }        

    }
    
    return $atti_ids;
  }
  
  public static function getAttiConInterventiPerTag($carica_id, $argomenti_ids, $tipo_firma, $con = null)
  {
    if (is_null($con)) {
  		$con = Propel::getConnection(self::DATABASE_NAME);
    }

    $atti_ids = array();
    foreach (array(0, 1) as $is_omnibus) {
      if ($is_omnibus) {
        $tagging_table = 'sf_tagging_for_index';
        $tagging_conditions = "t.atto_id=i.atto_id";
      } else {
        $tagging_table = 'sf_tagging';
        $tagging_conditions = "t.taggable_id=i.atto_id and t.taggable_model='OppAtto'";          
      }
      $sql = sprintf("select i.atto_id, i.sede_id, i.data as data_intervento from opp_intervento i, opp_atto a, $tagging_table t where i.atto_id=a.id and a.is_omnibus=$is_omnibus and i.carica_id = %d and $tagging_conditions and t.tag_id in (%s) group by i.atto_id, i.sede_id, i.data;", $carica_id, implode(", ", $argomenti_ids));

      $stm = $con->createStatement(); 
      $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
    
      while ($rs->next())
      {
        $row = $rs->getRow();
        $atto_id = $row['atto_id'];
        
        // gli atti posono essere ripetuti se ci sono più date o sedi con almeno un intervento
        // il raggruppamento corretto è fatto nella select
        if (array_key_exists($atto_id, $atti_ids)) {
          $atti_ids[$atto_id] ++;
        } else {
          $atti_ids[$atto_id] = 1;          
        }
      }        
    }
        
    return $atti_ids;
  }


  public static function getPosizionePoliticoOggettiVotatiPerArgomenti($carica_id, $tags_ids, $user_id, $verbose = false, $log = null, $data = null, $con = null)
  {
    
    // Firme
    // estrazione di tutti gli atti taggati con un pool di argomenti e votati da un utente
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select f.tipo, f.atto_id, a.tipo_atto_id, t.tag_id, v.voting from opp_carica_has_atto f, opp_atto a, sf_tagging t, sf_votings v  where f.carica_id=%d and f.atto_id=a.id and t.taggable_model='OppAtto' and t.taggable_id = a.id and t.tag_id in (%s) and v.votable_model='OppAtto' and v.votable_id=a.id and v.user_id=%d",
                   $carica_id, implode(", ", $tags_ids), $user_id);


    if ($verbose) {
      echo "\nAtti: " . $sql . "\n\n";
    }
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    $log_msgs = array();
    
    // calcolo del punteggio
    $punteggio = 0;
    $punteggio_firme = 0;
    $punteggio_interventi = 0;
    while ($rs->next())
    {
      $row = $rs->getRow();
      $atto_id = $row['atto_id'];
      $tipo_atto_id = $row['tipo_atto_id'];
      $tipo_firma = $row['tipo'];
      $voto = $row['voting'];
      
      $d_punteggio = OppCaricaHasAttoPeer::get_fattore_firma_posizione($tipo_firma, $tipo_atto_id) * $voto;
      
      $log_msgs [] = $log_msg = sprintf("atto: %9d, tipo_atto: %4d, tipo_firma: %1s, voto: %3d, punteggio: %7.2f", $atto_id, $tipo_atto_id, $tipo_firma, $voto, $d_punteggio);
      if ($verbose) {
        echo sprintf ("  %s\n", $log_msg);
      }
      
      $punteggio_firme += $d_punteggio;
    }

    $log_msgs []= sprintf("Totale firme: %7.2f", $punteggio_firme);


    // Interventi
    // estrazione di tutti gli interventi votati da un utente e relativi ad atti taggati con un pool di argomenti
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select i.id, i.tipologia, i.atto_id, t.tag_id, v.voting from opp_intervento i, sf_tagging t, sf_votings v  where i.carica_id=%d and t.taggable_model='OppAtto' and t.taggable_id = i.atto_id and t.tag_id in (%s) and v.votable_model='OppIntervento' and v.votable_id=i.id and v.user_id=%d",
                   $carica_id, implode(", ", $tags_ids), $user_id);

     if ($verbose) {
       echo "\nInterventi: " . $sql . "\n\n";
     }

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    // calcolo del punteggio
    while ($rs->next())
    {
      $row = $rs->getRow();
      $intervento_id = $row['id'];
      $tipo_intervento = $row['tipologia'];
      $atto_id = $row['atto_id'];
      $voto = $row['voting'];
      
      $d_punteggio = OppInterventoPeer::get_fattore_intervento_posizione($tipo_intervento) * $voto;

      $log_msgs [] = $log_msg = sprintf("  atto: %9d, voto: %3d, tipo_intervento: %61s\n", $atto_id, $tipo_intervento, $voto, $d_punteggio);
      if ($verbose) {
        echo sprintf ("  %s\n", $log_msg);
      }
      
      $punteggio_interventi += $d_punteggio;
    }
    
    $punteggio = $punteggio_firme + $punteggio_interventi;
    
    $log_msgs []= sprintf("Totale interventi: %7.2f", $punteggio_interventi);
    $log_msgs []= sprintf("Totale: %7.2f", $punteggio);
    
    
    if (is_null($log)) {
      return $punteggio;
    } else {
      return $log_msgs;
    }
  }

  /**
   * torna un array associativo con i dati storici dell'interesse di un politico su argomenti
   *
   * @param array $argomenti_ids 
   * @param string $carica_id 
   * @param string $data - se specificato, definisce la condizione sul campo data per i record nella cache
   * @return hash, con la data come chiave
   *         - 2010-04-30 => 34.56
   *         - 2010-05-31 => 39.63
   *         - ...
   * @author Guglielmo Celata
   */
  public static function getStoricoInteressePoliticoArgomenti($carica_id, $argomenti_ids, $data_condition = '')
  { 
    $storico = array();
		$con = Propel::getConnection(self::DATABASE_NAME);

    // FIRME
    // estrazione di tutte le firme della carica relative ad atti taggati con argomento e del peso degli atti
    foreach (array('P', 'R', 'C') as $tipo_firma) {
      $atti_ids = self::getAttiPresentatiPerTag($carica_id, $argomenti_ids, $tipo_firma, $con);
      if (count($atti_ids) == 0) continue;
    
      $sql = sprintf("select ah.chi_id, ah.indice, ah.data, ah.priorita from opp_act_history_cache ah where ah.chi_tipo='A' $data_condition and ah.chi_id in (%s) order by ah.data", implode(", ", $atti_ids));

      $stm = $con->createStatement(); 
      $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

      while ($rs->next())
      {
        $row = $rs->getRow();
        
        $data = $row['data'];
        $priorita = $row['priorita'];
        $punti_atto = $row['indice']/(float)$priorita;
        
        if (!array_key_exists($data, $storico))
          $storico[$data] = 0;

        $storico[$data] += $delta = OppCaricaHasAttoPeer::get_nuovo_fattore_firma($tipo_firma) * $punti_atto;
      }        
    }
    
    // INTERVENTI
    // estrazione di tutte le sedute con almeno un intervento della carica relativo ad atti taggati con argomento 
    $atti_ids = self::getAttiConInterventiPerTag($carica_id, $argomenti_ids, $tipo_firma, $con);
    if (count($atti_ids) > 0)
    {
      $sql = sprintf("select ah.chi_id, ah.indice, ah.data, ah.priorita from opp_act_history_cache ah where ah.chi_tipo='A' $data_condition and ah.chi_id in (%s) order by ah.data", implode(", ", array_keys($atti_ids)));

      $stm = $con->createStatement(); 
      $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
      while ($rs->next())
      {
        $row = $rs->getRow();

        $data = $row['data'];
        $priorita = $row['priorita'];

        // punti moltiplicati per il *peso* dell'atto (n. di sedi e date con almeno un intervento)
        // poi divisi per la priorità
        $punti_atto = $atti_ids[$row['chi_id']] * $row['indice']/(float)$priorita;

        if (!array_key_exists($data, $storico))
          $storico[$data] = 0;

        $storico[$data] += $delta = OppCaricaHasAttoPeer::get_nuovo_fattore_firma('I') * $punti_atto;
      }  
      
    }
    
  
    ksort($storico);
    return $storico;
    
  }
  
  /**
   * torna un array associativo di politici che si occupano di certi argomenti, 
   * ordinati in base al punteggio, con eventuale limit
   *
   * @param array $argomenti_ids 
   * @param string $ramo (C o S)
   * @param integer $gruppo_id filtro opzionale per gruppo
   * @param boolean fetch_interventi (se fetchare o meno gli interventi)
   * @return array di hash, con chiave carica_id
   *          - politico_id,
   *          - nome, cognome, acronimo,
   *          - punteggio
   * @author Guglielmo Celata
   */
  public static function getClassificaPoliticiSiOccupanoDiArgomenti($argomenti_ids, $ramo, $data, $limit = null, $gruppo_ids = null, $fetch_interventi = true)
  {
    
    // definizione array tipi di cariche
    if ($ramo == 'C') {
      $tipi_cariche = array(1);
    } else if ($ramo == 'S') {      
      $tipi_cariche = array(4, 5);
    } else {
      $tipi_cariche = array(1, 4, 5);      
    }

    if (is_array($gruppo_ids))
    {
      if (count($gruppo_ids) > 0) {
        $group_constraint = sprintf(" and g.id in (%s) ", implode(", ", $gruppo_ids));
      } else {
        $group_constraint = '';
      }
    }
    else if (is_null($gruppo_ids))
      $group_constraint = '';
    else
      $group_constraint = " and g.id = $gruppo_ids "; 
      
    // Firme
    // estrazione di tutte le firme relative ad atti non-omnibus taggati con argomento
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select p.nome, p.cognome, p.id as politico_id, g.acronimo, c.id as carica_id, c.circoscrizione, ca.tipo, ca.atto_id, ah.indice, ah.priorita from opp_carica c, opp_carica_has_atto ca, opp_carica_has_gruppo cg, opp_gruppo g, sf_tagging t, opp_act_history_cache ah, opp_politico p, opp_atto a where p.id=c.politico_id and c.id=ca.carica_id and cg.carica_id=c.id and cg.data_fine is null and cg.gruppo_id=g.id %s and a.is_omnibus = 0 and t.taggable_id=ca.atto_id and t.taggable_model='OppAtto' and ah.chi_tipo='A' and ah.data='%s' and ah.chi_id=ca.atto_id  and a.id=ca.atto_id and (ca.tipo != 'P' or ca.tipo = 'P' and a.pred is null) and c.tipo_carica_id in (%s) and c.data_fine is null and cg.data_fine is null and t.tag_id in (%s) group by ca.tipo, ca.atto_id, ca.carica_id",
                   $group_constraint, $data, implode(", ", $tipi_cariche), implode(", ", $argomenti_ids));

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    // costruzione array associativo dei politici (sommatoria pesata)
    $politici = array();
    while ($rs->next())
    {
      $row = $rs->getRow();
      $carica_id = $row['carica_id'];
      $circoscrizione = $row['circoscrizione'];
      $atto_id = $row['atto_id'];
      $tipo = $row['tipo'];
      $punti_atto = $row['indice'];
      $priorita = $row['priorita'];
      $politico_id = $row['politico_id'];
      $nome = $row['nome'];
      $cognome = $row['cognome'];
      $acronimo = $row['acronimo'];
      
      
      if (!array_key_exists($carica_id, $politici))
        $politici[$carica_id] = array('politico_id' => $politico_id, 'circoscrizione' => $circoscrizione,
                                      'nome' => $nome, 'cognome' => $cognome, 'acronimo' => $acronimo, 
                                      'punteggio' => 0);

      $politici[$carica_id]['punteggio'] += OppCaricaHasAttoPeer::get_nuovo_fattore_firma($tipo) * $punti_atto / (float)$priorita;
    }


    // Firme
    // estrazione di tutte le firme relative ad atti omnibus taggati con argomento
		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select p.nome, p.cognome, p.id as politico_id, g.acronimo, c.id as carica_id, c.circoscrizione, ca.tipo, ca.atto_id, ah.indice, ah.priorita from opp_carica c, opp_carica_has_atto ca, opp_carica_has_gruppo cg, opp_gruppo g, sf_tagging_for_index t, opp_act_history_cache ah, opp_politico p, opp_atto a where p.id=c.politico_id and c.id=ca.carica_id and cg.carica_id=c.id and cg.data_fine is null and cg.gruppo_id=g.id %s and a.is_omnibus = 1 and t.atto_id=ca.atto_id and (ca.tipo != 'P' or ca.tipo = 'P' and a.pred is null) and  ah.chi_tipo='A' and ah.data='%s' and ah.chi_id=ca.atto_id and a.id=ca.atto_id and c.tipo_carica_id in (%s) and c.data_fine is null and cg.data_fine is null and t.tag_id in (%s) group by ca.tipo, ca.atto_id, ca.carica_id",
                   $group_constraint, $data, implode(", ", $tipi_cariche), implode(", ", $argomenti_ids));

    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

    // aggiunta all'array della classifica dei politici
    while ($rs->next())
    {
      $row = $rs->getRow();
      $carica_id = $row['carica_id'];
      $circoscrizione = $row['circoscrizione'];
      $atto_id = $row['atto_id'];
      $tipo = $row['tipo'];
      $punti_atto = $row['indice'];
      $priorita = $row['priorita'];
      $politico_id = $row['politico_id'];
      $nome = $row['nome'];
      $cognome = $row['cognome'];
      $acronimo = $row['acronimo'];
      
      
      if (!array_key_exists($carica_id, $politici))
        $politici[$carica_id] = array('politico_id' => $politico_id, 'circoscrizione' => $circoscrizione,
                                      'nome' => $nome, 'cognome' => $cognome, 'acronimo' => $acronimo, 
                                      'punteggio' => 0);

      $politici[$carica_id]['punteggio'] += OppCaricaHasAttoPeer::get_nuovo_fattore_firma($tipo) * $punti_atto / (float)$priorita;
    }

    if ($fetch_interventi) {
      // Interventi
      // estrazione degli interventi relativi ad atti non-omnibus taggati con argomenti
      $sql = sprintf("select count(*) as ni, p.id as politico_id, p.nome, p.cognome, c.circoscrizione, g.acronimo, i.atto_id, i.carica_id, ah.indice, ah.priorita from opp_intervento i, opp_atto a, opp_politico p, opp_carica c, opp_carica_has_gruppo cg, opp_gruppo g, sf_tagging t, opp_act_history_cache ah where p.id=c.politico_id and ah.chi_id=i.atto_id and i.atto_id=a.id and c.id=i.carica_id and cg.carica_id=c.id and cg.data_fine is null  and cg.gruppo_id=g.id %s  and ah.data='%s' and c.tipo_carica_id in (%s) and c.data_fine is null and a.is_omnibus = 0 and t.taggable_id=a.id and t.taggable_model='OppAtto' and t.tag_id in (%s) group by i.carica_id, i.atto_id;",
                     $group_constraint, $data, implode(", ", $tipi_cariche), implode(", ", $argomenti_ids));

      $stm = $con->createStatement(); 
      $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

      // costruzione array associativo dei politici (sommatoria pesata)
      while ($rs->next())
      {
        $row = $rs->getRow();
        $n_interventi = $row['ni'];
        $carica_id = $row['carica_id'];
        $atto_id = $row['atto_id'];
        $circoscrizione = $row['circoscrizione'];
        $priorita = $row['priorita'];
        $punti_atto = $row['indice'];
        $politico_id = $row['politico_id'];
        $nome = $row['nome'];
        $cognome = $row['cognome'];
        $acronimo = $row['acronimo'];

        if (!array_key_exists($carica_id, $politici))
          $politici[$carica_id] = array('politico_id' => $politico_id, 'circoscrizione' => $circoscrizione,
                                        'nome' => $nome, 'cognome' => $cognome, 'acronimo' => $acronimo, 
                                        'punteggio' => 0);

        $politici[$carica_id]['punteggio'] += OppCaricaHasAttoPeer::get_nuovo_fattore_firma('I') * $n_interventi * $punti_atto / (float)$priorita;
      }

      // estrazione di tutte le sedute con interventi relativi ad atti omnibus taggati con argomenti
      $sql = sprintf("select count(*) as ni, p.id as politico_id, p.nome, p.cognome, c.circoscrizione, g.acronimo, i.atto_id, i.sede_id, i.data, i.carica_id, ah.indice, ah.priorita from opp_intervento i, opp_atto a, opp_politico p, opp_carica c, opp_carica_has_gruppo cg, opp_gruppo g, sf_tagging_for_index t, opp_act_history_cache ah where p.id=c.politico_id and ah.chi_id=i.atto_id and i.atto_id=a.id and c.id=i.carica_id and cg.carica_id=c.id  and cg.data_fine is null and cg.gruppo_id=g.id %s  and ah.data='%s' and c.tipo_carica_id in (%s) and c.data_fine is null and a.is_omnibus = 1 and t.atto_id=a.id and t.tag_id in (%s) group by i.carica_id, i.atto_id;",
                     $group_constraint, $data, implode(", ", $tipi_cariche), implode(", ", $argomenti_ids));

      $stm = $con->createStatement(); 
      $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

      // costruzione array associativo dei politici (sommatoria pesata)
      while ($rs->next())
      {
        $row = $rs->getRow();
        $n_interventi = $row['ni'];
        $carica_id = $row['carica_id'];
        $circoscrizione = $row['circoscrizione'];
        $atto_id = $row['atto_id'];
        $priorita = $row['priorita'];
        $punti_atto = $row['indice'];
        $politico_id = $row['politico_id'];
        $nome = $row['nome'];
        $cognome = $row['cognome'];
        $acronimo = $row['acronimo'];

        if (!array_key_exists($carica_id, $politici))
          $politici[$carica_id] = array('politico_id' => $politico_id, 'circoscrizione' => $circoscrizione,
                                        'nome' => $nome, 'cognome' => $cognome, 'acronimo' => $acronimo, 
                                        'punteggio' => 0);

        $politici[$carica_id]['punteggio'] += OppCaricaHasAttoPeer::get_nuovo_fattore_firma('I') * $n_interventi * $punti_atto / (float)$priorita;
      }


    }
    
    // ordinamento per rilevanza, prima dello slice
    if (count($politici) > 1)
      uasort($politici, array("OppCaricaPeer", "comparisonIndice"));


    // slice dell'array, se specificata l'opzione limit
    if (!is_null($limit) && count($politici) > $limit)
    {
      $politici = array_slice($politici, 0, $limit, true);
    }

    return $politici;
  }
  
  
  public static function comparisonIndice($a, $b)
  {
    if ($a['punteggio'] == $b['punteggio']) {
        return 0;
    }
    return ($a['punteggio'] < $b['punteggio']) ? 1 : -1;
  }
  
  /**
   * return an associative array of all the constituencies
   * a zero option is included at the beginning, if specified
   *
   * @param string $ramo 
   * @param boolean $include_zero
   * @return array of strings
   * @author Guglielmo Celata
   */
  public static function getAllConstituencies($ramo, $include_zero = false)
  {
    $c = new Criteria();
    if ($ramo == 'camera')
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
    else
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, 4);
    $c->clearSelectColumns();
    $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
    $c->setDistinct();
    $rs = OppCaricaPeer::doSelectRS($c);
    if ($include_zero)
      $all_constituencies = array('0' => $include_zero);
    else
      $all_constituencies = array();
      
    while ($rs->next())
    {
      $all_constituencies[$rs->getString(1)]= $rs->getString(1);
    }
    
    // ordina le circoscrizioni
    uasort($all_constituencies, 'OppCaricaPeer::sortConstituencies');
    return $all_constituencies;
  }
  
  /**
    * Callback function per i sort() su array di circoscrizioni (solo stringhe)
    * ha come scopo quello di ordinare tutte le voci in modo alfabetico
    * facendo slittare in fondo le circoscrizioni estere
    * @author Daniele Faraglia
    */
  public static function sortConstituencies( $a, $b )
  {
      if ( in_array($a, self::$foreignConstituencies ) ) 
          return in_array($b, self::$foreignConstituencies) ? strnatcmp($a, $b) : 1;
      return in_array($b, self::$foreignConstituencies) ? -1 : strnatcmp($a, $b);
  }
  
  public static function doSelectFullReport($politico_id)
  {
    $risultato = array();
	
  	$c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(OppCaricaPeer::ID);
  	$c->addSelectColumn(OppCaricaPeer::DATA_INIZIO);
  	$c->addSelectColumn(OppCaricaPeer::DATA_FINE);
  	$c->addSelectColumn(OppCaricaPeer::CARICA);
  	$c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);
  	$c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->addSelectColumn(OppCaricaPeer::INDICE);
  	$c->addSelectColumn(OppCaricaPeer::POSIZIONE);
  	$c->addAsColumn('CONT', 'COUNT(*)');
  	$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID, OppCaricaPeer::ID, Criteria::LEFT_JOIN);
  	$c->addGroupByColumn(OppCaricaPeer::ID);
  	$c->addGroupByColumn(OppVotazioneHasCaricaPeer::VOTO);
  	$c->add(OppCaricaPeer::POLITICO_ID, $politico_id, Criteria::EQUAL);
  	$c->addDescendingOrderByColumn(OppCaricaPeer::DATA_INIZIO);
  	$c->addDescendingOrderByColumn(OppCaricaPeer::DATA_FINE);
  	$rs = OppCaricaPeer::doSelectRS($c);  
	
  	while ($rs->next())
    {
	  
  	  if(!isset($risultato[$rs->getInt(1)]))
  	  { 
	    
  		$risultato[$rs->getInt(1)] = array('data_inizio' => $rs->getDate(2, 'Y-m-d'), 'data_fine' => $rs->getDate(3, 'Y-m-d'),
  		                                   'carica' => $rs->getString(4), 'circoscrizione' => $rs->getString(5), 
  		                                   'Assente' => 0, 'Astenuto' => 0, 'Contrario' => 0, 'Favorevole' => 0, 'In missione' => 0, 
  										   'Partecipante votazione non valida' => 0, 'Presidente di turno' => 0, 'Richiedente la votazione e non votante' => 0, 
  										   'Voto segreto' => 0, 'Indice' => $rs->getFloat(7), 'Posizione' => $rs->getInt(8) );
  	  }
	  
  	  $risultato[$rs->getInt(1)][$rs->getString(6)] = $rs->getInt(9);
	  	  
  	}
	
	  return $risultato;
	
  }

  
  public static function doSelectPresenzePerGruppo($carica_id, $data_inizio, $data_fine)
  {
    $c = new Criteria();
  	$c->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, OppVotazionePeer::ID, Criteria::LEFT_JOIN);
  	$c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID, Criteria::LEFT_JOIN);
  	$c->add(OppVotazioneHasCaricaPeer::CARICA_ID, $carica_id, Criteria::EQUAL);
  	$c->add(OppSedutaPeer::DATA, $data_inizio, Criteria::GREATER_EQUAL);
	
  	if($data_fine!='') 
  	  $c->add(OppSedutaPeer::DATA, $data_fine, Criteria::LESS_EQUAL);
	
  	$cton1 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_2'), Criteria::EQUAL);
  	$cton2 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_3'), Criteria::EQUAL);
    $cton1->addOr($cton2);
	  $cton3 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_4'), Criteria::EQUAL);
    $cton1->addOr($cton3);
	  $cton4 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_6'), Criteria::EQUAL);
    $cton1->addOr($cton4);
	  $cton5 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_7'), Criteria::EQUAL);
    $cton1->addOr($cton5);
	  $cton6 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_8'), Criteria::EQUAL);
    $cton1->addOr($cton6);
	  $cton7 = $c->getNewCriterion(OppVotazioneHasCaricaPeer::VOTO, sfConfig::get('app_voto_9'), Criteria::EQUAL);
    $cton1->addOr($cton7);
    $c->add($cton1);
	
	  return $totale = OppVotazioneHasCaricaPeer::doCount($c);   
  }


  /**
   * torna array di OppCarica a partire da un array di ID (id di carica e NON politico)
   *
   * @param array $ids 
   * @return array of OppCarica
   * @author Guglielmo Celata
   */
  public function getRSFromIDArray($ids, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

    $sql = sprintf("select c.id, c.tipo_carica_id, p.nome, p.cognome from opp_carica c, opp_politico p where c.politico_id=p.id and c.id in (%s)",
                   implode(",", $ids));
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }


  public static function getParlamentariRamoDataRS($ramo, $legislatura, $data, $offset = null, $limit = null)
  {

    switch (strtolower($ramo)) {
      case 'camera':
      case 'c':
        $tipi_carica_ids = array(1);
        break;

      case 'senato':
      case 's':
        $tipi_carica_ids = array(4,5);
        break;

      case 'governo':
        $tipi_carica_ids = array(2,3,6,7);
        break;
      
      case 'parlamento':
        $tipi_carica_ids = array(1,4,5);
        break;
      
      default:
        $tipi_carica_ids = array(1,2,3,4,5,6,7);
        break;
    }

		$con = Propel::getConnection(self::DATABASE_NAME);
    $sql = sprintf("select c.id, c.politico_id, c.tipo_carica_id, p.nome, p.cognome from opp_carica c, opp_politico p where p.id=c.politico_id and (c.legislatura=%d or legislatura is null) and c.tipo_carica_id in (%s) and c.data_inizio < '%s' and (data_fine >= '%s' or data_fine is null) order by c.tipo_carica_id, p.cognome",
                   $legislatura, implode(',', $tipi_carica_ids), $data, $data);
    if (!is_null($limit)) {
      if (!is_null($offset))
        $sql .= " limit $offset, $limit";
      else
        $sql .= " limit $limit";
    }
    $stm = $con->createStatement(); 
    return $stm->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);
  }


  /**
   * estrae i parlamentari di un ramo, per una legislatura, attivi durante una settimana 
   * se ramo e settimana non sono specificati, l'estrazione riguarda tutti i rami/periodi
   * @param string  $ramo ['', 'camera', 'senato', 'governo']
   * @param integer $legislatura 
   * @param string  $settimana ['', 'y-m-d']
   * @return array di OppCaricaObject (join con OppPolitico)
   * @author Guglielmo Celata
   */
  public static function getParlamentariRamoSettimana($ramo, $settimana, $offset = null, $limit = null)
  {
    // calcolo della legislatura
    if ($settimana != '')
      $legislatura = OppLegislaturaPeer::getCurrent($settimana);
    else
      $legislatura = OppLegislaturaPeer::getCurrent();
      
    $c = new Criteria();
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);
    $c->addAscendingOrderByColumn(OppCaricaPeer::TIPO_CARICA_ID);
    $c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
    
    if ($ramo == 'camera')
    {
      $c->add(OppCaricaPeer::LEGISLATURA, $legislatura, Criteria::EQUAL);
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, '1', Criteria::EQUAL);
    }
    else if ($ramo == 'senato')
    {
      // in questo modo considero i senatori a vita
      $cton = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $legislatura, Criteria::EQUAL);
      $cton1 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, null, Criteria::EQUAL);
      $cton->addOr($cton1);
      $c->add($cton);
 	    $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(4, 5), Criteria::IN);
    } 
    else if ($ramo == 'governo')
    {
      // considero presidente del consiglio, ministri, vicemoinistri e sottosegretari
 	    $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(2, 3, 6, 7), Criteria::IN);
    } 
    
    else if ($ramo == '')
    {

      /**
       * criteri composti per estrarre deputati, senatori e senatori a vita
       * (oppCarica.legislatura = leg OR oppCarica.legislatura IS NULL) AND 
       * (oppCarica.tipo_carica in (4, 5)  OR (oppCarica.legislatura = leg AND oppCarica.tipo_carica = 1))
       *
       **/
      $crit0 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $legislatura);
      $crit1 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, null, Criteria::ISNULL);
      $crit2 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, array(4, 5), Criteria::IN);
      $crit3 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $legislatura);
      $crit4 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 1);

      $crit0->addOr($crit1);
      $crit3->addAnd($crit4);
      $crit2->addOr($crit3);
      $crit0->addAnd($crit2);

      $c->add($crit0);
      
    }
    
    // in carica al momento del calcolo
    if ($settimana != '') {
      $cton0 = $c->getNewCriterion(OppCaricaPeer::DATA_INIZIO, strtotime("+1 week", strtotime($settimana)), Criteria::LESS_THAN);
      $cton1 = $c->getNewCriterion(OppCaricaPeer::DATA_FINE, $settimana, Criteria::GREATER_EQUAL);
      $cton2 = $c->getNewCriterion(OppCaricaPeer::DATA_FINE, null, Criteria::ISNULL);
      
      $cton1->addOr($cton2);
      $cton0->addAnd($cton1);
      $c->add($cton0);
    } else {
      $c->add(OppCaricaPeer::DATA_FINE, null, Criteria::EQUAL);
    }
    
    if ($offset) $c->setOffset($offset);
    if ($limit) $c->setLimit($limit);
    return self::doSelect($c);
  }


  public static function getActiveMPs($ramo, $limit = 0, $leg = 16 )
  {
    
    if (!in_array($ramo, array('C', 'S')))
      throw new Exception("Ramo must be 'C' or 'S'");
      
    $c = new Criteria();
    if ($ramo == 'C')
    {
      $c->add(self::TIPO_CARICA_ID, 1);
      $c->add(OppCaricaPeer::TIPO_CARICA_ID, '1', Criteria::EQUAL);
      
    }
    else
    {
      $c->add(self::TIPO_CARICA_ID, array(4, 5), Criteria::IN);

      $cton = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, '4', Criteria::EQUAL);
      $cton1 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, '5', Criteria::EQUAL);
      $cton->addOr($cton1);
      $c->add($cton);
      
    }

    $c->add(OppCaricaPeer::LEGISLATURA, $leg, Criteria::EQUAL);
    $c->add(self::DATA_FINE, null, Criteria::ISNULL);
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);

    if ($limit > 0)
      $c->setLimit($limit);
      
    return OppCaricaPeer::doSelect($c);
  }


  /**
   * return the number of MPs in the given section (C or S)
   *
   * @param string $ramo 
   * @return void
   * @author Guglielmo Celata
   */
  public static function getNParlamentari($ramo)
  {
    if (!in_array($ramo, array('C', 'S')))
      throw new Exception("Ramo must be 'C' or 'S'");
      
    $c = new Criteria();
    $c->add(self::DATA_FINE, null, Criteria::ISNULL);
    if ($ramo == 'C')
      $c->add(self::TIPO_CARICA_ID, 1);
    else
      $c->add(self::TIPO_CARICA_ID, array(4, 5), Criteria::IN);
    
    return self::doCount($c);
  }

  /**
   * returns the sum of the given field for all the MPs
   * in the given parliament section
   *
   * @param string $section 
   * @param string $field - the field to sum
   * @return void
   * @author Guglielmo Celata
   */
  public static function getSomma($field, $section)
  {
    $con=Propel::getConnection(self::DATABASE_NAME); 
    
    $sql = "SELECT sum($field) from opp_carica where data_fine is null and ";
    if ($section == 'C') $sql .= "tipo_carica_id = 1;";
    else $sql .= "tipo_carica_id in (4,5);";
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_NUM);
    if ($rs->next()) 
      return $rs->getInt(1);
    else
      return 0;
  }

}
?>
