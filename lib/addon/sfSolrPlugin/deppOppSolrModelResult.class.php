<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Override the sfSolrResult class for the Opp site
 * adding the getInternalAlertPartial() method
 * @package    sfSolrPlugin
 * @subpackage Results
 * @author     Guglielmo Celata <g.celata@depp.it>
 */
class deppOppSolrModelResult extends sfSolrModelResult
{
  
  /**
  * Factory.  Gets an instance of the appropriate result based off type
  */
  static public function getInstance($result, $search, $maxScore)
  {
    switch ($result->sfl_type)
    {
      case 'action':
        $c = 'deppOppSolrActionResult';
        break;
      case 'model':
        $c = 'deppOppSolrModelResult';
        break;
      default:
        $c = __CLASS__;
    }
    
    $r = new $c($result, $search);
    $r->setMaxScore($maxScore);
    
    return $r;
  }
  
  public function getInternalAlertPartial()
  {
    $model = $this->retrieveModel();
    
    if (isset($model['alertPartial']))
    {
      return $model['alertPartial'];
    }

    return 'sfSolr/' . $this->getInternalType() . 'Alert';
  }
}