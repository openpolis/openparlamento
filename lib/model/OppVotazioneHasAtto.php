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
    $tipo_atto = $this->getOppAtto()->getOppTipoAtto()->getTipo();

    // controllo e scrittura notizie di rilevanza 1 (home)
    $has_group_votation = NewsPeer::hasGroupVotation($data, $ramo);
    if (!$has_group_votation)
    {
      NewsPeer::addGroupVotation($data, $ramo);
    }    

    // controllo e scrittura notizie di rilevanza 2 (elenchi)
    
    $has_group_votation = NewsPeer::hasGroupVotation($data, $ramo, $tipo_atto);
    if (!$has_group_votation)
    {
      NewsPeer::addGroupVotation($data, $ramo, $tipo_atto);
    }    
    
    
    // controllo e scrittura notizie di rilevanza 3 (foglia)
    $has_group_votation_on_atto = NewsPeer::hasGroupVotation($data, $ramo, $tipo_atto, $atto_id);
    if (!$has_group_votation_on_atto)
    {
      NewsPeer::addGroupVotation($data, $ramo, $tipo_atto, $atto_id);
    }
  }
  
  public function save($con = null)
  {
    
    if ($this->getOppVotazione()->getFinale() == 1)
    {
      $this->priority_override = 1;
    }
    parent::save();

  }
  
}

sfPropelBehavior::add(
  'OppVotazioneHasAtto',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto'),
              'date_method'        => array( 'getOppVotazione', 'getOppSeduta', 'getData'),
              'priority'           => '3',
        )));