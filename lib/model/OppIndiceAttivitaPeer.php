<?php

/**
 * Classe che mantiene i parametri dell'indice di attività
 *
 * @package lib.model
 */ 
class OppIndiceAttivitaPeer
{

  public static $soglia_cofirme = 10;
  
  public static $punteggi = array(
     'ddl'           => array('presentazione'       => array('m' => 6.0, 'o' =>  6.0),
                              'cofirme_gruppo_lo'   => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_gruppo_hi'   => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_altri_lo'    => array('m' => 0.5, 'o' =>  0.5),
                              'cofirme_altri_hi'    => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_lo'      => array('m' => 1.0, 'o' =>  1.0),
                              'cofirme_opp_hi'      => array('m' => 2.0, 'o' =>  2.0),
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

   'emendamenti'    => array('presentazione'       => array('m' => 0.1, 'o' =>  0.1),
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
 
  /**
   * calcola l'indice accumulato fino alla fine della settimana, per un atto, presentato da una carica 
   *
   * @param OppCarica $carica
   * @param OppAtto   $atto
   * @param string    $settimana
   * @param boolean   $verbose
   * @return float
   * @author Guglielmo Celata
   */
  public static function calcolaIndiceAtto($carica, $atto, $settimana, $verbose = false)
  {
    // calcolo se appartiene alla maggioranza o all'opposizione
    $in_maggioranza = $carica->inMaggioranza($settimana);
    
    // determina il tipo di atto (per quello che concerne il calcolo dell'indice)
    $tipo_atto = $atto->getTipoPerIndice();
    
    if (is_null($tipo_atto)) return 0;
    
    if ($verbose)
      printf("atto: %10s %15s\n", $atto->getId(), $tipo_atto);

    $punteggio = 0.0;
    
    // --- presentazione ---
    $d_punteggio = self::getPunteggio($tipo_atto, 'presentazione', $in_maggioranza);
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  presentazione %7.2f\n", $d_punteggio);


    // --- consenso ---
    if ($settimana == '') {
      $firme_atto = $atto->getFirme(date('Y-m-d'));
    } else {
      $firme_atto = $atto->getFirme(date('Y-m-d', strtotime('+1 week', strtotime($settimana))));      
    }
    $n_firme = array ('gruppo' => 0, 'altri' => 0, 'opp' => 0);
    foreach ($firme_atto as $firma) {
      $relazione = $firma->getOppCarica()->getRelazioneCon($carica, $firma->getData('Y-m-d'));
      if ($relazione == 'me' || is_null($relazione)) continue;
      $n_firme[$relazione] += 1;
    }
    
    // TODO: aggiungere controllo se carica cambia nel tempo tra maggioranza e opposizione,
    //       in caso si decida di avere parametri del consenso differenti tra M e O
    //       ora sono uguali
    $d_punteggio = 0.0;
    foreach ($n_firme as $tipo => $value) {
      if (!$value) continue;
      
      if ($value <= self::$soglia_cofirme)
        $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, "cofirme_${tipo}_lo", $in_maggioranza);
      else
        $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, "cofirme_${tipo}_hi", $in_maggioranza);

      if ($verbose)
        printf("    firme %s (%d) %7.2f\n", $tipo, $value, $dd_punteggio);
    }
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  totale firme  %7.2f\n", $d_punteggio);
      
    
    // --- iter ---
    if ($settimana == '') {
      $itinera_atto = $atto->getItinera(date('Y-m-d'));
    } else {
      $itinera_atto = $atto->getItinera(date('Y-m-d', strtotime('+1 week', strtotime($settimana))));      
    }
    
    $d_punteggio = 0.0;
    foreach ($itinera_atto as $iter_atto) {
      $passaggio = OppIterPeer::getIterPerIndice($iter_atto->getIterId());
      $carica_in_maggioranza_al_passaggio = $carica->inMaggioranza($iter_atto->getData('Y-m-d'));
      if (is_null($passaggio)) continue;
      $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_atto, $passaggio, $carica_in_maggioranza_al_passaggio);
      if ($verbose)
        printf("    iter %s %7.2f\n", $passaggio, $dd_punteggio);
        
      // --- bonus maggioranza ---
      if ($passaggio == 'approvato' || $passaggio == 'approvato_camera') {
        if ($carica_in_maggioranza_al_passaggio && $atto->votatoDaOpposizione()) {
          $d_punteggio += self::getPunteggio($tipo_atto, 'bonus_bi_partisan', true);
          if ($verbose)
            printf("    bonus di maggioranza! %7.2f\n", $d_punteggio);          
        }
      }
    }
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  totale iter   %7.2f\n", $d_punteggio);

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
  public static function calcolaIndiceEmendamento($carica, $emendamento, $settimana, $verbose = false)
  {
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


    // --- consenso ---
    if ($settimana == '') {
      $firme_emendamento = $emendamento->getFirme(date('Y-m-d'));
    } else {
      $firme_emendamento = $emendamento->getFirme(date('Y-m-d', strtotime('+1 week', strtotime($settimana))));      
    }
    $n_firme = array ('gruppo' => 0, 'altri' => 0, 'opp' => 0);
    foreach ($firme_emendamento as $firma) {
      $relazione = $firma->getOppCarica()->getRelazioneCon($carica, $firma->getData('Y-m-d'));
      if ($relazione == 'me' || is_null($relazione)) continue;
      $n_firme[$relazione] += 1;
    }
    
    // TODO: aggiungere controllo se carica cambia nel tempo tra maggioranza e opposizione,
    //       in caso si decida di avere parametri del consenso differenti tra M e O
    //       ora sono uguali
    $d_punteggio = 0.0;
    foreach ($n_firme as $tipo => $value) {
      if (!$value) continue;
      
      if ($value <= self::$soglia_cofirme)
        $d_punteggio += $dd_punteggio = self::getPunteggio('emendamenti', "cofirme_${tipo}_lo", $in_maggioranza);
      else
        $d_punteggio += $dd_punteggio = self::getPunteggio('emendamenti', "cofirme_${tipo}_hi", $in_maggioranza);

      if ($verbose)
        printf("    firme %s (%d) %7.2f\n", $tipo, $value, $dd_punteggio);
    }
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  totale firme  %7.2f\n", $d_punteggio);
      
    
    // --- iter ---
    if ($settimana == '') {
      $itinera_emendamento = $emendamento->getItinera(date('Y-m-d'));
    } else {
      $itinera_emendamento = $emendamento->getItinera(date('Y-m-d', strtotime('+1 week', strtotime($settimana))));      
    }
    
    $d_punteggio = 0.0;
    foreach ($itinera_emendamento as $iter_emendamento) {
      $passaggio = OppEmIterPeer::getIterPerIndice($iter_emendamento->getEmIterId());
      if (is_null($passaggio)) continue;
      $d_punteggio += $dd_punteggio = self::getPunteggio($tipo_emendamento, $passaggio, $carica->inMaggioranza($iter_emendamento->getData('Y-m-d')));
      if ($verbose)
        printf("    iter %s %7.2f\n", $passaggio, $dd_punteggio);
    }
    $punteggio += $d_punteggio;
    if ($verbose)
      printf("  totale iter   %7.2f\n", $d_punteggio);

    
    return $punteggio;
  }
  

  /**
   * torna la componente dell'indice, che riguarda il parlamentare
   *
   * @param string $carica 
   * @param string $settimana 
   * @param string $verbose 
   * @return float
   * @author Guglielmo Celata
   */
  public function calcolaPunteggioInterventi($carica, $settimana, $verbose = false)
  {
    // --- interventi ---
    if ($settimana == '') {
      $n_interventi = $carica->getNSeduteConInterventi(date('Y-m-d'));
    } else {
      $n_interventi = $carica->getNSeduteConInterventi(date('Y-m-d', strtotime('+1 week', strtotime($settimana))));      
    }
    
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
    return self::$punteggi[$tipo_atto][$tipo_azione][$maggioranza?'m':'o'];
  }
  
  
  
  
}
