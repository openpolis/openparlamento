<?php

/**
 * Classe che mantiene i parametri dell'indice di attività
 *
 * @package lib.model
 */ 
class OppIndiceAttivitaPeer
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
                              'discusso_in_ass'     => array('m' => 1.5, 'o' =>  1.5),
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

 
  public static function getFileSystem()
  {
    if (self::$filesystem == null)
      self::$filesystem = new sfFileSystem();
      
    return self::$filesystem;
  }
  
  /**
   * calcola l'indice di attività per un politico
   *
   * @param integer $id 
   * @param date $settimana 
   * @param boolean $verbose 
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcola_indice_politico($id, $settimana = '', $verbose = '')
  {
    // fetch dell'oggetto OppCarica
    $carica = OppCaricaPeer::retrieveByPK($id);
    
    // inizializzazion xml con dettaglio computazione
    $xml_node = new SimpleXMLElement(
      '<opp xmlns="'.self::$opp_ns.'" '.
            ' xmlns:op="'.self::$op_ns.'" '.
            ' xmlns:xlink="'.self::$xlink_ns.'" >'.
      '</opp>');
      
    // self::addProcessingInstruction($xml_node, 'xml-stylesheet', 'type="text/xsl" href="dettaglio_politici.xslt"');
    $content_node = $xml_node->addChild('op:content', null, self::$op_ns);             
  
    // estrae atti ed emendamenti firmati come Primo Firmatario, fino alla fine della settimana indagata
    if ($settimana == '') {
      $atti = $carica->getPresentedAttos();
      $emendamenti = $carica->getPresentedEmendamentos();
    } else {
      $atti = $carica->getPresentedAttos(date('Y-m-d', strtotime("+1 week", strtotime($settimana))));
      $emendamenti = $carica->getPresentedEmendamentos(date('Y-m-d', strtotime("+1 week", strtotime($settimana))));
    }

    $punteggio = 0.;
  
    // --- componente dell'indice dovuta agli atti ---
    $atti_node = $content_node->addChild('atti', null, self::$opp_ns);
    $atti_node->addAttribute('n_atti', 
                             count($atti));
    
    if ($verbose)
      printf("\n  numero atti: %d\n", count($atti));
    $d_punteggio = 0.;
    foreach ($atti as $atto) {
      $d_punteggio += self::calcolaIndiceAtto($carica, $atto, $settimana, $atti_node, $verbose);
    }
    $atti_node->addAttribute('totale', $d_punteggio);
    $punteggio += $d_punteggio;

    // --- componente dell'indice dovuta agli emendamenti ---
    $emendamenti_node = $content_node->addChild('emendamenti', null, self::$opp_ns);
    $emendamenti_node->addAttribute('n_emendamenti', 
                                    count($emendamenti));
    if ($verbose)
      printf("\n  numero emendamenti: %d\n", count($emendamenti));
    $d_punteggio = 0.;
    foreach ($emendamenti as $emendamento) {
      $d_punteggio += self::calcolaIndiceEmendamento($carica, $emendamento, $settimana, $emendamenti_node, $verbose);
    }
    $emendamenti_node->addAttribute('totale', $d_punteggio);
    $punteggio += $d_punteggio;
    
    // --- componente dell'indice dovuta agli interventi (in sedute)
    $interventi_node = $content_node->addChild('interventi', null, self::$opp_ns);
    $punteggio += $d_punteggio = self::calcolaPunteggioInterventi($carica, $settimana, $interventi_node, $verbose);
    $interventi_node->addAttribute('totale', $d_punteggio);


    $content_node->addAttribute('totale', $punteggio);

    $xml_storage_path = sfConfig::get('xml-storage-path', 
                                       SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'xml');
    $politici_path = $xml_storage_path.DIRECTORY_SEPARATOR.'indici'.DIRECTORY_SEPARATOR.'politici';
    $file_path = $politici_path.DIRECTORY_SEPARATOR."$id.xml";

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
 
 
 
  /**
   * calcola l'indice accumulato fino alla fine della settimana, per un atto, presentato da una carica 
   *
   * @param OppCarica $carica
   * @param OppAtto   $atto
   * @param string    $settimana
   * @param SimpleXMLElement    $xml_node   
   * @param boolean   $verbose
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcolaIndiceAtto($carica, $atto, $settimana, $xml_node, $verbose = false)
  {
    $atto_node = $xml_node->addChild('atto', null, self::$opp_ns);
    
    // calcolo se appartiene alla maggioranza o all'opposizione
    $in_maggioranza = $carica->inMaggioranza($settimana);
    
    // determina il tipo di atto (per quello che concerne il calcolo dell'indice)
    $tipo_atto = $atto->getTipoPerIndice();
    
    if (is_null($tipo_atto)) return 0;
    
    if ($verbose)
      printf("atto: %10s %15s\n", $atto->getId(), $tipo_atto);

    $atto_node->addAttribute('tipo_atto', $tipo_atto);
    $atto_node->addAttribute('id', $atto->getId());    
    $atto_node->addChild('titolo', $atto->getTitolo(), self::$opp_ns);

    $punteggio = 0.0;
    
    // --- presentazione ---
    $d_punteggio = self::getPunteggio($tipo_atto, 'presentazione', $in_maggioranza);
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  presentazione %7.2f\n", $d_punteggio);
    $presentazione_node = $atto_node->addChild('presentazione', null, self::$opp_ns);
    $presentazione_node->addAttribute('totale', $d_punteggio);


    // --- consenso ---
    if ($settimana == '') {
      $firme_atto = $atto->getFirme(date('Y-m-d'));
    } else {
      $firme_atto = $atto->getFirme(date('Y-m-d', strtotime('+1 week', strtotime($settimana))));      
    }
    $n_firme = array ('gruppo' => 0, 'altri' => 0, 'opp' => 0, 'gov' => 0, 'mia' => 0);
    foreach ($firme_atto as $firma) {
      $relazione = $firma->getOppCarica()->getRelazioneCon($carica, $firma->getData('Y-m-d'));
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
    if ($settimana == '') {
      $itinera_atto = $atto->getItinera(date('Y-m-d'));
    } else {
      $itinera_atto = $atto->getItinera(date('Y-m-d', strtotime('+1 week', strtotime($settimana))));      
    }
    
    $iter_node = $atto_node->addChild('iter', null, self::$opp_ns);
    
    $d_punteggio = 0.0;
    $n_passaggi = 0;
    foreach ($itinera_atto as $iter_atto) {
      $passaggio = OppIterPeer::getIterPerIndice($iter_atto->getIterId());
      if (is_null($passaggio)) continue;

      $n_passaggi++;
      
      $passaggio_node = $iter_node->addChild('passaggio', null, self::$opp_ns);
      $passaggio_node->addAttribute('tipo', $passaggio);

      $carica_in_maggioranza_al_passaggio = $carica->inMaggioranza($iter_atto->getData('Y-m-d'));
      if (is_null($passaggio)) continue;
      $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, $passaggio, $carica_in_maggioranza_al_passaggio);
      if ($verbose)
        printf("    iter %s %7.2f\n", $passaggio, $dd_punteggio);
      
      $passaggio_node->addAttribute('totale', $dd_punteggio);
        
      // --- bonus maggioranza ---
      if ($passaggio == 'approvato' || $passaggio == 'approvato_camera') {
        if ($carica_in_maggioranza_al_passaggio && $atto->votatoDaOpposizione()) {
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
   * @param OppCarica $carica
   * @param OppEmendamento   $emendamento
   * @param string    $settimana
   * @param boolean   $verbose
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcolaIndiceEmendamento($carica, $emendamento, $settimana, $xml_node, $verbose = false)
  {
    $emendamento_node = $xml_node->addChild('emendamento', null, self::$opp_ns);
    $emendamento_node->addAttribute('id', $emendamento->getId());    
    $emendamento_node->addChild('titolo', Text::denominazioneEmendamento($emendamento, 'list'));
    
    // calcolo se appartiene alla maggioranza o all'opposizione
    $in_maggioranza = $carica->inMaggioranza($settimana);
    
    if ($verbose)
      printf("emendamento: %10s\n", $emendamento->getId());

    $punteggio = 0.0;
    
    // --- presentazione ---
    $d_punteggio = self::getPunteggio('emendamenti', 'presentazione', $in_maggioranza);
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  presentazione %7.2f\n", $d_punteggio);
    $presentazione_node = $emendamento_node->addChild('presentazione', null, self::$opp_ns);
    $presentazione_node->addAttribute('totale', $d_punteggio);


    // --- consenso ---
    if ($settimana == '') {
      $firme_emendamento = $emendamento->getFirme(date('Y-m-d'));
    } else {
      $firme_emendamento = $emendamento->getFirme(date('Y-m-d', strtotime('+1 week', strtotime($settimana))));      
    }
    $n_firme = array ('gruppo' => 0, 'altri' => 0, 'opp' => 0, 'mia' => 0);
    foreach ($firme_emendamento as $firma) {
      $relazione = $firma->getOppCarica()->getRelazioneCon($carica, $firma->getData('Y-m-d'));
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
    if ($settimana == '') {
      $itinera_emendamento = $emendamento->getItinera(date('Y-m-d'));
    } else {
      $itinera_emendamento = $emendamento->getItinera(date('Y-m-d', strtotime('+1 week', strtotime($settimana))));      
    }
    
    $iter_node = $emendamento_node->addChild('iter', null, self::$opp_ns);

    $d_punteggio = 0.0;
    $n_passaggi = 0;
    foreach ($itinera_emendamento as $iter_emendamento) {
      $passaggio = OppEmIterPeer::getIterPerIndice($iter_emendamento->getEmIterId());
      if (is_null($passaggio)) continue;

      $n_passaggi++;
      
      $passaggio_node = $iter_node->addChild('passaggio', null, self::$opp_ns);
      $passaggio_node->addAttribute('tipo', $passaggio);

      $d_punteggio += $dd_punteggio = self::getPunteggio('emendamenti', $passaggio, $carica->inMaggioranza($iter_emendamento->getData('Y-m-d')));

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
   * @param string $carica 
   * @param string $settimana 
   * @param SimpleXMLElement $xml_node
   * @param string $verbose 
   * @return float
   * @author Guglielmo Celata
   */
  public function calcolaPunteggioInterventi($carica, $settimana, $xml_node, $verbose = false)
  {
    // --- interventi ---
    if ($settimana == '') {
      $n_interventi = $carica->getNSeduteConInterventi(date('Y-m-d'));
    } else {
      $n_interventi = $carica->getNSeduteConInterventi(date('Y-m-d', strtotime('+1 week', strtotime($settimana))));      
    }
    
    $xml_node->addAttribute('n_sedute_con_intervento', $n_interventi);
    
    $d_punteggio = $n_interventi * self::$punteggi['intervento'];
    if ($verbose)
      printf("  interventi   %7.2f\n", $d_punteggio);

    return $d_punteggio;
  }


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
   * genera una processing instruction per includere link all'xsl nell'xml
   *
   * @param string $xml_node 
   * @param string $name 
   * @param string $value 
   * @return void
   * @author Guglielmo Celata
   */
  protected static function addProcessingInstruction( $xml_node, $name, $value )
  {
      // Create a DomElement from this simpleXML object
      $dom_sxe = dom_import_simplexml($xml_node);
     
      // Create a handle to the owner doc of this xml
      $dom_parent = $dom_sxe->ownerDocument;
     
      // Find the topmost element of the domDocument
      $xpath = new DOMXPath($dom_parent);
      $first_element = $xpath->evaluate('/*[1]')->item(0);
     
      // Add the processing instruction before the topmost element           
      $pi = $dom_parent->createProcessingInstruction($name, $value);
      $dom_parent->insertBefore($pi, $first_element);
  }
  
  
  
  
  
}
