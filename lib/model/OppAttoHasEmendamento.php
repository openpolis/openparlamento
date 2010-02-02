<?php

/**
 * Subclass for representing a row from the 'opp_atto_has_emendamento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAttoHasEmendamento extends BaseOppAttoHasEmendamento
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
    $data = $this->getOppEmendamento()->getDataPres();
    $atto_id = $this->getAttoId();
    $cnt = 0;
    
    // controllo e scrittura notizie di rilevanza 1 
    // (in un certo giorno sono stati presentati emendamenti su un certo atto)
    $has_group = oppNewsPeer::hasGroupEmendamento($data, 'OppAtto', $atto_id);
    if (!$has_group)
    {
      oppNewsPeer::addGroupEmendamento($data, 'OppAtto', $atto_id);
      $cnt++;
    }
    return $cnt;
  }
  
}

/* 
removed (#379)
restored (#382)
*/
sfPropelBehavior::add(
  'OppAttoHasEmendamento',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'date_method'        => array( 'getOppEmendamento', 'getDataPres'),
              'priority'           => '3' )));
