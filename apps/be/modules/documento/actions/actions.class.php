<?php

/**
 * documento actions.
 *
 * @package    op_openparlamento
 * @subpackage documento
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class documentoActions extends autodocumentoActions
{
  protected function addFiltersCriteria($c)
  {
    if (isset($this->filters['titolo_is_empty']))
    {
      $criterion = $c->getNewCriterion(OppDocumentoPeer::TITOLO, '');
      $criterion->addOr($c->getNewCriterion(OppDocumentoPeer::TITOLO, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['titolo']) && $this->filters['titolo'] !== '')
    {
      $c->add(OppDocumentoPeer::TITOLO, strtr($this->filters['titolo'], '*', '%'), Criteria::LIKE);
    }
  
    if (isset($this->filters['atto_filter']) && $this->filters['atto_filter'] !== '')
    {
      $c->add(OppDocumentoPeer::ATTO_ID, $this->filters['atto_filter']);
    }
  }
  
}
