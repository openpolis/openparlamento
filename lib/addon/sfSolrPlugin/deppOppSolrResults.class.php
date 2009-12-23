<?php
/*
 * This file extends the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Extends the sfSolrResults class, returning the correct deppOppSolrResult instance
 *
 *
 * @package    sfSolrPlugin extension
 * @subpackage Results
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class deppOppSolrResults extends sfSolrResults
{
  /**
  * Gets a result instance for the result.
  */
  protected function getInstance($result)
  {
    return deppOppSolrModelResult::getInstance($result, $this->search, $this->getMaxScore());
  }
  
}