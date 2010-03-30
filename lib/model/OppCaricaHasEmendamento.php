<?php

/**
 * Subclass for representing a row from the 'opp_carica_has_emendamento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppCaricaHasEmendamento extends BaseOppCaricaHasEmendamento
{
  
  public $generate_only_group_news = true;
  
  /**
   * generates a group news, unless the sf_news_cache already has it
   *
   * @return return 1 if the news was created, 0 otherwise
   * @author Guglielmo Celata
   **/
  public function generateUnlessAlreadyHasGroupNews()
  {
    $data = $this->getData();
    $politico_id = $this->getOppCarica()->getPoliticoId();
    $cnt = 0;
    
    // controllo e scrittura notizie di rilevanza 1 (in un certo giorno c'è stato un intervento su un certo atto)
    $has_group= oppNewsPeer::hasGroupEmendamento($data, 'OppPolitico', $politico_id);
    if (!$has_group)
    {
      oppNewsPeer::addGroupEmendamento($data, 'OppPolitico', $politico_id);
      $cnt++;
    }
    return $cnt;
  }
  
}

/**
 * a new record in opp_carica_has_emendamento (new signature), 
 * generates news related to the OppAtto the emendamento relates to,
 * to the OppPolitico that has signed the emendamento, and 
 * to all the Tags the emendamento is tagged with
 **/
 
// #382 only generates grouped news
/* 
commented (temporarily, to allow clean import of emendamenti)
sfPropelBehavior::add(
  'OppCaricaHasEmendamento',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array())));
*/