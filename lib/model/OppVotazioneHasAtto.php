<?php

/**
 * Subclass for representing a row from the 'opp_votazione_has_atto' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppVotazioneHasAtto extends BaseOppVotazioneHasAtto
{
  public $priority_override = 0;
  public $generate_group_news = true;

  /**
   * generates a group news, unless the sf_news_cache already has it
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function generateUnlessAlreadyHasGroupNews()
  {
    $seduta = $this->getOppVotazione()->getOppSeduta();
    $data = $seduta->getData();
    $ramo = $seduta->getRamo();
    $atto_id = $this->getAttoId();
    $tipo_atto_id = $this->getOppAtto()->getTipoAttoId();

    $cnt = 0;
    
    // controllo e scrittura notizie di rilevanza 1 (in un certo giorno si è votato un certo tipo di atti)
    $has_group_votation = NewsPeer::hasGroupVotation($data, $ramo, $tipo_atto_id);
    if (!$has_group_votation)
    {
      NewsPeer::addGroupVotation($data, $ramo, $tipo_atto_id);
      $cnt ++;
    }    
    
    // controllo e scrittura notizie di rilevanza 2 (in un certo giorno si è votato per un atto almeno una volta)
    $has_group_votation_on_atto = NewsPeer::hasGroupVotation($data, $ramo, $tipo_atto_id, $atto_id);
    if (!$has_group_votation_on_atto)
    {
      NewsPeer::addGroupVotation($data, $ramo, $tipo_atto_id, $atto_id);
      $cnt++;
    }
    
    return $cnt;
  }
  
  public function save($con = null)
  {
    
    if ($this->getOppVotazione()->getFinale() == 1)
    {
      $this->priority_override = 1;
    }
    return parent::save();

  }
  
}

sfPropelBehavior::add(
  'OppVotazioneHasAtto',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'date_method'        => array( 'getOppVotazione', 'getOppSeduta', 'getData'),
              'priority'           => '3',
        )));