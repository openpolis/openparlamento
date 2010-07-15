<?php

/**
 * Classe che mantiene i parametri dell'indice di rilevanza (per tag)
 *
 * @package lib.model
 */ 
class OppIndiceRilevanzaPeer extends OppIndicePeer
{


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
   * calcola l'indice di rilevanza per un atto (e produce l'xml di dettaglio)
   *
   * @param integer $atto_id
   * @param integer $tipo_atto_id 
   * @param date $data 
   * @param boolean $verbose 
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcola_rilevanza_atto($atto_id, $tipo_atto_id, $data = '', $verbose = '')
  {
    // inizializzazione xml con dettaglio computazione
    $xml_node = new SimpleXMLElement(
      '<opp xmlns="'.self::$opp_ns.'" '.
            ' xmlns:op="'.self::$op_ns.'" '.
            ' xmlns:xlink="'.self::$xlink_ns.'" >'.
      '</opp>');
      
    // self::addProcessingInstruction($xml_node, 'xml-stylesheet', 'type="text/xsl" href="../xslt/politici.xslt"');
    $content_node = $xml_node->addChild('op:content', null, self::$op_ns);             
  
    $punteggio = self::calcolaRilevanzaAtto($atto_id, $tipo_atto_id, $data, $content_node, $verbose);
  

    $content_node->addAttribute('totale', $punteggio);

    $xml_storage_path = sfConfig::get('xml-storage-path', 
                                       SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'xml');
    $atti_path = $xml_storage_path.DIRECTORY_SEPARATOR.'indici'.DIRECTORY_SEPARATOR.'atti';
    $file_path = $atti_path.DIRECTORY_SEPARATOR."$atto_id.xml";

    // scrittura xml su file system
    try
    {
      if (!file_exists($file_path))
      {
        $created = self::getFilesystem()->mkdirs($atti_path);
        if (!$created)
          throw new Exception('Impossibile creare directory ' . $atti_path);
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
   * calcola l'indice di rilevanza accumulato fino alla fine della settimana, per un atto, nel suo complesso 
   *
   * @param integer $atto_id
   * @param integer $tipo_atto_id 
   * @param date $data 
   * @param SimpleXMLElement    $xml_node   
   * @param boolean   $verbose
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcolaRilevanzaAtto($atto_id, $tipo_atto_id, $data, $xml_node, $verbose = false)
  {
    $atto_node = $xml_node->addChild('atto', null, self::$opp_ns);
    
    // calcolo gruppi e schieramenti che presentano
    list($schier_pres, $grup_pres) = OppCaricaHasAttoPeer::getSchierGrupPresAtto($atto_id, $data);

    // variabile che indica se l'atto è stato presentato dalla maggioranza
    $di_maggioranza = count($schier_pres) == 1 && $schier_pres[0] == 1;
    
    // determina il tipo di atto (per quello che concerne il calcolo dell'indice)
    $tipo_atto = OppTipoAttoPeer::getTipoPerIndice($tipo_atto_id);

    if (is_null($tipo_atto)) return 0;
    
    $atto_node->addAttribute('tipo_atto', $tipo_atto);
    $atto_node->addAttribute('id', $atto_id);    

    $punteggio = 0.0;
    
    // --- consenso ---
    $consenso_node = $atto_node->addChild('consenso', null, self::$opp_ns);
    $firmeRS = OppCaricaHasAttoPeer::getFirmeAttoDataTipoRS($atto_id, $data);

    $n_firme = array ('gruppo' => 0, 'altri' => 0, 'opp' => 0);
    while ($firmeRS->next()) {
      $row = $firmeRS->getRow();
      
      // gestione del caso in cui l'atto è presentato dai due schieramenti
      // tutte le firme sono assegnate a gruppo, altri e opp
      if (count($schier_pres) > 1)
      {
        $n_firme['gruppo'] += $row['nf'];
        $n_firme['altri'] += $row['nf'];
        $n_firme['opp'] += $row['nf'];
        continue;
      }
      
      // gestione del caso in cui l'atto è presentato da più di un gruppo
      // le firme dello schieramento di pres. sono assegnate a gruppo e altri
      if (count($grup_pres) > 1) {
        if ($row['maggioranza'] == $schier_pres[0]) {
          $n_firme['gruppo'] += $row['nf'];
          $n_firme['altri'] += $row['nf'];          
        } else {
          $n_firme['opp'] += $row['nf'];          
        }
        continue;
      }
      
      if (in_array($row['gruppo_id'], $grup_pres)) {
        if ($row['nf'] > 1) $n_firme['gruppo'] += $row['nf'];
      } else if ($row['maggioranza'] == $schier_pres[0]) {
        $n_firme['altri'] + $row['nf'];
      } else {
        $n_firme['gruppo'] + $row['nf'];        
      }
      
    }
    
    $d_punteggio = 0.0;
    foreach ($n_firme as $tipo => $value) {
      if (!$value) continue;
      
      if ($value <= self::$soglia_cofirme)
        $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, "cofirme_${tipo}_lo", $di_maggioranza);
      else
        $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, "cofirme_${tipo}_hi", $di_maggioranza);

      $firme_node = $consenso_node->addChild('firme_'.$tipo, null, self::$opp_ns);
      $firme_node->addAttribute('n_firme', $value);
      $firme_node->addAttribute('totale', $dd_punteggio);

      if ($verbose)
        printf("    firme %s (%d) %7.2f\n", $tipo, $value, $dd_punteggio);
    }
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  totale firme  %7.2f\n", $d_punteggio);
 
    $consenso_node->addAttribute('n_firme', $n_firme['gruppo'] + $n_firme['altri'] + $n_firme['opp']);
    $consenso_node->addAttribute('totale', $d_punteggio);
    
    
    // --- iter ---
    $itinera_atto_rs = OppAttoHasIterPeer::getItineraAttoDataRS($atto_id, $data);
    
    $iter_node = $atto_node->addChild('iter', null, self::$opp_ns);
    
    $d_punteggio = 0.0;
    $n_passaggi = 0;
    while ($itinera_atto_rs->next()) {
      $iter_atto = $itinera_atto_rs->getRow();
      
      $passaggio = OppIterPeer::getIterPerIndice($iter_atto['iter_id']);
      if (is_null($passaggio)) continue;

      $n_passaggi++;
      
      $passaggio_node = $iter_node->addChild('passaggio', null, self::$opp_ns);
      $passaggio_node->addAttribute('tipo', $passaggio);

      if (is_null($passaggio)) continue;
      $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, $passaggio, $di_maggioranza);
      if ($verbose)
        printf("    iter %s %7.2f\n", $passaggio, $dd_punteggio);
      
      $passaggio_node->addAttribute('totale', $dd_punteggio);
        
      // --- bonus maggioranza ---
      if ($passaggio == 'approvato' || $passaggio == 'approvato_camera') {
        if ($di_maggioranza && OppAttoPeer::isAttoVotatoDaOpposizione($atto_id, $data)) {
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
    
    // --- sedute con interventi in commissione e assemblea ---
    $sedute_con_interventi_node = $atto_node->addChild('sedute_con_interventi', null, self::$opp_ns);

    $sedute_commissioni_node = $sedute_con_interventi_node->addChild('commissioni', null, self::$opp_ns);
    $n_sedute_commissioni = OppInterventoPeer::getNSeduteConInterventiAttoData($atto_id, 'C', $data);
    if ($n_sedute_commissioni) $n_sedute_commissioni--;
    $d_punteggio_sedute_commissioni = $n_sedute_commissioni * self::getPunteggio($tipo_atto, 'discusso_in_seduta_comm', $di_maggioranza);
    $sedute_commissioni_node->addAttribute('n_sedute', $n_sedute_commissioni);
    $sedute_commissioni_node->addAttribute('totale', $d_punteggio_sedute_commissioni);
    
    $sedute_assemblea_node = $sedute_con_interventi_node->addChild('assemblea', null, self::$opp_ns);
    $n_sedute_assemblea = OppInterventoPeer::getNSeduteConInterventiAttoData($atto_id, 'A', $data);
    if ($n_sedute_assemblea) $n_sedute_assemblea--;
    $d_punteggio_sedute_assemblea = $n_sedute_assemblea * self::getPunteggio($tipo_atto, 'discusso_in_seduta_ass', $di_maggioranza);
    $sedute_assemblea_node->addAttribute('n_sedute', $n_sedute_assemblea);
    $sedute_assemblea_node->addAttribute('totale', $d_punteggio_sedute_assemblea);
    
    $punteggio += $d_punteggio_sedute = $d_punteggio_sedute_commissioni + $d_punteggio_sedute_assemblea;

    if ($verbose)
      printf("  totale sedute   %7.2f\n", $d_punteggio_sedute);

    $sedute_con_interventi_node->addAttribute('totale', $d_punteggio_sedute);
    
    $atto_node->addAttribute('totale', $punteggio);

    return $punteggio;
  }


  /**
   * calcola l'indice di rilevanza per un tag (e produce l'xml di dettaglio)
   *
   * @param integer $tag_id
   * @param date $data 
   * @param boolean $verbose 
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcola_rilevanza_tag($tag_id, $data = '', $verbose = '')
  {
    // inizializzazione xml con dettaglio computazione
    $xml_node = new SimpleXMLElement(
      '<opp xmlns="'.self::$opp_ns.'" '.
            ' xmlns:op="'.self::$op_ns.'" '.
            ' xmlns:xlink="'.self::$xlink_ns.'" >'.
      '</opp>');
      
    // self::addProcessingInstruction($xml_node, 'xml-stylesheet', 'type="text/xsl" href="../xslt/tag.xslt"');
    $content_node = $xml_node->addChild('op:content', null, self::$op_ns);             
  
    $punteggio = self::calcolaRilevanzaTag($tag_id, $data, $content_node, $verbose);
  

    $content_node->addAttribute('totale', $punteggio);

    $xml_storage_path = sfConfig::get('xml-storage-path', 
                                       SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'xml');
    $tag_path = $xml_storage_path.DIRECTORY_SEPARATOR.'indici'.DIRECTORY_SEPARATOR.'tag';
    $file_path = $tag_path.DIRECTORY_SEPARATOR."$tag_id.xml";

    // scrittura xml su file system
    try
    {
      if (!file_exists($file_path))
      {
        $created = self::getFilesystem()->mkdirs($tag_path);
        if (!$created)
          throw new Exception('Impossibile creare directory ' . $tag_path);
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
   * calcola l'indice di rilevanza accumulato fino a una certa data, per un tag
   * come somma degli indici di rilevanza di tutti gli atti taggati con quel tag 
   *
   * @param integer $tag_id
   * @param date $data 
   * @param SimpleXMLElement    $xml_node   
   * @param boolean   $verbose
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcolaRilevanzaTag($tag_id, $data, $xml_node, $verbose = false)
  {
    $tag_node = $xml_node->addChild('tag', null, self::$opp_ns);
    
    // estrazione array atti taggati a una certa data
    $atti_ids = TaggingPeer::getTaggableIdsData($tag_id, 'OppAtto', $data);
    
    if ($verbose)
      printf("tag: %10s\n", $tag_id);

    $tag_node->addAttribute('id', $tag_id);    
    $tag_node->addAttribute('n_atti', count($atti_ids));    

    $punteggio = 0.0;
    
    // --- estrazione rilevanza singoli atti ---
    foreach ($atti_ids as $cnt => $atto_id) {
      $punteggio += $d_punteggio = OppActHistoryCachePeer::getIndiceForAttoData($atto_id, $data);
      $atto_node = $tag_node->addChild('atto', null, self::$opp_ns);
      $atto_node->addAttribute('totale', $d_punteggio);
      if ($verbose)
        printf("atto: %10s totale: %7.2f\n", $atto_id, $d_punteggio);
    }
    
    $tag_node->addAttribute('totale', $punteggio);

    return $punteggio;
  }

 
  
}
