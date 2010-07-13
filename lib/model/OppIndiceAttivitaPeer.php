<?php

/**
 * Classe che mantiene i parametri dell'indice di attività
 *
 * @package lib.model
 */ 
class OppIndiceAttivitaPeer extends OppIndicePeer
{

  public static $soglia_cofirme = 10;

  public static $opp_ns = 'http://www.openpolis.it/2010/opp';
  public static $op_ns = 'http://www.openpolis.it/2010/op';
  public static $xlink_ns = 'http://www.w3.org/1999/xlink';
  
  public static $filesystem;
  
  public static $punteggi = array(
     'ddl'           => array('presentazione'       => array('m' =>  0.08, 'o' =>   0.08),
                              'cofirme_gruppo_lo'   => array('m' =>  0.8,  'o' =>   0.8),
                              'cofirme_gruppo_hi'   => array('m' =>  0.8,  'o' =>   0.8),
                              'cofirme_altri_lo'    => array('m' =>  1.0,  'o' =>   1.0),
                              'cofirme_altri_hi'    => array('m' =>  1.0,  'o' =>   1.0),
                              'cofirme_opp_lo'      => array('m' =>  1.5,  'o' =>   1.5),
                              'cofirme_opp_hi'      => array('m' =>  1.5,  'o' =>   1.5),
                              'cofirme_gov_lo'      => array('m' =>  0.0,  'o' =>   0.0),
                              'cofirme_gov_hi'      => array('m' =>  0.0,  'o' =>   0.0),
                              'discusso_in_comm'    => array('m' =>  5.0,  'o' =>  15.0),
                              'discusso_in_ass'     => array('m' => 10.0,  'o' =>  30.0),
                              'votato'              => array('m' =>  0.0,  'o' =>   0.0),
                              'approvato'           => array('m' =>  0.0,  'o' =>   0.0),
                              'approvato_camera'    => array('m' => 20.0,  'o' =>  60.0),
                              'diventato_legge'     => array('m' => 50.0,  'o' => 150.0),
                              'bonus_bi_partisan'   => array('m' => 20.0,  'o' =>     0),
                             ),
      'mozione'      => array('presentazione'       => array('m' =>  0.06, 'o' =>   0.06),
                              'cofirme_gruppo_lo'   => array('m' =>  0.6,  'o' =>   0.6),
                              'cofirme_gruppo_hi'   => array('m' =>  0.6,  'o' =>   0.6),
                              'cofirme_altri_lo'    => array('m' =>  0.8,  'o' =>   0.8),
                              'cofirme_altri_hi'    => array('m' =>  0.8,  'o' =>   0.8),
                              'cofirme_opp_lo'      => array('m' =>  1.0,  'o' =>   1.0),
                              'cofirme_opp_hi'      => array('m' =>  1.0,  'o' =>   1.0),
                              'discusso_in_comm'    => array('m' =>  0.0,  'o' =>   0.0),
                              'discusso_in_ass'     => array('m' =>  0.0,  'o' =>   0.0),
                              'votato'              => array('m' =>  1.0,  'o' =>   3.0),
                              'approvato'           => array('m' =>  2.0,  'o' =>   6.0),
                              'approvato_camera'    => array('m' =>  0.0,  'o' =>   0.0),
                              'diventato_legge'     => array('m' =>  0.0,  'o' =>   0.0),
                              'bonus_bi_partisan'   => array('m' =>  1.0,  'o' =>   0.0),
                             ),
      'risoluzione'  => array('presentazione'       => array('m' =>  0.06, 'o' =>   0.06),
                              'cofirme_gruppo_lo'   => array('m' =>  1.0,  'o' =>   1.0),
                              'cofirme_gruppo_hi'   => array('m' =>  1.0,  'o' =>   1.0),
                              'cofirme_altri_lo'    => array('m' =>  1.5,  'o' =>   1.5),
                              'cofirme_altri_hi'    => array('m' =>  1.5,  'o' =>   1.5),
                              'cofirme_opp_lo'      => array('m' =>  2.0,  'o' =>   2.0),
                              'cofirme_opp_hi'      => array('m' =>  2.0,  'o' =>   2.0),
                              'discusso_in_comm'    => array('m' =>  0.0,  'o' =>   0.0),
                              'discusso_in_ass'     => array('m' =>  0.0,  'o' =>   0.0),
                              'votato'              => array('m' =>  1.0,  'o' =>   3.0),
                              'approvato'           => array('m' =>  2.0,  'o' =>   6.0),
                              'approvato_camera'    => array('m' =>  0.0,  'o' =>   0.0),
                              'diventato_legge'     => array('m' =>  0.0,  'o' =>   0.0),
                              'bonus_bi_partisan'   => array('m' =>  1.0,  'o' =>   0.0),
                             ),
      'odg'          => array('presentazione'       => array('m' =>  0.04, 'o' =>   0.04),
                              'cofirme_gruppo_lo'   => array('m' =>  0.5,  'o' =>   0.5),
                              'cofirme_gruppo_hi'   => array('m' =>  1.0,  'o' =>   1.0),
                              'cofirme_altri_lo'    => array('m' =>  0.5,  'o' =>   0.5),
                              'cofirme_altri_hi'    => array('m' =>  1.0,  'o' =>   1.0),
                              'cofirme_opp_lo'      => array('m' =>  1.5,  'o' =>   1.5),
                              'cofirme_opp_hi'      => array('m' =>  1.5,  'o' =>   1.5),
                              'discusso_in_comm'    => array('m' =>  0.0,  'o' =>   0.0),
                              'discusso_in_ass'     => array('m' =>  0.0,  'o' =>   0.0),
                              'votato'              => array('m' =>  0.5,  'o' =>   1.5),
                              'approvato'           => array('m' =>  1.0,  'o' =>   3.0),
                              'approvato_camera'    => array('m' =>  0.0,  'o' =>   0.0),
                              'diventato_legge'     => array('m' =>  0.0,  'o' =>   0.0),
                              'bonus_bi_partisan'   => array('m' =>  0.5,  'o' =>   0.0),
                             ),
     'interrogazione'=> array('presentazione'       => array('m' => 0.05, 'o' =>  0.05),
                              'cofirme_gruppo_lo'   => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_gruppo_hi'   => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_altri_lo'    => array('m' => 1.5, 'o' =>  1.5),
                              'cofirme_altri_hi'    => array('m' => 1.5, 'o' =>  1.5),
                              'cofirme_opp_lo'      => array('m' => 1.5, 'o' =>  1.5),
                              'cofirme_opp_hi'      => array('m' => 2.5, 'o' =>  1.5),
                              'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                              'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                              'votato'              => array('m' =>   0, 'o' =>    0),
                              'approvato'           => array('m' =>   0, 'o' =>    0),
                              'approvato_camera'    => array('m' =>   0, 'o' =>    0),
                              'diventato_legge'     => array('m' => 1.0, 'o' =>  1.0),
                              'bonus_bi_partisan'   => array('m' =>   0, 'o' =>    0),
                             ),
    'interpellanza'  => array('presentazione'       => array('m' => 0.05, 'o' =>  0.05),
                              'cofirme_gruppo_lo'   => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_gruppo_hi'   => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_altri_lo'    => array('m' => 0.8, 'o' =>  0.8),
                              'cofirme_altri_hi'    => array('m' => 0.8, 'o' =>  0.8),
                              'cofirme_opp_lo'      => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_hi'      => array('m' => 1.0, 'o' =>  1.0),
                              'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                              'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                              'votato'              => array('m' =>   0, 'o' =>    0),
                              'approvato'           => array('m' =>   0, 'o' =>    0),
                              'approvato_camera'    => array('m' =>   0, 'o' =>    0),
                              'diventato_legge'     => array('m' => 1.0, 'o' =>  1.0),
                              'bonus_bi_partisan'   => array('m' =>   0, 'o' =>    0),
                             ),

     'emendamenti'    => array('presentazione'       => array('m' => 0.05, 'o' => 0.05),
                               'cofirme_gruppo_lo'   => array('m' => 0.5, 'o' =>  0.2),
                               'cofirme_gruppo_hi'   => array('m' => 0.5, 'o' =>  0.2),
                               'cofirme_altri_lo'    => array('m' => 0.8, 'o' =>  0.8),
                               'cofirme_altri_hi'    => array('m' => 0.8, 'o' =>  0.8),
                               'cofirme_opp_lo'      => array('m' => 1.5, 'o' =>  2.0),
                               'cofirme_opp_hi'      => array('m' => 1.5, 'o' =>  2.0),
                               'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                               'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                               'votato'              => array('m' => 1.0, 'o' =>  3.0),
                               'approvato'           => array('m' => 2.0, 'o' =>  6.0),
                               'approvato_camera'    => array('m' =>   0, 'o' =>    0),
                               'diventato_legge'     => array('m' =>   0, 'o' =>    0),
                               'bonus_bi_partisan'   => array('m' => 1.0, 'o' =>    0),
                              ),
     'intervento'                 => 0.4,
     'presenze_voti'              => 0.001,
     'presenze_voti_finali'       => 0.1,
     'presenze_voti_magg_battuta' => 0.3,
     'relatore'                   => 5.0,
     'emendamenti_soglia'         => 40,
     'emendamenti_larghezza'      => 100.
  );
  
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
    if (!array_key_exists($tipo_azione, self::$punteggi[$tipo_atto])) {
      return 0.0;
    }
    return self::$punteggi[$tipo_atto][$tipo_azione][$maggioranza?'m':'o'];
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
  
    // estrae atti ed emendamenti firmati come Primo Firmatario, fino alla data specificata
    if (count($atti_ids) == 0)
      $attis = OppCaricaPeer::getPresentedAttosIdsAndTiposByCaricaData($carica_id, $legislatura, $data);
    else
    {
      $attis = array();
      foreach ($atti_ids as $atto_id) {
        $atto  = OppAttoPeer::retrieveByPK($atto_id);
        $attis []= array('id' => $atto->getId(), 'tipo_atto_id' => $atto->getTipoAttoId());
        unset($atto);
      }
    }
      
    if (count($emendamenti_ids) == 0)
      $emendamenti_ids = OppCaricaPeer::getPresentedEmendamentosIdsByCaricaData($carica_id, $legislatura, $data);

    $punteggio = 0.;
  
    // --- componente dell'indice dovuta agli atti ---
    $atti_node = $content_node->addChild('atti', null, self::$opp_ns);
    $atti_node->addAttribute('n_atti', 
                             count($attis));
    
    if ($verbose)
      printf("\n  numero atti: %d\n", count($attis));
    $d_punteggio = 0.;
    foreach ($attis as $atto) {
      $d_punteggio += self::calcolaIndiceAtto($carica_id, $atto['id'], $atto['tipo_atto_id'], $data, $atti_node, $verbose);
    }
    $atti_node->addAttribute('totale', $d_punteggio);
    $punteggio += $d_punteggio;

    // --- componente indice dovuta alle firme come relatore
    $n_relazioni = OppCaricaHasAttoPeer::countRelazioni($carica_id, $legislatura, $data);
    if ($n_relazioni > 0)
    {
      $punteggio += $d_punteggio = self::$punteggi['relatore'] * $n_relazioni;
      if ($verbose)
      {
        printf("\n  numero relazioni: %d - punteggio: %7.2f\n", $n_relazioni, $d_punteggio);
        
      }
      $relazioni_node = $content_node->addChild('relazioni', null, self::$opp_ns);
      $relazioni_node->addAttribute('n_relazioni', $n_relazioni);
      $relazioni_node->addAttribute('totale', $d_punteggio);
    }
    

    // --- componente dell'indice dovuta agli emendamenti ---
    $emendamenti_node = $content_node->addChild('emendamenti', null, self::$opp_ns);
    $emendamenti_node->addAttribute('n_emendamenti', 
                                    count($emendamenti_ids));
    if ($verbose)
      printf("\n  numero emendamenti: %d\n", count($emendamenti_ids));
    $d_punteggio = 0.;
    foreach ($emendamenti_ids as $emendamento_id) {
      
      $d_punteggio += self::calcolaIndiceEmendamento($carica_id, $emendamento_id, $data, $emendamenti_node, $verbose);
    }
    $emendamenti_node->addAttribute('totale', $d_punteggio);
    $punteggio += $d_punteggio;
    


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
   * calcola l'indice accumulato fino alla fine della settimana, per un atto, presentato da una carica 
   *
   * @param integer  $carica_id
   * @param integer  $atto_id
   * @param integer  $tipo_atto_id
   * @param string   $data
   * @param SimpleXMLElement    $xml_node   
   * @param boolean   $verbose
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcolaIndiceAtto($carica_id, $atto_id, $tipo_atto_id, $data, $xml_node, $verbose = false)
  {
    $atto_node = $xml_node->addChild('atto', null, self::$opp_ns);
    
    $atto = OppAttoPeer::retrieveByPK($atto_id);
    // calcolo se appartiene alla maggioranza o all'opposizione (al momento della presentazione di un atto)
    $in_maggioranza = OppCaricaPeer::inMaggioranza($carica_id, $atto->getDataPres());
    
    // determina il tipo di atto (per quello che concerne il calcolo dell'indice)
    $tipo_atto = OppTipoAttoPeer::getTipoPerIndice($tipo_atto_id);
    
    if (is_null($tipo_atto)) return 0;
    
    if ($verbose)
      printf("atto: %10s %15s\n", $atto_id, $tipo_atto);

    $atto_node->addAttribute('tipo_atto', $tipo_atto);
    $atto_node->addAttribute('id', $atto_id);    

    $punteggio = 0.0;
    
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
      
      if ($value <= self::$soglia_cofirme)
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
      
    
    // --- iter ---
    $itinera_atto = OppAttoHasIterPeer::getItinera($atto_id, $data);
    $iter_node = $atto_node->addChild('iter', null, self::$opp_ns);
    
    $d_punteggio = 0.0;
    $n_passaggi = 0;
    foreach ($itinera_atto as $iter_atto) {
      $passaggio = OppIterPeer::getIterPerIndice($iter_atto['iter_id']);
      if (is_null($passaggio)) continue;

      $n_passaggi++;
      
      $passaggio_node = $iter_node->addChild('passaggio', null, self::$opp_ns);
      $passaggio_node->addAttribute('tipo', $passaggio);

      $carica_in_maggioranza_al_passaggio = OppCaricaPeer::inMaggioranza($carica_id, $iter_atto['data']);
      if (is_null($passaggio)) continue;
      $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, $passaggio, $carica_in_maggioranza_al_passaggio);
      if ($verbose)
        printf("    iter %s %7.2f\n", $passaggio, $dd_punteggio);
      
      $passaggio_node->addAttribute('totale', $dd_punteggio);
        
      // --- bonus maggioranza (TODO: la data?) ---
      if ($passaggio == 'approvato' || $passaggio == 'approvato_camera') {
        if ($carica_in_maggioranza_al_passaggio && OppAttoPeer::isAttoVotatoDaOpposizione($atto_id, $data)) {
          $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, 'bonus_bi_partisan', true);
          $bonus_node = $iter_node->addChild('bonus_maggioranza', null, self::$opp_ns);
          $bonus_node->addAttribute('totale', $dd_punteggio);
          if ($verbose)
            printf("    bonus di maggioranza! %7.2f\n", $dd_punteggio);          
        }
      }
    }
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  totale iter   %7.2f\n", $d_punteggio);

    $iter_node->addAttribute('n_passaggi', $n_passaggi);
    $iter_node->addAttribute('totale', $d_punteggio);


    // presentazione n. emendamenti presentati legati all'atto
    $n_emendamenti = OppAttoHasEmendamentoPeer::countEmendamentiAttoDaCaricaData($carica_id, $atto_id, $data);
    $larghezza = self::$punteggi['emendamenti_larghezza']; 
    $soglia = self::$punteggi['emendamenti_soglia']; ;
    
    // calcolo valore emendamenti presentati per atto, con soglia discendente
    // 1 + tanh(0.01*(s-x))
    // integrale indefinito è x - 100 * log(cosh(0.01*s - 0.01*x)) (Wolfram Alpha)
    // in questo modo, fino a 40 emendamenti il peso è uniforme, poi scende, fino a 400, quando
    // gli emendamenti in più non pesano niente
    // descritto in: http://trac.openpolis.it/openparlamento/wiki/NuovoIndice
    $d_punteggio = 0;
    if ($n_emendamenti > 0 and $n_emendamenti <= $soglia)
      $d_punteggio = self::getPunteggio('emendamenti', "presentazione", 'm') * $n_emendamenti;
    else
    {
      if ($n_emendamenti > 0)
        $d_punteggio =  self::getPunteggio('emendamenti', "presentazione", 'm') * ($n_emendamenti - $larghezza * log(cosh(1./$larghezza * ($soglia - $n_emendamenti))));
    }
    
    $d_punteggio = round($d_punteggio, 2);
    
    if ($d_punteggio > 0)
    {
      if ($verbose)
        printf("  totale emendamenti   %7.2f\n", $d_punteggio);
      $emendamenti_atto_node = $atto_node->addChild('emendamenti', null, self::$opp_ns);
      $emendamenti_atto_node->addAttribute('n_emendamenti', $n_emendamenti);
      $emendamenti_atto_node->addAttribute('totale', $d_punteggio);
    }
    

    $punteggio += $d_punteggio;

    $atto_node->addAttribute('totale', $punteggio);

    return $punteggio;
  }

  /**
   * calcola l'indice accumulato fino alla fine della settimana, per un emendamento, presentato da una carica 
   *
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
      printf("  interventi   %7.2f\n", $d_punteggio);

    return $d_punteggio;
  }

  public function calcolaPunteggioPresenzeVoti($carica_id, $data, $xml_node, $verbose = false)
  {
    // --- calcolo presenza ai voti ---
    $n_presenze = OppVotazioneHasCaricaPeer::countPresenzeVoti($carica_id, $data);      
    
    $xml_node->addAttribute('presenze', $n_presenze);
    
    $d_punteggio = $n_presenze * self::$punteggi['presenze_voti'];
    if ($verbose)
      printf("  presenze ai voti   %7.2f\n", $d_punteggio);

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
      printf("  presenze ai voti finali   %7.2f\n", $d_punteggio);

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
      printf("  presenze ai voti con maggioranza battuta  %7.2f\n", $d_punteggio);

    $xml_node->addAttribute('totale', $d_punteggio);

    return $d_punteggio;
  }

  
}
