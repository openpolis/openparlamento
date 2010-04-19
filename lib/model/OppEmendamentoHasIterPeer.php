<?php

/**
 * Subclass for performing query and update operations on the 'opp_emendamento_has_iter' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppEmendamentoHasIterPeer extends BaseOppEmendamentoHasIterPeer
{

  public static function getItinera($emendamento_id, $data)
  {
    $c = new Criteria();
    $c->add(self::EMENDAMENTO_ID, $emendamento_id);
    $c->add(self::DATA, $data, Criteria::LESS_THAN);
    $c->addGroupByColumn(self::EMENDAMENTO_ID);
    $c->addGroupByColumn(self::EM_ITER_ID);    
    
    return self::doSelectJoinOppIter($c);
  }
  
}
