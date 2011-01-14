<?php

/**
 * Subclass for performing query and update operations on the 'opp_alert_term' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAlertTermPeer extends BaseOppAlertTermPeer
{
  
  // mappa i tipo_atto_id in tipologie per il calcolo dell'indice di attività
  public static $type_filters = array(
    'politici'             => 'Parlamentari',
    'disegni'              => 'Disegni di legge',
    'decreti'              => 'Decreti legge',
    'decrleg'              => 'Decreti legislativi',
    'emendamenti'          => 'Emendamenti',
    'mozioni'              => 'Mozioni',
    'interpellanze'        => 'Interpellanze',
    'Interrogazioni'       => 'interrogazioni',
    'risoluzioni'          => 'Risoluzioni',
    'odg'                  => 'Ordini del giorno',
    'audizioni'            => 'Audizioni',
    'comunicazionigoverno' => 'Comunicati del Governo',
    'votazioni'            => 'Votazioni',
    'argomenti'            => 'Argomenti',
    'resoconti'            => 'Resoconti stenografici'
  );
  
  
  /**
   * prende dei filtri (chiavi), con separatore | e torna le label con separatore ' + '
   *
   * @param string $filters (disegni|decreti|decrleg)
   * @return string (Disegni di Legge + Decreti Legge + Decreti legislativi)
   * @author Guglielmo Celata
   */
  public static function get_filters_labels($filters)
  {
    $labels = array();
    foreach (explode("|", $filters) as $filter) {
      $labels []= OppAlertTermPeer::$type_filters[$filter];
    }
    return implode(" + ", $labels);    
  }
    
  
  /**
   * if a term is not in the op_alert_term table, then insert it, fetch and return it
   *
   * @param string $term 
   * @return OppAlertTerm
   * @author Guglielmo Celata
   */
  public static function fetchOrInsert($term)
  {
    $term_obj = self::retrieveByTerm($term);

    if ($term_obj == null)
      $term_obj = self::addTerm($term);
      
    return $term_obj;
  }
  
  /**
   * add a term to the op_alert_term table
   *
   * @param string $term 
   * @return void
   * @author Guglielmo Celata
   */
  public static function addTerm($term)
  {
    $term_obj = new OppAlertTerm();
    $term_obj->setTerm($term);
    $term_obj->save();
    return $term_obj;
  }
  
  public static function retrieveByTerm($term)
  {
    $c = new Criteria();
    $c->add(self::TERM, $term);
    return self::doSelectOne($c);
  }
}
