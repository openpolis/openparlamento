<?php

/**
 * emendamento actions.
 *
 * @package    op_openparlamento
 * @subpackage emendamento
 * @author     Guglielmo Celata
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class emendamentoActions extends autoemendamentoActions
{
  protected function addFiltersCriteria($c)
  {
    if (isset($this->filters['titolo_is_empty']))
    {
      $criterion = $c->getNewCriterion(OppEmendamentoPeer::TITOLO, '');
      $criterion->addOr($c->getNewCriterion(OppEmendamentoPeer::TITOLO, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['titolo']) && $this->filters['titolo'] !== '')
    {
      $c->add(OppEmendamentoPeer::TITOLO, strtr($this->filters['titolo'], '*', '%'), Criteria::LIKE);
    }
  
    if (isset($this->filters['atto_filter']) && $this->filters['atto_filter'] !== '')
    {
      $c->addJoin(OppEmendamentoPeer::ID, OppAttoHasEmendamentoPeer::EMENDAMENTO_ID);
      $c->add(OppAttoHasEmendamentoPeer::ATTO_ID, $this->filters['atto_filter']);
    }
  }
  
}
