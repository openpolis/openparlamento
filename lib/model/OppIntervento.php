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
  public $generate_group_news = true;
  
  public function save($con = null)
  {
    if ($this->isNew())
      $updateInterventi = true;

    $affected_rows = parent::save($con);

    if ($updateInterventi)
    {
      $atto = $this->getOppAtto();
      $atto->setNInterventi($atto->countOppInterventos());
      $atto->save();
    }

    return $affected_rows;
  }
  
  public function delete($con = null)
  {
    $atto = $this->getOppAtto();
    
    parent::delete($con);
    
    $atto->setNInterventi($atto->countOppInterventos());
    $atto->save();
  }
  
  /**
   * generates a group news, unless the sf_news_cache already has it
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function generateUnlessAlreadyHasGroupNews()
  {
    $data = $this->getData();
    $sede_id = $this->getSedeId();
    $tipo_atto_id = $this->getOppAtto()->getTipoAttoId();
    $atto_id = $this->getAttoId();
    $politico_id = $this->getOppCarica()->getPoliticoId();
    $cnt = 0;
    
    // controllo e scrittura notizie di rilevanza 1 (in un certo giorno c'è stato un intervento su un certo atto)
    $has_group_intervention = NewsPeer::hasGroupIntervention($data, $sede_id, $tipo_atto_id, $atto_id);
    if (!$has_group_intervention)
    {
      NewsPeer::addGroupIntervention($data, $sede_id, $tipo_atto_id, $atto_id);
      $cnt++;
    }
    return $cnt;
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