<?php

/**
 * Classe che mantiene i parametri dell'indice di attività
 *
 * @package lib.model
 */ 
class OppIndiceAttivitaPeer extends OppIndicePeer
{

  public static $opp_ns = 'http://www.openpolis.it/2010/opp';
  public static $op_ns = 'http://www.openpolis.it/2010/op';
  public static $xlink_ns = 'http://www.w3.org/1999/xlink';
  
  public static $filesystem;
  
  
  public static $vecchi_punteggi = array(
    'ddl'             => array('P' => 10, 'C' => 3, 'R' => 6),
    'mozione'         => array('P' =>  6, 'C' => 2, 'R' => 0),
    'interpellanza'   => array('P' =>  3, 'C' => 1, 'R' => 0),
    'interrogazione'  => array('P' =>  3, 'C' => 1, 'R' => 0),
    'risoluzione'     => array('P' =>  5, 'C' => 2, 'R' => 0),
    'odg'             => array('P' =>  4, 'C' => 2, 'R' => 0)
  );

 
  /**
   * ritorna il punteggio per un tipo di atto, di azione e per maggioranza o opposizione
   *
   * @param string $tipo_atto
   * @param string $tipo_azione 
   * @param string $maggioranza 
   * @return float
   * @author Guglielmo Celata
   */
  public function getPunteggio($tipo_atto, $tipo_azione, $maggioranza)
  {
    if (!array_key_exists($tipo_azione, parent::$punteggi[$tipo_atto])) {
      return 0.0;
    }
    return parent::$punteggi[$tipo_atto][$tipo_azione][$maggioranza?'m':'o'];
  }

  /**
   * ritorna il punteggio per un tipo di atto, dato un tipo di co-firma
   *
   * @param string $tipo_atto
   * @param string $tipo_firma
   * @return float
   * @author Guglielmo Celata
   */
  public function getVecchioPunteggio($tipo_firma, $tipo_atto)
  {
    return self::$vecchi_punteggi[strtolower($tipo_atto)][strtoupper($tipo_firma)];
  }


  /**
   * calcola indice attività con vecchio criterio per un politico, fino a una certa data
   *
   * @param integer $id 
   * @param integer $legislatura 
   * @param date $data 
   * @param boolean $verbose 
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcola_vecchio_indice($carica_id, $legislatura, $data = '', $verbose = '')
  {
    if ($data == '') throw new Exception("Date can not be null");
  
    // componente dovuta alle firme
    $attis = OppCaricaPeer::getSignedAttosIdsAndTiposByCaricaData($carica_id, $legislatura, $data);
    if ($verbose)
      printf("\n  numero atti: %d\n", count($attis));
      
    $d_punteggio = 0.;
    foreach ($attis as $atto) {
      $tipo_atto = OppTipoAttoPeer::getTipoPerIndice($atto['tipo_atto_id']);
      $d_punteggio += $dd_punteggio = self::getVecchioPunteggio($atto['tipo_firma'], $tipo_atto);
      if ($verbose)
        printf("    atto: %7d, tipo: %2d, firma: %1s, punti%7.2f\n", $atto['id'], $atto['tipo_atto_id'], $atto['tipo_firma'], $dd_punteggio);
    }
    
    // componente dovuta agli interventi
    $n_interventi = OppInterventoPeer::countInterventiByCaricaData($carica_id, $legislatura, $data);
    $d_punteggio += $n_interventi;
    if ($verbose)
      printf("    n_interventi: %d\n", $n_interventi);
  
    return $d_punteggio;
  }
 


  /**
   * calcola l'indice di attività per un politico
   *
   * @param integer $id 
   * @param date $data 
   * @param boolean $verbose 
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcola_indice_politico($carica_id, $legislatura, $data = '', $verbose = '', $atti_ids = array(), $emendamenti_ids = array())
  {
    if ($data == '') throw new Exception("Date can not be null");

    
    // inizializzazion xml con dettaglio computazione
    $xml_node = new SimpleXMLElement(
      '<opp xmlns="'.self::$opp_ns.'" '.
            ' xmlns:op="'.self::$op_ns.'" '.
            ' xmlns:xlink="'.self::$xlink_ns.'" >'.
      '</opp>');
      
    // self::addProcessingInstruction($xml_node, 'xml-stylesheet', 'type="text/xsl" href="../xslt/politici.xslt"');
    $content_node = $xml_node->addChild('op:content', null, self::$op_ns);             
  
    // estrae atti firmati come Primo Firmatario, fino alla data specificata
    $attis = OppCaricaPeer::getPresentedAttosIdsAndTiposByCaricaData($carica_id, $legislatura, $data);

    $punteggio = 0.;
  
    // --- componente dell'indice dovuta agli atti presentati (primo firmatario) ---
    $n_atti = count($attis);
    $atti_node = $content_node->addChild('atti_presentati', null, self::$opp_ns);
    $atti_node->addAttribute('n_atti_presentati', $n_atti);
    
    $d_punteggio = 0.;
    foreach ($attis as $atto) {
			// --- skip atti da non analizzare, se passato elenco atti in linea di comando
      if (!empty($atti_ids) && !in_array($atto['id'], $atti_ids)) {
        continue;
      }
      $dd_punteggio = self::calcolaIndiceAtto($carica_id, $atto['id'], $atto['tipo_atto_id'], $data, $atti_node, $verbose);
      $d_punteggio += $dd_punteggio;
    }
    $atti_node->addAttribute('totale', $d_punteggio);
    if ($verbose)
      printf("\ntotale atti presentati: %d - punteggio: %7.2f\n", $n_atti, $d_punteggio);
    $punteggio += $d_punteggio;


    // --- componente indice dovuta alle firme come relatore
    $atti_relazionati = OppCaricaHasAttoPeer::getRelazioni($carica_id, $legislatura, $data);
    $n_atti_relazionati = count($atti_relazionati);
    $atti_relazionati_node = $content_node->addChild('atti_relazionati', null, self::$opp_ns);
    $atti_relazionati_node->addAttribute('n_atti_relazionati', $n_atti_relazionati);

    $d_punteggio = 0;
    foreach ($atti_relazionati as $atto_hash) {
			// --- skip atti da non analizzare, se passato elenco atti in linea di comando
      if (!empty($atti_ids) && !in_array($atto_hash['id'], $atti_ids)) {
        continue;
      }
      $atto = OppAttoPeer::retrieveByPK($atto_hash['id']);
      $ultimo_atto_relazionato_in_navetta_da_me = $atto->getIsUltimoRelazionatoInNavettaDaCarica($carica_id);
      if ($ultimo_atto_relazionato_in_navetta_da_me)      
        $d_punteggio += self::calcolaIndiceAtto($carica_id, $atto_hash['id'], $atto_hash['tipo_atto_id'], $data, $atti_relazionati_node, $verbose, 'relazione');
    }

    $atti_relazionati_node->addAttribute('totale', $d_punteggio);
    if ($verbose)
      printf("totale atti relazionati: %d - punteggio: %7.2f\n", $n_atti_relazionati, $d_punteggio);
    $punteggio += $d_punteggio;
    
    
    // componente indice dovuta agli emendamenti
    // i conti sono dettagliati per tutti gli atti cui si riferiscono gli emendamenti (grouped by)
    $atti_for_emendamenti_ids = OppAttoHasEmendamentoPeer::getAttiIdsForEmendamentiCaricaData($carica_id, $data);
    $n_emendamenti = OppAttoHasEmendamentoPeer::countEmendamentiDaCaricaData($carica_id, $data);
    if (count($n_emendamenti) > 0)
      $emendamenti_node = $content_node->addChild('emendamenti', null, self::$opp_ns);

    $em_punteggio = 0;
    foreach ($atti_for_emendamenti_ids as $em_atto_id) {

      $em_atto = OppAttoPeer::retrieveByPK($em_atto_id);
      
      $em_atto_node = $emendamenti_node->addChild('atto', null, self::$opp_ns);
      $em_atto_node->addAttribute('id', $em_atto->getId());
      $em_atto_node->addAttribute('tipo_atto', OppTipoAttoPeer::getTipoPerIndice($em_atto->getTipoAttoId()));
      
      $em_punteggio += $d_punteggio = self::calcolaComponenteEmendamentiPerCaricaAtto($carica_id, $em_atto_id, $data, $em_atto_node, $verbose);
    }
    
    $emendamenti_node->addAttribute('numero_atti', count($atti_for_emendamenti_ids));
    $emendamenti_node->addAttribute('numero', $n_emendamenti);
    $emendamenti_node->addAttribute('totale', $em_punteggio);

    $punteggio += $em_punteggio;
    

    // --- componente dell'indice dovuta alla partecipazione (interventi + presenze ai voti)
    
    $partecipazione_node = $content_node->addChild('partecipazione', null, self::$opp_ns);
    $interventi_node = $partecipazione_node->addChild('interventi', null, self::$opp_ns);
    $punteggio += $d_interv_punteggio = self::calcolaPunteggioInterventi($carica_id, $data, $interventi_node, $verbose);
    $interventi_node->addAttribute('totale', $d_interv_punteggio);
    
    $d_pres_punteggio = 0.;
    $presenze_votazioni_node = $partecipazione_node->addChild('presenze', null, self::$opp_ns);
    
    $presenze_voti_node = $presenze_votazioni_node->addChild('voti', null, self::$opp_ns);
    $d_pres_punteggio += $dd_punteggio = self::calcolaPunteggioPresenzeVoti($carica_id, $data, $presenze_voti_node, $verbose);

    $presenze_finali_node = $presenze_votazioni_node->addChild('voti_finali', null, self::$opp_ns);
    $d_pres_punteggio += $dd_punteggio = self::calcolaPunteggioPresenzeVotiFinali($carica_id, $data, $presenze_finali_node, $verbose);

    $presenze_battuta_node = $presenze_votazioni_node->addChild('voti_maggioranza_battuta', null, self::$opp_ns);
    $d_pres_punteggio += $dd_punteggio = self::calcolaPunteggioPresenzeVotiMaggBattuta($carica_id, $data, $presenze_battuta_node, $verbose);
    
    $presenze_votazioni_node->addAttribute('totale', $d_pres_punteggio);
    
    $d_punteggio = $d_interv_punteggio + $d_pres_punteggio;
    $partecipazione_node->addAttribute('totale', $d_punteggio);

    $punteggio += $d_punteggio;
    $content_node->addAttribute('totale', $punteggio);

    $xml_storage_path = sfConfig::get('xml-storage-path', 
                                       SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'xml');
    $politici_path = $xml_storage_path.DIRECTORY_SEPARATOR.'indici'.DIRECTORY_SEPARATOR.'politici';
    $file_path = $politici_path.DIRECTORY_SEPARATOR."$carica_id.xml";


    // scrittura xml su file system
    try
    {
      if (!file_exists($file_path))
      {
        $created = self::getFilesystem()->mkdirs($politici_path);
        if (!$created)
          throw new Exception('Impossibile creare directory ' . $politici_path);
      }
      
      $fp = @fopen($file_path, "w");
      fputs($fp, $xml_node->asXML());
      if ($verbose)
        printf("    scrittura di: %s\n", $file_path);
    } catch (Exception $e) {
      printf("Errore durante la scrittura del file: %s.\n%s\n",  $file_path, $e->getMessage());
    }
  
    return $punteggio;
  }
 
 
 
 public static function calcolaVecchioIndiceAtto($carica_id, $atto_id, $tipo_atto_id, $data, $verbose = false)
 {
  # code...
 }
 
  /**
   * calcola l'indice per un atto, presentato da una carica 
   *
   * @param integer  $carica_id
   * @param integer  $atto_id
   * @param integer  $tipo_atto_id
   * @param string   $data
   * @param SimpleXMLElement    $xml_node   
   * @param boolean  $verbose
   * @param string   $mode presentazione || relazione
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcolaIndiceAtto($carica_id, $atto_id, $tipo_atto_id, $data, $xml_node, $verbose = false, $mode = 'presentazione')
  {
    $atto_node = $xml_node->addChild('atto', null, self::$opp_ns);
    
    $atto = OppAttoPeer::retrieveByPK($atto_id);
    $priorita = is_null($atto->getPriorityValue()) ? 1 : $atto->getPriorityValue();
    $atto_is_ratifica = $atto->isRatifica();
    
    // calcolo se appartiene alla maggioranza o all'opposizione (al momento della presentazione di un atto)
    $in_maggioranza = OppCaricaPeer::inMaggioranza($carica_id, $atto->getDataPres());
    
    // determina il tipo di atto (per quello che concerne il calcolo dell'indice)
    $tipo_atto = OppTipoAttoPeer::getTipoPerIndice($tipo_atto_id);
		
    // determina se l'atto è parte di un Testo Unificato
    $is_unified = OppAttoPeer::isUnifiedText($atto_id);
    
    // determina se l'atto è stato assorbito
    $is_absorbed = OppAttoPeer::isAbsorbed($atto_id);

    // determina se l'atto unificato è principale o meno
    $is_unificato_non_main = is_array($is_unified) && !$is_unified['is_main_unified'];
    $is_unificato_main = is_array($is_unified) && $is_unified['is_main_unified'];
    
    if (is_null($tipo_atto)) return 0;
    
    if ($verbose) {
      printf("  atto: %10s %15s\n", $atto_id, $tipo_atto);
      printf("    unificato a: %s\n", $is_unified?$is_unified:'-');
      printf("    assorbito da: %s\n", $is_absorbed?$is_absorbed:'-');	
		}
		
    $atto_node->addAttribute('tipo_atto', $tipo_atto);
    $atto_node->addAttribute('priorita', $priorita);
    $atto_node->addAttribute('id', $atto_id);    

    $punteggio = 0.0;
    
    if ($mode == 'presentazione') {

      // --- presentazione ---
      $d_punteggio = self::getPunteggio($tipo_atto, 'presentazione', $in_maggioranza);
      $punteggio += $d_punteggio;
      if ($verbose)
        printf("  presentazione %7.2f\n", $d_punteggio);
      $presentazione_node = $atto_node->addChild('presentazione', null, self::$opp_ns);
      $presentazione_node->addAttribute('totale', $d_punteggio);

      // --- consenso ---
      $firme_atto = OppCaricaHasAttoPeer::getFirme($atto_id, $data);  
      $n_firme = array ('gruppo' => 0, 'altri' => 0, 'opp' => 0, 'gov' => 0, 'mia' => 0);
      foreach ($firme_atto as $firma) {
        $relazione = OppCaricaPeer::getRelazioneCon($carica_id, $firma['carica_id'], $firma['data']);
        if (is_null($relazione)) continue;
        $n_firme[$relazione] += 1;
      }

      // TODO: aggiungere controllo se carica cambia nel tempo tra maggioranza e opposizione,
      //       in caso si decida di avere parametri del consenso differenti tra M e O
      //       ora sono uguali
      $consenso_node = $atto_node->addChild('consenso', null, self::$opp_ns);
      $consenso_node->addAttribute('n_firme', count($firme_atto));

      $d_punteggio = 0.0;
      foreach ($n_firme as $tipo => $value) {
        if (!$value) continue;

        $soglia = self::$soglia_cofirme;
        if ($tipo_atto == 'mozione') $soglia = self::$soglia_cofirme_mozioni;

        if ($value <= $soglia)
          $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, "cofirme_${tipo}_lo", $in_maggioranza);
        else
          $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, "cofirme_${tipo}_hi", $in_maggioranza);

        $firme_node = $consenso_node->addChild('firme_'.$tipo, null, self::$opp_ns);
        $firme_node->addAttribute('n_firme', $value);
        $firme_node->addAttribute('totale', $dd_punteggio);

        if ($verbose)
          printf("    firme %s (%d) %7.2f\n", $tipo, $value, $dd_punteggio);
      }
      $punteggio += $d_punteggio;
      if ($verbose)
        printf("  totale firme  %7.2f\n", $d_punteggio);

      $consenso_node->addAttribute('totale', $d_punteggio);
    }
      
    // --- iter ---
    $itinera_atto = OppAttoHasIterPeer::getItinera($atto_id, $data);
    $iter_node = $atto_node->addChild('iter', null, self::$opp_ns);
    $d_punteggio = 0.0;
    $n_passaggi = 0;

    // l'iter è calcolato sempre per i primi firmatari
    // per atti non assorbiti e non unificati o unificati principali, per i relatori
		/*
    if ($mode == 'presentazione' || 
        $mode == 'relazione' && is_null($is_absorbed) && (is_null($is_unified) || $is_unificato_main)) {
		*/
    if ($mode == 'presentazione' || 
        $mode == 'relazione' ) {

      // controlla se atti non assorbiti sono diventati legge dopo passaggi in altri rami
      // atti diventati legge non prendono il punteggio di approvazione
      $diventato_legge_in_altri_rami = false;
      $atto = OppAttoPeer::retrieveByPK($atto_id);
      $c = new Criteria();
      $c->add(OppAttoHasIterPeer::ITER_ID, 16);
      $c->add(OppAttoHasIterPeer::DATA, $data, Criteria::LESS_EQUAL);
      while ($atto_succ_id = $atto->getSucc())
      {
        $atto = OppAttoPeer::retrieveByPK($atto_succ_id);
        if ($atto->countOppAttoHasIters($c) > 0)
        {
          $diventato_legge_in_altri_rami = true;
        }
      }
      unset($c);
      unset($atto);
			if ($verbose)
				printf("    diventato legge in altri rami: %s\n", $diventato_legge_in_altri_rami?'y':'n');


      foreach ($itinera_atto as $iter_atto) {

        $passaggio = OppIterPeer::getIterPerIndice($iter_atto['iter_id']);

        // salta passaggi nulli
        if (is_null($passaggio)) continue;
        
        // simula assorbimenti per primi firmatari di atti di tipo Testo Unificato, non principali,
        if ($is_unificato_non_main && $passaggio == 'approvato') $passaggio = 'assorbito';

        // se diventato legge in altri rami, non prende punteggio di approvazione
        if ($diventato_legge_in_altri_rami && $passaggio == 'approvato') continue;
        
        
        $n_passaggi++;

        $passaggio_node = $iter_node->addChild('passaggio', null, self::$opp_ns);
        
        if ($passaggio == 'assorbito' && $is_unificato_non_main) {
          $passaggio_node->addAttribute('tipo', 'testo unificato non principale');
        } else {
          $passaggio_node->addAttribute('tipo', $passaggio);
        }

        $carica_in_maggioranza_al_passaggio = OppCaricaPeer::inMaggioranza($carica_id, $iter_atto['data']);
        $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, $passaggio, $carica_in_maggioranza_al_passaggio);
        if ($verbose)
          printf("    iter %s (%s %s) %7.2f\n", 
                 $passaggio, $iter_atto['data'], $carica_in_maggioranza_al_passaggio?'magg':'opp', $dd_punteggio);

        $passaggio_node->addAttribute('totale', $dd_punteggio);

        // il break su atti assorbiti avviene dopo l'assegnazione del punteggio
        if ($mode == 'presentazione' && $passaggio == 'assorbito')
        {
          break;
        }

        
        // --- bonus maggioranza ---
        if ($passaggio == 'approvato' || $passaggio == 'approvato_camera') {
          if ($carica_in_maggioranza_al_passaggio && OppAttoPeer::isAttoVotatoDaOpposizione($atto_id, $data)) {
            $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, 'bonus_bi_partisan', true);
            $bonus_node = $iter_node->addChild('bonus_maggioranza', null, self::$opp_ns);
            $bonus_node->addAttribute('totale', $dd_punteggio);
            if ($verbose)
              printf("    bonus di maggioranza! %7.2f\n", $dd_punteggio);          
          }
        }
        
        // break se mozione, risoluzione o odg approvato
        if (in_array($tipo_atto, array('mozione', 'risoluzione', 'odg')) && $passaggio == 'approvato') break;
        
      }


      // controlla se diventato legge dopo passaggi in altri rami (se non assorbito)
      // assegna punteggio se diventato legge in altri rami
      if ($diventato_legge_in_altri_rami && is_null($is_absorbed) && (is_null($is_unified) || $is_unificato_main)) {
        $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, 'diventato_legge', $in_maggioranza);

        $passaggio_node = $iter_node->addChild('passaggio', null, self::$opp_ns);
        $passaggio_node->addAttribute('tipo', "diventato legge in altri rami");
        $passaggio_node->addAttribute('totale', $dd_punteggio);

        if ($verbose)
          printf("    iter %s %7.2f\n", "diventato legge in altri rami", $dd_punteggio);
      }
      
      
    }
    
    if ($is_absorbed) {
      if ($verbose)
        printf("  atto assorbito da %d\n", $is_absorbed);
      $iter_node->addAttribute('assorbito_da', $is_absorbed);
    }

    if (is_array($is_unified) && $is_unificato_non_main) {
      if ($verbose)
        printf("  atto unificato (principale: %d)\n", $is_unified['atto_to_id']);
      $iter_node->addAttribute('unificato_in', $is_unified['atto_to_id']);
    }
    
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  totale iter   %7.2f\n", $d_punteggio);

    $iter_node->addAttribute('n_passaggi', $n_passaggi);
    $iter_node->addAttribute('totale', $d_punteggio);

    if ($atto_is_ratifica)
    {
      $atto_node->addAttribute('totale_pre_diminuzione_ratifica', $punteggio);
      if ($verbose)
        print "questo ATTO è una ratifica\n";
       
      $punteggio = $punteggio / self::$punteggi['fattore_diminuzione_ratifica'];
    }

    // $punteggio = $priorita * $punteggio;
    $atto_node->addAttribute('totale', $punteggio);

    if ($verbose)
      printf(" totale atto   %7.2f\n", $punteggio);

    unset($c);
    unset($atto);

    return $punteggio;
  }

  /**
   * calcola l'indice accumulato fino alla fine della settimana, per un emendamento, presentato da una carica 
   * DEPRECATO: i calcoli sono fatti nell'atto, per aggregazione, solo su presentazione e iter
   * @param integer  $carica_id
   * @param integer  $emendamento_id
   * @param string   $data
   * @param boolean  $verbose
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcolaIndiceEmendamento($carica_id, $emendamento_id, $data, $xml_node, $verbose = false)
  {
    // calcolo se appartiene alla maggioranza o all'opposizione
    $in_maggioranza = OppCaricaPeer::inMaggioranza($carica_id, $data);
    
    $punteggio = 0.0;

    $emendamento_node = null;
    $consenso_node = null;
    
    
    // --- consenso ---
    $firme_emendamento = OppCaricaHasEmendamentoPeer::getFirme($emendamento_id, $data);      
    $n_firme = array ('gruppo' => 0, 'altri' => 0, 'opp' => 0, 'mia' => 0);
    foreach ($firme_emendamento as $firma) {
      $relazione = OppCaricaPeer::getRelazioneCon($carica_id, $firma['carica_id'], $firma['data']);
      if (is_null($relazione)) continue;
      $n_firme[$relazione] += 1;
    }


    $d_punteggio = 0.0;
    foreach ($n_firme as $tipo => $value) {
      if (!$value) continue;

      if ($value <= self::$soglia_cofirme)
        $d_punteggio += $dd_punteggio = self::getPunteggio('emendamenti', "cofirme_${tipo}_lo", $in_maggioranza);
      else
        $d_punteggio += $dd_punteggio = self::getPunteggio('emendamenti', "cofirme_${tipo}_hi", $in_maggioranza);

      if ($dd_punteggio > 0)
      {
        if (is_null($emendamento_node))
        {
          if ($verbose)
            printf("emendamento: %10s\n", $emendamento_id);
          
          $emendamento_node = $xml_node->addChild('emendamento', null, self::$opp_ns);
          $emendamento_node->addAttribute('id', $emendamento_id);            
        }
        if (is_null($consenso_node))
        {
          $consenso_node = $emendamento_node->addChild('consenso', null, self::$opp_ns);
          $consenso_node->addAttribute('n_firme', count($firme_emendamento));        
        }

        $firme_node = $consenso_node->addChild('firme_'.$tipo, null, self::$opp_ns);
        $firme_node->addAttribute('n_firme', $value);
        $firme_node->addAttribute('totale', $dd_punteggio);

        if ($verbose)
          printf("    firme %s (%d) %7.2f\n", $tipo, $value, $dd_punteggio);
      }

    }

    $punteggio += $d_punteggio;

    if (!is_null($consenso_node))
    {
      $consenso_node->addAttribute('totale', $d_punteggio);

      if ($verbose)
        printf("  totale firme  %7.2f\n", $d_punteggio);
    }
      
    
    // --- iter ---
    $itinera_emendamento = OppEmendamentoHasIterPeer::getItinera($emendamento_id, $data);

    $d_punteggio = 0.0;
    $n_passaggi = 0;
    foreach ($itinera_emendamento as $iter_emendamento) {
      $passaggio = OppEmIterPeer::getIterPerIndice($iter_emendamento['em_iter_id']);
      if (is_null($passaggio)) continue;

      $n_passaggi++;
      
      $d_punteggio += $dd_punteggio = self::getPunteggio('emendamenti', 
                   $passaggio, OppCaricaPeer::inMaggioranza($carica_id, $iter_emendamento['data']));

      if ($dd_punteggio > 0)
      {
        if (is_null($iter_node))
        {
          $iter_node = $emendamento_node->addChild('iter', null, self::$opp_ns);          
        }
        
        if (is_null($passaggio_node))
        {
          $passaggio_node = $iter_node->addChild('passaggio', null, self::$opp_ns);
          $passaggio_node->addAttribute('tipo', $passaggio);
        }
        $passaggio_node->addAttribute('totale', $dd_punteggio);

        if ($verbose)
          printf("    iter %s %7.2f\n", $passaggio, $dd_punteggio);
      }

    }


    $punteggio += $d_punteggio;
    
    if (!is_null($emendamento_node))
    {
      $emendamento_node->addAttribute('totale', $punteggio);    
      if ($verbose)
        printf("  totale iter   %7.2f\n", $d_punteggio);      
    }
    
    return $punteggio;
  }
  

  /**
   * torna la componente dell'indice, che riguarda il parlamentare
   *
   * @param integer $carica_id 
   * @param string $data 
   * @param SimpleXMLElement $xml_node
   * @param string $verbose 
   * @return float
   * @author Guglielmo Celata
   */
  public function calcolaPunteggioInterventi($carica_id, $data, $xml_node, $verbose = false)
  {
    // --- interventi ---
    $n_interventi = OppInterventoPeer::getNSeduteConInterventiCaricaData($carica_id, $data);      
    
    $xml_node->addAttribute('n_sedute_con_intervento', $n_interventi);
    
    $d_punteggio = $n_interventi * self::$punteggi['intervento'];
    if ($verbose)
      printf("interventi   %7.2f\n", $d_punteggio);

    return $d_punteggio;
  }

  public function calcolaPunteggioPresenzeVoti($carica_id, $data, $xml_node, $verbose = false)
  {
    // --- calcolo presenza ai voti ---
    $n_presenze = OppVotazioneHasCaricaPeer::countPresenzeVoti($carica_id, $data);      
    
    $xml_node->addAttribute('presenze', $n_presenze);
    
    $d_punteggio = $n_presenze * self::$punteggi['presenze_voti'];
    if ($verbose)
      printf("presenze ai voti   %7.2f\n", $d_punteggio);

    $xml_node->addAttribute('totale', $d_punteggio);

    return $d_punteggio;
  }

  public function calcolaPunteggioPresenzeVotiFinali($carica_id, $data, $xml_node, $verbose = false)
  {
    // --- calcolo presenza ai voti finali ---
    $n_presenze = OppVotazioneHasCaricaPeer::countPresenzeVotiFinali($carica_id, $data);      
    
    $xml_node->addAttribute('presenze', $n_presenze);
    
    $d_punteggio = $n_presenze * self::$punteggi['presenze_voti_finali'];
    if ($verbose)
      printf("presenze ai voti finali   %7.2f\n", $d_punteggio);

    $xml_node->addAttribute('totale', $d_punteggio);

    return $d_punteggio;
  }
  
  public function calcolaPunteggioPresenzeVotiMaggBattuta($carica_id, $data, $xml_node, $verbose = false)
  {
    // --- calcolo presenza ai voti con maggioranza battuta ---
    // -- il gruppo 19 (PDL) identifica il comportamento della maggioranza in modo univoco
    // -- al cambio della legislatura questo criterio potrebbe non andar più bene
    $n_presenze = OppVotazioneHasCaricaPeer::countPresenzeVotiMaggBattuta($carica_id, $data, 19);      
    
    $xml_node->addAttribute('presenze', $n_presenze);
    
    $d_punteggio = $n_presenze * self::$punteggi['presenze_voti_magg_battuta'];
    if ($verbose)
      printf("presenze ai voti con maggioranza battuta  %7.2f\n", $d_punteggio);

    $xml_node->addAttribute('totale', $d_punteggio);

    return $d_punteggio;
  }


  /**
   * torna la componente dell'indice dovuta agli emendamenti presentati dalla carica, 
   * in relazione a un atto, entro una certa data
   *
   * @param string $carica_id 
   * @param string $atto_id 
   * @param string $data 
   * @param string $em_atto_node 
   * @param string $verbose 
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcolaComponenteEmendamentiPerCaricaAtto($carica_id, $atto_id, $data, $atto_node, $verbose = false)
  {
    // presentazione emendamenti legati all'atto
    $n_emendamenti = OppAttoHasEmendamentoPeer::countEmendamentiAttoDaCaricaData($carica_id, $atto_id, $data);
    $larghezza = self::$punteggi['emendamenti_larghezza']; 
    $soglia = self::$punteggi['emendamenti_soglia'];

    // calcolo valore emendamenti presentati per atto, con soglia discendente
    // 1 + tanh(0.01*(s-x))
    // integrale indefinito è x - 100 * log(cosh(0.01*s - 0.01*x)) (Wolfram Alpha)
    // in questo modo, fino a 40 emendamenti il peso è uniforme, poi scende, fino a 400, quando
    // gli emendamenti in più non pesano niente
    // descritto in: http://trac.openpolis.it/openparlamento/wiki/NuovoIndice
    $d_punteggio = 0;
    $punteggio_em_presentati = 0;
    if ($n_emendamenti > 0 and $n_emendamenti <= $soglia)
      $punteggio_em_presentati = self::getPunteggio('emendamenti', "presentazione", 'm') * $n_emendamenti;
    else
    {
      if ($n_emendamenti > 0)
        $punteggio_em_presentati =  self::getPunteggio('emendamenti', "presentazione", 'm') * ($n_emendamenti - $larghezza * log(cosh(1./$larghezza * ($soglia - $n_emendamenti))));
    }

    if ($punteggio_em_presentati > 0)
    {
      $punteggio_em_presentati = round($punteggio_em_presentati, 2);

      if ($verbose)
        printf("    presentazione %d emendamenti %7.2f\n", $n_emendamenti, $punteggio_em_presentati);

      $d_punteggio += $punteggio_em_presentati;
    }

    // calcolo componente dovuta a emendamenti legati all'atto che per lo meno siano stati votati
    $n_emendamenti_votati = OppAttoHasEmendamentoPeer::countEmendamentiFaseAttoCaricaData(array(1,2), $carica_id, $atto_id, $data);
    $n_emendamenti_approvati = OppAttoHasEmendamentoPeer::countEmendamentiFaseAttoCaricaData(array(1), $carica_id, $atto_id, $data);

    if ($n_emendamenti_votati + $n_emendamenti_approvati > 0)
    {
      $d_punteggio += $punteggio_em_votati = $n_emendamenti_votati * self::getPunteggio('emendamenti', 'votato', 'm');
      $d_punteggio += $punteggio_em_approvati = $n_emendamenti_approvati * self::getPunteggio('emendamenti', 'approvato', 'm');

      if ($verbose)
      {
        printf("    votazione %d emendamenti %7.2f\n", $n_emendamenti_votati, $punteggio_em_votati);
        printf("    approvazione %d emendamenti %7.2f\n", $n_emendamenti_approvati, $punteggio_em_approvati);        
      }

    }


    if ($d_punteggio  > 0)
    {
      if ($verbose)
        printf("  totale emendamenti   %7.2f\n", $d_punteggio);
        
      $emendamenti_atto_node = $atto_node->addChild('emendamenti', null, self::$opp_ns);
      $emendamenti_atto_node->addAttribute('totale', $d_punteggio);
      $emendamenti_atto_node->addAttribute('numero', $n_emendamenti);

      $em_presentati_node = $emendamenti_atto_node->addChild('presentati', null, self::$opp_ns);
      $em_presentati_node->addAttribute('numero', $n_emendamenti);
      $em_presentati_node->addAttribute('totale', $punteggio_em_presentati);

      if ($n_emendamenti_votati > 0)
      {
        $em_votati_node = $emendamenti_atto_node->addChild('votati', null, self::$opp_ns);
        $em_votati_node->addAttribute('numero', $n_emendamenti_votati);
        $em_votati_node->addAttribute('totale', $punteggio_em_votati);        
      }

      if ($n_emendamenti_approvati > 0)
      {
        $em_approvati_node = $emendamenti_atto_node->addChild('approvati', null, self::$opp_ns);
        $em_approvati_node->addAttribute('numero', $n_emendamenti_approvati);
        $em_approvati_node->addAttribute('totale', $punteggio_em_approvati);        
      }

    }
    
    return $d_punteggio;
    
  }
  
}
