<?php

/**
 * storia_politico actions.
 *
 * @package    op_openparlamento
 * @subpackage storia_politico
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class storia_politicoActions extends autostoria_politicoActions
{
  public function addFiltersCriteria($c)
  {
    if (isset($this->filters['rami']))
    {
      $rami = $this->filters['rami'];
      if (count($rami))
      {
        foreach ($rami as $ramo)
        {
          switch ($ramo)
          {
            case 'C':
              $crit = $c->getNewCriterion(OppPoliticianHistoryCachePeer::RAMO, 'C');
              break;
            case 'S':
              $crit = $c->getNewCriterion(OppPoliticianHistoryCachePeer::RAMO, 'S');
              break;
            case 'G':
              $crit = $c->getNewCriterion(OppPoliticianHistoryCachePeer::RAMO, 'G');
              break;
          }
        }
        if (isset($crit)) $c->add($crit);
      }
    }
    
    if (isset($this->filters['rami_is_empty']))
    {
      $ramiIsEmpty = $this->filters['rami_is_empty'];
      unset($this->filters['rami_is_empty']);
    }
    if (isset($this->filters['rami']))
    {
      $statuses = $this->filters['rami'];
      unset($this->filters['rami']);
    }

    // Call the base class implementation to get the other filters
    $result = parent::addFiltersCriteria($c);

    // Restore the statuses filter
    if (isset($ramiIsEmpty))
    {
      $this->filters['rami_is_empty'] = $ramiIsEmpty;
    }
    if (isset($rami))
    {
      $this->filters['rami'] = $rami;
    }
    
  } 
  
}
