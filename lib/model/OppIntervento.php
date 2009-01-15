<?php

/**
 * Subclass for representing a row from the 'opp_intervento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppIntervento extends BaseOppIntervento
{
  
  /**
   * generates a group news, unless the sf_news_cache already has it
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function generateUnlessAlreadyHasGroupNews()
  {
    // controllo se esistono notizie di raggruppamenti
    $data = $this->getData();
    $sede_id = $this->getSedeId();
    $tipo_atto = $this->getOppAtto()->getOppTipoAtto()->getTipo();
    $atto_id = $this->getAttoId();
    $politico_id = $this->getOppCarica()->getPoliticoId();

    $has_group_intervention = NewsPeer::hasGroupIntervention($data, $sede_id);
    if (!$has_group_intervention)
    {
      NewsPeer::addGroupIntervention($data, $sede_id);
    }    

    $has_group_intervention_on_type_of_atto = NewsPeer::hasGroupIntervention($data, $sede_id, 'Atto', $tipo_atto);
    if (!$has_group_intervention_on_type_of_atto)
    {
      NewsPeer::addGroupIntervention($data, $sede_id, 'Atto', $tipo_atto);
    }
    
    $has_group_intervention_on_atto = NewsPeer::hasGroupIntervention($data, $sede_id, 'Atto', $tipo_atto, $atto_id);
    if (!$has_group_intervention_on_atto)
    {
      NewsPeer::addGroupIntervention($data, $sede_id, 'Atto', $tipo_atto, $atto_id);
    }

    $has_group_intervention_of_politico = NewsPeer::hasGroupIntervention($data, $sede_id, 'Politico', null, $politico_id);
    if (!$has_group_intervention_of_politico)
    {
      NewsPeer::addGroupIntervention($data, $sede_id, 'Politico', null, $politico_id);
    }
  }
  
}

sfPropelBehavior::add(
  'OppIntervento',
  array('deppPropelActAsNewsGeneratorBehavior' =>
        array('monitorable_models' => array( 'OppAtto' => 'getOppAtto', 
                                             'OppPolitico' => array('getOppCarica', 'getOppPolitico')),
              'date_method'        => 'Data',
              'priority'           => '3',
        )));