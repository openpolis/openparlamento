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
     'ddl'           => array('presentazione'       => array('m' => 6.0, 'o' =>  6.0),
                              'cofirme_gruppo_lo'   => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_gruppo_hi'   => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_altri_lo'    => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_altri_hi'    => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_lo'      => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_hi'      => array('m' => 2.0, 'o' =>  2.0),
                              'cofirme_gov_lo'      => array('m' => 0.0, 'o' =>  0.0),
                              'cofirme_gov_hi'      => array('m' => 0.0, 'o' =>  0.0),
                              'discusso_in_comm'    => array('m' => 1.0, 'o' =>  3.0),
                              'discusso_in_ass'     => array('m' => 1.5, 'o' =>  4.5),
                              'votato'              => array('m' =>   0, 'o' =>    0),
                              'approvato'           => array('m' =>   0, 'o' =>    0),
                              'approvato_camera'    => array('m' => 4.0, 'o' => 12.0),
                              'diventato_legge'     => array('m' => 8.0, 'o' => 24.0),
                              'bonus_bi_partisan'   => array('m' => 4.0, 'o' =>    0),
                             ),
      'mozione'      => array('presentazione'       => array('m' => 3.0, 'o' =>  3.0),
                              'cofirme_gruppo_lo'   => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_gruppo_hi'   => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_altri_lo'    => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_altri_hi'    => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_lo'      => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_hi'      => array('m' => 2.0, 'o' =>  2.0),
                              'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                              'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                              'votato'              => array('m' => 1.5, 'o' =>  3.0),
                              'approvato'           => array('m' => 3.0, 'o' =>  6.0),
                              'approvato_camera'    => array('m' =>   0, 'o' =>    0),
                              'diventato_legge'     => array('m' =>   0, 'o' =>    0),
                              'bonus_bi_partisan'   => array('m' => 1.5, 'o' =>    0),
                             ),
      'risoluzione'  => array('presentazione'       => array('m' => 2.0, 'o' =>  2.0),
                              'cofirme_gruppo_lo'   => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_gruppo_hi'   => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_altri_lo'    => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_altri_hi'    => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_lo'      => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_hi'      => array('m' => 2.0, 'o' =>  2.0),
                              'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                              'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                              'votato'              => array('m' => 1.0, 'o' =>  2.0),
                              'approvato'           => array('m' => 2.0, 'o' =>  4.0),
                              'approvato_camera'    => array('m' =>   0, 'o' =>    0),
                              'diventato_legge'     => array('m' =>   0, 'o' =>    0),
                              'bonus_bi_partisan'   => array('m' => 1.0, 'o' =>    0),
                             ),
     'odg'          =>  array('presentazione'       => array('m' => 3.0, 'o' =>  3.0),
                              'cofirme_gruppo_lo'   => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_gruppo_hi'   => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_altri_lo'    => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_altri_hi'    => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_lo'      => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_hi'      => array('m' => 2.0, 'o' =>  2.0),
                              'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                              'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                              'votato'              => array('m' => 1.0, 'o' =>  2.0),
                              'approvato'           => array('m' => 2.0, 'o' =>  4.0),
                              'approvato_camera'    => array('m' =>   0, 'o' =>    0),
                              'diventato_legge'     => array('m' =>   0, 'o' =>    0),
                              'bonus_bi_partisan'   => array('m' => 1.0, 'o' =>    0),
                             ),
     'interrogazione'=> array('presentazione'       => array('m' => 3.0, 'o' =>  3.0),
                              'cofirme_gruppo_lo'   => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_gruppo_hi'   => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_altri_lo'    => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_altri_hi'    => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_lo'      => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_hi'      => array('m' => 2.0, 'o' =>  2.0),
                              'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                              'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                              'votato'              => array('m' =>   0, 'o' =>    0),
                              'approvato'           => array('m' =>   0, 'o' =>    0),
                              'approvato_camera'    => array('m' =>   0, 'o' =>    0),
                              'diventato_legge'     => array('m' =>   0, 'o' =>    0),
                              'bonus_bi_partisan'   => array('m' =>   0, 'o' =>    0),
                             ),
    'interpellanza'  => array('presentazione'       => array('m' => 3.0, 'o' =>  3.0),
                              'cofirme_gruppo_lo'   => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_gruppo_hi'   => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_altri_lo'    => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_altri_hi'    => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_lo'      => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_hi'      => array('m' => 2.0, 'o' =>  2.0),
                              'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                              'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                              'votato'              => array('m' =>   0, 'o' =>    0),
                              'approvato'           => array('m' =>   0, 'o' =>    0),
                              'approvato_camera'    => array('m' =>   0, 'o' =>    0),
                              'diventato_legge'     => array('m' =>   0, 'o' =>    0),
                              'bonus_bi_partisan'   => array('m' =>   0, 'o' =>    0),
                             ),

     'emendamenti'    => array('presentazione'       => array('m' =>   0, 'o' =>    0),
                               'cofirme_gruppo_lo'   => array('m' => 0.2, 'o' =>  0.2),
                               'cofirme_gruppo_hi'   => array('m' => 0.4, 'o' =>  0.4),
                               'cofirme_altri_lo'    => array('m' => 0.4, 'o' =>  0.4),
                               'cofirme_altri_hi'    => array('m' => 0.8, 'o' =>  0.8),
                               'cofirme_opp_lo'      => array('m' => 1.0, 'o' =>  1.0),
                               'cofirme_opp_hi'      => array('m' => 2.0, 'o' =>  2.0),
                               'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                               'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                               'votato'              => array('m' => 0.5, 'o' =>  1.5),
                               'approvato'           => array('m' => 2.0, 'o' =>  6.0),
                               'approvato_camera'    => array('m' =>   0, 'o' =>    0),
                               'diventato_legge'     => array('m' =>   0, 'o' =>    0),
                               'bonus_bi_partisan'   => array('m' => 1.0, 'o' =>    0),
                              ),
     'intervento'     => 0.5
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
  public static function calcola_indice_politico($carica_id, $data = '', $verbose = '')
  {
    if ($data == '') throw new Exception("Date can not be null");
    
    // inizializzazion xml con dettaglio computazione
    $xml_node = new SimpleXMLElement(
      '<opp xmlns="'.self::$opp_ns.'" '.
            ' xmlns:op="'.self::$op_ns.'" '.
            ' xmlns:xlink="'.self::$xlink_ns.'" >'.
      '</opp>');
      
    self::addProcessingInstruction($xml_node, 'xml-stylesheet', 'type="text/xsl" href="../xslt/politici.xslt"');
    $content_node = $xml_node->addChild('op:content', null, self::$op_ns);             
  
    // estrae atti ed emendamenti firmati come Primo Firmatario, fino alla data specificata
    $attis = OppCaricaPeer::getPresentedAttosIdsAndTiposByCaricaData($carica_id, $data);
    $emendamenti_ids = OppCaricaPeer::getPresentedEmendamentosIdsByCaricaData($carica_id, $data);

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
    
    // --- componente dell'indice dovuta agli interventi (in sedute)
    $interventi_node = $content_node->addChild('interventi', null, self::$opp_ns);
    $punteggio += $d_punteggio = self::calcolaPunteggioInterventi($carica_id, $data, $interventi_node, $verbose);
    $interventi_node->addAttribute('totale', $d_punteggio);


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
    
    // calcolo se appartiene alla maggioranza o all'opposizione (al momento della presentazione di un atto)
    $in_maggioranza = OppCaricaPeer::inMaggioranza($carica_id, $data_pres);
    
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
    $emendamento_node = $xml_node->addChild('emendamento', null, self::$opp_ns);
    $emendamento_node->addAttribute('id', $emendamento_id);    
    
    // calcolo se appartiene alla maggioranza o all'opposizione
    $in_maggioranza = OppCaricaPeer::inMaggioranza($carica_id, $data);
    
    if ($verbose)
      printf("emendamento: %10s\n", $emendamento_id);

    $punteggio = 0.0;
    
    // --- presentazione ---
    $d_punteggio = self::getPunteggio('emendamenti', 'presentazione', $in_maggioranza);
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  presentazione %7.2f\n", $d_punteggio);
    $presentazione_node = $emendamento_node->addChild('presentazione', null, self::$opp_ns);
    $presentazione_node->addAttribute('totale', $d_punteggio);


    // --- consenso ---
    $firme_emendamento = OppCaricaHasEmendamentoPeer::getFirme($emendamento_id, $data);      
    $n_firme = array ('gruppo' => 0, 'altri' => 0, 'opp' => 0, 'mia' => 0);
    foreach ($firme_emendamento as $firma) {
      $relazione = OppCaricaPeer::getRelazioneCon($carica_id, $firma['carica_id'], $firma['data']);
      if (is_null($relazione)) continue;
      $n_firme[$relazione] += 1;
    }
    
    // TODO: aggiungere controllo se carica cambia nel tempo tra maggioranza e opposizione,
    //       in caso si decida di avere parametri del consenso differenti tra M e O
    //       ora sono uguali
    $consenso_node = $emendamento_node->addChild('consenso', null, self::$opp_ns);
    $consenso_node->addAttribute('n_firme', count($firme_emendamento));

    $d_punteggio = 0.0;
    foreach ($n_firme as $tipo => $value) {
      if (!$value) continue;
      
      if ($value <= self::$soglia_cofirme)
        $d_punteggio += $dd_punteggio = self::getPunteggio('emendamenti', "cofirme_${tipo}_lo", $in_maggioranza);
      else
        $d_punteggio += $dd_punteggio = self::getPunteggio('emendamenti', "cofirme_${tipo}_hi", $in_maggioranza);

      $firme_node = $consenso_node->addChild('firme_'.$tipo, null, self::$opp_ns);
      $firme_node->addAttribute('n_firme', $value);
      $firme_node->addAttribute('totale', $dd_punteggio);

      if ($verbose)
        printf("    firme %s (%d) %7.2f\n", $tipo, $value, $dd_punteggio);
    }
    $punteggio += $d_punteggio;

    $consenso_node->addAttribute('totale', $d_punteggio);

    if ($verbose)
      printf("  totale firme  %7.2f\n", $d_punteggio);
      
    
    // --- iter ---
    $itinera_emendamento = OppEmendamentoHasIterPeer::getItinera($emendamento_id, $data);
    $iter_node = $emendamento_node->addChild('iter', null, self::$opp_ns);

    $d_punteggio = 0.0;
    $n_passaggi = 0;
    foreach ($itinera_emendamento as $iter_emendamento) {
      $passaggio = OppEmIterPeer::getIterPerIndice($iter_emendamento['em_iter_id']);
      if (is_null($passaggio)) continue;

      $n_passaggi++;
      
      $passaggio_node = $iter_node->addChild('passaggio', null, self::$opp_ns);
      $passaggio_node->addAttribute('tipo', $passaggio);

      $d_punteggio += $dd_punteggio = self::getPunteggio('emendamenti', 
                   $passaggio, OppCaricaPeer::inMaggioranza($carica_id, $iter_emendamento['data']));

      $passaggio_node->addAttribute('totale', $dd_punteggio);
      if ($verbose)
        printf("    iter %s %7.2f\n", $passaggio, $dd_punteggio);
    }


    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  totale iter   %7.2f\n", $d_punteggio);

    
    $emendamento_node->addAttribute('totale', $punteggio);    
    
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


  
}
